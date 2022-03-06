@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')

    <ul class="list-group">
        <li class="list-group-item"><a href="{{ route('adminUsers') }}">
            <i class="bi bi-people-fill"></i>Пользователи</a>
        </li>
        <li class="list-group-item"><a href="{{ route('products.index') }}">Продукты</a></li>
        <li class="list-group-item"><a href="{{ route('categories.index') }}">Категории</a></li>
    </ul>


@endsection