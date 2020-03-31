<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = ['payment_id','amount_paid','balance','mode_payment','posted_on','cleared_on','date_payment','mpesa_code','payment_clearance_status'];
}
