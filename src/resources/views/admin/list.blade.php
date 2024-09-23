@extends('app')

@section('title', 'クイズ一覧')

@section('content')
@include('header')
<!DOCTYPE html>
<html>

<head>
    <title>クイズ作成管理画面</title>
</head>

<body>
    <!-- モーダルウィンドウの中身 -->
    @if(Session::has('flash_message'))
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script>
    //ページ読み込み後、モーダルを実行
    $(window).on('load', function() {
        $('#modal_box').modal('show');
    });
    </script>

    <!-- モーダルウィンドウの中身 -->
    <div class="modal fade" id="modal_box" tabindex="-1" role="dialog" aria-labelledby="label1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label1">クイズ編集確認</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('flash_message') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- ページ内容 -->
    <center>
        <h1 class="my-3 ml-3">クイズ作成管理画面</h1>

        <div class="col-5 ml-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>作成日時</th>
                        <th>更新日時</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                </thead>
                @foreach($quiz_data as $data)
                <tbody>
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->content}}</td>
                        <td>{{$data->created_at}}</td>
                        <td>{{$data->updated_at}}</td>
                        <td>
                            <a href="{{ route('admin.edit', ['id' => $data->id]) }}"
                                class="btn btn-success btn-sm">編集</a>
                        </td>
                        <td>
                            <a href="{{ route('admin.delete', ['id' => $data->id]) }}" class="btn btn-danger btn-sm"
                                onclick="handleButtonClick()">削除</a>
                        </td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </center>
</body>

</html>

<script>
// 削除実行ボタン押下時にダイアログを表示
function showConfirmation() {
    return confirm("選択したクイズを削除します。\nよろしいですか？");
}
</script>
@endsection