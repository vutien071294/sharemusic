<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\systems\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\modules\place\models\District */
/* @var $form yii\widgets\ActiveForm */

$authitem = new Authitem();
$list_permission = $authitem->get_list_permission_name($model->name);
$js_array = json_encode($list_permission);
?>

<div class="authitem-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
    
    <?php if ($model->isNewRecord) {
        ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 50])->label('Tên nhóm quyền<span class="required_data"> *</span>') ?>
        <?php
    }else{
        ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => 50,'disabled' => true])->label('Tên nhóm quyền<span class="required_data"> *</span>') ?>
        <?php
    }?>

    <?= $form->field($model, 'description')->textArea(['row' => 5, 'maxlength' => 2000]) ?>

    <?= ' <div class="help-block"></div>' ?>

    <?= '<label class="control-label">Lựa chọn quyền<span class="required_data"> *</span></label>'; ?>
    
     <?= ' <div class="help-block"></div>' ?>

    <?php echo Html::checkbox(null, false, [
        'label' => 'Tất cả',
        'class' => 'check-all',
    ]); ?>

     <?= $form->field($model, 'list_permission')->checkboxList(ArrayHelper::map(AuthItem::find()->where(['type' => '2'])->all(), 'name', 'description'), [
                        'item'=>function ($index, $label, $name, $checked, $value){
                            return '<div class="col-md-6">
                                         <input type="checkbox" name='.$name.' value='.$value.' class="checkbox_list_per checkbox_item_'.$value.'" />'.$label.'
                                    </div>';
                                    }
                        ],
                        ['class' => 'class_list_permission'] )->label(false) ?>

    </br>
    <div class="form-group pull-right">
        <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    $('.check-all').click(function() {
        var selector = $(this).is(':checked') ? ':not(:checked)' : ':checked';
        $('#authitem-list_permission input[type="checkbox"]' + selector).each(function() {
            $(this).trigger('click');
        });
    });
</script>
<?php 


if (!$model->isNewRecord) {
    ?>
    <script>
        var list_per_old = <?php echo $js_array ?>;
        var elm = document.getElementsByClassName('checkbox_list_per');
        $.each(elm, function(index, el) {
            $.map(list_per_old, function(em){
                if(el.value ==  em.child){
                    $(".checkbox_item_"+em.child).prop("checked", true);
                }
            });
        }); 
    </script>

    <?php
} ?>
<script>
    $(".checkbox_list_per").change(function() {
        var elm = document.getElementsByClassName('checkbox_list_per');
        if(this.checked == false) {
            var length_check = $('#authitem-list_permission :checked').size();
            if(elm.length == length_check){
                $(".check-all").prop("checked", true);
            }else{
                 $(".check-all").prop("checked", false);
            }
        }
        if(this.checked) {
            var length_check = $('#authitem-list_permission :checked').size();
            if(elm.length == length_check){
                $(".check-all").prop("checked", true);
            }else{
                 $(".check-all").prop("checked", false);
            }
        }
    });
</script>
<script>
    var elm = document.getElementsByClassName('checkbox_list_per');
    var length_check = $('#authitem-list_permission :checked').size();
    if(elm.length == length_check){
        $(".check-all").prop("checked", true);
    }
</script>