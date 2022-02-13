@extends('layouts.app')
@section('style')
<style>
    .product-picture {
        width: 70px;
        display: block;
        height: 70px;
    }
</style>
@endsection

@section('title')
    Список продуктов
@endsection

@section('content')
<div class="container">
    <h2>Список продуктов</h2>
    <div class='row'>
        <div class='col-3'>
            <a class='btn btn-primary' href="{{ route('product.create') }}">Добавить новый продукт</a>
        </div>
    </div>
    <hr>
    <table class='table'>
        <tr>
            <th class="col-3">Наименование</th>
            <th class="col-3">Описание</th>
            <th>Цена</th>
            <th>Категория</th>
            <th>Миниатюра</th>
            <th>Действия</th>
        </tr>
        @if(count($products) < 1)
        <div class="alert alert-info" role="alert">
            Не создано еще ни одного продукта
          </div>
        @else
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->categories()->name }}</td>
            <td><img class='product-picture' src="{{ asset('storage') }}/{{ $product->picture }}" alt=""></td>
            <td>
                {{-- Редактирование --}}
                <a href="{{ route('product.edit', ['id' => $product->id]) }}" class="btn btn-success col-xs" title='Редактировать'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                </a>
                {{-- Удаление --}}
                <a href="{{ route('product.delete', ['id' => $product->id]) }}" class="btn btn-danger col-xs" title='Удалить'>
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