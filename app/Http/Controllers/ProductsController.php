<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = products::all();
        $sections = sections::all();
        return view('products.index', compact('products', 'sections'));
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
            'product_name' => 'required',
            'section_id' => 'required',
            'description' => 'nullable',
        ]);
        $products = $request->except('_token');

        products::create($products);
        return  redirect()->route('products.index')->with('msg', 'تم اضافة المنتج بنجاح')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string  $id)
    {
        // dd(sections::where('section_name', $request->section_name)->first()->id);
        // $request->validate([
        //     'product_name' => 'required',
        //     'description' => 'nullable',
        //     'section_id' => 'required'
        // ]);
        $ID = sections::where('section_name', $request->section_name)->first()->id; // get the id of the section


        $Products = Products::findOrFail($request->pro_id);

        $Products->update([
            'product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $ID,

        ]);
        return redirect()
            ->route('products.index')
            ->with('msg', 'تم تعديل المنتج بنجاح')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string  $id)

    {
        $products = products::find($id);
        $products->delete();
        return redirect()
            ->route('products.index')
            ->with('msg', 'تم حذف المنتج بنجاح')
            ->with('type', 'success');
    }
}
