<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\members\models\Users */

$this->title = 'Cập nhật thông tin cá nhân';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update">

    <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
		<legend style="text-align: center; color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3><?= Html::encode($this->title) ?></h3></legend>
		<div class="mapping-content-updateform">
			<?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
		</div>
	</fieldset>

</div>
	