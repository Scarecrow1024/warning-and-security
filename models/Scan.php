<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scan".
 *
 * @property integer $id
 * @property string $name
 * @property string $domail
 * @property integer $type
 * @property string $node
 * @property string $user
 * @property integer $status
 * @property string $time
 * @property integer $alarm_status
 * @property string $alarm_condition
 * @property integer $alarm_group
 */
class Scan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'alarm_status', 'alarm_group'], 'integer'],
            [['time'], 'safe'],
            [['name', 'domail', 'node', 'user', 'alarm_condition'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '任务名称',
            'domail' => '扫描站点',
            'type' => '扫描类型',
            'node' => '扫描节点',
            'user' => '提交人',
            'status' => '扫描状态',
            'time' => '添加时间',
            'alarm_status' => '告警开关',
            'alarm_condition' => '告警条件',
            'alarm_group' => '告警对象',
        ];
    }
}
