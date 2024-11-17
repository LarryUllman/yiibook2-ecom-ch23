<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\Utilities;

/** @var yii\web\View $this */
/** @var app\models\Cart $model */

$this->title = 'View Cart';
\yii\web\YiiAsset::register($this);


?>
<div class="cart-view">

    <h1>View Cart</h1>

    <p>
        <?= Html::a('Empty Cart', 'clear', [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to empty the cart?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
    'dataProvider' => $model->getContents(),
    'columns' => [
        [
            'header' => 'Title',
            'enableSorting' => false,
            'format' => "html",
            'value' => function ($data) {
                return Html::a($data['book']['title'], ['book/view', 'id' => $data['book']['id']]);
            },
        ],
        [
            'header' => 'Price',
            'enableSorting' => false,
            'value' => function ($data) {
                return Utilities::formatAmount($data['book']['price']); 
            },
        ],
        [
            'header' => 'Quantity',
            'enableSorting' => false,
            'value' => 'quantity', 
        ],
        [
            'header' => 'Remove',
            'class' => 'yii\grid\ActionColumn',
            'template' => '{remove}',
            'buttons' => [
                'remove' => function ($url, $model, $key) {
                    return Html::a('Remove', ['cart/delete', 'book_id' => $model['book_id']]);
                },
            ]
        ]
    ]
]); ?>

    <p><b>Total</b>: <?php echo Utilities::formatAmount($model->getTotal()); ?></p>
    <p><?php echo Html::a('Checkout', array ('/pay')); ?></p>

</div>
