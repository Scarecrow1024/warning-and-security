<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file_rule`.
 */
class m170302_032001_create_file_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('file_rule', [
            'id' => $this->primaryKey(),
            'value' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('file_rule');
    }
}
