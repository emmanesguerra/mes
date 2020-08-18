<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SystemConfigLibrary
 *
 * @author AE2
 */
namespace Core\Library\Modules;

use Core\Model\SystemConfig;

class SystemConfigLibrary {
    //put your code here
    

    public static function save($keyword, $value) {
        return SystemConfig::updateOrCreate(['keyword' => $keyword], ['keyvalue' => $value]);
    }
    
    public static function retrieve($keyword) {
        $resp = SystemConfig::find($keyword);
        return ($resp) ? $resp->keyvalue: null;
    }
}
