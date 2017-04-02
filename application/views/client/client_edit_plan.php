    
    <button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addPlanModal"> เพิ่มบันทึกการักษา  </button>
    <table id="treatmentTable" class="table display" cellspacing="0" width="100%" style="table-layout: fixed;
    word-wrap: break-word;">
        <thead>
            <tr>
                <th></th>
                <th>วันที่</th>
                <th>รายการรักษา</th>
                <th>รายละเอียด</th>
                <th>REFER</th>
                <th>ทันตแพทย์</th>
            </tr>
        </thead>
    </table>

    <div id="rel_treatment" style="display:none">   
    <?= $relation_treatment ?>
    </div>
    <div id="inner_treatment" style="display:none">

    <?= $inner_treatment ?>
    </div>
    <div id="addPlanModal" class="modal  fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">เพิ่มข้อมูลการรักษา</h4>
            </div>
            <form id="planform" action="<?php echo base_url() ?>ajax/planadd" class="form-horizontal">
                
            <div class="modal-body">

               <input type="hidden" name="client_id" value="<?=$client_id?>" />
                <input type="hidden" name="plan_id" value="" />
                <div class="form-group" >
                   <label for="doctor_id" class="control-label col-sm-2">ทันตแพทย์</label>
                     <div class="col-sm-4">
                        <select class="form-control select2 " name="doctor_id" style="width:100%">
                       <option value="">ระบุ</option>
                          <?php foreach ($q_doctors->result_array() as $row){ ?>
                          <option value="<?= $row['doctor_id'] ?>"   ><?= $row['name']; ?> <?= $row['surname']; ?></option>
                          <?php } ?>
                      </select>

                      </div>
                        <label for="" class="control-label col-sm-2">วันที่รักษา</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control date2" id="treatment_date" name="treatment_date" value="<?php echo date('d-m-Y'); ?>" />
                            </div>
                </div>

                <div id="well-treatment" style="max-height: 400px;overflow-y: scroll;">

                <div class="well">
                            <div class="form-group ">
                                    <label for="lab" class="control-label col-sm-2">ประเภทการรักษา</label>
                                    <div class="col-sm-4">
                                    <select class="form-control select2" name="parent_treatment_id[]" style="width:100%">
                                        <option value="">ระบุประเภท</option>
                                      <?php foreach ($parent_treatment->result_array() as $row){ ?>
                                      <option value="<?= $row['treatment_id'] ?>"><?= $row['name']; ?></option>
                                      <?php } ?>
                                  </select>
                                  </div>
                                  <label for="lab" class="control-label col-sm-2">การรักษา</label>
                                    <div class="col-sm-4">
                                    <select class="form-control select2 child" name="treatment_id[]" style="width:100%">
                                        <option value="">ระบุประเภท</option>
                                    
                                  </select>
                                   <input type="text" class="form-control other_treatment" name="other_treatment[]" placeholder="ระบุ" style="display:none" />
                                  </div>
                            </div>
                            <div class="form-group">
                                 <label for="" class="control-label col-sm-2">จำนวน<span class="unit"></span></label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control quantity" name="quantity[]" />
                                </div>
                                 <label for="" class="control-label col-sm-2">ราคา</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control price" name="price[]" placeholder="0.00" />
                                </div>
                            </div>

                        </div>

                </div>
                </div>

                   <button type="button" id="add_plan" class="btn btn-success  btn-add pull-right" style="margin-right: 10%" >เพิ่ม</button>
                  
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2" > Note </label>
                        <div class="col-md-8">
                            <textarea rows='6' class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2" > REFERER </label>
                        <div class="col-md-8">
                            <textarea rows='6' class="form-control" name="refer"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label col-sm-2" ><h3 style="color:#00a65a;"> รวม</h3> </label>
                        <div class="col-md-8  "  style="color:#00a65a;">
                        <label for="" class="control-label col-sm-2" > <h3 class="sumprice" style="color:#00a65a;"> 0.00 </h3></label>
                        </div>
                    </div>
                <div class="modal-footer">


                    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-save">บันทึก</button>
                </div>

            </form>
    </div>
</div>
<script type="text/javascript">

        var treatmentTable = $('#treatmentTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
             "order": [],
            "info": true,
             "autoWidth": false,
                "columnDefs": [
                    { width: '8%', targets: 'no-sort',"orderable": false }, 
                    { width: '10%', targets: 1 },
                    { width: '30%', targets: 2 },
                    { width: '30%', targets: 3 },
                    { width: '10%', targets: 4 },
                    { width: '12%', targets: 5 },
                ],
            "ajax": '<?= base_url() ?>ajax/treatmentsbyclient/<?=$client_id; ?>',
            columns: [{
                "orderable": false ,
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<a  href="#" class="editable-plan" data-id="' + data + '">แก้ไข </a><a  href="#" class="deleteable2" data-id="' + data + '">ลบ </a>';
                    }
                    return data;
                },
                className: "dt-body-center"
            }, {},{}, {}, {}, {}]
        });
      

          var recreateTreatmentTable = function() {
            if (treatmentTable) {
                treatmentTable.destroy();
            }
            treatmentTable = $('#treatmentTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "fixedColumns": true,
            "autoWidth": false,
                 "columnDefs": [
                    { width: '8%', targets: 0 },
                    { width: '10%', targets: 1 },
                    { width: '30%', targets: 2 },
                    { width: '30%', targets: 3 },
                    { width: '10%', targets: 4 },
                    { width: '12%', targets: 5 },
                ],
                "ajax": '<?= base_url() ?>ajax/treatmentsbyclient/<?=$client_id; ?>',
                columns: [{
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return '<a  href="#" class="editable-plan" data-id="' + data + '">แก้ไข </a><a  href="#" class="deleteable2" data-id="' + data + '">ลบ </a>';
                        }
                        return data;
                    },
                    className: "dt-body-center"
                }, {},{}, {}, {}, {}]
            });
        }

       
        $(document).on('click', '.editable-plan', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>ajax/get_plan/' + $(this).data('id'), function(data) {
                $('#planform select[name="treatment_id"]').val(data.treatment_id).trigger('change');
                $('#planform input[name="treatment_date"]').val(data.treatment_date);
                $('#planform textarea[name="description"]').val(data.description);
                $('#planform input[name="plan_id"]').val(data.plan_id);
                $('#planform select[name="doctor_id"]').val(data.doctor_id).trigger('change');
                if(data['treatment_list']){
                    for(var i = 0; i< data['treatment_list'].length; i++)
                    {
                        if(i == 0)
                        {   
                            $('.well select[name="parent_treatment_id[]"]').val(data['treatment_list'][i]['parent_id']).trigger('change');
                            $('.well select[name="treatment_id[]"]').val(data['treatment_list'][i]['treatment_id']).trigger('change');
                            $('.well .price').val(data['treatment_list'][i]['price_t']);
                            $('.well .other_treatment').val(data['treatment_list'][i]['other_treatment']);
                            $('.well .quantity').val(data['treatment_list'][i]['quantity']);
                        }else{

                            console.log(data['treatment_list'][i]['parent_id']);
                            var source   = $("#entry-template").html();
                            var template = Handlebars.compile(source);
                            $('#addPlanModal').find('.modal-body').find('#well-treatment').append(template);
                            $('.select2').select2();

                            $('.additional select[name="parent_treatment_id[]"]').last().val(data['treatment_list'][i]['parent_id']).trigger('change');
                            $('.additional select[name="treatment_id[]"]').last().val(data['treatment_list'][i]['treatment_id']).trigger('change');
                            $('.additional .price').last().val(data['treatment_list'][i]['price_t']);
                            $('.additional .other_treatment').last().val(data['treatment_list'][i]['other_treatment']);
                            $('.additional .quantity').last().val(data['treatment_list'][i]['quantity']);
                        }
                    }
                     calculateSum();
                }
               
                $('#addPlanModal').modal('show');

            });
        });
         $(document).on('click', '.deleteable2', function(evt) {
            evt.preventDefault();
            $.get('<?=base_url() ?>ajax/delete_plan/' + $(this).data('id'), function(data) {
                recreateTreatmentTable();

            });

        });

        $('#planform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm2',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                      
                       resetPlanForm();
                        recreateTreatmentTable();
                        $('#addPlanModal').modal('hide');
                    } else {
                        $('#planform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });
        $('#editplanform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#echoForm2',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                      
                        $('#planform input[type="text"]', '#planform input[type="checkbox"]','#planform textarea').clearFields();
                        $('#planform .validation-form').empty();
                        $('#planform input[name="plan_id"]').val();
                        $('#planform select').trigger('change');
                        recreateTreatmentTable();
                        $('#editPlanModal').modal('hide');
                    } else {
                        $('#planform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
                            responseText.message + '</div>');
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });

        $('#add_plan').click(function(){
            var source   = $("#entry-template").html();
            var template = Handlebars.compile(source);
            $('#addPlanModal').find('.modal-body').find('#well-treatment').append(template);
            $('.select2').select2();

        });

        var  treatment_rel = JSON.parse($('#rel_treatment').html());
        var inner_treatment = JSON.parse($('#inner_treatment').html());
        $(document).on('change','select[name="parent_treatment_id[]"]',function(evt){
            var parent = evt.target.value;
            if(parent){

                 var dataOptions = [];
                
                for(var i=0;  i< treatment_rel[parent].length; i++)
                {
                    dataOptions.push({ id: treatment_rel[parent][i]['treatment_id'] ,
                    text:  treatment_rel[parent][i]['name']});
                }
                    //  $(evt.target).parent().parent().parent().find(".child").select2('destroy').empty().select2({data:dataOptions}).trigger('change');
                      $(evt.target).parent().parent().parent().find('.other_treatment').val('');
                        $(evt.target).parent().parent().parent().find('.other_treatment').hide();
                        $(evt.target).parent().parent().parent().find(".child").select2().select2('destroy').empty().select2({data:dataOptions}).trigger('change');
            
                if(evt.target.value==999)
                {
                      $(evt.target).parent().parent().parent().find('.other_treatment').show();
                      $(evt.target).parent().parent().parent().find('.price').attr("placeholder","0.00");
                    calculateSum();
                }
            }else{
                  $(evt.target).parent().parent().parent().find(".child").select2().select2('destroy').empty().select2({data:[{id:'',text:"ระบุประเภท"}]}).trigger('change');
            }

        });
         $(document).on('change','.child',function(evt){
            if(inner_treatment[evt.target.value]){
                $(evt.target).parent().parent().parent().find('.price').val('');
            var quantity =  $(evt.target).parent().parent().parent().find('.quantity').val()||1;
            $(evt.target).parent().parent().parent().find('.quantity').parent().find('unit').html(inner_treatment[evt.target.value]['unit']);
            $(evt.target).parent().parent().parent().find('.price').attr("placeholder",inner_treatment[evt.target.value]['price'] * quantity);
               calculateSum();
            }else{
                $(evt.target).parent().parent().parent().find('.price').val('');
                 $(evt.target).parent().parent().parent().find('.price').attr("placeholder","0.00");
                 calculateSum();
            }
        });
          var calculateSum = function(){
            var sum = 0;
                $('.price').each(function(){
                    var price = parseFloat($(this).val());
                    
                    if(!price || isNaN(price))
                    {
                         price = parseFloat($(this).attr('placeholder'));
                    }
                    sum += price;

                });
                $('.sumprice').html(sum);
        }
       $(document).on('change','.quantity',function(evt){
            var price =0;
            if(inner_treatment[$(evt.target).parent().parent().parent().find('.child').val()]['price']){    
             price = inner_treatment[$(evt.target).parent().parent().parent().find('.child').val()]['price']||0;
            }

              $(evt.target).parent().parent().parent().find('.price').attr("placeholder", price* evt.target.value);
              calculateSum();
        });
       $(document).on('change','.price',function(){
          calculateSum();
       });
        $(document).on('click','.btn-delete-plan',function(){
            $(this).parent().remove();
        });
        var resetPlanForm = function(){
            $('.additional').remove();  
            $('#planform input[type="text"]').not('[name="treatment_date"]').val('');
            $('#planform select').val('');
            $('#planform textarea').val('');
            $('#editplanform input[name="plan_id"]').val('');
            $('#planform .validation-form').empty();
            $('#planform input[name="plan_id"]').val();
            $('#planform select').trigger('change');
            // calculateSum();
        }
        $('#addPlanModal').on('hidden.bs.modal', function () {
            resetPlanForm();
        });
       
</script> 
<script id="entry-template" type="text/x-handlebars-template">
   
  <div class="well additional">
            <div class="form-group ">
                    <label for="lab" class="control-label col-sm-2">ประเภทการรักษา</label>
                    <div class="col-sm-4">
                    <select class="form-control select2" name="parent_treatment_id[]" style="width:100%">
                           <option value="">ระบุประเภท</option>
                      <?php foreach ($parent_treatment->result_array() as $row){ ?>
                      <option value="<?= $row['treatment_id'] ?>"><?= $row['name']; ?></option>
                      <?php } ?>
                  </select>
                  </div>
                  <label for="lab" class="control-label col-sm-2">การรักษา</label>
                    <div class="col-sm-4">
                    <select class="form-control select2 child" name="treatment_id[]" style="width:100%">
                           <option value="">ระบุประเภท</option>
                  </select>
                   <input type="text" class="form-control other_treatment" name="other_treatment[]" placeholder="ระบุ"  style="display:none" />
                  </div>
            </div>
            <div class="form-group">
                 <label for="" class="control-label col-sm-2">จำนวน<span class="unit"></span></label>
                <div class="col-md-4">
                    <input type="text" class="form-control quantity" name="quantity[]" />
                </div>
                 <label for="" class="control-label col-sm-2">ราคา</label>
                <div class="col-md-4">
                    <input type="text" class="form-control price"  name="price[]" placeholder="0.00"/>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-cancel btn-delete-plan" >ลบ</button>
       
  </div>
  </script>