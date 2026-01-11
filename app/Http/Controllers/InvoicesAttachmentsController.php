<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'file_name' => 'required|mimes:jpeg,png,jpg,pdf,word'
        ]);
        $invoice_id = Invoices::latest()->first()->id;
        $img_name =  $request->file('file_name')->getClientOriginalName();
        $request->file_name->move(public_path('images/' . $request->invoice_number), $img_name);

        $attachments = new invoices_attachments();
        $attachments->file_name = $img_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->Created_by = Auth::user()->name;
        $attachments->invoices_id = $invoice_id;
        $attachments->save();
        return redirect()
            ->route('invoices_details', $invoice_id)
            ->with('Add', 'تم اضافة اللمرفق بنجاح')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
