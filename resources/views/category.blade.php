@extends('layouts.app')

@section('styles')
<style>
    .product-price {
        border-bottom: 1px solid grey;
        font-size: 23px;
        text-align: center;
        margin-bottom: 10px;
    }
    .card-text {
        height: 46px;
    }
    .product-buttons {
        display: flex;
        justify-content: space-between;
        line-height: 37px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach ($products as $product)
        <div class="col-3">
            <div class="card mb-4" style="width: 18rem;">
                <img src="{{ asset('storage') }}/{{$product->picture}}" class="card-img-top" alt="{{$product->name}}">
                <div class="card-body">
                    <h5 class="card-title">
                        {{$product->name}}
                    </h5>
                    <p class="card-text">
                        {{ $product->description }}
                    </p>
                    <div class="product-price">
                        {{ $product->price }} руб.
                    </div>
                    <hr>
                    <div class="row product-buttons">
                        <div class='col-4 text-center'>
                            <form action="{{ route('removeFromCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name='id' value='{{ $product->id }}'>
                                <button @empty(session("cart.$product->id")) disabled @endempty class="btn btn-danger">-</button>
                            </form>
                        </div>
                        <div class='col-4 text-center'>
                            {{ session("cart.$product->id") ?? 0 }}
                        </div>
                        <div class='col-4 text-center'>
                            <form action="{{ route('addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name='id' value='{{ $product->id }}'>
                                <button class="btn btn-success">+</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection