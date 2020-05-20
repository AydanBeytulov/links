<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rotator extends Model
{

    protected $fillable = [
        'name','service','active'
    ];

    public function urls()
    {
        return $this->belongsToMany('App\URL','url_rotator','rotator_id','url_id');
    }


    public function serviceData()
    {
        return $this->hasOne('App\Service','id','service');
    }
}
