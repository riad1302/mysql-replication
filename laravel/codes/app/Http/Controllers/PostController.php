<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {

        $posts = Post::latest()->paginate(5);
        return view('post.index',compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function add(): View
    {
        return view('post.add');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Post::create($request->all());

        return redirect()->route('post.index')
            ->with('success','Post created successfully.');
    }
}
