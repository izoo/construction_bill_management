<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillsDetails extends Model
{
    //
 
    protected $fillable = ['item','price','quantity','ref_no','total_cost','balance','amount_paid','vat','status','due_date','pending_bank_amount','pending_bank_balances'];
}
