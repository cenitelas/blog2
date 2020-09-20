<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected function byModel(Model $model,$view=null){
            $posts = $model->posts()
                ->join('categories', 'posts.category_id', '=', 'categories.id')
                ->where('categories.enable', '=','1')
                ->select('posts.*')
                ->latest()
                ->paginate(3);
            $table = $model->getTable();
            $single = Str::singular($table);
        return view($view ?? "posts.by-$single",[
            'posts'=> $posts,
            $single =>$model
        ]);
    }

    public function byCategory(Category $category){
       return $this->byModel($category);
    }

    public function byUser(User $user){
        return $this->byModel($user);
    }
    public function index()
    {
//        $this->authorize('view-any', Post::class);
        $posts = Post::query()
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->where('categories.enable', '=','1')
            ->select('posts.*')
            ->latest()
            ->paginate(3);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return view('posts.form', [
            'categories' => auth()->user()->categories
        ]);
    }

    public function store(PostFormRequest $request)
    {
        $this->authorize('create', Post::class);

        $post = auth()->user()
            ->posts()
            ->create($this->getData($request));

        return redirect()->route('posts.show', $post);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);;
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.form', [
            'post' => $post,
            'categories' => auth()->user()->categories
        ]);
    }

    public function update(PostFormRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $post->update($this->getData($request));
        return redirect()->route('posts.show', $post);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('posts.index');
    }

    protected function uploadImage(PostFormRequest $request){
        if(!$request->hasFile('image'))
            return null;

        return $request->file('image')->store('public/images');
    }

    protected function getData(PostFormRequest $request){
        $data = $request->validated();
        $data['image_path'] = $this->uploadImage($request);
        unset($data['image']);
        return $data;
    }
}
