<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5); // Example if you use roles in index
        $paidCount = Invoices::where('status', 'مدفوعة')->count();
        $partiallyPaidCount = Invoices::where('status', 'مدفوعة جزئيا')->count();
        $unpaidCount = Invoices::where('status', 'غير مدفوعة')->count();



        $totalInvoices = $paidCount + $partiallyPaidCount + $unpaidCount;

        $paidPercentage = ($totalInvoices > 0) ? ($paidCount / $totalInvoices) * 100 : 0;
        $partiallyPaidPercentage = ($totalInvoices > 0) ? ($partiallyPaidCount / $totalInvoices) * 100 : 0;
        $unpaidPercentage = ($totalInvoices > 0) ? ($unpaidCount / $totalInvoices) * 100 : 0;
        return view('index', compact('roles', 'paidCount', 'partiallyPaidCount', 'unpaidCount', 'totalInvoices', 'paidPercentage', 'partiallyPaidPercentage', 'unpaidPercentage'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {}
}
