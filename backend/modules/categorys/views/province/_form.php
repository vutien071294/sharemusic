<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\modules\categorys\models\Province */
/* @var $form yii\widgets\ActiveForm */
$begin_time = $model->begin_time ? date('d-m-Y',$model->begin_time) : '';
$end_time = $model->end_time ? date('d-m-Y',$model->end_time) : '';
?>

<div class="province-form">


    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
      <div class="col-xs-12 padding-right-0  padding-left-0">
          <?= $form->field($model, 'code',['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => 255])->label('Mã tỉnh thành<span class="required_data"> *</span>') ?>

          <?= $form->field($model, 'name',['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => 255])->label('Tên tỉnh thành<span class="required_data"> *</span>') ?>
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
          <?= $form->field($model, 'country',['options' => ['class' => 'col-xs-6']])->textInput(['maxlength' => 255])->label('Quốc gia') ?>

          <?= $form->field($model, 'is_valid',['options' => ['class' => 'col-xs-6']])->dropDownList(['1' => 'Hiệu lực', '2' => 'Hết hiệu lực'])->label('Trạng thái') ?>
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
