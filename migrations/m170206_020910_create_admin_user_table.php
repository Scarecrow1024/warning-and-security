<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `admin_user`.
 */
class m170206_020910_create_admin_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableName = 'admin_users';
        $linkColumn = array(
            'uid'  => 'pk COMMENT "用户主键"',
            'username' => Schema::TYPE_STRING . ' COMMENT "用户名称"',
            'password' => Schema::TYPE_STRING . ' COMMENT "用户密码"',
            'real_name' => Schema::TYPE_STRING . ' COMMENT "真实姓名"',
            'photo' => Schema::TYPE_STRING . ' COMMENT "头像"',
            'phone' => Schema::TYPE_STRING . ' COMMENT "联系方式"',
            'mail' => Schema::TYPE_STRING . ' COMMENT "邮箱"',
            'authKey' => Schema::TYPE_STRING . ' COMMENT "用户Key"',
            'secret' => Schema::TYPE_STRING . ' COMMENT "google-secret"',
            'salt' => Schema::TYPE_INTEGER . ' COMMENT "随机盐值"',
            'created' => Schema::TYPE_DATETIME.' COMMENT "创建时间"',
            'updated' => Schema::TYPE_DATETIME.' COMMENT "修改时间"',
            'status' => Schema::TYPE_INTEGER . ' COMMENT "用户状态"' . 'DEFAULT 1',
            'google_status' => Schema::TYPE_INTEGER . ' COMMENT "google-secret状态"' . 'DEFAULT 0',
        );
        $linkOptions =' ENGINE=Innodb DEFAULT CHARSET=utf8';
        $this->createTable($tableName, $linkColumn);

        // 初始化账户 admin 密码 admin
        $this->insert( $tableName, array(
                                        'username' => 'admin',
                                        'password' => '28387c0ea018abe8bad4489da274fb21',
                                        'phone' => '15639128975',
                                        'mail' => '819681825@qq.com',
                                        'real_name' => '超级管理员',
                                        'salt' => '822503',
                                        ));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('admin_user');
    }
}
