@extends('app')

@section('title', 'クイズ編集画面')

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

<!-- 内容 -->
<div class="container mt-4">
    <div class="border p-4">
        <h1 class="h4 mb-4 font-weight-bold">クイズ編集</h1>

        <form method="POST" action="{{ route('admin.change') }}" enctype="multipart/form-data">
            @csrf
            <!-- クイズ内容 -->
            <div class="form-group">
                <label for="subject">
                    クイズ内容
                </label>
                <textarea name="content" class="form-control" rows="8">{{ $quiz_edit_data->content }}</textarea>
            </div>

            @foreach($choice_edit_data as $data)
            @php
            $select = $loop->index + 1
            @endphp
            <!-- 選択肢 -->
            <div class="form-group">
                <label for="subject">
                    選択肢 {{ $select }}
                </label>
                <input id="choice{{ $select }}" type="text" name="choice{{ $select }}" class="form-control"
                    value="{{ $data->content }}">
            </div>
            @endforeach
            <br>
            <!-- 正解 -->
            <label for="correct">〜正解は何番？〜</label>
            @foreach($choice_edit_data as $data)
            @php
            $select = $loop->index + 1
            @endphp
            <div class="form-group">
                <label for="subject"></label>
                @if ($data->is_answer === 1)
                <label><input type="radio" name="answer" value="{{ $select }}" checked>
                    選択肢{{ $select }}</label>
                @else
                <label><input type="radio" name="answer" value="{{ $select }}">
                    選択肢{{ $select }}</label>
                @endif
            </div>
            @endforeach

            <!-- クイズのID -->
            <input type="hidden" name="quizId" value="{{$quiz_edit_data->id}}">

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