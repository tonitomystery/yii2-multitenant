<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tenants}}`.
 */
class m250525_141213_create_tenants_table extends Migration
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
        $this->createTable('{{%tenants}}', [
            'id' => $this->char(36)->notNull()->append('PRIMARY KEY'),
            'name' => $this->string()->notNull(),
            'data' => $this->json(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tenants}}');
    }
}
