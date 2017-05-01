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
use app\models\Available;
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
class PingController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionInit(){
        //swoole_timer_tick(1000*600, function ($timer_id) {
            $client = new \swoole_client(SWOOLE_SOCK_TCP);
            if (!$client->connect('127.0.0.1', 9502, 1)){
                echo "Swoole服务启动异常".date('Y-m-d H:i:s', time()).PHP_EOL;
            }
            $sql = "select count(*) as count from available";
            $count = Yii::$app->db->createCommand($sql)->queryOne()['count'];
            $k = ceil($count/100);
            for($i=0;$i<$k;$i++){
                $j = $i*100;
                $data = Available::find()->select('addr,report_group')->asArray()->offset($j)->limit(100)->all();
                if (!$client->send(json_encode($data))){
                    echo "Swoole发送数据异常".date('Y-m-d H:i:s', time()).PHP_EOL;
                }else{
                    echo $client->recv().PHP_EOL;
                }
                unset($data);
            }
            $client->close();
        //});
    }

    public function actionPing(){
    	$serv = new \swoole_server("127.0.0.1", 9502);
    	$serv->set(array('task_worker_num' => 8,'worker_num' => 2,'max_request' => 10000, 'daemonize' => 1));
    	$serv->on('Receive', function($serv, $fd, $from_id, $data) {
        	$task_id = $serv->task($data);
    	    $serv->send($fd,'端口9502的服务端已接收到客户端提交的数据');
    	});
    	$serv->on('Task', function ($serv, $task_id, $from_id, $data) {
            //客户端发送过来数据进行ping操作
            $res = json_decode($data,true);
            foreach($res as $k=>$v){
            	//ping操作并且更新数据库
                //t[1]:电信 当电信和联通为0通知
                $t = json_decode($this->ping($v['addr']), true);
                if($t[0]==0 && $t[1]==0){
                    $this->mail(json_decode($v['report_group'], true), $v['addr']);
                    sleep(30);
                }
                $sql = 'update available set ct='.$t[1].',cu='.$t[0].',cm='.$t[1].',upd_data='."'".date('Y-m-d H:i:s', time())."'".' where addr = '."'".$v['addr']."'";
                if(Yii::$app->db->createCommand($sql)->execute()){
                    echo $v['addr']." update ok".PHP_EOL;
                }else{
                    echo $v['addr']." no update".PHP_EOL;
                }
                //file_put_contents(Yii::$app->basePath.'/runtime/test.log',$name.$x.$v."\n",FILE_APPEND);
                echo $v['addr'].','.$t[0].','.$t[1].PHP_EOL;
                unset($res[$k]);
            }
    	});
    	$serv->on('Finish', function ($serv, $task_id, $data) {
        	$finish = "AsyncTask[$task_id] Finish: 队列处理完毕";
            echo $finish.PHP_EOL;
    	});
    	$serv->start();
    }

    public function ping($domain = "www.baidu.com"){
        $data = [];
        for($i=4;$i>=1;$i-=3){
            $ch=curl_init(); 
            //2电信，1联通
            $post = "domain=".$domain."&strdo=pingquery&pingnumber=10&strlin=".$i;
            curl_setopt($ch,CURLOPT_URL,"http://ping.7c.com/hander/ping.ashx");
            curl_setopt($ch,CURLOPT_REFERER,"http://ping.7c.com/");
            curl_setopt($ch,CURLOPT_HEADER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT , "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
            $content=curl_exec($ch);
            curl_close($ch);
            $html = new SimpleHtml();
            $html->load($content);
            $res = $html->find('li[class=zuih]',0);
            if(isset($res)){
                //延迟
                $min_ct = $res->children(2)->plaintext;
                $max_ct = $res->children(3)->plaintext;
                $ct = (intval($max_ct)+intval($min_ct))/2;
            }else{
                $min_ct = 0;
                $max_ct = 0;
                $ct = 0;
            }
            $data[] = $ct;
            $html->clear();
        }
        return json_encode($data);
    }

    public function mail($gs = [1], $addr=""){
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
        $mail->setSubject("IP异常");
        $mail->setHtmlBody($addr."异常,电信联通均超时,请检查IP状态");
        $mail->send();
    }
    
}
