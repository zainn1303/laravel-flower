<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public function flower()
    {
        return $this->belongsTo('App\Flower');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
