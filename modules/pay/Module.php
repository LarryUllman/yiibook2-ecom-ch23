<?php

namespace app\modules\pay;

use yii\base\InvalidConfigException;
use app\components\Utilities;

/**
 * pay module definition class
 */
class Module extends \yii\base\Module
{

    public $publishable_key;
    public $secret_key;
    public $redirectOnSuccess;
    public $amount;

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\pay\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if ($this->publishable_key === null) {
            throw new InvalidConfigException("Your Stripe 'publishable_key' must be set.");
        }
        if ($this->secret_key === null) {
            throw new InvalidConfigException("Your Stripe 'secret_key' must be set.");
        }
        // custom initialization code goes here
        $cart = Utilities::getCart();
        $this->amount = $cart->getTotal();
        if($this->amount < 50) {
            throw new UserException('You have nothing to purchase.');
        }

    }
}
