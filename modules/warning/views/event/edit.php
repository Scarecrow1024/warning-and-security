<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Url;

$this->title = '编辑异常事件';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form=ActiveForm::begin([
    'method'=>'post',
    ]);?>
    <table class="table" cellspacing="1" cellpadding="3" width="100%">
                <input type="hidden" name="id" value="<?php echo $data['id']?>">
            <tr>
                <td>异常事件名称：</td>
                <td>
                    <input class="form-control"  type="text" name="event_name" value="<?php echo $data['event_name']?>" />
                </td>
            </tr>
            <tr>
                <td>异常唯一代码标识：</td>
                <td>
                    <input class="form-control"  type="text" name="event_token" value="<?php echo $data['event_token']?>" />
                </td>
            </tr>
            <tr>
                <td>异常类型：</td>
                <td>
                    <?php for($i=0;$i<=2;$i++){?>
                    <?php $checked="checked=''"?>
                    <input type="radio" name="event_type" <?php if($i==$data['event_type']){echo $checked;}?> value="<?php echo $i?>" />
                    <?php if($i==0){echo "邮件通知";}?>
                    <?php if($i==1){echo "短信通知";}?>
                    <?php if($i==2){echo "发送短信和邮件通知";}?>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>异常简单描述：</td>
                <td>
                    <input class="form-control"  type="text" name="event_desc" value="<?php echo $data['event_desc']?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <?= Html::submitButton('修改事件',['class' => 'btn btn-primary']) ?>
                    <input type="reset" class="btn btn-info" value=" 重置 " />
                </td>
            </tr>
        </table>
<?php ActiveForm::end();?>

