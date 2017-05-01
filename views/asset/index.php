<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '资产管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .pagination{
        
    }
</style>
<div class="asset-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <div style="float: right;" class="btn-group">
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal1">添加</button>
                
        <!-- <a class="btn btn-primary" href="/group/add" type="button">添加部门</a> -->
        </div>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'url:url',
            'ip',
            [
                'label' => '资产类型',
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', ['' => '全部',
                            1 => '内网资产',
                            2 => '外网资产',
                        ], ['class' => 'form-control']),
                'value' => function ($data) {
                    return ['' => '全部',
                            1 => '内网资产',
                            2 => '外网资产',
                        ][$data->type];
                },
            ],
            'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加知识库</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/asset/create'
        ]);?>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputPassword1">资产名称：</label>
            <input type="text" id="thinktank-name" class="form-control" name="Asset[name]" maxlength="32" aria-invalid="false">
        </div>
        <div class="form-group field-thinktank-url">
            <label class="control-label" for="thinktank-url">资产url</label>
            <input type="text" id="thinktank-source" class="form-control" name="Asset[url]" maxlength="32">
        </div>
        <div class="form-group field-thinktank-ip">
            <label class="control-label" for="thinktank-ip">资产ip</label>
            <input type="text" id="asset-ip" class="form-control" name="Asset[ip]" maxlength="32">
        </div>
        <div class="form-group field-thinktank-type">
            <label class="control-label" for="thinktank-type">资产类型</label>
            <select name="Asset[type]" class="form-control">
                <option value="1">内网资产</option>
                <option value="2">外网资产</option>
            </select>
        </div>
        <div class="form-group field-thinktank-user">
            <label class="control-label" for="thinktank-user">资产归属人</label>
            <input type="text" id="asset-user" class="form-control" name="Asset[user]" maxlength="16">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="submit" class="btn btn-primary">添加</button>
      </div>
      <?php ActiveForm::end();?>
    </div>
  </div>
</div>