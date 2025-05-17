<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reseña>
 */
class ReseñaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contenido' => $this->faker->paragraph(4),
            'usuario_user' => Usuario::inRandomOrder()->first()?->usuario_user ?? Usuario::factory(),
            'producto_id' => Producto::inRandomOrder()->first()?->id ?? Producto::factory(),
        ];
    }
}
