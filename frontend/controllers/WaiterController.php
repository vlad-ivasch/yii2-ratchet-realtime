<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 02.12.2016
 * Time: 11:46
 */

namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\models\Meals;
use common\models\Seat;
use common\models\Order;
use Yii;
use common\sockets\Pusher;
use yii\filters\AccessControl;

class WaiterController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['waiterManage'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $orders = Order::find()->where(['waiter_id' => Yii::$app->user->id])->all();

        return $this->render('index', ['orders' => $orders]);
    }

    public function actionCreate()
    {
        $meals = ArrayHelper::map(Meals::find()->all(), 'id', 'name');
        $seats = ArrayHelper::map(Seat::find()->all(), 'id', 'id');

        $order = new Order();


        if ($post = Yii::$app->request->post()) {
            $order->status = 0;
            $order->waiter_id = Yii::$app->user->id;
            if ($order->load($post) && $order->validate()) {

                $order->save();

                $entryData = array(
                    'topic_id' => Pusher::TOPIC_NEW_ORDER,
                    'meal' => $order->meal->name,
                    'seat' => $order->seat->id,
                    'id' => $order->id,
                    'waiter' => $order->waiter->username
                );

                Pusher::sendDataToServer($entryData);

                //return $this->render('index',['orders' => Order::find()->all()]);
                return $this->redirect('index');
            }


        }

        return $this->render('create', ['order' => $order, 'meals' => $meals, 'seats' => $seats]);


    }

}