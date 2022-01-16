@extends('layouts.app')

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

<form action="{{ route('saveProfile') }}" method="POST">
    @csrf
    <input type="hidden" value="{{ $user->id }}" name="userId">
    <div class="mb-3">
        <label class="form-label">Имя</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}">
      </div>
    <div class="mb-3">
        <label class="form-label">Почта</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}">
      </div>
      <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection