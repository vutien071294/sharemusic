<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\User */

$this->title = 'Cập nhật tài khoản';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update col-md-12" style="margin-left: 0%; margin-top:20px;" >

    <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
		<legend style="text-align: center;  color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3 class="add-color-content-header"><?= Html::encode($this->title) ?></h3></legend>
		<div class="mapping-content-updateform">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
    	</div>
    	<?= $this->render('info', [
                'user_id' => $model->id,
            ]) ?>
	</fieldset>


</div>
