<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Scan */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Scans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scan-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'domail',
            'type',
            'node',
            'user',
            'status',
            'time',
            'alarm_status',
            'alarm_condition',
            'alarm_group',
        ],
    ]) ?>

</div>
