<?php

use yii\db\Migration;

/**
 * Handles the creation of table `admin_log`.
 */
class m170227_061620_create_admin_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('admin_log', [
            'id' => $this->primaryKey(),
            'user' => $this->string(32)->comment('用户'),
            'type' => $this->string(32)->comment('日志类型'),
            'preview' => $this->string()->comment('日志预览'),
            'details' => $this->string()->comment('日志详情'),
            'times' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin_log');
    }
}
