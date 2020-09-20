<div class="card card-body mb-3">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('posts.show', $post) }}">
            <h2 class="h5 mb-0">{{ $post->title }}</h2>
        </a>

        <div class="d-flex align-items-center justify-content-end">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}" class="mt-3 btn btn-warning btn-sm">
                    Редактировать
                </a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf @method('delete')
                    <button class="ml-2 mt-3 btn btn-danger btn-sm">
                        Удалить
                    </button>
                </form>
            @endcan
        </div>
    </div>

    @if($post->image_path)
        <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="img-fluid my-3 rounded">
    @else
        <hr style="border-style: dashed;" />
    @endif

    <div class="text-muted d-flex align-items-center">
        <a href="{{route('category.posts',$post->category)}}" class="badge badge-secondary mr-3">
            {{ $post->category->name }}
        </a>
        <div>
            <a href="{{route('user.posts',$post->user)}}">{{ $post->user->name }}</a>
        </div>
        <div class="ml-auto">
            {{ $post->created_at->diffForHumans() }}
        </div>
    </div>

    <hr style="border-style: dashed;" />

    <p class="mb-0">{{ Str::words($post->content, 22) }}</p>

    <div class="text-right">
        <a class="btn btn-primary" href="{{route('posts.show',$post)}}">Подробнее</a>
    </div>
</div>
