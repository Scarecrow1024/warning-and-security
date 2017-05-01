<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
//use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\warning\models\Login;
use app\controllers\BaseController;

class LoginController extends BaseController
{
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if(Yii::$app->request->isPost){
            $admin=new Login();
            $res=$admin->find()->where(['username'=>Yii::$app->request->post('username')])->asArray()->one();
            if($res){
                if(Yii::$app->request->post('username')==$res['username']&&Yii::$app->request->post('password')==$res['password']){
                    $session=YII::$app->session;
                    $session->open();
                    $session->set('isLogin', 1, 3600);
                    $session->set('username', Yii::$app->request->post('username'), 3600);
                    $session->close();
                    $this->redirect('http://www.warning.com/user/index');
                }
            }else{
                $error['error']="请输入正确的用户名和密码";
                $error['backurl']="/login/index";
                return $this->redirect(['error/error', 'error' => $error]);
            }
        } 
    }

    public function actionLgout(){
        $session=YII::$app->session;
        $session->open();
        $session->set('isLogin', null,-3600);
        $session->close();
        $this->redirect('http://www.warning.com/login/index');
    }

    public function actionIndex(){
        $model=new login();
        return $this->render("login",['model'=>$model]);
    }
}
