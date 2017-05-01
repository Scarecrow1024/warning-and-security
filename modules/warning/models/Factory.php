<?php

namespace app\modules\warning\models;

use yii\db\ActiveRecord;
use yii\base\Model;
use yii\db\Query;
use app\modules\warning\models\SendError;
use yii;

//工厂设计模式
class Factory extends ActiveRecord{
	public static function getDb() {
      return Yii::$app->db;
  	}

    public static function createSerror(){
        $se=new SendError();
        return $se;
    }
}