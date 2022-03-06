@extends('layouts.app')
@section('style')
<style>
    .category-picture {
        width: 70px;
        display: block;
        height: 70px;
    }
</style>
@endsection

@section('title')
    Список категорий
@endsection

@section('content')
<div class="container">

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

    @if(session('saveImportCategoriesFileFlash'))
    <div class='alert alert-success'>
        Файл с категориями сохранен на сервере
    </div>
    @endif

    @if(session('deleteExportCategoriesFileFlash'))
    <div class='alert alert-success'>
        Файл с категориями удален на сервере
    </div>
    @endif

    <h3>Импорт категорий</h3>
    <form method="POST" action="{{ route('saveImportCategoriesFile') }}" enctype="multipart/form-data">
        <div class="row mb-3">
        @csrf
        <div class="col-6">
            <input type="file" class="form-control" name="importCategoriesFile">
        </div>
        <div class='col-3'>
            <button type="submit" class="btn btn-primary">Сохранить файл</button>
        </div>
    </form> 
    <div class='col-3'>
    <form method="POST" action="{{ route('importCategories') }}">
        @csrf
            <button type="submit" class="btn btn-primary">Загрузить категории</button>
        </div>
    </div>
    </form>
    <hr>
    <h3>Экспорт категорий</h3>
    <div class="row mb-3">

        <div class='col-3'>
            <form method="POST" action="{{ route('exportCategories') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Выгрузить категории</button>
            </form>
        </div>
        <div class='col-3'>
            <form method="POST" action="{{ route('downloadExportFile') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Сохранить файл на компьютер</button>
            </form>
        </div>
    </div>
    <hr>
    
    <div class='row mb-3 mt-3'>
        <div class="col-3">
            <h3>Список категорий</h3>
        </div>
        <div class='col-3'>
            <a class='btn btn-primary' href="{{ route('category.create') }}">Создать категорию</a>
        </div>
    </div>
    <hr>
    <table class='table'>
        <tr>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Миниатюра</th>
            <th>Действия</th>
        </tr>
        @if(count($categories) < 1)
        <div class="alert alert-info" role="alert">
            Не создано еще ни одной категории
          </div>
        @else
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->name }}</td>
            <td>{{ $category->description }}</td>
            <td><img class='category-picture' src="{{ asset('storage') }}/{{ $category->picture }}" alt=""></td>
            <td>
                {{-- Редактирование --}}
                <a href="{{ route('category.edit', ['id' => $category->id]) }}" class="btn btn-success col-xs" title='Редактировать'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                </a>
                    {{-- Удаление --}}
                    <a href="{{ route('category.delete', ['id' => $category->id]) }}" class="btn btn-danger col-xs" title='Удалить'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </a>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
</div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endsection