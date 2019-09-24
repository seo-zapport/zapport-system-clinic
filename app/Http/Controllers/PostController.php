<?php

namespace App\Http\Controllers;

use App\Post;
use App\Media;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $posts = Post::where('user_id', auth()->user()->id)
                         ->where('title', 'like', '%'.$request->search.'%')
                         ->orderBy('id', 'desc')
                         ->paginate(10);
            $posts->appends(['search' => $request->search]);
            $search = $request->search;
            return view('posts.index', compact('posts', 'search'));
        }else{
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $employees = Media::where('file_name', '!=', NULL)->where('user_id', auth()->user()->id)->get();
            return view('posts.create', compact('employees'));
        }else{
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validated();
            auth()->user()->published(
                new Post($atts)
            );

            $lastID = Post::where('user_id', auth()->user()->id)->get()->last();

            return redirect()->route('post.show', ['post' => $lastID->title]);
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $employees = Media::where('file_name', '!=', NULL)->where('user_id', auth()->user()->id)->get();
            return view('posts.edit', compact('post', 'employees'));
        }else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $atts = $request->validated();
        $post->update($atts);
        return redirect()->route('post.show', ['post' => $post->title]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return redirect()->route('post.index');
    }
}