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
 <ul class="nav nav-pills">
    <li role="presentation" class="active"><a href="<?= base_url() ?>labs">ค้นหางานแล็บ</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>lab/name" >เพิ่มชื่อแล็บ</a></li>
    <li role="presentation"><a href="<?= base_url() ?>lab/servicename">เพิ่มชื่อบริการ</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>lab/edit">ข้อมูลแล็บ</a></li>
</ul>
		<script type="text/javascript" src="<?= base_url() ?>assets/js/script.js" ></script>
<div class="box">
	<div class="box-header with-border">
		<h3 class="box-title">ค้นหาผู้ป่วย</h3>
	</div>
	<div class="box-body">
		<form id="formElem" name="formElem" class="form-horizontal" action="<?= base_url() ?>lab/" method="post">
			<div class="form-group">
					
                      <label for="send_date" class="control-label col-sm-2" >วันที่ส่ง</label>
                      <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="send_date" class="form-control pull-right" data-date-format="dd-mm-yyyy" id="datepicker" value="<?=set_value('send_date',(isset($send_date))?date('d-m-Y',strtotime($send_date)):""); ?>">
                              </div>
                      
                      </div>
			</div>
			<div class="form-group">
						<label for="lab" class="control-label col-sm-2">ชื่อ แล๊บ</label>
					<div class="col-sm-4">
						 <select class="form-control select2" name="lab"   >
						 	<option value=""> ทั้งหมด </option>
                        <?php foreach ($labs->result_array() as $row){ ?>
                        <option value="<?= $row['lab_id'] ?>" <?php echo set_select('lab', $row['lab_id'], isset($title)?$row['lab_id']==$title:$row['lab_id']==""); ?>><?= $row['name']; ?></option>
                        <?php } ?>
                    </select>
					</div>
			</div>
			<div class="form-group">
            <label for="lab" class="control-label col-sm-2">ชื่อ ทันตแพทย์</label>
          <div class="col-sm-4">
             <select class="form-control select2" name="doctor"   >
              <option value=""> ทั้งหมด </option>
                        <?php foreach ($doctors->result_array() as $row){ ?>
                        <option value="<?= $row['doctor_id'] ?>"  <?php echo set_select('doctor', $row['doctor_id'], isset($title)?$row['doctor_id']==$title:$row['doctor_id']==""); ?>><?= $row['name']; ?></option>
                        <?php } ?>
                    </select>
          </div>
      </div>
      
			<div class="form-group">
						<label for="is_received"  class="control-label col-sm-2" >สถานะ</label>
					<div class="col-sm-4">
						<div class="checkbox">
                            <label>
                              <input name="is_received" type="checkbox" value="Y"   <?php  echo set_value('is_received', (isset($is_received))?$is_received:"") == "Y" ? "checked" : ""; ?> > ได้รับแล้ว
                            </label>
                          </div>
					</div>
			</div>
			
			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหา </button>

		</form>
	</div>
</div>

<div class="box">

	<div class="box-body">
		  <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>วันที่</th>
                  <th>ทันตแพทย์</th>
                  <th>คนไข้</th>
                  <th>รายการ</th>
                  <th>lab</th>
                  <th>ราคา</th>
                  <th>สถานะ</th>
                  <th> จัดการ </th>
                </tr>
                </thead>
                <tbody>
                	<?php foreach ($labts->result_array() as $row) { ?>
                		<tr>
                			<td><a  class="ajax-date" href="#" data-toggle="modal" data-target="#datemodal"  data-id="<?=date('d-m-Y',strtotime($row['send_date']))?>"><?=date('d-m-Y',strtotime($row['send_date']))?></a></td>
                			<td><a  class="ajax-doctor"  href="#" data-toggle="modal" data-target="#doctormodal" data-id="<?=$row['doctor_id']?>" data-name="<?= $row['doctor_name'].' '.$row['doctor_surname']; ?>"><?=$row['doctor_name'] ?> <?=$row['doctor_surname'] ?></a></td>
                			<td><?=$row['client_name'] ?> <?=$row['client_surname'] ?></td>
                			<td><?=$row['service_name'] ?></td>
                			<td><?=$row['lab_name'] ?></td>
                			<td><?=number_format($row['price'],2,'.',',') ?></td>
                			<td><?=($row['is_received']=="Y")?"ได้รับแล้ว":"ยังไม่ได้รับ" ?></td>
                			<td><a href="<?= base_url() ?>lab/edit/<?=$row['trans_id']?>" class="btn btn-primary" > แก้ไข </a></td>
                		</tr>
                	<?php }?>
                </tbody>
                
         </table>
	</div>
</div>
       <div id="doctormodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                <table id="doctortable" class="table table-bordered table-striped" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                  <th>วันที่</th>
			                  <th>ทันตแพทย์</th>
			                  <th>คนไข้</th>
			                  <th>รายการ</th>
			                  <th>lab</th>
			                  <th>ราคา</th>
			                  <th>สถานะ</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			                
			                  <th>วันที่</th>
			                  <th>ทันตแพทย์</th>
			                  <th>คนไข้</th>
			                  <th>รายการ</th>
			                  <th>lab</th>
			                  <th>ราคา</th>
			                  <th>สถานะ</th>	            
            			  </tr>
			        </tfoot>
			    </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ปิด</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <div id="datemodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
             		<table id="datetable" class="table display" cellspacing="0" width="100%">
			        <thead>
			            <tr>
			                  <th>วันที่</th>
			                  <th>ทันตแพทย์</th>
			                  <th>คนไข้</th>
			                  <th>รายการ</th>
			                  <th>lab</th>
			                  <th>ราคา</th>
			                  <th>สถานะ</th>
			            </tr>
			        </thead>
			        <tfoot>
			            <tr>
			                
			                  <th>วันที่</th>
			                  <th>ทันตแพทย์</th>
			                  <th>คนไข้</th>
			                  <th>รายการ</th>
			                  <th>lab</th>
			                  <th>ราคา</th>
			                  <th>สถานะ</th>	            
            			  </tr>
			        </tfoot>
			    </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ปิด</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
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

   $('#datepicker').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
      });
	 jQuery(document).ready(function(){
	 $('.select2').select2();
	});
</script>
		<!-- /.box-header -->