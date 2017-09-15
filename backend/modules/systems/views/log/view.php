<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\users\models\User;
/* @var $this yii\web\View */
/* @var $model backend\modules\systems\models\Log */

$this->title = 'Xem chi tiết lịch sử hoạt động';
$this->params['breadcrumbs'][] = ['label' => 'Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$name_user = $model->user_id ? User::findOne($model->user_id)['username'] : '';
?>
<div class="log-view col-md-9" style="margin-left: 10%; margin-top:20px;">

    <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
        <legend style="text-align: center; color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3><?= Html::encode($this->title) ?></h3></legend>

        <div class="mapping-content-updateform">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'action',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'resource',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => $name_user,
                    ],

                    [
                        'attribute' => 'create_time',
                        'format' => ['date', 'php:d-m-Y'],
                    ],
                    [
                        'attribute' => 'decription',
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
            <div class="pull-right" style="margin-right: 10px;">
                <p>

                    <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
                </p>
            </div>
        </div>

    </fieldset>
</div>
