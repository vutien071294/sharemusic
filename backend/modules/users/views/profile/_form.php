<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\components\ComponentBase;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\members\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
if ($model->birthday) {
    $birthday = substr($model->birthday, 6,2).'-'.substr($model->birthday, 4,2).'-'.substr($model->birthday, 0,4);
}else{
    $birthday ='';
}
if ($model->provision_day) {
    $provision_day = substr($model->provision_day, 6,2).'-'.substr($model->provision_day, 4,2).'-'.substr($model->provision_day, 0,4);
}else{
    $provision_day ='';
}
 
?>
<div class="users-form">

    <?php $form = ActiveForm::begin(['id' => 'user_form','enableAjaxValidation' => true,'options'=>['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 30])->label('Họ tên (*)') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 30])->label('Email (*)') ?>

    <?= '<label class="control-label">Ngày sinh</label>'; ?> 
    <?php
    echo DatePicker::widget([
        'name' => 'Userinfo[birthday]', 
        'value' => $birthday,
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'options' => ['placeholder' => 'Lựa chọn ngày sinh'],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true,
            'class' =>'form-control'
            ]
        ]);
    ?> 
    <?= ' <div class="help-block"></div>' ?> 

    <?= $form->field($model, 'sex')->radioList([
        '1' => 'Nam',
        '2' => 'Nữ',
        '3' => 'Khác',
    ]); ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'cmnd')->textInput(['maxlength' => 15]) ?>
    
    <?= '<label class="control-label">Ngày cấp</label>'; ?> 
     <?php
    echo DatePicker::widget([
        'name' => 'Userinfo[provision_day]', 
        'value' => $provision_day,
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'options' => ['placeholder' => 'Lựa chọn ngày sinh'],
        'pluginOptions' => [
            'format' => 'dd-mm-yyyy',
            'todayHighlight' => true,
            'class' =>'form-control'
            ]
        ]);
    ?> 
    <?= ' <div class="help-block"></div>' ?> 

    <?= $form->field($model, 'provision_place')->textInput(['maxlength' => true])->label('Nơi cấp') ?>

    <?= $form->field($model, 'homeland')->textInput(['maxlength' => true])->label('Quê quán') ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label('Địa chỉ') ?>




    <hr class="hr_inform">

    <div class="form-group pull-right">
        <?= Html::submitButton('Cập nhật', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        <?= Html::a('Trở lại', ['index'],  ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    <style >
      .form-control{
        font-size: 13px;
        font-family: Helvetica, Arial, Tahoma, sans-serif;
    }
    body{
        font-size: 13px;
        font-family: Helvetica, Arial, Tahoma, sans-serif;
    }

</style>
</style>
