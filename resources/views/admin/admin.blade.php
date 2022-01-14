@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
<ul>
    <li><a href="{{ route('adminUsers') }}">Пользователи</a></li>
    <li><a href="{{ route('adminProducts') }}">Продукты</a></li>
    <li><a href="{{ route('adminCategories') }}">Категории</a></li>
</ul>
@endsection