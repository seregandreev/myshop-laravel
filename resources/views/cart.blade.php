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

    <cart-component 
        :prods="{{$products}}"
        :user="{{$user}}"
        address="{{$address}}"
    >
    </cart-component>
@endsection