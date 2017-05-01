<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\components\Tool;
use app\models\AdminUsers;
use app\models\LoginForm;
use yii\web\Controller;
use app\models\GoogleAuthenticator;

class LoginController extends Controller
{

    public $enableCsrfValidation = false;
    public $layout = 'main-login';

    /**
     * log-add action.
     * 
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if (!$model->validate())    //验证数据
            {
                return $this->render('login', ['model' => $model]);
            }
            $username = Yii::$app->request->post('LoginForm')['username'];
            $user = AdminUsers::findOne(['username' => $username]);
            if($user->status == 0){
                $this->addError('username', '该用户已被禁用！');
            }
            if($user->google_status==0){
                if($model->login()){
                    return $this->goBack();
                }
            }else{
                if(empty($user->secret)){
                    Yii::$app->session->set('uid', $user->uid, 120);
                    return $this->redirect('/login/secret');
                }else{
                    Yii::$app->session->set('uid', $user->uid);
                    return $this->redirect(['/login/confirm']);
                }
            }
            
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionConfirm()
    {
        $uid = Yii::$app->session->get('uid');
        if ($uid == false) {
            Yii::$app->session->remove('uid');
            return $this->redirect('/login/login');
        }
        $post = Yii::$app->request->post();
        if ($post['code'] != false) {
            $user = AdminUsers::findOne($uid);
            $secret = $user->secret;
            $google_model = new GoogleAuthenticator();
            $res = $google_model->verifyCode($secret, $post['code'], 2);
            if ($res) {
                $user = AdminUsers::findOne($uid);
                Yii::$app->user->login(User::findByUsername($user->username), 3600 * 24 * 2);
                Yii::$app->session->remove('uid');
                Yii::$app->session->remove('inputPasswordCount');
                //$this->addLoginLog(Yii::$app->user->identity);
                return $this->redirect('/');
            }else{
                $wrongPasswordTimes = Yii::$app->session->get('inputPasswordCount',1);
                Yii::$app->session->set('inputPasswordCount',$wrongPasswordTimes + 1);
                if($wrongPasswordTimes >= 3){
                    Yii::$app->session->remove('uid');
                    Yii::$app->session->remove('inputPasswordCount');
                    return $this->redirect(['/login/login']);
                }
                Yii::$app->session->setFlash('errorMsg','错误密码次数:'.$wrongPasswordTimes." 最多3次输入机会");
            }
        }
        return $this->render('confirm');
    }

    public function actionSecret(){
        if(Yii::$app->request->isPost){
            $uid = Yii::$app->session->get('uid');
            $model = AdminUsers::findOne($uid);
            $secret = Yii::$app->request->post('secret');
            $model->secret = $secret;
            return $model->save();
        }
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        return $this->render('secret',['secret'=>$secret]);
    }

    public function _setSuccessFlash($msg)
    {
        return Yii::$app->session['success_flash'] = $msg;
    }

    public function _setErrorFlash($msg)
    {
        return Yii::$app->session['error_flash'] = $msg;
    }

    public function _popErrorFlash()
    {
        $result = '';
        if (Yii::$app->session['error_flash']) {
            $flash = Yii::$app->session['error_flash'];
            $result = is_array($flash) ? implode('<br>', $flash) : $flash;
            unset(Yii::$app->session['error_flash']);
        }
        return $result;
    }

    public function _popSuccessFlash()
    {
        $result = '';
        if (Yii::$app->session['success_flash']) {
            $flash = Yii::$app->session['success_flash'];
            $result = is_array($flash) ? implode('<br>', $flash) : $flash;
            unset(Yii::$app->session['success_flash']);
        }
        return $result;
    }

}
