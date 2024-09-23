<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/*
* ホーム
*/
// ホーム
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


/*
* クイズ出題系ページ(QuizController)
*/
// クイズ画面(ホームでクイズ回答ボタンを押下した場合に遷移)
Route::get('/quiz', [App\Http\Controllers\QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz/submit', [App\Http\Controllers\QuizController::class, 'submit'])->name('quiz.submit');


/*
* マイページ関連(MyPageController)
*/
Route::middleware('auth')->group(function () {
    // マイページTop画面
    Route::get('/mypage', [App\Http\Controllers\MyPageController::class, 'top'])->name('mypage.top');
    // プロフィール編集画面
    Route::get('/mypage/edit', [App\Http\Controllers\MyPageController::class, 'edit'])->name('mypage.edit');
    // アイコン設定/変更
    Route::post('/upload', [App\Http\Controllers\MyPageController::class, 'upload'])->name('mypage.upload');
    // プロフィール編集
    Route::post('/mypage/edit/change', [App\Http\Controllers\MyPageController::class, 'change'])->name('mypage.change');
});


/*
* 管理画面関連(AdminController)
*/
// 管理画面Top
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
});
// クイズ管理
Route::get('/admin/quiz', [App\Http\Controllers\AdminController::class, 'list'])->name('admin.list');
// クイズ編集
Route::get('/admin/quiz/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
// クイズ編集実行
Route::post('/admin/quiz/change', [App\Http\Controllers\AdminController::class, 'change'])->name('admin.change');
// クイズ新規作成
Route::get('/admin/quiz/add', [App\Http\Controllers\AdminController::class, 'add'])->name('admin.add');
// クイズ作成実行
Route::post('/admin/quiz/create', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
// クイズ削除実行
Route::get('/admin/quiz/delete', [App\Http\Controllers\AdminController::class, 'delete'])->name('admin.delete');