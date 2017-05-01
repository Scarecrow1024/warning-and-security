

<div class="admin-dashboard">
<?php print_r($data)?>
    <div class="container">   
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
        编辑自定义菜单
      </button>
      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel">自定义列表</h4>
            </div>
            <div class="modal-body">
              <ul class="list-group">
                <?php foreach($data as $k=>$v){?>
                    <li class="list-group-item"><?php echo $v['name']?><br>
                    <?php foreach($v as $kk=>$vv){?>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="<?php echo $kk?>" name="<?php echo $k[]?>" value="">
                        </label>
                    <?php }?>
                    </li>
                <?php }?>
              </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
    </div>
</div>
