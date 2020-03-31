<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spares extends Model
{
    //
    protected $fillable=['spare_name','price','model_name','make_name',
    'description','photo','type','category'];
}
