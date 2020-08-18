<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Page extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    
    protected $fillable = ['url', 'name', 'title', 'description', 'javascripts', 'css', 'template', 'template_html'];
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function getCssAttribute($value)
    {
        if(!empty($value)) {
            return explode(',', $value);
        }
    }
    
    public function setCssAttribute($value)
    {
        if(!empty($value)) {
            $this->attributes['css'] = implode(',', $value);
        }
    }
    
    public function getJavascriptsAttribute($value)
    {
        if(!empty($value)) {
            return explode(',', $value);
        }
    }
    
    public function setJavascriptsAttribute($value)
    {
        if(!empty($value)) {
            $this->attributes['javascripts'] = implode(',', $value);
        } 
    }
    
    /**
     * A page may be given various contents.
     */
    public function contents()
    {
        return $this->belongsToMany(
                'Core\Model\Content',
                'page_has_contents',
                'page_id',
                'content_id'
        )->withPivot('tags');
    }
}
