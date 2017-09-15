<?php

use backend\modules\categorys\models\Province;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\categorys\models\DistrictSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="province-search">

    <?php $form = ActiveForm::begin(
        [
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'form-horizontal'],
        ]
    ); ?>

    <div style="margin-top: 10px">
        <?= $form->field($model, 'search_text', ['options' => ['class' => 'col-xs-4']])->textInput(['placeholder' => 'Nhập mã/ Tên quận huyện'])->label(false) ?>

        <?= $form->field($model,'province_code', ['options' => ['class' => 'col-xs-2']])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Province::find()->orderBy(['name'=>SORT_ASC])->where(['is_valid'=> 1])->all(), 'code', 'name'),
                'language' => 'vi',
                'options' => ['placeholder' => '--- Tỉnh thành ---'],
                'pluginOptions' => [
                'allowClear' => true
                ],
                ])->label(false);
                ?>
    </div>


</div>
<div class="form-group">
    <?= Html::submitButton('Tìm kiếm', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
