<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class SiteController extends Controller
{

    public function index() {


        return view('index', [
            'categories' => $categories ?? []
        ]);
    }

    function about() {
        return view('about');
    }

}
