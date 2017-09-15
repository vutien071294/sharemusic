<?php

namespace backend\modules\systems\models;

use Yii;
use backend\modules\users\models\UserSearch;
use backend\modules\systems\models\AuthItemSearch;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property integer $id
 * @property string $item_name
 * @property integer $user_id
 * @property string $created_at
 */
class Authassignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name'], 'required', 'message' => 'Nhóm quyền không được trống'],
            [['user_id'], 'required', 'message' => 'Người dùng không được trống'],
            [['user_id'], 'integer'],
            [['user_id'], 'unique', 'message' => 'Người dùng đã được cấp quyền'],
            [['created_at','updated_at'], 'safe'],
            [['item_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Nhóm quyền',
            'user_id' => 'Người dùng',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
        ];
    }
     public function getUsers()
        {
            return $this->hasOne(UserSearch::className(), ['id' => 'user_id']);
        }

     public function getAuthitem()
        {
            return $this->hasOne(AuthItemSearch::className(), ['name' => 'item_name']);
        }
}
