<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\users\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\User */

$this->title = 'Xem chi tiết người dùng';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$Users = new User();
if($model->create_user_id){
    $name_creater = $Users->get_user_name($model->create_user_id);
}
else
{
    $name_creater = '';
}
if($model->update_user_id){
    $name_editer = $Users->get_user_name($model->update_user_id);
}
else
{
    $name_editer = '';
}

$arr = [
    ['id' => '1', 'name' => 'Kinh doanh - NCC'],
    ['id' => '2', 'name' => 'Người dùng - NCC'],
    ['id' => '3', 'name' => 'Đại lý'],
    ['id' => '4', 'name' => 'Cộng tác viên'],
];
if ($model->type) {
    $type =  $arr[$model->type-1]['name'];
}else{
    $type = '';
}

$arr_login = [
    ['id' => '1', 'name' => 'Mật khẩu'],
    ['id' => '2', 'name' => 'Chứng thư số'],
];
if ($model->type_login) {
    $type_login = $arr_login[$model->type_login-1]['name'];
}else{
    $type_login = '';
}

$values=[
    '2'=>'label label-warning status_category'.$model['id'],
    '1'=>'label label-success status_category'.$model['id'],
    '3'=>'label label-danger status_category'.$model['id'],
];
if ($model['status'] == '1 ') {
    $status_name = 'Hoạt động';
}elseif($model['status'] == '2')
{
    $status_name = 'Tạm dừng';
}else{
    $status_name = 'Khóa';
}
$status = Html::tag('span', $status_name , ['class' => $values[$model['status']]]);
?>

<div class="user-view col-md-12" style="margin-left: 0%; margin-top:10px; padding: 20px;">
    
    <fieldset style="border: 1px solid #0093DD; border-radius: 10px; ">
    <legend style="text-align: center;  color: #0093DD; font-size: 15px;border-bottom: 0px; width: auto;"><h3 class="add-color-content-header"><?= Html::encode($this->title) ?></h3></legend>
    <div class="col-md-12" >
   
    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <tr>
                <th>Tên đăng nhập</th><td><?php echo $model->username ?></td>
                <th>Tên hiển thị</th><td><?php echo $model->userdisplay ?></td>
            </tr>
            <tr>
                <th>Trạng thái </th><td><?php echo $status ?></td>
            </tr>
            <tr>
                <th>Thời gian tạo</th><td><?php echo date('d-m-Y', $model->created_at); ?></td>
                <th>Người tạo</th><td><?php echo $name_creater ?></td>
            </tr>
            <tr>
                <th>Thời gian cập nhật</th><td><?php echo date('d-m-Y', $model->updated_at); ?></td>
                <th>Người cập nhật</th><td><?php echo $name_editer ?></td>
            </tr>
        </tbody>
    </table>
    </div>
    <hr class="hr_inform">
    <div class="col-md-12">
        <div class="form-group pull-right ">
            <p>
               <?= Html::a('Cập nhật', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

               <?= Html::a('Trở lại', ['index'], ['class' => 'btn btn-default']) ?>
            </p>
        </div>
    </div>
    <?= $this->render('info', [
        'user_id' => $model->id,
        // 'type' => $model->type,
    ]) ?>
    </fieldset> 
</div>
