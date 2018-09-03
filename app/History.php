<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    protected $fillable = ['user_id', 'date', 'type', 'description', 'nominal'];
    protected $table = 'history';
    protected $dates = ['deleted_at'];
}

