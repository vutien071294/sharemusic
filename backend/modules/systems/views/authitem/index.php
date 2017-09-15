<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\components\ComponentBase;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\systems\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Nhóm quyền';
$this->params['breadcrumbs'][] = $this->title;
$arr = array('0' => '10' , '1' => '15', '2'=> '20', '3' => '30','4' => '50');
$components = new ComponentBase();
$base_url = $components->Base_url();
?>
<!-- Content Header (Page header) -->

<div class="authitem-index">
    <div>
        <section class="content-header">
            <h1 class="add-color-content-header">
            Danh sách nhóm quyền
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
            'attribute' => 'name',
            'headerOptions' => ['class' => 'text-center text-headerOptions'],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:20%;',],
        ],
        [
            'attribute' => 'created_at',
            'headerOptions' => ['class' => 'text-center text-headerOptions '],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
            'format' => ['date', 'php:d-m-Y'],
        ],
        [
            'attribute' => 'description',
            'headerOptions' => ['class' => 'text-center text-headerOptions '],
            'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:50%;',],
        ],
        [   
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
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
            'delete' => function ($url, $model) {
                return Html::a(
                    '',
                    $url = '#',
                    ['class' => 'glyphicon glyphicon-trash confirm_delete add-color-content-header', 'id' => $model->name,'title' => 'Xóa']
                );
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
            url: '<?php echo $base_url ?>systems/authitem/index',
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


<div class="modal fade" id="confirm_delete_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:30px 25px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="text-align: center; font-size: 20;"><span class="glyphicon glyphicon-lock" ></span> Bạn có chắc chắn muốn xóa bản ghi ?</h4>
            </div>
            <div class="id_delete_district_inmodal_div hide" ></div>
                <div class="modal-footer" style="margin-left: 30%; ">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button>
                <div id="district"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $(".confirm_delete").click(function(){
            var id_del = $(this).attr('id');
            $(".id_delete_question_inmodal_div").empty().append(" <p class='id_delete_district_inmodal_p' >"+id_del+"</p>.");
            $("#district").empty().append("<a style='color:white;text-decoration: none;' href='<?php echo $base_url ?>systems/authitem/delete?id="+id_del+" ' data-method='post' > <button  style='margin-left: 5%;' type='submit' class='btn btn-primary btn-default pull-left confirm_delete_btn'><span class='glyphicon glyphicon-trash'></span> Xóa </button> </a> ");
            $("#confirm_delete_modal").modal();
        })
       $(".confirm_delete_btn").click(function(){
        var id_delete_district = $('.id_delete_district_inmodal_p').text();
        document.getElementsByClassName("confirm_delete_btn")[0].setAttribute("data-dismiss", "modal"); 
      });
    //xoa
  });
</script>