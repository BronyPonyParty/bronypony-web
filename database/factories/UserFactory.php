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
            'login' => $this->faker->citySuffix(),
            'password' =>  md5('123456'),
            'phone_number' => '79' . substr($this->faker->e164PhoneNumber(), 3, 11),
            'mail' => $this->faker->unique()->safeEmail(),
            'organization_id' => rand(1, 3),
            'status_name' => rand(1, 10) < 8 ? 'Работает' : 'Уволен'
        ];
    }
}
