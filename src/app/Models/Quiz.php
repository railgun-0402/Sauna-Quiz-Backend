<?php

namespace App\Models;

use App\Exceptions\AdminQuizException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Exception;

class Quiz extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * クイズをランダムで1問取得
     *
     * @return self
     */
    public static function getQuiz(): self
    {
        // クイズテーブルのIDを配列で取得
        $quizIdList = self::pluck('id')->toArray();

        // シャッフル
        shuffle($quizIdList);

        // 配列の1番目を取得
        $quizId = current($quizIdList);

        return self::where('id', $quizId)->first();        
    }

    /**
     * IDに紐づいたクイズデータ取得
     * @param mixed $id
     *
     * @return \App\Models\Quiz
     */
    public static function getQuizById($quizId)
    {
        return self::find($quizId);
    }

    /**
     * Quizテーブルの数から、新規作成するクイズIDを取得
     *
     * @return int
     */
    public static function getQuizDataId()
    {
        return self::count();
    }

    /**
     * Quizを追加
     *
     * @param string $content
     * idは連番・contentは引数・それ以外は基本now
     */
    public static function insertQuizData($content)
    {
        try {
            DB::beginTransaction();
            // Quizテーブルデータ追加
            DB::table('quizzes')->insert([
                'comment_id'=> self::getQuizDataId() + 1,
                'content' => $content
            ]);
            DB::commit();
        } catch (Exception $e) {
            // ロールバック後、呼び出し元で失敗ダイアログを表示させる
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * クイズデータ全取得
     *
     * @return \App\Models\Quiz[]
     */
    public static function getQuizAll()
    {
        return self::all();
    }

    /**
     * クイズデータ編集
     * @param object $request リクエストデータ
     *
     * @return void
     */
    public static function updateQuizData($request)
    {
        DB::beginTransaction();
        try {
            DB::table('quizzes')
            ->where('id', $request->quizId)
            ->update([
                'content' => $request->content
            ]);
            DB::commit();
        } catch (Exception $e) {
            // ロールバック後、呼び出し元で失敗ダイアログを表示させる
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * クイズデータ削除
     * @param mixed $id
     */
    public static function deleteQuizById($quizId): void
    {
        try {
            self::where('id', $quizId)->delete();
        } catch (Exception $e) {
            // ロールバック後、呼び出し元で失敗ダイアログを表示させる
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}