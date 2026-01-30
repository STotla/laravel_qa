<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('votables')->delete();
        $users = User::all();
        $usersCount = $users->count();
        $voteOptions = [1]; // 1 for upvote, -1 for downvote
        $questions = Question::all();

        foreach($questions as $question){
            for($i=0; $i<rand(1, $usersCount); $i++){
                $user = $users[$i];
                $vote = $voteOptions[array_rand($voteOptions)];
                // Attach vote to votables table
                $question->votes()->attach($user->id, ['vote' => $vote]);
            }
        }


    }
}
