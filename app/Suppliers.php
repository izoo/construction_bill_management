<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    //
    protected $fillable = ['supplier_name','supplier_email','supplier_phone','company_name'];
}
