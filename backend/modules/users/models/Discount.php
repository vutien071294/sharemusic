<?php

namespace backend\modules\users\models;

use Yii;

/**
 * This is the model class for table "account_discount".
 *
 * @property integer $id
 * @property string $account_code
 * @property integer $service_count
 * @property integer $discount_new
 * @property integer $discount_renew
 * @property integer $discount_tranf
 * @property integer $discount_file_customer
 * @property integer $discount_service_count
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_count', 'discount_new', 'discount_renew', 'discount_tranf', 'discount_file_customer', 'discount_service_count'], 'required', 'message' => '{attribute} không được trống'],
            ['account_id', 'integer'],
            [['service_count','discount_file_customer','discount_service_count'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => '{attribute} phải là một số'],
            [['discount_new','discount_renew','discount_tranf'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => '{attribute} phải là một số'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account Code',
            'service_count' => 'Số lượng cam kết',
            'discount_new' => 'Chiết khấu cấp mới',
            'discount_renew' => 'Chiết khấu gia hạn',
            'discount_tranf' => 'Chiết khấu chuyển đổi',
            'discount_file_customer' => 'Phạt số lượng cam kết',
            'discount_service_count' => 'Phạt hồ sơ',
        ];
    }

}
