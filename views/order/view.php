<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\Utilities;

/** @var yii\web\View $this */
/** @var app\models\Order $model */

$this->title = 'Order Confirmation #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Order Number',
                'value' => $model->id,
            ],
            'customer.email',
            [
                'label' => 'Total',
                'value' => Utilities::formatAmount($model->total),
            ],
            [
                'label' => 'Order Date',
                'value' => Utilities::formatDate($model->date_entered),
            ],
        ],
    ]) ?>

    <h2>Download Purchases</h2>
    <ul>
    <?php $items = $model->orderContents;
    foreach ($items as $item) {
        echo '<li>' . HTML::a($item->book->title, ['/book/download', 'id' => $item->book_id]) . '</li>';
    }
    ?>
    </ul>

</div>
