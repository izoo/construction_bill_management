<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    //
    protected $fillable=['site_name','location','owner','phone','email','id_no'];
}
