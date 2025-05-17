<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoriaDrink;
use App\Enums\TipoCoctel;
use App\Enums\BaseSabor;
use App\Enums\TiempoPreparacion;

class CategoriaDrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (TipoCoctel::cases() as $tipo) {
            CategoriaDrink::create([
                'tipo' => 'tipo_coctel',
                'nombre' => $tipo->value
            ]);
        }

        foreach (BaseSabor::cases() as $sabor) {
            CategoriaDrink::create([
                'tipo' => 'base_sabor',
                'nombre' => $sabor->value
            ]);
        }

        foreach (TiempoPreparacion::cases() as $tiempo) {
            CategoriaDrink::create([
                'tipo' => 'tiempo_preparacion',
                'nombre' => $tiempo->value
            ]);
        }
    }
}
