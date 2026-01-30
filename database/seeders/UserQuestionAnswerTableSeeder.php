<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserQuestionAnswerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Question::factory()->count(10))
            ->create();

        Question::all()->each(function ($question) {
            $question->answers()->createMany(
                Answer::factory()->count(rand(1, 20))->make(['user_id' => User::inRandomOrder()->first()->id])->toArray()
            );
            $question->update(['answer_count' => $question->answers()->count()]);
        });
    }
}
