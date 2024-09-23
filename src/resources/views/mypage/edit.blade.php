@extends('app')

@section('title', 'プロフィール編集画面')

@section('content')
@include('header')
<!-- バリデーションエラー表示領域 -->
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- 画面正常領域 -->
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold .float-right">プロフィール編集</h1>

        <form method="POST" action="{{ route('mypage.change') }}" enctype="multipart/form-data">
            @csrf
            <!-- ユーザ名 -->
            <div class="form-group">
                <label for="subject">
                    ユーザ名
                </label>
                <input id="name" type="text" name="name" class="form-control" value="{{ $user_data->name }}">
            </div>

            <!-- 自己紹介 -->
            <div class="form-group">
                <label for="subject">
                    自己紹介 (200文字以内)
                </label>
                <textarea name="introduction" class="form-control" rows="8">{{ $user_data->introduction }}</textarea>
            </div>

            <!-- 性別 -->
            <div class="form-group">
                <label for="subject">
                    性別：
                </label>
                <br>
                <label><input type="radio" name="sex" value="{{ config('user_sex.man') }}" @if ($user_data->sex ===
                    config('user_sex.man'))
                    checked @endif> 男性</label>
                <label><input type="radio" name="sex" value="{{ config('user_sex.woman') }}" @if ($user_data->sex ===
                    config('user_sex.woman'))
                    checked @endif> 女性</label>
                <label><input type="radio" name="sex" value="{{ config('user_sex.others') }}" @if ($user_data->sex ===
                    config('user_sex.others'))
                    checked @endif> その他</label>
            </div>

            <!-- 実行ボタン -->
            <button type="submit" class="btn btn-primary" onclick="showConfirmation()">
                編集実行
            </button>
        </form>
    </div>
</div>

<script>
// 編集実行ボタン押下時にダイアログを表示
function showConfirmation() {
    return confirm("編集を実行します。\nよろしいですか？");
}
</script>
@endsection