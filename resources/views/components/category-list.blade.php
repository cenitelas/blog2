<div class="card">

    <div class="list-group list-group-flush">
        @foreach($categories as $category)
            <a href="{{ route('category.posts',$category) }}" class="list-group-item list-group-item-action">
                {{$category->name}}
            </a>
        @endforeach
    </div>
</div>
