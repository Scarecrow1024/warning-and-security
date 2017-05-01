<?php
namespace app\modules\warning\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use yii;

class SendError extends ActiveRecord{
    //定义一个send方法用于触发发送邮件和信息的事件
    public function send(){
        $this->trigger('send');
    }

    public function send_mail($event){
        $token=$event->data['token'];
        $error=$event->data['error'];
        $infos=$this->getUserInfo($token);
        //print_r($infos);die;
        $mail_json=array();
        foreach($infos as $v){
            $mail= Yii::$app->mailer->compose();
            $mail->setTo($v['email']); 
            $mail->setSubject("报警信息"); 
            //使用模板的话就不能使用setHtmlBody()
            //$mail->setTextBody();   //发布纯文字文本
            $mail->setHtmlBody("错误代码：".$token."<br>"."错误信息：".$error);
            if($mail->send()){
                //$mail_json['results'][]=$v;
                $mail_json[]=array("mail"=>'ok');
            }else{
                $mail_json['results'][]=$v;
                $mail_json['results'][]['error']="wrong call or mail config";
                $mail_json[]=array("mail"=>'wrong call or mail config');
            }
        }
        return $mail_json;
    }

    public function send_mss($event){
        $token=$event->data['token'];
        $error=$event->data['error'];
        $infos=$this->getUserInfo($token);
        $arr=array();
        foreach($infos as $v){
            $phone=$v['phone'];
            //$arr['results'][]=$v;
            $arr[]=json_decode($this->mss($phone,$token,$error),true);
        }
        return $arr;
    }

    public function merge_all($event){
        $arr_mail=$this->send_mail($event);
        $arr_msg=$this->send_mss($event);
        //合并邮件和短息的错误信息
        $arr=array();
        for($i=0;$i<count($arr_msg);$i++){
            $arr[]=array_merge($arr_mail[$i],$arr_msg[$i]);
        }
        //判断发送邮件是否出错，出错则设为-1
        $mail_code=0;
        foreach($arr_mail as $k=>$v){
            if(isset($arr_mail[$k]['mail'])!="ok"){
                $mail_code=-1;
            }
        }
        //判断发送短信是否出错，出错则设为-2
        $msg_code=0;
        foreach($arr_msg as $k=>$v){
            if($arr_msg[$k]['error']==-40){
                $msg_code=-2;
            }
        }
        if(($mail_code+$msg_code)==0){
            $data['code']=0;
            $data['msg']="send mail and messsge are success";
        }
        if(($mail_code+$msg_code)==-1){
            $data['code']=-1;
            $data['msg']="send mail is faild";
        }
        if(($mail_code+$msg_code)==-2){
            $data['code']=-2;
            $data['msg']="send messsge is faild";
        }
        if(($mail_code+$msg_code)==-3){
            $data['code']=-3;
            $data['msg']="send mail and messsge are faild";
        }
        $userinfo=$this->getUserInfo($event->data['token']);
        //对下标从新排序
        $userinfo=array_values($userinfo);
        //合并错误信息和用户信息
        $infos=array();
        for($i=0;$i<count($arr);$i++){
            $infos[]=array_merge($userinfo[$i],$arr[$i]);
        }
        $data['result']=$infos;
        //print_r($infos);
        //print_r($data);
        $json=json_encode($data);
        echo $json;
    }

    public function merge_mail($event){
        $array1=$this->send_mail($event);
        //print_r($array1);
        $merge1=array_merge($array1[0]);
        $merge2=array_merge($array1[1]);
        $arr=array();
        $arr['error']=2;
        $arr['results'][]=$merge1;
        $arr['results'][]=$merge2;
        $json=json_encode($arr);
        echo $json;
        //$this->send_mss($event);
    }

    public function merge_msg($event){
        $array2=$this->send_mss($event);
        //print_r($array1);
        $merge1=array_merge($array2[0]);
        $merge2=array_merge($array2[1]);
        $arr=array();
        $arr['error']=2;
        $arr['results'][]=$merge1;
        $arr['results'][]=$merge2;
        $json=json_encode($arr);
        echo $json;
        //$this->send_mss($event);
    }

    public function mss($phone,$token,$error){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://sms-api.luosimao.com/v1/send.json");
        curl_setopt($ch, CURLOPT_HTTP_VERSION  , CURL_HTTP_VERSION_1_0 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD  , 'api:key-763b8c207f7919e3c7631197de78c2ec');

        curl_setopt($ch, CURLOPT_POST, TRUE);
        //$post="mobile=$phone&message=$mes";
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $phone,'message' => '异常代码：'.$token.'  异常信息：'.$error.'【珑凌科技】'));
        $res = curl_exec( $ch );
        curl_close( $ch );
        return $res;
    }


    //获取user的详细信息
    public function getUserInfo($token){
        //首先获取到该异常事件所属的分组
        $sql="select a.*, GROUP_CONCAT(b.role_id) role_id from event as a left join event_role b on a.id = b.event_id where a.event_token = $token";
        $data=Yii::$app->db->createCommand($sql)
             ->queryOne();
        //根据获得的分组user的id
        $roles=explode(',',$data['role_id']);
        $ids=array();
        foreach($roles as $v){
            $sql="select user_id from user_role where role_id=$v";
            $ids[]=Yii::$app->db->createCommand($sql)
             ->queryAll();
        }
        $ids=array_filter($ids);
        //根据user的id获取user的详细信息
        $userinfo=array();
        foreach($ids as $v){
            foreach($v as $vv){
                $sql="select * from user where id = ".$vv['user_id'];
                $userinfo[]=Yii::$app->db->createCommand($sql)
                 ->queryOne();
            }  
        }
        $userinfo=array_filter($userinfo);
        $userinfo=$this->array_unique($userinfo);
        return $userinfo;
    }

    //对多维数组去重
    function array_unique($array){
        $out = array();
        foreach ($array as $key=>$value) {
            if (!in_array($value, $out)){
                $out[$key] = $value;
            }
        }
        return $out;
    } 
}