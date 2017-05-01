<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\bootstrap\Alert;
//$this->context->layout = false;
//AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0" />
<title>Bootstrap响应式登录界面模板</title>
<link rel="stylesheet" type="text/css" href="/public/css/bootstrap.min.css" />
<meta http-equiv="refresh" content="3;url=<?php echo $error['backurl']?>"> 
</head>
<body>
<div style="text-align: center;margin-left: 30%;
margin-top: 10%;" class="col-md-4">
	<div class="panel panel-danger" style="height: 400px;"><p style="padding-top: 150px;font-size: 20px ;color: red"><strong><?php echo $error['error']?></strong></p><br><p style="font-size: 20px">等待3秒后跳转</p></div>
</div>

<?php
	echo Alert::widget([
      'options' => ['class' => 'alert-info'],
      'body' => Yii::$app->session->getFlash('greeting'),
    ]);
?>


<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
