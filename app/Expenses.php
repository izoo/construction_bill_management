<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    //
    protected $fillable = ['site','mode_payment', 'cheque_no', 'mpesa_code','bank_name','date_paid'];
}
