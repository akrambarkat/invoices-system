<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'Value_Status',
        'note',
        'Payment_Date',
    ];

    protected $dates = ['deleted_at'];

    public function sections()
    {
        return $this->belongsTo(sections::class, 'section_id')->withDefault();
    }

    public function invoices_detalis()
    {
        return $this->hasMany(invoices_details::class, 'invoice_id');
    }
    public function invoices_attachment()
    {
        return $this->hasMany(invoices_attachments::class, 'invoice_id');
    }
}
