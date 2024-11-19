<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use app\models\Customer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\components\Utilities;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Order models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {


        // Must have processed a charge before coming here:
        if (!isset(\Yii::$app->session['payment_id'])) {
            throw new ForbiddenHttpException('You have not made a purchase.');
        }

    	// Get the payment info:
        $q = new Query();
        $payment = $q->select('*')
        ->from('payment')
        ->where(['id' => \Yii::$app->session['payment_id']])
        ->one();

        if (!$payment) {
            throw new ForbiddenHttpException('You have not made a purchase.');
        }

        // Fetch the customer, if existing:
        $customer = Customer::findOne(['email' => $payment['email']]);

        // If no customer, create a new one:
        if($customer===null) {
            $customer = new Customer;
            $customer->email = $payment['email'];
            $customer->save();
        }

        // Record the order:
        $order=new Order;
        $order->customer_id = $customer->id;
        $order->payment_id = $payment['id'];
        $order->total = $payment['amount'];
        $order->date_entered = $payment['created_at'];
        $order->save();

        // Store the order contents in the order contents table:
        $cart = Utilities::getCart();
        $cmd = \Yii::$app->db->createCommand('INSERT INTO order_content 
        (order_id, book_id, quantity, price_per) 
        SELECT :order_id, cc.book_id, cc.quantity, b.price 
        FROM cart_content AS cc, book AS b 
        WHERE (b.id=cc.book_id) AND (cc.cart_id=:cart_id)');
        $order_id = $order->id;
        $cart_id = $cart->id;
        $cmd->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        $cmd->bindParam(':cart_id', $cart_id, \PDO::PARAM_INT);
        $cmd->execute();

        // Clear the cart:
        $cart->clear();

        return $this->render('view', [
            'model' => $order,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
