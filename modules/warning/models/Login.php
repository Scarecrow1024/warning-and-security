<?php

namespace app\modules\warning\models;

use yii\db\ActiveRecord;
use yii\base\Model;

class Login extends ActiveRecord{
    public $password;
    public $username;
    public $rememberMe;

    public static function tableName()
    {
        return 'admin';
    }

    public function rules()
    {
        return [
             [['username', 'password'], 'required' ,'message'=>'必填'],
        ];
    }
}
