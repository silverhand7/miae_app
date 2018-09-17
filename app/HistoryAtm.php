<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryAtm extends Model
{
    protected $fillable = ['user_id', 'date', 'type', 'desc', 'nominal', 'code_access'];
    protected $table = 'history_atm';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
