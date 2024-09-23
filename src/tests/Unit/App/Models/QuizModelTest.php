<?php

namespace Tests\Unit\App\Models;

use App\Models\Quiz;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class QuizModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @test
     * getQuiz
     * @return void
     */
    public function testGetQuiz()
    {
        // quizzesテーブルのcontentカラムに「Quiz content 1～3」を作成
        $quizzes = [];
        for ($i = 1; $i <= 3; $i++) {
            $quizzes[] = Quiz::create(['content' => "Quiz content $i"]);
        }

        // 「Quiz content 1～3」からシャッフルされたいずれかのレコード取得
        $quiz = Quiz::getQuiz();
        // getQuizメソッドがnullを返さないことを確認
        $this->assertNotNull($quiz);

        // 「Quiz content 1～3」を作った際のidを配列で取得
        $quizListIds = [];
        foreach ($quizzes as $quizze) {
            $quizListIds[] = $quizze->id;
        }
        // getQuizから取得した単一のidが、「Quiz content 1～3」を作った際のidに含まれているかどうか
        $this->assertTrue(in_array($quiz->id, $quizListIds));

        // quizzesテーブルのcontentカラムから「Quiz content 1～3」を配列で取得
        $quizContents = [];
        foreach ($quizzes as $quizze) {
            $quizContents[] = $quizze->content;
        }
        // getQuizから取得した単一のcontentが「Quiz content 1～3」のどれかであるか
        $this->assertTrue(in_array($quiz->content, $quizContents));
    }
}
