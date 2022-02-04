@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')

<div class='conteiner'>
    <ul>
        <li><a href="{{ route('adminUsers') }}">Пользователи</a></li>
        <li><a href="{{ route('adminProducts') }}">Продукты</a></li>
        <li><a href="{{ route('categories.index') }}">Категории</a></li>
    </ul>
    
    @if(session('starImportCategories'))
    <div class='alert alert-success'>
        Загрузка категорий запущена
    </div>
    @endif

    @if(session('starExportCategories'))
    <div class='alert alert-success'>
        Выгрузка категорий запущена
    </div>
    @endif

        <div class='row mt-3'>
            <div class='col-3'>
                <form method="POST" action="{{ route('importCategories') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Загрузить категории</button>
                </form>
            </div>
            <div class='col-3'>
                <form method="POST" action="{{ route('exportCategories') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Выгрузить категории</button>
                </form>
            </div>
        </div>
</div>

@endsection