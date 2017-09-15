<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\users\models\User;
use backend\modules\systems\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model backend\modules\authentication\models\Authassignment */

$this->title = 'Xem chi tiết vai trò người dùng';
$this->params['breadcrumbs'][] = ['label' => 'Authassignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user = new User();
$user_name = $model->user_id ? $user->get_user_name($model->user_id) : '';
//
$authitem = new Authitem();
$list_permission = $authitem->get_list_permission($model->item_name);
?>
<div class="authassignment-view col-md-9" style="margin-left: 10%; margin-top:20px; padding: 20px;">

     <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
    <legend style="text-align: center;  color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3 class="add-color-content-header"><?= Html::encode($this->title) ?></h3></legend>

        <div class="mapping-content-updateform">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'user_id',
                    'value' => $user_name
                ],
                'item_name',
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
        <?= '<label class="control-label">Danh sách quyền</label>'; ?>
        <?= ' <div class="help-block"></div>' ?>
        <table>
        
        <?php foreach($list_permission as $statement){ ?>
        <tr class="col-sm-6">
            <td >
                <?= $statement['description'] ?>
            </td>
        </tr>

        <?php } ?>
        </table>
        <hr class="hr_inform">
         <div class="form-group pull-right">
               <p>
                   <?= Html::a('Cập nhật', ['update', 'item_name' => $model->item_name, 'user_id' => $model->user_id], ['class' => 'btn btn-primary']) ?>

                   <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
               </p>
           </div>
        </div> 
    </fieldset> 
</div>
