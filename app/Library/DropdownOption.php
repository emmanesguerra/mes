<?php

namespace App\Library;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DropdownOption
 *
 * @author alvin
 */

class DropdownOption{
    //put your code here
    
    public static function BackgroundPositions() 
    {
        return [
            'top left',
            'top center',
            'top right',
            'bottom left',
            'bottom center',
            'bottom right',
            'center',
            'center left',
            'center right'
        ];
    }
}
