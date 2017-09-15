<?php

namespace backend\modules\systems\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $rule_name
 * @property string $description
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class AuthItem extends \yii\db\ActiveRecord
{
    public $list_permission;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Tên nhóm quyền không được trống'],
            [['list_permission'], 'required', 'message' => 'Lựa chọn quyền không được trống'],
            [['type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'rule_name'], 'string', 'max' => 255],
            [['description', 'data'], 'string', 'max' => 2000],
            [['name'], 'unique','message'=>'Tên quền nhập đã tồn tại'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9|\-]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
            [['description'], 'match', 'pattern' => '/^[a-zA-Z0-9|\s|\!|\@|\,|\.|\:|\;|\"|\?|\'|\/|\(|\)|\=|\+|\_|\*|\-|\Đ|\Á|\Â|\Ê|\Ơ|\Ă|\Ô|ÀÁÂÃÈÉÊẾÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêếìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳýỵỷỹ]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
        ];

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Tên nhóm quyền',
            'type' => 'Type',
            'rule_name' => 'Rule Name',
            'description' => 'Mô tả',
            'data' => 'Data',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'list_permission' => 'Danh sách quyền',
        ];
    }

     public function add_child_item($name,$arr){
        $sql_delete ="DELETE FROM auth_item_child
            WHERE parent = '".$name."'";
        Yii::$app->db->createCommand($sql_delete)->execute();
        foreach ($arr as $key => $value) {
            $sql = "INSERT INTO auth_item_child (parent,child) VALUES ('".$name."','".$value."')";
            Yii::$app->db->createCommand($sql)->execute();
        }
        return true;
    }
    public function add_child_item_new($old_name,$name,$arr){
        $sql_delete ="DELETE FROM auth_item_child 
            WHERE parent = '".$old_name."'";
        Yii::$app->db->createCommand($sql_delete)->execute();
        foreach ($arr as $key => $value) {
            $sql = "INSERT INTO auth_item_child (parent,child) VALUES ('".$name."','".$value."')";
            Yii::$app->db->createCommand($sql)->execute();
        }
        return true;
    }
    public function get_list_permission($name){
        $sql = "SELECT * FROM auth_item_child  WHERE parent = '".$name."'";
        $rows = Yii::$app->db->createCommand($sql)->queryAll();

        $arr = array();
        foreach ($rows as $key => $value) {
            array_push($arr, $value['child']);
        }

        $query1 = new Query;
        $query1->select('description')
            ->from('auth_item')
            ->where(['IN', 'name', $arr])
            ->Orderby('description');

        $list = $query1->all();
        return $list;
    }

     public function get_list_permission_name($name){
        $query = new Query;
        $query->select('child')
            ->from('auth_item_child')
            ->where(['parent' => $name]);
        $rows = $query->all();
        return $rows;
    }
    public function delete_permisstion_in_authchild($name)
    {
        $sql_delete_child ="DELETE FROM auth_item_child 
            WHERE parent = '".$name."'";
        Yii::$app->db->createCommand($sql_delete_child)->execute();
        $sql_delete_assign ="DELETE FROM auth_assignment 
            WHERE item_name = '".$name."'";
        Yii::$app->db->createCommand($sql_delete_assign)->execute();
        return true;
    }
}
