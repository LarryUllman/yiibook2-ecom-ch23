<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartContent;
use app\models\CartSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\Utilities;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
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
                        'delete' => ['GET'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAdd($id)
    {
        // Need the cart:
        $cart = Utilities::getCart();

		// Check for the item already being in the cart:
        $item = CartContent::find()
            ->where(['cart_id' => $cart->id, 'book_id' => $id])
            ->one();

        // If the item already exists, add another:
        if($item!==null) {
            $item->quantity = $item->quantity + 1;
        } else { // New item:
            $item = new CartContent();
            $item->cart_id = $cart->id;
            $item->book_id = $id;
            $item->quantity = 1;
        }

        // Save the item:
        $item->save();

        // Show the cart contents:
        return $this->render('view',array(
            'model'=>$cart
        ));
}

    /**
     * Shows the a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {

        // Need the cart:
        $cart = Utilities::getCart();

        return $this->render('view', [
            'model' => $cart,
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
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
     * Deletes a cart item (a single CartContent row).
     * @param int $book_id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
public function actionDelete($book_id)
{

    // Need the cart:
    $cart = Utilities::getCart();
    $cmd = \Yii::$app->db->createCommand()->delete('cart_content', ['cart_id' => $cart->id, 'book_id' => $book_id]);
    $cmd->execute();
    
    return $this->render('view',array(
        'model'=>$cart
    ));

}

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
