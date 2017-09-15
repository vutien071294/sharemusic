<?php

namespace backend\modules\users\models;

use Yii;
use yii\db\Query;
use backend\modules\users\models\User;
use yii\data\SqlDataProvider;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $type_login
 * @property string $serialcert
 * @property string $userdisplay
 * @property string $image
 * @property integer $last_login_time
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $type
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $dai_ly_id;
    public $nhom_quyen_id;
    public $re_password;
    public $search_text;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'userdisplay', 'nhom_quyen_id'],'required','message'=>'{attribute} không được trống'],
            ['username', 'unique', 'message' => 'Tên đăng nhập đã tồn tại.'],
            ['serialcert', 'unique', 'message' => 'Serial chứng thư đã tồn tại.'],
            [['password_hash', 're_password', 'username', 'userdisplay'], 'string','max' => 30, 'tooLong'=> '{attribute} không quá 30 ký tự'],
            ['re_password', 'compare', 'compareAttribute'=>'password_hash', 'message'=>"Mật khẩu nhập lại không đúng" ],
            [['status', 'created_at', 'updated_at', 'create_user_id', 'update_user_id', 'last_login_time', 'create_time', 'update_time', 'type'], 'integer'],
            [['userdisplay','dai_ly_id', 'serialcert'], 'string'],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9|\.|\_|\@|\-]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
            [['serialcert'], 'match', 'pattern' => '/^[a-zA-Z0-9|]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
            [['serialcert'], 'string','max' => 50, 'min'=>6, 'tooShort'=>'{attribute} tối thiểu phải có 6 ký tự', 'tooLong'=> '{attribute} không quá 30 ký tự'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Tên đăng nhập',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Mật khẩu',
            're_password' => 'Nhập lại mật khẩu',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Tình trạng',
            'created_at' => 'Thời gian tạo',
            'updated_at' => 'Thời gian cập nhật',
            'create_user_id' => 'Người tạo',
            'update_user_id' => 'Người sửa',
            'type_login' => 'Loại đăng nhập',
            'serialcert' => 'Serial chứng thư ',
            'userdisplay' => 'Tên hiển thị',
            'image' => 'Image',
            'last_login_time' => 'Lần đăng nhập cuối',
            'create_time' => 'Thời gian tạo',
            'update_time' => 'Thời gian cập nhật',
            'type' => 'Loại tài khoản',
            'nhom_quyen_id' => 'Nhóm quyền'
        ];
    }
    public function get_user_name($id)
    {
        $query = new Query;
        $query->select('username')
        ->from('user')
        ->where(['id' => $id])
        ->limit(1);
        $rows = $query->all();
        if ($rows){
            return $rows[0]['username'];
        }else{
            return '';
        }
    }
    public function  get_list_ctv_assign()
    {
        $query = new Query;
        $query->select('account_id')
        ->from('account_assign')
        ->where(['role' => '2_COLLABORATOR_SUPPLIER']);
        $rows = $query->all();
        if ($rows) {
            $data = array();
            foreach ($rows as $key => $value) {
                array_push($data, $value['account_id']);
            }
            return $data;
        }
        return $rows;
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->type = $this->type;
        $user->userdisplay = $this->userdisplay;
        $user->username = $this->username;
        $user->type_login = $this->type_login;
        $user->type = $this->type;
        $user->serialcert  = $this->serialcert;
        $user->created_at  = time() ;
        $user->status  = 1;
        $user->create_user_id  =  Yii::$app->user->id;
        if ($this->password_hash) {

            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        }
        $user->auth_key = Yii::$app->security->generateRandomString();
        
        return $user->save(false) ? $user : null;
    }
    public function add_new_auth_assignment($user_id, $item_name)
    {
        $sql = "INSERT INTO auth_assignment (user_id, item_name, created_at, updated_at) VALUES ('".$user_id."','".$item_name."', ".time().", ".time().")";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }
    public function add_new_account_assignment($user_id, $account_id, $type)
    {
        if ($type ==  '3') {
            $role = '1_CONTROLLER_SUPPLIER';
        }else{
            $role = '2_COLLABORATOR_SUPPLIER';
        }
        if ($account_id) {
            $sql = "INSERT INTO account_assign (account_id, user_id, role) VALUES (".$account_id.",".$user_id.", '".$role."')";
            Yii::$app->db->createCommand($sql)->execute();
        }
        
        return true;
    }

    public function update_user($id, $userdisplay, $type_login, $password_hash, $serialcert){
        $user_update = Yii::$app->user->id;
        $password_hash = Yii::$app->security->generatePasswordHash($password_hash);
        $sql = 'UPDATE user SET updated_at = '.time().", userdisplay = '".$userdisplay."', update_user_id = ".$user_update." WHERE (id = '".$id."')";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    public function update_account_assign($user_id, $account_id)
    {
        $sql = "UPDATE account_assign SET account_id = ".$account_id." WHERE (user_id = ".$user_id.")";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    public function get_list_daily_ctv_index($user_id){
        $sql = "select ag.account_name
            from account ag
            inner join account_assign acc on acc.account_id = ag.id
            where acc.user_id = ".$user_id;
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }
    public function get_user_info_by_id($user_id){
        $sql = "select uf.*
            from user_info uf
            where uf.user_id = ".$user_id;
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }
    
    public function get_list_agency_by_user($user_id)
    {
        $sql = 'SELECT account.account_code, account.account_name, account.contract, account.prepaid, account.postpaid, account_assign.id
        FROM user u
        JOIN account_assign ON account_assign.user_id = u.id
        JOIN account
        ON account.id = account_assign.account_id
        WHERE account_assign.user_id = '.$user_id;
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }

    public function delete_assign_account($id_delete, $user_id)
    {
        $sql_delete ="DELETE FROM account_assign 
        WHERE user_id = ".$user_id."  AND account_id = (SELECT id FROM account WHERE account_code = '".$id_delete."')";
        Yii::$app->db->createCommand($sql_delete)->execute();
        return true;
    }

    public function get_list_agency_assign($value){
        $sql = "SELECT *
        FROM account 
        WHERE account.id NOT IN (SELECT account_assign.account_id FROM account_assign WHERE user_id=".$value.")";
        $row = Yii::$app->db->createCommand($sql)->queryAll();
        return $row;
    }

    public function save_assign_agency_user($names,$user_id)
    {
        foreach ($names as $key => $value) {
            $sql = "INSERT INTO account_assign (user_id, account_id, role) VALUES (".$user_id.",".$value.", '1_SALE_SUPPLIER')";
            Yii::$app->db->createCommand($sql)->execute();
        }
        return true;
    }

    public function get_list_agency_by_id($list,$user_id)
    {
        $string = '(';
        foreach ($list as $key => $value) {
            $string .=  $value.',';
        }
        $str = rtrim($string,',');
        $str = $str.')';
        $sql = 'SELECT account.account_code, account.account_name, account.contract, account.prepaid, account.postpaid, account_assign.id
        FROM user u
        JOIN account_assign ON account_assign.user_id = u.id
        JOIN account
        ON account.id = account_assign.account_id
        WHERE account.id IN'.$str.' AND account_assign.user_id = '.$user_id;
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }
    public function get_num_record_agency_by_user($user_id)
    {
        $sql = "SELECT COUNT(*) as clients FROM account_assign WHERE user_id =".$user_id;
        $results =  Yii::$app->db->createCommand($sql)->queryAll();
        $numClients = (int)$results[0]["clients"];
        return $numClients;
    }

    // các hàm của ctv
    public function get_list_cooperator_by_user($user_id)
    {
        $sql = 'SELECT account.account_code, account.account_name, account.contract, account.prepaid, account.postpaid, account_assign.id
        FROM user u
        JOIN account_assign ON account_assign.user_id = u.id
        JOIN account
        ON account.id = account_assign.account_id
        WHERE account_assign.user_id = '.$user_id." AND account_assign.role = '1_SALE_SUPPLIER' AND account.account_type = 2";
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }

    public function get_list_cooperator_assign(){
        $sql = "SELECT *
            FROM account 
            WHERE account.id NOT IN (SELECT account_assign.account_id FROM account_assign ) and account_type = 2";
        $row = Yii::$app->db->createCommand($sql)->queryAll();
        return $row;
    }
    public function get_num_record_cooperator_by_user($user_id)
    {
        $sql = "SELECT COUNT(*) as clients FROM account_assign WHERE user_id =".$user_id." AND account_id IN (SELECT id FROM account WHERE account_type = 2) ";
        $results =  Yii::$app->db->createCommand($sql)->queryAll();
        $numClients = (int)$results[0]["clients"];
        return $numClients;
    }

    public function save_assign_cooperator_user($names,$user_id)
    {
        foreach ($names as $key => $value) {
            $sql = "INSERT INTO account_assign (user_id, account_id, role) VALUES (".$user_id.",".$value.", '1_SALE_SUPPLIER')";
            Yii::$app->db->createCommand($sql)->execute();
        }
        return true;
    }

    public function delete_user($id){
        $sql_delete_assign ="DELETE FROM account_assign 
        WHERE user_id = ".$id;
        Yii::$app->db->createCommand($sql_delete_assign)->execute();
        $sql_delete_auth ="DELETE FROM auth_assignment 
        WHERE user_id = ".$id;
        Yii::$app->db->createCommand($sql_delete_auth)->execute();
        return true;
    }

    public function changepass($id, $new_password)
    {
        $update_time = date('Y-m-d');
        $update_time = strtotime($update_time);
        $password = Yii::$app->security->generatePasswordHash($new_password);
        $sql = "UPDATE ".'"'."user".'"'." SET password_hash = '".$password."',updated_at = '".$update_time."' WHERE (id = '".$id."')";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }

    public function get_list_data_agency_new($id)
    {

        $provider = new SqlDataProvider([
            'sql' => "SELECT *
                FROM account 
                WHERE account.id NOT IN (SELECT account_assign.account_id FROM account_assign WHERE user_id=".$id.")",
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $provider;
    }

    public function get_list_data_role_new($id)
    {

        $provider = new SqlDataProvider([
            'sql' => "SELECT *
            FROM auth_item 
            WHERE auth_item.name NOT IN (SELECT auth_assignment.item_name FROM auth_assignment WHERE user_id= ".$id.") AND auth_item.type = 1",
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $provider;
    }
    public function delete_assign_user_role($user_id)
    {
        $sql_delete ="DELETE FROM auth_assignment 
        WHERE user_id = ".$user_id;
        Yii::$app->db->createCommand($sql_delete)->execute();
        return true;
    }

    public function get_role_user($id){
        $sql = 'SELECT ai.description
                FROM user u 
                LEFT JOIN auth_assignment au ON u.id = au.user_id
                LEFT JOIN auth_item ai ON au.item_name = ai.name
                WHERE u.id ='.$id;
        $rows =  Yii::$app->db->createCommand($sql)->queryAll();
        if ($rows){
            return $rows[0]['description'];
        }else{
            return '';
        }
    }

}