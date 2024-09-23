<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 管理者権限：管理画面へ遷移
        if (\Gate::allows('admin')) {
            return redirect(route('admin.index'));
        }

        // 一般ユーザー権限：ホーム画面に遷移
        return view('index');
    }
}
