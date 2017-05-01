<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property integer $frequency
 * @property integer $delay
 * @property integer $loss
 * @property integer $number
 * @property string $git_time
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $file2;
    public $file3;
    public $file4;
    public $file5;
    public $frequency;
    public $delay;
    public $group;
    public $loss;
    public $number;
    public $git_time;

    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency', 'delay', 'loss', 'number'], 'integer'],
            [['git_time'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'frequency' => 'Frequency',
            'delay' => 'Delay',
            'loss' => 'Loss',
            'number' => 'Number',
            'git_time' => 'Git Time',
            'file' => '上传域名列表',
            'file2' => '上传资产列表',
            'file3' => '上传xss规则',
            'file4' => '上传sql注入规则',
            'file5' => '上传文件包含规则'
        ];
    }
}
