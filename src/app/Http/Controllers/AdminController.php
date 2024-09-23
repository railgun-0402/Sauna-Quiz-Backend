<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Http\Requests\AdminEditRequest;
use App\Http\Requests\AdminQuizCreateRequest;
use App\Models\Category;
use App\Services\QuizAdmin\QuizAdminService;

class AdminController extends Controller
{
    /**
     * クイズ管理Top画面
     */
    public function index()
    {
        // 画面を返すのみ
        return view('admin.index');
    }
    
    /**
     * クイズ管理Top画面
     */
    public function list()
    {
        try {
            // DBデータを取得
            $quizData = Quiz::getQuizAll();

            return view('admin.list', [
                'quiz_data' => $quizData,
            ]);
        } catch (\Exception $e) {
            print('Top画面エラー'. $e->getMessage());
        }
    }

    /**
     * Quiz編集画面遷移
     */
    public function edit(Request $id)
    {
        try {
            // Objectから、idを取得
            $quizId = $id->id;
            // 全画面で選択したクイズデータを取得
            $quizEditData = Quiz::getQuizById($quizId);
            // クイズ問題に応じた回答を取得
            $choiceEditData = Choice::getQuizData($quizId);

            return view('admin.edit', [
                'quiz_edit_data' => $quizEditData,
                'choice_edit_data' => $choiceEditData,
            ]);
        } catch (\Exception $e) {
            print('編集画面遷移エラー'. $e->getMessage());
        }
    }

    /**
     * Quiz編集実行
     */
    public function change(AdminEditRequest $request)
    {
        try {
            // クイズデータの編集
            Quiz::updateQuizData($request);
            // Choiceテーブルデータを取得
            $choiceData = Choice::getQuizData($request->quizId);            
            // Choiceテーブルに選択肢を登録
            QuizAdminService::registerRightAndWrong($choiceData, $request);

            return redirect()
            ->route('admin.list')
            ->with('flash_message', '編集が完了しました');
        } catch (\Exception $e) {
            return redirect()
            ->route('admin.index')
            ->with('flash_message', 'Error!!:クイズの編集に失敗しました。。');
        }
    }

    /**
     * Quiz追加画面遷移
     */
    public function add()
    {
        try {
            // DBデータを取得
            $categoryData = Category::getCategoryAll();

            return view('admin.add', [
                'category_data' => $categoryData,
            ]);
        } catch (\Exception $e) {
            print('追加エラー'. $e->getMessage());
        }
    }

    /**
     * Quiz追加実行
     */
    public function create(AdminQuizCreateRequest $request)
    {                
        try {
            // クイズデータ追加
            Quiz::insertQuizData($request->content);
            // クイズIDを取得
            $nextQuizId = Quiz::getQuizDataId();

            // 画面で入力したクイズの選択肢を取得
            $choices = QuizAdminService::getChoiceData($request);
            // Choiceテーブルデータ追加:選択肢は複数なので、繰り返し処理
            $i = 0;
            foreach ($choices as $index => $choice) {
                Choice::insertQuestionsData($nextQuizId, $request->category, $choice, $request->answer, $i);
                $i++;
            }

            return redirect()
            ->route('admin.index')
            ->with('flash_message', 'クイズの追加に成功しました');
        } catch (\Exception $e) {
            return redirect()
            ->route('admin.index')
            ->with('flash_message', 'Error!!:クイズの追加に失敗しました。。');
        }
    }

    /**
     * Quiz削除
     */
    public function delete(Request $id)
    {
        try {
            // Objectから、idを取得
            $quizId = $id->id;

            // クイズ問題に応じた回答を取得
            $choiceEditData = Choice::getQuizData($quizId);

            // 選択肢・クイズの削除
            foreach ($choiceEditData as $data){ $data->delete(); }
            Quiz::deleteQuizById($quizId);

            return redirect()
            ->route('admin.index')
            ->with('flash_message', 'クイズの削除に成功しました');
        } catch (\Exception $e) {
            return redirect()
            ->route('admin.index')
            ->with('flash_message', 'Error!!:クイズの削除に失敗しました。。');
        }
    }
}