<?php
namespace backend\modules\users\views\user;

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\users\models\User;
use backend\components\ComponentBase;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\users\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tài khoản';
$this->params['breadcrumbs'][] = $this->title;
$arr = array('0' => '10' , '1' => '15', '2'=> '20', '3' => '30', '4' => '50');
$components = new ComponentBase();
$base_url = $components->Base_url();

?>
<div class="user-index">
    <div>
        <section class="content-header">
            <h1 class="add-color-content-header">
                Danh sách người dùng
            </h1>
        </section>
    </div>
    <div class="search-in-category">
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
    <div class="pull-right">
        <p>
            <?= Html::a('+ Thêm', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>
    <?= GridView::widget([
        'pager' => [
            'firstPageLabel' => 'Đầu',
            'lastPageLabel' => 'Cuối',
        ],
        'emptyText' => 'Không có bản ghi !',
        'summary' => "<div class='summary'>Hiển thị <b>{begin}</b> - <b>{end}</b> trên <b>{totalCount}</b> bản ghi<div>",
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:3%;',],
            ],
            [
                'attribute' => 'username',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
            ],
            [
                'attribute' => 'userdisplay',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
            ],
            
            [
                'attribute' => 'nhom_quyen_id',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
                'format' => 'raw',
                'value'=>function($row){
                    $user = new User();
                    $role = $user->get_role_user($row->id);
                    if ($role) {
                        return $role;
                    }else{
                        return '';
                    }
                    
                }
            ],
            [
                'attribute' => 'last_login_time',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:15%;',],
                'format' =>  ['date', 'php: d-m-Y'],
            ],
            [
                'attribute' => 'status',
                'label' => 'Trạng thái',
                'headerOptions' => ['class' => 'text-center text-headerOptions'],
                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:10%;',],
                'format'=>'raw',
                'value'=>function($row){
                    $values=[
                        '2'=>'label label-warning status_category'.$row['id'],
                        '1'=>'label label-success status_category'.$row['id'],
                        '3'=>'label label-danger status_category'.$row['id'],
                    ];
                        if ($row['status'] == '1 ') {
                            $status_name = 'Hoạt động';
                        }elseif($row['status'] == '2')
                        {
                            $status_name = 'Tạm dừng';
                        }else{
                            $status_name = 'Khóa';
                        }
                        return Html::tag('span', $status_name , ['class' => $values[$row['status']]]);
                },
            ],

            [   
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {reset}',
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
                        if( Yii::$app->user->can('DELETE_USER') ){
                            return Html::a(
                            '',
                            $url = '#',
                            ['class' => 'glyphicon glyphicon-trash confirm_delete add-color-content-header', 'id' => $model->id,'title' => 'Xóa']
                        );
                        }else{
                            return '';
                        }
                    },
                    'reset' => function ($url, $model) {
                        if( Yii::$app->user->can('RESET_PASSWORD_USER') ){
                            return Html::a(
                                '',
                                $url = '#',
                                ['class' => 'glyphicon glyphicon-send confirm_reset_password add-color-content-header', 'id' => $model->id,'title' => 'reset password']
                            );
                        }else{
                            return '';
                        }
                        
                    },

                ],
            ],
        ],
    ]); ?>
</div>
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
        <div class="pull-right Mypagination" >
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
                            <option value="<?php echo $value ?>" <?php if ($records == $value) { ?>
                            selected=""
                            <?php
                                } 
                            ?> >
                            <?php echo $value ?>
                            </option>
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
<script >
    function selectpickerpages() {
        var num = document.getElementById("pagination-number-new").value;
        $.ajax({
            method: "POST",
            url: '<?php echo $base_url ?>users/user/index',
            data: { record : num},
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
            <div class="modal-footer" style="margin-left: 30%; ">
            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button>
            <div id="button_del_user"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_reset_password_modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:30px 25px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="text-align: center; font-size: 20;"><span class="glyphicon glyphicon-lock" ></span> Bạn có chắc chắn reset mật khẩu người dùng này ?</h4>
            </div>
            <div class="modal-footer" style="margin-left: 30%; ">
            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button>
            <div id="reset_pass_button"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        //xoa
        $(".confirm_delete").click(function(){
            var id_del = $(this).attr('id');
            
            $("#button_del_user").empty().append("<a style='color:white;text-decoration: none;' href='<?php echo $base_url ?>users/user/delete?id="+id_del+" ' data-method='post' > <button  style='margin-left: 5%;' type='submit' class='btn btn-primary btn-default pull-left confirm_delete_btn'><span class='glyphicon glyphicon-trash'></span> Xóa </button> </a> ");
            $("#confirm_delete_modal").modal();
        })
        $(".confirm_delete_btn").click(function(){
        document.getElementsByClassName("confirm_delete_btn")[0].setAttribute("data-dismiss", "modal"); 
        });
        // reset mật khẩu
        $(".confirm_reset_password").click(function(){
            var id_reset = $(this).attr('id');
            console.log(id_reset)
            $("#reset_pass_button").empty().append("<a style='color:white;text-decoration: none;' href='<?php echo $base_url ?>users/user/reset_password?id="+id_reset+" ' data-method='post' > <button  style='margin-left: 5%;' type='submit' class='btn btn-primary btn-default pull-left confirm_reset_password_btn'><span class='glyphicon glyphicon-send'></span> Reset </button> </a> ");
            $("#confirm_reset_password_modal").modal();
        })
        $(".confirm_reset_password_btn").click(function(){
        document.getElementsByClassName("confirm_reset_password_btn")[0].setAttribute("data-dismiss", "modal"); 
        });
  });
</script>