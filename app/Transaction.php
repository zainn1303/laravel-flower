<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function historie()
    {
        return $this->hasOne('App\Historie');
    }
}
