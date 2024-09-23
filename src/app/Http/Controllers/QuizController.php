<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuizSubmissionRequest;
use App\Models\Choice;
use App\Models\Quiz;

class QuizController extends Controller
{

    /**
     * クイズ出題画面
     *
     * @return void
     */
    public function index()
    {
        // クイズ1問取得
        $quiz = Quiz::getQuiz();

        // クイズ問題に応じた回答を取得
        $choices = Choice::getChoice($quiz->id);

        return view('quiz.index')
            ->with('quiz', $quiz)
            ->with('choices', $choices);
    }

    /**
     * クイズ解答実行
     *
     * @param QuizSubmissionRequest $request リクエスト情報
     * @return void
     */
    public function submit(QuizSubmissionRequest $request)
    {
        // 必要なデータのみ取得
        $request_data = $request->only([
            'answer',
            'quiz_id',
        ]);

        // quiz_idに対応する、正解の選択肢を取得
        $correctChoice = Choice::where('quiz_id', $request_data['quiz_id'])
                               ->where('is_answer', true)
                               ->first();

        return response()->json([
            'correct' => $correctChoice->id === $request_data['answer'] ? true : false,
            // 'comment' => Comment::getData(); // TODO commentsテーブル作成後に対応
        ]);
    }
}
