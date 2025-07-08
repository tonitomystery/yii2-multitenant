<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tenants".
 *
 * @property string $id
 * @property string $name
 * @property string $domain
 * @property string $database
 * @property string|null $data
 * @property int $created_at
 * @property int $updated_at
 */
class Tenant extends \yii\db\ActiveRecord
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->id = \app\components\UuidGenerator::generate();
            }
            return true;
        }
        return false;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tenants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'default', 'value' => null],
            [['name'], 'required'],
            [['id', 'created_at', 'updated_at'], 'safe'],
            // [['data'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['id'], 'string', 'max' => 36],
            // [['name', 'domain', 'database'], 'string', 'max' => 255],
            // [['domain'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'domain' => 'Domain',
            'database' => 'Database',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets users related to this tenant via TenantUser.
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('tenant_user', ['tenant_id' => 'id']);
    }

    /**
     * Gets query for [[TenantUsers]].
     * @return \yii\db\ActiveQuery
     */
    public function getTenantUsers()
    {
        return $this->hasMany(TenantUser::class, ['tenant_id' => 'id']);
    }
}
