<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ThinkTank */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Think Tanks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="think-tank-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'source',
            'desc',
            'type',
            'time',
        ],
    ]) ?>

</div>
