<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tenant_user".
 *
 * @property int $id
 * @property string $tenant_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Tenant $tenant
 * @property User $user
 */
class TenantUser extends \yii\db\ActiveRecord
{
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
        return 'tenant_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'user_id', 'role'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['tenant_id'], 'string', 'max' => 36],
            [['role'], 'string', 'max' => 255],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tenant::class, 'targetAttribute' => ['tenant_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenant_id' => 'Tenant ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Tenant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::class, ['id' => 'tenant_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
