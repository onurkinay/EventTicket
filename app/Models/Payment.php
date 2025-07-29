<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'cc_number',
        'cc_exp_month',
        'cc_exp_year',
        'cc_cvv',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
