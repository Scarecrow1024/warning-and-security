<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "available".
 *
 * @property integer $id
 * @property string $name
 * @property string $addr
 * @property integer $ct
 * @property integer $cm
 * @property integer $cu
 * @property string $upd_data
 * @property integer $frequency
 * @property integer $number
 * @property integer $report_status
 * @property integer $delay
 * @property integer $report_time
 * @property string $report_group
 */
class Available extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'available';
    }

    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ct', 'cm', 'cu', 'frequency', 'number', 'report_status', 'delay', 'report_time'], 'integer'],
            [['upd_data'], 'safe'],
            [['name'], 'string', 'max' => 32],
            [['addr'], 'string', 'max' => 20],
            [['report_group'], 'string', 'max' => 12],
            [['file'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'addr' => 'Addr',
            'ct' => 'Ct',
            'cm' => 'Cm',
            'cu' => 'Cu',
            'upd_data' => 'Upd Data',
            'frequency' => 'Frequency',
            'number' => 'Number',
            'report_status' => 'Report Status',
            'delay' => 'Delay',
            'report_time' => 'Report Time',
            'report_group' => 'Report Group',
        ];
    }
}
