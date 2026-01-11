<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\sections as AppSections;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Illuminate\Routing\Controller;


class SectionsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = sections::get();
        return view('sections.sections', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_name' => 'required|unique:sections',
            'description' => 'nullable'
        ], [
            'section_name.required' => 'يرجى ادخال اسم القسم',
            'section_name.unique' => 'القسم موجود مسبقا',
        ]);

        // $data = $request->except('_token','created_by');
        $section = sections::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('section.index')
            ->with('msg', 'تم اضافة القسم بنجاح')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd(sections::find($id));
        $ID = $request->id;
        $section = sections::find($ID);
        $request->validate([
            'section_name' => 'required',
            'description' => 'nullable'
        ], [
            'section_name.required' => 'يرجى ادخال اسم القسم',
        ]);

        // $data = $request->except('_token','created_by');
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()
            ->route('section.index')
            ->with('msg', 'تم تعديل القسم بنجاح')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = sections::find($id);
        $section->delete();
        return redirect()
            ->route('section.index')
            ->with('msg', 'تم حذف القسم بنجاح')
            ->with('type', 'success');
    }
}
