<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
    
class QuizCreateTest extends TestCase
{
    use RefreshDatabase;

    /* 各テストの前にSeed実行 */
    protected $seed = true;

    
    /**
     * @test
     * クイズ追加画面の表示テスト
     */
    public function it_displays_create_quiz_form()
    {
        $categories = Category::all(); // 適当なクイズを試す

        // クイズ編集画面へのリクエスト
        $response = $this->get(route('admin.add', ['categories' => $categories]));

        // レスポンスのアサーション
        $response->assertStatus(200);
        $response->assertSee('クイズを追加する(入力は全て必須です)');
        $response->assertSee('クイズ内容');
        $response->assertSee('正解は何番？'); 

        // バリデーションエラーメッセージの表示
        $response->assertDontSee('alert alert-danger'); // エラーメッセージが表示されないことを確認
    }

    /**
     * @test
     * バリデーションエラー：クイズ内容と正解が空
     */
    public function validation_check_null_content_answer()
    {     
        // 不正なデータでクイズ追加フォームにリクエスト
        $response = $this->post(route('admin.create'), [
            // クイズ内容だけ空でリクエスト
            'content' => '',
            'choice1' => 'choice1',
            'choice2' => 'choice2',
            'choice3' => 'choice3',
            'choice4' => 'choice4',
            'answer' => '',
            'category' => '4',
        ]);
        
        $response->assertStatus(302);           // バリデーションエラーによるリダイレクト確認
        $response->assertSessionHasErrors();    // エラーメッセージがセッションに保存
        $response->assertRedirect();            // 適切なページにリダイレクト確認

        // クイズ追加画面、エラーメッセージ表示確認
        $redirectResponse = $this->get(route('admin.add'));
        $redirectResponse->assertStatus(200);
        $redirectResponse->assertSee('alert alert-danger');
        $redirectResponse->assertSee('クイズ内容は必ず指定してください。');
        $redirectResponse->assertSee('正解選択肢は必ず指定してください。');
    }

    /**
     * @test
     * バリデーションエラー：選択肢1とカテゴリーが空
     */
    public function validation_check_null_choice_category()
    {     
        // 不正なデータでクイズ追加フォームにリクエスト
        $response = $this->post(route('admin.create'), [
            // クイズ内容だけ空でリクエスト
            'content' => '問題内容',
            'choice1' => '',
            'choice2' => '選択肢2',
            'choice3' => '選択肢3',
            'choice4' => '選択肢4',
            'answer' => '4',
            'category' => '',
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        
        // クイズ追加画面、エラーメッセージ表示確認
        $redirectResponse = $this->get(route('admin.add'));
        $redirectResponse->assertSee('選択肢1は必ず指定してください。');
        $redirectResponse->assertSee('カテゴリーは必ず指定してください。');
    }

    /**
     * @test
     * バリデーションエラー：選択肢2〜4が空
     */
    public function validation_check_null_choices()
    {     
        // 不正なデータでクイズ追加フォームにリクエスト
        $response = $this->post(route('admin.create'), [
            // クイズ内容だけ空でリクエスト
            'content' => '問題内容',
            'choice1' => '選択肢1',
            'choice2' => '',
            'choice3' => '',
            'choice4' => '',
            'answer' => '4',
            'category' => '2',
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        
        // クイズ追加画面、エラーメッセージ表示確認
        $redirectResponse = $this->get(route('admin.add'));
        $redirectResponse->assertSee('選択肢2は必ず指定してください。');
        $redirectResponse->assertSee('選択肢3は必ず指定してください。');
        $redirectResponse->assertSee('選択肢4は必ず指定してください。');
    }

    /**
     * @test
     * 境界値テスト①
     * バリデーションエラー：クイズ内容の文字数が最大値を超える
     */
    public function validation_check_max_count()
    {
        // 256文字の文字を取得
        $test_string = \Lang::get("validation.string_256");
        // 不正なデータでクイズ追加フォームにリクエスト
        $response = $this->post(route('admin.create'), [
            // クイズ内容だけ空でリクエスト
            'content' => $test_string,
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
        $response->assertRedirect();
        
        // クイズ追加画面、エラーメッセージ表示確認
        $redirectResponse = $this->get(route('admin.add'));
        $redirectResponse->assertSee('クイズ内容は、255文字以下で指定してください。');
    }

    /**
     * @test
     * 境界値テスト②
     * バリデーションチェック：クイズ内容の文字数 = 最大文字数
     */
    public function validation_check_equal_count()
    {
        // 255文字の文字を取得(最大文字数)
        $test_string = \Lang::get("validation.string_255");
        // 不正なデータでクイズ追加フォームにリクエスト
        $response = $this->post(route('admin.create'), [
            // クイズ内容だけ空でリクエスト
            'content' => $test_string,
            'choice1' => '選択肢1',
            'choice2' => '選択肢2',
            'choice3' => '選択肢3',
            'choice4' => '選択肢4',
            'answer' => '4',
            'category' => '1',
        ]);
        
        $response->assertStatus(302);        
        $response->assertSessionHasNoErrors();  // エラーではないのでセッションは存在しないはず
        $response->assertRedirect();
        
        $redirectResponse = $this->get(route('admin.add'));
        $redirectResponse->assertDontSee('クイズ内容は、255文字以下で指定してください。');
    }

    /**
     * @test
     * クイズ追加テスト
     */    
    public function executes_quiz_create()
    {
        // ダイアログ表示時にOKがクリックされたと仮定
        $this->mockConfirmationDialog(true);

        // 送信するサンプルデータ
        $validData = [
            'content' => 'TestQuestion',
            'choice1' => '選択肢1',
            'choice2' => '選択肢2',
            'choice3' => '選択肢3',
            'choice4' => '選択肢4',
            'answer' => '4',
            'category' => '1',
        ];

        $user = User::find("1");
        $response = $this->actingAs($user)
            ->post(route('admin.create'), $validData);

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
                ->with('return confirm("クイズを追加します。\\nよろしいですか？");')
                ->andReturn($confirmed);
        });
    }

}