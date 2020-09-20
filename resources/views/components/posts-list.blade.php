@if($posts->isNotEmpty())

    @foreach($posts as $post)
        @include('components.post-card')
    @endforeach

    {{ $posts->links() }}

@else
    <div class="alert alert-secondary">
        Постов нет :(
    </div>
@endif
