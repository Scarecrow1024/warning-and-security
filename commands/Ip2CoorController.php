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

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Ip2CoorController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionInit(){
        //swoole_timer_tick(1000*600, function ($timer_id) {
            $client = new \swoole_client(SWOOLE_SOCK_TCP);
            if (!$client->connect('127.0.0.1', 9501, 1)){
                echo "Swoole服务启动异常";
            }
            $sql = "select count(*) as count from waf";
            $count = Yii::$app->db2->createCommand($sql)->queryOne()['count'];
            //$count = 2000;
            $k = ceil($count/100);
            for($i=0;$i<$k;$i++){
                $j = $i*100;
                $data = TaskManage::find()->select('wanip,time')->where(['not like','wanip','87.245.198'])->orderBy(['time'=>SORT_DESC])->asArray()->offset($j)->limit(100)->all();
                if (!$client->send(json_encode($data))){
                    echo "Swoole发送数据异常";
                }else{
                    echo $client->recv().PHP_EOL;
                }
                unset($data);
            }
            $client->close();
        //});
    }

    public function actionIp2Coor(){
    	$serv = new \swoole_server("127.0.0.1", 9501);
    	$serv->set(array('task_worker_num' => 8,'worker_num' => 2,'max_request' => 10000, 'daemonize' => 1));
    	$serv->on('Receive', function($serv, $fd, $from_id, $data) {
            Coors::deleteAll();
            $sql = "alter table coors AUTO_INCREMENT=1";
            Yii::$app->db->createCommand($sql)->execute();
            $task_id = $serv->task($data);
         	//echo "Dispath AsyncTask: id=$task_id".PHP_EOL;
    	    $serv->send($fd,'消息发送成功');
    	});
        
    	$serv->on('Task', function ($serv, $task_id, $from_id, $data) {
        	echo "New AsyncTask[id=$task_id]".PHP_EOL;
            //客户端发送过来数据进行ip2坐标操作
            $res = json_decode($data,true);
            foreach($res as $k=>$v){
                $model = new Coors();
            	$coor = json_decode($this->ip2coor($v['wanip']), true)['content'];
                $name = $coor['address'];
                $x = $coor['point']['x'];
                $y = $coor['point']['y'];
                $model->city = $name;
                $model->wanip = $v['wanip'];
                $model->x = $x;
                $model->y = $y;
                $model->upd_data = $v['time'];
                if($name!=""){
                    if($model->save()){
                        echo $name,$x,$y,PHP_EOL;
                        unset($res[$k]);
                    }
                } 
            }
    	});
    	$serv->on('Finish', function ($serv, $task_id, $data) {
        	$finish = "AsyncTask[$task_id] Finish: $data".PHP_EOL;
            echo $finish;
    	});
    	$serv->start();
    }

    public function ip2coor($ip=""){
        $ak = "04aC1ups73Z6i5ELxu5NiVK8V4bW8ByG";
        $url = "http://api.map.baidu.com/location/ip?ak=".$ak."&coor=bd09ll&ip=".$ip;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res=curl_exec($ch);
        return $res;
    }
}
