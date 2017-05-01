<?php

namespace app\modules\warning\controllers;

use yii;
use yii\web\Controller;
use app\modules\warning\models\Role;
use app\modules\warning\models\Event;
use yii\db\Query;
use app\modules\warning\models\Snoopy;
use app\controllers\BaseController;

class RoleController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */

    public function actionIndex()
    {

        $model=new Role();
        $data=$model->getRoleName();
        return $this->render('index',['data'=>$data]);
    }

    public function actionAdd(){
        if(YII::$app->request->isPost){
            $role_name=Yii::$app->request->post('role_name');
            $model=new Role();
            $model->role_name=$role_name;
            if($model->insert()){
                $this->_setSuccessFlash('报警组添加成功');
                return $this->redirect('/warning/role/index');
            }else{
                print_r($model->getErrors());
            }
        }else{
            $event=new Event();
            $events=$event->find()->asArray()->all();
            return $this->render('add',['events'=>$events]);
        }     
    }

    public function actionEdit(){
        if(Yii::$app->request->isPost){
            $id=Yii::$app->request->post('id');
            /*$role_name=Yii::$app->request->post('role_name');
            $sql="update role set role_name = '". $role_name ."' where id = ".$id;
            Yii::$app->db->createCommand($sql)
             ->execute();*/
            $model=Role::findOne($id);

            //添加一个事件当save后触发
            $model->on("save",function(){
                $event_ids=Yii::$app->request->post('event_id');
                $id=Yii::$app->request->post('id');
                //先删除原来的对应的user_id
                $sql="delete from event_role where role_id = $id";
                    Yii::$app->db->createCommand($sql)
                     ->execute();
                //然后插入新的数据
                foreach($event_ids as $v){
                    $sql="insert into event_role (role_id,event_id) values ($id,$v)";
                    Yii::$app->db->createCommand($sql)
                     ->execute();
                }
                //echo "更新event_role表成功";
            });

            $model->role_name=Yii::$app->request->post("role_name");
            var_dump($model->role_name);
            if($model->save()){
                $model->trigger('save');
                $this->_setSuccessFlash('报警组修改成功');
                return $this->redirect('/warning/role/index');
            }else{
                var_dump($model);
                var_dump($model->errors);
                print_r($model->getErrors());
            }
        }else{
            $model=new Role();
            $data=$model->getRoleNameById($_GET['id']);
            $event=new Event();
            $events=$event->find()->asArray()->all();
            return $this->render('edit',['data'=>$data[0],'events'=>$events]);
            /*$model=new Role();
            $data=$model->find()->asArray()->where(['id'=>Yii::$app->request->get('id')])->one();
            return $this->render('edit',['data'=>$data]);*/
        }
    }

    public function actionDel(){
        if(Yii::$app->request->isGet){
            $id=Yii::$app->request->get('id');
            $model = Role::findOne($id);
            if($model->delete()){
                $this->_setSuccessFlash('报警组删除成功');
                return $this->redirect('/warning/role/index');
            }
        }
    }
}
