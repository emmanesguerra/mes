<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Library;

/**
 * Description of DropdownOptions
 *
 * @author ai
 */
class DropdownOptions {
    //put your code here
    public static function timezones() 
    {
        return timezone_identifiers_list();
    }
}
