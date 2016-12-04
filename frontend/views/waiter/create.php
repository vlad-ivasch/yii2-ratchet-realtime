<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 02.12.2016
 * Time: 11:50
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\JqueryAsset;

?>

<div class="row">

    <?php
    $form = ActiveForm::begin();
    ?>

    <?= $form->field($order, 'meal_id')->dropDownList($meals); ?>
    <?= $form->field($order, 'seat_id')->dropDownList($seats); ?>

    <?= Html::submitButton('Create order', ['id' => 'test']) ?>


    <?php ActiveForm::end(); ?>
</div>


