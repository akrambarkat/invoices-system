<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\Customers_ReportController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\usersController;
use App\Models\Invoices;
use App\Models\invoices_attachments;

// Route::prefix('')->name('invoices')->function()


Route::middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('/invoices', InvoicesController::class);
    Route::resource('/section', SectionsController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/archive', ArchiveController::class);
    Route::resource('/InvoiceAttachments', InvoicesAttachmentsController::class);
    Route::get('/section_id', [InvoicesController::class, 'getproducts']); //alax code for view data
    Route::get('/invoices_details/{id}', [InvoicesDetailsController::class, 'index'])->name('invoices_details');
    Route::get('get_file/{id}', [InvoicesDetailsController::class, 'get_file'])->name('get_file');
    Route::get('open_file/{id}', [InvoicesDetailsController::class, 'open_file'])->name('open_file');
    Route::delete('delete_file/{id}', [InvoicesDetailsController::class, 'delete_file'])->name('delete_file');
    Route::get('show_status/{id}', [InvoicesController::class, 'show_status'])->name('show_status');
    Route::post('Status_Update/{id}', [InvoicesController::class, 'Status_Update'])->name('Status_Update');
    Route::get('Invoice_Paid', [InvoicesController::class, 'Invoice_Paid'])->name('Invoice_Paid');
    Route::get('Invoice_UnPaid', [InvoicesController::class, 'Invoice_UnPaid'])->name('Invoice_UnPaid');
    Route::get('Invoice_Partial', [InvoicesController::class, 'Invoice_Partial'])->name('Invoice_Partial');
    Route::get('archives/{id}', [InvoicesController::class, 'archives'])->name('archives');
    Route::get('restore_archives/{id}', [ArchiveController::class, 'restore_archives'])->name('restore_archives');
    Route::get('Print_invoice/{id}', [InvoicesController::class, 'Print_invoice'])->name('Print_invoice');
    Route::get('export_invoices', [InvoicesController::class, 'export'])->name('export');
    Route::get('invoices_report', [InvoicesReportController::class, 'invoices_report'])->name('invoices_report');
    Route::post('Search_invoices', [InvoicesReportController::class, 'Search_invoices'])->name('Search_invoices');
    Route::get('customers_report', [Customers_ReportController::class, 'customers_report'])->name("customers_report");
    Route::post('Search_customers', [Customers_ReportController::class, 'Search_customers'])->name("Search_customers");

    Route::resource('role', roleController::class);
    Route::resource('users', usersController::class);
});
