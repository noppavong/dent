  
  <form  id="formElem" role="form" action="<?php echo base_url() ?>assistant/save" method="post" class=" form-horizontal" novalidate >
      <?php if(isset($assistant_id)){?>
        <input type="hidden" name="assistant_id" value="<?= set_value('assistant_id',$assistant_id) ?>"/> 
      <?php }?>
              <!-- general form elements -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">ข้อมูล ผู้ช่วย</h3>
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
            <div class="form-group" >
              <label  class="control-label col-sm-2" for="name">ชื่อ</label>
              <div class="col-sm-3">
                <input type="text" id="name" name="name" class="form-control"  placeholder="" value="<?php echo set_value('name',(isset($name))?$name:""); ?>">
              </div>
              <label  class="control-label col-sm-2" for="salary">เงินเดือน</label>
              <div class="col-sm-3">
                <input type="text" readonly id="salary" name="salary" class="form-control"  placeholder="" value="<?php echo set_value('salary',(isset($salary))?$salary:""); ?>">
              </div>
            </div>
            <div class="form-group">
              <label  class="control-label col-sm-2" for="surname">นามสกุล</label>
              <div class="col-sm-3">
                <input type="text" id="surname" name="surname" class="form-control"  value="<?=set_value('surname',(isset($surname))?$surname:""); ?>">
              </div>
              <label  class="control-label col-sm-2" for="account_no">เลขบัญชี</label>
              <div class="col-sm-3">
                <input type="text" id="account_no" name="account_no" class="form-control"  placeholder="" value="<?php echo set_value('account_no',(isset($account_no))?$account_no:""); ?>">
              </div>
            </div>
            <div class="form-group">
              <label  class="control-label col-sm-2" for="phone_no">โทรศัพท์</label>
              <div class="col-sm-3">
                <input type="text" id="phone_no" name="phone_no" class="form-control"  value="<?=set_value('phone_no',(isset($phone_no))?$phone_no:""); ?>">
              </div>
              <label class="control-label col-sm-2"> ธนาคาร </label>
              <div class="col-sm-3">
                <select class="form-control select2" name="bank"  >
                 <?php foreach ($banks->result_array() as $row){ ?>
                 <option value="<?= $row['bank_id'] ?>"  <?php echo set_select('bank', $row['bank_id'], isset($bank)?$row['bank_id']==$bank:$row['bank_id']==""); ?>><?= $row['name']; ?></option>
                 <?php } ?>
               </select>
              </div>
            </div>
            <div class="form-group">
              <label  class="control-label col-sm-2">  งานที่ถนัด</label>
              <div class="col-sm-7">

                <?= form_multiselect('skill[]', $skills, (isset($assistant_skills)?$assistant_skills:""),array('class'=>'form-control select2')); ?>
             
             </div>
          </div>
           <div class="form-group">
              <label  class="control-label col-sm-2">  วันพักงาน</label>
              <div class="col-sm-7">

                <?= form_multiselect('holiday[]', $holidays, "",array('class'=>'form-control select2')); ?>
             
             </div>
          </div>
          <div class="form-group" >
            <label    class="control-label col-sm-2" for="working_status">สถานะ</label>
            <div class="col-sm-7">
              <div class="radio col-sm-3">
                <label>
                  <input type="radio"  name="working_status"  value="A"  <?php  echo set_value('status', (isset($working_status))?$working_status:"") == "P" ? "checked" : ""; ?>>
                  ทำงาน
                </label>
              </div>
              <div class="radio col-sm-3">
                <label>
                  <input type="radio" name="working_status"  value="N"  <?php  echo set_value('status', (isset($working_status))?$working_status:"") == "I" ? "checked" : ""; ?>>
                  ยกเลิก
                </label>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary btn-lg " >
            บันทึก
          </button>
          <button type="button" class="btn btn-danger btn-lg " >
            ยกเลิก
          </button>
          <?php if(isset($assistant_id)){ ?>
          <button class="btn btn-warning btn-lg" type="button" data-href="<?= base_url() ?>assistant/delete/<?= $assistant_id ?>" data-toggle="modal" data-target="#confirm-delete">
            ลบ
          </button>
          <?php } ?>
        </div>
      </div>
 
</form>
       <?php if(isset($assistant_id)) { ?>
         <div class="modal fade modal-warning" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                ลบข้อมูล
                            </div>
                            <div class="modal-body">
                                 ยืนยันการลบ                                
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                <a class="btn btn-danger btn-ok">ตกลง</a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.select2').select2();
    $('form').preventDoubleSubmission();
  //  $('#birth_date').datepicker({
 //      autoclose: true,
 //      format:'yyyy-mm-dd'
 //    });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
      

  });
  </script>