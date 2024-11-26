<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CartContent $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="cart-content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cart_id')->textInput() ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
