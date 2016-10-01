<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $table = 'members';
    protected $fillable = ['name','address','age','photo'];
    protected $dates = ['deleted_at'];
}
