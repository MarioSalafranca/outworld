<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class HomeController extends Controller
{
    public function home() {
        if (request()->hasCookie('age_verified')) {
            $productos = Producto::all();
            return view('home', compact('productos'));
        } else {
            return view('ageGate');
        }
    }
}
