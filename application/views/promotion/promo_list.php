
<section class="content-header">
<ul class="nav nav-pills">
    <li role="presentation"><a href="<?= base_url() ?>promotion">รายการรักษาต่อเนื่อง</a></li>
    <li role="presentation"  class="active"><a href="<?= base_url() ?>promotion/promos" >promotion</a></li>
</ul>
</section>

<div class="col-xs-12">


 <div class="box">

    <div class="box-header with-border">

    <div class="box-title">
        promotion
    </div>
    </div>
    <div class="box-body ">
      <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addpromotionModal" > เพิ่ม promotion </button>
      <br class="clear"/>
      <div class="col-xs-12">
         <table id="promotionTable" class="table display" cellspacing="0" width="100%">
            <thead>
               <tr>
                  <th></th>
                  <th>รหัส</th>
                  <th>ชื่อ</th>
                  <th>ราคา</th>
                  <th>จำนวนครั้ง</th>
              </tr>
          </thead>
      </table>
  </div>
</div>

</div>

<div id="addpromotionModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">promotion</h4>
              </div>

              <form id="promotionform" action="<?php echo base_url() ?>promotion/savepromotion" class="form-horizontal">
                <div class="modal-body">
                    <div class="validation-form" id="echoForm"></div>
                    <input type="hidden" name="promotion_id" value="" />
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
                    </div>

                    <div class="form-group" >
                      <label  class="control-label col-sm-2" for="sumprice">ราคา</label>
                      <div class="col-sm-3">
                        <input type="text" id="sumprice" name="sumprice" class="form-control"  placeholder=""/>
                    </div>

                    <label  class="control-label col-sm-2" for="times">จำนวนครั้ง</label>
                      <div class="col-sm-3">

                        <select name="times" class="form-control select2" > 
                            <?php for($i = 0;$i < 100;$i++) { ?>
                                <option value="<?=$i; ?>" > <?=$i; ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                  </div>
                     

                <div id="well-promo" style="max-height: 400px;overflow-y: scroll;">
                      <div class="well">
                             <div class="form-group ">
                                    <label for="lab" class="control-label col-sm-1">ครั้งที่</label>
                                    <div class="col-sm-2">
                                    <select class="form-control select2 start" name="start[]" style="width:100%">
                                            <?php for($i = 0;$i < 100;$i++) { ?>
                                                <option value="<?=$i; ?>" > <?=$i; ?> </option>
                                            <?php } ?>
                                  </select>
                                  </div>
                                    <label for="lab" class="control-label col-sm-1">ถึง</label>
                                     <div class="col-sm-2">
                                   <select class="form-control select2 end" name="end[]" style="width:100%">
                                              <?php for($i = 0;$i < 100;$i++) { ?>
                                                <option value="<?=$i; ?>" > <?=$i; ?> </option>
                                            <?php } ?>
                                  </select> 
                                  </div>
                                  <label for="lab" class="control-label col-sm-1">ราคา</label>
                                    
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control installment" name="installment[]"  />
                                    </div>
                                    <div class="col-md-2">
                                         <button type="button" id="add_tier" class="btn btn-success  btn-add pull-right" style="margin-right: 10%" >เพิ่ม</button>
                   

                                    </div>

                            </div>
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
</div>
<script type="text/javascript">
    $(document).ready(function() {

        $('#add_tier').click(function(){
            console.log('add tier');
            var source   = $("#entry-template").html();
            var template = Handlebars.compile(source);
            console.log(template);
            $('#addpromotionModal').find('.modal-body').find('#well-promo').append(template);
            $('.select2').select2();

        });

        $(document).on('click','.btn-delete-plan',function(){
            $(this).parent().parent().parent().remove();
        });


        $('#promotionform ').resetForm();
        $(document).on('click', '.editable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>promotion/get_promotion/' + $(this).data('id'), function(data) {
                $('input[name="name"]').val(data.promotion.name);
                $('input[name="code"]').val(data.promotion.code);
                $('input[name="sumprice"]').val(data.promotion.sum_price);
                $('select[name="times"]').val(data.promotion.times).trigger('change');
                $('input[name="promotion_id"]').val(data.promotion.promotion_id);
                if(data['tier']){
                    for(var i = 0; i< data['tier'].length; i++)
                    {
                        if(i == 0)
                        {   
                            $('.well .installment').val(data['tier'][i]['installment']);
                            $('.well .start').val(data['tier'][i]['start']).trigger('change');
                            $('.well .end').val(data['tier'][i]['end']).trigger('change');
                        }else{

                            var source   = $("#entry-template").html();
                            var template = Handlebars.compile(source);
                            $('#addpromotionModal').find('.modal-body').find('#well-promo').append(template);
                            $('.additional .installment').val(data['tier'][i]['installment']);
                            $('.additional .start').val(data['tier'][i]['start']).trigger('change');
                            $('.additional .end').val(data['tier'][i]['end']).trigger('change');
                        }
                    }
                }
                $('#addpromotionModal').modal('show');

            });


        });
        $(document).on('click', '.deleteable', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>promotion/delete_promotion/' + $(this).data('id'), function(data) {
                recreateTable();

            });

        });
        $('#addpromotionModal').on('hidden.bs.modal', function() {
            // do something…
            if ($('input[name="promotion_id"]').val().length > 0) {
                $('input[name="promotion_id"]').val('');
            }
            $('#promotionform ').resetForm();
            $('select').trigger('change');
            $('.validation-form').empty();
            $('.additional').remove();
        });
        $('#price').mask("##0.00", {
            reverse: true
        });
        var promotionTable = $('#promotionTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "ajax": '<?= base_url() ?>promotion/listpromotion/',
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
            if (promotionTable) {
                promotionTable.destroy();
            }

            promotionTable = $('#promotionTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "ajax": '<?= base_url() ?>promotion/listpromotion/',
            "lengthMenu": [[ 25, 50, -1], [25, 50, "All"]],
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

        $('#promotionform').on('submit', function(e) {
          e.preventDefault();
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                        if ($('input[name="promotion_id"]').val().length > 0) {
                            $('input[name="promotion_id"]').val('');
                        }

                        $('#promotionform ').resetForm();
                        $('.validation-form').empty();
                        $('select').trigger('change');
                        recreateTable();
                        $('#addpromotionModal').modal('hide');
                    } else {
                        $('.validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            });
        });

        $('.select2').select2();
        $('#promotionform').preventDoubleSubmission();
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

<script id="entry-template" type="text/x-handlebars-template">
   
<div class="well additional">
         <div class="form-group ">
                <label for="lab" class="control-label col-sm-1">ครั้งที่</label>
                <div class="col-sm-2">
                <select class="form-control select2 start" name="start[]" style="width:100%">
                        <?php for($i = 0;$i < 100;$i++) { ?>
                            <option value="<?=$i; ?>" > <?=$i; ?> </option>
                        <?php } ?>
              </select>
              </div>
                <label for="lab" class="control-label col-sm-1">ถึง</label>
                 <div class="col-sm-2">
               <select class="form-control select2 end" name="end[]" style="width:100%">
                          <?php for($i = 0;$i < 100;$i++) { ?>
                            <option value="<?=$i; ?>" > <?=$i; ?> </option>
                        <?php } ?>
              </select> 
              </div>
              <label for="lab" class="control-label col-sm-1">ราคา</label>
                
                <div class="col-sm-3">
                    <input type="text" class="form-control installment" name="installment[]"  />
                </div>
                <div class="col-sm-2">
            <button type="button" class="btn btn-danger btn-cancel btn-delete-plan pull-right" style="margin-right: 10%">ลบ</button>
            </div>
            </div>
       
  </div>
  </script>