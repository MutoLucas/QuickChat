<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = "blocks";

    protected $fillable = [
        'user_who_blocked_id',
        'user_blocked_id'
    ];

}
