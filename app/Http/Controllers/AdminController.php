<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Compra;
use App\Models\Drink;
use App\Models\Categoria;
use App\Models\CategoriaDrink;
use App\Models\Ingrediente;
use App\Models\Instrumento;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function panel() {
        $desde24    = Carbon::now()->subDay();
        $usuarios24 = Usuario::where('created_at', '>=', $desde24)->count();
        $pedidos24  = Compra::where('created_at', '>=', $desde24)->count();
        $ingresos24 = Compra::where('created_at', '>=', $desde24)->sum('total');

        $totalUsuarios = Usuario::count();
        $totalPedidos  = Compra::count();
        $totalIngresos = Compra::sum('total');

        $usuariosAll = Usuario::orderBy('created_at', 'desc')->paginate(10)->fragment('tab-users');
        $comprasAll    = Compra::orderBy('created_at', 'desc')->paginate(10)->fragment('tab-compras');
        $productosAll  = Producto::orderBy('nombre', 'asc')->paginate(10)->fragment('tab-productos');
        $drinksAll = Drink::with(['tipoCoctel', 'baseSabor', 'tiempoPreparacion'])->orderBy('nombre')->paginate(10)->fragment('tab-drinks');
        return view('admin.panel', compact(
            'usuarios24','pedidos24','ingresos24',
            'totalUsuarios','totalPedidos','totalIngresos',
            'usuariosAll','comprasAll','productosAll','drinksAll'
        ));
    }

    public function makeAdmin($id)
    {
        $u = Usuario::findOrFail($id);
        $u->rol = 'admin';
        $u->save();
        return back();
    }

    public function deleteUser($id)
    {
        $u = Usuario::findOrFail($id);
        $u->delete();
        return back();
    }

    public function downloadInvoice($id)
    {
        $compra = Compra::with('productos')->findOrFail($id);

        $usuarioSesion = session('usuario');
        $esAdmin       = session()->has('admin');
        if ($compra->usuario_user !== $usuarioSesion && ! $esAdmin) {
            abort(403);
        }

        $usuario = Usuario::withTrashed()
            ->where('usuario_user', $compra->usuario_user)
            ->firstOrFail();

        $items = $compra->productos->map(function($p){
            return [
                'nombre'   => $p->nombre,
                'cantidad' => $p->pivot->cantidad,
                'precio'   => $p->pivot->precio_unitario,
            ];
        })->toArray();

        $pdf = \PDF::loadView('factura', compact('compra','usuario','items'));
        return $pdf->stream("factura_{$compra->id}.pdf");
    }

    public function deleteCompra($id)
    {
        DB::transaction(function() use ($id) {
            $compra = Compra::with('productos')->findOrFail($id);

            foreach ($compra->productos as $producto) {
                $producto->increment('stock', $producto->pivot->cantidad);
            }

            $compra->productos()->detach();

            $compra->delete();
        });

        return back();
    }

    public function createCompra()
    {
        $usuarios  = Usuario::orderBy('nombre')->get();
        $productos = Producto::orderBy('nombre')->get();

        return view('admin.crear_compra', compact('usuarios','productos'));
    }

    public function registrarCompraAdmin(Request $request)
    {
        $data = $request->validate([
            'usuario_user'               => 'required|exists:usuarios,usuario_user',
            'fecha'                      => 'required|date',
            'envio'                      => 'required|numeric|min:0',
            'email'                      => 'required|email',
            'telefono'                   => 'required|string|max:20',
            'calle'                      => 'required|string|max:100',
            'numero'                     => 'required|string|max:20',
            'ciudad'                     => 'required|string|max:100',
            'cp'                         => 'required|string|max:100',
            'pais'                       => 'required|string|max:100',
            'productos'                  => 'required|array|min:1',
            'productos.*.producto_id'    => 'required|exists:productos,id',
            'productos.*.cantidad'       => 'required|integer|min:1',
            'productos.*.precio_unitario'=> 'required|numeric|min:0',
        ]);

        $subtotal = collect($data['productos'])->sum(function($item) {
            return $item['cantidad'] * $item['precio_unitario'];
        });
        $total = $subtotal + $data['envio'];

        DB::transaction(function() use ($data, $total) {
            $compra = Compra::create([
                'usuario_user' => $data['usuario_user'],
                'fecha'        => $data['fecha'],
                'total'        => $total,
                'envio'        => $data['envio'],
                'email'        => $data['email'],
                'telefono'     => $data['telefono'],
                'calle'        => $data['calle'],
                'numero'       => $data['numero'],
                'ciudad'       => $data['ciudad'],
                'cp'           => $data['cp'],
                'pais'         => $data['pais'],
            ]);

            foreach ($data['productos'] as $item) {
                // pivote
                $compra->productos()->attach($item['producto_id'], [
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                ]);

                Producto::where('id', $item['producto_id'])
                    ->decrement('stock', $item['cantidad']);
            }
        });

        return redirect()
            ->route('panel')
            ->with('success', 'Compra registrada correctamente.');
    }

    public function deleteProducto($id)
    {
        $p = Producto::findOrFail($id);
        $p->delete();
        return back();
    }

    public function createProducto()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.crear_producto', compact('categorias'));
    }

    public function registrarProductoAdmin(Request $request)
    {
        // 1) Validar inputs
        $data = $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'required|string|max:255',
            'texto'         => 'required|string',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'categorias'    => 'required|array|min:1',
            'categorias.*'  => 'required|exists:categorias,id',
            'imagenes'      => 'required|array|min:1|max:3',
            'imagenes.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2) Determinar carpeta: slug del nombre
        $folder = Str::slug($data['nombre']) ?: 'anadidos';
        $basePath = "public/image/tienda/productos/{$folder}";
        // Crear carpeta si no existe
        if (! Storage::exists($basePath)) {
            Storage::makeDirectory($basePath);
        }

        DB::transaction(function() use ($data, $basePath, $folder) {
            // 3) Guardar primera imagen en campo 'imagen' de producto
            $imagenPrincipal = null;
            if (! empty($data['imagenes'][0])) {
                $file     = $data['imagenes'][0];
                $filename = Str::random(8) . '_' . $file->getClientOriginalName();
                $file->storeAs("image/tienda/productos/{$folder}", $filename, 'public');
                $imagenPrincipal = "image/tienda/productos/{$folder}/{$filename}";
            }

            // 4) Crear el registro de Producto
            $producto = Producto::create([
                'nombre'      => $data['nombre'],
                'descripcion' => $data['descripcion'],
                'texto'       => $data['texto'],
                'precio'      => $data['precio'],
                'stock'       => $data['stock'],
                'imagen'      => $imagenPrincipal,
            ]);

            // 5) Guardar las demás imágenes en imagenes_productos
            foreach ($data['imagenes'] as $i => $file) {
                if ($i === 0 || $file === null) {
                    continue;
                }
                $filename = Str::random(8) . '_' . $file->getClientOriginalName();
                $file->storeAs("image/tienda/productos/{$folder}", $filename, 'public');
                DB::table('imagenes_productos')->insert([
                    'producto_id'    => $producto->id,
                    'ruta'    => "image/tienda/productos/{$folder}/{$filename}",
                ]);
            }

            // 6) Asociar categorías (tabla pivote categoria_producto)
            $producto->categorias()->attach($data['categorias']);
        });

        return redirect()
            ->route('panel');
    }

    public function editarProducto($id)
    {
        $producto = Producto::with('categorias')->findOrFail($id);

        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.editar_producto', compact('producto', 'categorias'));
    }

    public function updateProducto(Request $request, $id)
    {
        // 1) Validar inputs
        $data = $request->validate([
            'nombre'        => 'required|string|max:255',
            'descripcion'   => 'required|string|max:255',
            'texto'         => 'required|string',
            'precio'        => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'categorias'    => 'required|array|min:1',
            'categorias.*'  => 'required|exists:categorias,id',
            'imagenes.0'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagenes.1'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'imagenes.2'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 2) Cargar el producto
        $producto = Producto::findOrFail($id);

        // 3) Determinar carpeta (usa slug del nombre nuevo o del existente)
        $folder = Str::slug($data['nombre']) ?: Str::slug($producto->nombre) ?: 'anadidos';
        $basePath = "public/image/tienda/productos/{$folder}";
        if (! Storage::exists($basePath)) {
            Storage::makeDirectory($basePath);
        }

        DB::transaction(function() use ($data, $producto, $folder, $basePath) {
            // 4) Imagen principal (si se sube una nueva)
            if (isset($data['imagenes'][0])) {
                $file     = $data['imagenes'][0];
                $filename = Str::random(8) . '_' . $file->getClientOriginalName();
                $file->storeAs("image/tienda/productos/{$folder}", $filename, 'public');
                $producto->imagen = "image/tienda/productos/{$folder}/{$filename}";
            }

            // 5) Actualizar campos básicos
            $producto->nombre      = $data['nombre'];
            $producto->descripcion = $data['descripcion'];
            $producto->texto       = $data['texto'];
            $producto->precio      = $data['precio'];
            $producto->stock       = $data['stock'];
            $producto->save();

            // 6) Imágenes secundarias (índices 1 y 2)
            foreach ([1,2] as $i) {
                if (isset($data['imagenes'][$i])) {
                    $file     = $data['imagenes'][$i];
                    $filename = Str::random(8) . '_' . $file->getClientOriginalName();
                    $file->storeAs("image/tienda/productos/{$folder}", $filename, 'public');
                    DB::table('imagenes_productos')->insert([
                        'producto_id' => $producto->id,
                        'ruta'        => "image/tienda/productos/{$folder}/{$filename}",
                    ]);
                }
            }

            // 7) Sincronizar categorías
            $producto->categorias()->sync($data['categorias']);
        });

        return redirect()
            ->route('panel')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function createDrink() {
        // Trae las categorías de tipo de cóctel
        $tipos = CategoriaDrink::where('tipo', 'tipo_coctel')
            ->orderBy('nombre')
            ->get();

        // Trae las categorías de base de sabor
        $bases = CategoriaDrink::where('tipo', 'base_sabor')
            ->orderBy('nombre')
            ->get();

        // Trae las categorías de tiempo de preparación
        $tiempos = CategoriaDrink::where('tipo', 'tiempo_preparacion')
            ->orderBy('nombre')
            ->get();

        // Trae todos los ingredientes existentes
        $ingredientes = Ingrediente::orderBy('nombre')->get();

        $instrumentos = Instrumento::orderBy('nombre')->get();

        // Trae todos los productos para vincularlos al drink
        $productos = Producto::orderBy('nombre')->get();

        // Devuelve la vista con todos los datos necesarios
        return view('admin.crear_drink', compact(
            'tipos',
            'bases',
            'tiempos',
            'ingredientes',
            'productos',
            'instrumentos'
        ));
    }

    public function registrarDrink(Request $request)
    {
        // 1) Validación
        $data = $request->validate([
            'nombre'                   => 'required|string|max:255',
            'imagen'                   => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'descripcion'              => 'required|string|max:255',
            'texto'                    => 'required|string',
            'pasos'                    => 'required|string',
            'producto_id'              => 'required|exists:productos,id',
            'tipo_coctel_id'           => 'required|exists:categoria_drinks,id',
            'base_sabor_id'            => 'required|exists:categoria_drinks,id',
            'tiempo_preparacion_id'    => 'required|exists:categoria_drinks,id',
            'imagenes'                 => 'required|array|min:4',
            'imagenes.*'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'ingredientes'             => 'required|array|min:1',
            'ingredientes.*.nombre'    => 'required|string|max:255',
            'ingredientes.*.cantidad'  => 'required|string|max:50',
            'instrumentos'             => 'required|array|min:1',
            'instrumentos.*.nombre'    => 'required|string|max:255',
        ]);

        // 2) Carpeta basada en slug del nombre
        $folder   = Str::slug($data['nombre']) ?: 'anadidos';
        $basePath = "public/image/absolut-drinks/{$folder}";
        if (! Storage::disk('public')->exists($basePath)) {
            Storage::disk('public')->makeDirectory($basePath);
        }

        // 3) Transacción
        DB::transaction(function() use ($request, $data, $folder) {
            // 3a) Imagen principal
            $file       = $request->file('imagen');
            $filename   = Str::random(8) . '_' . $file->getClientOriginalName();
            $file->storeAs("image/absolut-drinks/{$folder}", $filename, 'public');
            $imagenPath = "image/absolut-drinks/{$folder}/{$filename}";

            // 3b) Crear el Drink
            $drink = Drink::create([
                'nombre'                  => $data['nombre'],
                'imagen'                  => $imagenPath,
                'descripcion'             => $data['descripcion'],
                'texto'                   => $data['texto'],
                'pasos'                   => $data['pasos'],
                'producto_id'             => $data['producto_id'],
                'tipo_coctel_id'          => $data['tipo_coctel_id'],
                'base_sabor_id'           => $data['base_sabor_id'],
                'tiempo_preparacion_id'   => $data['tiempo_preparacion_id'],
            ]);

            // 3c) Imágenes adicionales
            foreach ($request->file('imagenes') as $file) {
                if (! $file) continue;
                $fname = Str::random(8) . '_' . $file->getClientOriginalName();
                $file->storeAs("image/absolut-drinks/{$folder}", $fname, 'public');
                DB::table('drinks_imagenes')->insert([
                    'drink_id' => $drink->id,
                    'ruta'     => "image/absolut-drinks/{$folder}/{$fname}",
                ]);
            }

            // 3d) Ingredientes (crear si no existen)
            foreach ($data['ingredientes'] as $item) {
                $ing = Ingrediente::firstOrCreate(
                    ['nombre' => $item['nombre']]
                );
                $drink->ingredientesPivot()->attach(
                    $ing->id,
                    ['cantidad' => $item['cantidad']]
                );
            }

            // 4) Instrumentos
            foreach ($data['instrumentos'] as $itm) {
                // crea si no existe
                $inst = Instrumento::firstOrCreate([
                    'nombre' => $itm['nombre']
                ]);
                // asocia al drink
                $drink->instrumentos()->attach($inst->id);
            }
        });


        return redirect()->route('panel');
    }

    public function deleteDrink($id)
    {
        DB::transaction(function() use ($id) {
            $drink = Drink::with([
                'instrumentos',
                'ingredientes',
                'imagenes',
                'reseñas'
            ])->findOrFail($id);

            // 1) Desvincular pivotes many-to-many
            $drink->instrumentos()->detach();
            $drink->ingredientes()->detach();

            // 2) Borrar los hasMany asociados
            $drink->imagenes()->delete();
            $drink->reseñas()->delete();

            // 3) Borrar el propio drink
            $drink->delete();
        });

        return back()->with('success', 'Drink eliminado correctamente.');
    }

    public function editDrink($id)
    {
        $drink = Drink::with(['ingredientes','instrumentos','imagenes'])
            ->findOrFail($id);

        $tipos        = CategoriaDrink::where('tipo','tipo_coctel')->get();
        $bases        = CategoriaDrink::where('tipo','base_sabor')->get();
        $tiempos      = CategoriaDrink::where('tipo','tiempo_preparacion')->get();
        $ingredientes = Ingrediente::orderBy('nombre')->get();
        $instrumentos = Instrumento::orderBy('nombre')->get();
        $productos    = Producto::orderBy('nombre')->get();

        return view('admin.edit_drink', compact(
            'drink','tipos','bases','tiempos',
            'ingredientes','instrumentos','productos'
        ));
    }

    public function updateDrink(Request $request, $id)
    {
        // 1) Validación
        $data = $request->validate([
            'nombre'                   => 'required|string|max:255',
            'imagen'                   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'descripcion'              => 'required|string',
            'texto'                    => 'required|string',
            'pasos'                    => 'required|string',
            'producto_id'              => 'required|exists:productos,id',
            'tipo_coctel_id'           => 'required|exists:categoria_drinks,id',
            'base_sabor_id'            => 'required|exists:categoria_drinks,id',
            'tiempo_preparacion_id'    => 'required|exists:categoria_drinks,id',
            'imagenes'                 => 'nullable|array|min:4',
            'imagenes.*'               => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'ingredientes'             => 'required|array|min:1',
            'ingredientes.*.nombre'    => 'required|string|max:255',
            'ingredientes.*.cantidad'  => 'required|string|max:50',
            'instrumentos'             => 'required|array|min:1',
            'instrumentos.*.nombre'    => 'required|string|max:255',
        ]);

        // 2) Carpeta según slug del nombre (o del existente si slug vacío)
        $drink    = Drink::findOrFail($id);
        $slug     = Str::slug($data['nombre']) ?: Str::slug($drink->nombre) ?: 'anadidos';
        $basePath = "public/image/absolut-drinks/{$slug}";
        if (!Storage::disk('public')->exists($basePath)) {
            Storage::disk('public')->makeDirectory($basePath);
        }

        DB::transaction(function() use ($data, $request, $drink, $slug) {
            // 3) Imagen principal (si se cargó nueva)
            if ($request->hasFile('imagen')) {
                $file     = $request->file('imagen');
                $fname    = Str::random(8).'_'.$file->getClientOriginalName();
                $file->storeAs("image/absolut-drinks/{$slug}", $fname, 'public');
                $drink->imagen = "image/absolut-drinks/{$slug}/{$fname}";
            }

            // 4) Actualizar campos básicos
            $drink->update([
                'nombre'                => $data['nombre'],
                'descripcion'           => $data['descripcion'],
                'texto'                 => $data['texto'],
                'pasos'                 => $data['pasos'],
                'producto_id'           => $data['producto_id'],
                'tipo_coctel_id'        => $data['tipo_coctel_id'],
                'base_sabor_id'         => $data['base_sabor_id'],
                'tiempo_preparacion_id' => $data['tiempo_preparacion_id'],
            ]);

            // 5) Imágenes adicionales (si enviadas)
            if (! empty($data['imagenes'])) {
                foreach ($request->file('imagenes') as $file) {
                    if (! $file) continue;
                    $fn = Str::random(8).'_'.$file->getClientOriginalName();
                    $file->storeAs("image/absolut-drinks/{$slug}", $fn, 'public');
                    DB::table('drinks_imagenes')->insert([
                        'drink_id' => $drink->id,
                        'ruta'     => "image/absolut-drinks/{$slug}/{$fn}",
                    ]);
                }
            }

            // 6) Ingredientes: crear si falta y sync con cantidad
            $ingredSync = [];
            foreach ($data['ingredientes'] as $ing) {
                $model = Ingrediente::firstOrCreate(['nombre' => $ing['nombre']]);
                $ingredSync[$model->id] = ['cantidad' => $ing['cantidad']];
            }
            $drink->ingredientes()->sync($ingredSync);

            // 7) Instrumentos: crear si falta y sync
            $instIds = [];
            foreach ($data['instrumentos'] as $itm) {
                $model = Instrumento::firstOrCreate(['nombre' => $itm['nombre']]);
                $instIds[] = $model->id;
            }
            $drink->instrumentos()->sync($instIds);
        });

        return redirect()->route('panel');
    }

}
