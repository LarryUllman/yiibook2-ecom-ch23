<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\components\Utilities;
?>

<div class="view">

<?= Html::a('<img src="/images/' . $model->id . '.jpg">', ['book/view', 'id' => $model->id]); ?>
	<br />
	<b><?= $model->getAttributeLabel('title'); ?>:</b>
	<?= Html::encode($model->title); ?>
	<br />
	<b><?= $model->getAttributeLabel('price'); ?>:</b>
	<?= Utilities::formatAmount($model->price); ?>
	<br />
	<b><?= $model->getAttributeLabel('author'); ?>:</b>
	<?= Html::encode($model->author); ?>
	<br />
	<b><?= $model->getAttributeLabel('date_published'); ?>:</b>
	<?= Utilities::formatDate($model->date_published); ?>
	<br />
</div>
