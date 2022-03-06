@extends('layouts.app')

@section('content')

@auth

@endauth
<categories-component 
    page-title="Категории"
    :categories="{{$categories}}"
    route-category="{{route('category', '')}}"
>
</categories-component>

<!--  <div class="row">
        @foreach ($categories as $category)
        <div class="col-3">
            <div class="card mb-3" style="width: 15rem; height: 25rem;">
                <img src="{{ asset('storage') }}/{{$category->picture}}" class="card-img-top" alt="{{$category->name}}" style="height: 200px">
                <div class="card-body">
                    <h5 class="card-title">
                        {{$category->name}}
                    </h5>
                    <p class="card-text">
                        {{ $category->description }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('category', $category->id) }}" class="btn btn-primary w-100">Перейти</a>
                </div>
            </div>
        </div>

        @endforeach
    </div> -->
@endsection
