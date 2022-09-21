<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WordSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 1000; $i++) {
            Word::create([
                'name' => 'Word ' .$i,
                'description' => 'Description word ' .$i,
                'user_id' => 1
            ]);
        }

    }
}
