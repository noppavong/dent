<button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addLabModal"> เพิ่มแล็บ  </button>
    <table id="labTable" class="table display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>วันที่ส่ง</th>
                <th>ทันตแพทย์</th>
                <th>ชื่อแล๊บ</th>
                <th>ชิ้นงาน</th>
                <th>ราคา</th>
                <th>สถานะ</th>
            </tr>
        </thead>
    </table>

<div id="addLabModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูลแล็บ</h4>
            </div>

            <form id="labform" action="<?php echo base_url() ?>ajax/labsave" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>

                    <input type="hidden" name="client_id" value="<?=$client_id?>" />
                    <input type="hidden" name="trans_id" value="" />
                    <div class="form-group ">
                        <label for="lab" class="control-label col-sm-2">ชื่อ แล็บ</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="lab" style="width:100%">
                  <?php foreach ($labs->result_array() as $row){ ?>
                  <option value="<?= $row['lab_id'] ?>"><?= $row['name']; ?></option>
                  <?php } ?>
              </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="service" class="control-label col-sm-2">ชื่อ บริการ</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="service" style="width:100%">
              <?php foreach ($services->result_array() as $row){ ?>
              <option value="<?= $row['service_id'] ?>"   ><?= $row['name']; ?> </option>
              <?php } ?>
          </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="doctor" class="control-label col-sm-2"> ทันตแพทย์</label>
                        <div class="col-sm-8">
                            <select class="form-control select2 " name="doctor" style="width:100%">
          <?php foreach ($q_doctors->result_array() as $row){ ?>
          <option value="<?= $row['doctor_id'] ?>"   ><?= $row['name']; ?> <?= $row['surname']; ?></option>
          <?php } ?>
      </select>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="namethai">สถานะ</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
        <input name="is_received" type="checkbox" value="Y" > ได้รับแล้ว
    </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="send_date" class="control-label col-sm-2">วันที่ส่ง</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="datepicker2" name="send_date" class="form-control pull-right " data-date-format="dd-mm-yyyy">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="control-label col-sm-2"> ราคา </label>
                        <div class="col-sm-8">
                            <input type="text" id="price" name="price" class="form-control" />

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remark" class="control-label col-sm-2">หมายเหตุ</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="remark" rows="5" placeholder="หมายเหตุ ..."></textarea>
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
<script >
    var labTable = $('#labTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>ajax/listbyclient_id/<?=$client_id; ?>',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {}, {}, {}, {}]
            });
 $('#addLabModal').on('hidden.bs.modal', function() {
        // do something…
        if ($('#labform input[name="trans_id"]').val().length > 0) {
            $('#labform input[name="trans_id"]').val('');
        }
        $('#labform input[type="text"]', '#labform input[type="checkbox"]', '#labform select', '#labform textarea').clearFields();
        $('#labform select').trigger('change');
        $('#labform .validation-form').empty();
    });
    $(document).on('click', '.editable', function(evt) {
        evt.preventDefault();
        $.get('<?=base_url() ?>ajax/get_lab/' + $(this).data('id'), function(data) {
            $('#labform select[name="service"]').val(data.service).trigger('change');
            $('#labform select[name="doctor"]').val(data.doctor).trigger('change');
            $('#labform select[name="lab"]').val(data.lab).trigger('change');
            $('#labform input[name="price"]').val(data.price);
            $('#labform input[name="send_date"]').val(data.send_date);

            $('#labform textarea[name="remark"]').val(data.remark);
            $('#labform input[name="trans_id"]').val(data.trans_id);
            if (data.is_received == 'Y') {
                $('#labform input[name="is_received"]').attr('checked', true);
            }
            $('#addLabModal').modal('show');
        });


    });
    var recreateTable = function() {
            if (labTable) {
                labTable.destroy();
            }
            labTable = $('#labTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                 "autoWidth": false,
          
                "ajax": '<?= base_url() ?>ajax/listbyclient_id/<?=$client_id; ?>',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable" data-id="' + data + '">แก้ไข </a>&nbsp;&nbsp;&nbsp;&nbsp;<a  href="#" class="deleteable" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {}, {}, {}, {}, {}, {}]
            });
        };

        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>ajax/delete_labts/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
         $('#labform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('#labform input[name="trans_id"]').val().length > 0) {
                            $('#labform input[name="trans_id"]').val('');
                        }
                        $('#labform input[type="text"]', '#labform input[type="checkbox"]', '#labform select', '#labform textarea').clearFields();
                        $('#labform .validation-form').empty();
                        $('#labform select').trigger('change');
                        recreateTable();
                        $('#addLabModal').modal('hide');
                    } else {
                        $('#labform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });

</script>