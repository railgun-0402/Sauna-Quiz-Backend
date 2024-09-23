<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者権限
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'is_admin' => 1,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Str::random(10),
            'created_at'  => now(),
            'updated_at'  => now(),
            'introduction'  => \Str::random(10),
            'sex'  => 1,
        ]);

        // ユーザー権限
        User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'is_admin' => 0,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => \Str::random(10),
            'created_at'  => now(),
            'updated_at'  => now(),
            'introduction'  => \Str::random(10),
            'sex'  => 1,
        ]);

        // ダミーデータ
        User::factory(500)->create();
    }
}
