<?php

namespace app\modules\warning\controllers;
//namespace app\controllers;

use yii;
use yii\web\Controller;
use app\modules\warning\models\Event;
use yii\db\Query;
use app\controllers\BaseController;

class EventController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actions(){
        return [
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }


    public function actionIndex()
    {
        //$model=new Event();
        //使用单例设计模式来实例化
        $model = Event::getInstace();
        $data=$model->find()->asArray()->all();
        return $this->render('index',['data'=>$data]);
    }

    public function actionAdd(){
        if(YII::$app->request->isPost){
            $event_name=Yii::$app->request->post('event_name');
            $event_token=Yii::$app->request->post('event_token');
            $event_desc=Yii::$app->request->post('event_desc');
            $event_type=Yii::$app->request->post('event_type');
            $model = Event::getInstace();
            $model->event_name=$event_name;
            $model->event_token=$event_token;
            $model->event_desc=$event_desc;
            $model->event_type=$event_type;
            if($model->insert()){
                $this->_setSuccessFlash('异常添加成功');
                return $this->redirect(Yii::$app->request->getReferrer());
            }else{
                print_r($model->getErrors());
            }
        }else{
            return $this->render('add');
        }     
    }

    public function actionEdit(){
        if(Yii::$app->request->isPost){
            $id=Yii::$app->request->post('id');
            $model=Event::findOne($id);
            $model->event_name=Yii::$app->request->post('event_name');
            $model->event_token=Yii::$app->request->post('event_token');
            $model->event_desc=Yii::$app->request->post('event_desc');
            $model->event_type=Yii::$app->request->post('event_type');
            if($model->save()){
                $this->_setSuccessFlash('异常修改成功');
                return $this->redirect(Yii::$app->request->getReferrer());
            }else{
                print_r($model->getErrors());
            }
        }
        $model=new Event();
        $data=$model->find()->where(["id"=>$_GET['id']])->asArray()->one();
        $data['id']=$_GET['id'];
        return $this->render('edit',['data'=>$data]);
    }

    public function actionDel(){
        if(Yii::$app->request->isGet){
            $id=Yii::$app->request->get('id');
            $model = Event::findOne($id);
            if($model->delete()){
                $this->_setSuccessFlash('异常删除成功');
                return $this->redirect('/warning/event/index');
            }
        }
    }
}
