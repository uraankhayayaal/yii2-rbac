<?php

namespace ayaalkaplin\rbac;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    public $controllerNamespace = 'ayaalkaplin\rbac\controllers';
    
    public function init(){
        parent::init();
    }
}