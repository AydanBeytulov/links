<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'category','service','url','description','qty','userId','paid','active','pay_address','price','btc_price'
    ];

    public function categoryData()
    {
        return $this->hasOne('App\Category','id','category');
    }

    public function serviceData()
    {
        return $this->hasOne('App\Service','id','service');
    }

    public function userData()
    {
        return $this->hasOne('App\User','id','userId');
    }
}
