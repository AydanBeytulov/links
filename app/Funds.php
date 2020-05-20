<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{

    protected $fillable = [
        'userID','funds','status','competeDate','checkout_url','status_url','qrcode_url','btc_price','pay_address',
    ];
}
