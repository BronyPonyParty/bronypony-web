<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'organization_name' => $this->faker->unique()->company(),
            'phone_number' => '79' . substr($this->faker->unique()->e164PhoneNumber(), 3, 11),
            'address' => $this->faker->unique()->address(),
            'status' => rand(0 ,1) ? 'Работает' : 'Не работает'
        ];
    }
}
