<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
              'title'        => rtrim($this->faker->unique()->realText(rand(50, 80)), '.'),
            'body'         => $this->faker->realTextBetween(200, 500),
            'views'=>(rand(0,10)),
            'answer_count'=>(rand(0,15)),
            //'votes_count' =>rand(-3,40),


        ];
    }
}
