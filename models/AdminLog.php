<?php

namespace app\models;

use Yii;
use moonland\phpexcel\Excel;

/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id
 * @property string $user
 * @property string $type
 * @property string $preview
 * @property string $times
 * @property string $details
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['times'], 'safe'],
            [['details'], 'string'],
            [['user', 'type', 'preview'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user' => Yii::t('app', '用户'),
            'type' => Yii::t('app', '日志类型'),
            'preview' => Yii::t('app', '内容预览'),
            'times' => Yii::t('app', '时间'),
            'details' => Yii::t('app', '详情'),
        ];
    }

    public static function exportLog()
    {
        $log_model = new AdminLog();
        $log_model->user = Yii::$app->user->identity->username ?: ' ';
        $log_model->type = "管理员";
        $log_model->preview = "导出操作日志";
        $log_model->times = date("Y-m-d H:i:s", time());
        $log_model->details = ' ';
        $log_model->save();
    }

    public static function action_log($username='', $type='', $preview='', $details=''){
        $model = new AdminLog();
        $model->user = $username;
        $model->type = $type;
        $model->preview = $preview;
        $model->details = $details;
        $model->times = date('Y-m-d H:i:s', time());
        $model->save();
    }

}
