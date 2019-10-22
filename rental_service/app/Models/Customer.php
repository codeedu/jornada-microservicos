<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
