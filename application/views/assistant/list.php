<style>

.form-group .row div{
	text-align: right;
	vertical-align: center;
}
.form-group .row label{
	line-height: 34px;
}

</style>
<div class="col-xs-12">
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ค้นหาผู้ช่วย</h3>
	</div>
	<div class="box-body">
		<form id="formElem" name="formElem" action="<?= base_url() ?>assistants/" method="post">
			
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2"  >
						<label  for="name" >ชื่อ</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="name" name="name" class="form-control" value="<?php echo set_value('name') ?>" placeholder="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="surname">นามสกุล</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="surname" name="surname" class="form-control"  value="<?php echo set_value('surname') ?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="phone_no">เบอร์ติดต่อ</label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="phone_no" name="phone_no" class="form-control" value="<?php echo set_value('phone_no') ?>">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-2">
						<label for="phone_no">วันที่</label>
					</div>
					<input type='hidden' name="date"  id="date" value="<?php echo set_value('date') ?>"/>
					<div class="col-sm-3 date" data-provider="inline"> 

					</div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา </button>

			<a href="<?= base_url()?>client/" class="btn btn-primary"><i class="fa fa-plus-square"></i> เพิ่ม </a>
		</form>
	</div>
</div>

<div class="box">

	<div class="box-body">
		  <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ชื่อ-นามสกุล</th>
                  <th>เบอร์ติดต่อ</th>
                  <th>สถานะ</th>
                </tr>
                </thead>
                <tbody>
                	<?php foreach ($assistants->result_array() as $row) { ?>
                		<tr>
                			<td><a href="<?php echo base_url() ?>assistant/edit/<?=$row['assistant_id']?>"><?=$row['name'] ?>   <?=$row['surname'] ?></a></td>
                			
                			<td><?=$row['phone_no'] ?></td>
                			<td><?=($row['working_status']=="A")?"ทำงาน":"ยกเลิก" ?></td>
                		</tr>
                	<?php }?>
                </tbody>
         </table>
	</div>
</div>
</div>
<script type="text/javascript" >
Date.prototype.yyyymmdd = function() {
  var mm = this.getMonth() + 1; // getMonth() is zero-based
  var dd = this.getDate();

  return [this.getFullYear(), !mm[1] && '-', mm, !dd[1] && '-', dd].join(''); // padding
};

	 $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
	 var date = $('#date').val();
	 if(date){
	 	var arrdt = date.split('-');
	 $('.date').datepicker({
	    toggleActive: true
	}).on('changeDate', function (ev) {
    $('#date').val(ev.date.yyyymmdd());

    $('.date').datepicker('setDate', new Date(arrdt[0], arrdt[1], arrdt[2]));
		$('.date').datepicker('update');
	 }else{
	 	 $('.date').datepicker({
	    toggleActive: true
	}).on('changeDate', function (ev) {
    $('#date').val(ev.date.yyyymmdd());
	 }
});
</script>
		<!-- /.box-header -->