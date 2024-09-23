<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // ユーザーテーブル
        $this->call(UserSeeder::class);
        // クイズ設問テーブル
        $this->call(QuizSeeder::class);
        // カテゴリーテーブル
        $this->call(CategorySeeder::class);
        // 回答選択肢テーブル
        $this->call(ChoiceSeeder::class);
        // クイズ解説テーブル
        $this->call(CommentSeeder::class);
    }
}