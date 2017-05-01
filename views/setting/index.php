<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\models\Group;
/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '设置列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    $gs = Group::find()->asArray()->all();
?>
<div class="group-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php Pjax::begin(); ?>

<div class="box box-primary">

<div class="box-body">
<?php $form=ActiveForm::begin([
    'method' => 'post',
    'action' => '/setting/update'
]);?>
    <div class="box-header with-border">
        <div style="float: right;" class="btn-group">
            <!-- Button trigger modal -->
                <button type="submit" class="btn btn-primary btn-md" >更新设置</button>
            <!-- <a class="btn btn-primary" href="/group/add" type="button">添加部门</a> -->
        </div>
    </div><br>
    <div class="form-group col-lg-6">
        <label for="exampleInputPassword1"><b>可用性监控频率</b></label>
        <div>
        <div class="input-group clockpicker col-lg-6" data-placement="top">
            <input type="text" name="frequency" class="form-control" value="<?=$data['frequency']?>">
            <span class="input-group-addon">
                分钟
            </span>
        </div>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label for="exampleInputPassword1"><b>响应时间</b></label>
        <div>
        <div class="input-group clockpicker col-lg-6" data-placement="top">
            <input type="text" name="delay" class="form-control" value="<?=$data['delay']?>">
            <span class="input-group-addon">
                ms
            </span>
        </div>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label for="exampleInputPassword1"><b>发包量</b></label>
        <div>
        <div class="input-group clockpicker col-lg-6" data-placement="top">
            <input type="text" name="number" class="form-control" value="<?=$data['number']?>">
            <span class="input-group-addon">
                个
            </span>
        </div>
        </div>
    </div>
    <div class="form-group col-lg-6">
        <label for="exampleInputPassword1"><b>天眼报警组</b></label>
        <div>
        <div class="input-group clockpicker col-lg-6" data-placement="top">
            <select name="group" class="form-control">
            <?php foreach($gs as $v){?>
                <?php 
                    $selected = "";
                    if($v['id'] == $data['group']){
                        $selected = "selected";
                    }else{
                        $selected = "";
                    }
                ?>
                <option <?=$selected?> value="<?=$v['id']?>"><?=$v['group_name']?></option>
            <?php }?>
            </select>
        </div>
        </div>
    </div>
    
<?php ActiveForm::end();?>

<div class="form-group col-lg-6">
    <div>
    <div class="input-group clockpicker col-lg-6" data-placement="top">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>'upload', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file')->fileInput() ?>

        <button type="submit" class="btn btn-primary btn-sm">导入可用性监控ip</button>

        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>

<div class="form-group col-lg-6">
    <div>
    <div class="input-group clockpicker col-lg-6" data-placement="top">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>'upload2', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file2')->fileInput() ?>

        <button type="submit" class="btn btn-primary btn-sm">导入资产ip</button>

        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>

<div class="form-group col-lg-6">
    <div>
    <div class="input-group clockpicker col-lg-6" data-placement="top">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>'upload3', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file3')->fileInput() ?>

        <button type="submit" class="btn btn-primary btn-sm">导入xss规则</button>

        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>

<div class="form-group col-lg-6">
    <div>
    <div class="input-group clockpicker col-lg-6" data-placement="top">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>'upload4', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file4')->fileInput() ?>

        <button type="submit" class="btn btn-primary btn-sm">导入sql注入规则</button>

        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>
<div class="form-group col-lg-6">
    <div>
    <div class="input-group clockpicker col-lg-6" data-placement="top">
        <?php $form = ActiveForm::begin(['method'=>'post','action'=>'upload5', 'options' => ['enctype' => 'multipart/form-data']]) ?>
        <?= $form->field($model, 'file5')->fileInput() ?>

        <button type="submit" class="btn btn-primary btn-sm">导入文件包含规则</button>

        <?php ActiveForm::end() ?>
    </div>
    </div>
</div>
</div>

</div>

<?php Pjax::end(); ?></div>
