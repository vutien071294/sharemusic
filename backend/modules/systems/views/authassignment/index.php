<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\place\models\Province;
use backend\components\ComponentBase;
use kartik\export\ExportMenu;
use backend\modules\place\models\District;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\systems\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Vai trò';
$this->params['breadcrumbs'][] = $this->title;
$arr = array('0' => '10' , '1' => '15', '2'=> '20', '3' => '30', '4' => '50');
$components = new ComponentBase();
$base_url = $components->Base_url();
?>
<!-- Content Header (Page header) -->

<div class="authassigment-index">
    <div>
        <section class="content-header">
            <h1 class="add-color-content-header">
                Quản lý vai trò người dùng
            </h1>
        </section>
    </div>
<div class="pull-right">
    <?= Html::a(' + Thêm', ['create'], ['class' => 'btn btn-primary']) ?>
</div>
<?= GridView::widget([
    'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
        ],
    'dataProvider' => $dataProvider,
    'summary' => "<div class='summary'>Hiển thị <b>{begin}</b> - <b>{end}</b> trên <b>{totalCount}</b> bản ghi<div>",
    'emptyText' => 'Không có bản ghi !',
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header'=>'',
            'headerOptions' => ['class' => 'text-center text-headerOptions'],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:3%;',],
        ],
        [
            'attribute' => 'user_id',
            'value' => 'users.username',
            'headerOptions' => ['class' => 'text-center text-headerOptions'],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:35%;',],
            'label' => 'Người dùng',
        ],
        [
            'attribute' => 'item_name',
            'value' => 'authitem.description',
            'headerOptions' => ['class' => 'text-center text-headerOptions'],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:40%;',],
        ],
        [
            'attribute' => 'created_at',
            'headerOptions' => ['class' => 'text-center text-headerOptions '],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
            'format' => ['date', 'php:d-m-Y'],
        ],
        [   
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update}',
            'header'=>'',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:7%;',],
            'buttons' => [
                'view' => function ($url, $model) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-eye-open"></span>',
                    $url,['title' => 'Xem']);
                },
                'update' => function ($url, $model) {
                  return Html::a(
                    '<span class="glyphicon glyphicon-pencil"></span>',
                    $url,['title' => 'Cập nhật']);
                },
            ],
        ],
    ],
]); ?>

<?php 
$total=$dataProvider->getTotalCount();
if ($total>$records) {
?>
<div style="margin-top: -75px;">
<?php
}else{ 
?>
<div>
<?php
}
?>
    <div class="pull-right Mypagination">
        <table>
            <tr>
                <td>
                    <div>
                        <p style="float: right; padding-top: 10px;">Kích thước trang: </p>
                    </div>
                </td>
                <td>
                    <div>
                        <select style="width: 80px;  " id="pagination-number-new" class="form-control pull-right " onchange="selectpickerpages()" name="">
                          <?php 
                          foreach ($arr as $key => $value) {
                            ?>
                            <option value="<?php echo $value ?>" <?php if ($records == $value) {
                              ?>
                              selected=""
                              <?php
                            } 
                            ?> ><?php echo $value ?></option>
                            <?php
                          }
                          ?>
                        </select>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    function selectpickerpages() {
        var x = document.getElementById("pagination-number-new").value;
        $.ajax({
            method: "POST",
            url: '<?php echo $base_url ?>systems/authassigment/index',
            data: { record : x},
            async: true,
            success: function(result) {
                document.open();
                document.write(result);
                document.close();
            },
        });
    }
</script>

