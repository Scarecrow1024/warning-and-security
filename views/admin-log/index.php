<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '日志');
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/static/js/message_result.js',
    ['depends' => 'app\assets\AppAsset']);
?>
<style>
    .pagination{
        float: right;
    }
</style>

<div class="admin-log-index">


    <div class="box">
    <div class="box-header">
    <?= Html::a(Yii::t('app', '导出'), ['export'], ['class' => 'btn btn-success','style'=>'float:right']) ?>
    </div>
    
    <div class="box-body no-padding">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
          //  'user',
            [
                'label' => '用户',
                'filter' => Html::activeTextInput($searchModel, 'user', ['class' => 'form-control']),
                'value' => 'user',
            ],

          //  'type',
            [
                'label' => '日志类型',
                'filter' => Html::activeTextInput($searchModel, 'type', ['class' => 'form-control']),
                'value' => 'type',
            ],

          //  'preview',
            [
                'label' => '内容预览',
                'filter' => Html::activeTextInput($searchModel, 'preview', ['class' => 'form-control']),
                'value' => 'preview',
            ],
            [
                'label' => '时间',
              //  'filter' => Html::activeTextInput($searchModel, 'times', ['class' => 'form-control']),
                'value' => 'times',
            ],
           // 'times',
            // 'details:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                //  'headerOptions'=> ['width'=> '190'],
                'template' => '{view}',
                "buttons" => [
                    "view" => function ($url)
                    {
                        $options = [
                            'title' => '查看',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<button class="btn btn-sm btn-info">查看</button>', $url, $options);
                    },
                ],
            ],
        ],
    ]); ?>
    </div>
    <div class="box-footer clearfix" >
<div class="pagination-box pull-right">
    <nav class="pull-right">
        <?php echo LinkPager::widget([
            'firstPageLabel' => '&laquo;&laquo;',
            'lastPageLabel' => '&raquo;&raquo;',
            'pagination' => $pages,
        ]);?>
    </nav>
</div>
</div>
</div>

</div>

<script>
function getElementsClass(classnames){ 
    var classobj= new Array();//定义数组 
     
    var classint=0;//定义数组的下标 
     
    var tags=document.getElementsByTagName("*");//获取HTML的所有标签 
     
    for(var i in tags){//对标签进行遍历 
     
    if(tags[i].nodeType==1){//判断节点类型 
     
    if(tags[i].getAttribute("class") == classnames)//判断和需要CLASS名字相同的，并组成一个数组 
     
    { 
     
    classobj[classint]=tags[i]; 
     
    classint++; 
     
    } 
     
    } 
     
    } 
     
    return classobj;//返回组成的数组 
} 

window.onload=function(){
    var a=getElementsClass("summary"); 
    a[0].style.display = "none"; 
    var b=getElementsClass("pagination"); 
    console.log(b[0])
    b[0].style.display = "none"; 
}
</script>