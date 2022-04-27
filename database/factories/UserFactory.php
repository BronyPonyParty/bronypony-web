<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'lastname' => $this->faker->lastName(),
            'firstname' => $this->faker->firstName(),
            'middlename' => $this->faker->lastName(),
            'login' => $this->faker->unique()->citySuffix(),
            'password' =>  md5('123456'),
            'phone_number' => '79' . substr($this->faker->unique()->e164PhoneNumber(), 3, 11),
            'mail' => $this->faker->unique()->safeEmail(),
            'organization_id' => rand(1, 3),
            'status' => rand(1, 10) < 8
        ];
    }
}
