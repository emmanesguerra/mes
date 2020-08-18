<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = ['log_in', 'ip_address', 'email'];
    
    public $timestamps = false;
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
