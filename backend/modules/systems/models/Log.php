<?php

namespace backend\modules\systems\models;

use Yii;
use backend\modules\users\models\UserSearch;
/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $action
 * @property string $resource
 * @property string $decription
 * @property integer $user_id
 * @property integer $create_time
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['action'], 'required'],
            [['user_id', 'create_time'], 'integer'],
            [['action', 'resource'], 'string', 'max' => 255],
            [['decription'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'action' => 'Hành động',
            'resource' => 'Tài nguyên',
            'decription' => 'Mô tả',
            'user_id' => 'Người dùng',
            'create_time' => 'Thời gian',
        ];
    }

     public function getUser()
        {
            return $this->hasOne(UserSearch::className(), ['id' => 'user_id']);
        }
}
