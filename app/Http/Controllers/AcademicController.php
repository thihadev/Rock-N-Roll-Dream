<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AcademicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $academic_years = AcademicYear::get();

        return view('academic-year.index',compact('academic_years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academic-year.create');
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
            "academic_year" => ['required'],
            "start_date" => ['required'],
            "end_date" => ['required'],
            "final_closure_date" => ['required'],
            "closure_date" => ['required'],
        ]);

        $data['created_by'] = Auth::id();

        AcademicYear::create($data);

        return redirect()->route('academic-years.index')->with('success', 'Saved Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $academicYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('academic-year.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $data = $request->validate([
            "academic_year" => ['required'],
            "start_date" => ['required'],
            "end_date" => ['required'],
            "final_closure_date" => ['required'],
            "closure_date" => ['required'],
        ]);


        $data['last_modified_by'] = Auth::id();
        $academicYear->update($data);

        return redirect()->route('academic-years.index')->with('success', 'Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();

        return redirect()->route('academic-years.index');
    }

    public function getClosure(Request $request)
    {
        $academic = AcademicYear::find($request->id);

        return response()->json($academic);
    }
}
