<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-users-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->uid], [
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
            'uid',
            'username',
            'real_name',
            'phone',
            'mail',
            'authKey',
            'secret',
            'created',
            'updated',
            [
                'label' => '二次验证状态',
                'attribute' => 'status',
                'value'=>function ($model){
                    return $model->status==1?'启用':'停用';   
                }
            ],
            [
                'label' => '二次验证状态',
                'attribute' => 'google_status',
                'value'=>function ($model){
                    return $model->google_status==1?'启用':'停用';   
                }
            ],
            //'google_status',
        ],
    ]) ?>

</div>
