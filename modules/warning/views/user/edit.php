<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;

$this->title = '编辑告警员';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form=ActiveForm::begin([
        'method' => 'post',
        'action'=>'doedit',
    ]);?>
<div class="from-group">
	<table  class="table table-hover table-bordered">
            <tr>
                <td><strong>选择分组：</strong></td>
                <td>             
                    <?php foreach ($roles as $k => $v): 
                            if(strpos(','.$data['role_id'].',', ','.$v['id'].',') !== FALSE)
                                $check = 'checked="checked"';
                            else 
                                $check = '';
                    ?>
                        <input <?php echo $check; ?> type="checkbox" name="role_id[]" value="<?php echo $v['id']; ?>" />
                        <?php echo $v['role_name']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <input type="hidden" class="form-control" name="id" value="<?php echo $data['id']?>">
            <tr>
                <td>姓名：</td>
                <td>
                    <input type="text" class="form-control" name="username" value="<?php echo $data['username']?>">
                </td>
            </tr>
            <tr>
                <td>手机号：</td>
                <td>
                    <input type="text" class="form-control" name="phone" value="<?php echo $data['phone']?>">
                </td>
            </tr>
            <tr>
                <td>邮箱：</td>
                <td>
                    <input type="text" class="form-control" name="email" value="<?php echo $data['email']?>">
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <?= Html::submitButton('修改',['class' => 'btn btn-primary']) ?>
                    <input type="reset" class="btn btn-info" value=" 重置 " />
                </td>
            </tr>
        </table>
</div>
<?php ActiveForm::end();?>