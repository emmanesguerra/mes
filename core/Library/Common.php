<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Library;

/**
 * Description of Common
 *
 * @author ai
 */

use Core\Model\SystemConfig;

class Common {
    //put your code here
    
    public static function save_settings($keyword, $value)
    {
        return SystemConfig::updateOrCreate(['keyword' => $keyword], ['keyvalue' => $value]);
    }
    
    public static function get_settings($keyword)
    {
        $sys = SystemConfig::find($keyword);
        if($sys) {
            return $sys->keyvalue;
        } else {
            return '';
        }
    }
}
