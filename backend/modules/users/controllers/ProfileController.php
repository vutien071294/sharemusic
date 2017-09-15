<?php

namespace backend\modules\users\controllers;

use Yii;
use backend\modules\users\models\User;
use backend\modules\users\models\Userinfo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\components\ComponentBase;
use backend\models\Logfile;
/**
 * GroupController implements the CRUD actions for Group model.
 */
class ProfileController extends Controller
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
        if( Yii::$app->user->can('VIEW_USER_MYSELF') ){
            $model = new Userinfo();
            $id_profile = Yii::$app->user->id;
            //log
            $action = __FUNCTION__;
            $log = new Logfile();
            $arr = array();
            $messages = 'Truy cập xem thông tin cá nhân';
            $resource = 'Profile';
            $level = 3;
            array_push($arr, $messages);
            array_push($arr, $level);
            array_push($arr, $action);
            array_push($arr, $resource);
            $log->save_log_to_db(Yii::$app->user->id,$arr);
            //end log
            return $this->render('view', ['model' => $model->get_user_by_id($id_profile)]);
        }else
        {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
        }
    }
    public function actionUpdate($id)
    {
        if( Yii::$app->user->can('EDIT_USER_MYSELF') ){
            $model = $this->findModel($id);
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                if ($model->birthday) {
                    $model->birthday = substr($model->birthday, 6,4).substr($model->birthday, 3,2).substr($model->birthday, 0,2);
                }else{
                     $model->birthday = 0;
                } 
                if ($model->provision_day) {
                    $model->provision_day = substr($model->provision_day, 6,4).substr($model->provision_day, 3,2).substr($model->provision_day, 0,2);
                }else{
                     $model->provision_day = 0;
                }
                $model->save(false);
                //log
                $action = __FUNCTION__;
                $log = new Logfile();
                $arr = array();
                $messages = 'Chỉnh sửa thông tin cá nhân';
                $resource = 'Profile';
                $level = 3;
                array_push($arr, $messages);
                array_push($arr, $level);
                array_push($arr, $action);
                array_push($arr, $resource);
                $log->save_log_to_db(Yii::$app->user->id,$arr);
                //end log
                $model = new Userinfo();
                $id_profile = Yii::$app->user->id;
                return $this->render('view', ['model' => $model->get_user_by_id($id_profile)]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else
        {
            throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
        }
    }
     protected function findModel($id)
    {
        if (($model = Userinfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
