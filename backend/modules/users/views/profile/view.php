<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\members\models\Groups;
use backend\components\ComponentBase;

/* @var $this yii\web\View */
/* @var $model backend\modules\members\models\User */

$components = new ComponentBase();
$base_url = $components->Base_url();

$this->title = 'Profile';

if ($model[0]['sex'] == '1') {
    $gender = 'Nam';
}elseif ($model[0]['sex'] == '2') {
    $gender = 'Nữ';
}elseif($model[0]['sex'] == '3'){
    $gender = 'Khác';
} 
// birthday
if ($model[0]['birthday'] != 0) {
    $birthday_user = substr($model[0]['birthday'], 6,2).'-'.substr($model[0]['birthday'], 4,2).'-'.substr($model[0]['birthday'], 0,4);
}else{
    $birthday_user = '';
}

// provision day
if ($model[0]['provision_day'] != 0) {
    $provision_day = substr($model[0]['provision_day'], 6,2).'-'.substr($model[0]['provision_day'], 4,2).'-'.substr($model[0]['provision_day'], 0,4);
}else{
    $provision_day = '';
}

$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view col-md-9" style="margin-left: 10%; margin-top:10px; padding: 20px;">
    <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
        <legend style="text-align: center; color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h2>Hồ sơ cá nhân</h2></legend>
    
        <div class="mapping-content-updateform">
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Họ tên',
                'value' => $model[0]['fullname'],
            ],
            [
                'label' => 'Email',
                'value' => $model[0]['email'],
            ],
            [
                'label' => 'Giới tính',
                'value' => $gender,
            ],
            [
                'label' => 'Ngày sinh',
                'value' => $birthday_user,
            ],
            [
                'label' => 'Số điện thoại',
                'value' => $model[0]['phone'],
            ],
            [
                'label' => 'Số chứng minh nhân dân',
                'value' => $model[0]['cmnd'],
            ],
            [
                'label' => 'Ngày cấp',
                'value' => $provision_day
            ],
            [
                'label' => 'Nơi cấp',
                'value' => $model[0]['provision_place'],
            ],
            [
                'label' => 'Quê quán',
                'value' => $model[0]['homeland'],
            ],
            [
                'label' => 'Địa chỉ',
                'value' => $model[0]['address'],
            ],
       ],
    ]) ?>
    <hr class="hr_inform">
    <div class="pull-right"">
        <p>
            <?= Html::a('Cập nhật', ['update', 'id' => $model[0]['id']], ['class' => 'btn btn-primary']) ?>
            
        </p>
    </div>
    </div>
    </fieldset>
</div>
<style>
     body{
    font-size: 13px;
    font-family: Helvetica, Arial, Tahoma, sans-serif;
  }
</style>