<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;
    use app\common\widgets\ueditor\Ueditor;
?>
<?php $form=ActiveForm::begin([
    'method'=>'post',
    ]);?>

    <table class="table" cellspacing="1" cellpadding="3" width="100%">
            <tr>
                <td>异常事件名称：</td>
                <td>
                    <input class="form-control"  type="text" name="event_name" value="" />
                </td>
            </tr>
            <tr>
                <td>异常唯一代码标识：</td>
                <td>
                    <input class="form-control"  type="text" name="event_token" value="" />
                </td>
            </tr>
            <tr>
                <td>异常类型：</td>
                <td>
                    <input type="radio" name="event_type" value="0" />
                        只发邮件
                    <input type="radio" name="event_type" value="1" />
                        只发短信
                    <input type="radio" name="event_type" value="2" />
                        发送邮件和短信
                </td>
            </tr>

            <tr>
                <td>异常简单描述：</td>
                <td>
                    <input class="form-control"  type="text" name="event_desc" value="" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <?= Html::submitButton('添加事件',['class' => 'btn btn-primary']) ?>
                    <input type="reset" class="btn btn-info" value=" 重置 " />
                </td>
            </tr>
        </table>
<?php ActiveForm::end();?>

