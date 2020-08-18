<?php

namespace Core\Helpers;

use Core\Model\Module;

class Helpers {
    //put your code here
    public static function getModules () {
        $modules = Module::all();
        
        return $modules;
    }
}
