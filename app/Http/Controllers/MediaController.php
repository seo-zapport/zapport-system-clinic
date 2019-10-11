<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
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
    public function index()
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $medias = Media::where('user_id', auth()->user()->id)->get();
            return view('posts.medias.index', compact('medias'));
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
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
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            if ($request->ajax()) {
                $atts = $request->validated();
                if ($request->hasFile('file_name')) {
                    $filepath = 'public/uploaded/media';
                    $fileName = $request->file_name->getClientOriginalName();
                    $atts['alt'] = $fileName;
                    $mediaSearch = Media::where('user_id', auth()->user()->id)->where('file_name', $fileName)->first();
                    if ($mediaSearch === NULL) {
                        $request->file('file_name')->storeAs($filepath, $fileName);
                        $atts['file_name'] = $fileName;
                        auth()->user()->addMedia(
                            new Media($atts)
                        );
                        $lastId = Media::where('file_name', $fileName)->first();
                        $atts['id'] = $lastId->id;
                        return response()->json($atts);
                    }else{
                        return response()->json(['errors2' => 'Image already exists!', 'code' => 422], 422);
                    }
                }
            }
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
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
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate(['alt' => 'required']);
            if ($request->alt != null) {
                $media->update($atts);
            }
            return back();
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
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
        if (count($media->posts) > 0) {
            return back()->with('delete_error', 'You cannot delete an image associated with post');
        }
        Storage::delete('public/uploaded/media/'.$media->file_name);
        $media->delete();
        return back();
    }

    public function addMediaOnPostUpdate(MediaRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            if ($request->ajax()) {
                $atts = $request->validated();
                if ($request->hasFile('file_name')) {
                    $filepath = 'public/uploaded/media';
                    $fileName = $request->file_name->getClientOriginalName();
                    $atts['alt'] = $fileName;
                    $mediaSearch = Media::where('user_id', auth()->user()->id)->where('file_name', $fileName)->first();
                    if ($mediaSearch === NULL) {
                        $request->file('file_name')->storeAs($filepath, $fileName);
                        $atts['file_name'] = $fileName;
                        auth()->user()->addMedia(
                            new Media($atts)
                        );
                        $lastId = Media::where('file_name', $fileName)->first();
                        $atts['id'] = $lastId->id;
                        return response()->json($atts);
                    }else{
                        return response()->json(['errors2' => 'Image already exists!', 'code' => 422], 422);
                    }
                }
            }
        }elseif (Gate::allows('isBanned')) {
            Auth::logout();
            return back()->with('message', 'You\'re not employee!');
        }else{
            return back();
        }
    }
}
