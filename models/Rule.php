<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rule".
 *
 * @property integer $id
 * @property string $name
 * @property string $request_body
 * @property integer $type
 * @property string $method
 * @property integer $s_level
 * @property integer $r_level
 * @property integer $r_par
 * @property string $par_route
 * @property string $route
 * @property string $reg
 */
class Rule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rule';
    }

    public static function getDb() {
      return Yii::$app->db3;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 's_level', 'r_level', 'r_par'], 'integer'],
            [['name', 'method', 'par_route'], 'string', 'max' => 32],
            [['request_body'], 'string', 'max' => 12],
            [['route'], 'string', 'max' => 64],
            [['reg'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '规则名称',
            'request_body' => '请求体',
            'type' => '扫描类型',
            'method' => '关联方案',
            's_level' => '扫描级别',
            'r_level' => '风险级别',
            'r_par' => '响应参数',
            'par_route' => '路径参数',
            'route' => '请求路径',
            'reg' => '匹配正则',
        ];
    }
}
