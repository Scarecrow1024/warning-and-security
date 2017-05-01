<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_users".
 *
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $real_name
 * @property string $phone
 * @property string $mail
 * @property string $authKey
 * @property string $secret
 * @property integer $salt
 * @property string $created
 * @property string $updated
 * @property integer $status
 * @property integer $google_status
 */
class TaskManage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    
    public static function tableName()
    {
        return 'waf';
    }

    public static function getDb() {
        return Yii::$app->db2;
    }

}
