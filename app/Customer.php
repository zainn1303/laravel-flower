<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function cart()
    {
        return $this->hasOne('App\Cart');
    }
}
