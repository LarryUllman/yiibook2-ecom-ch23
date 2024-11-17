<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property string $customer_session_id
 * @property string|null $date_modified
 *
 * @property CartContent[] $cartContents
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_session_id'], 'required'],
            [['date_modified'], 'safe'],
            [['customer_session_id'], 'string', 'max' => 32],
            [['customer_session_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_session_id' => 'Customer Session ID',
            'date_modified' => 'Date Modified',
        ];
    }

    /**
     * Gets query for [[CartContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartContents()
    {
        return $this->hasMany(CartContent::class, ['cart_id' => 'id']);
    }

    public function getContents()
    {
        return new ActiveDataProvider([
            'query' => $this->getCartContents()
        ]);
    }

    // Returns the total of the items in a cart (as an integer).
    public function getTotal()
    {
        $q = new Query();
        return $q->select('SUM(quantity * book.price)')
        ->from('cart_content')
        ->join('INNER JOIN', 'book', 'book_id=book.id')
        ->where(['cart_id' => $this->id])
        ->scalar();
    }

}
