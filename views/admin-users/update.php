<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminUsers */

$this->title = '更新管理员: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->uid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-users-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
