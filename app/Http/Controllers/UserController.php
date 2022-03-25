<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::get();

        return view('user.create',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "department_id" => ['required'],
            "first_name" => ['required'],
            "last_name" => ['required'],
            "email" => ['required'],
            "date_of_birth" => ['required'],
            "gender" => ['required'],
            "mobile_no" => ['required'],
            "staff_type" => ['nullable'],
            "role" => ['required'],
        ]);

        // $data['created_by'] = Auth::id();

        User::create($data);

        return redirect()->route('user.index')->with('success', 'Saved Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $departments = Department::get();

        return view('user.edit',compact('user','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            "department_id" => ['required'],
            "first_name" => ['required'],
            "last_name" => ['required'],
            "email" => ['required'],
            "date_of_birth" => ['required'],
            "gender" => ['required'],
            "mobile_no" => ['required'],
            "staff_type" => ['nullable'],
            "role" => ['required'],
        ]);


        // $data['last_modified_by'] = Auth::id();

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('academic-years.index');
    }
}
