<div>
<div class="col-xs-12">
	<div class="col-xs-4">Mẫu.../QĐ-01</div>
</div>
	<div class="report-title text-center"><h2>Báo cáo 02</h2></div>

	<div class="help-block col-xs-12"></div>

	<div class="col-xs-12 text-center">
		<div>Từ ngày................Đến ngày.....................</div>
	</div>

	<div class="help-block col-xs-12"></div>

	<div class="col-xs-12 list-unstyled">
		<div >Cửa hàng:..........................................</div>
	</div>
	<div class="col-xs-12 list-unstyled">
		<div >Địa chỉ:...............................................</div>
	</div>
	<div class="help-block col-xs-12"></div>
	<div class="data">
		<table class="table table-striped table-bordered">
			<thead class="thead-inverse">
				<tr>
					<td rowspan="2" class="text-center"><b>Mã tỉnh thành</b></td>
					<td rowspan="2" class="text-center"><b>Tên tỉnh thành</b></td>
					<td colspan="2" class="text-center"><b>Giá trị</b></td>
					<td rowspan="2" class="col-xs-2"><b>Tổng</b></td>
				</tr>
				<tr>
					<td><b>Giá trị 1</b></td>
					<td><b>Giá trị 2</b></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="5"><b>nam</b></td>
				</tr>
				<?php 
					foreach ($data as $key => $value) {
						?>
							<tr>
								<td><?php echo $value['code'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td></td>
							</tr>

						<?php
					}
				?>
				<tr>
					<td colspan="5"><b>Nữ</b></td>
				</tr>
				<?php 
					foreach ($data as $key => $value) {
						?>
							<tr>
								<td><?php echo $value['code'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td><?php echo $value['name'] ?></td>
								<td></td>
							</tr>

						<?php
					}
				?>
			</tbody>
	
			<tfoot>
				<tr>
					<td colspan="4"><b>Tổng cộng</b></td>
					<td>value tổng</td>
				</tr>
			</tfoot>
			
			
		</table>
	</div>
</div>
