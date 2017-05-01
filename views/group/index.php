<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '报警组列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>

<section class="panel">
<header class="panel-heading">
    <div style="float: right;" class="btn-group">
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal1">添加报警组</button>
        <!-- <a class="btn btn-primary" href="/group/add" type="button">添加部门</a> -->
    </div>
</header>
<div class="panel-body">
<?php $form=ActiveForm::begin();?>
    <table class="table table-bordered table-hover dataTable no-footer dtr-inline collapsed" cellpadding="3" cellspacing="1">
        <tr>
            <th style="width:25%">报警组名称</th>
            <th >报警组成员</th>
            <th style="width:15%">操作</th>
        </tr>    
        <?php foreach($data as $k=>$v):?>
        <tr>
            <td><?php echo $v['group_name']?></td>
            <td>
                <?php 
                    foreach(json_decode($v['users']) as $user){
                        foreach($users as $u){
                            if($user == $u['uid']){
                                echo $u['username'],";";
                            }
                        }
                    }
                ?>
            </td>
            <td>
                <div class="btn-group">
                <button id="<?=$v['id']?>" class="btn btn-xs btn-warning" type="button" data-target="#modal-delete" data-toggle="modal" onclick="get_id(this)" data-event="delete">删除</button><a href="/group/update?id=<?=$v['id']?>" id="<?=$v['id']?>" k="<?=$k?>" type="button" class="btn btn-xs btn-danger" >编辑</a>
                </div>
            </td>
        </tr>
        <?php endforeach;?>
    </table>    
<?php ActiveForm::end();?>
</div>
</section>

<?php Pjax::end(); ?></div>

<div style="" class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加报警组</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/group/create'
        ]);?>
      <div class="modal-body">
        <div class="form-group">
        <label for="exampleInputPassword1">名称：</label>
        <input type="text" class="form-control" name="group_name" value=""><br>
        <label for="exampleInputPassword1">成员：</label>
        <div class="form-group">
            <?php foreach($users as $k=>$v){?>
                <label class="radio-inline">
                    <input type="checkbox" name="users[]" value="<?=$v['uid']?>"><?php echo $v['username']?>
                </label>
                <?= (($k+1)%5==0)?'<br>':'';?>
            <?php }?>
        </div>
        <input type="hidden" name="id" id="id" value="">
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">添加</button>
      </div>
      <?php ActiveForm::end();?>
    </div>
  </div>
</div>

<div style="margin-top: 100px;" class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">编辑报警组</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/group/update'
        ]);?>
      <div class="modal-body">
         
        <div class="form-group">
        <label for="exampleInputPassword1">名称：</label>
        <input type="text" class="form-control" id="name" name="group_name" value=""><br>
        <label for="exampleInputPassword1">成员：</label>
        <div class="form-group">
        <?php foreach($users as $k=>$v){?>
            <?php foreach($data as $user){?>
                <?php if(in_array($v['uid'],json_decode($user['users'],true)))
                        $check = 'checked="checked"';
                    else 
                        $check = '';
                ?>
            <?php }?>   
            <label class="radio-inline">
            <input type="checkbox" <?php echo $check?> name="users[]" value="<?=$v['uid']?>"><?php echo $v['username']?>
            </label>
            <?= (($k+1)%5==0)?'<br>':'';?>
        <?php }?>
        </div>
        <input type="hidden" name="id" id="id" value="">
      </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">修改</button>
      </div>
      <?php ActiveForm::end();?>
    </div>
  </div>
</div>

<script type="text/javascript">
    function get_k(obj){
        var id = $(obj).attr('id');
        $('#id').val(id);
        var tr1 = $(obj).parent().parent().parent().children("td").get(0);
        var tr2 = $(obj).parent().parent().parent().children("td").get(1);
        var name = $(tr1).text();
        var email = $(tr2).text();
        $('#name').val(name);
        $('#email2').val(email);
    }

    function get_id(tr){
        var gnl=confirm("确定要删除?");
        if (gnl==true){
            var id = $(tr).attr('id');
            $.get('/group/delete',{id:id},function(res) {
                if(res == 1){
                    $(tr).parent().parent().parent().attr('hidden','true');             
                }else{
                    alert('删除失败');
                }
            });
        }else{
            return false;
        }
    }
</script>