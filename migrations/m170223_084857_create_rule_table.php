<?php

use yii\db\Migration;

/**
 * Handles the creation of table `rule`.
 */
class m170223_084857_create_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('rule', [
            'id' => $this->primaryKey(),
            'name' => $this->string(32)->comment('规则名称'),
            'request_body' => $this->string(12)->comment('请求体'),
            'type' => $this->smallInteger(1)->defaultValue(1)->comment('扫描类型'),
            'method' => $this->string(32)->comment('关联方案'),
            's_level' => $this->smallInteger(1)->defaultValue(1)->comment('扫描级别'),
            'r_level' => $this->smallInteger(1)->defaultValue(1)->comment('风险级别'),
            'r_par' => $this->smallInteger(3)->comment('响应参数'),
            'par_route' => $this->string(32)->comment('路径参数'),
            'route' => $this->string(64)->defaultValue('/index/index.php')->comment('请求路径'),
            'reg' => $this->string(128)->comment('匹配正则')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('rule');
    }
}
