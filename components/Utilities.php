<?php
namespace app\components;
use Yii;
use app\models\Cart;

class Utilities {

	public static function getCart() {

		// Get or create the cart session ID:
		$cookies = Yii::$app->request->cookies;
		if ($cookies->has('SESSION')) {
			$sess = $cookies['SESSION']->value;
		} else {
			$sess = bin2hex(openssl_random_pseudo_bytes(16));
		}

		// Send the cookie:
		$cookies = Yii::$app->response->cookies;
		$cookies->add(new \yii\web\Cookie([
			'name' => 'SESSION',
			'value' => $sess,
			'expire' => time()+(60*60*24*30)
		]));

		$cart=Cart::find()->where(['customer_session_id' => $sess])->one();
		if($cart===null) {
			$cart = new Cart();
			$cart->customer_session_id = $sess;
			$cart->save();
		}
		return $cart;

	}

	public static function formatAmount($amount) {
		return  \Yii::$app->formatter->asCurrency($amount/100, 'USD');
	}

	public static function formatDate($date, $format = 'long') {
		return \Yii::$app->formatter->asDate($date, $format);
	}

}
