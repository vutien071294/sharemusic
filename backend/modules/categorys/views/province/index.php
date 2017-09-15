<?php
namespace backend\modules\categorys\views\province;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use backend\components\ComponentBase;
use backend\modules\categorys\models\Province;
use kartik\export\ExportMenu;
use Yii;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\categorys\models\ProvinceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tỉnh thành';
$this->params['breadcrumbs'][] = $this->title;
$arr = array('0' => '10' , '1' => '15', '2'=> '20', '3' => '30',
    '4' => '50' );
$components = new ComponentBase();
$base_url = $components->Base_url();

?>


<div class="province-index">

    <div>
        <section class="content-header">
         <h1 class="add-color-content-header">
            Danh mục tỉnh thành
        </h1>
        </section>
    </div>
    <div class="search-in-category">
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
  
    <!-- Xuất excel -->
    <?php 
    $gridColumns = [
      [
      'class' => 'yii\grid\SerialColumn',
      'header'=>'STT',
      ],
      'code',
      'name',
      'country',
      [
        'attribute' => 'begin_time',
        'format' => ['date', 'php:d-m-Y'],
      ],
      [
        'attribute' => 'end_time',
        'format' => ['date', 'php:d-m-Y'],
      ],
       [
          'attribute' => 'is_valid',
          'format'=>'raw',
          'value'=>function($row){
                if ($row['is_valid'] == '1') {
                    $status_name = 'Có hiệu lực';
                }else
                {
                    $status_name = 'Hết hiệu lực';
                }
                return Html::tag('span', $status_name);
                },
            ],
      'description',
    ];
    ?>
    <div class="pull-right">
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'target'=>'_self',
            'filename'=>'Danh sách tỉnh thành',
            'dropdownOptions' => [
            'label' => 'Export',
            'class' => 'btn btn-primary',
            'title'=> 'Xuất dữ liệu',
            'encoding'=> 'utf8'
            ],
            'showColumnSelector'=>true,
            'columnSelectorOptions' =>[
            'class' => 'btn btn-primary',
            'title' => 'Cột muốn xuất',
            ],
            'columnBatchToggleSettings' => [
              'label' => 'Tất cả',
            ],
            'showConfirmAlert'=> false,
            'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_HTML  => false,
            ],
            ]);
            ?>
        <?php  if( Yii::$app->user->can('ADD_PROVINCE')){ ?>
        <a class="btn btn-primary" href="#" id="click-import-excel"> <span class="glyphicon glyphicon-import"></span> Import</a>

        <?= Html::a(' + Thêm', ['create'], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        
        
    </div>

    <?= GridView::widget([
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
                'attribute' => 'code',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
            ], 
            [
                'attribute' => 'name',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
            ],
            [
                'attribute' => 'is_valid',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:30%;',],
                'format'=>'raw',
                'value'=>function($row){
                $values=[
                '1'=>'label label-success status_category'.$row['id'],
                '2'=>'label label-danger status_category'.$row['id'],
                ];
                if ($row['is_valid'] == '1') {
                    $status_name = 'Có hiệu lực';
                }else
                {
                    $status_name = 'Hết hiệu lực';
                }
                return Html::tag('span', $status_name , ['class' => $values[$row['is_valid']]]
                    );
                },
            ],
            [   
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'header'=>'',
                'headerOptions' => ['class' => 'text-center'],
                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:7%;',],
                'buttons' => [
                    'view' => function ($url, $model) {
                      if( Yii::$app->user->can('VIEW_PROVINCE')){
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            $url,['title' => 'Xem']);
                      }
                      else
                        {
                          return '';
                        }
                    },
                    'update' => function ($url, $model) {
                      if( Yii::$app->user->can('EDIT_PROVINCE')){
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            $url,['title' => 'Cập nhật']);
                         }
                      else
                        {
                          return '';
                        }
                    },
                    'delete' => function ($url, $model) {
                      if( Yii::$app->user->can('DELETE_PROVINCE')){
                        return Html::a(
                          '',
                          $url = '#',
                          ['class' => 'glyphicon glyphicon-trash confirm_delete_province add-color-content-header', 'id' => $model->id,'title' => 'Xóa']
                          );
                      }
                      else
                        {
                          return '';
                        }
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


<!-- Modal show import -->
<div class="modal fade" id="confirm_importdata" role="dialog" data-backdrop="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header modal_header-site">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           <h4><span class="glyphicon glyphicon-transfer"></span> Lựa chọn file excel tải lên <a href="<?php echo $base_url?>uploads/temp/tinhthanh.xlsx" download>(<span class="glyphicon glyphicon-save"></span>Tải file mẫu)</a></h4>
        </div>
        <?php 
        $model = new Province(); 
        $form = ActiveForm::begin(['action' => 'province/import', 'options' => ['enctype'=>'multipart/form-data']]); ?>
        <div class="col-md-9 content-modal_import">
            <?= $form->field($model,'file')->fileInput(['class' => 'content-modal_import','required' => 'required','accept'=>'.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'])->label(false) ?>
        </div>
            <div class="form-group">
              <div class="modal-footer margin_modal-30">
                  <?= Html::submitButton('<span class="glyphicon glyphicon-import"></span> Import',['class'=>'btn btn-primary pull-left']) ?>
                  <button type="" class="btn btn-danger btn-default margin-right-55" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button>
                  
              </div>
            </div>
            <?php ActiveForm::end(); ?>
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
            url: '<?php echo $base_url ?>categorys/province/index',
            data: { record : x},
            async: true,
            success: function(result) {
              document.open();
              document.write(result);
              document.close();
            },
        });
    }

    $("#click-import-excel").click(function(){
        $("#confirm_importdata").modal();
    });
</script>
<?php 
if ($error) {
    ?>

    <!-- Modal error  import-->
    <div class="modal fade" id="modal-error-import-excel" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header-faq-error modal_header-site">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="text-error-modal"><span class="glyphicon glyphicon-grain"></span> Dòng <?php echo $error ?> </h4>
            </div>
        </div>

    </div>
    </div> 
    <script>
        $( document ).ready(function() {
            $("#modal-error-import-excel").modal("show");
                window.setTimeout(function () {
                  $("#modal-error-import-excel").modal("hide");
                  location.replace('<?php echo $base_url ?>categorys/province');
              }, 3000);
        });
    </script>
    <?php
}
 ?>

<!-- Modal show delete  -->
    <div class="modal fade" id="confirm_delete_province_modal" role="dialog" data-backdrop="false">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header modal_header-site">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="h4_fontsize-modal"><span class="glyphicon glyphicon-lock" ></span> Bạn có chắc chắn muốn xóa bản ghi ?</h4>
          </div>
          <div class="id_delete_province_inmodal_div hide" ></div>
          <div class="modal-footer modal_footer-site">
            <button id="" type='submit' class='btn btn-primary btn-default pull-left confirm_delete_province_btn margin_modal-3'><span class='glyphicon glyphicon-trash' data-dismiss='modal'></span> Xóa </button>
            <button type="submit" class="btn btn-danger btn-default pull-left margin_modal-5" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button>
            </div>
          </div>
        </div>

      </div>
<!-- modal thong bao -->
    <div class="modal fade" id="modal-success_delete" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header-success" >
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="text-success-modal text-center"></h3>
              </div>
          </div>

      </div>
    </div>
</div> 
    <script>
      $(document).ready(function(){
         $(".confirm_delete_province").click(function(){
            var id_province = $(this).attr('id');
            $('.confirm_delete_province_btn').attr('id',id_province);
            $("#confirm_delete_province_modal").modal();
            });

       $(".confirm_delete_province_btn").click(function(){
          $("#confirm_delete_province_modal").modal("hide");
          var id_delete = $(this).attr('id');
          if (id_delete) 
            {
              $.ajax({
                method: 'POST',
                url: '<?php echo $base_url ?>categorys/province/delete',
                data: { 'value' : id_delete},
                async: true,
                success: function(result){
                  if (result == 'success') 
                    {
                        $("#modal-success_delete").modal("show");
                        $('.text-success-modal').html('<span class="glyphicon glyphicon-ok-circle"></span> Xóa thành công');
                          window.setTimeout(function () {
                          $("#modal-success_delete").modal("hide");
                          location.replace('<?php echo $base_url ?>categorys/province');
                        }, 2000);
                        
                    }
                  else
                    {
                        $("#modal-success_delete").modal("show");
                        $('.text-success-modal').html('<span class="glyphicon glyphicon-remove-circle"></span> Xóa không thành công');
                          window.setTimeout(function () {
                          $("#modal-success_delete").modal("hide");
                        }, 2000);
                        

                    }
                }

              });
            }
          else
          {
            return false;
          }
       
      });
    //xoa
  });
</script>
