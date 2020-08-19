<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class News extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'title', 'short_description', 'description'];
    
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
    
    public function category()
    {
        return $this->hasOne(NewsCategory::class, 'id', 'category_id');
    }
}
