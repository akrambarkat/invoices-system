<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoicesReportController extends Controller
{
    function invoices_report()
    {
        return view('report.invoices_report');
    }

    public function Search_invoices(Request $request)
    {

        $rdio = $request->rdio;


        // في حالة البحث بنوع الفاتورة

        if ($rdio == 1) {


            // في حالة عدم تحديد تاريخ
            if ($request->type && $request->start_at == '' && $request->end_at == '') {

                $invoices = Invoices::get()->where('Status', '=', $request->type);
                $type = $request->type;
                return view('report.invoices_report', compact('type'))->with('details', $invoices);
            }

            // في حالة تحديد تاريخ استحقاق
            else {

                $start_at = date($request->start_at);
                $end_at = date($request->end_at);
                $type = $request->type;

                $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('Status', '=', $request->type)->get();
                return view('reports.invoices_report', compact('type', 'start_at', 'end_at'))->with('details', $invoices);;
            }
        }

        //====================================================================

        // في البحث برقم الفاتورة
        else {

            $invoices = Invoices::get()->where('invoice_number', '=', $request->invoice_number);
            return view('report.invoices_report')->with('details', $invoices);;
        }
    }
}
