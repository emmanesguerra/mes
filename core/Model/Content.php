<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Content extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'html_template', 'container_class', 'type', 'class_namespace', 'method_name'];
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];
    
    /**
     * {@inheritdoc}
     */
    public function generateTags(): array
    {
        return (!empty($this->html_template)) ? ['displayToDashboard'] : [];
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    /**
     * A content may be assigned to various pages.
     */
    public function pages()
    {
        return $this->belongsToMany(
                'Core\Model\Page',
                'page_has_contents',
                'content_id',
                'page_id'
        );
    }
}
