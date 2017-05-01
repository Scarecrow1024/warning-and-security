<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asset".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $ip
 * @property integer $type
 * @property string $user
 */
class Asset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file2;

    public static function tableName()
    {
        return 'asset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['name', 'url', 'ip'], 'string', 'max' => 32],
            [['user'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '资产编号',
            'name' => '资产名称',
            'url' => '资产url',
            'ip' => '资产ip',
            'type' => '资产类型',
            'user' => '资产归属人',
        ];
    }

    /**
     * @inheritdoc
     * @return AssetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetQuery(get_called_class());
    }
}
