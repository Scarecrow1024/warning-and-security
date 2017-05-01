<?php

use yii\db\Migration;

/**
 * Handles the creation of table `scan`.
 */
class m170223_071516_create_scan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('scan', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->comment('任务名称'),
            'domail' => $this->string(32)->comment('目标站点'),
            'type' => $this->smallInteger(1)->defaultValue(1)->comment('扫描类型'),
            'node' => $this->string(32)->comment('扫描节点'),
            'user' => $this->string(32)->comment('提交人'),
            'status' => $this->smallInteger(1)->defaultValue(1)->comment('完成状态'),
            'time' => $this->dateTime()->comment('提交时间'),
            'alarm_status' => $this->smallInteger(1)->defaultValue(1)->comment('告警开关'),
            'alarm_condition' => $this->string(32)->defaultValue('[0,0,0]')->comment('告警条件'),
            'alarm_group' => $this->smallInteger(3)->defaultValue(1)->comment('告警对象')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('scan');
    }
}
