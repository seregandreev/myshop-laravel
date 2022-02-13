@extends('layouts.app')


@section('styles')
<style>
    .product-buttons {
        display: flex;
        justify-content: space-evenly;
        line-height: 37px;
    }
</style>
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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
            @php
                $summ = 0;
            @endphp
            @forelse ($products as $idx => $product)
                @php
                    $productSumm = $product->price * $product->quantity;
                    $summ += $productSumm;
                @endphp
                <tr>
                    <td>{{$idx + 1}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td class="product-buttons">
                        <form method="post" action="{{ route('removeFromCart') }}">
                            @csrf
                            <input name='id' hidden value="{{ $product->id }}">
                            <button @empty($product->quantity) disabled @endempty class="btn btn-danger">-</button>
                        </form>
                            {{ $product->quantity }}   
                        <form method="post" action="{{ route('addToCart') }}">
                            @csrf
                            <input name='id' hidden value="{{ $product->id }}">
                            <button class="btn btn-success">+</button>
                        </form>
                    </td>
                    <td>
                        {{ $productSumm }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">
                        Корзина пока пуста, начните <a href="{{route('home')}}">покупать!</a>
                    </td>
                </tr>
            @endforelse
                <tr>
                    <td colspan="4" class="text-end">Итого:</td>
                    <td>
                        <strong>
                        {{ $summ }}
                        </strong>
                    </td>
                </tr>
        </tbody>
    </table>
    @if($summ)
        <form action="{{ route('createOrder') }}" method="POST">
            @csrf
            <input type="text" class='form-control mb-2' name="name" value="{{ $user->name ?? '' }}" placeholder="Имя">
            <input type="text" class='form-control mb-2' name="email" value="{{ $user->email ?? '' }}" placeholder="e'mail">
            <input type="text" class='form-control mb-2' name="address" value="{{ $address }}" placeholder="Адрес">
            <input id='register_confirmation' name='register_confirmation' type="checkbox">
            <!-- не забудьте добавить оферту -->
            <label for="register_confirmation">Вы будете автоматически зарегистрированы</label>
            <br>
            <button type="submit" class="btn btn-success">Оформить заказ</button>
        </form>
    @endif
@endsection