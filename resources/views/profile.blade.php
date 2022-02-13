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

    @if (session('saveProfileFlash'))
        <div class="alert alert-success" role="alert">
            Профиль успешно сохранен
        </div>
    @endif

<form action="{{ route('saveProfile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="userId">
    <div class="mb-3">
        <label class="form-label">Аватар</label>
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
        <label class="form-label">Текущий пароль</label>
        <input type="password" class="form-control" name="current_password">
    </div>
    <div class="mb-3">
        <label class="form-label">Новый пароль</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="mb-3">
        <label class="form-label">Повторите новый пароль</label>
        <input type="password" class="form-control" name="password_confirmation">
    </div>
    <div class="mb-3">
        <label class="form-label">Список адресов</label>
            @forelse ($user->addresses as $address)
            <br>
                <input @if($address->main) checked @endif name="main_address" id="main_address{{$address->id}}" type="radio" value="{{ $address->id }}" class="form-check-input">
                <label for="main_address{{$address->id}}" class="form-check-label @if($address->main) b5 text-primary @endif">{{ $address->address }}</label>
            @empty
                <em>Нет адресов</em>
            @endforelse

    </div>
    <div class="mb-3">
        <label class="form-label">Новый адрес</label>
        <input type="text" class="form-control" name="new_address" >
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection


