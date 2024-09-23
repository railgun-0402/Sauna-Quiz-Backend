<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path().'/dml/quizzes.sql');
        \DB::insert($sql);
    }
}
