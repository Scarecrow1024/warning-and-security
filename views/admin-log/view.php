<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\AdminLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '日志'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-view" style="margin: 30px;">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user',
            'type',
            'preview',
            'times',
            'details:ntext',
        ],
    ]) ?>

</div>
