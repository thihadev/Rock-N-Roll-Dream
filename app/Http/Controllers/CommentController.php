<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;

class CommentController extends Controller
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

        Comment::create([
            'description' => $request->comment_body,
            'user_id' => Auth::id(),
            'idea_id' => $request->idea_id,
            'annonymous' => $request->annonymous ? $request->annonymous : 0,
        ]);

        return back();
    
    }

    public function reactionStore(Request $request)
    {
        Reaction::updateOrCreate(
            ['user_id' => Auth::id(), 'idea_id' => $request->id],
            [
                'user_id' => Auth::id(),
                'created_by' => Auth::id(),
                'idea_id' => $request->id,
                'up_down' => $request->up_down,
            ]
        );
        return response()->json('success');

    }


}
