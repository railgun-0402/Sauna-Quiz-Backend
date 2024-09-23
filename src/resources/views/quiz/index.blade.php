@extends('app')

@section('title', 'クイズ')

@section('content')
    @include('header')
    @include('sidebar')
    <quiz-index
        :quiz="{{ json_encode($quiz) }}"
        :choices="{{ json_encode($choices) }}"
    />
@endsection
