<?php
$this->title = '两步验证';
?>
<style>
    .login-img3-body .login-form{
        max-width: 550px;
        background-color: transparent;
        border: 0;
    }
    .login-form input[type="text"]{
        border: 1px solid #ccc;
        height: 34px;
        line-height: 34px;
        font-size: 14px;
        border-radius: 4px;
        vertical-align: middle;
    }
    .input-group-btn{
        vertical-align: middle;
        white-space: nowrap;
        width: 1%;
    }
    .input-group-addon,.input-group-btn{
        font-size: 0;
        position: relative;
        white-space: nowrap;
    }

    .login-form .input-group-addon{
        padding: 0;
    }
    .login-form .btn{
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .input-group{
        width: 250px;
        margin: 0 auto;
    }
    .panel{
        height: 200px;
    }
    .panel-body{
        margin-top:44px;
    }
    .container{
        width: 30%;
        margin-top: 10%;
    }
    .panel-warning{
        margin-left: 20%;
        margin-right: auto;
    }
</style>
<body class="login-img3-body" onload="window.conForm.code.focus()">
<div class="container">
    <div class="login-wrap login-form">
        <div class="panel">
            <div class="panel-heading">
                <b>输入动态口令</b>
                <a href="logout" class="btn btn-sm pull-right btn-danger">取消</a>
            </div>
            <div class="panel-body">
                <div class="panel-warning"><?=Yii::$app->session->getFLash('errorMsg')?></div>
                <form class="" name="conForm" action="" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control" name="code">
                        <input type="hidden" name="_csrf">
                        <span class="input-group-addon">
                            <input class="btn btn-primary" type="submit" value="上吧,小火龙">
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
