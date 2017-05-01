<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Scan */

$this->title = 'Update Scan: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
