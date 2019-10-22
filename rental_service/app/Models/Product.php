<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Uuid;
    public $incrementing = false;
    protected $keyType = "string";

    protected $fillable = [
        "id",
        "name",
        "price",
    ];
}
