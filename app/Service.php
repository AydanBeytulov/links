<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name','category','spoof_url','rate'
    ];

    public function categoryData()
    {
        return $this->hasOne('App\Category','id','category');
    }
}
