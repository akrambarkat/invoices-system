<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {

        $invoices = Invoices::where('id', $id)->first();
        $attachment = invoices_attachments::where('invoices_id', $id)->get();
        $details = invoices_details::where('invoices_id', $id)->get();
        return view('invoices.invoices_details', compact('invoices', 'attachment', 'details'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit() {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }
    public function get_file(string $id)
    {
        $file = invoices_attachments::findOrFail($id);

        $filePath = public_path('images/' . $file->invoice_number . '/' . $file->file_name);

        // return response()->file($filePath);

        return response()->download($filePath);
    }




    public function open_file(string $id)
    {
        $file = invoices_attachments::findOrFail($id);

        $filePath = public_path('images/' . $file->invoice_number . '/' . $file->file_name);
        $mimeType = mime_content_type($filePath);
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $file->file_name . '"'
        ]);
    }

    function delete_file(string $id)
    {
        $file = invoices_attachments::where('id', $id)->first();
        $file->delete();
        $filePath = public_path('images/' . $file->invoice_number . '/' . $file->file_name);
        // $filePath::delete();
        File::delete($filePath);

        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }
}
