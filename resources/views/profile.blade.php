@extends('layouts.app')

@section('style')
<style>
    .user-picture {
        width: 100px;
        display: block;
        height: 100px;
        border-radius: 100px;
    }

    .main-address {
        font-size: bold;
    }
</style>
@endsection

@section('title')
    Профиль пользователя
@endsection

@section('content')

    @if ($errors->isNotEmpty())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}
                @if(!$loop->last)<br> @endif
            @endforeach
        </div>
    @endif

<form action="{{ route('saveProfile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="userId">
    <div class="mb-3">
        <label class="form-label">Изображение</label>
        <img class="user-picture mb-2" src="{{ asset('storage') }}/{{ $user->picture }}" alt="">
        <input type="file" class="form-control" name="picture">
    </div>
    <div class="mb-3">
        <label class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Почта</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Список адресов</label>
        <ul>
            @forelse ($user->addresses as $address)
                <li class="@if($address->main) b5 text-primary @endif">
                    {{ $address->address }}
                </li>
            @empty
                <em>Нет адресов</em>
            @endforelse
        </ul>
    </div>
    <div class="mb-3">
        <label class="form-label">Новый адрес</label>
        <input type="text" class="form-control" name="new_address" >
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection


