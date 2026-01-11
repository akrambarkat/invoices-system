<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoices_details extends Model
{
    protected $fillable = [
        'invoices_id',
        'invoice_number',
        'product',
        'Section',
        'Status',
        'Value_Status',
        'note',
        'user',
        'Payment_Date',
    ];
    public function  invoice()
    {
        return $this->belongsTo(invoices::class, 'invoices_id')->withDefault();
    }
}
