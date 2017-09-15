<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\users\models\Agency;

// use backend\modules\place\models\Province;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div  style="margin-top: 10px">
        <?= $form->field($model, 'search_text', ['options' => ['class' => 'col-xs-4']])->textInput(['placeholder'=>'Nhập tên đăng nhập/ tên người dùng'])->label(false) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
