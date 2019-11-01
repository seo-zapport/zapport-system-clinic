<?php

namespace App\Http\Controllers;

use App\Tag;
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
            $tags = Tag::get();
            $employees = Media::where('file_name', '!=', NULL)->where('user_id', auth()->user()->id)->get();
            return view('posts.create', compact('employees', 'tags'));
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
        // dd($request->all());
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validated();
            $atts = $request->except('tag_id');
            $srch = Post::where('title', $request->title)->get();
            $replaced = str_replace(' ', '-', $request->title);
            if (count($srch ) > 0) {
                $count = count($srch)+1;
                $atts['slug'] = $replaced.'-'.$count;
            }else{
                $atts['slug'] = $replaced;
            }
            auth()->user()->published(
                new Post($atts)
            );

            $lastID = Post::where('user_id', auth()->user()->id)->get()->last();
            $tagID = $request->input('tag_id');
            $tag = Tag::find($tagID);
            $array_atts = array();
            foreach ($tagID as $tagsID) {
                $attsPivot['tag_id']  = $tagsID;
                $array_atts[]         = $attsPivot;
            }
            foreach ($array_atts as $finalAtts) {
                $lastID->tags()->attach($finalAtts);
            }
            // $tag->posts()->attach($lastID);

            return redirect()->route('post.show', ['post' => $lastID->slug]);
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
            $tags = Tag::get();
            $arr = array();
            foreach ($post->tags as $tag) {
                $arr[] = $tag->id;
            }
            foreach ($post->tags as $postTags) {
                $postTags;
            }
            $uniqueTag =  Tag::whereNotIn('id', $arr)->get();
            return view('posts.edit', compact('post', 'employees', 'tags', 'postTags', 'uniqueTag'));
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
    public function update(Request $request, Post $post)
    {
        // dd($request->all());
        $this->authorize('update', $post);
        $atts = $request->validate([
            'title'        =>  'required',
            'description'  =>  'required',
        ]);
        $atts = $request->except(['tag_id', 'tag_old']);
        // dd($atts);
        $post->update($atts);

        $tagID = $request->input('tag_id');
        $tag = Tag::find($tagID);
        if (!empty($tag)) {
        $array_atts = array();
            foreach ($tagID as $tagsID) {
                $attsPivot['tag_id']  = $tagsID;
                $array_atts[]         = $attsPivot;
            }
            foreach ($array_atts as $finalAtts) {
                $post->tags()->attach($finalAtts);
            }
        }
        // $post->tags()->updateExistingPivot($request->tag_old, array('tag_id' => $request->tag_id));
        return redirect()->route('post.show', ['post' => $post->slug]);
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

    public function searchImg(Request $request, $ft_id)
    {
        if ($request->ajax()) {
            $searchID = Media::find($ft_id);
            $info = pathinfo($searchID->file_name);
            $bytes = filesize('storage/uploaded/media/'.$searchID->file_name);
            list($width, $height) = getimagesize('storage/uploaded/media/'.$searchID->file_name);
            if ($bytes >= 1024){
                $bytes = number_format($bytes / 1024, 2). 'KB';
            }elseif($bytes >= 1048576){
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            $searchID['fileType'] = $info['extension'];
            $searchID['filesize'] = $bytes;
            $searchID['dimension'] = $width . ' x ' . $height;
            return response()->json($searchID);
        }
    }
}
