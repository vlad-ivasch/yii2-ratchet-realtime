<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 02.12.2016
 * Time: 13:40
 *
 * @var \common\models\Order orders;
 */

use yii\web\JqueryAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\Order;

$this->registerCssFile(Yii::getAlias('@web/css/timeTo.css'));

$this->registerJsFile(Yii::getAlias('@web/js/jquery.time-to.min.js'), ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::getAlias('@web/js/updateStatus.js'), ['depends' => JqueryAsset::className()]);
$this->registerJsFile(Yii::getAlias('@web/js/socket.js'), ['depends' => JqueryAsset::className()]);


?>


<div class="row">
    <div class="orders col-lg-12">

        <?php
        foreach ($orders as $order):
        switch ($order->status) {
            case 0:
                $icon = "glyphicon-time";
                $panel = "panel-default";
                break;
            case 1:
                $panel = "panel-info";
                $icon = "glyphicon-time";
                break;
            case 2:
                $icon = "glyphicon-ok";
                $panel = "panel-success";
                break;
        }

        ?>
        <div id="order<?= $order->id; ?>" class="panel <?= $panel; ?>">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <span class="mealName"><?= $order->meal->name; ?></span>
                    <span class="glyphicon <?= $icon; ?>"></span>
                </h3>
            </div>
            <div class="panel-body">
                Table <span class="seat"><?= $order->seat->id; ?></span><br>
                Created by <span class="waiter"><?= $order->waiter->username; ?> </span>
                <hr>
                <?php
                if (!$order->date):
                    ?>

                    <div class="cookingTimeWrapper">
                        Cooking time<br>
                        <input type="text" name="timeCooking">
                        <?= Html::button('Start', ['data' => ['id' => $order->id], 'class' => 'status-button btn-success']); ?>

                    </div>
                    <?php
                else:
                ?>
                Cooking time: <?= $order->cooking_time; ?> minutes <br>

                <?php

                $timeleft = ($order->cooking_time * 60) + strtotime($order->date) - time();
                if ($timeleft > 0 && $order->status < 2):
                    ?>
                    <div class="countdown" data-date="<?= date('D M d Y H:i:s', 3600 + $timeleft + time()); ?>"></div>
                    <?php
                endif;
                ?>

                <button type="button" class="done-button btn-success" data-id="<?= $order->id; ?>">Done</button>
            </div>

            <?php
            endif;
            ?>


        </div>


    </div>
    <?php
    endforeach;
    ?>
</div>
</div>