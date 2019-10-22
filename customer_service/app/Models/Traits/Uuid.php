<?php


namespace App\Models\Traits;


trait Uuid
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($obj) {
            if (!$obj->id) {
                $obj->id = \Ramsey\Uuid\Uuid::uuid4();
            }
        });
    }
}
