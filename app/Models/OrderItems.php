<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',    'orders_id',    'quantity',    'price_per_unit'
    ];
   
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
        
}
