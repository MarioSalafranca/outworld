<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombres = [
            'Absolut Vodka',
            'Absolut Citron',
            'Absolut Lime',
            'Absolut Grapefruit',
            'Absolut Mandrin',
            'Absolut Watermelon',
            'Absolut Mango',
            'Absolut Raspberri',
            'Absolut Peach',
            'Absolut Pears',
            'Absolut Vanilia',
            'Absolut Wild Berri',
            'Absolut Peppar',
            'Absolut Kurant',
            'Absolut Ruby Red',
            'Absolut 100',
            'Absolut Elyx',
            'Absolut Berri Açaí',
            'Absolut Orient Apple',
            'Absolut Gräpevine',
            'Absolut Cherrykran',
            'Absolut Hibiskus',
            'Absolut Cilantro',
            'Absolut Juice Strawberry',
            'Absolut Juice Apple',
            'Absolut Juice Pear & Elderflower',
            'Absolut Juice Rhubarb',
        ];

        return [
            'nombre' => $this->faker->randomElement($nombres),
            'descripcion' => $this->faker->sentence(12),
            'precio' => $this->faker->randomFloat(2, 5, 300),
            'imagen' => 'imagenes/default.jpg',
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
