<?php

namespace App\Http\Controllers;

use Cache;
use App\Post;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class FrontpageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        $posts = Post::orderBy('id', 'DESC')->get();
        return view('front-page', compact('users', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response4
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('front-page-post', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * Load Data
     */
    public function load_data(Request $request){
        if ( $request->ajax() ) {
            if($request->id > 0){
                $data = Post::where('id', '<', $request->id)->where('important', '1')->orderBy('id', 'desc')->limit(1)->get();
            }else{
                $data = Post::where('important', '1')->orderBy('id', 'desc')->limit(1)->get();
            }
            $output = '';
            $last_id = '';

            if (!$data->isEmpty()) {
                foreach($data as $posts){
                    $output .= '<a href="' . route('frnt.show.post', ['post' => $posts->slug]) . '" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">' . $posts->title . '<span class="badge badge-primary badge-pill">' . $posts->user->name . '</span></a>';
                    $last_id = $posts->id;
                }
                $output .= '<div id="load_more" class="text-center mt-4"><button type="button" class="btn btn-primary" id="loadMore" data-id="'.$last_id.'">Load More</button></div>';
            }else{
               $output .= '<div id="load_more" class="text-center mt-4"><button type="button" class="btn btn-info text-white" id="loadMore" disabled>No Data Found</button></div>'; 
            }
            echo $output;
        }
    }
}
