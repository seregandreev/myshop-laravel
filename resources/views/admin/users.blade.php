@extends('layouts.app')

@section('title')
    Список пользователей
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

    <h1>Список ролей</h1>
    <table class="table table-bordered mb-4">
        <thead>
            <tr>
                <th>№</th>
                <th>Наименование</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $idx => $role)
            <tr>
                <td>{{$idx + 1}}</td>
                <td>{{$role->name}}</td>
                <td>
                    {{-- Удаление --}}
                    <a href="{{ route('deleteRole', ['id' => $role->id]) }}" class="btn btn-danger col-xs" title='Удалить'>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">Нет ролей</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Новая роль</h3>
    <form action="{{ route('addRole') }}" method="POST" class="mb-4">
        @csrf
        <input type="text" class="form-control mb-2" name="name">
        <button type="submit" class="btn btn-success" >Добавить</button>
    </form>

    <h3>Добавление роли пользователю</h3>
    <form action="{{ route('addRoleToUser') }}" method="POST" class="mb-4">
        @csrf
        <select name="user_id" class="mb-2 form-control">
            <option disabled selected>-- Выберите пользователя --</option>
            @foreach ($users as $user)
                <option value="{{ $user->id}}">{{ $user->name }}</option>
            @endforeach
        </select>
        <select name="role_id" class="mb-2 form-control">
            <option disabled selected>-- Выберите роль --</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id}}">{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-success" >Добавить</button>
    </form>

    <h1>
        {{ $title }}
    </h1>

    <table class="table table-border">
        <thead>
            <tr>
                <th>#</th>
                <th>Имя</th>
                <th>Почта</th>
                <th>Роли</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <ul>
                            @foreach ($user->roles as $role)
                                <li>{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('enterAsUser', $user->id) }}">Войти</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection