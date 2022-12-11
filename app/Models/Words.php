<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    protected $guarded = [];

    public static function test(){
        return Words::all();
    }
}
