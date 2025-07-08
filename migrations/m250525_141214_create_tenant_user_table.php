<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tenant_user}}`.
 */
class m250525_141214_create_tenant_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%tenant_user}}', [
            'id' => $this->primaryKey(),
            'tenant_id' => $this->char(36)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'role' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey(
            'fk-tenant_user-tenant_id',
            '{{%tenant_user}}',
            'tenant_id',
            '{{%tenants}}',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-tenant_user-user_id',
            '{{%tenant_user}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-tenant_user-tenant_id',
            '{{%tenant_user}}',
            'tenant_id'
        );
        $this->createIndex(
            'idx-tenant_user-user_id',
            '{{%tenant_user}}',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tenant_user}}');
    }
}
