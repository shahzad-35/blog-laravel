<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'post_title' => $this->faker->sentence,
            'post_body' => $this->faker->text,
            'post_image' => $this->faker->imageUrl($width = 640, $height = 480),
            'category_id' => $this->faker->randomDigitNotNull,
        ];
    }
}
