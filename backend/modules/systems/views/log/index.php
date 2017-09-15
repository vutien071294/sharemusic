<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\ComponentBase;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\systems\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Logs';
$this->params['breadcrumbs'][] = $this->title;
$arr = array('0' => '10' , '1' => '15', '2'=> '20', '3' => '30',
    '4' => '50' );
$components = new ComponentBase();
$base_url = $components->Base_url();
?>
<div class="log-index">
    <div>
        <section class="content-header">
         <h1 class="add-color-content-header">
            Lịch sử hoạt động người dùng
        </h1>
        </section>
    </div>
    <div class="search-in-category">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <?= GridView::widget([
        'pager' => [
            'firstPageLabel' => 'Đầu',
            'lastPageLabel' => 'Cuối',
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
                'attribute' => 'action',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:10%;',],
            ], 
            [
                'attribute' => 'resource',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
            ], 
            [
                'attribute' => 'user_id',
                'value' => 'user.username',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:10%;',],
            ], 

            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:d-m-Y'],
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:10%;',],
            ],
            [
                'attribute' => 'decription',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
            ], 

            [   
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'header'=>'',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:7%;',],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            $url,['title' => 'Xem']);
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
          <div class="pull-right" style="margin-top: 14px">
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
</div>
</div>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
    function selectpickerpages() {
        var x = document.getElementById("pagination-number-new").value;
        console.log(x);
        $.ajax({
            method: "POST",
            url: '<?php echo $base_url ?>systems/log/index',
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
