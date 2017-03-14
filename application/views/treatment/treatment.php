<div class="col-xs-12">
 <ul class="nav nav-pills">
    <li role="presentation" ><a href="<?= base_url() ?>treatment">การรักษา</a></li>
 </ul>

 <div class="box">

    <div class="box-header with-border">

    <div class="box-title">
        การรักษา
    </div>
    </div>
    <div class="box-body ">
      <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addtreatmentModal" > เพิ่มการรักษา </button>
      <br class="clear"/>
      <div class="col-xs-12">
         <table id="treatmentTable" class="table display" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th></th>
                  <th>รหัส</th>
                  <th>ชื่อการรักษา</th>
                  <th>Unit</th>
                  <th>ราคา</th>
              </tr>
          </thead>
      </table>
  </div>
</div>

</div>

<div id="addtreatmentModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">ข้อมูลผู้ช่วย</h4>
              </div>

              <form id="treatmentform" action="<?php echo base_url() ?>treatment/savetreatment" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="treatment_id" value="" />
                      <div class="form-group" >
                      <label  class="control-label col-sm-2" for="code">รหัส</label>
                      <div class="col-sm-5">
                        <input type="text" id="code" name="code" class="form-control"  placeholder=""/>
                      </div>
                      </div>
                    <div class="form-group" >
                      <label  class="control-label col-sm-2" for="name">ชื่อ</label>
                      <div class="col-sm-5">
                        <input type="text" id="name" name="name" class="form-control"  placeholder=""/>
                    </div>
                    <label  class="control-label col-sm-1" for="price">ราคา</label>
                    <div class="col-sm-2">
                        <input type="text" id="price" name="price" class="form-control"  placeholder=""/>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-2"> ประเภทการรักษา </label>
                <div class="col-sm-5">
                    <select class="form-control select2" name="parent_id" style="width:100%" >
                       <?php foreach ($treatment_parent->result_array() as $row){ ?>
                       <option value="<?= $row['treatment_id'] ?>"  <?php echo set_select('bank', $row['parent_id'], isset($bank)?$row['treatment_id']==$parent_id:$row['treatment_id']==""); ?>><?= $row['name']; ?></option>
                       <?php } ?>
                   </select>
               </div>  
                <label  class="control-label col-sm-1" for="unit">หน่วย</label>
                    <div class="col-sm-2">
                        <input type="text" id="unit" name="unit" class="form-control"  placeholder=""/>
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

        $('#treatmentform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>treatment/get_treatment/' + $(this).data('id'), function(data) {
                $('input[name="name"]').val(data.treatment.name);
                $('input[name="code"]').val(data.treatment.code);
                $('input[name="price"]').val(data.treatment.price);
                $('input[name="unit"]').val(data.treatment.unit);
                $('input[name="treatment_id"]').val(data.treatment.treatment_id);
                $('select[name="parent_id"]').val(data.treatment.parent_id);
                $('select[name="parent_id"]').trigger('change');

                $('#addtreatmentModal').modal('show');

            });


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>treatment/delete_treatment/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
        $('#addtreatmentModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="treatment_id"]').val().length > 0) {
                $('input[name="treatment_id"]').val('');
            }
            $('#treatmentform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var treatmentTable = $('#treatmentTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>treatment/listtreatment/',
            "lengthMenu": [[ 25, 50, -1], [25, 50, "All"]],
            columns: [{
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>'+'&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {}, {}, {}, {}]
        });

        var recreateTable = function() {
            if (treatmentTable) {
                treatmentTable.destroy();
            }
            treatmentTable = $('#treatmentTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>treatment/listtreatment/',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {}, {}]
            });
        }

        $('#treatmentform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="treatment_id"]').val().length > 0) {
                            $('input[name="treatment_id"]').val('');
                        }

                        $('#treatmentform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addtreatmentModal').modal('hide');
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