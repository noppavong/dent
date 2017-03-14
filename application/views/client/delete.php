<style>

.form-group .row div{
	text-align: right;
	vertical-align: center;
}
.form-group .row label{
	line-height: 34px;
}

</style>
<section class="content-header">
<ul class="nav nav-pills">
	  <li role="presentation"><a href="<?= base_url() ?>clients">ค้นหาคนไข้</a></li>
	  <li role="presentation"><a href="<?= base_url() ?>client/create" >เพิ่มคนไข้</a></li>
	  <li role="presentation"  class="active"><a href="<?= base_url() ?>client/delete">ลบคนไข้</a></li>
	  <li role="presentation"><a href="<?= base_url() ?>client/edit">ข้อมูลคนไข้</a></li>
</ul>
</section>
<div class="col-xs-12">
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ลบคนไข้</h3>
	</div>
	<div class="box-body">
		<form id="formElem" name="formElem" action="<?= base_url() ?>clients/" method="post">
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="surnamethai">หมายเลข HN</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="hn" name="hn" class="form-control" value="<?= set_value('hn') ?>"  >
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2"  >
						<label  for="namethai" >ชื่อ</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="name_thai" name="name_thai" class="form-control"  value="<?= set_value('name_thai') ?>"  placeholder="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="surnamethai">นามสกุล</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="surname_thai" name="surname_thai" value="<?= set_value('surname_thai') ?>"  class="form-control" >
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="surnamethai">เบอร์ติดต่อ</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="phone_no" name="phone_no" value="<?= set_value('phone_no') ?>"  class="form-control" >
					</div>
				</div>
			</div>
			
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา </button>
		</form>
	</div>
</div>

<div class="box">

	<div class="box-body">
		<form id="formElement" method="post" action="<?=base_url() ?>client/delete">
		  <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th><input type='checkbox' id="checka" name="check" onclick="checkAll();" value="" ></th>
                  <th>หมายเลข HN</th>
                  <th>ชื่อ-นามสกุล</th>
                  <th>ชื่อเล่น</th>
                  <th>เบอร์ติดต่อ</th>
                  <th>สถานะ</th>
                </tr>
                </thead>
                <tbody>
                	<?php foreach ($client->result_array() as $row) { ?>
                		<tr>
                			<th><input type='checkbox' name='delete_id[]' class="delete-checkbox" value="<?=$row['client_id'] ?>"></th>
                			<td><?=$row['hn'] ?></td>
                			<td><?=$row['name_thai'] ?>   <?=$row['surname_thai'] ?></td>
                			
                			<td><?=$row['nickname'] ?></td>
                			<td><?=$row['phone_no'] ?></td>
                			<td><?=($row['status']=="I")?"ไม่เคลื่อนไหว":"ผู้ป่วย" ?></td>
                		</tr>
                	<?php }?>
                </tbody>
	         </table>
	         <button type="submit" class="btn btn-danger" > ลบ </button>
	     </form>
	</div>
</div>
</div>
<script type="text/javascript" >

	 $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	 function checkAll()
	 {
		if($('#checka').is(':checked')){
				$('.delete-checkbox').attr('checked',true);
				$('.delete-checkbox').prop('checked',true);
		}else{

				$('.delete-checkbox').attr('checked',false);
				$('.delete-checkbox').prop('checked',false);
		}
	 }
</script>
		<!-- /.box-header -->