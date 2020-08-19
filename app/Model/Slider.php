<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Slider extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'link', 'image', 'backgound_pos', 'text_pos1', 'text_pos2'];
    
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
