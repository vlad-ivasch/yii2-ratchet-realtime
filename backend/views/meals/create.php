<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Meals */

$this->title = 'Create Meals';
$this->params['breadcrumbs'][] = ['label' => 'Meals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="meals-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
