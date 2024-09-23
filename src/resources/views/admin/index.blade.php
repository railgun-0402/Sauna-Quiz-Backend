@extends('app')

@section('title', '管理画面Top')

@section('content')
@include('header')
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
                <h5 class="modal-title" id="label1">クイズ追加通知</h5>
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
<admin-top></admin-top>
@endsection