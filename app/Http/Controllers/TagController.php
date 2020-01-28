<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Gate;

class TagController extends Controller
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
        $tags = Tag::orderBy('id', 'desc')->paginate(10);
        $count = Tag::get();

        $class = ( request()->is('category*') ) ?'admin-category' : '';//**add Class in the body*/

        return view('posts.category.index', compact('class','tags', 'count'));
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
    public function store(TagRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            if ($request->ajax()) {
                $atts = $request->validated();
                $atts['tag_slug'] = Str::slug($request->tag_name, '-');
                $lastid = Tag::create($atts);
                $atts['id'] = $lastid->id;
                return response()->json($atts);
            }
        }else{
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                'tag_name' => ['required', 'unique:tags,tag_name,'.$tag->id],
            ]);
            $atts['tag_slug'] = Str::slug($request->tag_name, '-');
            $tag->update($atts);
            return back();
        }else{
            return back();
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            if (count($tag->posts) >= 1) {
                return back()->with('tag_error', 'You can\'t delete category with post!');
            }
            $tag->delete();
            return back();
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
    public function store2(TagRequest $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            if ($request->ajax()) {
                $atts = $request->validated();
                $atts['tag_slug'] = Str::slug($request->tag_name, '-');
                $lastid = Tag::create($atts);
                $atts['id'] = $lastid->id;
                return response()->json($atts);
            }
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
    public function createTag(Request $request)
    {
        if (Gate::check('isAdmin') || Gate::check('isHr') || Gate::check('isDoctor') || Gate::allows('isNurse')) {
            $atts = $request->validate([
                        'tag_name' => ['required', 'unique:tags'],
                    ]);
            $atts['tag_slug'] = Str::slug($request->tag_name, '-');
            Tag::create($atts);
            return back();
        }else{
            return back();
        }
    }

    public function searchTags(Request $request)
    {
        if ($request->ajax()) {
            if ($request->tag != '') {
                $data = Tag::orderBy('tag_name', 'asc')
                           ->where('tag_name', 'like', '%'.$request->tag.'%')
                           ->get();
                $output = '';
                if (count($data) > 0) {
                    foreach ($data as $row) {
                        $output .= '<div class="mb-1">';
                        $output .= '<input type="checkbox"  name="tag_id[]" value="'.$row->id.'" class="zp-chkbox" id="tag_id_'.$row->id.'">';
                        $output .= '<label class="form-check-label" for="tag_id_'.$row->id.'">'.$row->tag_name.'</label>';
                        $output .= '</div>';
                    }
                }else{
                    $output .= '<p class="text-center p-2">No Result found!</p>';
                }
                return response($output);
            }
        }
    }

    public function searchNull(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::orderBy('tag_name', 'asc')
                       ->get();
            $output = '';
            foreach ($data as $row) {
                $output .= '<div class="mb-1">';
                $output .= '<input type="checkbox"  name="tag_id[]" value="'.$row->id.'" class="zp-chkbox" id="tag_id_'.$row->id.'">';
                $output .= '<label class="form-check-label" for="tag_id_'.$row->id.'">'.$row->tag_name.'</label>';
                $output .= '</div>';
            }
            return response($output);
        }
    }

    public function searchTagsEdit(Request $request)
    {
        if ($request->ajax()) {
            if ($request->tag != '') {
                $data = Tag::where('tag_name', 'like', '%'.$request->tag.'%')
                           ->whereNotIn('id', $request->tag_old)
                           ->orderBy('tag_name', 'asc')
                           ->get();
                $output = '';
                if (count($data) > 0) {
                    foreach ($data as $row) {
                        $output .= '<div class="mb-1">';
                        $output .= '<input type="checkbox"  name="tag_id[]" value="'.$row->id.'" class="zp-chkbox" id="tag_id_'.$row->id.'">';
                        $output .= '<label class="form-check-label" for="tag_id_'.$row->id.'">'.$row->tag_name.'</label>';
                        $output .= '</div>';
                    }
                }else{
                    $output .= '<p class="text-center p-2">No Result found!</p>';
                }
                return response($output);
            }
        }
    }

    public function searchNullEdit(Request $request)
    {
        if ($request->ajax()) {
            $data = Tag::whereNotIn('id', $request->tag_old)
                       ->orderBy('tag_name', 'asc')
                       ->get();
            $output = '';
            foreach ($data as $row) {
                $output .= '<div class="mb-1">';
                $output .= '<input type="checkbox"  name="tag_id[]" value="'.$row->id.'" class="zp-chkbox" id="tag_id_'.$row->id.'">';
                $output .= '<label class="form-check-label" for="tag_id_'.$row->id.'">'.$row->tag_name.'</label>';
                $output .= '</div>';
            }
            return response($output);
        }
    }
}