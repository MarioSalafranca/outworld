<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Valoracion>
 */
class ValoracionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'puntuacion' => $this->faker->randomElement(['1', '2', '3', '4', '5']),
            'usuario_user' => Usuario::inRandomOrder()->first()?->usuario_user ?? Usuario::factory(),
            'producto_id' => Producto::inRandomOrder()->first()?->id ?? Producto::factory(),
        ];
    }
}
