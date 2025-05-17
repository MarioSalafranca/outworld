<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombres = [
            '40% ABV',
            '38% ABV',
            '50% ABV',
            '4.5% ABV',
            '10% ABV',
            'Otros',
        ];

        return [
            'nombre' => $this->faker->randomElement($nombres),
        ];
    }
}
