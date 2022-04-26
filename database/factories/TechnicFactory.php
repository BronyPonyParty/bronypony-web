<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => rand(0, 10) <= 6 ? 'Компьютер' : 'Принтер',
            'number' => $this->faker->unique()->buildingNumber(),
            'date_purchase' => $this->faker->unixTime(),
            'description' => $this->faker->realTextBetween(200, 1000),
            'provider_id' => rand(1, 3),
            'organization_id' => rand(1, 3),
            'state_name' => rand(0, 10) <= 8 ? 'Исправна' : 'Утилизирована'
        ];
    }
}
