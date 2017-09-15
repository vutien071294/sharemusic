<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\categorys\models\Province;
use kartik\date\DatePicker;
$begin_time = $model->begin_time ? date('d-m-Y',$model->begin_time) : '';
$end_time = $model->end_time ? date('d-m-Y',$model->end_time) : '';
/* @var $this yii\web\View */
/* @var $model backend\modules\categorys\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="district-form">
  
  
   <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
      <div class="col-xs-12 padding-right-0  padding-left-0">
          <?= $form->field($model, 'code',['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => 255])->label('Mã quận huyện<span class="required_data"> *</span>') ?>

          <?= $form->field($model, 'name',['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => 255])->label('Tên quận huyện<span class="required_data"> *</span>') ?>
      </div>

      <div class="col-xs-12 padding-right-0  padding-left-0">
          <?= $form->field($model,'province_code',['options' => ['class' => 'col-xs-6']])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Province::find()->orderBy(['name'=>SORT_ASC])->where(['is_valid'=> 1])->all(), 'code', 'name'),
                'language' => 'vi',
                'options' => ['placeholder' => '--- Tỉnh thành ---'],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ])->label('Tỉnh thành<span class="required_data"> *</span>');
          ?>

          <?= $form->field($model, 'is_valid',['options' => ['class' => 'col-xs-6']])->dropDownList(['1' => 'Hiệu lực', '2' => 'Hết hiệu lực'])->label('Trạng thái') ?>
      </div>

      <div class="col-xs-12 padding-right-0  padding-left-0">
          <?= $form->field($model,'begin_time',['options' => ['class' => 'col-xs-6']])->widget(DatePicker::classname(), [
                   'type' => DatePicker::TYPE_COMPONENT_APPEND,
                   'options' => [
                   'value' => $begin_time,
                   'placeholder' => '--- Lựa chọn ngày ---'],
                   'language' => 'vi',
                   'pluginOptions' => [
                   'autoclose'=>true,
                   'format' => 'dd-mm-yyyy',
                   'class' =>'form-control',
                   'todayHighlight' => true
                   ]])->label('Ngày bắt đầu')
                ?>
          <?= $form->field($model,'end_time',['options' => ['class' => 'col-xs-6']])->widget(DatePicker::classname(), [
                   'type' => DatePicker::TYPE_COMPONENT_APPEND,
                   'options' => [
                   'value' => $end_time,
                   'placeholder' => '--- Lựa chọn ngày ---'],
                   'language' => 'vi',
                   'pluginOptions' => [
                   'autoclose'=>true,
                   'format' => 'dd-mm-yyyy',
                   'class' =>'form-control',
                   'todayHighlight' => true
                   ]])->label('Ngày kết thúc')
                ?>
      </div>

      <div class="col-xs-12 padding-right-0  padding-left-0">
          <?= $form->field($model, 'description',['options' => ['class' => 'col-xs-12']])->textArea(['maxlength' => 255, 'row'=> 5])->label('Mô tả') ?>
      </div>

      <div class="col-xs-12">
          <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
          </div>
      </div>
  <?php ActiveForm::end(); ?>

</div>
