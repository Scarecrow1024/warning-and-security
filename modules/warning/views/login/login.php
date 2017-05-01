<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->context->layout = 'login'; //设置使用的布局文件
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'action'=>'login/',
        'method'=>'post',
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <div class="form-group">
                    <div class="col-xs-12  ">
                        <div class="input-group">
                            <span class="input-group-addon">用户名</span>
                            <input type="text" id="username" name="username" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12  ">
                        <div class="input-group">
                            <span class="input-group-addon">密码&nbsp&nbsp&nbsp&nbsp</span></span>
                            <input onclick="msg()" type="password" id="password" name="password" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-xs-12 col-xs-offset-1 ">
                        <button type="submit" style="width: 80%" class="btn btn-primary btn-lg active">Login</button>
                    </div>
                </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    function msg(){
        layer.msg('玩命卖萌中', function(){
        //关闭后的操作
        });
    }   
</script>