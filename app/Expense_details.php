<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense_details extends Model
{
    //
    protected $fillable=['site_name','expense_name','quantity','unit_price','vat','total_amount'];
}
