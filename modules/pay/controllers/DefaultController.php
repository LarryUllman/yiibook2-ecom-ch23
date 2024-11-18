<?php

namespace app\modules\pay\controllers;

use yii\web\Controller;
use app\modules\pay\models\Payment;

/**
 * Default controller for the `pay` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $module = \Yii::$app->controller->module;

        $model = new Payment;
        if ($model-> amount === null) {
            $model->amount = \Yii::$app->controller->module->amount;
        }

        // Handle the form submission:
        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            // Store values in session:
            \Yii::$app->session['payment_id'] = $model->id;

            // Redirect:
            if (!empty(\Yii::$app->controller->module->redirectOnSuccess)) {
                return $this->redirect(\Yii::$app->controller->module->redirectOnSuccess);
            } else {
                return $this->render('thanks', ['model' => $model]);
            }

        // Present the form:
        } else {

            \Stripe\Stripe::setApiKey($module->secret_key);

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $model->amount,
                'currency' => 'usd',
            ]);
            $model->payment_id = $intent->id;

            return $this->render('index', ['model' => $model, 'intent' => $intent, 'publishable_key' => $module->publishable_key]);
        }

    }
}
