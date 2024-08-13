<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int $price
 * @property string|null $description
 * @property string $author
 * @property string $filename
 * @property string $date_published
 *
 * @property CartContent[] $cartContents
 * @property Download[] $downloads
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'price', 'author', 'filename', 'date_published'], 'required'],
            [['price'], 'integer'],
            [['description'], 'string'],
            [['date_published'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['author', 'filename'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'description' => 'Description',
            'author' => 'Author',
            'filename' => 'Filename',
            'date_published' => 'Date Published',
        ];
    }

    /**
     * Gets query for [[CartContents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCartContents()
    {
        return $this->hasMany(CartContent::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Downloads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownloads()
    {
        return $this->hasMany(Download::class, ['book_id' => 'id']);
    }
}
