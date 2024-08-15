<?php

use yii\helpers\Html;
use app\components\Utilities;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <img src="/images/<?= $model->id; ?>.jpg"><br />

    <p>
        <b><?= $model->getAttributeLabel('title'); ?>:</b>
        <?= Html::encode($model->title); ?>
    </p>

    <p>
        <b><?= $model->getAttributeLabel('price'); ?>:</b>
        <?= Utilities::formatAmount($model->price); ?>
    </p>

    <p>
        <b><?= $model->getAttributeLabel('author'); ?>:</b>
        <?= Html::encode($model->author); ?>
    </p>

    <p>
        <b><?= $model->getAttributeLabel('date_published'); ?>:</b>
        <?= Utilities::formatDate($model->date_published); ?>
    </p>

    <p>
        <b><?= $model->getAttributeLabel('description'); ?>:</b>
        <?= Html::encode($model->description); ?>
    </p>

    <p>
        <?= Html::a('Add to Cart', ['/cart/add', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
