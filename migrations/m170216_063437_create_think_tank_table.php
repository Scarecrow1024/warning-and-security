<?php

use yii\db\Migration;

/**
 * Handles the creation of table `think_tank`.
 */
class m170216_063437_create_think_tank_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('think_tank', [
            'id' => $this->primaryKey(),
            'name' => $this->string('32')->defaultValue('')->comment('事件名称'),
            'source' => $this->string('32')->defaultValue('')->comment('漏洞来源'),
            'desc' => $this->string('128')->defaultValue('')->comment('事件描述'),
            'type' => $this->smallInteger(1)->defaultValue('1')->comment('漏洞类型'),
            'time' => $this->dateTime()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('think_tank');
    }
}
