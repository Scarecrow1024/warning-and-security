<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <section  class="panel">
	<header class="panel-heading">
	    <a href="/group/index" style="color: #9FB6CD">返回</a>
	</header>
	<div class="panel-body">
	<div class="from-group">
		<table  class="table table-hover table-bordered">
	            <tr>
	                <td>报警组名称：</td>
	                <td>
	                    <input type="text" class="form-control" name="group_name" value="<?php echo $data['group_name']?>">
	                </td>
	            </tr>
	            <tr>
	                <td>报警组成员：</td>
	                <td>
	                    <div class="form-group">
	                    <?php foreach($users as $k=>$v){?>
	                    <?php if(in_array($v['uid'],json_decode($data['users'],true)))
	                                $check = 'checked="checked"';
	                            else 
	                                $check = '';
	                        ?>
	                        <label class="radio-inline">
	                            <input <?php echo $check?> type="checkbox" name="users[]" value="<?=$v['uid']?>"><?php echo $v['username']?>
	                        </label>
	                        <?= (($k+1)%5==0)?'<br>':'';?>
	                    <?php }?>
	                    </div>
	                </td>
	            </tr>
	            
	        </table>
	</div>
	</div>
	</section>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '更新报警组', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
