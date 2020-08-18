<?php

namespace Core\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class MenuSetting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    protected $primaryKey = 'menu_id';
    
    protected $fillable = [
        'menu_id', 'blck_start', 'blck_end', 'list_dflt', 'list_chld', 
        'list_end', 'anch_dflt', 'anch_chld',
        'subblck_start', 'subblck_end', 'sublist_dflt', 'sublist_chld', 'sublist_end', 
        'subanch_dflt', 'subanch_chld'
    ];
    
    protected $auditExclude = [
        'created_by',
        'updated_by'
    ];
}
