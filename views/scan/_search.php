<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ScanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="scan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'domail') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'node') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'alarm_status') ?>

    <?php // echo $form->field($model, 'alarm_condition') ?>

    <?php // echo $form->field($model, 'alarm_group') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
