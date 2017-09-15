<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "account_assign".
 *
 * @property integer $id
 * @property integer $account_id
 * @property integer $user_id
 * @property string $role
 * @property string $note
 */
class Assignacc extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_assign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'user_id', 'role'], 'required'],
            [['account_id', 'user_id'], 'integer'],
            [['role'], 'string', 'max' => 255],
            [['note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'user_id' => 'User ID',
            'role' => 'Role',
            'note' => 'Note',
        ];
    }
}
