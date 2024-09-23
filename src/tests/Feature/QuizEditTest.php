<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuizEditTest extends TestCase
{
    use RefreshDatabase;
    
    /* 各テストの前にSeed実行 */
    protected $seed = true;

    
    /**
     * @test
     * クイズ編集画面の表示テスト     
     */
    public function it_displays_edit_quiz_form()
    {                
        $quiz = Quiz::find("1"); // 適当なクイズを試す

        // クイズ編集画面へのリクエスト
        $response = $this->get(route('admin.edit', ['id' => $quiz->id]));
        
        $response->assertStatus(200);
        $response->assertSee('クイズ編集');
        $response->assertSee('クイズ内容');        

        // エラーメッセージが表示無し確認
        $response->assertDontSee('alert alert-danger'); 
    }

    /**
     * @test
     * バリデーションエラーの表示テスト
     */    
    public function it_displays_validation_errors()
    {     
        // 不正なデータでクイズ編集フォームにリクエスト
        $response = $this->post(route('admin.change'), [
            // バリデーションに違反するデータを送信
            'content' => '',
        ]);

        // レスポンスのアサーション
        $response->assertStatus(302);           // バリデーションエラーによるリダイレクト確認
        $response->assertSessionHasErrors();    // エラーメッセージがセッションに保存
        $response->assertRedirect();            // 適切なページにリダイレクト確認

        // クイズ編集画面、エラーメッセージ表示確認
        $redirectResponse = $this->get(route('admin.edit', ['id' => Quiz::find("1")->id]));
        $redirectResponse->assertStatus(200);
        $redirectResponse->assertSee('alert alert-danger');
        $redirectResponse->assertSee('クイズ内容は必ず指定してください。');
    }

    /**
     * @test
     * クイズの編集テスト
     */    
    public function it_executes_quiz_edit()
    {
        // ダイアログ表示時にOKがクリックされたと仮定
        $this->mockConfirmationDialog(true);

        // 送信するサンプルデータ
        $validData = [
            'content' => 'サウナの発信の地は？',      // クイズ内容
            'choice1' => 'アフリカ',                // 選択肢1
            'choice2' => 'インド',                 // 選択肢2
            'choice3' => 'ロシア',                 // 選択肢3
            'choice4' => 'フィンランド',            // 選択肢4
            'answer' => 4,                        // 正解の選択肢番号
            'quizId' => 1,                        // クイズのID（編集対象のクイズのID）
        ];

        $user = User::find("1");
        $response = $this->actingAs($user)
            ->post(route('admin.change'), $validData);

        // レスポンスのアサーション
        $response->assertStatus(302);
    }

    /** 
     * ダイアログ表示時にOKがクリックされたと仮定するメソッド
     *
     * @param bool $confirmed
     */
    private function mockConfirmationDialog($confirmed = true)
    {
        // テスト時に JavaScript の confirm メソッドを上書き
        $this->mock(Javascript::class, function ($mock) use ($confirmed) {
            $mock->shouldReceive('execute')
                ->with('return confirm("編集を実行します。\\nよろしいですか？");')
                ->andReturn($confirmed);
        });
    }
}