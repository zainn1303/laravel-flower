<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    protected $guarded = [];

    public function categorie()
    {
        return $this->belongsTo('App\Categorie');
    }

    public function cart()
    {
        return $this->hasOne('App\Cart');
    }

    public function historie()
    {
        return $this->hasOne('App\Historie');
    }
}
