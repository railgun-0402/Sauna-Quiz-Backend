<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = file_get_contents(database_path().'/dml/choices.sql');
        \DB::insert($sql);
    }
}
