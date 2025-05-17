<?php

namespace Database\Factories;

use App\Models\Comentario;
use App\Models\Entrada;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comentario' => $this->faker->sentence(15),
            'usuario_user' => Usuario::inRandomOrder()->first()?->usuario_user ?? Usuario::factory(),
            'entrada_id' => Entrada::inRandomOrder()->first()?->id ?? Entrada::factory(),
            'comentario_id_comentario' => null,
        ];
    }
}
