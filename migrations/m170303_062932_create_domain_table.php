<?php

use yii\db\Migration;

/**
 * Handles the creation of table `domain`.
 */
class m170303_062932_create_domain_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('domain', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->comment('网站名称'),
            'url' => $this->string()->comment('网站url'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('domain');
    }
}
