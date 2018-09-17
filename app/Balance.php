<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    protected $fillable = ['user_id', 'amount', 'last_saldo_date', 'initial_balance', 'balance_type'];
    protected $table = 'balance';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
