<?php

namespace backend\modules\categorys\controllers;

use Yii;
use backend\modules\categorys\models\District;
use backend\modules\categorys\models\DistrictSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\models\Logfile;
use yii\web\ForbiddenHttpException;
/**
 * DistrictController implements the CRUD actions for District model.
 */
class DistrictController extends Controller
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
     * Lists all District models.
     * @return mixed
     */
    public function actionIndex()
    {
        if( Yii::$app->user->can('VIEW_DISTRICT'))
        {
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
            } else {
                $error = false;
            }
            if (isset($_POST['record'])) {
                $records = $_POST['record'];
                $num = (int)$records;
                setcookie("pagenumber", $num, time() + 300);
            } else {
                // $config = new Configsystem();
                $records = 20;
                $num = (int)$records;
                if (isset($_COOKIE['pagenumber'])) {
                    $num = $_COOKIE['pagenumber'];
                    $records = $_COOKIE['pagenumber'];
                }
            }
            $searchModel = new DistrictSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->pagination->pageSize = $num;
            //log
            $action = __FUNCTION__;
            $log = new Logfile();
            $arr = array();
            $messages = 'Truy cập màn hình quản lý';
            $resource = 'Danh mục quận huyện';
            $level = 3;
            array_push($arr, $messages);
            array_push($arr, $level);
            array_push($arr, $action);
            array_push($arr, $resource);
            $log->save_log_to_db(Yii::$app->user->id,$arr);
            //end log 
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'records' => $records,
                'error' => $error,
            ]);
        }
        else
            {
                throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Displays a single District model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        //log
        $action = __FUNCTION__;
        $log = new Logfile();
        $arr = array();
        $messages = 'Thực thi chức năng xem chi tiết';
        $resource = 'Danh mục quận huyện';
        $level = 3;
        array_push($arr, $messages);
        array_push($arr, $level);
        array_push($arr, $action);
        array_push($arr, $resource);
        $log->save_log_to_db(Yii::$app->user->id,$arr);
        //end log 
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new District model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( Yii::$app->user->can('ADD_DISTRICT'))
        {
            $model = new District();
            $model->create_user_id = Yii::$app->user->id;
            $model->create_time = time();
            $model->is_valid = 1;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($model->load(Yii::$app->request->post())) 
            {
                $model->begin_time = $model->begin_time ? strtotime($model->begin_time) : Null;

                $model->end_time = $model->end_time ? strtotime($model->end_time) : Null;
                $model->name = pg_escape_string($model->name);
                $model->description = pg_escape_string($model->description);
                //log
                    $action = __FUNCTION__;
                    $log = new Logfile();
                    $arr = array();
                    $messages = 'Thực thi chức năng thêm mới';
                    $resource = 'Danh mục quận huyện';
                    $level = 3;
                    array_push($arr, $messages);
                    array_push($arr, $level);
                    array_push($arr, $action);
                    array_push($arr, $resource);
                    $log->save_log_to_db(Yii::$app->user->id,$arr);
                //end log 
                if( !(District::find()->where(['code' => $model->code])->exists()) && $model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                   $id = District::find()->select('id')->where(['code' => $model->code])->one();
                   return $this->redirect(['view', 'id' => $id->id]);
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
     * Updates an existing District model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
            $model = $this->findModel($id);
            $model->update_user_id = Yii::$app->user->id;
            $model->update_time = time();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($model->load(Yii::$app->request->post())) {
                $model->begin_time = $model->begin_time ? strtotime($model->begin_time) : Null;

                $model->end_time = $model->end_time ? strtotime($model->end_time) : Null;
                $model->name = pg_escape_string($model->name);
                $model->description = pg_escape_string($model->description);
                //log
                    $action = __FUNCTION__;
                    $log = new Logfile();
                    $arr = array();
                    $messages = 'Thực thi chức năng chỉnh sửa';
                    $resource = 'Danh mục quận huyện';
                    $level = 3;
                    array_push($arr, $messages);
                    array_push($arr, $level);
                    array_push($arr, $action);
                    array_push($arr, $resource);
                    $log->save_log_to_db(Yii::$app->user->id,$arr);
                //end log 
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
    }


    public function actionImport()
    {
        $model = new District();

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'file');
            $filename = 'quanhuyen.' . $file->extension;
            $upload = $file->saveAs('uploads/' . $filename);
            $objPHPExcel = \PHPExcel_IOFactory::load('uploads/quanhuyen.' . $file->extension);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $data_first = current($sheetData);
            $flag = true;
            $key_error = '';
            $check_date = "/\b\d{4}[\/-]\d{1,2}[\/-]\d{1,2}\b/";
            if (trim($data_first['A']) != 'STT' || trim($data_first['B']) != 'Mã quận huyện(*)' || trim($data_first['C']) != 'Tên quận huyện(*)' || trim($data_first['D']) != 'Mã tỉnh thành(*)' || trim($data_first['E']) != 'Ngày bắt đầu' || trim($data_first['F']) != 'Ngày kết thúc' || trim($data_first['G']) != 'Mô tả') 
                {
                    $flag = false;
                    $key_error = 'title sai cấu trúc';
                }

            if ($flag == true) {
                $cut = array_shift($sheetData);
                $model_data = District::find()->all();
                foreach ($sheetData as $key_import => $value_import) {
                    if ($model_data) 
                    {
                     foreach ($model_data as $key => $value) 
                         {
                            if (trim($value_import['B']) == $value['code']) 
                                {
                                    $key_error = $key_import+1 . ' trùng mã quận huyện';
                                    $flag = false;
                                    break;
                                }
                            if (trim($value_import['C']) == $value['name']) 
                                {
                                    $key_error = $key_import+1 . ' trùng tên quận huyện';
                                    $flag = false;
                                    break;
                                } 
                        }
                    }
                    foreach ($value_import as $key_x => $value_x) 
                        {
                            $pos = strrpos($value_x, "<");
                            if ($pos !== false) 
                                { 
                                    $key_error = $key_import+1 . ' có chứa ký tự đặc biệt';
                                    $flag = false;
                                    break;
                                }
                        }
                    $posSpace = preg_match('/\s/', $value_import['B']);
                    if ($posSpace == 1) 
                        {
                            $key_error = $key_import + 1 . ' mã quận huyện có chứa dấu cách';
                            $flag = false;
                            break;
                        }
                    if (strlen(trim($value_import['B'])) > 255 ) 
                    {
                        $key_error = $key_import+1 . ' mã quận huyện lớn hơn 255 ký tự';
                        $flag = false;
                        break;
                    }

                    if (strlen(trim($value_import['C'])) > 255 ) 
                        {
                            $key_error = $key_import+1 . ' tên quận huyện lớn hơn 255 ký tự';
                            $flag = false;
                            break;
                        }
                    if (strlen(trim($value_import['D'])) > 255 ) 
                        {
                            $key_error = $key_import+1 . ' mã tỉnh thành lớn hơn 255 ký tự';
                            $flag = false;
                            break;
                        }

                    if (strlen(trim($value_import['G'])) > 255 ) 
                        {
                            $key_error = $key_import+1 . ' mô tả lớn hơn 255 ký tự';
                            $flag = false;
                            break;
                        }
                    if ($value_import['C'] == '') 
                        {
                            $key_error = $key_import+1 . ' tên quận huyện không được trống';
                            $flag = false;
                            break;
                        }
                    if ($value_import['B'] == '') 
                        {
                            $key_error = $key_import+1 . ' mã quận huyện không được trống';
                            $flag = false;
                            break;
                        }

                     if ($value_import['D'] == '') 
                        {
                            $key_error = $key_import+1 . ' mã tỉnh thành không được trống';
                            $flag = false;
                            break;
                        }

                     if ($value_import['E']) 
                            {
                                $value_import['E'] = District::convertDate($value_import['E']); 
                               if(!preg_match($check_date ,$value_import['E'], $matchs))
                                {
                                    $key_error = $key_import+1 . ' ngày bắt đầu không đúng định dạng';
                                    $flag = false;
                                    break;
                                }
                            }

                     if ($value_import['F']) 
                            {
                                $value_import['F'] = District::convertDate($value_import['F']); 
                               if(!preg_match($check_date ,$value_import['F'], $matchs))
                                {
                                    $key_error = $key_import+1 . ' ngày kết thúc không đúng định dạng';
                                    $flag = false;
                                    break;
                                }
                            }

                }

            }
            if ($flag == true) {
                foreach ($sheetData as $key => $value_sh) {
                    $id_user = Yii::$app->user->id;
                    $time = time();
                    $is_valid = 1;
                    $value_sh['B'] = pg_escape_string(trim($value_sh['B']));
                    $value_sh['C'] = pg_escape_string(trim($value_sh['C']));
                    $value_sh['D'] = pg_escape_string(trim($value_sh['D']));
                    $value_sh['G'] = pg_escape_string(trim($value_sh['G']));
                    $begin_time = $value_sh['E'] ? strtotime(District::convertDate($value_sh['E'])) : 0;
                    $end_time = $value_sh['F'] ? strtotime(District::convertDate($value_sh['F'])) : 0;
                    $sql = "INSERT INTO district (code, name,province_code,begin_time,end_time,description,is_valid,create_user_id,create_time) VALUES ('".$value_sh['B']."','".$value_sh['C']."','".$value_sh['D']."',CASE ".$begin_time." when 0 then NULL ELSE ".$begin_time." END,CASE ".$end_time." when 0 then NULL ELSE ".$end_time." END,'".$value_sh['G']."','".$is_valid."','".$id_user."','".$time."')";
                    Yii::$app->db->createCommand($sql)->execute();
                }
                //log
                    $action = __FUNCTION__;
                    $log = new Logfile();
                    $arr = array();
                    $messages = 'Import dữ liệu thành công';
                    $resource = 'Danh mục quận huyện';
                    $level = 3;
                    array_push($arr, $messages);
                    array_push($arr, $level);
                    array_push($arr, $action);
                    array_push($arr, $resource);
                    $log->save_log_to_db(Yii::$app->user->id,$arr);
                    //end log 
                return Yii::$app->response->redirect(['/categorys/district']);
            } else {
                //log
                    $action = __FUNCTION__;
                    $log = new Logfile();
                    $arr = array();
                    $messages = 'Import không thành công';
                    $resource = 'Danh mục quận huyện';
                    $level = 3;
                    array_push($arr, $messages);
                    array_push($arr, $level);
                    array_push($arr, $action);
                    array_push($arr, $resource);
                    $log->save_log_to_db(Yii::$app->user->id,$arr);
                    //end log 
                return Yii::$app->response->redirect(['/categorys/district', 'error' => $key_error]);
            }
        }
    }


    /**
     * Deletes an existing District model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if( Yii::$app->user->can('DELETE_DISTRICT'))
        {
            if (isset($_POST['value'])) 
            {
                $id = $_POST['value'];
                $this->findModel($id)->delete();
                //log
                $action = __FUNCTION__;
                $log = new Logfile();
                $arr = array();
                $messages = 'Thực thi chức năng xóa';
                $resource = 'Danh mục quận huyện';
                $level = 3;
                array_push($arr, $messages);
                array_push($arr, $level);
                array_push($arr, $action);
                array_push($arr, $resource);
                $log->save_log_to_db(Yii::$app->user->id,$arr);
                //end log 

                return 'success';
            }
            else
            {
                return 'error';
            }
        }
        else
            {
                throw new ForbiddenHttpException('Bạn không có quyền truy cập chức năng này !');
            }
    }

    /**
     * Finds the District model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return District the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
