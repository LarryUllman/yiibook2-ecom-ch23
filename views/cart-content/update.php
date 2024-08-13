<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CartContent $model */

$this->title = 'Update Cart Content: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cart Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cart-content-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
