<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Compra;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TiendaController extends Controller
{
    public function tienda(Request $request) {

        if (! request()->hasCookie('age_verified')) {
            return view('ageGate');
        }

        $tamanioPagina = 8;

        $categoria = $request->input('categoria');
        $subcategoria = $request->input('subcategoria');

        $productos = Producto::with(['imagenes', 'categorias']);

        if ($categoria && $categoria !== 'all') {
            $productos->whereHas('categorias', function ($query) use ($categoria) {
                $query->where('nombre', $categoria);
            });
        }

        if ($subcategoria) {
            $productos->whereHas('categorias', function ($query) use ($subcategoria) {
                $query->where('nombre', $subcategoria);
            });
        }

        $productos = $productos->paginate($tamanioPagina);

        return view('tienda', compact('productos'));
    }

    public function search(Request $request)
    {
        $term = $request->input('q');

        if (empty($term)) {
            $products = Producto::all();
        } else {
            $products = Producto::where('nombre', 'LIKE', "%{$term}%")
                ->orderBy('nombre')
                ->paginate(8)
                ->withQueryString();
        }

        return view('tienda', [
            'productos' => $products,
            'search'   => $term,
        ]);
    }

    public function producto($id) {

        if (! request()->hasCookie('age_verified')) {
            return view('ageGate');
        }


        $producto = Producto::with(['atributos', 'imagenes', 'ingredientes'])->findOrFail($id);
        return view('producto', compact('producto'));
    }

    public function carrito() {

        if (! session()->has('usuario')) {
            return redirect()->route('tienda');
        }

        return view('carrito');
    }

    public function procesarPedido(Request $request) {

        $request->validate([
            'carrito' => 'required|json',
        ]);

        $items   = json_decode($request->input('carrito'), true);
        $username = session('usuario');
        $user = Usuario::where('usuario_user', $username)->firstOrFail();

        foreach ($items as $item) {
            $producto = Producto::find($item['id']);
            if (! $producto) {
                return back()->withErrors("El producto con ID {$item['id']} no existe.");
            }
            if ($producto->stock < $item['cantidad']) {
                return back()->withErrors("No hay suficiente stock de “{$producto->nombre}”. Solo quedan {$producto->stock} unidades.");
            }
        }

        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += $item['precio'] * $item['cantidad'];
        }
        $envio = 5.00;
        $total = $subtotal + $envio;

        DB::beginTransaction();
        try {
            $compra = Compra::create([
                'fecha'        => Carbon::now()->toDateString(),
                'total'        => $total,
                'envio'        => $envio,
                'email'        => $user['email'],
                'telefono'     => $user['telefono'],
                'calle'        => $user['calle'],
                'ciudad'       => $user['ciudad'],
                'cp'           => $user['cp'],
                'numero'       => $user['numero'],
                'pais'         => $user['pais'],
                'usuario_user' => $user['usuario_user'],
            ]);

            foreach ($items as $item) {
                $producto = Producto::findOrFail($item['id']);

                $compra->productos()->attach($producto->id, [
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                ]);

                // Descontar del stock
                $producto->decrement('stock', $item['cantidad']);
            }

            DB::commit();

            $pdf = DomPDF::loadView('factura', [
                'compra'  => $compra,
                'usuario' => $user,
                'items'   => $items,
            ]);

            return $pdf->stream("factura_{$compra->id}.pdf");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al procesar el pedido: ' . $e->getMessage());
        }
    }
}


