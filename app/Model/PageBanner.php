<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PageBanner extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    protected $primaryKey = 'page_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['page_id', 'title', 'description', 'link', 'image', 'backgound_pos'];
    
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
    
    public function page()
    {
        return $this->hasOne(Page::class, 'id', 'page_id');
    }
}
