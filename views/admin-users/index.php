<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AdminUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员列表';
$this->params['breadcrumbs'][] = '管理员列表';
?>
<div class="admin-users-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            /*[
                'class' => 'yii\grid\CheckboxColumn',
                // 在此配置其他属性
            ],*/
            [
                'label' => '用户名',
                'options' => ['width' => '120px;'],
                'attribute' => 'username',
            ],
            [
                'label' => '姓名',
                'options' => ['width' => '120px;'],
                'attribute' => 'real_name',
            ],
            [
                'label' => '手机',
                'options' => ['width' => '120px;'],
                'attribute' => 'phone',
            ],
            [
                'label' => '邮箱',
                'options' => ['width' => '140px;'],
                'attribute' => 'mail',
            ],
            // 'authKey',
            // 'secret',
            // 'salt',
            [
                'label' => '创建时间',
                'options' => ['width' => '140px;'],
                'attribute' => 'created',
            ],
            // 'updated',
            [
                'label' => '状态',
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', app\models\AdminUsers::getStatus(), ['class' => 'form-control']),
                'value' => function ($data) {
                    return app\models\AdminUsers::getStatus()[$data->status];
                },
            ],
            [
                'label' => '二次验证',
                'attribute' => 'google_status',
                'filter' => Html::activeDropDownList($searchModel, 'google_status', app\models\AdminUsers::getStatus(), ['class' => 'form-control']),
                'value' => function ($data) {
                    return app\models\AdminUsers::getStatus()[$data->google_status];
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '更多操作',
                'headerOptions'=> ['width'=> '200'],
                'template' => '{reset-pass}&nbsp;&nbsp;{reset-two}&nbsp;&nbsp;{open-two}',
                "buttons" => [
                    "open-two" => function($url, $model)
                    {
                        $options = [
                            'title' => $model->google_status == 1 ? '关闭二次验证' : '开启二次验证',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if ($model->status == 1)
                        {
                            if ($model->google_status == 1)
                                return Html::a('<button class="btn btn-sm btn-warning">关闭二次验证</button>', $url, $options);
                            else
                                return Html::a('<button class="btn btn-sm btn-success">开启二次验证</button>', $url, $options);
                        }
                    },
                    "reset-two" => function ($url, $model)
                    {
                        $options = [
                            'title' => '重置二次验证秘钥',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        if ($model->status == 1)
                            return Html::a('<button class="btn btn-sm btn-github" style="background-color: #777699">重置秘钥</button>', $url, $options);
                    },
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{view} {update} {delete}',
                'header' => '基本操作',
                'headerOptions' => ['width' => '140'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(Html::tag('span', '', ['class' => "glyphicon fa fa-eye"]), ['admin-users/view', 'id'=>$model->uid], ['class' => "btn btn-xs btn-success", 'title' => '查看']);
                    },
                    'update' => function ($url, $model, $key) use($uid){
                          return Html::a('更新', ['admin-users/update','id'=>$model->uid], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                            return Html::a('删除', ['admin-users/delete', 'id' => $model->uid], ['class' => "btn btn-xs btn-danger",'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ]]);
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
