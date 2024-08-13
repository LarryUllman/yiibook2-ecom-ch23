<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property int $id
 * @property string $email
 * @property string|null $pass
 * @property int $get_emails
 * @property string $date_entered
 *
 * @property Download[] $downloads
 * @property PasswordToken[] $passwordTokens
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['get_emails'], 'integer'],
            [['date_entered'], 'safe'],
            [['email'], 'string', 'max' => 80],
            [['pass'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'pass' => 'Pass',
            'get_emails' => 'Get Emails',
            'date_entered' => 'Date Entered',
        ];
    }

    /**
     * Gets query for [[Downloads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDownloads()
    {
        return $this->hasMany(Download::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[PasswordTokens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPasswordTokens()
    {
        return $this->hasMany(PasswordToken::class, ['customer_id' => 'id']);
    }
}
