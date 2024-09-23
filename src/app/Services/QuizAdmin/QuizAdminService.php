<?php

namespace App\Services\QuizAdmin;

use App\Http\Requests\AdminQuizCreateRequest;
use App\Http\Requests\AdminEditRequest;

/**
 * クイズ管理画面のサービスクラス
 */
class QuizAdminService {

    /**
     * クイズ編集画面で設定した、正否をそれぞれ登録
     *
     * @param object $choiceData 選択肢のデータ(選択肢1~の正否、trueは正解でfalseは不正解)
     * @param AdminEditRequest $request リクエストデータ
     */
    public static function registerRightAndWrong(object $choiceData, AdminEditRequest $request): void
    {
        foreach($choiceData as $num => $data) {            
            // 選択肢は1からなので、+1
            $key = "choice".$num+1;            
            if ($data != null) {
                /*
                * 正解の選択肢と同じなら、is_answerを1にする
                * true: is_answerを1にする
                * false: is_answerを0にする
                */
                $request->answer == $num+1
                ? $data->is_answer = 1
                : $data->is_answer = 0;

                // 選択肢の内容を変更
                $data->content = $request->$key;
                $data->save();
            }
        }
    }


    /**
     * クイズ選択肢の取得
     *
     * @param AdminQuizCreateRequest $request リクエストデータ
     * 
     * @return array
     */
    public static function getChoiceData(AdminQuizCreateRequest $request): array
    {
        // 選択肢のみを取得する
        return array_filter($request->all(), function ($key) {
            return strpos($key, 'choice') === 0;
        }, ARRAY_FILTER_USE_KEY);
    }
}