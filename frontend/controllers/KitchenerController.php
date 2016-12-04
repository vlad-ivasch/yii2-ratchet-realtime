<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 02.12.2016
 * Time: 16:05
 */

namespace frontend\controllers;


use yii\web\Controller;
use common\models\Order;
use Yii;
use common\sockets\Pusher;
use yii\filters\AccessControl;

class KitchenerController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['kitchenrManage'],
                    ],
                ],
            ],
        ];
    }

    function actionIndex()
    {
        $orders = Order::find()->where(['<', 'status', '2'])->all();

        return $this->render('index', ['orders' => $orders]);
    }

    function actionChangeStatus()
    {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $order = Order::findOne(['id' => $data['id']]);

            if ($order) {
                $order->status = 1;
                $order->cooking_time = (int)$data['time'];
                $order->date = date('Y-m-d H:i:s', time());
                $order->save();

                $entryData = array(
                    'topic_id' => Pusher::TOPIC_STATUS_CHANGED,
                    'id' => $data['id'],
                    'time' => $data['time'],
                    'timeStart' => date('D M d Y H:i:s O', time() + (intval($data['time']) * 60)),
                    'status' => 1

                );
                Pusher::sendDataToServer($entryData);


            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'timeStart' => date('D M d Y H:i:s O', time() + (intval($data['time']) * 60)),
            ];
        }

    }

    function actionDone()
    {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $order = Order::findOne(['id' => $data['id']]);

            if ($order) {
                $order->status = 2;
                $order->save();

                $entryData = array(
                    'topic_id' => Pusher::TOPIC_STATUS_CHANGED,
                    'id' => $data['id'],
                    'status' => 2

                );
                Pusher::sendDataToServer($entryData);


            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 2
            ];
        }

    }


}