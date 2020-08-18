<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Module extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module_name', 'description', 'route_root_name'];
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
