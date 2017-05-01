<?php

namespace app\modules\warning\controllers;
//namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * Default controller for the `admin` module
 */
class BaseController extends Controller
{
    public function init()
    {
        //任何人都可以访问login/index
        $url=$_SERVER['REQUEST_URI'];
        //判断是否登录，未登录则跳转到登陆界面
        if($url=="/login/index"){
            session_start();
        }else{
            session_start();
            if(empty($_SESSION['isLogin'])){
                $this->redirect('http://www.warning.com/login/index');
            }
        }
    }  
    public function _setErrorFlash($msg){
        return Yii::$app->session['error_flash'] = $msg;
    }
}
