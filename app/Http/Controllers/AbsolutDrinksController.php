<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drink;
use App\Models\Reseña;

class AbsolutDrinksController extends Controller
{
    // General
    public function absolutDrinks(Request $request)
    {

        if (! request()->hasCookie('age_verified')) {
            return view('ageGate');
        }

        $query = Drink::with(['ingredientes', 'instrumentos', 'reseñas']);

        $tipoCoctel = $request->input('tipo_coctel');
        $baseSabor = $request->input('base_sabor');
        $tiempoPreparacion = $request->input('tiempo_preparacion');

        if ($tipoCoctel) {
            $query->whereHas('tipoCoctel', function ($q) use ($tipoCoctel) {
                $q->where('nombre', $tipoCoctel);
            });
        }

        if ($baseSabor) {
            $query->whereHas('baseSabor', function ($q) use ($baseSabor) {
                $q->where('nombre', $baseSabor);
            });
        }

        if ($tiempoPreparacion) {
            $query->whereHas('tiempoPreparacion', function ($q) use ($tiempoPreparacion) {
                $q->where('nombre', $tiempoPreparacion);
            });
        }

        $drinks = $query->paginate(8);

        return view('absolutDrinks', compact('drinks'));
    }

    public function search(Request $request)
    {
        $term = $request->input('q');

        $query = Drink::query();

        if (!empty($term)) {
            $query->where('nombre', 'LIKE', "%{$term}%");
        }

        $drinks = $query->orderBy('nombre')
            ->paginate(8)
            ->withQueryString();

        return view('absolutDrinks', [
            'drinks' => $drinks,
            'search' => $term,
        ]);
    }

    // Especifico
    public function drink($id) {

        if (! request()->hasCookie('age_verified')) {
            return view('ageGate');
        }

        $drink = Drink::with(['ingredientes', 'instrumentos', 'reseñas', 'imagenes'])->findorfail($id);
        return view('drink', compact('drink'));
    }

    public function comentar(Request $request, $id) {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:500',
            'usuario' => 'nullable|string|max:100',
        ]);

        Reseña::create([
            'drink_id' => $id,
            'usuario' => session('usuario'),
            'comentario' => $request->input('comentario'),
            'valoracion' => $request->input('rating'),
        ]);

        return redirect()->back();
    }

    public function responder(Request $request, $id) {
        $request->validate([
            'comentario' => 'required|string',
        ]);

        $reseñaPadre = Reseña::find($id);

        Reseña::create([
            'usuario' => session('usuario'),
            'valoracion' => 0,
            'comentario' => $request->comentario,
            'parent_id' => $id,
            'drink_id' => $reseñaPadre->drink_id,
        ]);

        return redirect()->back()->with('success', 'Respuesta añadida correctamente.');
    }


}
