<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Observers;

/**
 * Description of BaseObserver
 *
 * @author alvin
 */

use Core\Model\SystemConfig;
use Core\Observers\SystemConfigObserver;

use Core\Model\User;
use Core\Observers\UserObserver;

use Core\Model\Module;
use Core\Observers\ModuleObserver;

use Core\Model\Content;
use Core\Observers\ContentObserver;

use Core\Model\Page;
use Core\Observers\PageObserver;

use Core\Model\Menu;
use Core\Observers\MenuObserver;

use Core\Model\Office;
use Core\Observers\OfficeObserver;

use Core\Model\MenuSetting;
use Core\Observers\MenuSettingObserver;

class BaseObserver {
    //put your code here
    public function init()
    {
        SystemConfig::observe(SystemConfigObserver::class);
        User::observe(UserObserver::class);
        Module::observe(ModuleObserver::class);
        Content::observe(ContentObserver::class);
        Page::observe(PageObserver::class);
        Menu::observe(MenuObserver::class);
        Office::observe(OfficeObserver::class);
        MenuSetting::observe(MenuSettingObserver::class);
    }
}
