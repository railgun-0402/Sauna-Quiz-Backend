<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Choice extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'category_id',
        'content',
        'is_answer',
    ];


    /**
     * 設問に紐づく回答をシャッフルして取得
     *
     * @param integer $quizId quizzesテーブルのID
     * @return Collection
     */
    public static function getChoice(int $quizId): Collection
    {
        return self::query()
            ->where('quiz_id', $quizId)
            ->get()
            ->shuffle();
    }

    /**
     * 選択肢データを追加
     * @param $quizId 外部ID
     * @param $categoryId 外部ID
     * @param $content 選択肢内容
     * @param $isAnswer 正否
     * @param $i 繰り返し処理
     *
     * 選択肢は基本複数なので、$iが必要
     */
    public static function insertQuestionsData($quizId, $categoryId, $content, $isAnswer, $i): void
    {
        try {
            DB::beginTransaction();

            DB::table('choices')->insert([
                'quiz_id' => $quizId,
                'category_id' => $categoryId,
                'content' => $content,
                'is_answer' => ((int)$i+1 == $isAnswer)
                ? '1'
                : '0'
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            print('Choiceデータ追加失敗!'. $e->getMessage());
        }
    }


    /**
     * 設問に紐づくデータを取得
     *
     * @param integer $quizId quizzesテーブルのID
     * @return Collection
     */
    public static function getQuizData(int $quizId): Collection
    {
        return self::query()
            ->where('quiz_id', $quizId)
            ->get();
    }
}