<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\TaskManage;
use app\models\Coors;
use app\models\Available;
use yii\data\ActiveDataProvider;
use app\components\SimpleHtml;
use yii\web\UploadedFile;
use app\models\Group;
use app\models\AdminUsers;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class TaskManageController extends BaseController
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'attack';
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

    public function actionTest(){
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9501, 1)){
            echo "Swoole服务启动异常";
        }
        for($i=0;$i<10;$i++){
            $j = $i*100;
            //$data = [];
            $data = TaskManage::find()->select('wanip,time')->where(['not like','wanip','87.245.198'])->orderBy(['time'=>SORT_DESC])->asArray()->offset($j)->limit(100)->all();
            //一次只向队列里加入50条数据，防止内存溢出
            /*foreach (TaskManage::find()->select('wanip,time')->where(['not like','wanip','87.245.198'])->orderBy(['time'=>SORT_DESC])->limit($j,5)->each(5) as $each) {
                $data[]['wanip'] = $each->wanip;
                echo $each->wanip."<br>";
            }*/
            if (!$client->send(json_encode($data))){
                echo "Swoole发送数据异常";
            }else{
                echo $client->recv()."<br>";
            }
            //print_r($data);
            unset($data);
        }
        $client->close();
    }

    public function actionInit(){
        print_r(TaskManage::find()->asArray()->where(['not like','wanip','87.245.198'])->orderBy(['time'=>SORT_DESC])->all());die;
        $time = date('Y-m-d H:i:s',time());
        foreach (TaskManage::find()->select('wanip')->where(['not like','wanip','87.245.198'])->limit(500)->orderBy(['time'=>SORT_DESC])->each(20) as $task)
        {
            $coor = new Coors();
            $res = json_decode($this->ip2coor($task->wanip), true)['content'];
            $city = $res['address'];
            $x = $res['point']['x'];
            $y = $res['point']['y'];
            $coor->wanip = $task->wanip;
            $coor->city = $city;
            $coor->x = $x;
            $coor->y = $y;
            $coor->upd_data = $time;
            $coor->save();
            echo $city."<br>";
        }
    }

    public function actionPing(){
        $client = new \swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9502, 1)){
            echo "Swoole服务启动异常";
        }
        $data = [];
        //一次只向队列里加入50条数据，防止内存溢出
        foreach (Available::find()->select('addr')->orderBy(['time'=>SORT_DESC])->each(50) as $each) {
            $data[]['addr'] = $each->addr;
            if (!$client->send(json_encode($data))){
                echo "Swoole发送数据异常";
            }else{
                echo $client->recv();
            }
        }
        $client->close();
    }

    public function actionCreate(){
        $name = Yii::$app->request->post('name');
        $addr = Yii::$app->request->post('addr');
        $report_group = json_encode(Yii::$app->request->post('report_group'));
        $report_status = Yii::$app->request->post('report_status');
        $model = new Available();
        $model->name = $name;
        $model->addr = $addr;
        $model->report_status = $report_status;
        $model->report_group = $report_group;
        if($model->save()){
            $this->_setSuccessFlash('添加成功');
            return $this->redirect('/task-manage/available');
        }
    }

    public function actionAvailable(){
        $query_params = Yii::$app->request->queryParams;
        $model = new Available();
        $data = $model->find();
        $currentPage = $query_params['page'] ? $query_params['page'] : 1;
        $pageSize = $query_params['per-page'] ? $query_params['per-page'] : 15;
        $pageInfo = $this->_page($data, $currentPage, $pageSize, true);
        /*foreach($pageInfo['data'] as $v){
            $t = json_decode($this->ping($v->addr), true);
            $v['ct'] = $t[0];
            $v['cu'] = $t[1];
        }*/
        $users = Group::find()->asArray()->all();
        return $this->render('available',['data' => $pageInfo['data'], 'pages'=>$pageInfo['pages'],'model'=>$model, 'users'=>$users]);
    }

    public function actionDel(){
        $id = Yii::$app->request->get('id');
        $model = Available::findOne($id);
        return $model->delete();
    }

    public function ping($domain = "www.baidu.com"){
        $data = [];
        for($i=2;$i>=1;$i--){
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

    public function actionAttack(){
        $data = Coors::find()->asArray()->all();
        $citys = [];
        foreach($data as $k=>$v){
            $citys[] = $v['city'];
        }
        foreach($citys as $k=>$v){
            $ips[] = explode(".",$v);
        }
        //获取城市次数，排序
        $times = [];
        foreach($ips as $k=>$v){
            $times[] = implode('.',$v);
        }
        $times = array_count_values($times);
        arsort($times);
        $xx = [];
        foreach($times as $k=>$v){
            $xx[$k]['name'] = $k;
            $xx[$k]['value'] = $v;
        }
        $xx = array_values($xx);
        //获取城市坐标排好序的
        $res = [];
        foreach($xx as $k=>$v){
            $res[$v['name']][0] = Coors::find()->select('x')->where(['city'=>$v['name']])->asArray()->one()['x'];
            $res[$v['name']][1] = Coors::find()->select('y')->where(['city'=>$v['name']])->asArray()->one()['y'];
        }
        //获取city出现次数便于拼装
        $s = [];
        foreach($times as $v){
            $s[] = $v;
        }
        //获取city名称便于拼装
        $c = [];
        foreach($res as $k=>$v){
            $c[] = $k;
        }

        $wanips = [];
        foreach($data as $k=>$v){
            $wanips[] = $v['wanip'];
        }
        foreach($wanips as $k=>$v){
            $ss[] = explode(".",$v);
        }
        foreach($ss as $k=>$v){
            unset($ss[$k][3]);
        }
        //获取ip次数，排序
        $stimes = [];
        foreach($ss as $k=>$v){
            $stimes[] = implode('.',$v);
        }
        $stimes = array_count_values($stimes);
        arsort($stimes);
        $zz = [];
        foreach($stimes as $k=>$v){
            $zz[] = $k;
        }
        for($i=0;$i<=(count($zz)-count($xx));$i++){
            array_pop($zz);
        } 
        return $this->render('attack',['counts'=>json_encode($xx),'coor'=>json_encode($res),'times'=>$s,'citys'=>$c,'ips'=>$zz]);
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
