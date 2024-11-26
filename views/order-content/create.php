<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\OrderContent $model */

$this->title = 'Create Order Content';
$this->params['breadcrumbs'][] = ['label' => 'Order Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
