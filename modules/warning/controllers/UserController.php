<?php

namespace app\modules\warning\controllers;

use yii;
//use yii\web\Controller;
use app\modules\warning\models\User;
use app\modules\warning\models\Role;
use yii\db\Query;
use app\controllers\BaseController;

class UserController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(){
        $user=new User();
        $data=$user->getRoleName();
        //$data=$user->find()->asArray()->all();
        return $this->render('index',['data'=>$data]);
    }

    public function actionAaa(){
        $data=array();
        $data['server']['name']='服务器管理';
        $data['server'][]=array('url'=>'server/list','name'=>'服务器列表');
        $data['server'][]=array('url'=>'net-int-card/list','name'=>'网卡管理');
        $data['server'][]=array('url'=>'cardisp/list','name'=>'ISP 管理');
        $data['server'][]=array('url'=>'netip/list','name'=>'IP 管理');
        $data['server'][]=array('url'=>'line/list','name'=>'线路管理');

        $data['ip-library']['name']='IP库管理';
        $data['ip-library'][]=array('url'=>'ip-library/index','name'=>'IP 库');
        $data['ip-library'][]=array('url'=>'ip-library/isp','name'=>'自定义ISP');
        $data['ip-library'][]=array('url'=>'ip-library/area','name'=>'地区划分');
        $data['ip-library'][]=array('url'=>'ip-library/log','name'=>'操作日志');

        return $this->render('aaa',['data'=>$data]);
    }

    public function actionDemo(){
        //aaabbcd=>3a2bcd
        //abcabc=>abcabc
        $str = "abcddaa";
        $data = str_split($str);
        
    }

    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $user=new User();
            $user->username=Yii::$app->request->post('User')['username'];
            $user->phone=Yii::$app->request->post('User')['phone'];
            $user->email=Yii::$app->request->post('User')['email'];
            if($user->insert()){
                $this->_setSuccessFlash('用户添加成功');
                return $this->redirect('/warning/user/index');
            }else{
                print_r($user->getErrors());
            }
        }else{
            $role=new Role();
            $roles=$role->find()->asArray()->all();
            $model=new User();
            return $this->render('add',[
                'model'=>$model,
                'roles'=>$roles,
                ]);
        }  
    }

    public function actionDoedit(){
        if(Yii::$app->request->isPost){
            $id=Yii::$app->request->post('id');
            $model = User::findOne($id);
            $model->on('save',function(){
                $role_ids=Yii::$app->request->post('role_id');
                $id=Yii::$app->request->post('id');
                //先删除原来的对应的user_id
                $sql="delete from user_role where user_id = $id";
                    Yii::$app->db->createCommand($sql)
                     ->execute();
                //然后插入新的数据
                foreach($role_ids as $v){
                    $sql="insert into user_role (user_id,role_id) values ($id,$v)";
                    Yii::$app->db->createCommand($sql)
                     ->execute();
                }
                //echo "更新user_role表成功";
            });
            $model->username=Yii::$app->request->post('username');
            $model->phone=Yii::$app->request->post('phone');
            $model->email=Yii::$app->request->post('email');
            if ($model->save()) {
                $model->trigger('save');
                $this->_setSuccessFlash('用户更新成功');
                return $this->redirect('/warning/user/index');
            }
        }
    }

    public function actionEdit(){
        $model=new User();
        $data=$model->getRoleNameById($_GET['id']);
        //print_r($data);
        //$data=$model->find()->where(['id'=>Yii::$app->request->get('id')])->asArray()->one();
        $role=new Role();
        $roles=$role->find()->asArray()->all();
        return $this->render('edit',['data'=>$data[0],'roles'=>$roles]);
    }

    public function actionDel(){
        if(Yii::$app->request->isGet){
            $id=Yii::$app->request->get('id');
            $model = User::findOne($id);
            if($model->delete()){
                $this->_setSuccessFlash('用户删除成功');
                //return $this->redirect(Yii::$app->request->getReferrer());
                return $this->redirect('/warning/user/index');
            }
        }
    }

    public function actionAbc(){
        $str = "abcabc";
        $data = str_split($str);
        $data_1 = array_count_values($data);
        //print_r($data_1);
        $keys = array_keys($data_1);
        $vals = array_values($data_1);
        $str1 = '';
        for($i=0;$i<count($keys);$i++){
            $str1 .= $vals[$i].$keys[$i];
        }
        $data_2 = str_split($str1);
        //print_r($data_2);
        for($i=0;$i<count($data_2);$i++){
            if($data_2[$i]==1){
                unset($data_2[$i]);
            }  
        }
        echo implode('', $data_2);
    }
}
