<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    protected $guarded = [];

    function products()
    {
        return $this->hasMany(products::class);
    }
    function invoices()
    {
        return $this->hasMany(Invoices::class);
    }
}
