<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_perfil'   => $this->faker->numberBetween(2, 3),
            'id_sexo'     => $this->faker->numberBetween(1, 7),
            'nome'        => $this->faker->name(),
            'cpf'         => $this->faker->unique()->numerify('###########'),
            'senha'       => bcrypt('123456'),
            'email'       => $this->faker->unique()->safeEmail(),
            'dat_nasc'    => $this->faker->date(),
            'endereco'    => $this->faker->address(),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
