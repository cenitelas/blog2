@extends('layouts.app')
@section('content')
    <div class="d-flex align-items-center mb-3">
        <h1 class="h3 mb-0">{{$post->title}}</h1>

        <div class="ml-auto">
            <div class="d-flex align-items-center justify-content-end">
                @can('update',$post)
                    <a href="{{ route('posts.edit',$post)}}" class="btn btn-warning">
                        Редактировать
                    </a>
                @endcan
                @can('delete',$post)
                    <form action="{{route('posts.destroy',$post)}}" method="post">
                        @csrf @method('delete')
                        <button class="ml-2 btn btn-danger">
                            Удалить
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    <hr style="border-style: dotted"/>
    <div class="mb-3 text-muted d-flex">
        <div>
            Автор: {{$post->user->name}}
        </div>
        <div class="ml-3">
            Категория: {{$post->category->name}}
        </div>
        <div class="ml-auto">
            {{$post->created_at->diffForHumans()}}
        </div>
    </div>
    <div class="card card-body lead">
        {!!   nl2br($post->content) !!}
    </div>

    @if($post->image_path)
    <hr style="border-style: dotted"/>

    <img class="img-fluid" src="{{Storage::url($post->image_path)}}" alt="{{ $post->title }}"/>
    @endif
    <hr style="border-style: dotted"/>

    <div class="d-flex justify-content-end">
        @auth
            <form action="{{route('likes.toggle',$post)}}" method="post">
                @csrf @method('put')
                <button href="#" class="btn @if($post->isLikeBy(auth()->user())) btn-danger @else btn-secondary @endif">
                    {{$post->likes()->count()}} лайков
                </button>
            </form>
        @else
            <div>{{$post->likes()->count()}} лайков</div>
        @endauth
    </div>
    <div class="mt-3">
        <h1 class="h3">Оставить комментарий</h1>
        <form action="{{route('comment.create', $post)}}" method="post" class="card card-body">
            @csrf
            <div class="form-group">
                <label for="name">Сообщение</label>
                <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror " placeholder="Введите текст..."></textarea>
                @error('message')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button class="btn btn-primary">Отправить</button>
        </form>

    </div>
    <div class="mt-5">
        <h1 class="h3">Комментарии</h1>
        @foreach($post->comments->reverse() as $comment)
            <hr style="border-style: dotted"/>
            <div class="mb-3 text-muted d-flex">
                <div>
                    Пользоватеь: {{$comment->user->name}}
                </div>
                <div class="ml-auto">
                    {{$comment->created_at->diffForHumans()}}
                </div>
                @if(auth()->user()==$comment->user)
                    <form class="ml-3" action="{{ route('comment.delete', $comment) }}" method="post">
                        @csrf
                        <button class="btn btn-sm btn-danger">
                            Удалить
                        </button>
                    </form>
                @endif
            </div>
            <div class="card card-body lead">
                {!!   nl2br($comment->message) !!}
            </div>
        @endforeach
    </div>
@endsection
