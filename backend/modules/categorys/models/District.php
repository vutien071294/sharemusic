<?php

namespace backend\modules\categorys\models;

use Yii;
use yii\db\Query;
use backend\modules\categorys\models\ProvinceSearch;
/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $province_id
 * @property string $description
 * @property string $begin_time
 * @property string $end_time
 * @property integer $is_valid
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $create_time
 * @property integer $update_time
 */
class District extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $file;
    public $search_text;
    public static function tableName()
    {
        return 'district';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required','message' => 'Mã huyện không được trống'],
            [['name'], 'required','message' => 'Tên huyện không được trống'],
            [['province_code'], 'required','message' => 'Tỉnh thànhkhông được trống'],
            [['code'], 'string', 'max' => 255,'tooLong'=> 'Mã huyện không quá 255 ký tự'],
            [['name'], 'string', 'max' => 255 , 'tooLong'=> 'Tên huyện không quá 255 ký tự'],
            [['description'], 'string', 'max' => 255 , 'tooLong'=> 'Mô tả không quá 255 ký tự'],
            [['code'], 'match', 'pattern' => '/^[a-zA-Z0-9|\.|\_|\-]+$/', 'message' => 'Dữ liệu nhập vào không hợp lệ !'],
            ['code', 'unique', 'message' => 'Mã tỉnh thành đã tồn tại.'],
            ['name', 'unique', 'message' => 'Tên tỉnh thành đã tồn tại.'],
            [['is_valid', 'create_user_id', 'update_user_id', 'create_time', 'update_time'], 'integer'],
            [['begin_time', 'end_time'], 'safe'],
             [['begin_time','end_time'], 'validateDate'],
            [['file'],'file','extensions'=>'csv, xls, xlsx','wrongExtension'=>' File tải lên không đúng định dạng : {extensions}'],
            [['file'],'file','maxSize'=>1024 * 1024 * 5, 'tooBig' => 'Size tối đa của file là 5M'],
            [['code', 'name', 'description', 'province_code'], 'trim'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'province_code' => 'Tên tỉnh thành',
            'id' => 'ID',
            'code' => 'Mã quận huyện ',
            'name' => 'Tên quận huyện',
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

    public function getProvince()
    {
        return $this->hasOne(ProvinceSearch::className(), ['code' => 'province_code']);
    }

    public function get_name_province($code)
    {
        $query = new Query;
        $query->select('name')
            ->from('province')
            ->where(['code' => $code])
            ->limit(1);
        $rows = $query->all();
        if ($rows) {
            return $rows[0]['name'];
        } else {
            return '';
        }
    }

    public function convertDate($date){
        $date_convert = str_replace('/', '-', $date);
        $date_convert = date('Y-m-d',strtotime($date_convert));
        return $date_convert;
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
}
