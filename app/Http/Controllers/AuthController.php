<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function register(Request $request) {
        $request->validate([
            'usuario_user' => 'required|string|max:255|unique:usuarios,usuario_user',
            'email' => 'required|email|unique:usuarios,email',
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'password' => 'required|string|min:6',
            'telefono' => 'required|string|max:20',
            'calle' => 'required|string|max:100',
            'ciudad' => 'required|string|max:100',
            'cp' => 'required|string|max:100',
            'numero' => 'required|string|max:20',
            'pais' => 'required|string|max:100',
        ]);

        Usuario::create([
            'usuario_user' => $request->usuario_user,
            'email' => $request->email,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'calle' => $request->calle,
            'ciudad' => $request->ciudad,
            'cp' => $request->cp,
            'numero' => $request->numero,
            'pais' => $request->pais,
        ]);

        return redirect()->route('miCuenta');
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->password)) {

            session(['usuario' => $usuario->usuario_user]);

            $admin = $usuario->rol;
            if ($admin == "admin") {
                session(['admin' => true]);
            }

            if (session()->has('url.intended')) {
                $dest = session('url.intended');
                session()->forget('url.intended');
                return redirect($dest);
            }
            return redirect()->route('miCuenta');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas.',
        ]);
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return redirect()->route('tienda');
    }

    public function checkAge(Request $request) {
        $request->validate([
            'day' => 'required|numeric|min:1|max:31',
            'month' => 'required|numeric|min:1|max:12',
            'year' => 'required|numeric|min:1900|max:'.Carbon::now()->year,
        ]);

        $day = $request->input('day');
        $month = $request->input('month');
        $year = $request->input('year');

        $birthDate = Carbon::createFromDate($year, $month, $day);

        $age = $birthDate->age;

        if ($age < 18) {
            return back()->withErrors(['age' => 'No tienes 18 años.']);
        }

        $cookie = cookie('age_verified', 'true');

        return redirect()->route('home')->cookie($cookie);
    }
}
