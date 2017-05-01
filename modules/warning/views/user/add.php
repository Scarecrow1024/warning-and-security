<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;

$this->title = '添加告警员';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form=ActiveForm::begin([
        'method' => 'post',
    ]);?>
<div class="from-group">
	<table cellspacing="1" class="table" cellpadding="3" width="100%">
            <tr>
                <td>
                    <strong>选择分组：</strong>
                    <?php foreach ($roles as $k => $v): ?>
                        <input type="checkbox" name="role_id[]" value="<?php echo $v['id']; ?>" />
                        <?php echo $v['role_name']; ?>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'username') ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'phone') ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $form->field($model, 'email') ?>
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
</div>
<?php ActiveForm::end();?>