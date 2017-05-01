<?php

use yii\db\Migration;

/**
 * Handles the creation of table `xss_rule`.
 */
class m170302_031950_create_xss_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('xss_rule', [
            'id' => $this->primaryKey(),
            'value' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('xss_rule');
    }
}
