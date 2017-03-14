 
  <link rel="stylesheet" href="<?=base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="<?=base_url() ?>assets/plugins/fullcalendar/fullcalendar.print.css" media="print">

<script src="<?=base_url() ?>assets/js/fullcalendar.min.js"></script>

  <link rel="stylesheet" href="<?=base_url() ?>assets/css/scheduler.min.css">
  <script type="text/javascript" src="<?=base_url() ?>assets/js/scheduler.js"></script>
<div class="col-xs-12" >
 <ul class="nav nav-pills">
    <li role="presentation" class="active"  ><a href="<?= base_url() ?>clinic">นัดหมาย</a></li>
</ul>


	  <div class="box box-primary">
    <div class="row">
      <div class="col-md-12">
        <button type="button" class="btn btn-success" id="export" >export to PDF</button>
        </div>


        <div  class="col-md-12">
               <select class="form-control select2" name="view_doctor_id" id="view_doctor_id" style="width:100%" >
                       
               </select>
         </div>
      </div>
	    <div class="box-body no-padding">
	      <!-- THE CALENDAR -->

    <button class="btn small"  id="datepicker-select" data-date-format="yyyy-mm-dd" ><i class="fa  fa-calendar-o"></i></button>
	      <div id="calendar"></div>
	    </div>
	    <!-- /.box-body -->
	  </div>
     <div id="appointmentModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">ข้อมูลนัดหมาย</h4>
                </div>


                <form id="appointment-form" action="<?php echo base_url() ?>appointment/saveappointment" class="form-horizontal"> 
                  <div class="modal-body">
                       <div class="validation-form" id="echoForm"></div>
                       <input type="hidden" name="appointment_id" value="" />

                       <div class="form-group ">
                              <label for="name" class="control-label col-sm-4">ชื่อคนไข้ </label>
                              <div class="col-sm-8">
                                 <select class="form-control select2" name="client_id" style="width:100%" >
                                     <?php foreach ($clients->result_array() as $row){ ?>
                                     <option value="<?= $row['client_id'] ?>"  ><?= $row['name_thai'].' '.$row['surname_thai']; ?></option>
                                     <?php } ?>
                                 </select>
                              </div>
                       </div>
                       <div class="form-group ">
                              <label for="name" class="control-label col-sm-4">ชื่อคนไข้ (กรณีไม่มีประวัติ)</label>
                              <div class="col-sm-8">
                                <input type="text" name="custom_client"  class="form-control" />
                              </div>
                      </div>
                      <div class="form-group ">
                              <label for="name" class="control-label col-sm-4">เบอร์ติดต่อ</label>
                              <div class="col-sm-8">
                                <input type="text" name="phone_no"  class="form-control" />
                              </div>
                      </div>
                      <div class="form-group">
                              <label class="control-label col-sm-4"> ทันตแพทย์ </label>
                              <div class="col-sm-8">
                                  <select class="form-control select2" id="doctor_id" name="doctor_id" style="width:100%" >
                                      <?php foreach ($doctors->result_array() as $row){ ?>
                                     <option value="<?= $row['doctor_id'] ?>"  ><?= $row['name'].' '.$row['surname']; ?></option>
                                     <?php } ?>
                                 </select>
                             </div>
                       </div>
                       <div class="form-group">
                              
                            <button type="button" data-toggle="modal" data-target="#appointmentJobmodal" class="btn btn-primary">เพิ่ม</button>
                            <button type="button" data-toggle="modal" data-target="#errorAppointmentJobmodal" class="btn btn-danger">ลบ</button>

                              <label class="control-label col-sm-2"> งาน </label>
                              <div class="col-sm-8">
                                     <select class="form-control select2" name="job_id" style="width:100%" >
                                     <?php foreach ($jobs->result_array() as $row){ ?>
                                     <option value="<?= $row['job_id'] ?>"  ><?= $row['name']; ?></option>
                                     <?php } ?>
                                 </select>
                              </div>
                       </div>  
                        <div class="form-group">
                              <label class="control-label col-sm-4"> วันที่นัด </label>
                              <div class="col-sm-8">
                              <input type="text" id="datepicker2" class="form-control" name="appointment_date"  />
                             </div>
                       </div>
                       <div class="form-group">
                              <label class="control-label col-sm-2" >เรื่มต้น</label>
                              <div class="col-sm-4">

                               <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timeonly" name="start_time" />
                                    </div>
                              </div>
                              <label class="control-label col-sm-2" >สิ้นสุด</label>
                                <div class="col-sm-4">

                               <div class="bootstrap-timepicker">
                                    <input type="text" class="form-control timeonly" name="end_time" />
                                    </div>
                              </div>
                              
                       </div>

                       <div class="form-group">
                             <label class="control-label col-sm-4"> ระยะเวลา </label>
                              <div class="col-sm-8">
                                 <select class="form-control select2" id="select_period" name="period" style="width:100%" >
                                    <option value=""> ไม่ระบุ </option>
                                    <option value="15" >15 นาที</option>
                                    <option value="30" >30 นาที </option>
                                    <option value="45" >45 นาที</option>
                                    <option value="60" >60 นาที</option>  
                                 </select>
                              </div>
                       </div>
                       <div class="form-group ">
                             <label class="control-label col-sm-4"> NOTE </label>
                              <div class="col-sm-8">
                              <textarea name="note" class="form-control" rows="6"> </textarea>
                             </div>


                       </div>
                       <div class="form-group update_only">
                            <label class="control-label col-sm-4 "> สถานะ </label>
                            <div class="col-sm-8">
                              <div class="checkbox">
                                <label>
                                     <input type="checkbox"  name="confirm_first"  value="Y" />
                                            confirm ครั้งที่ 1

                                </label>
                              </div>
                              <div class="checkbox">
                                <label>
                                     <input type="checkbox"  name="confirm_second"  value="Y" />
                                            confirm ครั้งที่ 2

                                </label>
                              </div>
                            </div>
                       </div>
                  </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-danger pull-left btn-delete update_only" >ลบข้อมูล</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

                </form> 
            </div>
        </div>
    </div>
</div>



<!-- Slimscroll -->
<script src="<?=base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- fullCalendar 2.2.5 --><script>
jQuery(document).ready(function(){

    $('#datepicker2').datepicker({
        autoclose: true,
        dateFormat: 'dd-mm-yy',
    });
      $(".timeonly").timepicker({
          showMeridian: false,
          showSeconds:false,
          disableFocus:true,
      }).on('show.timepicker', function(e) {
             setTimeout(function(){
               $(e.target).prev().find('input[name="hour"]').focus();
            }, 1);
            
  });

      $('#select_period').change(function(){
         if($(this).val()){
          var start_time = $('input[name="start_time"]').val();
          var appointDate = $('input[name="appointment_date"]').val();
          var datetime = appointDate+' '+start_time;
          var current_time = moment(datetime,'DD-MM-YYYY HH:mm');
          var period = parseInt($(this).val());
          current_time.add(period, 'minute');
          $('input[name="end_time"]').val(current_time.format('HH:mm'));
        }
      });

      $('#appointmentModal').on('hidden.bs.modal', function () {

               $('#appointment-form').resetForm();
              $('.validation-form').empty();
              $('appointment-form select').trigger('change');
              $('.update_only').hide();
      });
      $('#export').click(function() {
    var moment = $('#calendar').fullCalendar('getDate');
    window.open('/dent/appointment/gen/<?=$view_doc_id ?>/'+moment.format('YYYY-MM-DD'));
});
   
});

  $('#appointment-form').find('.btn-delete').click(function(e){
      e.preventDefault(); // prevent native submit
      console.log('delete');

    $.ajax({
      type: "POST",
      url: '/dent/appointment/delete_appointment',
      data:{appointment_id:$('input[name="appointment_id"]').val()},
      success: function(data){
         $('#appointmentModal').modal('hide');
          $('#calendar').fullCalendar( 'refetchEvents' );
      },
    });
  });

    $('#appointment-form').on('submit', function(e) {
        e.preventDefault(); // prevent native submit
        $(this).ajaxSubmit({
            type: 'POST',
            dataType: 'json',
            target: '#echoForm',
            success: function(responseText, statusText, xhr, $form) {
                if (responseText.status == '1') {
                    if ($('input[name="appointment_id"]').val().length > 0) {
                        console.log('clear id');
                        $('input[name="appointment_id"]').val('');
                    }
                  
                     $('#appointmentform').resetForm();
                    $('.validation-form').empty();
                    $('#appointmentform select').trigger('change');
                    $('#appointmentModal').modal('hide');
                    $('#calendar').fullCalendar( 'refetchEvents' );
                } else {
                    
                    $('.validation-form').empty();
                    $('.validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                        responseText.message + '</div>');
                }

                // datatable.columns.adjust().draw(); // Redraw the DataTable
            }
        })
    });


  $(function() { // document ready

    $('#calendar').fullCalendar({
      allDaySlot:false,
      height:2000,
      maxTime:'22:00:00',
      minTime:'08:00:00',
    contentHeight:2000,
      eventStartEditable:false,
      eventDurationEditable:true,
      droppable:false,
viewRender: function(){ 
  $("#schedule_container").css('min-width',$('.fc-resource-cell').length*125);
  $('.fc-today-button').after($('#datepicker-select'));
},
    slotDuration:'00:15:00',
      schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
      defaultView: 'agendaDay',   
      resources:function(callback){
              setTimeout(function(){
              var view = $('#calendar').fullCalendar('getView');
              $.ajax({
                url: '/dent/appointment/getDoctorGroup/',
                dataType: 'json',
                cache: false,
                data: {
                    start: view.start.format(),
                    end: view.end.format(),
                    timezone: view.options.timezone
                 } 
          }).then(function(resources){

            var data_doc =[{id:0,text:'ไม่ระบุ'}];
            var newres = [];
            for(var i = 0; i< resources.length;i++)
            {
              data_doc.push({'id':resources[i].id,'text':resources[i].title});
              if(<?=$view_doc_id ?> == resources[i].id)
              {
                newres.push(resources[i]);
              }
            }
            $('.select2').select2();

            $('#view_doctor_id').unbind('change');
             $('#view_doctor_id').html('').select2({data:data_doc}).trigger('change');

            $('#view_doctor_id').val('<?=$view_doc_id ?>').trigger("change");
              $('#view_doctor_id').change(function(){ 
                if($(this).val()> 0){
                    window.location.replace('<?=base_url() ?>appointment/bydoctor/'+$(this).val());
                 }else{
                  window.location.replace('<?=base_url() ?>appointment');
                 }
              });

             //filter resources;

            callback(newres);

          });          
        },0);
      },
      refetchResourcesOnNavigate:true,
      selectable: true,
      eventLimit: true, // allow "more" link when too many events
      eventRender: function(event, element)
      { 
           $(element).find('.fc-title').html('<table class="table">'+
    '<tbody>'+
      '<tr>'+
        '<td>'+
        event.title+
        '</td>'+
        '<td>'+
        event.phone_no+
        '</td>'+
        '<td>'+
        event.job_name+
        '</td>'+
        '<td>'+
        event.note+
        '</td>'+
      '</tr>'+
       '<tbody>'+
       '</table>');
           return element;
      },
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'agendaDay'
      },

      //// uncomment this line to hide the all-day slot
      //allDaySlot: false,
 
     events: function(start, end, timezone, callback) {
        $.ajax({
            url: '/dent/appointment/getAppointmentGroupByDoctor/',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: start.unix(),
                end: end.unix()
            },
            success: function(doc) {
                var events = [];
                for(var i = 0 ;i<doc.length; i++){
                  events.push(doc[i]);
                }
                callback(events);
            }
        });
    },
    eventResize:function( event, delta, revertFunc, jsEvent, ui, view ) {
        var seconds = delta._milliseconds/1000;
        var end_time = event.end_time;
        var end_date = moment(end_time,'HH:mm');
        if(seconds >0){
         end_date.add(seconds,'second');
        }else{
          end_date.subtract(seconds,'second');
        }
        console.log(delta);
        var new_end_time = end_date.format('HH:mm');
         $.ajax({

            type: 'POST',
            url: '/dent/appointment/updateEndTime/',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                appointment_id: event.id.replace('appointment_id',''),
                end_time: new_end_time
            },
            success: function(doc) {
                console.log(doc);
            }
        });
    },
      eventClick: function(calEvent, jsEvent, view,resource) {

          // console.log(calEvent);
          // console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
          // console.log('View: ' + view.name);
          // console.log(resource);
          $('input[name="appointment_id"]').val(calEvent.id.replace('appointment_id',''));
          $('select[name="doctor_id"]').val(calEvent.doctor_id).trigger('change');
          $('select[name="client_id"]').val(calEvent.client_id).trigger('change');
          $('input[name="custom_client"').val(calEvent.custom_client);
          $('textarea[name="note"]').val(calEvent.note);
          $('select[name="job_id').val(calEvent.job_id).trigger('change');
          $('input[name="start_time"]').val(calEvent.start_time);
          $('input[name="end_time"]').val(calEvent.end_time);
          $('input[name="appointment_date"]').val(calEvent.appointment_date);
          $('input[name="phone_no"]').val(calEvent.phone_no);
          $('select[name="period"]').val(calEvent.period).trigger('change');
            if(calEvent.confirm_first == 'Y')
          {

            $("input[name='confirm_first']").prop("checked", true);
          }
          if(calEvent.confirm_second == 'Y')
          {

            $("input[name='confirm_second']").prop("checked", true);
          }
          $('#appointmentModal').modal('show');

          // change the border color just for fun
          $(this).css('border-color', 'red');

          $('.update_only').show();

      },
      dayClick: function(date, jsEvent, view, resource) {
        if(resource.id)
        {
            $('select[name="doctor_id"]').val(resource.id).trigger('change');
            $('input[name="appointment_date"]').val(date.format('DD-MM-YYYY'));
            $('input[name="start_time"]').val( date.format("HH:mm"));
            $('#appointmentModal').modal('show');
        }
      }
    });
    
    $('#datepicker-select').datepicker({
        inline: true,
        // onSelect: function(dateText, inst) {
        //     console.log('select');
        //     var d = new Date(dateText);
        //     $('#calendar').fullCalendar('gotoDate', d);
        // }
    }).on('changeDate', function (ev) {
       var d = new Date(ev.date);
      $('#calendar').fullCalendar('gotoDate', d);
  });

  });

function resourcesData(){
  return {
    start: $('#calendar').fullCalendar('getView').start.format(),
    end: $('#calendar').fullCalendar('getView').end.format()
  };
}
</script>
<style>
.small-box .icon{
    font-size:50px;
}
.small-box .icon2{
    position: absolute;
    top: -10px;
    right: 10px;
    z-index: 0;
    font-size:50px;
    color: rgba(0,0,0,0.15);
}
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

.update_only{
  display: none;
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
#calendar table {
    table-layout: fixed;
}
#calendar
{
    overflow-x:scroll;
}
.fc-time-grid-event.fc-short .fc-time{
  font-size:1em;
}
.fc-time-grid-event.fc-short .fc-title{

  font-size:1em;
}


</style>

</div>
<div id="errorAppointmentJobmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ลบข้อมูล งาน</h4>
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


<!-- Button trigger modal -->

<<div id="appointmentJobmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูล (งาน)</h4>
            </div>
            <div class="modal-body">
                <form id="jobform" class="form-horizontal">
                    <div class="form-group ">
                        <label for="service" class="control-label col-sm-3">งาน </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="job_name" name="job_name" />
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