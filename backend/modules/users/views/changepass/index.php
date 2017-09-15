<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Thay đổi mật khẩu của bạn';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-signup">
   <fieldset class="col-lg-6" style="border: 1px solid #0093DD; border-radius: 10px; margin-left: 25%; margin-top: 20px;">
        <legend style="text-align: center; color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h2>Cập nhật mật khẩu</h2></legend>
    
        <div class="mapping-content-updateform">

    <div class="row">
        <div>
            <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

                <?= $form->field($model, 'PASSWORD')->passwordInput(['maxlength'=>30])->label('Mật khẩu cũ (*)') ?>

                <?= $form->field($model, 'NEW_PASSWORD')->passwordInput(['maxlength'=>30])->label('Mật khẩu mới (*)') ?>

                <?= $form->field($model, 'RENEW_PASSWORD')->passwordInput(['maxlength'=>30])->label('Xác nhận mật khẩu mới (*)') ?>

                <hr class="hr_inform">
                <div class="pull-right"">
                    <p>
                        <?= Html::submitButton('Thay đổi',['index','class' => 'btn btn-primary']) ?>
                    </p>
                </div>
            <?php ActiveForm::end(); ?>
    </div>
    </div>
    </fieldset>

</div>
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
