<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\invoicesExport;

use App\Models\Invoices;
use App\Models\products;
use App\Models\sections;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use Illuminate\Support\Facades\DB;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Container\Attributes\DB as AttributesDB;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $invoices = Invoices::all();
        return view('invoices.invoice', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = sections::all();
        return  view('invoices.add_invoices', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'Section' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'nullable',
            'Rate_VAT' => 'required',
            'Value_VAT' => 'required',
            'Total' => 'required',
            'note' => 'nullable',

        ], [
            'invoice_number.required' => 'يجب ادخال رقم الفاتورة',
            'invoice_Date.required' => 'يجب ادخال تاريخ الفاتورة',
            'Due_date.required' => 'يجب ادخال تاريخ الاستحقاق',
            'product.required' => 'يجب ادخال المنتج',
            'Section.required' => 'يجب ادخال القسم',
            'Amount_collection.required' => 'يجب ادخال مبلغ التحصيل',
            'Amount_Commission.required' => 'يجب ادخال مبلغ العمولة ',
            'Rate_VAT.required' => 'يجب ادخال نسبة الضريبة',
        ]);



        $x = invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = Invoices::latest()->first()->id;
        invoices_details::create([
            'invoices_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);


        if ($request->hasFile('pic')) {
            $request->validate([
                'pic' => 'required|mimes:jpeg,png,jpg,pdf,word'
            ]);
            $invoice_id = Invoices::latest()->first()->id;
            $img_name =  $request->file('pic')->getClientOriginalName();
            $request->pic->move(public_path('images/' . $request->invoice_number), $img_name);

            $attachments = new invoices_attachments();
            $attachments->file_name = $img_name;
            $attachments->invoice_number = $request->invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoices_id = $invoice_id;
            $attachments->save();
        }

        return redirect()
            ->route('invoices.index')
            ->with('msg', 'تم اضافة الفاتورة بنجاح')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return  view('invoices.edit_invoices', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string  $id)
    {
        $x = Invoices::find($request->invoice_id);
        $oldInvoiceNumber = $x->invoice_number;

        $request->validate([
            'invoice_number' => 'required',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'Section' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'nullable',
            'Rate_VAT' => 'required',
            'Value_VAT' => 'required',
            'Total' => 'required',
            'note' => 'nullable',

        ], [
            'invoice_number.required' => 'يجب ادخال رقم الفاتورة',
            'invoice_Date.required' => 'يجب ادخال تاريخ الفاتورة',
            'Due_date.required' => 'يجب ادخال تاريخ الاستحقاق',
            'product.required' => 'يجب ادخال المنتج',
            'Section.required' => 'يجب ادخال القسم',
            'Amount_collection.required' => 'يجب ادخال مبلغ التحصيل',
            'Amount_Commission.required' => 'يجب ادخال مبلغ العمولة ',
            'Rate_VAT.required' => 'يجب ادخال نسبة الضريبة',
        ]);



        $x->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $y = invoices_details::find($request->invoice_id);
        $invoice_id = invoices::latest()->first()->id;
        $y->update([
            'invoices_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        // $attachment = invoices_attachments::where('invoices_id', $id)->first();
        // if ($attachment) {
        //     // اسم الملف القديم
        //     $oldFileName = $attachment->file_name;

        //     // إنشاء اسم جديد بناءً على رقم الفاتورة الجديد
        //     $newFileName = str_replace($oldInvoiceNumber, $request->invoice_number, $oldFileName);

        //     // مسار الملف القديم والجديد
        //     $oldFilePath = public_path('images/' . $oldInvoiceNumber . '/' . $oldFileName);
        //     $newFilePath = public_path('images/' . $request->invoice_number . '/' . $newFileName);

        //     // التأكد من وجود الملف في نظام الملفات
        //     if (File::exists($oldFilePath)) {
        //         // نقل الملف وتغيير اسمه
        //         File::move($oldFilePath, $newFilePath);
        //     }

        //     // تحديث اسم الملف في قاعدة البيانات
        //     $attachment->invoice_number = $newFileName;
        //     $attachment->save();
        // }
        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return redirect()->route('invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string  $id)
    {
        // dd(invoices_attachments::where('invoices_id', $id)->first());
        $invoices = invoices::where('id', $id)->first();

        $x = invoices_attachments::where('invoices_id', $id)->first();

        // $filePath = public_path('images/' . $x->invoice_number . '/' . $x->file_name);
        // File::delete($filePath);
        if (!empty($x->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($x->invoice_number);
        }

        $invoices->forcedelete();
        session()->flash('delete_invoice');
        return redirect()->route('invoices.index');
    }

    //aJax
    public function getproducts(Request $request)
    {
        // return 'asas';
        $id = $request->SectionId;
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }

    function show_status($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        $sections = sections::all();

        return view('invoices.status_update', compact('invoices', 'sections'));
    }

    function Status_Update($id, Request $request)
    {
        $invoices = Invoices::where('id', $id)->first();
        $details = invoices_details::where('id', $id)->first();
        if ($request->Status === 'مدفوعة') {
            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'invoices_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        } else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'invoices_id' => $request->id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
                'Value_Status' => 3,
                'note' => $request->note,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }
    function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoice_paid', compact('invoices'));
    }
    function Invoice_UnPaid()
    {
        $invoices = Invoices::where('Value_Status', 2)->get();
        return view('invoices.Invoice_UnPaid', compact('invoices'));
    }
    function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status', 3)->get();
        return view('invoices.invoice_partial', compact('invoices'));
    }


    function archives($id, Request $request)
    {
        $invoices = Invoices::where('id', $id)->first();
        $invoices->delete();
        session()->flash('archive_invoices');
        return redirect('/invoices');
    }



    // function Invoice_Paid_Details($id)
    // {
    //     $invoices = Invoices::where('id', $id)->first();
    //     $details = invoices_details::where('invoices_id', $id)->get();
    //     return view('invoices.invoice_paid_details', compact('invoices', 'details'));
    // }

    function Print_invoice($id)
    {
        $invoices = Invoices::where('id', $id)->first();
        return view('invoices.print_invoice', compact('invoices'));
    }
    function export()
    {
        // echo "aaaa";
        return  Excel::download(new invoicesExport, 'invoices.xlsx');
    }
}
