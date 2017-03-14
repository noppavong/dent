<div class="col-xs-12">
 <ul class="nav nav-pills">
 	<li role="presentation" ><a href="<?= base_url() ?>clinic">ตารางเวลา</a></li>
 	<li role="presentation" ><a href="<?= base_url() ?>clinic/inout" >ลงวันหยุด/วันเข้าพิเศษ</a></li>
 	<li role="presentation" ><a href="<?= base_url() ?>clinic/doctor">ทันตแพทย์</a></li>
 	<li role="presentation" class="active"><a href="<?= base_url() ?>clinic/assistant">ผู้ช่วย</a></li>
 </ul>

 <div class="box">

    <div class="box-header with-border">

    <div class="box-title">
        ผู้ช่วย
    </div>
    </div>
 	<div class="box-body ">
      <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addassistantModal" > เพิ่มผู้ช่วย </button>
      <br class="clear"/>
      <div class="col-xs-12">
         <table id="assistantTable" class="table display" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th></th>
                  <th>ชื่อ นามสกุล</th>
                  <th>เบอร์โทรศัพท์</th>
                  <th>เชี่ยวชาญ </th>
              </tr>
          </thead>
      </table>
  </div>
</div>

</div>

<div id="addassistantModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">ข้อมูลผู้ช่วย</h4>
              </div>

              <form id="assistantform" action="<?php echo base_url() ?>clinic/saveassistant" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="assistant_id" value="" />
                    <div class="form-group" >
                      <label  class="control-label col-sm-2" for="name">ชื่อ</label>
                      <div class="col-sm-3">
                        <input type="text" id="name" name="name" class="form-control"  placeholder=""/>
                    </div>
                    <label  class="control-label col-sm-2" for="salary">เงินเดือน</label>
                    <div class="col-sm-3">
                        <input type="text" readonly id="salary" name="salary" class="form-control"  placeholder=""/>
                    </div>
                </div>
                <div class="form-group">
                  <label  class="control-label col-sm-2" for="surname">นามสกุล</label>
                  <div class="col-sm-3">
                    <input type="text" id="surname" name="surname" class="form-control"  />
                </div>
                <label  class="control-label col-sm-2" for="account_no">เลขบัญชี</label>
                <div class="col-sm-3">
                    <input type="text" id="account_no" name="account_no" class="form-control"  placeholder="" />
                </div>
            </div>
            <div class="form-group">
              <label  class="control-label col-sm-2" for="phone_no">โทรศัพท์</label>
              <div class="col-sm-3">
                <input type="text" id="phone_no" name="phone_no" class="form-control"  value="<?=set_value('phone_no',(isset($phone_no))?$phone_no:""); ?>">
            </div>
            <label class="control-label col-sm-2"> ธนาคาร </label>
            <div class="col-sm-3">
                <select class="form-control select2" name="bank" style="width:100%" >
                   <?php foreach ($banks->result_array() as $row){ ?>
                   <option value="<?= $row['bank_id'] ?>"  <?php echo set_select('bank', $row['bank_id'], isset($bank)?$row['bank_id']==$bank:$row['bank_id']==""); ?>><?= $row['name']; ?></option>
                   <?php } ?>
               </select>
           </div>
       </div>
       <div class="form-group">
          <label  class="control-label col-sm-2">  งานที่ถนัด</label>
          <div class="col-sm-7">

            <?= form_multiselect('skill[]', $skills,"",array('class'=>'form-control select2',"style"=>"width:100%")); ?>

                   </div>
           </div>
           <div class="form-group">
          <label  class="control-label col-sm-2">  วันหยุด</label>
          <div class="col-sm-7">

            <?= form_multiselect('holiday[]', $holidays,"",array('class'=>'form-control select2',"style"=>"width:100%")); ?>
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
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#assistantform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/get_assistant/' + $(this).data('id'), function(data) {
                $('input[name="name"]').val(data.assistant.name);
                $('input[name="surname"]').val(data.assistant.surname);
                $('input[name="phone_no"]').val(data.assistant.phone_no);
                $('input[name="md_no"]').val(data.assistant.md_no);
                $('input[name="account_no"]').val(data.assistant.account_no);
                $('input[name="share_percentage"]').val(data.assistant.share_percentage);
                $('input[name="assistant_id"]').val(data.assistant.assistant_id);
                var selectedValues = [];
                for(var i = 0; i< data.assistant_skill.length ; i++)
                {

                    selectedValues.push(parseInt(data.assistant_skill[i].skill_id));
                }
                
                var selectedHoliday = [];
                for(var i =0; i< data.assistant_holiday.length;i++)
                {
                     selectedHoliday.push(parseInt(data.assistant_holiday[i].holiday_id));
                }
                $('select[name="holiday[]"]').select2('val',[selectedHoliday]);
                $('select[name="skill[]"]').select2('val',[selectedValues]);

                $('#addassistantModal').modal('show');

            });


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>clinic/delete_assistant/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
        $('#addassistantModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="assistant_id"]').val().length > 0) {
                $('input[name="assistant_id"]').val('');
            }
            $('#assistantform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var assistantTable = $('#assistantTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>clinic/listassistant/',
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>'+'&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="viewable" data-id="' + data + '">ดู </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {}, {}]
        });

        var recreateTable = function() {
            if (assistantTable) {
                assistantTable.destroy();
            }
            assistantTable = $('#assistantTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>clinic/listassistant/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>'+'&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="viewable" data-id="' + data + '">ดู </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {}]
            });
        }

        $('#assistantform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="assistant_id"]').val().length > 0) {
                            $('input[name="assistant_id"]').val('');
                        }

                        $('#assistantform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addassistantModal').modal('hide');
                    } else {
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
   showMeridian: false
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
table.timesetup {
    empty-cells: show;
    border: 1px solid #000;
}
table.timesetup th{
    text-align:center;
}
table.timesetup th,.timesetup td {
    min-width: 2em;
    min-height: 2em;
    border: 1px solid #000!important;

}
.timesetup>tbody>tr>th{

    border-left: 1px solid #000!important;
}

</style>