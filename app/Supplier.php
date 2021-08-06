<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Supplier extends Model
{
    public function scopeNotcharity($query){
        return $query->where('id','!=',4);
    }
}
