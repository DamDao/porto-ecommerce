<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'orders_id',    'amount',    'payment_date',    'payment_method'
    ];

    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
}
