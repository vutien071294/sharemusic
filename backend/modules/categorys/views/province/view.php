<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\ComponentBase;
use backend\modules\users\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\categorys\models\Province */

$this->title = 'Xem chi tiết tỉnh thành';
$this->params['breadcrumbs'][] = ['label' => 'Provinces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$components = new ComponentBase();
$base_url = $components->Base_url();

$name_create_user = $model->create_user_id ? User::findOne($model->create_user_id)['username'] : '';
$name_update_user = $model->update_user_id ? User::findOne($model->update_user_id)['username'] : '';
$name = $model->name ? html_entity_decode($model->name) : '';
$country = $model->country ? html_entity_decode($model->country) : '';
$description = $model->description ? html_entity_decode($model->description) : '';

if ($model->is_valid == 1) {
    $status_view = 'Có hiệu lực';
}else
{
    $status_view = 'Hết hiệu lực';
}



//get css class
$getbel=[
    '2'=>'label label-danger',
    '1'=>'label label-success',
];
if ($model->is_valid) {
    $classstatus = $getbel[$model->is_valid];
}else
{
    $classstatus = $getbel[2];
}    
//
?>
<div class="province-view col-md-9" style="margin-left: 10%; margin-top:20px;">

 <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
        <legend style="text-align: center; color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3><?= Html::encode($this->title) ?></h3></legend>
    
        <div class="mapping-content-updateform">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'code',
            ],
            [
                'attribute' => 'name',
                'value' => $name,
            ],
            [
                'attribute' => 'country',
                'value' => $country,
            ],
            [
                'attribute'=>'is_valid',
                'format'=>'raw',    
                'value'=>Html::tag('span', $status_view, [ 'class' => $classstatus]),
            ],
            [
                'attribute' => 'begin_time',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'end_time',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'create_user_id',
                'value' => $name_create_user,
            ],
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:d-m-Y'],
            ],
            [
                'attribute' => 'update_user_id',
                'value' => $name_update_user,
            ],
            [
                'attribute' => 'description',
                'value' => $description,
            ],
        ],
    ]) ?>
      <div class="pull-right" style="margin-right: 10px;">
            <p>
                <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            
                <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
            </p>
        </div>
     </div> 

    </fieldset>
</div>
</div>
