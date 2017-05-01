<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Scan */

$this->title = '添加扫描';
$this->params['breadcrumbs'][] = ['label' => 'Scans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
