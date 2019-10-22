<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'order_id',
        'payment_type',
        'description',
        'amount',
        'payment_date',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
