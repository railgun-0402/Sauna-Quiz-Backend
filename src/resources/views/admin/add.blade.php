@extends('app')

@section('title', 'クイズ新規追加')

@section('content')
@include('header')
@php
$choices = array(
"choice1",
"choice2",
"choice3",
"choice4"
);
@endphp

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


<!-- 内容 -->
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">クイズを追加する(入力は全て必須です)</h1>

        <form method="POST" action="{{ route('admin.create') }}" enctype="multipart/form-data">
            @csrf
            <!-- クイズ内容 -->
            <div class="form-group">
                <label for="subject">
                    クイズ内容
                </label>
                <textarea name="content" class="form-control" rows="8"></textarea>
            </div>

            <!-- 選択肢 -->
            @foreach ($choices as $choice)
            @php $choice_num = $loop->index + 1 @endphp
            <div class="form-group">
                <label for="subject">
                    選択肢{{ $choice_num }}
                </label>
                <input id="choice{{$choice_num}}" type="text" name="choice{{$choice_num}}" class="form-control"
                    value="">
            </div>
            @endforeach
            <br>

            <!-- 正解選択ラジオボタン -->
            <label for="correct">〜正解は何番？〜</label>
            @foreach ($choices as $choice)
            @php $choice_num = $loop->index + 1 @endphp
            <div class="form-group">
                <label for="subject"></label>
                <label><input type="radio" name="answer" value="{{ $choice_num }}">
                    選択肢{{ $choice_num }}</label>
            </div>
            @endforeach

            <!-- カテゴリ選択プルダウン -->
            <label for="correct">〜カテゴリ選択〜</label><br>
            <select name="category">
                <option value="">カテゴリを選択してください</option>
                @foreach($category_data as $data)
                <option value="{{ $loop->index + 1 }}">{{ $data->name }}</option>
                @endforeach
            </select><br><br>

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
    return confirm("クイズを追加します。\nよろしいですか？");
}
</script>
@endsection