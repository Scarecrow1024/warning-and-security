<?php

use yii\db\Migration;

/**
 * Handles the creation of table `asset`.
 */
class m170216_081154_create_asset_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('asset', [
            'id' => $this->primaryKey(),
            'name' => $this->string('32')->defaultValue('')->comment('资产名称'),
            'url' => $this->string('32')->defaultValue('')->comment('资产url'),
            'ip' => $this->string('32')->defaultValue('')->comment('资产ip'),
            'type' => $this->smallInteger('1')->defaultValue(1)->comment('资产类型'),
            'user' => $this->string('16')->defaultValue('')->comment('所属人')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('asset');
    }
}
