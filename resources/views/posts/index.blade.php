@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center mb-3">

        <h1 class="h3 mb-0">
            Посты
        </h1>

        @can('create', App\Models\Post::class)
            <a href="{{ route('posts.create') }}" class="ml-auto btn btn-success">
                Добавить пост
            </a>
        @endcan

    </div>

    <div class="row">

        <div class="col-md-9">

            @include('components.posts-list')

        </div>

        <div class="col-md-3">

        </div>

    </div>

@endsection
