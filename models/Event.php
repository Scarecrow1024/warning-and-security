<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use Yii;

class Event extends ActiveRecord{
	protected static $event;

  public static function getDb() {
      return Yii::$app->db3;
  }

	//私有构造函数，防止外界实例化对象
    public function __construct() {
    }

    public function __colne()
    {
    }

    //声明一个获取类实例的方法
    static function getInstace()
    {
       if(self::$event) {
          return self::$event;
       } else {
          //生成自己
          self::$event = new self();
          return self::$event;
       }  
    }

    public function rules()
    {
        return [
             ['event_name', 'required','message' => '不能为空'],
        ];
    }
}