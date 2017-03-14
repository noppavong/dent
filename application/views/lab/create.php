	<script type="text/javascript" src="<?= base_url() ?>assets/js/script.js" ></script>
 

  <form  id="formElem" role="form" action="<?php echo base_url() ?>lab/save" method="post" class=" form-horizontal" novalidate >
 			<?php if(isset($client_id)){?>
 				<input type="hidden" name="client_id" value="<?= set_value('client_id',$client_id) ?>"/> 
 			<?php }?>
 				<!-- general form elements -->
 				<div class="box">
 					<div class="box-header with-border">
 						<h3 class="box-title">ข้อมูล lab</h3>
 					</div>
 					<!-- /.box-header -->
 					<!-- form start -->
 					<div class="box-body">        
          <?php if (validation_errors()){ ?>
          <div class="alert alert-danger alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo validation_errors(); ?>
          </div>
          <?php } ?>    
                <div class="form-group ">
                    <label for="lab"  class="control-label col-sm-2">ชื่อ lab</label>
                    <div class="col-sm-7">
                    <select class="form-control select2" name="lab" value="<?=set_value('lab',(isset($lab)?$lab:"")); ?>"  >
                        <?php foreach ($labs->result_array() as $row){ ?>
                        <option value="<?= $row['lab_id'] ?>" <?php echo set_select('lab', $row['lab_id'], False); ?> ><?= $row['name']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <button type="button" data-toggle="modal" data-target="#labmodal" class="btn btn-primary">เพิ่ม</button>
                    <button type="button" data-toggle="modal" data-target="#errorLabmodal" class="btn btn-danger">ลบ</button>
                </div>
                  <div class="form-group ">
                    <label for="service"  class="control-label col-sm-2">ชื่อ บริการ</label>
                    <div class="col-sm-7">
                    <select class="form-control select2" name="service" value="<?=set_value('service',(isset($service)?$service:"")); ?>"  >
                        <?php foreach ($services->result_array() as $row){ ?>
                        <option value="<?= $row['service_id'] ?>"><?= $row['name']; ?> </option>
                        <?php } ?>
                    </select>
                    </div>

                    <button type="button" data-toggle="modal" data-target="#servicemodal" class="btn btn-primary">เพิ่ม</button> 
                    <button type="button" data-toggle="modal" data-target="#errorServicemodal" class="btn btn-danger">ลบ</button>
                </div>
                  <div class="form-group ">
                    <label for="doctor"  class="control-label col-sm-2"> แพทย์</label>
                    <div class="col-sm-7">
                    <select class="form-control select2 " name="doctor" value="<?=set_value('doctor',(isset($doctor)?$doctor:"")); ?>"  >
                        <?php foreach ($doctors->result_array() as $row){ ?>
                        <option value="<?= $row['doctor_id'] ?>"><?= $row['name']; ?> <?= $row['surname']; ?></option>
                        <?php } ?>
                    </select>
                    </div>

                </div>
                 <div class="form-group" >
                    <label    class="control-label col-sm-2" for="namethai">สถานะ</label>
                     <div class="col-sm-7">
                          <div class="checkbox">
                            <label>
                              <input name="is_received" type="checkbox" value="Y"   <?php  echo set_value('is_received', (isset($is_received))?$is_received:"") == "Y" ? "checked" : ""; ?> > ได้รับแล้ว
                            </label>
                          </div>
                     </div>
                </div>

                  <div class="form-group">

                      <label for="send_date" class="control-label col-sm-2" >วันที่ส่ง</label>
                      <div class="col-sm-7">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="send_date" class="form-control pull-right" data-date-format="dd-mm-yyyy" id="datepicker" value="<?=set_value('send_date',(isset($send_date))?date('d-m-Y',strtotime($send_date)):""); ?>">
                              </div>
                      
                      </div>
                  </div>
                        <div class="form-group">
                            <label for="price" class="control-label col-sm-2" > ราคา </label>
                            <div class="col-sm-7">
                                  <input type="text" id="price" name="price" class="form-control" value="<?=set_value('price',(isset($price))?$price:""); ?>" />
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="remark"  class="control-label col-sm-2">หมายเหตุ</label>
                            <div class="col-sm-7">
                            <textarea class="form-control" name="remark" rows="5" placeholder="หมายเหตุ ..."><?=set_value('remark',(isset($remark)?$remark:"")); ?></textarea>
                            </div>
                        </div>
                      <button type="submit" class="btn btn-primary btn-lg" > บันทึก </button>
                      <a href="<?= base_url() ?>client/view/<?=$client_id ?>" class="btn btn-error btn-lg" > ยกเลิก </a>
 					</div>
 					<!-- /.box-body -->
 				</div>
      </form>
      <div id="labmodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูล (ชื่อ lab)</h4>
              </div>
              <div class="modal-body">
                <form id="labform" class="form-horizontal">
                  <div class="form-group ">
                    <label for="service"  class="control-label col-sm-2">ชื่อ </label>
                    <div class="col-sm-7">
                       <input type="text" class="form-control" id="name_lab" name="name_lab"  />
                    </div>
                   </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-save">บันทึก</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       <div id="servicemodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูล (ชื่อ บริการ)</h4>
              </div>
              <div class="modal-body">
                <form id="serviceform" class="form-horizontal" >
                  <div class="form-group ">
                    <label for="service"  class="control-label col-sm-2">ชื่อ </label>
                    <div class="col-sm-7">
                       <input type="text" class="form-control" id="name_service" name="name_service"  />
                    </div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-save">บันทึก</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          
          <!-- /.modal-dialog -->
        </div>
         <div id="errorLabmodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลบข้อมูล Lab</h4>
              </div>
              <div class="modal-body">
                  กดยืนยันเพื่อลบข้อมูล
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-delete">ยืนยัน</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       <div id="errorServicemodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลบข้อมูล บริการ</h4>
              </div>
               <div class="modal-body">
                  กดยืนยันเพื่อลบข้อมูล
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary btn-delete">ยืนยันdelete</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <script type="text/javascript">
        $(document).ready(function(){
          $('form').preventDoubleSubmission();
        //  $('#birth_date').datepicker({
       //      autoclose: true,
       //      format:'yyyy-mm-dd'
       //    });
              $('#confirm-delete').on('show.bs.modal', function(e) {
                  $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
              });
            

        });
           $('#datepicker').datepicker({
                autoclose: true,
                dateFormat: 'dd-mm-yy',
              });

    </script>



