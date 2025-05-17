<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{

    public function historia() {
        return view('historia');
    }

    public function contacto() {
        return view('contacto');
    }

    public function avisoLegal() {
        return view('/legal/avisoLegal');
    }

    public function politicaCookies() {
        return view('/legal/politicaCookies');
    }

    public function politicaPrivacidad() {
        return view('/legal/politicaPrivacidad');
    }

}
