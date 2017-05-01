<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
?>
<?php $form=ActiveForm::begin();?>
<div class="from-group">
	<table class="table" cellpadding="3" cellspacing="1">
        <tr>
            <th>异常名称</th>
            <th>异常标识</th>
            <th>通知类型</th>
            <th>异常描述</th>
            <th>操作</th>
        </tr>
        <?php foreach($data as $v){?>
            <tr>
                <td><?php echo $v['event_name']?></td>
                <td><?php echo $v['event_token']?></td>
                <td><?php echo $v['event_type']?></td>
                <td><?php echo $v['event_desc']?></td>
                <td>
                    <a href="edit?id=<?php echo $v['id']?>" title="编辑">编辑</a> |
                    <a href="del?id=<?php echo $v['id']?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
                </td>
            </tr>
        <?php }?>
        <strong style="color:red">0表示只发送邮件通知，1表示发送短信通知，2表示发送邮件和短信通知</strong>
    </table>
</div>
<?php ActiveForm::end();?>