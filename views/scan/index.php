<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ScanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '安全扫描';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .pagination{
        float: right;
    }
</style>
<div class="scan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal1">添加扫描</button>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            'domail',
            [
                'label' => '扫描类型',
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', ['' => '全部',
                            1 => 'WEB扫描',
                            2 => '端口扫描',
                        ], ['class' => 'form-control']),
                'value' => function ($data) {
                    return ['' => '全部',
                            1 => 'WEB扫描',
                            2 => '端口扫描',
                        ][$data->type];
                },
            ],
            'node',
            'user',
            [
                'label' => '扫描状态',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', ['' => '全部',
                            1 => '已完成',
                            2 => '进行中',
                        ], ['class' => 'form-control']),
                'value' => function ($data) {
                    return ['' => '全部',
                            1 => '已完成',
                            2 => '进行中',
                        ][$data->status];
                },
            ],
            'time',
            // 'alarm_status',
            // 'alarm_condition',
            // 'alarm_group',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<div style="" class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加扫描</h4>
      </div>
      <div class="modal-body">
        <?php $form = ActiveForm::begin([
            'method' => 'post',
            'action' => '/scan/create'
        ]); ?>
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'domail')->textInput() ?>
        <?= $form->field($model, 'type')->radioList(['1'=>'WEB扫描','2'=>'端口扫描']) ?>
        <?= $form->field($model, 'node')->radioList(['192.168.0.1'=>'192.168.0.1','192.168.0.2'=>'192.168.0.2','192.168.0.2'=>'192.168.0.2']) ?>
        <?= $form->field($model, 'user')->textInput() ?>
        <?= $form->field($model, 'alarm_status')->radioList(['1'=>'开','0'=>'关']) ?>
        <div class="form-group">
        <label for="exampleInputEmail1">告警条件</label>
            <div class="row">
                <div class="col-xs-4 col-md-4">
                  <input type="text" name="Scan[alarm_condition][]" placeholder="填写高危数量" class="form-control">
                </div>
                <div class="col-xs-4 col-md-4">
                  <input type="text" name="Scan[alarm_condition][]" placeholder="填写中危数量" class="form-control">
                </div>
                <div class="col-xs-4 col-md-4">
                  <input type="text" name="Scan[alarm_condition][]" placeholder="填写低危数量" class="form-control">
                </div>
            </div>
        </div>
        <?= $form->field($model, 'alarm_group')->radioList($group) ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            <button type="submit" class="btn btn-primary">添加</button>
        </div>
    <?php ActiveForm::end(); ?>
    </div>
    </div>
    </div>
</div>