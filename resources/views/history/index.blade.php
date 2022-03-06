@extends('layouts.app')

@section('styles')
<style>

</style>
@endsection

@section('content')
<h3>История заказов</h3>
<hr>
<!--
<history-orders-component 
    :orders="{{$orders}}">
</history-orders-component>
-->
        @if(count($orders) < 1)
            <div class="alert alert-info" role="alert">
                В истории заказов пусто
            </div>
        @else
        
    @foreach ($orders as $order)
        <div class="accordion accordion-flush" id="accordionExample">
        <table class="table table-bordered col-12 text-center">
            <tr>
                <td class="accordion-item">
                  <h2 class="accordion-header" id="flush-heading{{$order->id}}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$order->id}}" aria-expanded="false" aria-controls="flush-collapse{{$order->id}}">
                        {{$order->id}}
                    </button>
                  </h2>
                </td>
                <td>{{$order->created_at->format('d.m.Y H:i')}}</td>
                <td>
                    <form method="post" action="{{ route('replayToCart') }}">
                        @csrf
                        <input name='orderId' hidden value="{{ $order->id }}">
                        <button class="btn btn-success">Повторить заказ</button>
                    </form>
                </td>
            </tr>
        </table>
              <div id="flush-collapse{{$order->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$order->id}}" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Цена</th>
                                <th>Кол-во</th>
                            </tr>
                    </thead>
                    <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <input name='id' hidden value="{{ $product->id }}">
                        <tr>
                            <td><input name='name' hidden value="{{ $product->name }}">{{$product->name}}</td>
                            <td><input name='price' hidden value="{{ $product->pivot->price }}">{{$product->pivot->price}}</td>
                            <td><input name='quantity' hidden value="{{ $product->pivot->quantity }}">{{$product->pivot->quantity}}</td>
                        </tr>
                    </tr>
                @endforeach   
    </tbody>
</table>
</div>
</div>
</div>
@endforeach
@endif

@endsection