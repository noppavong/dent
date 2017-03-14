 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen"/>
  <script type="text/javascript" src="<?= base_url() ?>assets/js/script.js" ></script>
 <ul class="nav nav-pills">
    <li role="presentation" ><a href="<?= base_url() ?>clients">ค้นหาคนไข้</a></li>
    <li role="presentation" class="active"> <a href="<?= base_url() ?>client/create" >เพิ่มคนไข้</a></li>
    <li role="presentation"><a href="<?= base_url() ?>client/delete">ลบคนไข้</a></li>
    <li role="presentation"><a href="<?= base_url() ?>client/view">ข้อมูลคนไข้</a></li>
</ul>
<div class="col-xs-12">

<script>
    jQuery(document).ready(function(){

        jQuery('#otherdoc').change(function(){
            if($(this).is(':checked')){

                $('textarea[name="otherdoc"]').prop("disabled", false);
            }else{
                $('textarea[name="otherdoc"]').prop("disabled", true);
            }
        });
        $("#collapse").hide();
      $("#toggle").click(function () {
            if ($(this).data('name') == 'show') {
              console.log('hide');
                $("#collapse").slideUp('slow');
                $(this).data('name', 'hide');

            } else {
              console.log('show');
                 $("#collapse").slideDown( "slow");
                 $('.select2-container ').css('width','100%');
                $(this).data('name', 'show')
            }
        });

    }); 

</script>
 		<form  id="formElem" role="form" action="<?php echo base_url() ?>client/save" method="post" class=" form-horizontal" novalidate >
 			<?php if(isset($client_id)){?>
 				<input type="hidden" name="client_id" value="<?= set_value('client_id',$client_id) ?>"/> 
 			<?php }?>
 				<!-- general form elements -->
 				<div class="box">
 					<div class="box-header with-border">
 						<h3 class="box-title">เพิ่มคนไข้</h3>
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
                            <label    class="control-label col-sm-2" for="namethai">สถานะ</label>
                             <div class="col-sm-7">
                                <div class="radio col-sm-3">
                                    <label>
                                      <input type="radio"  name="status"  value="P"  <?php  echo set_value('status', (isset($status))?$status:"") == "P" ? "checked" : ""; ?>>
                                            คนไข้
                                    </label>
                                  </div>
                                  <div class="radio col-sm-3">
                                    <label>
                                      <input type="radio" name="status"  value="I"  <?php  echo set_value('status', (isset($status))?$status:"") == "I" ? "checked" : ""; ?>>
                                            ไม่เคลื่อนไหว
                                    </label>
                                  </div>
                             </div>
                        </div>
 						<div class="form-group" >
 							<label    class="control-label col-sm-2" for="namethai">ชื่อ</label>
 							 <div class="col-sm-7">
                            <input type="text" id="name_thai" name="name_thai" class="form-control"  placeholder="" value="<?php echo set_value('name_thai',(isset($name_thai))?$name_thai:""); ?>">
 						     </div>
                        </div>
 						<div class="form-group">
 							<label  class="control-label col-sm-2" for="surnamethai">นามสกุล</label>
 							 <div class="col-sm-7">
                            <input type="text" id="surname_thai" name="surname_thai" class="form-control"  value="<?=set_value('surname_thai',(isset($surname_thai))?$surname_thai:""); ?>">
 						      </div>
                        </div>
                          <div class="form-group">
                        <label  class="control-label col-sm-2" for="surnamethai">ชื่อเล่น</label>
                       <div class="col-sm-7">
                            <input type="text" id="nickname" name="nickname" class="form-control"  value="<?=set_value('nickname',(isset($nickname))?$nickname:""); ?>">
                  </div>
                        </div>

 					
                        <div class="form-group">

                            <label for="phone" class="control-label col-sm-2" >เบอร์ติดต่อ</label>
                            <div class="col-sm-7">
                                <input type="text" name="phone_no" class="form-control" value="<?=set_value('phone_no',(isset($phone_no))?$phone_no:""); ?>">

                            </div>
                        </div>
                          <div class="form-group ">
                            <label for="title"  class="control-label col-sm-2">คำนำหน้าชื่อ</label>
                            <div class="col-sm-7">
                            <select class="form-control select2" name="title"  >
                                <?php foreach ($titles->result_array() as $row){ ?>
                                <option value="<?= $row['title_id'] ?>"  <?php echo set_select('title', $row['title_id'], isset($title)?$row['title_id']==$title:$row['title_id']==""); ?>><?= $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>
                         <div class="form-group" >
                            <label    class="control-label col-sm-2" for="namethai">เพศ</label>
                             <div class="col-sm-7">
                                <div class="radio col-sm-3">
                                    <label>
                                      <input type="radio"  name="sex"  value="M"  <?php  echo set_value('sex', (isset($sex)?$sex:"")) == "M" ? "checked" : ""; ?>>
                                            ชาย
                                    </label>
                                  </div>
                                  <div class="radio col-sm-3">
                                    <label>
                                      <input type="radio" name="sex"  value="F"  <?php  echo set_value('sex',(isset($sex)?$sex:"")) == "F" ? "checked" : ""; ?>>
                                            หญิง
                                    </label>
                                  </div>
                             </div>
                        </div>

                        <div class="form-group">

                            <label for="phone" class="control-label col-sm-2" >วันเกิด</label>
                            <div class="col-sm-7">
                                  <div class="input-group date">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" name="birth_date" class="form-control pull-right" data-date-format="dd-mm-yyyy" id="datepicker" value="<?=set_value('birth_date',(isset($birth_date))?date('d-m-Y',strtotime($birth_date)):""); ?>">
                                    </div>
                            
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="age" class="control-label col-sm-2" > อายุ </label>
                            <div class="col-sm-7">
                                  <input type="text" id="age" name="age" class="form-control" value="<?=set_value('age',(isset($age))?$age:""); ?>" />
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label  for="allergic"  class="control-label col-sm-2">แพ้ยา</label>
                            <div class="col-sm-7">
                            <textarea class="form-control" name="allergic" rows="5" placeholder="แพ้ยา ..."><?=set_value('allergic',(isset($allergic)?$allergic:"")); ?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="medication" class="control-label col-sm-2">โรคประจำตัว</label>
                            <div class="col-sm-7">
                            <textarea class="form-control" name="medication" rows="5" placeholder="โรคประจำตัว ..."><?=set_value('medication',(isset($medication)?$medication:"")); ?></textarea>
                            </div>
                        </div>
                <!--        <div class="form-group">
                            <label for="surnamethai"  class="control-label col-sm-2">สถานะภาพ</label>

                            <select class="form-control" name="marital_status" value="<?=set_value('marital_id',$marital_id); ?>" >
                                <?php foreach ($maritals->result_array() as $row){ ?>
                                <option value="<?= $row['id'] ?>"><?= $row['desc']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                         -->
                         <div class="form-group">
                                <label  class="control-label col-sm-2"> หมอประจำ </label>
                                <div class="col-sm-7">
                                  
                                    <?= form_multiselect('doctor[]', $doctors, (isset($cli_doctors)?$cli_doctors:""),array('class'=>'form-control select2')); ?>
                                </select>
                            </div>
                           
                        </div>
                        <div class="form-group">
                            <label  class="control-label col-sm-2"> เอกสารที่ต้องการ</label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                <label>
                                     <input type="checkbox"  name="medcert"  value="Y"  <?php  echo set_value('medcert', (isset($medcert)?$medcert:"")) == "Y" ? "checked" : ""; ?>>
                                            ใบรับรองแพทย์

                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                     <input type="checkbox"  name="social"  value="Y"  <?php  echo set_value('social', (isset($social)?$social:"")) == "Y" ? "checked" : ""; ?>>
                                            ใบประกันสังคม

                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                     <input type="checkbox"  id="otherdoc" <?php if(!empty($otherdoc)){ ?> checked <?php } ?> >
                                            อื่นๆ ระบุ

                                </label>
                              </div>
                                 <textarea class="form-control"  name="otherdoc" rows="5" placeholder="เอกสารอื่นๆ ..." <?php if(empty($client_id)||empty($otherdoc)) { ?> disabled<?php } ?> ><?=set_value('otherdoc',(isset($otherdoc)?$otherdoc:"")); ?></textarea>
   
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="other" class="control-label col-sm-2"> อื่นๆ</label>
                               <div class="col-sm-7">
                            <textarea class="form-control"  name="other" rows="5" placeholder="หมายเหตุ" ><?=set_value('other',(isset($other)?$other:"")); ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="nickname" class="control-label col-sm-2" ></label>
                             <div class="col-sm-7">
                           <button id="toggle" type="button" data-name="hide" class="btn btn-default btn-block">แบบเต็ม</button>
                            </div>

                        </div>
 					</div>
 					<!-- /.box-body -->
 				</div>
 				<!-- /.box -->
 				<div class="box" id="collapse" >
 					<div class="box-header with-border">
 						<h3 class="box-title">ข้อมูลเพิ่มเติม</h3>
 					</div>
 					<div class="box-body">
                      
 					<!-- 	<div class="form-group">
 							<label for="birh_date">วันเดือนปีเกิด</label>
 							<input type="text" id="birth_date" name="birth_date"  class="form-control"  value="<?=set_value('birth_date',$birth_date); ?>" >
 						</div>
 -->
<!-- 
 						<div class="form-group">
 							<label for="idcard">บัตรประชาชน</label> 
 							<input type="text" name="idcard" class="form-control" placeholder="รหัสบัตรประชาชน" value="<?=set_value('idcard',$idcard); ?>" >
 						</div> -->
 					          <div class="form-group">
                                <label class="control-label col-sm-2">ที่อยู่</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" name="address" rows="5" placeholder="ที่อยู่ ..." ><?=set_value('address',(isset($address)?$address:"")); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="control-label col-sm-2">email</label> 
                                <div class="col-sm-7">
                                
                                <div class="input-group">

                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                
                                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?=set_value('email',(isset($email)?$email:"")); ?>">
                                </div>
                            </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-2">อาชีพ</label>
                                <div class="col-sm-7">
                                
                                <input type="text" id="occupation" name="occupation"  class="form-control" value="<?=set_value('occupation',(isset($occupation)?$occupation:"")); ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2">ที่ทำงาน</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" name="work_address" rows="5" placeholder="ที่อยู่ ..." > <?=set_value('work_address',(isset($work_address)?$work_address:"")); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ำ" class="control-label col-sm-2">เลขประจำตัวพนักงาน</label> 
                                <div class="col-sm-7">
                                
                                    <input type="text" name="employee_no" class="form-control" placeholder="เลขประจำตัวพนักงาน" value="<?=set_value('employee_no',(isset($employee_no)?$employee_no:"")); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="discount_per" class="control-label col-sm-2">ส่วนลด</label> 
                                <div class="col-sm-2">
                                  <select class="form-control select2" name="discount_per" style="width: 100%" >
                                     <?php for($i = 0; $i <=100; $i++){ ?>
                                     <option  value="<?= $i; ?>" <?php echo set_select('discount_per', $i, isset($discount_per)?$i==$discount_per:$i==""); ?>><?= $i ?>%</option>
                                     <?php } ?>
                                   </select>
                                </div>

                                <label for="lab"  class="control-label col-sm-2">บริษัท contact</label>
                                <div class="col-sm-4">
                                <select class="form-control select2" name="company"  >
                                    <?php foreach ($companies->result_array() as $row){ ?>
                                    <option value="<?= $row['company_id'] ?>" <?php echo set_select('company', $row['company_id'], isset($company)?$row['company_id']==$company:$row['company_id']==""); ?> ><?= $row['name']; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                                <button type="button" data-toggle="modal" data-target="#companymodal" class="btn btn-primary">เพิ่ม</button>
                                <button type="button" data-toggle="modal" data-target="#errorCompanymodal" class="btn btn-danger">ลบ</button>
                            </div>

                    
                    </div>

 					<!-- /.box-body -->
 				</div>
                <!-- Button trigger modal -->

                <div class="modal modal-primary" id="additionalInfo">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">เพิ่มเติม</h4>
                      </div>
                      <div class="modal-body">
                        <div style="width:500px;margin: 0 auto;">
                            
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" onclick="clearForm();">ยกเลิก</button>
                        <button type="button" class="btn btn-outline" data-dismiss="modal" >ตกลง</button>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>

                     <button type="submit" class="btn btn-primary btn-lg " >
                      บันทึก
                    </button>
 				 <button type="button" class="btn btn-danger btn-lg " >
                      ยกเลิก
                    </button>
                <?php if(isset($client_id)){ ?>
                <button class="btn btn-warning btn-lg" type="button" data-href="<?= base_url() ?>client/delete/<?= $client_id ?>" data-toggle="modal" data-target="#confirm-delete">
                        ลบ
                </button>
                
                <?php } ?>
 		</form>
      <div id="companymodal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">เพิ่มข้อมูล (บริษัทติดต่อ)</h4>
          </div>
          <div class="modal-body">
            <form id="companyform" class="form-horizontal">
              <div class="form-group ">
                <label for="service"  class="control-label col-sm-2">ชื่อ </label>
                <div class="col-sm-7">
                   <input type="text" class="form-control" id="name_company" name="name_company"  />
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
     <div id="errorCompanymodal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลบข้อมูล บริษัทติดต่อ</h4>
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
        <?php if(isset($client_id)) { ?>
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
</div>

<script type="text/javascript">
 $.fn.datepicker.dates['th'] ={
        changeMonth: true,
        changeYear: true,
        showOn: "ปุ่ม",
        buttonImage: 'images/calendar.gif',
        buttonImageOnly: true,
        dateFormat: 'dd M yy',
        days: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
        daysMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
        months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
        monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
        constrainInput: true,
        yearRange: '-20:+0',
        buttonText: 'เลือก',
    };

	$(document).ready(function(){
		$('.select2').select2();
		$('form').preventDoubleSubmission();
	// 	$('#birth_date').datepicker({
 //      autoclose: true,
 //      format:'yyyy-mm-dd'
 //    });
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });

      
     $('.percent').inputmask('Regex', { regex: "^[1-9][0-9]?$|^100$" });  
	});

     $('#datepicker').datepicker({
          language:'th',
          autoclose: true,
          dateFormat: 'dd-mm-yy',
           format: {
        /*
           * Say our UI should display a week ahead,
           * but textbox should store the actual date.
           * This is useful if we need UI to select local dates,
           * but store in UTC
           */
          toDisplay: function (date, format, language) {
              var d = new Date(date);
              d.setFullYear(d.getFullYear() +543);
              return formatDate(d);
          },
          toValue: function (date, format, language) {
              var d = new Date(date);
              return formatDate(d);
          },
       },
        }).change(dateChanged)
        .on('changeDate', dateChanged);

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('-');
}
function dateChanged(ev) {
  //  $(this).datepicker('hide');
    if ($('#datepicker').val() )
    {
        var from = $('#datepicker').val().split('-');
        console.log(from);
        var birthday = new Date(from[2],from[1],from[0]);
        var age  = _calculateAge(birthday);
        $('#age').val(age);
    }
}

   function _calculateAge(birthday) { // birthday is a date
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970+543);
  
}
</script>