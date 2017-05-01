<?php

use yii\db\Migration;

/**
 * Handles the creation of table `setting`.
 */
class m170210_070245_create_setting_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'key' => $this->string(32),
            'value' => $this->string(64),
            'comment' => $this->string(64)->comment('注释')
            /*'frequency' => $this->smallInteger(4)->defaultValue(10)->comment('监控频率'),
            'delay' => $this->smallInteger(4)->defaultValue(400)->comment('响应时间'),
            'loss' => $this->smallInteger(3)->defaultValue(90)->comment('丢包率'),
            'number' => $this->smallInteger(2)->defaultValue(10)->comment('发包量'),
            'git_time' => $this->string(11)->defaultValue(0)->comment('github更新时间'),*/
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('setting');
    }
}
