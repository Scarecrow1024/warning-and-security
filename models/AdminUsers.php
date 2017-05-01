<?php

namespace app\models;

use Yii;
use app\models\AdminLog;

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
class AdminUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['salt', 'status', 'google_status'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['username', 'password', 'real_name', 'photo', 'phone', 'mail', 'authKey', 'secret'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'username' => '用户名',
            'password' => '密码',
            'real_name' => '真实姓名',
            'photo' => '头像',
            'phone' => '联系方式',
            'mail' => '通知邮箱',
            'authKey' => 'Auth Key',
            'secret' => '二次验证秘钥',
            'salt' => 'Salt',
            'created' => '创建时间',
            'updated' => '更新时间',
            'status' => '管理员状态',
            'google_status' => '二次验证状态',
        ];
    }

    /**
     * @inheritdoc
     * @return AdminUsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdminUsersQuery(get_called_class());
    }

    public static function getStatus()
    {
        return [
            '' => '全部',
            1 => '启用',
            0 => '停用',
        ];
    }

}
