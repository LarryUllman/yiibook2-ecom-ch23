<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="pay-default-index">

<?php $form = ActiveForm::begin([
    'id' => 'payment-form',
    'options' => ['data-secret' => $intent->client_secret],
]); ?>

    <div id="card-element">
    <!-- Elements will create input elements here -->
    </div>

    <!-- We'll put the error messages in this element -->
    <div id="card-errors" role="alert"></div>

  <div id="email">
    <?= $form->field($model, 'email')->textInput() ?>
  </div>

  <?= $form->field($model, 'payment_id')->hiddenInput(['payment_id' => $model->payment_id])->label(false) ?>
  <button id="card-button">Submit Payment</button>
<?php ActiveForm::end(); ?>
</div>


<?php $this->registerJsFile('https://js.stripe.com/v3/'); ?>

<?php $this->registerJs("var stripe = Stripe('{$publishable_key}');

// Create the card element:
var elements = stripe.elements();
var card = elements.create('card');
card.mount('#card-element');

// Watch for input:
var displayError = document.getElementById('card-errors');
card.on('change', function(event) {
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

// Handle the form submission:
var form = document.getElementById('payment-form');
document.getElementById('card-button').addEventListener('click', function(ev) {
  ev.preventDefault();
  stripe.confirmCardPayment(form.dataset.secret, {
    payment_method: {
      card: card,
    }
  }).then(function(result) {
    if (result.error) {
      displayError.textContent = result.error.message;
    } else {
      // The payment has been processed!
      if (result.paymentIntent.status === 'succeeded') {
        form.submit();
      }
    }
  });
});
"); ?>
