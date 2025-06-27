@extends('errors.layout')

@section('title', 'Сервис временно недоступен')
@section('code', '503')
@section('icon', '🔧')
@section('message')
    Сервис временно недоступен из-за технических работ или большой нагрузки.
    Пожалуйста, попробуйте снова позже.
@endsection
