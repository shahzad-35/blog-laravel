<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'google_id' => $this->faker->ean13,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->sha256,
            'picture' => $this->faker->imageUrl($width = 640, $height = 480, 'Boy') ,
            'role' => $this->faker->randomElement($array = array ('Admin','NULL'))
        ];
    }
}
