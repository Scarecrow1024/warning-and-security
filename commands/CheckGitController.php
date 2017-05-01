<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\TaskManage;
use app\models\Coors;
use app\models\Setting;
use app\components\SimpleHtml;
use app\models\Group;
use app\models\AdminUsers;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CheckGitController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */

    public function actionCheckGit(){
        //两小时更新一次时间，发现不一致则发邮件提醒
    	//swoole_timer_tick(1000*20, function ($timer_id) {
            $cookies = $this->login_github();
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, "https://github.com/search?o=desc&q=zyf&s=indexed&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_REFERER, "https://github.com/search?q=zyf&type=Code&utf8=%E2%9C%93");
            curl_setopt($ch,CURLOPT_COOKIE,"$cookies[0];$cookies[1];$cookies[2];$cookies[3];$cookies[4]");
            curl_setopt($ch,CURLOPT_HEADER, 0);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
            curl_setopt($ch,CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('relative-time', 0);
            if(!isset($res)){
                echo "github登录失败".date('Y-m-d H:i:s', time()).PHP_EOL;
                die;
            }
            $git_time = strtotime($res->datetime);
            $setting = Setting::find()->where(['key'=>'git_time'])->one();
            $sql = "update setting set `value` = $git_time where `key` = 'git_time'";
            Yii::$app->db->createCommand($sql)->execute();
            if($setting->value < $git_time){
                echo "github有代码更新".date('Y-m-d H:i:s', time()).PHP_EOL;
                //发送邮件通知 设置里面的group
                $this->mail();
            }else{
                echo "github无代码更新".date('Y-m-d H:i:s', time()).PHP_EOL;
            }
        //});
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
        try{
            preg_match_all('/Set-Cookie:(.*);/iU',$content,$cookie_array); //正则匹配
            preg_match('/input name="authenticity_token" type="hidden" value="(.*)" /iU',$content,$authenticity_token);
            $token = $authenticity_token[1];
        }catch(exception $e){
            echo "登录失败";
            exit();
        }
        
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
    }

    public function mail($gs = []){
        $gs[] = Setting::find()->select('value')->where(['key'=>'group'])->one()->value;
        $uids = [];
        foreach($gs as $v){
            $uids[] = json_decode(Group::find()->select('users')->asArray()->where(['id'=>$v])->one()['users'], true);
        }
        $us = [];
        foreach($uids as $k=>$v){
            foreach($v as $vv){
                $us[] = $vv;
            }
        }
        //获取组员的id
        $us = array_unique($us);
        $tmp = [];
        foreach($us as $v){
            $tmp[] = AdminUsers::find()->select('username,mail')->where(['uid'=>$v])->asArray()->one();
        }
        $res = [];
        foreach($tmp as $v){
            $res[$v['mail']] = $v['username'];
        }
        $mail= Yii::$app->mailer->compose();
        $mail->setTo($res);
        $mail->setSubject("GitHub安全提醒");
        $mail->setHtmlBody("github有代码更新,请登录查看");
        $mail->send();
    }
}
