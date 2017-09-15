<?php

namespace backend\modules\categorys\models;

use Yii;

/**
 * This is the model class for table "province".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $country
 * @property string $description
 * @property string $begin_time
 * @property string $end_time
 * @property integer $is_valid
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $search_text;
    public static function tableName()
    {
        return 'province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_valid'], 'integer'],
            [['country'], 'string', 'max' => 255, 'tooLong' => 'Quốc gia không quá 255 ký tự'],

            [['code'], 'required','message' => 'Mã tỉnh thành không được trống'],
            [['name'], 'required','message' => 'Tên tỉnh thành không được trống'],
            [['code'], 'string', 'max' => 255,'tooLong'=> 'Mã tỉnh thành không quá 255 ký tự'],
            [['name'], 'string', 'max' => 255 , 'tooLong'=> 'Tên tỉnh thành không quá 255 ký tự'],
            [['description'], 'string', 'max' => 255 , 'tooLong'=> 'Mô tả không quá 255 ký tự'],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z0-9|\.|\_|\-]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
            ['code', 'unique', 'message' => 'Mã tỉnh thành đã tồn tại.'],
            ['name', 'unique', 'message' => 'Tên tỉnh thành đã tồn tại.'],
            [['file'],'file','extensions'=>'csv, xls, xlsx','wrongExtension'=>' File tải lên không đúng định dạng : {extensions}'],
            [['file'],'file','maxSize'=>1024 * 1024 * 5, 'tooBig' => 'Size tối đa của file là 5M'],
            [['begin_time', 'end_time'], 'safe'],
            [['begin_time','end_time'], 'validateDate'],
            [['code', 'name', 'country', 'description'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Mã tỉnh thành',
            'name' => 'Tên tỉnh thành',
            'country' => 'Quốc gia',
            'description' => 'Mô tả',
            'begin_time' => 'Ngày bắt đầu hiệu lực',
            'end_time' => 'Ngày kết thúc hiệu lực',
            'is_valid' => 'Trạng thái',
            'create_time' => 'Ngày tạo',
            'create_user_id' => 'Người tạo',
            'update_time' => 'Ngày cập nhật',
            'update_user_id' => 'Người cập nhật',
        ];
    }

    public  function validateDate(){
        if ($this->end_time) {
            if ($this->begin_time) {
               if (strtotime($this->begin_time) > strtotime($this->end_time)) {
                    $this->addError('end_time','TG kết thúc  phải lớn hơn TG bắt đầu');
                }
                
             }
         }
        if ($this->begin_time) {
            if ($this->end_time) {
                     if (strtotime($this->begin_time) > strtotime($this->end_time)) {
                     $this->addError('begin_time','TG bắt đầu  phải nhỏ hơn TG kết thúc');
                 }
            }
            
        }

    }

    public function convertDate($date){
        $date_convert = str_replace('/', '-', $date);
        $date_convert = date('Y-m-d',strtotime($date_convert));
        
        return $date_convert;
    }

}
