<?php

namespace backend\modules\systems\controllers;

use Yii;
use backend\modules\systems\models\Authassignment;
use backend\modules\systems\models\AuthassignmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\ForbiddenHttpException;
/**
 * AuthassignmentController implements the CRUD actions for Authassignment model.
 */
class AuthassignmentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Authassignment models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( Yii::$app->user->can('VIEW_ROLE')){
            if (isset($_POST['record'])) {
                $records = $_POST['record'];
                $num = (int)$records;
                setcookie("pagenumber", $num,time() + 300);
            }
            else {
                        // $config = new Configsystem();
                $records = 20;
                $num = (int)$records;
                if(isset($_COOKIE['pagenumber'])){
                    $num = $_COOKIE['pagenumber'];
                    $records = $_COOKIE['pagenumber'];
                }
            }
            $searchModel = new AuthassignmentSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize=$num;
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'records' => $records,
            ]);
         }
        else
            {
                 throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Displays a single Authassignment model.
     * @param string $id
     * @return mixed
     */
    public function actionView($item_name,$user_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($item_name,$user_id),
        ]);
    }

    /**
     * Creates a new Authassignment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( Yii::$app->user->can('ADD_ROLE')){
            $model = new Authassignment();
             if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
            if ($model->load(Yii::$app->request->post())) {
                $model->created_at = time();
            if (!(Authassignment::find()->where( [ 'user_id' => $model->user_id ] )->exists())  && $model->save(false)) {
                return $this->redirect(['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]);
            }else{
                $auth = Authassignment::find()->select('*')->where(['user_id' => $model->user_id])->one();
                return $this->redirect(['view', 'item_name' => $auth->item_name, 'user_id' => $auth->user_id]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
         }
        else
            {
                 throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Updates an existing Authassignment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($item_name,$user_id)
    {
        if( Yii::$app->user->can('EDIT_ROLE')){
            $model = $this->findModel($item_name,$user_id);
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                        Yii::$app->response->format = Response::FORMAT_JSON;
                        return ActiveForm::validate($model);
                    }
            $model->updated_at = time();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'item_name' => $model->item_name, 'user_id'=> $model->user_id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
         }
        else
            {
                 throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Deletes an existing Authassignment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($item_name,$user_id)
    {
        $this->findModel($item_name,$user_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Authassignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Authassignment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($item_name,$user_id)
    {
        if (($model = Authassignment::findOne(['item_name' => $item_name, 'user_id' => $user_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
