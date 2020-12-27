<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $guarded = [];

    public function flower()
    {
        return $this->hasOne('App\Flower');
    }

    public function cart()
    {
        return $this->hasOne('App\Cart');
    }
}
