<?php

namespace app\modules\pay\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property string $payment_id
 * @property string $email
 * @property int $amount
 * @property string $created_at
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_id', 'email', 'amount'], 'required'],
            [['amount'], 'number', 'integerOnly' => true, 'min' => 50],
            [['email'], 'email'],
            [['created_at'], 'safe'],
            [['payment_id', 'email'], 'string', 'max' => 100],
            [['payment_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment_id' => 'Payment ID',
            'email' => 'Email',
            'amount' => 'Amount (in cents)',
            'created_at' => 'Payment Date',
        ];
    }
}
