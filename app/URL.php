<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class URL extends Model
{

    protected $fillable = [
        'url','userId','qty','qty_showed','order_id','spoof_url','active'
    ];

    protected $table = "urls";


    public function userData()
    {
        return $this->hasOne('App\User','id','userId');
    }

    public function rotators()
    {
        return $this->belongsToMany('App\Rotator','url_rotator','url_id','rotator_id');
    }


}
