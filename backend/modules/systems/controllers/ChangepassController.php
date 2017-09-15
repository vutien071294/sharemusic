<?php

namespace frontend\modules\systems\controllers;

use Yii;
use frontend\modules\systems\models\Changepass;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class ChangepassController extends Controller
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

    public function actionIndex()
    {
        // if( Yii::$app->user->can('change_password') ){
            $model = new Changepass();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $id = Yii::$app->user->id;
            if ($model->load(Yii::$app->request->post()) && $model->changepass($id)) {
                Yii::$app->user->logout();
                return $this->goHome();
            } else {
                return $this->render('index', [
                    'model' => $model,
                ]);
            }
        // }else
        // {
        //     throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
        // }
    }
}
