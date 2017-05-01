<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
?>
<?php $form=ActiveForm::begin([
        'method' => 'post',
    ]);?>
<div class="from-group">
	<table  class="table table-hover table-bordered">
            <tr>
                <td><strong>选择异常事件：</strong></td>
                <td>             
                    <?php foreach ($events as $k => $v): 
                            if(strpos(','.$data['event_id'].',', ','.$v['id'].',') !== FALSE)
                                $check = 'checked="checked"';
                            else 
                                $check = '';
                    ?>
                        <input <?php echo $check; ?> type="checkbox" name="event_id[]" value="<?php echo $v['id']; ?>" />
                        <?php echo $v['event_name']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <input type="hidden" class="form-control" name="id" value="<?php echo $data['id']?>">
            <tr>
                <td>报警组名称：</td>
                <td>
                    <input type="text" class="form-control" name="role_name" value="<?php echo $data['role_name']?>">
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