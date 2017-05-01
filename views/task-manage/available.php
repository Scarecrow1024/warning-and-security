<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
  use yii\widgets\LinkPager;
  use app\models\Group;
  use yii\widgets\Pjax;
  $this->title = '可用性监控';
?>

<?php 
  $groups = Group::find()->asArray()->all();
  $gs = [];
  foreach($groups as $group){
    $gs[$group['id']] = $group['group_name'];
  }
?>

<?=Html::jsFile('@web/js/echarts.min.js')?>
<style type="text/css">
    .pagination-box .input-group {
        margin: 20px 10px;
    }
    .pageSize-box {
        display: inline-block;
        width: 80px;
        margin-left: 10px;
        vertical-align: middle;
    }
</style>
<?php Pjax::begin(); ?>
<div class="box">
<div class="box-header">
    <button type="submit" data-toggle="modal" data-target="#myModal1" class="btn btn-primary">添加监控</button>  
</div>
<!-- /.box-header -->
<div class="box-body no-padding">
  <table class="table">
    <tbody><tr>
      <th style="width: 10px">#</th>
      <th>名称</th>
      <th>监控对象</th>
      <th>电信响应时间(ms)</th>
      <th>联通响应时间(ms)</th>
      <th>更新时间</th>
      <th>报警组</th>
      <th>操作</th>
    </tr>
    <?php foreach($data as $k=>$v){?>
    <tr>
      <td><?php echo $v['id']?>.</td>
      <td><?php echo $v['name']?></td>
      <td><?php echo $v['addr']?></td>
      <td><?php echo intval($v['ct'])?></td>
      <td><?php echo intval($v['cu'])?></td>
      <td><?php echo $v['upd_data']?></td>
      <td>
      <?php 
        $count = count(json_decode($v['report_group'],true));
        for($i=0;$i<$count;$i++){
          echo "<span class='label label-warning'>".$gs[json_decode($v['report_group'],true)[$i]]."</span>";
        }
      ?>
      </td>
      <td>
        <a class="label label-success">配置</a> <a class="label label-success">订阅警报</a> <a onclick="del(this)" id="<?php echo $v['id']?>" class="label label-success">删除</a>
      </td>
    </tr>
    <?php }?>
  </tbody></table>
</div>
<div class="box-footer clearfix" >
<div class="pagination-box pull-right">
    <nav class="pull-right">
        <?php echo LinkPager::widget([
            'firstPageLabel' => '&laquo;&laquo;',
            'lastPageLabel' => '&raquo;&raquo;',
            'pagination' => $pages,
        ]);?>
    </nav>
</div>
</div>
<!-- /.box-body -->
</div>
<?php Pjax::end(); ?>

<div style="margin-top: 0px;" class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel1">添加监控</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/task-manage/create'
        ]);?>
      <div class="modal-body"> 
        <div class="form-group">
          <label for="exampleInputEmail1">监控名称</label>
          <input type="text" class="form-control" name="name" placeholder="">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">监控站点</label>
          <input type="text" class="form-control" name="addr" placeholder="ip/域名">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">告警开关</label>
            <div class="input-group">
              <label class="radio-inline">
                <input type="radio" name="report_status" checked value="1"> 开
              </label>
              <label class="radio-inline">
                <input type="radio" name="report_status" value="0"> 关
              </label>
            </div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">告警组</label>
          <div class="input-group">
          <?php foreach($users as $user){?>
            <label class="radio-inline">
                <input type="checkbox" name="report_group[]" value="<?=$user['id']?>"><?php echo $user['group_name']?>
            </label>
          <?php }?>
          </div>
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

<div style="margin-top: 0px;" class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel2">配置监控</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/task-manage/create'
        ]);?>
      <div class="modal-body"> 
        <div class="form-group">
          <label for="exampleInputEmail1">监控名称</label>
          <input type="text" class="form-control" name="name" placeholder="">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">监控站点</label>
          <input type="text" class="form-control" name="addr" placeholder="ip/域名">
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">告警开关</label>
            <div class="input-group">
              <label class="radio-inline">
                <input type="radio" name="report_status" checked value="1"> 开
              </label>
              <label class="radio-inline">
                <input type="radio" name="report_status" value="0"> 关
              </label>
            </div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">告警组</label>
          <div class="input-group">
          <?php foreach($users as $user){?>
            <label class="radio-inline">
                <input type="checkbox" name="report_group[]" value="<?=$user['id']?>"><?php echo $user['group_name']?>
            </label>
          <?php }?>
          </div>
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

<script type="text/javascript">
  function del(tr){
      var gnl=confirm("确定要删除?");
        if (gnl==true){
            var id = $(tr).attr('id');
            $.get('/task-manage/del',{id:id},function(res) {
                if(res == 1){
                    $(tr).parent().parent().attr('hidden','true');             
                }else{
                    alert('删除失败');
                }
            });
        }else{
            return false;
        }
  }
</script>