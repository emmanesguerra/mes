<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubscriberVCode extends Model
{
    protected $table = 'newsletters_verification_codes';
    
    protected $fillable = ['email', 'token'];
}
