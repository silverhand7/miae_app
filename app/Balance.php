<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = ['user_id', 'amount', 'last_saldo_date', 'initial_balance', 'balance_type'];
    protected $table = 'balance';
}
