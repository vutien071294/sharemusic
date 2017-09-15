<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\components\ComponentBase;
use kartik\file\FileInput;
use kartik\date\DatePicker;
use backend\modules\systems\models\AuthItem;
use backend\modules\users\models\User;
use backend\modules\users\models\Agency;
use backend\modules\users\models\Assignacc;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\User */
/* @var $form yii\widgets\ActiveForm */
$array = [
    ['id' => '1', 'name' => 'Kinh doanh - NCC'],
    ['id' => '2', 'name' => 'Người dùng - NCC'],
    ['id' => '3', 'name' => 'Đại lý'],
    ['id' => '4', 'name' => 'Cộng tác viên'],
];
$array_login = [
    ['id' => '1', 'name' => 'Mật khẩu'],
    ['id' => '2', 'name' => 'Chứng thư số'],
];
$components = new ComponentBase();
$base_url = $components->Base_url();

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'user_form','enableAjaxValidation' => true,'options'=>['enctype'=>'multipart/form-data']]); ?>
        
    <?php if ($model->isNewRecord) { ?>

    <?= $form->field($model, 'username')->textInput(['required'=>true,'class' => 'form-control my_username'])->label('Tên đăng nhập<span class="required_data"> *</span>');
    ?>
    <?php }else{ ?>

    <?= $form->field($model, 'username')->textInput(['required'=>true,'class' => 'form-control my_username','disabled' => true])->label('Tên đăng nhập<span class="required_data"> *</span>'); ?>

    <?php   } ?>

    <?= $form->field($model, 'userdisplay')->textInput(['required'=>true,'class' => 'form-control my_userdisplay'])->label('Tên hiển thị<span class="required_data"> *</span>');
    ?>
    
    <?php if ($model->isNewRecord) { ?>

        <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'class' => 'form-control my_password_hash'])->label('Mật khẩu<span class="required_data"> *</span>');
        ?> 

        <?= $form->field($model, 're_password')->passwordInput(['maxlength' => true, 'class' => 'form-control my_re_password'])->label('Nhập lại mật khẩu<span class="required_data"> *</span>'); ?>

    <?php } ?>

    
    <?php if ($model->isNewRecord) { ?>
        <?= $form->field($model, 'nhom_quyen_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Authitem::find()->where(['type' => 1])->orderBy(['name'=>SORT_ASC])->all(), 'name', 'description'),
                'language' => 'vi',
                'options' => ['placeholder' => '--- Lựa chọn quyền ---'],
                'pluginOptions' => [
                    'initialize' => true,
                    'allowClear' => true
                ],
                ])->label('Nhóm quyền<span class="required_data"> *</span>');
            ?>
    <?php } ?>
    
    <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
     </div>

    <?php ActiveForm::end(); ?>

    

</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
$( document ).ready(function() { 
    
    $(".type_login").change(function(){
        var value = this.value;
        var pas = document.getElementsByClassName("my_password_hash")[0];
        var repas = document.getElementsByClassName("my_re_password")[0];
        var serial = document.getElementsByClassName("my_serialcert")[0];
        if (parseInt(value) == 1) {
            var att = document.createAttribute("required");
            att.value = "true";
            var att2 = document.createAttribute("required");
            att2.value = "true";
            pas.setAttributeNode(att);
            repas.setAttributeNode(att2);
            $(".my_serialcert").removeAttr("required");
        }else{
            var att = document.createAttribute("required");
            att.value = "true";
            serial.setAttributeNode(att);
            $(".my_password_hash").removeAttr("required");
            $(".my_re_password").removeAttr("required");
        }
    });

    $(".my_userdisplay").blur(function(){
        var value = this.value;
        var user_displayname = capitalizeFirstLetter(value);
        $(".my_userdisplay").val(user_displayname);
    });
    $(".my_username").blur(function(){
        var value = this.value;
        var res = value.toLowerCase();
        $(".my_username").val(res);
    });
    function capitalizeFirstLetter(string) {
        var res = string.split(" ");
        var end_string = '';
        for (var i = 0; i < res.length; i++) {
            var element_string = res[i].charAt(0).toUpperCase() + res[i].slice(1);
            end_string += element_string + ' ';
        }
        return end_string.trim();
    }
});

</script>

