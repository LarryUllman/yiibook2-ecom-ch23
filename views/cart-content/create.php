<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CartContent $model */

$this->title = 'Create Cart Content';
$this->params['breadcrumbs'][] = ['label' => 'Cart Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
