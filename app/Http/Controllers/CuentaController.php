<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Compra;
use Barryvdh\DomPDF\Facade\Pdf as DomPDF;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class CuentaController extends Controller
{
    public function cuenta() {
        return view('/cuenta');
    }

    public function miCuenta() {
        if (session()->has('usuario')) {

            $usuario = session('usuario');
            $datosUsuario = Usuario::with('compras.productos')
                ->where('usuario_user', $usuario)
                ->firstOrFail();

            return view('/miCuenta', compact('datosUsuario'));

        } else {
            return view('/cuenta');
        }
    }

    public function actualizarPassword(Request $request) {
        if (session()->has('usuario')) {
            $user = session('usuario');

            $request->validate([
                'oldPassword' => 'required',
                'password' => 'required|min:6|confirmed|different:oldPassword'
            ],[
                'oldPassword.required' => 'La contraseña anterior es obligatoria.',
                'password.required' => 'La contraseña nueva es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);
            $oldPassword = $request->oldPassword;
            $data = array('usuario' => $user, 'password' => $oldPassword);

            $usuario = Usuario::checkUsuario($data);

            if ($usuario != null){
                $usuario->password = Hash::make($request->password);
                $usuario->save();
                return redirect()->route('miCuenta')->with('success', 'Contraseña cambiada correctamente.');
            } else {
                return redirect()->route('miCuenta')->withErrors(['login' => 'Contraseña actual incorrecta.']);
            }
        }
    }

    public function modificarCuenta(Request $request) {
        if (session()->has('usuario')) {
            $user = session('usuario');
            $datosUsuario = Usuario::find($user);

            $request->validate([
                'usuario_user' => 'required|string|max:250|unique:usuarios,usuario_user,' . $datosUsuario->usuario_user . ',usuario_user',
                'nombre' => 'required|string|max:25',
                'apellido' => 'required|string|max:30',
                'email' => [
                    'required', 'string', 'max:100',
                    Rule::unique('usuarios', 'email')->ignore($datosUsuario->email, 'email'),
                ],
                'telefono' => 'required|string|max:20',
                'calle' => 'required|string|max:100',
                'ciudad' => 'required|string|max:100',
                'cp' => 'required|string|max:100',
                'numero' => 'required|string|max:20',
                'pais' => 'required|string|max:100',
            ],[
                'usuario.unique' => 'El usuario ya existe.',
                'usuario.required' => 'El usuario es obligatorio.',

                'nombre.required' => 'El nombre es obligatorio.',
                'apellidos.required' => 'Los apellidos son obligatorios.',

                'email.required' => 'El email es obligatorio.',
                'email.unique' => 'El email ya existe.',
                'email.email' => 'El email debe ser una dirección válida.',

            ]);

            $datosUsuario->usuario_user = $request->usuario_user;
            $datosUsuario->nombre = $request->nombre;
            $datosUsuario->apellido = $request->apellido;
            $datosUsuario->email = $request->email;
            $datosUsuario->telefono = $request->telefono;
            $datosUsuario->calle = $request->calle;
            $datosUsuario->ciudad = $request->ciudad;
            $datosUsuario->cp = $request->cp;
            $datosUsuario->numero = $request->numero;
            $datosUsuario->pais = $request->pais;
            $datosUsuario->save();

            return redirect()->route('miCuenta');

        }
    }

    public function descargarFactura($id)
    {
        $compra = Compra::with('productos')->findOrFail($id);

        if ($compra->usuario_user !== session('usuario')) {
            abort(403);
        }

        $user = Usuario::where('usuario_user', $compra->usuario_user)->firstOrFail();
        $items = $compra->productos->map(function($p){
            return [
                'nombre'   => $p->nombre,
                'cantidad' => $p->pivot->cantidad,
                'precio'   => $p->pivot->precio_unitario,
            ];
        })->toArray();

        $pdf = DomPDF::loadView('factura', [
            'compra'  => $compra,
            'usuario' => $user,
            'items'   => $items,
        ]);

        return $pdf->stream("factura_{$compra->id}.pdf");
    }
/*
    public function eliminarCuenta()
    {
        $username = session('usuario');
        $user = Usuario::where('usuario_user', $username)->firstOrFail();

        $user->delete();

        session()->forget('usuario');

        return redirect()->route('home');
    }*/
}
