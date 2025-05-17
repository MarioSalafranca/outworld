<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrada>
 */
class EntradaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(6),
            'texto' => $this->faker->paragraphs(3, true),
            'imagen' => $this->faker->optional()->imageUrl(800, 600, 'nature'),
            'publicado' => false,
            'usuario_user' => Usuario::inRandomOrder()->first()?->usuario_user ?? Usuario::factory(),
        ];
    }
}
