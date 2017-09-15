<?php

namespace backend\modules\systems\controllers;

use Yii;
use backend\modules\systems\models\AuthItem;
use backend\modules\systems\models\AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\ForbiddenHttpException;
/**
 * AuthitemController implements the CRUD actions for AuthItem model.
 */
class AuthitemController extends Controller
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( Yii::$app->user->can('VIEW_PERMISSION')){
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
            $searchModel = new AuthItemSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize=$num;
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'records'=>$records,
            ]);
        }
        else
            {
                 throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( Yii::$app->user->can('ADD_PERMISSION')){
            $model = new AuthItem();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($model->load(Yii::$app->request->post())) {
            $model->type = 1;
            $model->created_at = time();
            if (!(Authitem::find()->where( [ 'name' => $model->name ] )->exists())  && $model->save(false)) 
            {
                $model->add_child_item($model->name,$model->list_permission);
                return $this->redirect(['view', 'id' => $model->name]);
            }else{
                $id = Authitem::find()->select('name')->where(['name' => $model->name])->one();
                return $this->redirect(['view', 'id' => $id->name]);
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
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( Yii::$app->user->can('EDIT_PERMISSION')){
            $model = $this->findModel($id);
            $old_name = $model->name;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                            Yii::$app->response->format = Response::FORMAT_JSON;
                            return ActiveForm::validate($model);
                        }
            if ($model->load(Yii::$app->request->post())) {
                $model->updated_at = time();
                if ($old_name == $model->name) {
                    $model->add_child_item($model->name,$model->list_permission);
                }
                else
                {
                    $model->add_child_item_new($old_name,$model->name,$model->list_permission);
                }
                $model->save();
                return $this->redirect(['view', 'id' => $model->name]);
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
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if( Yii::$app->user->can('DELETE_PERMISSION')){
            $model = new AuthItem();
            $model->delete_permisstion_in_authchild($id);
            $this->findModel($id)->delete();
            return $this->redirect(['index']);
        }
        else
        {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
        }
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
