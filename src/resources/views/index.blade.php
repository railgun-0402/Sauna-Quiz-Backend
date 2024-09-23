@extends('app')

@section('title', 'ホーム')

@section('content')
@include('header')
@include('sidebar')
<sauna-quiz></sauna-quiz>
@endsection
