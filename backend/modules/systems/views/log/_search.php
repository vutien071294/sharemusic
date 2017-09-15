<?php
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\users\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\categorys\models\DistrictSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin(
        [
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'form-horizontal'],
        ]
    ); ?>

    <div style="margin-top: 10px">
        <?= $form->field($model, 'resource', ['options' => ['class' => 'col-xs-3']])->textInput(['placeholder' => 'Nhập tên tài nguyên...'])->label(false) ?>

        <?= $form->field($model,'user_id', ['options' => ['class' => 'col-xs-2']])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(User::find()->orderBy(['username'=>SORT_ASC])->all(), 'id', 'username'),
                'language' => 'vi',
                'options' => ['placeholder' => '--- Lựa chọn người dùng ---'],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ])->label(false);
                ?>
    </div>
<div class="form-group">
    <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
