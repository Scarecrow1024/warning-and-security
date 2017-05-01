<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <?php Yii::$app->name='SEC安全平台';?>
    <?= Html::a('<span class="logo-mini">SEC</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']); ?>
    <?php 
        if(Yii::$app->user->isGuest){
            $head_img = $directoryAsset.'/img/user3-128x128.jpg';
        }else{
            if(Yii::$app->user->identity->photo){
                $head_img = Yii::$app->user->identity->photo;
            }else{
                $head_img = $directoryAsset.'/img/user3-128x128.jpg';
            }
        }
    ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo $head_img?>" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php echo Yii::$app->user->identity->username?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?php echo $head_img?>" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?php echo Yii::$app->user->identity->username?> - Developer
                                <small><?php echo date('Y-M-D')?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#myModal">修改资料</button>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    '退出',
                                    ['/login/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                
            </ul>
        </div>
    </nav>
</header>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">更新个人资料</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/admin-users/auth',
            'options' => ['enctype' => 'multipart/form-data']
        ]);?>
      <div class="modal-body">
        <div class="form-group field-thinktank-url">
            <label class="control-label" for="thinktank-url">昵称</label>
            <input type="text" id="thinktank-source" class="form-control" name="username" maxlength="32">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">登录邮箱</label>
            <input type="text" id="thinktank-name" class="form-control" name="mail" maxlength="32" aria-invalid="false">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">联系方式</label>
            <input type="text" id="thinktank-name" class="form-control" name="phone" maxlength="32" aria-invalid="false">
        </div>
        <div class="form-group field-thinktank-ip">
            <label class="control-label" for="thinktank-ip">原密码</label>
            <input type="text" id="asset-ip" class="form-control" name="old_password" maxlength="32">
        </div>
        <div class="form-group field-thinktank-user">
            <label class="control-label" for="thinktank-user">新密码</label>
            <input type="text" id="asset-password" class="form-control" name="password" maxlength="16">
        </div>
        <div class="form-group field-thinktank-user">
            <label class="control-label" for="thinktank-user">确认新密码</label>
            <input type="text" id="asset-user" class="form-control" name="re_password" maxlength="16">
        </div>
        <div class="form-group field-thinktank-user">
          <label class="control-label" for="thinktank-user">更换头像</label>
          <input type="file" id="exampleInputFile" name="photo">
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
