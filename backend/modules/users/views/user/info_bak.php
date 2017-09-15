<?php
use backend\modules\users\models\Userinfo;
use backend\modules\users\models\User;
use backend\components\ComponentBase;
use kartik\date\DatePicker;
use backend\modules\systems\models\Authassignment;
use backend\modules\systems\models\AuthItem;
use yii\grid\GridView;
use yii\helpers\Html;

$components = new ComponentBase();
$base_url = $components->Base_url();

$userinfo = Userinfo::find()->where(['user_id' => $user_id])->one();
$userrole = Authassignment::find()->where(['user_id' => $user_id])->one();

//tab quyền
$user_info = new Userinfo();
if ($userrole['item_name']) {
	$role_user = $userrole['item_name'];
	$list_permission = $user_info->get_list_permission($role_user);
}else{
	$role_user  = '';
}

//tab info
if ($userinfo['birthday'] != 0) {
	$birthday_user = substr($userinfo['birthday'], 6,2).'-'.substr($userinfo['birthday'], 4,2).'-'.substr($userinfo['birthday'], 0,4);
}else{
	$birthday_user = '';
}
if ($userinfo['provision_day'] != 0) {
	$provision_day_user = substr($userinfo['provision_day'], 6,2).'-'.substr($userinfo['provision_day'], 4,2).'-'.substr($userinfo['provision_day'], 0,4);
}else{
	$provision_day_user = '';
}

//tab đại lý
$user = new User();
if ($user_id) {
	$list_agency_by_user = $user->get_list_agency_by_user($user_id);
	$list_cooperator_by_user = $user->get_list_cooperator_by_user($user_id);
}

$dataProvider = User::get_list_data_agency_new($user_id);
?>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<div class="col-md-12">
  	<div class="nav-tabs-custom">
    	<ul class="nav nav-tabs">
		    <li><a href="#info_user" data-toggle="tab"><b>Thông tin</b></a></li>
		    <li><a href="#agency" data-toggle="tab"><b>Đại lý</b></a></li>
		    <!-- <li><a href="#cooperator" data-toggle="tab"><b>Cộng tác viên</b></a></li> -->
		    <li><a href="#role_user" data-toggle="tab"><b>Quyền hạn</b></a></li>
		    <li ><a href="#history_user" data-toggle="tab"><b>Lịch sử hoạt động</b></a></li>
  		</ul>
	  	<div class="tab-content">
	      	<div id="info_user" class="tab-pane">
		      	<span class="pull-right btn-create">
		            <a href="#" title="Chỉnh sửa thông tin nhân viên" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-success edit_modal_infor_user"><i class="glyphicon glyphicon-edit"></i></a>
		        </span>  
				<table class="table table-bordered table-edit-tab">
			        <tbody>
			            <tr>
			                <th class="th_table_ifno">Họ tên</th><td class="table_user_info-fullname"><?php echo $userinfo['fullname'] ?></td>
			                <th class="th_table_ifno">Email</th><td class="table_user_info-email"><?php echo $userinfo['email'] ?></td>
			                <th class="th_table_ifno">Số điện thoại</th><td class="table_user_info-phone"><?php echo $userinfo['phone'] ?></td>
			            </tr>
			            <tr>
			                <th class="th_table_ifno">Giới tính</th><td class="table_user_info-sex"><?php 
			                if ($userinfo['sex'] == '1') {
			                	echo 'Nam';
			                }elseif ($userinfo['sex'] == '2') {
			                	echo "Nữ";
			                }elseif($userinfo['sex'] == '3'){
			                	echo "Khác";
			                	} ?></td>
			                <th class="th_table_ifno">Ngày sinh</th><td class="table_user_info-birthday" colspan="3"><?php echo $birthday_user ?></td>

			            </tr>
			            <tr>
			                <th class="th_table_ifno">Chứng minh thư nhân dân</th><td class="table_user_info-cmnd"><?php echo $userinfo['cmnd'] ?></td>
			                <th class="th_table_ifno">Ngày cấp</th><td class="table_user_info-provision_day"><?php echo $provision_day_user ?></td>
			                <th class="th_table_ifno">Nơi cấp </th><td class="table_user_info-provision_place"><?php echo $userinfo['provision_place'] ?></td>
			            </tr>
			            <tr>
			            	<th class="th_table_ifno" >Quê quán</th><td class="table_user_info-homeland" colspan="5"><?php echo $userinfo['homeland'] ?></td>
			            </tr> 
			           <tr>
			                <th class="th_table_ifno">Địa chỉ</th><td class="table_user_info-address" colspan="5"><?php echo $userinfo['address'] ?></td>
			            </tr>
			        </tbody>
			    </table>
		    </div>
		    <!-- end tab info -->
	      	<div id="agency" class="tab-pane">
				<p class="title_info_role"> <b>Danh sách đại lý</b>
				<div class="margin-top-bot"> <button class="btn btn-primary add_new_agency_info">Thêm mới</button> </div>
			    <table id="list_agency_user" class="list_info_user table table-bordered table-edit-tab list_agency_user_class"></table>
			  
		    </div>
		    <!-- end tab egency -->
		    
	      	<div id="cooperator" class="tab-pane">
				<p class="title_info_role"> <b>Danh sách cộng tác viên</b>
				<div class="margin-top-bot"> <button class="btn btn-primary add_new_cooperator_info">Thêm mới</button> </div>
			    <table id="list_cooperator_user" class="list_info_user table table-bordered table-edit-tab list_cooperator_user"></table>
			  
		    </div>
		    <!-- end tab cooperator -->

		    <div id="role_user" class="tab-pane">
		    	<p class="title_info_role"> <b>Vai trò người dùng:</b> <label class="label label-success"></label><?= $role_user ?></p>
			    <table id="list_permission_user" class="list_info_user table table-bordered table-edit-tab"></table>
			    
		    </div>
		    <!-- end tab role user -->
		</div>
	</div>
</div>


<div class="modal fade show_user_info_modal" id="confirm_delete_modal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:20px 20px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 style="text-align: center; font-size: 20;"><span class="glyphicon glyphicon-edit" ></span> Chỉnh sửa thông tin người dùng</h4>
            </div>
            
            <div class="modal-body">
            	<div class="user-form">
					<form id="user_form" action="#" method="post" enctype="multipart/form-data" >
						<input type="hidden" name="_csrf" value="dHpaczc2Y3YFNyI6AgIhDgYUE0JlXBYZGSkuHUBROQ8BNwojRAcAKQ==">  

						<div class="padding-left-0 form-group field-user-fullname required col-xs-6">
							<label class="control-label" for="">Họ tên<span class="required_data"> *</span></label>
							<span class="pop_show_hide_fullname">
							<input type="text" id="fullname" class="form-control my_fullname btn-open-popover" name="user_info[fullname]" value="" required="" aria-required="true" >
							</span>
							<div id="has-error-fullname" class="help-block has-error has-error-fullname hide"></div>
						</div>
						<div class="form-group field-user-email required col-xs-6 padding-right-0">
							<label class="control-label" for="email">Email<span class="required_data"> *</span></label>
							<span class="pop_show_hide_email">
							<input type="email" id="user_email" class="form-control my_email" name="user_info[email]" value="" required="" aria-required="true">
							</span>
							<div id="has-error-email" class="help-block has-error has-error-email hide"></div>
						</div>
						<div class="col-xs-12">
							<div class="col-xs-4 padding-left-0 field-nhanvien-gioi_tinh">
								<label class="control-label">Giới tính<span class="required_data"> *</span></label>
								<input type="hidden" name="user_info[sex]" id="user_info-gioi_tinh"  value="">
								<div class="radio-bton">
								<label>
									<input type="radio" name="user_info_sex" value="1" id="radio_user_man" checked=""> Nam
								</label>
								<label>
									<input type="radio" name="user_info_sex" value="2" id="radio_user_won" > Nữ
								</label>
								<label>
									<input type="radio" name="user_info_sex" value="3" id="radio_user_les"> Khác
								</label>
								</div>
								<div class="help-block"></div>
							</div>
							<div class="col-xs-4 padding-right-0  field-user-birthday">
								<?php  echo '<label class="control-label">Ngày sinh</label>';
									echo DatePicker::widget([
									    'name' => 'user_info[birthday]',
									    'type' => DatePicker::TYPE_COMPONENT_APPEND,
									    'options' => [
											'value' => '',
											'placeholder' => '--- Lựa chọn ngày ---',
											'id' => 'user_birthday',
											],
									    'language' => 'en',
									    'pluginOptions' => [
									        'autoclose'=>true,
									        'format' => 'dd-mm-yyyy'
									    ]
									]);
								   ?>
							</div>
							<div class="col-xs-4 padding-right-0 field-user_infor-phone required">
								<label class="control-label" for="user_infor-phone">Số điện thoại</label>
								<input type="text" id="user_infor-phone" class="form-control" name="user_info[phone]" value="" aria-required="true">

								<div id="has-error-phone" class="help-block has-error has-error-phone hide"></div>
							</div>
						</div>
						<div class="col-xs-4 padding-left-0 field-user_infor-cmnd required">
							<label class="control-label" for="user_infor-cmnd">Số chứng minh nhân dân</label>
							<input type="text" id="user_infor-cmnd" class="form-control" name="user_info[cmnd]" value="" aria-required="true">

							<div id="has-error-cmnd" class="help-block has-error has-error-cmnd hide"></div>
						</div>
						<div class="col-xs-4 field-user_infor-provision_place required">
							<label class="control-label" for="user_infor-provision_place">Nơi cấp</label>
							<input type="text" id="user_infor-provision_place" class="form-control" name="user_info[provision_place]" value="" aria-required="true">

							<div class="help-block"></div>
						</div>

						<div class="col-xs-4 padding-right-0  field-user-provision_day">
							<?php  echo '<label class="control-label">Ngày cấp</label>';
								echo DatePicker::widget([
								    'name' => 'user_info[provision_day]',
								    'type' => DatePicker::TYPE_COMPONENT_APPEND,
								    'options' => [
										'value' => '',
										'placeholder' => '--- Lựa chọn ngày ---',
										'id' => 'user_provision_day',
										],
								    'language' => 'en',
								    'pluginOptions' => [
								        'autoclose'=>true,
								        'format' => 'dd-mm-yyyy'
								    ]
								]);
							   ?>
						</div>
						
						<div class="col-xs-12 padding-right-0 padding-left-0 form-group field-user-town required">
							<label class="control-label" for="">Quê quán</label>
							<input type="text" id="user_town" class="form-control my_town" name="user_info[town]" value="" >
							<div class="help-block"></div>
						</div>
						<div class="col-xs-12 padding-right-0 padding-left-0 form-group field-user-address required">
							<label class="control-label" for="">Địa chỉ</label>
							<input type="text" id="user_address" class="form-control my_address" name="user_info[address]" value="">
							<div class="help-block"></div>
						</div>
					
						<div class="form-group pull-right">
					        <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button> 
							<span>&nbsp;</span>
					        <button type="button" class="btn btn-primary confirm_save_btn">Cập nhật</button>  
					    </div>
					</form>
				</div>
        	</div>
        	<div class="modal-footer"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
    	$("#datepicker").datepicker();
        $(".edit_modal_infor_user").click(function(){
            $("#confirm_delete_modal").modal();
            var id = '<?php echo $user_id ?>';
            load_info_user_update(id);
        })
        function validateEmail(email) {
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
		}
		function load_info_user_update(id){
			$.ajax({
	            method: "POST",
	            url: '<?php echo $base_url ?>users/user/get_info_user_byid',
	            data: { 'id' : id },
	            async: true,
	            success: function(result) {
		            if (result != '') {
		            	var user = jQuery.parseJSON(result);
		                $("#fullname").val(user[0]['fullname']);
		                $("#user_email").val(user[0]['email']);
		                $("#user_infor-phone").val(user[0]['phone']);
		                $("#user_infor-cmnd").val(user[0]['cmnd']);
		                $("#user_infor-provision_place").val(user[0]['provision_place']);
		                $("#user_infor-user_town").val(user[0]['homeland']);
		                $("#user_infor-user_address").val(user[0]['address']);
		                if (user[0]['sex'] == '1') {
		                	$('#radio_user_man').prop('checked',true);
		                }else if(user[0]['sex'] == '2'){
		                	$('#radio_user_won').prop('checked',true);
		                }else{
		                	$('#radio_user_les').prop('checked',true);
		                }

		                if (user[0]['birthday'] == '0') {
		                	var birthday = '';
		                }else{
		                	var str = user[0]['birthday'].toString();
		                	var birthday = str.substr(6, 2) + '-' + str.substr(4, 2) + '-' + str.substr(0, 4);

		                }
		                $('#user_birthday').val(birthday);

		                if (user[0]['provision_day'] == '0') {
		                	var provision_day = '';
		                }else{
		                	var str = user[0]['provision_day'].toString();
		                	var provision_day = str.substr(6, 2) + '-' + str.substr(4, 2) + '-' + str.substr(0, 4);
		                }
		                $('#user_provision_day').val(provision_day);
	                }
	            },
	        });
		}
		function load_info_user(id){
			$.ajax({
	            method: "POST",
	            url: '<?php echo $base_url ?>users/user/get_info_user_byid',
	            data: { 'id' : id },
	            async: true,
	            success: function(result) {
	                var user = jQuery.parseJSON(result);
	                $('.table_user_info-fullname').html(user[0]['fullname']);
	                $('.table_user_info-email').html(user[0]['email']);
	                $('.table_user_info-cmnd').html(user[0]['cmnd']);
	                $('.table_user_info-provision_place').html(user[0]['provision_place']);
	                $('.table_user_info-phone').html(user[0]['phone']);
	                $('.table_user_info-address').html(user[0]['address']);
	                $('.table_user_info-homeland').html(user[0]['homeland']);
	                if (user[0]['sex'] == '1') {
	                	var sex  = 'Nam';
	                }else if(user[0]['sex'] == '2'){
	                	var sex  = 'Nữ';
	                }else{
	                	var sex = 'Khác'
	                }
	                $('.table_user_info-sex').html(sex);
	                if (user[0]['birthday'] == '0') {
	                	var birthday = '';
	                }else{
	                	var str = user[0]['birthday'].toString();
	                	var birthday = str.substr(6, 2) + '-' + str.substr(4, 2) + '-' + str.substr(0, 4);
	                }
	                $('.table_user_info-birthday').html(birthday);

	                if (user[0]['provision_day'] == '0') {
	                	var provision_day = '';
	                }else{
	                	var str = user[0]['provision_day'].toString();
	                	var provision_day = str.substr(6, 2) + '-' + str.substr(4, 2) + '-' + str.substr(0, 4);
	                }
	                $('.table_user_info-provision_day').html(provision_day);
	            },
	        });
		}
		// lưu info user
       	$(".confirm_save_btn").click(function(){
       		var user_id = '<?php echo $user_id ?>';
       		var fullname = $.trim($('#fullname').val());
       		var user_sex = $.trim($('input[name=user_info_sex]:checked').val());
       		var user_email = $.trim($('#user_email').val());
       		var user_birthday = $.trim($('#user_birthday').val());
       		var user_phone = $.trim($('#user_infor-phone').val());
       		var user_provision = $.trim($('#user_infor-cmnd').val());
       		var user_provision_place = $.trim($('#user_infor-provision_place').val());
       		var user_provision_day = $.trim($('#user_provision_day').val());
       		var user_town = $.trim($('#user_town').val());
       		var user_address = $.trim($('#user_address').val());

       		// validate data
       		// validate data
		    if (fullname  === '') { 
		    	$(".has-error-fullname").removeClass('hide');
		    	$(".has-error-fullname").text('Họ tên không được trống');
		        return false;
		    }else{
		    	$(".has-error-fullname").addClass('hide');
		    	$(".has-error-fullname").text('');
		    }

		    
		    if (user_email  === '') { 
		    	$(".has-error-email").removeClass('hide');
		    	$(".has-error-email").text('Email không được trống');
		        return false;
		    }else{
		    	$(".has-error-email").addClass('hide');
		    	$(".has-error-email").text('');
		    }
		    if (!validateEmail(user_email)) {
			  	$(".has-error-email").removeClass('hide');
		    	$(".has-error-email").text('Email không đúng định dạng');
		        return false;
			}else{
		    	$(".has-error-email").addClass('hide');
		    	$(".has-error-email").text('');
		    }
			var isnum = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test(user_phone);
		    if (user_phone  !== '' && !isnum)
		    {
		    	$(".has-error-phone").removeClass('hide');
		    	$(".has-error-phone").text('Số điện thoại không đúng định dạng');
		        return false;
		    }else{
		    	$(".has-error-phone").addClass('hide');
		    	$(".has-error-phone").text('');
		    }
		    var isnum_pro = /^\d+$/.test(user_provision);
		    if (user_provision  !== '' && !isnum_pro)
		    {
		    	$(".has-error-cmnd").removeClass('hide');
		    	$(".has-error-cmnd").text('Số chứng minh nhân dân phải là số');
		        return false;
		    }else{
		    	$(".has-error-cmnd").addClass('hide');
		    	$(".has-error-cmnd").text('');
		    }
		    $.ajax({
	            method: "POST",
	            url: '<?php echo $base_url ?>users/user/update_info_user',
	            data: { 'user_id' : user_id, 'fullname' : fullname, 'user_email' : user_email, 'user_sex' : user_sex, 'user_birthday' : user_birthday, 'user_phone' :  user_phone, 'user_provision' : user_provision, 'user_provision_place' : user_provision_place, 'user_provision_day': user_provision_day, 'user_address' : user_address, 'user_town' : user_town },
	            async: true,
	            success: function(result) {
	                load_info_user(result);
	                $('.show_user_info_modal').modal('hide');
	                $("#modal-success_update").modal("show");
		                window.setTimeout(function () {
		                  	$("#modal-success_update").modal("hide");
		            }, 2000);
	            },
	        });
     	});
  });
</script>
<div class="modal fade" id="modal-success_update" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header-success" >
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="text-success-modal"><span class="glyphicon glyphicon-ok"></span> Cập nhật thành công</h3>
            </div>
        </div>

    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
<?php 

$output = array();
foreach ($list_permission as $key => $value) {
	$temp = array();
	$temp = array_filter($temp);
	array_push($temp, $key+1);
	array_push($temp, $value['name']);
	array_push($temp, $value['description']);
	array_push($output, $temp);
}
$list_per_json =  json_encode($output, 128);
?>
<script>
var obj_per = <?php echo $list_per_json; ?>;
$(document).ready(function() {
    $('#list_permission_user').DataTable( {
        data: obj_per,
        columns: [
            { 
            	title: "STT",
            	className: "stt_view_list_per",
        	},
            { 
            	title: "Mã quyền",
            	className:"code_view_list_per",
            },
            { title: "Tên quyền" },
        ],
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            // "lengthMenu": "Xem _MENU_ bản ghi",
   //          "zeroRecords": "Không có bản ghi",
   //          "info": "Hiển thị trang _PAGE_ trên _PAGES_ trang",
   //          "infoEmpty": "Không có bản ghi",
   //          "infoFiltered": "(filtered from _MAX_ total records)",
   //          "search": "Tìm kiếm:",
   //          "oPaginate": {
			// 	"sFirst":    	"Đầu",
			// 	"sPrevious": 	"Trước",
			// 	"sNext":     	"Tiếp",
			// 	"sLast":     	"Cuối"
			// },
        }
    } );
} );
</script>

<?php 
// view danh sách đại lý
if ($list_agency_by_user) {
	$arr_agency = array();
	foreach ($list_agency_by_user as $key => $value) {
		$temp = array();
		$temp = array_filter($temp);
		array_push($temp, $key+1);
		array_push($temp, $value['account_code']);
		array_push($temp, $value['account_name']);
		array_push($temp, $value['contract']);
		array_push($temp, $value['prepaid']);
		array_push($temp, $value['postpaid']);
		array_push($temp, $value['id']);
		array_push($arr_agency, $temp);
	}
	$list_agency =  json_encode($arr_agency, 128);
}else{
	$list_agency = null;
}
?>

<!-- Modal show delete  egency-->
    <div class="modal fade" id="confirm_delete_agency_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:30px 25px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="text-align: center; font-size: 20;"><span class="glyphicon glyphicon-lock" ></span> Bạn có chắc chắn muốn xóa bản ghi ?</h4>
                </div>
                <div class="id_delete_agency_inmodal_div hide" ></div>
                <div class="modal-footer" style="margin-left: 30%; ">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button> 
                    <button type="button" id="confirm_delete_agency" class="btn btn-primary btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
                </div>
            </div>
        </div>
    </div>
<!-- modal add new agency for user -->
<div class="modal fade" id="modal_add_new_agency_user" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h3 class="modal-title text-center">Danh sách đại lý</h3>
        </div>
        <div class="modal-body">
        	<div class="id_user_add_agency_inmodal_div hide" ></div>
        	<div class=" content_body_modal_add_new" id="content_body_add_new">
        	 <?php \yii\widgets\Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'id' => 'list_agency_pjax',
                'summary' => "<div class='summary'>Hiển thị <b>{begin}</b> - <b>{end}</b> trên <b>{totalCount}</b> bản ghi<div>",
                'emptyText' => 'Không có bản ghi !',
                'columns' => [
	                [
		                'attribute' => 'account_code',
		                'format' => 'raw',
		                'label'=> 'Mã đại lý',
		                'headerOptions' => ['class' => 'text-center text-headerOptions'],
		                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
	                ],

	                [
		                'attribute' => 'account_name',
		                'format' => 'raw',
		                'label'=> 'Tên đại lý',
		                'headerOptions' => ['class' => 'text-center text-headerOptions'],
		                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
	                ], 

	                [
		                'attribute' => 'account_type',
		                'headerOptions' => ['class' => 'text-center text-headerOptions'],
		                'contentOptions' => ['class'=>'word-wrap-new', 'style'=>'width:30%;',],
		                'label'=> 'Loại đại lý',
		                'format'=>'raw',
		                'value'=>function($row){
		                    $values=[
		                        '1'=>'label label-success status_category'.$row['id'],
		                        '2'=>'label label-primary status_category'.$row['id'],
		                        '3'=>'label label-warnning status_category'.$row['id'],
		                    ];
		                    if ($row['account_type'] == '1 ') {
		                        $account_type = 'Đại lý';
		                    }else if($row['account_type'] == '2 ')
		                    {
		                        $account_type = 'Cộng tác viên';
		                    }
		                    else
		                    {
		                         $account_type = 'Kinh doanh';
		                    }
		                    return Html::tag('span', $account_type , ['class' => $values[$row['account_type']]]);
		                },
		            ],

	                [   
		                'class' => 'yii\grid\ActionColumn',
		                'template' => '{check}',
		                'header'=>'Chọn',
		                'headerOptions' => ['class' => 'text-center'],
		                'contentOptions' => ['class'=>'word-wrap-new text-center', 'style'=>'width:10%;',],
		                'buttons' => [
		                'check' => function ($url, $model) {
		                    return Html::checkbox(
		                      'span',
		                      '',
		                      ['class' => 'check_id_user', 'value' => $model['id'],'title' => 'Chọn người dùng']
		                      );
		                },
		                ],
	                ],

                ],

            ]);?>
		    </div>
        </div>
        <div class="modal-footer">
          	<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          	<button type="button" class="btn btn-primary submit_add_new_agency" data-dismiss="modal"  onclick="submit_add_new_agency();">Thêm mới</button>
        </div>
        <?php \yii\widgets\Pjax::end(); ?>
      </div>
      
    </div>
</div>

<?php 
// view danh sách cộng tác viên
if ($list_cooperator_by_user) {
	$arr_cooperator = array();
	foreach ($list_cooperator_by_user as $key => $value) {
		$temp = array();
		$temp = array_filter($temp);
		array_push($temp, $key+1);
		array_push($temp, $value['account_code']);
		array_push($temp, $value['account_name']);
		array_push($temp, $value['contract']);
		array_push($temp, $value['prepaid']);
		array_push($temp, $value['postpaid']);
		array_push($temp, $value['id']);
		array_push($arr_cooperator, $temp);
	}
	$list_cooperator =  json_encode($arr_cooperator, 128);
}else{
	$list_cooperator = null;
}
?>
<script>
<?php if($list_cooperator){ ?>
	var obj_cooperator = <?php echo $list_cooperator ?>;
<?php }else{ ?> 
	var obj_cooperator = '';
<?php } ?>
$(document).ready(function() {
	var table_co;
	$.fn.dataTable.ext.errMode = 'none';
	var rowNode_co;
    var table_co = $('#list_cooperator_user').DataTable( {
        data: obj_cooperator,
       
        columns: [
            { 
            	title: "STT",
            	className: "stt_view_list_per",
        	},
            { 
            	title: "Mã CTV",
            },
            { title: "Tên CTV" },
            { title: "Số hợp đồng" },
            { title: "Số tiền dư" },
            { title: "Số tiền nợ" },
            {
            	title: "",
            	data: null,
            	defaultContent: "<button class='btn btn-danger btn-default pull-left'>Xóa</button>"
            }
        ],
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
        }
    });

    $('#list_cooperator_user tbody').on( 'click', 'button', function () {
        var data = table_co.row( $(this).parents('tr') ).data();
        rowNode_co = $(this).parents('tr');
        var id_acc_asign_new = data[1];
        $("#confirm_delete_cooperator_modal").modal();
        $('.id_delete_cooperator_inmodal_div').empty().append(id_acc_asign_new);
    });

	// xử lý thêm mới cộng tác viên
		
	$('.add_new_cooperator_info').click(function(){
		var user_add_id = '<?php echo $user_id ?>';
		$("#modal_add_new_cooperator_user").modal();
	    $('.id_user_add_cooperator_inmodal_div').empty().append(user_add_id);
	    $.ajax({
	        method: "POST",
	        url: '<?php echo $base_url ?>users/user/get_list_cooperator_assign',
	        data: { 'user_add_id' : user_add_id},
	        async: true,
	        success: function(result) {
	        	var list_agency = JSON.parse(result);
	        	$('.content_body_add_new_co').empty();
				for (index in list_agency) {
				    var value_id = list_agency[index]['id'];
				    var value_name = list_agency[index]['account_name'];
				    $('.content_body_add_new_co').append('<div class="class_element_new"><label class="checkbox-inline checkbox-info"> <input type="checkbox" value="'+value_id+'"> '+value_name+' </label> </div>');
				}
	        },
	    });
	});
	// submit thêm mới cộng tác viên cho user
	$('.submit_add_new_cooperator').click(function(){
		var user_id = '<?php echo $user_id ?>';
		var copper_list = [];
        $('.content_body_add_new_co input:checked').each(function() {
            copper_list.push($(this).val());
        });
        if (copper_list.length != 0) {
        	$.ajax({
	            method: "POST",
	            url: '<?php echo $base_url ?>users/user/assign_cooperator_user',
	            data: { 
	            	'names' : copper_list,
	            	'user_id' : user_id
	        	},
	        	dataType: "json",
	            async: true,
	            success: function(result) {
			        var obj =  JSON.parse(result);
			        $.each(obj,function(index, value){
			        	if (value[0] == 1) {
			        		table = $('#list_cooperator_user').DataTable( {
						        data: null,
						       
						        columns: [
						            { 
						            	title: "STT",
						            	className: "stt_view_list_per",
						        	},
						            { 
						            	title: "Mã CTV",
						            },
						            { title: "Tên CTV" },
						            { title: "Số hợp đồng" },
						            { title: "Số tiền dư" },
						            { title: "Số tiền nợ" },
						            {
						            	title: "",
						            	data: null,
						            	defaultContent: "<button  class='btn btn-danger btn-default pull-left'>Xóa</button>"
						            }
						        ],
						        "language": {
						        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
						        }
						    });
						    var t = $('#list_cooperator_user').DataTable();
					       	t.row.add( [
					            value[0],
					            value[1],
					            value[2],
					            value[3],
					            value[4],
					            value[5],
					        ] ).draw( false );
			        	}else{
			        		var t = $('#list_cooperator_user').DataTable();
					       	t.row.add( [
					            value[0],
					            value[1],
					            value[2],
					            value[3],
					            value[4],
					            value[5],
					        ] ).draw( false );
					        $('#list_cooperator_user tbody').on( 'click', 'button', function () {
						       	var data = table_co.row( $(this).parents('tr') ).data();
						        rowNode_co = $(this).parents('tr');
						        var id_acc_asign_new = data[1];
						        $("#confirm_delete_cooperator_modal").modal();
						        $('.id_delete_cooperator_inmodal_div').empty().append(id_acc_asign_new);
						    });
			        	}
					});
	            },
	        });
        }
	});

	//submit delete
	$('#confirm_delete_cooperator').click(function(){
        var code_delete = $('.id_delete_cooperator_inmodal_div').text();
        var user_id = '<?php echo $user_id ?>';
        $.ajax({
            method: "POST",
            url: '<?php echo $base_url ?>users/user/delete_accout_assign_new',
            data: { 'id_delete' : code_delete,
            		'user_id' : user_id
        			},
            async: true,
            success: function(result) {
            	table_co.row(rowNode_co).remove().draw(false);
            },
        });
    });
});

</script>
<!-- Modal show delete  egency-->
    <div class="modal fade" id="confirm_delete_cooperator_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:30px 25px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 style="text-align: center; font-size: 20;"><span class="glyphicon glyphicon-lock" ></span> Bạn có chắc chắn muốn xóa bản ghi ?</h4>
                </div>
                <div class="id_delete_cooperator_inmodal_div hide" ></div>
                <div class="modal-footer" style="margin-left: 30%; ">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Đóng</button> 
                    <button type="button" id="confirm_delete_cooperator" class="btn btn-primary btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
                </div>
            </div>
        </div>
    </div>
   	<!-- modal add new cooperator for user -->
	<div class="modal fade" id="modal_add_new_cooperator_user" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Danh sách cộng tác viên</h4>
	        </div>
	        <div class="modal-body">
	        	<div class="id_user_add_cooperator_inmodal_div hide" ></div>
	        	<div class="content_body_add_new_co content_body_modal_add" id="content_body_add_new_co">
			    </div>
	        </div>
	        <div class="modal-footer">
	          	<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
	          	<button type="button" class="btn btn-primary submit_add_new_cooperator" data-dismiss="modal">Thêm mới</button>
	        </div>
	      </div>
	      
	    </div>
	</div>

<script>
	<?php if($list_agency){ ?>
		var obj_agency = <?php echo $list_agency ?>;
	<?php }else{ ?> 
		var obj_agency = '';
	<?php } ?>
$(document).ready(function() {
	var table;
	$.fn.dataTable.ext.errMode = 'none';
	var rowNode;
    var table = $('#list_agency_user').DataTable( {
        data: obj_agency,
       
        columns: [
            { 
            	title: "STT",
            	className: "stt_view_list_per",
        	},
            { 
            	title: "Mã đại lý",
            },
            { title: "Tên đại lý" },
            { title: "Số hợp đồng" },
            { title: "Số tiền dư" },
            { title: "Số tiền nợ" },
            {
            	title: "",
            	data: null,
            	defaultContent: "<button class='btn btn-danger btn-default pull-left'>Xóa</button>"
            }
        ],
        "language": {
        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
        }
    });

    $('#list_agency_user tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        rowNode = $(this).parents('tr');
        var id_acc_asign = data[1];
        $("#confirm_delete_agency_modal").modal();
        $('.id_delete_agency_inmodal_div').empty().append(id_acc_asign);
    });
   


	//xử lý thêm mới đại lý
	
	$('.add_new_agency_info').click(function(){
		var user_add_id = '<?php echo $user_id ?>';
		$("#modal_add_new_agency_user").modal();
    //     $('.id_user_add_agency_inmodal_div').empty().append(user_add_id);
    //     $.ajax({
    //         method: "POST",
    //         url: '<?php echo $base_url ?>users/user/get_list_agency_assign',
    //         data: { 'user_add_id' : user_add_id},
    //         async: true,
    //         success: function(result) {
    //         	var list_agency = JSON.parse(result);
    //         	$('.content_body_add_new').empty();
				// for (index in list_agency) {
				//     var value_id = list_agency[index]['id'];
				//     var value_name = list_agency[index]['account_name'];
				//     $('.content_body_add_new').append('<div class="class_element_new"><label class="checkbox-inline checkbox-info"> <input class"checkbox-info" type="checkbox" value="'+value_id+'"> '+value_name+' </label> </div>');
				// }
    //         },
    //     });
	});
	// submit thêm mới đại lý cho user
	$('.submit_add_new_agency').click(function(){
		var user_id = '<?php echo $user_id ?>';
		var names = [];
        $('#content_body_add_new input:checked').each(function() {
            names.push($(this).val());
        });
        console.log(names);
     //    if (names.length != 0) {
     //    	$.ajax({
	    //         method: "POST",
	    //         url: '<?php echo $base_url ?>users/user/assign_agency_user',
	    //         data: { 
	    //         	'names' : names,
	    //         	'user_id' : user_id
	    //     	},
	    //     	dataType: "json",
	    //         async: true,
	    //         success: function(result) {
			  //       var obj =  JSON.parse(result);
			  //       $.each(obj,function(index, value){
			  //       	if (value[0] == 1) {
			  //       		table = $('#list_agency_user').DataTable( {
					// 	        data: null,
						       
					// 	        columns: [
					// 	            { 
					// 	            	title: "STT",
					// 	            	className: "stt_view_list_per",
					// 	        	},
					// 	            { 
					// 	            	title: "Mã đại lý",
					// 	            },
					// 	            { title: "Tên đại lý" },
					// 	            { title: "Số hợp đồng" },
					// 	            { title: "Số tiền dư" },
					// 	            { title: "Số tiền nợ" },
					// 	            {
					// 	            	title: "",
					// 	            	data: null,
					// 	            	defaultContent: "<button  class='btn btn-danger btn-default pull-left'>Xóa</button>"
					// 	            }
					// 	        ],
					// 	        "language": {
					// 	        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
					// 	        }
					// 	    });
					// 	    var t = $('#list_agency_user').DataTable();
					//        	t.row.add( [
					//             value[0],
					//             value[1],
					//             value[2],
					//             value[3],
					//             value[4],
					//             value[5],
					//         ] ).draw( false );
			  //       	}else{
			  //       		var t = $('#list_agency_user').DataTable();
					//        	t.row.add( [
					//             value[0],
					//             value[1],
					//             value[2],
					//             value[3],
					//             value[4],
					//             value[5],
					//         ] ).draw( false );
					//         $('#list_agency_user tbody').on( 'click', 'button', function () {
					// 	        var data = t.row( $(this).parents('tr') ).data();
					// 	        rowNode = $(this).parents('tr');
					// 	        var id_acc_asign = data[1];
					// 	        $("#confirm_delete_agency_modal").modal();
					// 	        $('.id_delete_agency_inmodal_div').empty().append(id_acc_asign);
					// 	    });
			  //       	}
					// });
					// // $.pjax({container: '#list_agency_pjax'});
					// // $.pjax.reload({container: '#list_agency_pjax'});
					// $('#list_agency_pjax').yiiGridView('applyFilter');
	    //         },
	    //     });
     //    }
	});

	//submit delete
	$('#confirm_delete_agency').click(function(){
        var id_delete = $('.id_delete_agency_inmodal_div').text();
        var user_id = '<?php echo $user_id ?>';
        $.ajax({
            method: "POST",
            url: '<?php echo $base_url ?>users/user/delete_accout_assign',
            data: { 'id_delete' : id_delete,
            		'user_id' : user_id
        			},
            async: true,
            success: function(result) {
            	table.row(rowNode).remove().draw(false);
            	$('#list_agency_pjax').yiiGridView('applyFilter');
            },
        });
    });


});
	
</script>
<script type="text/javascript">
	 function submit_add_new_agency()
    {
    	var user_id = '<?php echo $user_id ?>';
		var names = [];
        $('#content_body_add_new input:checked').each(function() {
            names.push($(this).val());
        });
        console.log(names);
        if (names.length != 0) {
        	$.ajax({
	            method: "POST",
	            url: '<?php echo $base_url ?>users/user/assign_agency_user',
	            data: { 
	            	'names' : names,
	            	'user_id' : user_id
	        	},
	        	dataType: "json",
	            async: true,
	            success: function(result) {
			        var obj =  JSON.parse(result);
			        $.each(obj,function(index, value){
			        	if (value[0] == 1) {
			        		table = $('#list_agency_user').DataTable( {
						        data: null,
						       
						        columns: [
						            { 
						            	title: "STT",
						            	className: "stt_view_list_per",
						        	},
						            { 
						            	title: "Mã đại lý",
						            },
						            { title: "Tên đại lý" },
						            { title: "Số hợp đồng" },
						            { title: "Số tiền dư" },
						            { title: "Số tiền nợ" },
						            {
						            	title: "",
						            	data: null,
						            	defaultContent: "<button  class='btn btn-danger btn-default pull-left'>Xóa</button>"
						            }
						        ],
						        "language": {
						        	"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
						        }
						    });
						    var t = $('#list_agency_user').DataTable();
					       	t.row.add( [
					            value[0],
					            value[1],
					            value[2],
					            value[3],
					            value[4],
					            value[5],
					        ] ).draw( false );
			        	}else{
			        		var t = $('#list_agency_user').DataTable();
					       	t.row.add( [
					            value[0],
					            value[1],
					            value[2],
					            value[3],
					            value[4],
					            value[5],
					        ] ).draw( false );
					        $('#list_agency_user tbody').on( 'click', 'button', function () {
						        var data = t.row( $(this).parents('tr') ).data();
						        rowNode = $(this).parents('tr');
						        var id_acc_asign = data[1];
						        $("#confirm_delete_agency_modal").modal();
						        $('.id_delete_agency_inmodal_div').empty().append(id_acc_asign);
						    });
			        	}
					});
					// $.pjax({container: '#list_agency_pjax'});
					// $.pjax.reload({container: '#list_agency_pjax'});
					$('#list_agency_pjax').yiiGridView('applyFilter');
	            },
	        });
        }
    }
</script>