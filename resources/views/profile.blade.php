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
    @if (session('deleteAddress'))
    <div class="alert alert-success" role="alert">
        Адрес успешно удален
    </div>
@endif

<form action="{{ route('saveProfile') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="userId">
    <div class="mb-3">
        <label class="form-label">Аватар</label>
        <img class="user-picture mb-2" src="{{ asset('storage') }}/{{ $user->picture }}" alt="">
        <input type="file" class="col-6 form-control" name="picture">
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <label class="form-label">Имя</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}">
        </div>
        <div class="col-6">
            <label class="form-label">Почта</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}">
        </div>
    </div>
    <div class="mb-3 col-6">
        <label class="form-label">Текущий пароль</label>
        <input type="password" class="form-control" name="current_password">
    </div>
    <div class="mb-3 col-6">
        <label class="form-label">Новый пароль</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="mb-3 col-6">
        <label class="form-label">Повторите новый пароль</label>
        <input type="password" class="form-control" name="password_confirmation">
    </div>
    <div class="col-6 mb-3">
        <label class="form-label">Список адресов</label><br>
        <table class="table table-bordered text-center">
            @forelse ($user->addresses as $address)
                <tr>
                    <td>
                        <input @if($address->main) checked @endif name="main_address" id="main_address{{$address->id}}" type="radio" value="{{ $address->id }}" class="form-check-input">
                    </td>
                    <td> 
                        <label for="main_address{{$address->id}}" class="form-check-label @if($address->main) b5 text-primary @endif">{{ $address->address }}</label>
                    </td>
                    <td>
                        <a href="{{route('deleteAddress', $address->id)}}">🗑️</a>
                    </td>
                @empty
                    <td colspan="2">
                        <em>Нет адресов</em>
                    </td>
                </tr>
                @endforelse
        </table>

    </div>
    <div class="mb-2">
        <label class="form-label">Новый адрес</label>
        <input type="text" class="form-control" name="new_address" >
    </div>
    <div class="form-check form-switch mb-4">
        <input name="mainAddrUser" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
        <label class="form-check-label" for="flexSwitchCheckDefault">Будет основным адресом</label>
      </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection


