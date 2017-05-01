<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="ThemeBucket">
  <link rel="shortcut icon" href="#" type="image/png">

  <title>Blank Page</title>

  <link href="/public/css/style.css" rel="stylesheet">
  <link href="/public/css/style-responsive.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/public/js/html5shiv.js"></script>
  <script src="/public/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <a href="index.html"><img src="/public/images/logo.png" alt=""></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"><img src="/public/images/logo_icon.png" alt=""></a>
        </div>
        <!--logo and iconic logo end-->


        <div class="left-side-inner">

            <!-- visible to small devices only -->
            <div class="visible-xs hidden-sm hidden-md hidden-lg">
                <div class="media logged-user">
                    <img alt="" src="/public/images/photos/user-avatar.png" class="media-object">
                    <div class="media-body">
                        <h4><a href="#">John Doe</a></h4>
                        <span>"Hello There..."</span>
                    </div>
                </div>

                <h5 class="left-nav-title">Account Information</h5>
                <ul class="nav nav-pills nav-stacked custom-nav">
                    <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a></li>
                    <li><a href="#"><i class="fa fa-cog"></i> <span>Settings</span></a></li>
                    <li><a href="#"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>
                </ul>
            </div>

            <!--sidebar nav start-->
            <ul class="nav nav-pills nav-stacked custom-nav">
                <li><a href="index.html"><i class="fa fa-home"></i> <span>WARNING</span></a></li>
                <li class="menu-list nav-active"><a href=""><i class="fa fa-laptop"></i> <span>报警员管理</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="/user/index">报警员列表</a></li>
                        <li><a href="/user/add">添加报警员</a></li>

                    </ul>
                </li>
                <li class="menu-list nav-active"><a href=""><i class="fa fa-book"></i> <span>报警组管理</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="/role/index"> 报警组列表</a></li>
                        <li><a href="/role/add"> 添加报警组</a></li>
                    </ul>
                </li>
                <li class="menu-list nav-active"><a href=""><i class="fa fa-cogs"></i> <span>异常管理</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="/event/index"> 异常列表</a></li>
                        <li><a href="/event/add"> 添加异常</a></li>

                    </ul>
                </li>
                <li ><a href=""><i class="fa fa-bar-chart-o"></i> <span>系统优化</span></a>
                </li>
                
                <li><a href="/login/lgout"><i class="fa fa-sign-in"></i> <span>退出系统</span></a></li>

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">

        <!--toggle button start-->
        <a class="toggle-btn"><i class="fa fa-bars"></i></a>
        <!--toggle button end-->

        <!--search start-->

        <!--search end-->

        <!--notification menu start -->
        <div class="menu-right">
            <ul class="notification-menu">
                
                
                <?php if(isset($_SESSION['isLogin'])){ ?>
                <li>
                    <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <img src="/public/images/photos/user-avatar.png" alt="" />
                        <?php echo $_SESSION['username']?>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                        <li><a href="/login/lgout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                    </ul>
                </li>
                <?php }?>

            </ul>
        </div>
        <!--notification menu end -->

        </div>
        <!-- header section end-->

        <!-- page heading start-->
        <div class="page-heading">
            
        </div>
        <!-- page heading end-->

        <!--body wrapper start-->
        <div class="wrapper">
            <?= $content;?>
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer class="sticky-footer">
            2014 &copy; AdminEx by ThemeBucket
        </footer>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/public/js/jquery-1.10.2.min.js"></script>
<script src="/public/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/public/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/modernizr.min.js"></script>
<script src="/public/js/jquery.nicescroll.js"></script>


<!--common scripts for all pages-->
<script src="/public/js/scripts.js"></script>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
