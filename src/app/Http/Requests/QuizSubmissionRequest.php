<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizSubmissionRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストの権限を持っているか判断
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * リクエストに適用するバリデーションルールを取得
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quiz_id' => 'required|integer|exists:quizzes,id',
            'answer' => 'required|integer|exists:choices,id',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'answer.required' => 'いずれか一つを選択してください。',
        ];
    }


}
