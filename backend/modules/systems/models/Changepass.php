<?php
namespace frontend\modules\systems\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
// use frontend\modules\systems\models\Users;
use common\models\User;

/**
 * Signup form
 */
class Changepass extends Model
{
    public $PASSWORD;
    public $NEW_PASSWORD;
    public $RENEW_PASSWORD;

    private $_user;

    public function rules()
    {
        return [
            [['PASSWORD', 'NEW_PASSWORD','RENEW_PASSWORD'], 'required', 'message' => '{attribute} không được trống !'],
            // ['PASSWORD', 'exist', 'targetClass' => '\common\models\Users','message' => 'Mật khẩu cũ không đúng !'] ,
            ['PASSWORD', 'validateCurrenpassword'] ,
            [['PASSWORD', 'NEW_PASSWORD','RENEW_PASSWORD'], 'string', 'min' => 6,'max' => 32, 'tooShort' => '{attribute} phải có ít nhất 6 ký tự', 'tooLong' => 'Không quá 32 ký tự'],
            ['RENEW_PASSWORD','compare','compareAttribute'=>'NEW_PASSWORD','message'=>"Xác nhận mật khẩu không đúng !"],
            [['PASSWORD','RENEW_PASSWORD','NEW_PASSWORD'], 'match', 'pattern' => '/^[a-zA-Z0-9|\!|\@|\,|\.|\:|\;|\"|\?|\'|\/|\(|\)|\=|\+|\_|\*|\-]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
        ];

    }

    public function validateCurrenpassword(){
        $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->PASSWORD)) {
                $this->addError('PASSWORD', 'Mật khẩu cũ không đúng !');
            }
    }
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }
        return $this->_user;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'PASSWORD' => 'Mật khẩu cũ',
            'NEW_PASSWORD' => 'Mật khẩu mới',
            'RENEW_PASSWORD' => 'Xác nhận mật khẩu mới',
        ];
    }
    public function changepass($id)
    {
        if (!$this->validate())  {
            return null;
        }
        $update_time = date('Y-m-d');
        $update_time = strtotime($update_time);
        $password = Yii::$app->security->generatePasswordHash($this->RENEW_PASSWORD);
        $sql = "UPDATE user SET password_hash = '".$password."',updated_at = '".$update_time."' WHERE (id = '".$id."')";
        Yii::$app->db->createCommand($sql)->execute();
        return true;
    }
}
