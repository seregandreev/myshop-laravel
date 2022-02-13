@extends('layouts.app')
@section('style')
<style>

</style>
@endsection

@section('title')
    Добавление нового продукта
@endsection

@section('content')
<div class="container">
  
  @if ($errors->isNotEmpty())
  <div class="alert alert-danger" role="alert">
      @foreach ($errors->all() as $error)
          {{ $error }}
          @if(!$loop->last)<br> @endif
      @endforeach
  </div>
  @endif

  <div class="card-header first mb-3"><h3>Заполните информацию по новому продукту</h3><a class="card-header-link"  href="{{ route('products.index') }}"><i class="fa fa-mail-reply-all" aria-hidden="true"></i>  Вернуться к списку продуктов</a></div>
  <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label class="form-label">Наименование</label>
      <input type="text" class="form-control" id="name" name="name">
    </div>
    <div class="mb-3">
      <label class="form-label">Описание</label>
      <textarea name="description" class="form-control" id="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Цена</label>
        <input type="text" class="form-control" id="price" name="price">
    </div>
    <div class="mb-3">
        <label class="form-label">Категория</label>
        <select class="form-control" name="category_id" id="category_id">
            <option selected disabled>-- Выберите категорию --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Миниатюра</label>
      <input class="form-control" type="file" name="picture" id="picture">
    </div>
    <div class="col-12 text-end">
      <button type="submit" class="btn btn-primary btn-lg">Сохранить</button>
    </div>
  </form>
</div>

@endsection