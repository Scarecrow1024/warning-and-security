<?php
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
	use yii\helpers\Url;

$this->title = '告警员列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form=ActiveForm::begin();?>
    <table class="table" cellpadding="3" cellspacing="1">
        <tr>
            <th >用户名</th>
            <th >手机</th>
            <th >邮箱</th>
            <th >所属组</th>
            <th>操作</th>
        </tr>    
        <?php foreach($data as $k=>$v){?>      
        <tr>
            <td><?php echo $v['username']?></td>
            <td><?php echo $v['phone']?></td>
            <td><?php echo $v['email']?></td>
            <td><?php echo $v['role_name']?></td>
            <td>
                <a href="/warning/user/edit?id=<?php echo $v['id']?>" title="编辑">编辑</a>
                 |
                <a href="/warning/user/del?id=<?php echo $v['id']?>" onclick="return confirm('确定要删除吗？');" title="移除">移除</a>
            </td>
        </tr>
        <?php }?>
    </table>
    
<?php ActiveForm::end();?>

<script type="text/javascript">
    function compression(str){
        if(str.length == 0){
            return 0;
        }
        var len = str.length;
        var str2="";
        var i=0;
        var num=1;
        while(i<len){
            if(str.charAt(i)==str.charAt(i+1)){
                num++;
            }else{
                str2+=num;
                str2+=str.charAt(i);
                num = 1;
                }
            i++;   
        }
        return str2;
    }
    //alert(compression('aaabbcabbbbd'));
</script>