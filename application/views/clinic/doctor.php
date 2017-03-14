
<div class="col-xs-12">
 <ul class="nav nav-pills">
    <li role="presentation" ><a href="<?= base_url() ?>clinic">ตารางเวลา</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>clinic/inout" >ลงวันหยุด/วันเข้าพิเศษ</a></li>
    <li role="presentation" class="active" ><a href="<?= base_url() ?>clinic/doctor">ทันตแพทย์</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>clinic/assistant">ผู้ช่วย</a></li>
 </ul>
 <div class="box">

    <div class="box-header with-border">
 	<div class="box-title">
 		ทันตแพทย์
 	</div>
    </div>
 	<div class="box-body ">
 	<button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addDoctorModal" > เพิ่มทันตแพทย์  </button>
    <br class="clear"/>
    <div class="col-xs-12">
 		<table id="doctorTable" class="table display" cellspacing="0" width="100%">
 			<thead>
 				<tr>
 					<th></th>
 					<th>ชื่อ นามสกุล</th>
 					<th>เบอร์โทรศัพท์</th>
                    <th>เชี่ยวชาญ</th>
 				</tr>
 			</thead>
 		</table>
        </div>
 	</div>

 </div>

 <div id="viewDoctorModal" class="modal fade">
     <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ข้อมูลทันตแพทย์</h4>
            </div>
            <!-- /.box-header -->
            <div class="modal-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  
                  <tbody>
                  <tr>
                    <td>ชือ่</td>
                    <td id="viewname"></td>
                    <td>นามสกุล</td>
                    <td id="viewsurname"></td>
                  </tr>
                   <tr>
                    <td>เบอร์โทรศัพท์</td>
                    <td id="viewphone_no"></td>
                    <td>เลขที่ใบประกอบโรคศิลป์</td>
                    <td id="viewmd_no"></td>
                  </tr>
                     <tr>
                    <td>บัญชีธนาคาร</td>
                    <td id="viewaccount_no"></td>
                    <td>ธนาคาร</td>
                    <td id="viewbank"></td>
                  </tr>
                     <tr>
                    <td>เปอร์เซ็นส่วนแบ่ง</td>
                    <td id="viewshare_percentage"></td>
                    <td>เชี่ยวชาญ</td>
                    <td id="viewskill"></td>
                  </tr>

                  </tbody>
                  <table class="table timesetup">
                            
                            <tbody>
                                <tr >
                                    <th rowspan="2">วันเข้ารักษา</th>
                                    <th colspan="5">สัปดาห์ที่</th>
                                    <th >ตั้งแต่เวลา</th>
                                    <th >ถึงเวลา</th>
                                <tr/>
                                <tr>
                                    <th>(คลิกเพื่อเลือกวันเข้า)</th>
                                    <th>1</th>
                                    <th>2</th>
                                    <th>3</th>
                                    <th>4</th>
                                    <th>5</th>
                                    <th colspan="2" >(24 ชั่วโมง)</th>
                                </tr>
                                <?php for($i= 0; $i <= 6 ; $i++){ ?>
                                <tr>
                                    <td id="weekday_<?=$i ?>"> 
                                       <?= $mapday[$i +1] ?>
                                    </td>
                                    <td class="week_no">
                                    </td>
                                   <td class="week_no">
                                    </td>
                                    <td class="week_no">
                                    </td>
                                    <td class="week_no">
                                    </td>
                                    <td class="week_no">
                                    </td>
                                    <td class="start_time">
                                    </td>
                                    <td class="end_time">
                                    </td>
                                </tr>
                                <?php } ?>
                                
                            </tbody>
                    </table>

                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
 </div>
 <div id="addDoctorModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ข้อมูลทันตแพทย์</h4>
            </div>

            <form id="doctorform" action="<?php echo base_url() ?>clinic/savedoctor" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="doctor_id" value="" />
                    <div class="form-group ">
                        <label for="name" class="control-label col-sm-2">ชื่อ </label>
                        <div class="col-sm-3">
                        	<input type="text" name="name"  class="form-control" />
                        </div>
                         <label for="send_date" class="control-label col-sm-2">เชี่ยวชาญ</label>
                        <div class="col-sm-4">
							  <?= form_multiselect('skill[]', $skills, "",
							  array('class'=>'form-control select2','style'=>'width:100%')); ?>
	                        
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="service" class="control-label col-sm-2">นามสกุล</label>
                        <div class="col-sm-3">
                           	<input type="text" name="surname"  class="form-control" />
                        </div>
                         <label class="control-label col-sm-2" for="share_percentage">เปอร์เซ็นส่วนแบ่ง</label>
                        <div class="col-sm-4">
                        	<select class="form-control select2" name="share_percentage" style="width: 100%" >
                             <?php for($i = 0; $i <=100; $i++){ ?>
                             <option  value="<?= $i; ?>"><?= $i ?>%</option>
                             <?php } ?>
                           </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="doctor" class="control-label col-sm-2"> เบอร์โทรศัพท์</label>
                        <div class="col-sm-3">
                        	<input text="text" name="phone_no"  class="form-control" />
                        </div>
                        <label class="control-label col-sm-2"> ธนาคาร </label>
		              <div class="col-sm-4">
		                <select class="form-control select2" name="bank" style="width: 100%" >
		                 <?php foreach ($banks->result_array() as $row){ ?>
		                 <option value="<?= $row['bank_id'] ?>"  <?php echo set_select('bank', $row['bank_id'], isset($bank)?$row['bank_id']==$bank:$row['bank_id']==""); ?>><?= $row['name']; ?></option>
		                 <?php } ?>
		               </select>
		              </div> 

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="namethai">เลขที่ใบประกอบโรคศิลป์</label>
                        <div class="col-sm-3">
                        	<input type="text" name="md_no"  class="form-control"  />
                        </div>
                        <label class="control-label col-sm-2" for="account_no">เลขที่บัญชีธนาคาร</label>
                        <div class="col-sm-4">
                        	<input type="text" name="account_no"   class="form-control" />
                        </div>
                    </div>
                    	<table class="table timesetup">
                    			
                    			<tbody>
                    				<tr >
	                    				<th rowspan="2">วันเข้ารักษา</th>
	                    				<th colspan="5">สัปดาห์ที่</th>
	                    				<th >ตั้งแต่เวลา</th>
	                    				<th >ถึงเวลา</th>
                    				<tr/>
                    				<tr>
                    					<th>(คลิกเพื่อเลือกวันเข้า)</th>
                    					<th>1</th>
                    					<th>2</th>
                    					<th>3</th>
                    					<th>4</th>
                    					<th>5</th>
                    					<th colspan="2" >(24 ชั่วโมง)</th>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="0" /> วันอาทิตย์
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sun_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sun_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sun_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sun_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sun_week_no[]" value="5"/> 
                    					</td>
                    					<td>

      								        <div class="bootstrap-timepicker">
	                    								<input type="text" name="sun-start" class="timeonly" /> 
	                    						
                    						</div>
                    					</td>
                    					<td>

      								        <div class="bootstrap-timepicker">
                    							<input type="text" name="sun-end"  class="timeonly" />
                    						</div>
                    					
                    					</td>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="1" /> วันจันทร์
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="mon_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="mon_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="mon_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="mon_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="mon_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="mon-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="mon-end"  class="timeonly" />
                    					
                    					</div></td>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="2" /> วันอังคาร
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="tue_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="tue_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="tue_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="tue_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="tue_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="tue-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="tue-end"  class="timeonly" />
                    					
                    					</div></td>

                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="3" /> วันพุธ
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="wed_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="wed_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="wed_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="wed_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="wed_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="wed-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="wed-end"  class="timeonly" />
                    					
                    					</div></td>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="4" /> วันพฤหัส
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="thr_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="thr_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="thr_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="thr_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="thr_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="thr-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="thr-end"  class="timeonly" />
                    					
                    					</div></td>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="5" /> วันศุกร์
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="fri_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="fri_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="fri_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="fri_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="fri_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="fri-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="fri-end"  class="timeonly" />
                    					
                    					</div></td>
                    				</tr>
                    				<tr>
                    					<td>
                    						<input type="checkbox" name="weekday[]" value="6" /> วันเสาร์
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sat_week_no[]" value="1"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sat_week_no[]" value="2"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sat_week_no[]" value="3"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sat_week_no[]" value="4"/> 
                    					</td>
                    					<td>
                    						<input type="checkbox" class="expand-right" name="sat_week_no[]" value="5"/> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text" name="sat-start" class="timeonly" /> 
                    					</td>
                    					<td>
                    					 <div class="bootstrap-timepicker">
                    						<input type="text"  name="sat-end"  class="timeonly" />
                    					
                    					</div></td>
                    				</tr>
                    				
                    			</tbody>
                    	</table>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
        </div>
    </div>
    <div id="mapbank">
        <?= $mapbank ?>
    </div>
    <div id="mapskill">
        <?= $mapskill ?>
    </div>
</div>
</div>
<script type="text/javascript">
var seteditDoctor = function(id)
{
      $.get('<?=base_url() ?>clinic/get_doctor/' +id, function(data) {
                $('input[name="name"]').val(data.doctor.name);
                $('input[name="surname"]').val(data.doctor.surname);
                $('input[name="phone_no"]').val(data.doctor.phone_no);
                $('input[name="md_no"]').val(data.doctor.md_no);
                $('input[name="account_no"]').val(data.doctor.account_no);
                $('select[name="share_percentage"]').val(data.doctor.share_percentage);
                $('input[name="doctor_id"]').val(data.doctor.doctor_id);
                $('select[name="bank"]').val(data.doctor.bank);

                $('select[name="bank"]').trigger('change');
                $('select[name="share_percentage"]').trigger('change');
                var selectedValues = [];
                for(var i = 0; i< data.doctor_skill.length ; i++)
                {
                    selectedValues.push(parseInt(data.doctor_skill[i].skill_id));
                }
                 $('select[name="skill[]"]').select2('val',[selectedValues]);
                 for(var i = 0; i < data.doctor_time.length;i++){

                     $('input[name="weekday[]"]').filter('[value="'+data.doctor_time[i].weekday+'"]').prop('checked', true);
                     if(data.doctor_time[i].weekday == 0)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="sun_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="sun_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="sun_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="sun_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="sun_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="sun-start"]').val(data.doctor_time[i].start);
                        $('input[name="sun-end"]').val(data.doctor_time[i].end);
                      }
                      if(data.doctor_time[i].weekday == 1)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="mon_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="mon_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="mon_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="mon_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="mon_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="mon-start"]').val(data.doctor_time[i].start);
                        $('input[name="mon-end"]').val(data.doctor_time[i].time);
                      }
                    if(data.doctor_time[i].weekday == 2)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="tue_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="tue_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="tue_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="tue_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="tue_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="tue-start"]').val(data.doctor_time[i].start);
                        $('input[name="tue-end"]').val(data.doctor_time[i].end);
                      }

                    if(data.doctor_time[i].weekday == 3)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="wed_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="wed_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="wed_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="wed_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="wed_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="wed-start"]').val(data.doctor_time[i].start);
                        $('input[name="wed-end"]').val(data.doctor_time[i].end);
                      }

                    if(data.doctor_time[i].weekday == 4)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="thr_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="thr_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="thr_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="thr_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="thr_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="thr-start"]').val(data.doctor_time[i].start);
                        $('input[name="thr-end"]').val(data.doctor_time[i].end);
                      }
                       if(data.doctor_time[i].weekday == 5)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="fri_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="fri_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="fri_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="fri_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="fri_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="fri-start"]').val(data.doctor_time[i].start);
                        $('input[name="fri-end"]').val(data.doctor_time[i].end);
                      }

                    if(data.doctor_time[i].weekday == 6)
                     {
                        if(data.doctor_time[i].is_firstw == 'Y'){
                             $('input[name="sat_week_no[]"]').filter('[value="1"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_secondw == 'Y'){
                            
                             $('input[name="sat_week_no[]"]').filter('[value="2"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_thirdw == 'Y'){
                            
                             $('input[name="sat_week_no[]"]').filter('[value="3"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fourthw == 'Y'){
                            
                             $('input[name="sat_week_no[]"]').filter('[value="4"]').prop('checked',true);
                        }  
                        if(data.doctor_time[i].is_fifthw == 'Y'){
                            
                             $('input[name="sat_week_no[]"]').filter('[value="5"]').prop('checked',true);
                        }  

                        $('input[name="sat-start"]').val(data.doctor_time[i].start);
                        $('input[name="sat-end"]').val(data.doctor_time[i].end);
                      }

                }
                $('#addDoctorModal').modal('show');

            });
}

    var setViewDoctor = function(id)
    {

      $.get('<?=base_url() ?>clinic/get_doctor/' +id, function(data) {
        var bankmap = $('#mapbank').html();
        bankmap = JSON.parse(bankmap);
        var skillmap = $('#mapskill').html();
        skillmap = JSON.parse(skillmap);
        //clear

        $('.bg-green').removeClass('bg-green');
        $('.start_time').html(''); 
         $('.end_time').html(''); 

                $('#viewname').html(data.doctor.name);
                $('#viewsurname').html(data.doctor.surname);
                $('#viewphone_no').html(data.doctor.phone_no);
                $('#viewmd_no').html(data.doctor.md_no);
                $('#viewaccount_no').html(data.doctor.account_no);
                $('#viewshare_percentage').html(data.doctor.share_percentage);
                $('#viewbank').html(bankmap[data.doctor.bank]);
                var strSkill = [];
                for(var i = 0; i< data.doctor_skill.length ; i++)
                {
                    strSkill.push(skillmap[data.doctor_skill[i].skill_id]);
                }
            $('#viewskill').html(strSkill.join(','));
              for(var i = 0; i < data.doctor_time.length;i++){

                    $('#weekday_'+(data.doctor_time[i].weekday)).addClass('bg-green');
                     if(data.doctor_time[i].is_firstw == 'Y'){
                         $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.week_no:eq(1)').addClass('bg-green');
                    }  
                    if(data.doctor_time[i].is_secondw == 'Y'){
                        
                         $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.week_no:eq(2)').addClass('bg-green');
                    }  
                    if(data.doctor_time[i].is_thirdw == 'Y'){
                        
                         $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.week_no:eq(3)').addClass('bg-green');
                    }  
                    if(data.doctor_time[i].is_fourthw == 'Y'){
                        
                         $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.week_no:eq(4)').addClass('bg-green');
                    }  
                    if(data.doctor_time[i].is_fifthw == 'Y'){
                        
                         $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.week_no:eq(5)').addClass('bg-green');
                    }  
                     $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.start_time').html(data.doctor_time[i].start);
                     $('#weekday_'+(data.doctor_time[i].weekday)).parent().find('.end_time').html(data.doctor_time[i].end);
                     
              }
                $('#viewDoctorModal').modal('show');

        });
    }
    $(document).ready(function() {

            $('#doctorform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            seteditDoctor($(this).data('id'));


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/delete_doctor/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });

     $(document).on('click', '.viewable', function(evt) {
            setViewDoctor($(this).data('id'));
       });
        $(document).on('click','input[name="weekday[]"]',function(){
            if($(this).is(':checked')){
                $(this).parent().parent().find('input[type="checkbox"]').attr('checked',true);
                $(this).parent().parent().find('input[type="text"]').removeAttr('disabled');
            }else{
                $(this).parent().parent().find('input[type="checkbox"]').attr('checked',false);
                 $(this).parent().parent().find('input[type="text"]').val('');
                $(this).parent().parent().find('input[type="text"]').attr('disabled','disabled');

            }
        });
         $(document).on('click','input[name$="week_no[]"]',function(){
            console.log('check')
            if($(this).is(':checked')){

                $(this).parent().parent().find('input[name="weekday[]"]').prop('checked', true);
            }else{
                var alldeselect = true;
                 if ( $(this).parent().parent().find('input[name$="week_no[]"]:checked').length > 0) {
                      alldeselect = false;
                    }
                  if(alldeselect){
                       $(this).parent().parent().find('input[name="weekday[]"]').prop('checked', false);;
                    }

            }
        })
        $('#addDoctorModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="doctor_id"]').val().length > 0) {
                $('input[name="doctor_id"]').val('');
            }
            $('#doctorform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var doctorTable = $('#doctorTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>clinic/listdoctor/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="viewable" data-id="' + data + '">ดู </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {},{}]
        });

        var recreateTable = function() {
            if (doctorTable) {
                doctorTable.destroy();
            }
            doctorTable = $('#doctorTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
           	    "ajax": '<?= base_url() ?>clinic/listdoctor/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="viewable" data-id="' + data + '">ดู </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {},{}]
            });
        }

        $('#doctorform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="doctor_id"]').val().length > 0) {
                            $('input[name="doctor_id"]').val('');
                        }
                      
                         $('#doctorform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addDoctorModal').modal('hide');
                    } else {
                        
                        $('.validation-form').empty();
                        $('.validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });

        $('.select2').select2();
        $('form').preventDoubleSubmission();
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    });
    $('#datepicker2').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
    });
      $(".timeonly").timepicker({
      	  showMeridian: false,
          showSeconds:false,
          disableFocus:true,
	    }).on('show.timepicker', function(e) {
            console.log($(e.target).prev().find('input[name="hour"]'));
             setTimeout(function(){
               $(e.target).prev().find('input[name="hour"]').focus();
            }, 1);
            
  });
  
</script>
<style>
.modal-dialog{
	width: 800px!important;
}
.bootstrap-timepicker-widget{
	z-index: 1051!important;
}
.bootstrap-timepicker-widget table td input {
    width: 50px;
    margin:0 auto;
 }
.timesetup {
    empty-cells: show;
    border: 1px solid #000;
}
.timesetup th{
    text-align:center;
}
.timesetup th,.timesetup td {
    min-width: 2em;
    min-height: 2em;
    border: 1px solid #000!important;

}
.timesetup>tbody>tr>th{

    border-left: 1px solid #000!important;
}

</style>