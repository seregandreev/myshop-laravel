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
            <div class="card mb-4" style="width: 15rem; height: 25rem;">
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
                    <div class="product-buttons">
                        <button class="btn btn-danger">-</button>
                        0
                        <button class="btn btn-success">+</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection