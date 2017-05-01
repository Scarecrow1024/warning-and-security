<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ThinkTank */

$this->title = 'Create Think Tank';
$this->params['breadcrumbs'][] = ['label' => 'Think Tanks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="think-tank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
