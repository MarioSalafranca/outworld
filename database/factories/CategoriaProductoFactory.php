<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Producto;
use App\Models\Categoria;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CategoriaProducto>
 */
class CategoriaProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'producto_id' => Producto::inRandomOrder()->first()?->id ?? Producto::factory(),
            'categoria_id' => Categoria::inRandomOrder()->first()?->id ?? Categoria::factory(),
        ];
    }
}
