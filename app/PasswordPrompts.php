<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordPrompts extends Model
{
    //
    protected $fillable = [
        'prompt_on','password'
    ];
}
