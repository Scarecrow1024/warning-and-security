<?php

use yii\db\Migration;

/**
 * Handles the creation of table `group`.
 */
class m170206_072909_create_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('group', [
            'id' => $this->primaryKey(),
            'group_name' => $this->string('25')->comment('报警组名称'),
            'users' => $this->string('255')->defaultValue('[""]')->comment('通知人')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('group');
    }
}
