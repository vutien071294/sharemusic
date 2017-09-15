<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\systems\models\AuthItem;/* @var $this yii\web\View */
/* @var $model backend\modules\place\models\Province */
$authitem = new Authitem();
$list_permission = $authitem->get_list_permission($model->name);
//
$this->title = 'Xem chi tiết nhóm quyền';
$this->params['breadcrumbs'][] = ['label' => 'Districts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="district-view col-md-10" style="margin-left: 8%; margin-top:20px; padding: 20px;">

<fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
    <legend style="text-align: center;  color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;">
        <h3 class="add-color-content-header"><?= Html::encode($this->title) ?></h3>
    </legend>

    <div class="mapping-content-updateform">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                [
                    'attribute' => 'description',
                    'format' => 'raw',
                ],     
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'php:d-m-Y']
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'php:d-m-Y']
                ],
            ],
            ]) ?>

        <label class="control-label">Danh sách quyền</label>'
        <div class="help-block"></div>'
        <table class="table">
            <?php foreach($list_permission as $statement){ ?>
                <tr class="col-md-6">
                    <td>
                        <?= $statement['description'] ?>
                    </td>
                </tr>

            <?php } ?>
        </table>
        <hr class="hr_inform">
        <div class="form-group pull-right">
            <p>
                <?= Html::a('Cập nhật', ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>

                <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
            </p>
        </div>
    </div>
</fieldset>

</div>

