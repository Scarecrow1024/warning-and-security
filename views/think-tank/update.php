<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ThinkTank */

$this->title = '更新漏洞: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Think Tanks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="think-tank-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
