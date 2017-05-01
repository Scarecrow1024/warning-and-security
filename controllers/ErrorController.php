<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
//use app\models\SendError;
use app\models\Factory;
use yii\db\Query;

/**
 * Default controller for the `admin` module
 */
class ErrorController extends Controller
{
	/*
	 *这样调用接口，传递一个错误的唯一token和错误信息error
	 *type=0表示只发邮件，type=1表示只发短信，type=2表示都发
	 *http://www.warning.com/error/api?token=1001&error=支付出现异常&type=2
	**/

    public function actionPost(){
    	if(Yii::$app->request->isPost){
	    	$token=Yii::$app->request->post('token');
	    	//查询数据库获取type
	    	/*$sql="select event_type from event where event_token=$token";
	        $type=Yii::$app->db->createCommand($sql)
	             ->queryOne();
	        $type=$type['event_type'];*/
	        $type=Yii::$app->request->post('type');


	        //$sendError=new SendError();
	        /*
			//使用工厂设计模式
	        */
	        
	        $sendError=Factory::createSerror();
	        $data=array();
	        //传递一个token然后根据该token找到该错误事件所属的分组，然后找到属于该分组的组员
	        $data['token']=$token;
	        $data['error']=Yii::$app->request->post('error');
	        if($type==0){
	        	//只触发发送邮件事件
	        	//$sendError->on('send',[$sendError,'send_mail'],$data);
	        	$sendError->on('send',[$sendError,'merge_mail'],$data);
	        	$sendError->send();
	        }elseif($type==1){
	        	//只触发发送短信事件
	        	//$sendError->on('send',[$sendError,'send_mss'],$data);
	        	$sendError->on('send',[$sendError,'merge_msg'],$data);
	        	$sendError->send();
	        }else{
	        	//触发邮件和短信
	        	/*$sendError->on('send',[$sendError,'send_mail'],$data);
	        	$sendError->on('send',[$sendError,'send_mss'],$data);*/
	        	$sendError->on('send',[$sendError,'merge_all'],$data);
	        	$sendError->send();
	        }
	    }
    }

    public function actionError(){
    	$error=$_GET['error'];
    	return $this->render('error',['error'=>$error]);
    }

    public function actionApi(){	
    	$rs=curl_init();
    	$json='{"token":1004,"error":"error","type":2}';
    	//$post=json_decode($json,true);
        $url="http://www.warning.com/error/post";
        curl_setopt($rs,CURLOPT_URL,$url);
        //post数据来源
        curl_setopt($rs,CURLOPT_REFERER,"http://www.warning.com/error/api");
        curl_setopt($rs,CURLOPT_POST,1);
        curl_setopt($rs,CURLOPT_POSTFIELDS,$json);  
        curl_setopt($rs, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($json))
		);
        curl_setopt($rs,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($rs,CURLOPT_FOLLOWLOCATION,1);
        //跳转到数据页面
        echo curl_exec($rs);
        curl_close($rs);

    }

    public function actionDemo(){
    	/*$json='{
    		"error":1,
    		"results":[
					{
						"error":"1",
						"token":"1001",
						"type":"1",
						"mail":"false",
						"msg":"ok",
					},
					{
						"error":"0",
						"token":"1002",
						"type":"1",
						"msg":"ok",
					}
    		],
    	}';*/
    	$json='{
      "errno": -3, 
      "msg": "send email and mss field", 
      "results": [
            {
                  "name": "jemmy", 
                  "msg1": "worng mobile", 
                  "msg2": "wrong email add", 
                  "mss": "false", 
                  "email": "false"
            }, 
            {
                  "name": "tommy", 
                  "mss": "ok", 
                  "email": "ok"
            }
      ]
}';	
		/*echo "<pre>";
		echo $json;
		echo "</pre>";
		die;*/
    	$data=json_decode($json,true);
    	print_r($data);
    }

}
