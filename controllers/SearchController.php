<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\SimpleHtml;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class SearchController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionGithub()
    {
        /*
         *github模拟登录
         *抓取第一页信息
         */
        //获取登录页面的cookie和authenticity_token不知道何用
        if(Yii::$app->request->isPost){
            $q = Yii::$app->request->post('q');
            $cookies = $this->login_github();
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://github.com/search?o=desc&q=".$q."&s=indexed&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_REFERER, "https://github.com/search?q=".$q."&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_COOKIE,"$cookies[0];$cookies[1];$cookies[2];$cookies[3];$cookies[4]");
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('div[class=code-list]',0);
            return $this->render('github',['res'=>$res,'q'=>$q]);
        } else {
            $cookies = $this->login_github();
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://github.com/search?o=desc&q=lonlife&s=indexed&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_REFERER, "https://github.com/search?q=lonlife&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_COOKIE,"$cookies[0];$cookies[1];$cookies[2];$cookies[3];$cookies[4]");
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('div[class=code-list]',0);
            return $this->render('github',['res'=>$res]);
        }
        
    }

    public function login_github(){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "https://github.com/login");
        curl_setopt($ch,CURLOPT_REFERER, "https://github.com/");
        curl_setopt($ch,CURLOPT_HEADER, 1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content=curl_exec($ch);
        curl_close($ch);
        //正则匹配cookie并使用
        preg_match_all('/Set-Cookie:(.*);/iU',$content,$cookie_array); //正则匹配
        preg_match('/input name="authenticity_token" type="hidden" value="(.*)" /iU',$content,$authenticity_token);
        $token = $authenticity_token[1];
        $before_cookie = $cookie_array[1][1];
        //echo $content;die;

        $ch=curl_init(); 
        $post = array(
                "commit"=>"Sign in",
                "utf8"=>"✓",
                "authenticity_token"=>$token,
                "login"=>"1522402210",
                "password"=>"X123@987x"
            );
        curl_setopt($ch,CURLOPT_URL,"https://github.com/session");
        curl_setopt($ch,CURLOPT_REFERER,"https://github.com/");
        curl_setopt($ch,CURLOPT_HEADER, 1);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
        curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
        //带上上登陆前的cookie
        curl_setopt($ch,CURLOPT_COOKIE,$before_cookie);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 0);
        $content=curl_exec($ch);
        curl_close($ch);
        //正则匹配cookie并使用
        preg_match_all('/Set-Cookie:(.*);/iU',$content,$login_cookie); //正则匹配 
        $login_cookie1 = $login_cookie[1][0];
        $login_cookie2 = $login_cookie[1][1];
        $login_cookie3 = $login_cookie[1][2];
        $login_cookie4 = $login_cookie[1][3];
        $login_cookie5 = $login_cookie[1][4];
        $cookies = [$login_cookie1,$login_cookie2,$login_cookie3,$login_cookie4,$login_cookie5];
        return $cookies;
        //var_dump($login_cookie[1]);
    }

    public function actionShodan(){
        //$key = "AOaWbLRlcbjpNXIGGHofpbYlC4LcIIPb";
        if(Yii::$app->request->isPost){
            $q = Yii::$app->request->post('query');
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://www.shodan.io/search?query=".$q);
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('div[class=span9]',0);
            return $this->render('shodan',['res'=>$res,'q'=>$q]);
        }else{
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://www.shodan.io/search?query=lonlife");
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('div[class=span9]',0);
            return $this->render('shodan',['res'=>$res]);
        }
        
    }

}
