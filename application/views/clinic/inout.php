
 
 <div class="col-xs-12">

 <ul class="nav nav-pills">
    <li role="presentation" ><a href="<?= base_url() ?>clinic">ตารางเวลา</a></li>
    <li role="presentation" class="active" ><a href="<?= base_url() ?>clinic/inout" >ลงวันหยุด/วันเข้าพิเศษ</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>clinic/doctor">ทันตแพทย์</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>clinic/assistant">ผู้ช่วย</a></li>
 </ul>

   <div class="box box-success">

    <div class="box-header with-border">
      <div class="box-title">
         ลงวันเข้าพิเศษ
     </div>
 </div>
 <div class="box-body ">
    <div class="btn-group">
      <button type="button" data-toggle="modal" class="btn btn-info" data-target="#addscheduleModal" > ทันตแพทย์ลงวันเข้าพิเศษ</button>
      <button type="button" data-toggle="modal" class="btn btn-success" data-target="#addscheduleModal2" > ผู้ช่วยลงวันเข้าพิเศษ</button>
  </div>
  <div>
      <!-- Tab panes -->
      <table id="scheduleTable" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>ชื่อ นามสกุล</th>
                <th>เบอร์โทรศัพท์</th>
                <th>ตำแหน่ง</th>
                <th>วันที่ลงเพิ่ม</th>
                <th>เชี่ยวชาญ</th>
            </tr>
        </thead>
    </table>
</div>

</div>
</div>

</div>
<div class="col-xs-12">
   <div class="box box-danger">

    <div class="box-header with-border">
        <div class="box-title">
            ลาหยุด
        </div>
    </div>
    <div class="box-body ">
        <div class="btn-group">
            <button type="button" data-toggle="modal" class="btn btn-danger" data-target="#addabsentModal" > เพิ่มวันลาทันตแพทย์</button>
    
            <button type="button" data-toggle="modal" class="btn btn-warning" data-target="#addabsentModal2" > เพิ่มวันลาผู้ช่วย</button>
        </div>
        <div>
          <!-- Tab panes -->
          <table id="absentTable" class="table display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>ชื่อ นามสกุล</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>ตำแหน่ง</th>
                    <th>วันที่ลา</th>
                    <th>เชี่ยวชาญ</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
</div>

</div>
</div>
 <div id="addscheduleModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลงเวลาทันตแพทย์</h4>
            </div>

            <form id="scheduleform" action="<?php echo base_url() ?>clinic/saveschedule" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="id" value="" />
                    <input type="hidden" name="type" value="1"/>
                    <div class="form-group ">
                          <label class="control-label col-sm-2"> ทันตแพทย์ </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="doctor_id" style="width:100%" >
                                   <?php foreach ($doctors->result_array() as $row){ ?>
                                   <option value="<?= $row['doctor_id'] ?>"  ><?= $row['name'].' '.$row['surname']; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="control-label col-sm-2"> วันที่เข้า </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control datepicker"  name="start_date"  data-date-format="dd-mm-yyyy"/>
                        </div>
                      <!--   <label for="end_date" class="control-label col-sm-2"> วันที่ออก </label>
                         <div class="col-sm-4">
                        <input type="text" class="form-control datepicker"  name="end_date" data-date-format="dd-mm-yyyy"/>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label for="start_time" class="control-label col-sm-2">เวลาที่เข้า</label>
                           <div class="col-sm-4 bootstrap-timepicker">
                        <input type="text" class="form-control timeonly" name="start_time" />
                        </div>
                        <label for="start_time" class="control-label col-sm-2">เวลาที่ออก</label>

                           <div class="col-sm-4 bootstrap-timepicker">
                        <input type="text" class="form-control timeonly" name="end_time" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
        </div>
    </div>
</div>
 <div id="addscheduleModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลงเวลาผู้ช่วย</h4>
            </div>

            <form id="scheduleform2" action="<?php echo base_url() ?>clinic/saveschedule" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="id" value="" />
                    <input type="hidden" name="type" value="0"/>
                     <div class="form-group ">
                        <label for="assistant_id" class="control-label col-sm-2">ผู้ช่วย </label>
                         <div class="col-sm-9">
                                <select class="form-control select2" name="assistant_id" style="width:100%" >
                                   <?php foreach ($assistants->result_array() as $row){ ?>
                                   <option value="<?= $row['assistant_id'] ?>"  ><?= $row['name'].' '.$row['surname']; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="control-label col-sm-2"> วันที่เข้า </label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control datepicker"  name="start_date"  data-date-format="dd-mm-yyyy"/>
                        </div>
                      <!--   <label for="end_date" class="control-label col-sm-2"> วันที่ออก </label>
                         <div class="col-sm-4">
                        <input type="text" class="form-control datepicker"  name="end_date" data-date-format="dd-mm-yyyy"/>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label for="start_time" class="control-label col-sm-2">เวลาที่เข้า</label>
                           <div class="col-sm-4 bootstrap-timepicker">
                        <input type="text" class="form-control timeonly" name="start_time" />
                        </div>
                        <label for="start_time" class="control-label col-sm-2">เวลาที่ออก</label>

                           <div class="col-sm-4 bootstrap-timepicker">
                        <input type="text" class="form-control timeonly" name="end_time" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
        </div>
    </div>
</div>
  <div id="addabsentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลงลาทันตแพทย์</h4>
            </div>

            <form id="absentform" action="<?php echo base_url() ?>clinic/saveabsent" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm2"></div>
                    <input type="hidden" name="id" value="" />
                    <div class="form-group ">
                          <label class="control-label col-sm-2"> ทันตแพทย์ </label>
                            <div class="col-sm-9">
                                <select class="form-control select2" name="doctor_id" style="width:100%" >
                                    <option value="">ไม่มี</option>
                                   <?php foreach ($doctors->result_array() as $row){ ?>
                                   <option value="<?= $row['doctor_id'] ?>"  ><?= $row['name'].' '.$row['surname']; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="control-label col-sm-2"> วันที่ขาด</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control datepicker"  name="absent_date"  data-date-format="dd-mm-yyyy"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
        </div>
    </div>
</div>
   <div id="addabsentModal2" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลงลาผู้ช่วย</h4>
            </div>

            <form id="absentform2" action="<?php echo base_url() ?>clinic/saveabsent" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm2"></div>
                    <input type="hidden" name="id" value="" />
                   
                     <div class="form-group ">
                        <label for="assistant_id" class="control-label col-sm-2">ผู้ช่วย </label>
                         <div class="col-sm-9">
                                <select class="form-control select2" name="assistant_id" style="width:100%" >
                                    <option value="">ไม่มี</option>
                                   <?php foreach ($assistants->result_array() as $row){ ?>
                                   <option value="<?= $row['assistant_id'] ?>"  ><?= $row['name'].' '.$row['surname']; ?></option>
                                   <?php } ?>
                               </select>
                           </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="control-label col-sm-2"> วันที่ขาด</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control datepicker"  name="absent_date"  data-date-format="dd-mm-yyyy"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#scheduleform').resetForm();
        $('#scheduleform input[name="type"]').val('1');
        $('#scheduleform2').resetForm();
        $('#scheduleform2 input[name="type"]').val('0');
        $('#absentform').resetForm();
        $('#scheduleTable').on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/get_schedule/' + $(this).data('id'), function(data) {
                if(data.schedule.doctor_id){
                    $('#scheduleform select[name="doctor_id"]').val(data.schedule.doctor_id);
                    $('#scheduleform input[name="start_date"]').val(data.schedule.start_date);
                   // $('#scheduleform input[name="end_date"]').val(data.schedule.end_date);
                    $('#scheduleform input[name="start_time"]').val(data.schedule.start_time);
                    $('#scheduleform input[name="end_time"]').val(data.schedule.end_time);
                    $('#scheduleform input[name="id"]').val(data.schedule.id);
                     $('#scheduleform select[name="doctor_id"]').trigger('change');
                    $('#addscheduleModal').modal('show');
                }else{

                    $('#scheduleform2 select[name="assistant_id"]').val(data.schedule.assistant_id);
                    $('#scheduleform2 input[name="start_date"]').val(data.schedule.start_date);
                   // $('#scheduleform input[name="end_date"]').val(data.schedule.end_date);
                    $('#scheduleform2 input[name="start_time"]').val(data.schedule.start_time);
                    $('#scheduleform2 input[name="end_time"]').val(data.schedule.end_time);
                    $('#scheduleform2 input[name="id"]').val(data.schedule.id);
                     $('#scheduleform2 select[name="assistant_id"]').trigger('change');
                      $('#addscheduleModal2').modal('show');
                }



            });
        });
         $('#absentTable').on('click', '.editable', function(evt) {
            evt.preventDefault();

            $.get('<?=base_url() ?>clinic/get_absent/' + $(this).data('id'), function(data) {
                if(data.absent.doctor_id){

                    $('#absentform select[name="doctor_id"]').val(data.absent.doctor_id);
                    $('#absentform input[name="absent_date"]').val(data.absent.absent_date);
                    $('#absentform input[name="id"]').val(data.absent.id);
                     $('#absentform select[name="doctor_id"]').trigger('change');
                    $('#addabsentModal').modal('show');
                }else{

                    $('#absentform2 select[name="assistant_id"]').val(data.absent.assistant_id);
                    $('#absentform2 input[name="absent_date"]').val(data.absent.absent_date);
                    $('#absentform2 input[name="id"]').val(data.absent.id);
                     $('#absentform2 select[name="assistant_id"]').trigger('change');
                    $('#addabsentModal2').modal('show');
                }

            });


        });
        $('#scheduleTable').on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/delete_schedule/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
         $('#absentTable').on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/delete_absent/' + $(this).data('id'), function(data) {
                recreateTable2();

            });

        });
        $('#addscheduleModal').on('hidden.bs.modal', function() {
            
            $('#scheduleform ').resetForm();
            $('#scheduleform input[name="type"]').val('1');
            $('#scheduleform select').trigger('change');
            $('#scheduleform  .validation-form').empty();
        });
         $('#addscheduleModal2').on('hidden.bs.modal', function() {
            
            $('#scheduleform2 ').resetForm();
            $('#scheduleform2 input[name="type"]').val('0');
            $('#scheduleform2 select').trigger('change');
            $('#scheduleform2 .validation-form').empty();
        });
        $('#addabsentModal').on('hidden.bs.modal', function() {
            
            $('#absentform ').resetForm();
            $('#absentform  select').trigger('change');
            $('#absentform .validation-form').empty();
        });
            $('#addabsentModal2').on('hidden.bs.modal', function() {
            
            $('#absentform2 ').resetForm();
            $('#absentform2 select').trigger('change');
            $('#absentform2 .validation-form').empty();
        });


        var scheduleTable = $('#scheduleTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>clinic/in/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {}, {},{},{}]
        });
        var absentTable = $('#absentTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>clinic/out/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {},  {},{},{}]
        });

        var recreateTable = function() {
            if (scheduleTable) {
                scheduleTable.destroy();
            }
            scheduleTable = $('#scheduleTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
           	    "ajax": '<?= base_url() ?>clinic/in/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {},{},{}]
            });
        }
         var recreateTable2 = function() {
            if (absentTable) {
                absentTable.destroy();
            }
            absentTable = $('#absentTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>clinic/out/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {},  {},{},{}]
            });
        }

        $('#scheduleform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('#scheduleform input[name="id"]').val().length > 0) {
                            $('#scheduleform input[name="id"]').val('');
                        }
                      
                         $('#scheduleform ').resetForm();

                        $('#scheduleform input[name="type"]').val('1');
                        $('#scheduleform .validation-form').empty();
                        $('#scheduleform select').trigger('change');
                        recreateTable();
                        $('#addscheduleModal').modal('hide');
                    } else {

                        $('#scheduleform .validation-form').empty();
                        $('#scheduleform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });
        $('#scheduleform2').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('#scheduleform2 input[name="id"]').val().length > 0) {
                            $('#scheduleform2 input[name="id"]').val('');
                        }
                         $('#scheduleform2').resetForm();

                         $('#scheduleform2 input[name="type"]').val('0');
                        $('#scheduleform2 .validation-form').empty();
                        $('#scheduleform2 select').trigger('change');
                        recreateTable();
                        $('#addscheduleModal2').modal('hide');
                    } else {

                        $('#scheduleform2 .validation-form').empty();
                        $('#scheduleform2 .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });
        $('#absentform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm2',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="id"]').val().length > 0) {
                            $('input[name="id"]').val('');
                        }
                      
                         $('#absentform ').resetForm();
                        $('#absentform .validation-form').empty();
                        $('#absentform select').trigger('change');
                        recreateTable2();
                        $('#addabsentModal').modal('hide');
                    } else {
                        $('#absentform .validation-form').empty();
                        $('#absentform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });
        $('#absentform2').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm2',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="id"]').val().length > 0) {
                            $('input[name="id"]').val('');
                        }
                      
                         $('#absentform2').resetForm();
                        $('#absentform2 .validation-form').empty();
                        $('#absentform2 select').trigger('change');
                        recreateTable2();
                        $('#addabsentModal2').modal('hide');
                    } else {
                        $('#absentform2 .validation-form').empty();
                        $('#absentform2 .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
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
    $('.datepicker').datepicker({
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
            }, 1);});
            
  
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
    .datepicker {
        z-index: 1151 !important;
    }

</style>