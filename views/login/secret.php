<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<script src="//cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
<?=Html::jsFile('@web/js/qrcode.js')?>
<style>
    .login-page{
        overflow: hidden;
    }
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

    .login-form {
        padding: 0;
    }
    .login-form .btn{
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .panel{
        height: 460px;
    }
    .panel-body{
        margin-top:10px;
    }
    .panel-heading{
        margin-botom: ;
    }
    .container{
        width: 700px;
        margin-top: 5%;
    }
    canvas{
        margin-left: auto;
        display: block;
        margin-right: auto;
        margin-bottom: 10px;
    }
    #secret{
        margin-left: auto;
        display: block;
        margin-right: auto;
        text-align: center;
        width: 180px;
    }
    .google{
        margin-left: auto;
        display: block;
        margin-right: auto;
        width: 180px;
    }
    img{
        margin-left: auto;
        display: block;
        margin-right: auto;
    }

</style>

<body class="login-img3-body">
<div class="container">
    <div class="login-wrap login-form">
        <div class="panel">
            <div class="panel-heading">
                <b> 首次登陆需要绑定二次验证，请用洋葱或者谷歌身份验证器扫描此二维码，扫描成功后请重新登陆。</b>
            </div>
            <div class="panel-body">

                <div  class="col-md-12" id="qrcode"></div>

                <input id="secret" class="col-md-offset-4" type="text" value="<?php echo $secret; ?>" disabled>
                <br/>
                <a class="btn btn-info col-md-offset-4 google">已经扫描．返回登录页面</a>


                <div id="googleurl" hidden>otpauth://totp/sec@zyf?secret=<?php echo $secret; ?></div>

                <div id = 'user_name' style="display: none"><?="demo"?></div>

                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">

            </div>
        </div>
    </div>
</div>
</body>

<script>
    googleurl = $("#googleurl").text();
    var qrcode = new QRCode('qrcode', {
        text: googleurl,
        width: 180,
        height: 180,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });
    $('.google').click(function(){
        var secret = $("#secret").val();
        var csrfToken = $('#_csrf').val();
        $.post('/login/secret',{_csrf:csrfToken,'secret':secret},function(res){
            if(res){
                location.href = '/login/login';
            }else{
                alert(res);
            }
        })
    })
</script>