<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Warning System',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if(isset($_SESSION['isLogin'])){
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => $_SESSION['username'], 'url' => ['login/lgout']],  
            ],
        ]);
    }else{
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => '未登录', 'url' => ['login/index']],  
            ],
        ]);
    }   
    NavBar::end();
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php if(isset($_SESSION['isLogin'])){?>
        <div id="leftnav" class="col-md-3">
                <div class="list-group">
                    <!-- 组员管理 -->
                    <a class="list-group-item" data-toggle="collapse" href="#usercollapse" aria-expanded="false" aria-controls="collapseExample">用户管理<span class="caret"></span></a>
                    <div class="collapse" id="usercollapse">
                        <div class="">
                            <div class="list-group">
                                <a href="<?= Url::toRoute(['user/index'])?>" class="list-group-item">用户列表</a>
                                <a href="<?= Url::toRoute(['user/add'])?>" class="list-group-item">添加组员</a>
                            </div>
                        </div>
                    </div>
                    <!-- 分组管理 -->
                    <a class="list-group-item" data-toggle="collapse" href="#resourcecollapse" aria-expanded="false" aria-controls="collapseExample">分组管理<span class="caret"></span></a>
                    <div class="collapse" id="resourcecollapse">
                        <div class="">
                            <div class="list-group">
                                <a href="<?= Url::toRoute(['role/index'])?>" class="list-group-item">分组列表</a>
                                <a href="<?= Url::toRoute(['role/add'])?>" class="list-group-item">
                                添加分组</a>
                            </div>
                        </div>
                    </div>
                    <!-- 异常事件管理 -->
                    <a class="list-group-item" data-toggle="collapse" href="#errorcollapse" aria-expanded="false" aria-controls="collapseExample">异常管理<span class="caret"></span></a>
                    <div class="collapse" id="errorcollapse">
                        <div class="">
                            <div class="list-group">
                                <a href="<?= Url::toRoute(['event/index'])?>" class="list-group-item">异常列表</a>
                                <a href="<?= Url::toRoute(['event/add'])?>" class="list-group-item">添加异常</a>
                            </div>
                        </div>
                    </div>
                    <!-- 退出 -->
                    <a class="list-group-item" data-toggle="collapse" href="#logcollapse" aria-expanded="false" aria-controls="collapseExample">退出系统<span class="caret"></span></a>
                    <div class="collapse" id="logcollapse">
                        <div class="">
                            <div class="list-group">
                                <a href="<?= Url::toRoute(['login/lgout'])?>" class="list-group-item">退出系统</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    <div class="col-md-9">
        <?= $content ?>
    </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
