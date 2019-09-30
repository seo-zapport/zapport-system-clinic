<?php

namespace App\Http\Controllers;

use App\PostTag;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function show(PostTag $postTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function edit(PostTag $postTag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostTag $postTag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostTag  $postTag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post, $tag_id)
    {
        if ($request->ajax()) {
            $post->tags()->newPivotStatement()->where('post_id', $post->id)->where('tag_id', $tag_id)->delete();
            $tagID = Tag::find($tag_id);

            return response()->json(['id'=>$tagID->id, 'tag_name'=>$tagID->tag_name]);
        }
    }
}
