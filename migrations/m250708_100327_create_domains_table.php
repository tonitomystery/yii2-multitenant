<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%domains}}`.
 */
class m250708_100327_create_domains_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        $this->createTable('{{%domains}}', [
            'id' => $this->char(36)->notNull()->append('PRIMARY KEY'),
            'tenant_id' => $this->char(36)->notNull(),
            'domain' => $this->string()->notNull()->unique(),
            'is_primary' => $this->boolean()->defaultValue(false)->notNull(),
            'is_active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        
        // Crear índice para tenant_id
        $this->createIndex(
            '{{%idx-domains-tenant_id}}',
            '{{%domains}}',
            'tenant_id'
        );
        
        // Añadir clave foránea para tenant_id
        $this->addForeignKey(
            '{{%fk-domains-tenant_id}}',
            '{{%domains}}',
            'tenant_id',
            '{{%tenants}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Eliminar clave foránea
        $this->dropForeignKey(
            '{{%fk-domains-tenant_id}}',
            '{{%domains}}'
        );
        
        // Eliminar índice
        $this->dropIndex(
            '{{%idx-domains-tenant_id}}',
            '{{%domains}}'
        );
        
        $this->dropTable('{{%domains}}');
    }
}
