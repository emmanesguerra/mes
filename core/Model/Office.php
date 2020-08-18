<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Office extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    protected $fillable = ['address', 'contact_person', 'telephone', 'mobile', 'email', 'marker', 'm_width', 'm_height', 'store_hours'];
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];

    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return [
            'displayToDashboard'
        ];
    }
    
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
