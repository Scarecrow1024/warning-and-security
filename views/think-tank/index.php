<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ThinkTankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '知识库列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .pagination{
        float: right;
    }
</style>
<div class="think-tank-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="float: right;" class="btn-group">
        <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal1">添加</button>
        <!-- <a class="btn btn-primary" href="/group/add" type="button">添加部门</a> -->
    </div>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'source',
            'desc',
            [
                'label' => '漏洞类型',
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', app\models\ThinkTank::getStatus(), ['class' => 'form-control']),
                'value' => function ($data) {
                    return ['' => '全部',
                            1 => 'XSS',
                            2 => 'SQL注入',
                            3 => '命令执行',
                            4 => '文件包含',
                            5 => '任意文件操作',
                            6 => '权限绕过',
                            7 => '逻辑漏洞',
                            8 => '存在后门',
                            9 => '信息泄露',
                            10 => '任意文件上传',
                            11 => '弱口令',
                            12 => '本地提权',
                        ][$data->type];
                },
            ],
            'time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">添加知识库</h4>
      </div>
      <?php $form=ActiveForm::begin([
            'method' => 'post',
            'action' => '/think-tank/create'
        ]);?>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputPassword1">漏洞名称：</label>
            <input type="text" id="thinktank-name" class="form-control" name="ThinkTank[name]" maxlength="32" aria-invalid="false">
        </div>
        <div class="form-group field-thinktank-source">
            <label class="control-label" for="thinktank-source">漏洞来源</label>
            <input type="text" id="thinktank-source" class="form-control" name="ThinkTank[source]" maxlength="32">
        </div>
        <div class="form-group field-thinktank-desc">
            <label class="control-label" for="thinktank-desc">漏洞描述</label>
            <input type="text" id="thinktank-desc" class="form-control" name="ThinkTank[desc]" maxlength="128">
        </div>
        <div class="form-group field-thinktank-type">
            <label class="control-label" for="thinktank-type">漏洞类型</label>
            <select name="ThinkTank[type]" class="form-control">
                <option value="1">XSS</option>
                <option value="2">SQL注入</option>
                <option value="3">命令执行</option>
                <option value="4">文件包含</option>
                <option value="5">任意文件操作</option>
                <option value="6">权限绕过</option>
                <option value="7">逻辑漏洞</option>
                <option value="8">存在后门</option>
                <option value="9">信息泄露</option>
                <option value="10">任意文件上传</option>
                <option value="11">弱口令</option>
                <option value="12">本地提权</option>
            </select>
        </div>
        <div hidden class="form-group field-thinktank-time">
            <label class="control-label" for="thinktank-time">添加时间</label>
            <input type="text" id="thinktank-time" class="form-control" value="<?php echo date('Y-m-d H:i:s', time())?>" name="ThinkTank[time]">
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

<?php Pjax::end(); ?></div>
