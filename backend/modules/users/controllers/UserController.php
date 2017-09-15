<?php

namespace backend\modules\users\controllers;

use Yii;
use backend\modules\users\models\User;
use backend\modules\users\models\Userinfo;
use backend\modules\users\models\UserSearch;
use backend\modules\users\models\Agency;
use backend\modules\users\models\Assignacc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use backend\components\ComponentBase;

$components = new ComponentBase();
$base_url = $components->Base_url();
/**
 * UserController implements the CRUD actions for User model.
 */
$encFile =Yii::getAlias('@common'). '\sendmail\functions.php';
$encFile1 =Yii::getAlias('@common'). '\sendmail\class.phpmailer.php';
$encFile2 =Yii::getAlias('@common'). '\sendmail\class.smtp.php';
require_once($encFile);
require_once($encFile1);
require_once($encFile2);

class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {   
        if( Yii::$app->user->can('VIEW_USER_ALL')){
            $searchModel = new UserSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( Yii::$app->user->can('ADD_USER')){
            $model = new User();
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($model->load(Yii::$app->request->post()) && $model->signup()) {
                $id = User::find()->select('id')->where(['username' => $model->username])->one();
                $model->add_new_auth_assignment($id->id, $model->nhom_quyen_id);
                // if ($model->type == '3' || $model->type == '4') {
                //     $model->add_new_account_assignment($id->id, $model->dai_ly_id, $model->type);
                // }
                return $this->redirect(['view', 'id' => $id->id]);
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        if( Yii::$app->user->can('EDIT_USER_ALL')){
            $model = $this->findModel($id);
            $login_type_old = $model->type_login;
            if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($model);
                }
            if ($model->load(Yii::$app->request->post())) {
                if ($login_type_old == '1') {
                    $model->type_login = 1;
                    $model->password_hash = 'null';
                }else{
                    if ($model->password_hash == '') {
                        $model->password_hash = 'null';
                    }
                }
                $model->update_user($model->id, $model->userdisplay, $model->type_login, $model->password_hash, $model->serialcert);
                if ($model->dai_ly_id) {
                    $model->update_account_assign($model->id, $model->dai_ly_id); 
                }
                return $this->redirect(['view', 'id' => $model->id]);
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $id = $_REQUEST['id'];
        $model = new User();
        $model->delete_user($id);
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionList_daily_ctv(){
        $model = new User();
        $empty = array();
        if (isset($_POST['value'])) {
            $id = $_POST['value'];
            if ($id == '3') {
                $type = '1';
                $dai_ly_ctv = Agency::find()->where(['account_type' => $type])->orderBy(['account_name'=>SORT_ASC])->all();
                if ($dai_ly_ctv) {
                    foreach ($dai_ly_ctv as $model) {
                        $list_daily_ctv[$model->id] = $model->account_name;
                    }
                    echo json_encode($list_daily_ctv);
                }
                else{
                    echo json_encode($empty) ;
                }
            }else{
                $type = '2';
                //lấy danh sách cộng tác viên đã được gán quyền trong bảng account_assign
                $list_ctv_assign = $model->get_list_ctv_assign();
                $dai_ly_ctv = Agency::find()->where(['account_type' => $type]) ->andWhere(['not in', 'id', $list_ctv_assign])->orderBy(['account_name'=>SORT_ASC])->all();
                if ($dai_ly_ctv) {
                    foreach ($dai_ly_ctv as $model) {
                        $list_daily_ctv[$model->id] = $model->account_name;
                    }
                    echo json_encode($list_daily_ctv);
                }
                else{
                    echo json_encode($empty) ;
                }
            }
        }
        else{
            echo json_encode($empty);
        }
    }
    public function actionList_daily_ctv_edit(){
        $model = new User();
        $empty = array();
        $list_daily_ctv = array();
        if (isset($_GET['value'])) {
            $id = $_GET['value'];
            $id_user = $_GET['id'];
            if ($id == '3') {
                $type = '1';
                $assignacc =  Assignacc::find()->where(['user_id' => $id_user])->all();
                if ($assignacc) {
                    $id_daily_curent = Agency::find()->where(['id' => $assignacc[0]->account_id])->all();
                    $dai_ly_ctv = Agency::find()->where(['account_type' => $type])->andWhere(['not in', 'id', $id_daily_curent[0]->id])->orderBy(['account_name'=>SORT_ASC])->all();
                    if ($dai_ly_ctv) {
                        foreach ($id_daily_curent as $value) {
                            $list_daily_ctv[$value->id] = $value->account_name;
                        }
                        foreach ($dai_ly_ctv as $model) {
                            $list_daily_ctv[$model->id] = $model->account_name;
                        }
                        
                        echo json_encode($list_daily_ctv);
                    }
                    else{
                        foreach ($id_daily_curent as $value) {
                            $list_daily_ctv[$value->id] = $value->account_name;
                        }
                        echo json_encode($list_daily_ctv) ;
                    }
                }else{
                    $dai_ly_ctv = Agency::find()->where(['account_type' => $type])->orderBy(['account_name'=>SORT_ASC])->all();
                    if ($dai_ly_ctv) {
                        foreach ($dai_ly_ctv as $model) {
                            $list_daily_ctv[$model->id] = $model->account_name;
                        }
                        echo json_encode($list_daily_ctv);
                    }
                    else{
                        echo json_encode($empty) ;
                    }
                }
               
                
            }else{
                $assignacc =  Assignacc::find()->where(['user_id' => $id_user])->all();
                $type = '2';
                if ($assignacc) {
                    $id_daily_curent = Agency::find()->where(['id' => $assignacc[0]->account_id])->all();
                    //lấy danh sách cộng tác viên đã được gán quyền trong bảng account_assign
                    $list_ctv_assign = $model->get_list_ctv_assign();
                    
                    $dai_ly_ctv = Agency::find()->where(['account_type' => $type]) ->andWhere(['not in', 'id', $list_ctv_assign])->orderBy(['account_name'=>SORT_ASC])->all();
                    if ($dai_ly_ctv) {
                        foreach ($dai_ly_ctv as $model) {
                            $list_daily_ctv[$model->id] = $model->account_name;
                        }
                        foreach ($id_daily_curent as $value) {
                            $list_daily_ctv[$value->id] = $value->account_name;
                        }
                        echo json_encode($list_daily_ctv);
                    }
                    else{
                        foreach ($id_daily_curent as $value) {
                            $list_daily_ctv[$value->id] = $value->account_name;
                        }
                        echo json_encode($list_daily_ctv) ;
                    }
                }else{
                    $list_ctv_assign = $model->get_list_ctv_assign();
                    $dai_ly_ctv = Agency::find()->where(['account_type' => $type]) ->andWhere(['not in', 'id', $list_ctv_assign])->orderBy(['account_name'=>SORT_ASC])->all();
                    if ($dai_ly_ctv) {
                        foreach ($dai_ly_ctv as $model) {
                            $list_daily_ctv[$model->id] = $model->account_name;
                        }
                        echo json_encode($list_daily_ctv);
                    }
                    else{
                        echo json_encode($empty) ;
                    }
                }
            }
        }
        else{
            echo json_encode($empty);
        }
    }

    public function actionUpdate_info_user()
    {
        if (isset($_POST)) {
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];

                if (isset($_POST['fullname'])) {
                    $fullname = pg_escape_string($_POST['fullname']);
                }
                if (isset($_POST['user_email'])) {
                    $user_email = pg_escape_string($_POST['user_email']);
                }
                if (isset($_POST['user_sex'])) {
                    $user_sex = $_POST['user_sex'];
                }
                if (isset($_POST['user_birthday'])) {
                    $user_birthday = $_POST['user_birthday'];
                    if ($user_birthday) {
                        $user_birthday = substr($user_birthday, 6,4).substr($user_birthday, 3,2).substr($user_birthday, 0,2);
                    }else{
                         $user_birthday = 0;
                    }
                }
                if (isset($_POST['user_phone'])) {
                    $user_phone = $_POST['user_phone'];
                }
                if (isset($_POST['user_provision_place'])) {
                    $user_provision_place = pg_escape_string($_POST['user_provision_place']);
                }
                if (isset($_POST['user_provision'])) {
                    $user_provision = $_POST['user_provision'];
                }
                if (isset($_POST['user_provision_day'])) {
                    $user_provision_day = $_POST['user_provision_day'];
                    if ($user_provision_day) {
                        $user_provision_day = substr($user_provision_day, 6,4).substr($user_provision_day, 3,2).substr($user_provision_day, 0,2);
                    }else{
                        $user_provision_day = 0;
                    }
                   
                }
                if (isset($_POST['user_address'])) {
                    $user_address = pg_escape_string($_POST['user_address']);
                }
                if (isset($_POST['user_town'])) {
                    $user_town = pg_escape_string($_POST['user_town']);
                }

                $exists = Userinfo::find()
                    ->where([ 'user_id' => $user_id ])
                    ->exists();
                if (!$exists) {
                    $sql = "INSERT INTO user_info (fullname, email, sex, birthday, phone, cmnd, provision_day, provision_place, address, homeland, user_id) VALUES ('".$fullname."','".$user_email."', ".$user_sex.",".$user_birthday.",'".$user_phone."','".$user_provision."',".$user_provision_day.",'".$user_provision_place."','".$user_address."','".$user_town."', ".$user_id.")";
                    Yii::$app->db->createCommand($sql)->execute();
                }else{
                    $sql = "UPDATE user_info SET fullname = '".$fullname."', email = '".$user_email."', sex = ".$user_sex.", birthday = ".$user_birthday.", phone = '".$user_phone."', cmnd = '".$user_provision."', provision_day = ".$user_provision_day.", provision_place = '".$user_provision_place."', address = '".$user_address."', homeland = '".$user_town."' WHERE user_id = ".$user_id."";
                    Yii::$app->db->createCommand($sql)->execute();
                }
                return $user_id;
            }
        }
    }

    public function actionGet_info_user_byid(){
        if (isset($_POST)) {
            if (isset($_POST['id'])) {
                $model = new User;
                $id = $_POST['id'];
                $user = $model->get_user_info_by_id($id);
                return json_encode($user);
            }
        }
    }

    public function actionDelete_accout_assign(){
        if (isset($_POST)) {
            if (isset($_POST['id_delete'])) {
                $model = new User;
                $id_delete = $_POST['id_delete'];
                $user_id = $_POST['user_id'];
                $model->delete_assign_account($id_delete, $user_id);
                $list_agency_by_user = $model->get_list_agency_by_user($user_id);
                if ($list_agency_by_user) {
                    $arr_agency = array();
                    foreach ($list_agency_by_user as $key => $value) {
                        $temp = array();
                        $temp = array_filter($temp);
                        array_push($temp, $key+1);
                        array_push($temp, $value['account_code']);
                        array_push($temp, $value['account_name']);
                        array_push($temp, $value['contract']);
                        array_push($temp, $value['prepaid']);
                        array_push($temp, $value['postpaid']);
                        array_push($temp, $value['id']);
                        array_push($arr_agency, $temp);
                    }
                    $list_agency =  json_encode($arr_agency, 128);
                    return json_encode($list_agency);
                }
            }
        }
    }

    /**
     * Reset password current an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionReset_password($id)
    {
        $model = new User();
        $user = Userinfo::find()
                    ->where([ 'user_id' => $id ])
                    ->all();
        $user_now = User::find()
                    ->where([ 'id' => $id ])
                    ->all();
        $num = 8;
        $new_password = $this->generateRandomString($num);

        $subject = 'New password';
        $body = "<p>Mật khẩu mới đăng nhập hệ thống của tài khoản ".$user_now[0]['username']." là: ";
        $body .= "<strong>".$new_password."</strong></p>";
        $body .= "<p><a href='#'>Trở lại website</a></p>";

        if ($user[0]['email']) {
            $model->changepass($id, $new_password);
            $nTo = $user[0]['fullname'];
            $mTo = $user[0]['email'];
            sendMail($subject,$body,$nTo,$mTo,$diachicc = '');
        }
        return $this->redirect(['index']);
    }
    public function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function actionAssign_role_user(){
        if (isset($_POST)) {
            if (isset($_POST['user_id'])) {
                $model = new User;
                $role_name = $_POST['role_name'];
                $user_id = $_POST['user_id'];

                $model->delete_assign_user_role($user_id);

                $model->add_new_auth_assignment($user_id,$role_name);
                $user_info = new Userinfo();
                $list_permission = $user_info->get_list_permission($role_name);
                $output = array();
                foreach ($list_permission as $key => $value) {
                    $temp = array();
                    $temp = array_filter($temp);
                    array_push($temp, $key+1);
                    array_push($temp, $value['name']);
                    array_push($temp, $value['description']);
                    array_push($output, $temp);
                }
                $list_per_json =  json_encode($output, 128);
                return $list_per_json;
            }
        }
    }
}
