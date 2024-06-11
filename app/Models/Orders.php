<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',    'order_date',    'status', 'address', 'phone_number', 'name'
    ];

    public function payments()
    {
        $this->HasMany(Payments::class);
    }
}
