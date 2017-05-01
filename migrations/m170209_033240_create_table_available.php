<?php

use yii\db\Migration;

class m170209_033240_create_table_available extends Migration
{
    public function up()
    {
        $this->createTable('available', [
            'id' => $this->primaryKey(),
            'name' => $this->string('32')->comment('名称'),
            'addr' => $this->string('20')->comment('ip/域名'),
            'ct' => $this->smallInteger('4')->defaultValue(0)->comment('电信延迟'),
            'cm' => $this->smallInteger('4')->defaultValue(0)->comment('移动延迟'),
            'cu' => $this->smallInteger('4')->defaultValue(0)->comment('联通延迟'),
            'upd_data' => $this->dateTime(),
            'frequency' => $this->smallInteger(3)->defaultValue(0)->comment('监控频率'),
            'number' => $this->smallInteger(2)->defaultValue(10)->comment('发包数量'),
            'report_status' => $this->smallInteger(1)->defaultValue(0)->comment('报警开关'),
            'delay' => $this->smallInteger(4)->defaultValue(200)->comment('延迟时间'),
            'report_time' => $this->smallInteger(2)->defaultValue(1)->comment('报警次数'),
            'report_group' => $this->string('12')->defaultValue('["1"]')->comment('报警组')
        ]);
    }

    public function down()
    {
        echo "m170209_033240_create_table_available cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
