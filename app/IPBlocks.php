<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IPBlocks extends Model
{
    protected $table = "ip_blocks";

    protected $fillable = [
        'name','ip','active'
    ];
}
