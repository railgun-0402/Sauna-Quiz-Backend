<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\User;
use App\Http\Requests\MypageEditRequest;
use Exception;

class MyPageController extends Controller
{
    // マイページTop画面に遷移するためのメソッド
    public function top()
    {
        // ModelからIDに紐づくユーザデータ取得
        $users = new User();
        $userData = $users -> getUserDataWithID();

        return view('mypage.top', [
            'user_data' => $userData,
        ]);
    }

    // プロフィール編集画面に遷移するためのメソッド
    public function edit()
    {
        // ModelからIDに紐づくユーザデータ取得
        $users = new User();
        $userData = $users -> getUserDataWithID();

        return view('mypage.edit', [
            'user_data' => $userData
        ]);
    }

    // 画像を保存
    public function upload(Request $request)
    {
        // ディレクトリ名
        $dir = 'sample';

        // アップロードされたファイル名を取得
        $file_name = $request->file('image')->getClientOriginalName();

        // 取得したファイル名で保存
        $request->file('image')->storeAs('public/' . $dir, $file_name);

        // ファイル情報をDBに保存
        $image = new Image();
        $image->name = $file_name;

        // パス：「strage/app/public/sample」
        $image->path = 'storage/' . $dir . '/' . $file_name;
        $image->save();

        // return redirect('/mypage');
        return redirect()->route('mypage.top')->with(['image' => $image]);
    }

    // プロフィールの編集
    public function change(MypageEditRequest $request) 
    {           
        try {
            // バリデーション
            $userName = $request->name;                        // ユーザ名        
            $introduction = $request->introduction;             // 自己紹介
            $sex = $request->sex;                               // 性別                
            
            // DBに編集を反映            
            $users = new User();
            $users -> editUsersData($userName, $introduction, $sex);

            return redirect()->route('mypage.top')->with('flash_message', '編集が完了しました');
        } catch (Exception $exception) {
            print($exception);
        }
    }
}