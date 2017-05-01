<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '规则列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">添加规则</button>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'request_body',
            'type',
            'method',
            's_level',
            'r_level',
            'r_par',
            'par_route',
            'route',
            // 'reg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<div style="" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加规则</h4>
      </div>
      <div class="modal-body">

        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => '/rule/create'
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'request_body')->dropDownList(['1'=>'GET','2'=>'POST'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'type')->radioList(['1'=>'WEB扫描','2'=>'端口扫描']) ?>

        <?= $form->field($model, 'method')->dropDownList(['1'=>'框架注入漏洞','2'=>'sql注入漏洞','3'=>'XSS攻击'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 's_level')->dropDownList(['1'=>'基础规则','2'=>'特殊规则'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'r_level')->dropDownList(['1'=>'高危','2'=>'中危','3'=>'低危'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'r_par')->dropDownList(['1'=>'200 ok','2'=>'400 客户端错误','500'=>'服务端异常'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'par_route')->dropDownList(['1'=>'PH状态','2'=>'sql注入漏洞','3'=>'XSS攻击'], ['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'reg')->textInput(['maxlength' => true]) ?>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">添加</button>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    </div>
    </div>
</div>