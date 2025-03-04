<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyDrawResult extends Model
{
    protected $fillable = [
        'link_id',
        'number',
        'result',
        'prize',
    ];
}
