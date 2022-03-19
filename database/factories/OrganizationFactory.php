<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
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
            'address' => $this->faker->address(),
            'phone_number' => '79' . substr($this->faker->e164PhoneNumber(), 3, 11),
            'registration_date' => $this->faker->unixTime(),
            'state_name' => rand(0 , 1) ? 'Работает' : 'Не работает'
        ];
    }
}
