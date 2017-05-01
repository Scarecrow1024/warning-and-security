<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
?>
<?php $form=ActiveForm::begin();?>
<div class="from-group">
	<table class="table" cellpadding="3" cellspacing="1">
        <tr>
            <th>报警组名称</th>
            <th>负责的异常</th>
            <th>操作</th>
        </tr>
        <?php foreach($data as $v){?>
            <tr>
                <td><?php echo $v['role_name']?></td>
                <td><?php echo $v['event_name']?></td>
                <td>
                    <a href="edit?id=<?php echo $v['id']?>" title="编辑">编辑</a> |
                    <a href="del?id=<?php echo $v['id']?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a> 
                </td>
            </tr>
        <?php }?>
    </table>
</div>
<?php ActiveForm::end();?>