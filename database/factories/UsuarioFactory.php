<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_user' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'password' => bcrypt('password'),
            'telefono' => $this->faker->phoneNumber,
            'calle' => $this->faker->streetName,
            'ciudad' => $this->faker->city,
            'cp' => $this->faker->postcode,
            'numero' => $this->faker->buildingNumber,
            'pais' => $this->faker->country,
            'rol' => 'usuario',
            'remember_token' => Str::random(10),
        ];
    }
}
