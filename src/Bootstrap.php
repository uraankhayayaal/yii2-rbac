<?php

namespace ayaalkaplin\rbac;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface{

    public function bootstrap($app)
    {
        $app->setModule('rbac', 'ayaalkaplin\rbac\Module');
        
        $app->getUrlManager()->addRules([
            'rbac' => 'rbac/user/index',
        ], false);
    }
}