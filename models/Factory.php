<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use app\models\SendError;
use yii;

//工厂设计模式
class Factory extends ActiveRecord{
	public static function getDb() {
      return Yii::$app->db3;
  	}

    public static function createSerror(){
        $se=new SendError();
        return $se;
    }
}