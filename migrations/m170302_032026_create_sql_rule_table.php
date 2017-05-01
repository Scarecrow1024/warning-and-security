<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sql_rule`.
 */
class m170302_032026_create_sql_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('sql_rule', [
            'id' => $this->primaryKey(),
            'value' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('sql_rule');
    }
}
