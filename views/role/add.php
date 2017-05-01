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
                    
                <?php foreach ($events as $k => $v): ?>
                        <input type="checkbox" name="event_id[]" value="<?php echo $v['id']; ?>" />
                        <?php echo $v['event_name']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <input type="hidden" class="form-control" name="id" value="">
            <tr>
                <td>报警组名称：</td>
                <td>
                    <input type="text" class="form-control" name="role_name" value="">
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





