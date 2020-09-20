<?php
$category = $category ?? null;
?>
@extends('layouts.app')

@section('content')

    <h1 class="h3 mb-3">
        {{ $category ? 'Ред. категорию' : 'Новая категория' }}
    </h1>

    <div class="row">
        <div class="col-md-4">

            <form
                action="{{ $category ? route('categories.update', $category) : route('categories.store') }}"
                method="post" class="card card-body">
                @csrf
                @if($category)
                    @method('put')
                @endif

                <div class="form-group">
                    <label for="name">Название</label>
                    <input required value="{{ old('name', $category->name ?? null) }}" id="name" name="name" type="text"
                           class="form-control @error('name') is-invalid @enderror " placeholder="Введите имя...">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label  for="enable">Активность</label>

                    <input value="1" {{ old('enable', $category->enable ?? false ? 'checked' : '') }} id="enable" name="enable" type="checkbox"
                           class="ml-2 form-check-input @error('enable') is-invalid @enderror ">
                    @error('enable')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <button class="btn btn-primary">{{ $category ? 'Обновить' : 'Добавить' }}</button>

            </form>

        </div>
    </div>

@endsection
