<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\users\models\User;
use yii\helpers\ArrayHelper;
use backend\modules\systems\models\AuthItem;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\systems\models\Authassignment */
/* @var $form yii\widgets\ActiveForm */
$users = User::find()->where(['id' => $model->user_id])->all();
// $arr = [$users[0]['id'] => $users[0]['username']];
?>

<div class="authassignment-form">

	<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<!--  -->
        <?php if ($model->isNewRecord) {
        ?>
        <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(User::find()->orderBy(['username'=>SORT_ASC])->all(), 'id', 'username'),
            'language' => 'vi',
            'options' => ['placeholder' => '--- Lựa chọn người dùng ---'],
            'pluginOptions' => [
            'allowClear' => true
            ],
            ])->label('Chọn người dùng<span class="required_data"> *</span>');
            ?>
        <?php
        }else{
        ?>
        <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(User::find()->orderBy(['username'=>SORT_ASC])->all(), 'id', 'username'),
            'language' => 'vi',
            'disabled' => true,
            'options' => ['placeholder' => '--- Lựa chọn người dùng ---'],
            'pluginOptions' => [
            'allowClear' => true,
            ],
            ])->label('Chọn người dùng<span class="required_data"> *</span>');
            ?>
        <?php
        }
        ?>

        <?= $form->field($model, 'item_name')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Authitem::find()->where(['type' => 1])->orderBy(['name'=>SORT_ASC])->all(), 'name', 'name'),
                'language' => 'vi',
                'options' => ['placeholder' => '--- Lựa chọn nhóm quyền ---'],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ])->label('Nhóm quyền<span class="required_data"> *</span>');
                ?>

    <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Lưu' : 'Cập nhật', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
            <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
     </div>

    <?php ActiveForm::end(); ?>

</div>
