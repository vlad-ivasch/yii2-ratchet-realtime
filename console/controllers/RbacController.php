<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 19.11.2016
 * Time: 13:59
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {

        $auth = Yii::$app->authManager;

        $kitchener = $auth->createPermission('kitchenrManage');
        $kitchener->description = 'kitchener';
        $auth->add($kitchener);

        $waiter = $auth->createPermission('waiterManage');
        $waiter->description = 'waiter';
        $auth->add($waiter);

        $adminManage = $auth->createPermission('adminManage');
        $adminManage->description = 'admin managet';
        $auth->add($adminManage);

        $user = $auth->createRole('kitchener');
        $auth->add($user);
        $auth->addChild($user, $kitchener);


        $user = $auth->createRole('waiter');
        $auth->add($user);
        $auth->addChild($user, $waiter);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $auth->assign($admin, 1);


    }

}