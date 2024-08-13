<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "password_token".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $token
 * @property string $date_expires
 *
 * @property Customer $customer
 */
class PasswordToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'password_token';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'token', 'date_expires'], 'required'],
            [['customer_id'], 'integer'],
            [['date_expires'], 'safe'],
            [['token'], 'string', 'max' => 64],
            [['token'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'token' => 'Token',
            'date_expires' => 'Date Expires',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
}
