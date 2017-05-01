<?php

use yii\db\Migration;

/**
 * Handles the creation of table `coors`.
 */
class m170208_135228_create_coors_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('coors', [
            'id' => $this->primaryKey(),
            'wanip' => $this->string('20')->comment('ip'),
            'city' => $this->string('20')->comment('city'),
            'x' => $this->string('16')->defaultValue('')->comment('经度'),
            'y' => $this->string('25')->comment('维度'),
            'upd_data' => $this->string('32')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('coors');
    }
}
