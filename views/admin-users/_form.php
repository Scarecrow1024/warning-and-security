<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->label('用户名')->textInput(['maxlength' => 140]) ?>

    <?= $form->field($model, 'password')->label('默认密码')->passwordInput(['maxlength' => 140]) ?>

    <?= $form->field($model, 'real_name')->label('真是姓名')->textInput(['maxlength' => 140]) ?>

    <?= $form->field($model, 'phone')->label('联系方式')->textInput(['maxlength' => 140]) ?>

    <?= $form->field($model, 'mail')->label('通知邮箱')->textInput(['maxlength' => 140]) ?>

    <?= $form->field($model, 'status')->label('管理员状态')->radioList(['1'=>'启用','0'=>'停用']) ?>
    
    <?= $form->field($model, 'google_status')->label('二次验证状态')->radioList(['1'=>'启用','0'=>'停用']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '更新管理员', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
