<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historie extends Model
{
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo('App\Historie');
    }

    public function flower()
    {
        return $this->belongsTo('App\Flower');
    }
}
