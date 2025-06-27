@extends('errors.layout')

@section('title', 'Слишком много запросов')
@section('code', '429')
@section('icon', '🛑')
@section('message')
    Вы отправили слишком много запросов.
    Пожалуйста, подождите некоторое время перед повторной попыткой.
@endsection
