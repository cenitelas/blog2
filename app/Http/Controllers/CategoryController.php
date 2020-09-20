<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;

class CategoryController extends Controller
{

    public function index(User $user)
    {

        $categories = $user->categories()->get();

        return view('categories.index', [
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function create()
    {
        $this->authorize('create', Category::class);
        return view('categories.form');
    }

    public function store()
    {

        $this->authorize('create', Category::class);
        $data = $this->validated();
        if(!isset($data['enable']))
            $data['enable']=0;
        /** @var User $user */
        $user = auth()->user();
        $user->categories()->create($data);

        return redirect()->route('categories.index', $user);
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('categories.form', [
            'category' => $category
        ]);
    }

    public function update(Category $category)
    {
        $this->authorize('update', $category);

        $data = $this->validated();
        if(!isset($data['enable']))
            $data['enable']=0;
        $category->update($data);
        return redirect()->route('categories.index', auth()->user());
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();
        return back();
    }

    protected function validated() {
        return request()->validate([
            'name' => 'required|string|min:5',
            'enable' => 'boolean'
        ]);
    }

}
