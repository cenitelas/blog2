<?php
$post = $post ?? null;
?>

@extends('layouts.app')

@section('content')

    <h1 class="h3">{{ $post ? 'Ред. поста' : 'Новый пост' }}</h1>

    <div class="row">

        <div class="col-md-5">

            <form enctype="multipart/form-data" action="{{ $post ? route('posts.update', $post) : route('posts.store') }}"
                  class="card card-body" method="post">
                @csrf @if($post) @method('put') @endif

                <div class="form-group">
                    <label for="title">Заголовок</label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title', $post->title ?? null) }}"
                           class="form-control @error('title') is-invalid @enderror "
                           placeholder="Введите заголовок...">

                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="image">Изображение</label>

                    <div class="custom-file">
                        <input accept=".jpg,.jpeg,.png,.webp" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                        <label class="custom-file-label" for="image">Выберите изображение...</label>
                        @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                </div>
                <div class="form-group">
                    <label for="category_id">Категория</label>
                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                        @foreach($categories as $category)
                            <option {{ old('category_id', $post->category_id ?? null) == $category->id ? 'selected' : '' }}
                                    value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Пост</label>
                    <textarea class="form-control"
                              name="content"
                              id="content"
                              rows="10"
                              placeholder="Напишите что-нибудь великое...">{{ old('content', $post->content ?? null) }}</textarea>
                </div>

                <button class="btn btn-success">{{ $post ? 'Обновить' : 'Добавить' }}</button>

            </form>

        </div>

    </div>

@endsection
