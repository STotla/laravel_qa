<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavouritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('favourites')->delete();
        $users= User::pluck('id')->All();
        $numberOfUsers=count($users);
        foreach(Question::all() as $question){
            for($i=0;$i<rand(0,$numberOfUsers);$i++){
                $user= $users[$i];
                $question->favourites()->attach($user);
            }
        }
    }
}
