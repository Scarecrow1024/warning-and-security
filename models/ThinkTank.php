<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "think_tank".
 *
 * @property integer $id
 * @property string $name
 * @property string $source
 * @property string $desc
 * @property integer $type
 * @property string $time
 */
class ThinkTank extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'think_tank';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['time'], 'safe'],
            [['name', 'source'], 'string', 'max' => 32],
            [['desc'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '漏洞编号',
            'name' => '事件名称',
            'source' => '漏洞来源',
            'desc' => '漏洞描述',
            'type' => '漏洞类型',
            'time' => '添加时间',
        ];
    }

    /**
     * @inheritdoc
     * @return ThinkTankQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ThinkTankQuery(get_called_class());
    }

    public static function getStatus()
    {
        return [
            '' => '全部',
            1 => 'XSS',
            2 => 'SQL注入',
            3 => '命令执行',
            4 => '文件包含',
            5 => '任意文件操作',
            6 => '权限绕过',
            7 => '逻辑漏洞',
            8 => '存在后门',
            9 => '信息泄露',
            10 => '任意文件上传',
            11 => '弱口令',
            12 => '本地提权',
        ];
    }
}
