<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medias = Media::where('user_id', auth()->user()->id)->get();
        return view('posts.medias.index', compact('medias'));
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
    public function store(MediaRequest $request)
    {
        if ($request->ajax()) {
            $atts = $request->validated();
            if ($request->hasFile('file_name')) {
                $filepath = 'public/uploaded/media';
                $fileName = $request->file_name->getClientOriginalName();
                $mediaSearch = Media::where('file_name', $fileName)->first();
                if ($mediaSearch === NULL) {
                    $request->file('file_name')->storeAs($filepath, $fileName);
                    $atts['file_name'] = $fileName;
                    auth()->user()->addMedia(
                        new Media($atts)
                    );
                    return response()->json($atts);
                }else{
                    return response()->json(['errors2' => 'Image already exists!', 'code' => 422], 422);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $this->authorize('delete', $media);
        Storage::delete('public/uploaded/media/'.$media->file_name);
        $media->delete();
        return back();
    }
}
