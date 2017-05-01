<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coors".
 *
 * @property integer $id
 * @property string $wanip
 * @property string $city
 * @property string $x
 * @property string $y
 * @property string $upd_data
 */
class Coors extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'coors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wanip', 'city'], 'string', 'max' => 20],
            [['x'], 'string', 'max' => 16],
            [['y'], 'string', 'max' => 25],
            [['upd_data'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wanip' => 'Wanip',
            'city' => 'City',
            'x' => 'X',
            'y' => 'Y',
            'upd_data' => 'Upd Data',
        ];
    }
}
