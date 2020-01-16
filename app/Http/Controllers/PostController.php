<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Requests\PostRequest;
use App\Media;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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

            $class = ( request()->is('posts*') ) ?'admin-post' : '';//**add Class in the body*/
            
            return view('posts.index', compact('class', 'posts', 'search'));
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
            $tags = Tag::orderBy('tag_name', 'asc')->get();
            $employees = Media::where('file_name', '!=', NULL)->where('user_id', auth()->user()->id)->get();

            $class = ( request()->is('posts*') ) ?'admin-post' : '';//**add Class in the body*/

            return view('posts.create', compact('class','employees', 'tags'));
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
            $atts = $request->except(['tag_id', 'important', 'search_tag']);
            if ($request->important != null) {
                $atts['important'] = 1;
            }else{
                $atts['important'] = 0;
            }
            $srch = Post::where('title', $request->title)->get();
            $replaced = Str::slug($request->title, '-');
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
        
        $class = ( request()->is('posts*') ) ?'admin-post' : '';//**add Class in the body*/
        
        return view('posts.show', compact('class','post'));
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
            $postTags = [];
            foreach ($post->tags as $arr2) {
                $postTags[] = $arr2;
            }
            $uniqueTag =  Tag::whereNotIn('id', $arr)->orderBy('tag_name', 'asc')->get();
        
            $class = ( request()->is('posts*') ) ?'admin-post' : '';//**add Class in the body*/
            
            return view('posts.edit', compact('class', 'post', 'employees', 'tags', 'postTags', 'uniqueTag'));
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
        $this->authorize('update', $post);
        $atts = $request->validate([
            'title'        =>  'required',
            'description'  =>  'required',
        ]);
        $atts = $request->except(['tag_id', 'tag_old', 'important', 'search_tag']);
        if ($request->important != null) {
            $atts['important'] = 1;
        }else{
            $atts['important'] = 0;
        }
        $srch = Post::where('title', $request->title)->get();
        $replaced = Str::slug($request->title, '-');

        if ($post->title == $request->title) {
            $atts['slug'] = $post->slug;
        }else{
            if ( count($srch ) > 0) {
                $count = count($srch)+1;
                $lwr = strtolower($replaced).'-'.$count;
                $fnd = Post::where('slug', $lwr)->get();
                if (count($fnd) > 0) {
                    $counted = $count + count($fnd);
                    $atts['slug'] = $replaced.'-'.$counted;
                }else{
                    $atts['slug'] = $replaced.'-'.$count;
                }
            }else{
                $atts['slug'] = strtolower($replaced);
            }
        }

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
