<?php

use yii\db\Migration;

/**
 * Handles the creation of table `scan_result`.
 */
class m170223_072842_create_scan_result_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('scan_result', [
            'id' => $this->primaryKey(),
            's_id' => $this->integer(11)->comment('扫描任务id'),
            'url' => $this->string(128)->comment('漏洞url'),
            'type' => $this->string(32)->comment('漏洞类型'),
            'level' => $this->string(4)->comment('漏洞级别')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('scan_result');
    }
}
