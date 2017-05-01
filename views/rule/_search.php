<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RuleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rule-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'request_body') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'method') ?>

    <?php // echo $form->field($model, 's_level') ?>

    <?php // echo $form->field($model, 'r_level') ?>

    <?php // echo $form->field($model, 'r_par') ?>

    <?php // echo $form->field($model, 'par_route') ?>

    <?php // echo $form->field($model, 'route') ?>

    <?php // echo $form->field($model, 'reg') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
