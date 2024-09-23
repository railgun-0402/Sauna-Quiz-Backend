<?php
/**
 * 
 * AdminQuizCreateRequest
 * クイズ新規追加画面で追加を実行した際に、バリデーションを実行するクラス
 * 
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminQuizCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'required|max:255',
            'choice1' => 'required',
            'choice2' => 'required',
            'choice3' => 'required',
            'choice4' => 'required',
            'answer' => 'required',
            'category' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'content' => 'クイズ内容',
            'choice1' => '選択肢1',
            'choice2' => '選択肢2',
            'choice3' => '選択肢3',
            'choice4' => '選択肢4',
            'answer' => '正解選択肢',
            'category' => 'カテゴリー',
        ];
    }
}