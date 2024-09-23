<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class MypageTopTest extends TestCase
{
    /**
     * @test
     * マイページアクセス確認
     * 
     * ログインしていない場合は、ログイン画面へリダイレクトする
     */
    public function access_check_mypagetop()
    {
        $response = $this->get('/mypage');
        
        // ログイン画面へリダイレクトするかの確認
        $response->assertStatus(302)->assertRedirect(route("login"));
    }

    /**
     * @test
     * マイページアクセス確認 (ログイン済)
     */
    public function access_check_mypagetop_with_login()
    {
        $user = User::find("1");
        $response = $this->actingAs($user)
            ->get(route('mypage.top'));

        $response->assertStatus(200);
    }

    /**
     * @test
     * マイページTop画面表示テスト     
     */
    public function it_displays_mypage_top_screen()
    {
        $user = User::find("1");
        $response = $this->actingAs($user)
            ->get(route('mypage.top'));
        
        $response->assertSee('マイページ');
        $response->assertSee('サウナクイズ');
    }
}