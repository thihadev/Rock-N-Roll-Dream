<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Category;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Auth;
use Str;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ideas = Idea::get();

        return view('idea.index',compact('ideas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $departments = Department::get();
        $academic_years = AcademicYear::get();

        return view('idea.create', compact('categories','departments','academic_years'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $data = $request->validate([
            "category_id" => ['required'],
            "academic_year_id" => ['required'],
            "title" => ['required'],
            "description" => ['required'],
            "document_url" => ['nullable'],
            "annonymous" => ['nullable'],
        ]);

        if ($request->closure_date < now()->toDateString()) {
            return redirect()->route('ideas.create')->with('error', 'Idea Can\'t Be Submit.');
        }

        $data['created_by'] = Auth::id();
        $data['user_id'] = Auth::id();
        if ($request->document_url) {
            $ext = $request->document_url->getClientOriginalExtension();

            $name = time().Str::random(6).".".$ext;

            $data['document_url'] = $request->document_url->storeAs('document', $name);
        }

        $data['annonymous'] = $request->annonymous ? $request->annonymous : 0;
        Idea::create($data);

        return redirect()->route('ideas.index')->with('success', 'Saved Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function show(Idea $idea)
    {
        $check = Comment::where('user_id',Auth::id())->where('idea_id',$idea->id)->first();
        $reaction_check = Reaction::where('user_id',Auth::id())->where('idea_id',$idea->id)->first();

        $disable = $check ? 'disabled' : '';
        if ($reaction_check) {
            $reaction_up = ($reaction_check->up_down == 1) ? 'secondary' : 'outline-secondary';
            $reaction_down = ($reaction_check->up_down == 2) ? 'secondary' : 'outline-secondary';

            return view('idea.view', compact('idea','disable','reaction_up','reaction_down'));
        }
        return view('idea.view', compact('idea','disable'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idea  $idea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idea $idea)
    {
        //
    }
}
