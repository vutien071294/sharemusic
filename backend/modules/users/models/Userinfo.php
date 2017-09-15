<?php

namespace backend\modules\users\models;

use Yii;
use yii\db\Query;
/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $email
 * @property integer $sex
 * @property integer $birthday
 * @property string $phone
 * @property string $cmnd
 * @property integer $provision_day
 * @property string $provision_place
 * @property string $homeland
 * @property string $address
 * @property integer $user_id
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname', 'email'], 'required','message' => ' {attribute} không được trống'],
            ['email', 'unique', 'message' => 'email đã tồn tại.'],
            [['sex', 'birthday', 'provision_day', 'user_id'], 'safe'],
            [['sex', 'birthday', 'provision_day', 'user_id'], 'safe'],
            [['fullname', 'homeland', 'address'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 50],
            [['phone','cmnd'], 'integer', 'max' => 1000000000000000, 'tooBig' => ' {attribute} không quá 15 ký tự', 'message' => '{attribute} phải là số'],
            [['provision_place'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fullname' => 'Họ tên',
            'email' => 'Email',
            'sex' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'phone' => 'Số điện thoại',
            'cmnd' => 'Số chứng minh nhân dân',
            'provision_day' => 'Ngày cấp',
            'provision_place' => 'Nơi cấp',
            'homeland' => 'Quê quán',
            'address' => 'Địa chỉ',
            'user_id' => 'User ID',
        ];
    }
    public function get_list_permission($role)
    {
        $sql = "select * ,ai.description
            FROM auth_item_child ac
            join auth_item ai ON ac.child = ai.name
            WHERE ac.parent = '".$role."'";
        $row = Yii::$app->db->createCommand($sql)->queryAll();  
        return $row;
    }

    public function get_user_by_id($id)
    {
        $query = new Query;
        $query->select('*')
            ->from('user')
            ->leftJoin('user_info', 'user.id = user_info.user_id')
            ->where(['user_info.user_id' => $id]);
        $rows = $query->all();
        return $rows;
    }
}
