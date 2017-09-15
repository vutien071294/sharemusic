<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\place\models\District */

$this->title = 'Thêm mới nhóm quyền';
$this->params['breadcrumbs'][] = ['label' => 'Authitem', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authitem-create col-md-10" style=" margin-left: 8%; margin-top:20px;" >

	<fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
		<legend style="text-align: center;  color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3 class="add-color-content-header"><?= Html::encode($this->title) ?></h3></legend>
		<div class="mapping-content-updateform">
			<?= $this->render('_form', [
				'model' => $model,
				]) ?>
			</div>
		</fieldset>

	</div>
