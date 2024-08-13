<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $payment_id
 * @property int $total
 * @property string $date_entered
 *
 * @property Customer $customer
 * @property OrderContent[] $orderContents
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'payment_id', 'total'], 'required'],
            [['customer_id', 'payment_id', 'total'], 'integer'],
            [['date_entered'], 'safe'],
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
            'payment_id' => 'Payment ID',
            'total' => 'Total',
            'date_entered' => 'Date Entered',
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

    /**
     * Gets query for [[OrderContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderContents()
    {
        return $this->hasMany(OrderContent::class, ['order_id' => 'id']);
    }
}
