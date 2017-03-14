 
  <link rel="stylesheet" href="<?=base_url() ?>assets/plugins/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="<?=base_url() ?>assets/plugins/fullcalendar/fullcalendar.print.css" media="print">
<div class="col-xs-12" >
 <ul class="nav nav-pills">
    <li role="presentation" class="active"  ><a href="<?= base_url() ?>clinic">ตารางเวลา</a></li>
    <li role="presentation"  ><a href="<?= base_url() ?>clinic/inout" >ลงวันหยุด/วันเข้าพิเศษ</a></li>
    <li role="presentation"><a href="<?= base_url() ?>clinic/doctor">ทันตแพทย์</a></li>
    <li role="presentation" ><a href="<?= base_url() ?>clinic/assistant">ผู้ช่วย</a></li>
</ul>
<div class="form-group">
<select id="selectmode" name="selectmode" class="form-control" >
    <option value="0"> ดูทั้งหมด </option>
    <option value="1"> หมอ </option>
    <option value="2"> ผู้ช่วย </option>
</select>

</div>
    <div class="row">
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">

              <p>ทันตแพทย์</p>
            </div>
            <div class="icon2">
              <i class="fa  fa-user"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box " style="background-color:#ccc;">
            <div class="inner">

              <p>ผู้ช่วย</p>
            </div>
            <div class="icon2">
              <i class="fa  fa-user"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">

              <p>ทันตแพทย์ผู้เขี่ยวชาญ</p>
            </div>
            <div class="icon2">
              <i class="fa  fa-user"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">

              <p>ผู้ช่วยผู้เขี่ยวชาญ</p>
            </div>
            <div class="icon2">
              <i class="fa  fa-user"></i>
            </div>
          </div>
        </div>
         <!-- ./col -->
        <div class="col-lg-2 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <p>ลงเพิ่ม</p>
            </div>
            <div class="icon2">
              <i class="fa  fa-user"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>

	  <div class="box box-primary">
	    <div class="box-body no-padding">
	      <!-- THE CALENDAR -->
	      <div id="calendar"></div>
	    </div>
	    <!-- /.box-body -->
	  </div>
</div>



<!-- Slimscroll -->
<script src="<?=base_url() ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url() ?>assets/plugins/fastclick/fastclick.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?=base_url() ?>assets/plugins/fullcalendar/fullcalendar.js"></script>
<script>
    function getMonthFromString(mon){
        var d = Date.parse(mon + "1, 2012");
        if(!isNaN(d))
            return new Date(d).getMonth() + 1;
        return -1;
    }

 $('#calendar').fullCalendar({
 	 header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
    eventLimit: true, // for all non-agenda views
    views: {
        agenda: {
            eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
        },
        month: { // name of view
            displayEventEnd:true
            // other view-specific options here
        },
    },
     timeFormat: 'H:mm' ,
    events: function(start, end, timezone, callback) {
        $.ajax({
            url: '/dent/clinic/get_next_calendar/'+$('#selectmode').val(),
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: start.unix(),
                end: end.unix()
            },
            success: function(doc) {
            	console.log(doc);
                var events = [];
                for(var i = 0 ;i<doc.length; i++){
                	events.push(doc[i]);
                }
                callback(events);
            }
        });
    },

});
 $('#selectmode').change(function(){
  $('#calendar').fullCalendar( 'refetchEvents' );

 });
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
</style>