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
            'organization_name' => $this->faker->company(),
            'phone_number' => '79' . substr($this->faker->e164PhoneNumber(), 3, 11),
            'address' => $this->faker->address(),
            'state_name' => rand(0 ,1) ? 'Работает' : 'Не работает'
        ];
    }
}
