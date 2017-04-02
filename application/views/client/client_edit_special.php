<button type="button" data-toggle="modal" class="btn btn-primary" data-target="#addSpecialModal"> เพิ่มบันทึกการักษาต่อเนื่อง  
</button>
<table id="special_treatmentTable" class="table display" cellspacing="0" width="100%" style="table-layout: fixed;
word-wrap: break-word;">
<thead>
    <tr>
      <th>
      </th>
      <th>วันที่เริ่มรักษา
      </th>
      <th>รายการรักษา
      </th>
      <th>โปรโมชั่น 

      </th>
      <th>ครั้งที่ล่าสุด
      </th>
      <th>ทันตแพทย์
      </th>
  </tr>
</thead>
</table>
<div id="rel_promo" style="display:none">   
  <?= $special_promo_rel ?>
</div>
<div id="promo" style="display:none">
  <?= $special_promo ?>
</div>

<div id="promo_tier" style="display:none">
  <?= $special_promo_tier ?>
</div>
<div id="addSpecialModal" class="modal  fade">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <span aria-hidden="true">&times;
   </span>
   </button>
   <h4 class="modal-title">เพิ่มข้อมูลการรักษาต่อเนื่อง
   </h4>
</div>
<form id="specialform" action="<?php echo base_url() ?>ajax/specialadd" class="form-horizontal">
<div class="modal-body">
   <input type="hidden" name="client_special_id" value="<?=$client_id?>" />
   <input type="hidden" name="special_treatment_id" value="" />
   <div class="form-group" >
      <label for="doctor_id" class="control-label col-sm-2">ทันตแพทย์
      </label>
      <div class="col-sm-4">
         <select class="form-control select2 " name="doctor_id" style="width:100%">
            <option value="">ระบุ
            </option>
            <?php foreach ($q_doctors->result_array() as $row){ ?>
            <option value="<?= $row['doctor_id'] ?>"   >
               <?= $row['name']; ?> 
               <?= $row['surname']; ?>
            </option>
            <?php } ?>
         </select>
      </div>
      <label for="" class="control-label col-sm-2">วันที่เริ่มรักษา
      </label>
      <div class="col-md-4">
         <input type="text" class="form-control date2" id="treatment_date" name="treatment_date" value="<?php echo date('d-m-Y'); ?>" />
      </div>
   </div>
   <div id="well-special-treatment" style="max-height: 400px;overflow-y: scroll;">
      <div class="well">
         <div class="form-group ">
            <label for="lab" class="control-label col-sm-2">การรักษา
            </label>
            <div class="col-sm-4">
               <select class="form-control select2" name="continual_treatment_id" style="width:100%">
                  <option value="">ระบุประเภท
                  </option>
                  <?php foreach ($special_treatments->result_array() as $row){ ?>
                  <option value="<?= $row['treatment_id'] ?>">
                     <?= $row['name']; ?>
                  </option>
                  <?php } ?>
               </select>
            </div>
            <label for="lab" class="control-label col-sm-2">การรักษา
            </label>
            <div class="col-sm-4">
               <select class="form-control select2 child" name="promotion_id" style="width:100%">
                  <option value="">ระบุประเภท
                  </option>
               </select>
            </div>
         </div>
         <div class="form-group">
            <label for="" class="control-label col-sm-2">ครั้งที่
            <span class="unit">
            </span>
            </label>
            <div class="col-md-4">
               <input type="text" class="form-control time" name="time[]" placeholder="1" />
            </div>
            <label for="" class="control-label col-sm-2">ราคา
            </label>
            <div class="col-md-4">
               <input type="text" class="form-control price" name="price[]" placeholder="0.00" />
            </div>
         </div>
      </div>
   </div>

        <div class="form-group">
            <label for="" class="control-label col-sm-2" ><h3 style="color:#00a65a;"> คงเหลือ</h3> </label>
            <div class="col-md-8  "  style="color:#00a65a;">
            <label for="" class="control-label col-sm-2" > <h3 class="remainprice" style="color:#00a65a;"> 0.00 </h3></label>
            </div>
        </div>
   <div class="row">
      <button type="button" id="add_special" class="btn btn-success  btn-add pull-right" style="margin-right: 10%" >เพิ่ม
      </button>
   </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">ยกเลิก
  </button>
  <button type="submit" class="btn btn-primary btn-save">บันทึก
  </button>
</div>
</form>
</div>
</div>
</div>


<div id="viewSpecialModal" class="modal  fade">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
   <span aria-hidden="true">&times;
   </span>
   </button>
   <h4 class="modal-title">เพิ่มข้อมูลการรักษาต่อเนื่อง
   </h4>
</div>
<div class="modal-body">

   <div class="row" >
     <div  class="col-xs-2">ทันตแพทย์
      </div>
      <div class="col-xs-4 view-special-doctor" >
            
      </div>
      <div  class="col-xs-2">วันที่เริ่มรักษา
      </div>
      <div class="col-xs-4 view-special-treatment_date">

      </div>
   </div>
   <div class="row" >
      <div  class="col-xs-2">การรักษา
      </div>
      <div class="col-xs-4 view-special-treatment" >
            
      </div>
      <div  class="col-xs-2">โปรโมชั่น
      </div>
      <div class="col-md-4 view-special-promotion">

      </div>
   </div>
   <table id="special_ViewTable" class="table display" cellspacing="0" width="100%" style="table-layout: fixed;
    word-wrap: break-word;">
    <thead>
        <tr>
          <th>ครั้งที่
          </th>
          <th>ราคา
          </th>
    </thead>
    <tbody>

    </tbody>
    </table>


    <div class="form-group">
        <label for="" class="control-label col-sm-2" ><h3 style="color:#00a65a;"> คงเหลือ</h3> </label>
        <div class="col-md-8  "  style="color:#00a65a;">
        <label for="" class="control-label col-sm-2" > <h3 class="remainprice" style="color:#00a65a;"> 0.00 </h3></label>
        </div>
    </div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">ยกเลิก
  </button>
  <button type="submit" class="btn btn-primary btn-save">บันทึก
  </button>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    var treatmentTable = $('#special_treatmentTable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "order": [],
      "info": true,
      "autoWidth": false,
      "columnDefs": [
      {
          width: '8%', targets: 'no-sort',"orderable": false }
          , 
          {
              width: '10%', targets: 1 }
              ,
              {
                  width: '20%', targets: 2 }
                  ,
                  {
                      width: '20%', targets: 3 }
                      ,
                      {
                          width: '20%', targets: 4 }
                          ,
                              ],
                              "ajax": '<?= base_url() ?>ajax/specialbyclient/<?=$client_id; ?>',
                              columns: [{
                                "orderable": false ,
                                render: function(data, type, row) {
                                  if (type === 'display') {
                                    return '<a  href="#" class="editable-special" data-id="' + data + '">แก้ไข </a>'+
                                    '<a  href="#" class="viewable-special" data-id="' + data + '">ดู </a>'+
                                    '<a  href="#" class="deleteable2" data-id="' + data + '">ลบ </a>';
                                }
                                return data;
                            }
                            ,
                            className: "dt-body-center"
                        }
                        , {
                        }
                        , {
                        }
                        ,{
                        }
                        , {
                        }
                        , {
                        }
                        ]
                    }
                    );
    var recreateTreatmentTable = function() {
      if (treatmentTable) {
        treatmentTable.destroy();
    }
    treatmentTable = $('#special_treatmentTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "fixedColumns": true,
        "autoWidth": false,
        "columnDefs": [
        {
        width: '8%', targets: 0 }
        ,
        {
        width: '10%', targets: 1 }
        ,
        {
        width: '20%', targets: 2 }
        ,
        {
        width: '20%', targets: 3 }
        ,
        {
        width: '20%', targets: 4 }
        
        ,
        ],
        "ajax": '<?= base_url() ?>ajax/specialbyclient/<?=$client_id; ?>',
        columns: [{
          render: function(data, type, row) {
            if (type === 'display') {
             return '<a  href="#" class="editable-special" data-id="' + data + '">แก้ไข </a>'+
                                    '<a  href="#" class="viewable-special" data-id="' + data + '">ดู </a>'+
                                    '<a  href="#" class="deleteable2" data-id="' + data + '">ลบ </a>';
          }
          return data;
          }
          ,
          className: "dt-body-center"
          }
              , {
              }
              ,{
              }
              ,{
              }
              , {
              }
              , {
              }
              ]
          }
                      );
} 
//test
$(document).on('click', '.editable-special', function(evt) {
  evt.preventDefault();
  $.get('<?=base_url() ?>ajax/get_special/' + $(this).data('id'), function(data) {
    $('#specialform select[name="continual_treatment_id"]').val(data.continual_treatment_id).trigger('change');
    $('#specialform select[name="promotion_id"]').val(data.promotion_id).trigger('change');
    $('#specialform input[name="treatment_date"]').val(data.treatment_date);
    $('#specialform input[name="special_treatment_id"]').val(data.special_treatment_id);
    $('#specialform select[name="doctor_id"]').val(data.doctor_id).trigger('change');

    if(data['special_trans']){
      for(var i = 0; i< data['special_trans'].length; i++)
      {
        if(i == 0)
        {
          $('.well .price').val(data['special_trans'][i]['price']);
          $('.well .time').val(data['special_trans'][i]['time']);
      }
      else{
          var source   = $("#special-entry-template").html();
          var template = Handlebars.compile(source);
          $('#addSpecialModal').find('.modal-body').find('#well-special-treatment').append(template);
          $('.select2').select2();
          $('.additional .price').last().val(data['special_trans'][i]['price']);
          $('.additional .time').last().val(data['special_trans'][i]['time']);
      }
      calculateRemain(data.continual_treatment_id,data.promotion_id);
  }
}
$('#addSpecialModal').modal('show');
}
);
}
);
$(document).on('click','.viewable-special',function(evt){
   $.get('<?=base_url() ?>ajax/get_special/' + $(this).data('id'), function(data) {
    $('#special_ViewTable').find('tbody').empty();
    if(data.doctor_id){

      $('.view-special-doctor').html($('#specialform select[name="doctor_id"]').find('option[value="'+data.doctor_id+'"]').text());
    }
    if(data.continual_treatment_id)
    {

      $('.view-special-treatment').html($('#specialform select[name="continual_treatment_id"]').find('option[value="'+data.continual_treatment_id+'"]').text());
    }
    if(data.promotion_id)
    { 
      console.log('data promo_id'+data.promotion_id);
       if(rel_promo[data.continual_treatment_id]){
          for(var i=0;  i< rel_promo[data.continual_treatment_id].length; i++)
          {
            if(rel_promo[data.continual_treatment_id][i]['promotion_id']== data.promotion_id){
                $('.view-special-promotion').html(rel_promo[data.continual_treatment_id][i]['name']);
            }
          
          }
        }
    }
    if(data.treatment_date)
    {
      $('.view-special-treatment_date').html(data.treatment_date);
    }
    if(data['special_trans']){
      var sumInTier = 0;
      for(var i = 0; i< data['special_trans'].length; i++)
      {
             $('#special_ViewTable').find('tbody').append('<tr><td>'+data['special_trans'][i]['price']+'</td><td>'+data['special_trans'][i]['time']+'</td>');
             sumInTier+= parseFloat(data['special_trans'][i]['price']);
      }

      calculateRemain(data.continual_treatment_id,data.promotion_id,sumInTier);

    }

    $('#viewSpecialModal').modal('show');
  });
});
$(document).on('click', '.deleteable2', function(evt) {
  evt.preventDefault();
  $.get('<?=base_url() ?>ajax/delete_special/' + $(this).data('id'), function(data) {
    recreateTreatmentTable();
}
);
}
);
$('#specialform').on('submit', function(e) {
  e.preventDefault();
      // prevent native submit
      $(this).ajaxSubmit({
        type: 'POST',
        dataType: 'json',
        target: '#echoForm2',
        success: function(responseText, statusText, xhr, $form) {
          if (responseText.status == '1') {
            resetspecialform();
            recreateTreatmentTable();
            $('#addSpecialModal').modal('hide');
        }
        else {
            $('#specialform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
             responseText.message + '</div>');
        }
          // datatable.columns.adjust().draw(); // Redraw the DataTable
      }
  }
  )
  }
  );
$('#editspecialform').on('submit', function(e) {
  e.preventDefault();
      // prevent native submit
      $(this).ajaxSubmit({
        type: 'POST',
        dataType: 'json',
        target: '#echoForm2',
        success: function(responseText, statusText, xhr, $form) {
          if (responseText.status == '1') {
            $('#specialform input[type="text"]', '#specialform input[type="checkbox"]','#specialform textarea').clearFields();
            $('#specialform .validation-form').empty();
            $('#specialform input[name="special_treatment_id"]').val();
            $('#specialform select').trigger('change');
            recreateTreatmentTable();
            $('#editPlanModal').modal('hide');
        }
        else {
            $('#specialform .validation-form').append('<div class="alert alert-danger alert-dismissible">' +
             responseText.message + '</div>');
        }
          // datatable.columns.adjust().draw(); // Redraw the DataTable
      }
  }
  )
  }
  );
$('#add_special').click(function(){
  var source   = $("#special-entry-template").html();
  var template = Handlebars.compile(source);
  $('#addSpecialModal').find('.modal-body').find('#well-special-treatment').append(template);
  $('.select2').select2();
}
);
var  rel_promo = JSON.parse($('#rel_promo').html());
var promo = JSON.parse($('#promo').html());
var promo_tier = JSON.parse($('#promo_tier').html());
$(document).on('change','select[name="continual_treatment_id"]',function(evt){
  var parent = evt.target.value;
  if(parent){
    var dataOptions = [];
    if(rel_promo[parent]){
            for(var i=0;  i< rel_promo[parent].length; i++)
            {
              dataOptions.push({
                id: rel_promo[parent][i]['promo_id'] ,
                text:  rel_promo[parent][i]['name']}
                );
          }
          
    }else{
         dataOptions.push({id:'',text:'ระบุประเภท'});
    }
            $(evt.target).parent().parent().parent().find(".child").select2().select2('destroy').empty().select2({
              data:dataOptions}
              ).trigger('change');
  }
  else{
    $(evt.target).parent().parent().parent().find(".child").select2().select2('destroy').empty().select2({
      data:[{
        id:'',text:"ระบุประเภท"}
        ]}
        ).trigger('change');
    }
  }
);
$(document).on('change','#specialform select[name="promotion_id[]"]',function(event){
    var promo_id = event.target.value;
    if(promo_id){
        calculateInstallmentSum(promo_id);

    }
});
var calculateInstallmentSum =function(promo_id)
{
     $('#specialform .time').each(function(){

        calculateInstallment(promo_id,$(this).val(),$(this).parent().parent().parent().find(".price"));
     });
}
var calculateRemain = function(treatment_id,promo_id,sumInTier){
  if(rel_promo[treatment_id]){
      var sumprice = 0;
            for(var i=0;  i< rel_promo[treatment_id].length; i++)
            {
              if(promo_id == rel_promo[treatment_id][i]['promotion_id']){
                sumprice = rel_promo[treatment_id][i]['sum_price'];
                break;
              }

            }
            console.log(sumprice);
            console.log(sumInTier);
      if(sumInTier)
      {
        var result = (sumprice-sumInTier > 0)?sumprice-sumInTier:0;
        $('.remainprice').html(parseFloat(result).toFixed(2));
      }else{
        var result = 0;
        $('#specialform .price').each(function(){
          console.log($(this).val());
           result+= parseFloat($(this).val());
        });
        console.log(result);
        result = (sumprice-result > 0)?sumprice-result:0;
         $('.remainprice').html(parseFloat(result).toFixed(2));
      }
   }
}

$(document).on('change','#specialform .price',function(event){

   var treatment_id = $('#specialform select[name="continual_treatment_id"]').val();
   var promo_id = $('#specialform select[name="promotion_id"]').val();
   calculateRemain(treatment_id,promo_id);
});
$(document).on('change','#specialform .time',function(event){
    var promo_id = $('#specialform select[name="promotion_id"]').val();
    var time =$(this).val();
    console.log('promotion ===='+promo_id+" time ==== "+time);
    if(promo_id){
       calculateInstallmentSum(promo_id);

    }
});
var calculateInstallment = function(promo_id,time,$obj)
{
    var special_id= $('input[name="special_treatment_id"]').val();

      console.log('TIME : +++ >>'+time);
    if(time ){

            var tier = promo_tier[promo_id];
            var sum_price_in_tier = 0;
            var counted_period = 0;

            for(var i = 0 ;i < tier.length ; i++){
                 if(parseInt(tier[i]['start']) <= time && time <= parseInt(tier[i]['end'])){
                    $('.time').each(function(){
                        if(parseInt(tier[i]['start']) <= $(this).val() && $(this).val() <= parseInt(tier[i]['end'])){   
                            if($(this).parent().parent().parent().find(".price").val()   > 0)
                            {
                                sum_price_in_tier += parseFloat($(this).parent().parent().parent().find(".price").val()) ;
                                counted_period +=1;
                            }

                        }
                    });
                    var sum_max_tier = (tier[i]['end'] - tier[i]['start'] +1)*tier[i]['installment'];
                    console.log('counting period'+counted_period);
                    console.log((tier[i]['end'] - tier[i]['start'] +1-counted_period));
                    console.log(sum_max_tier);
                    console.log(sum_price_in_tier);
                    console.log((sum_max_tier-sum_price_in_tier));
                    var installment_remain = (sum_max_tier-sum_price_in_tier)/(tier[i]['end'] - tier[i]['start'] +1-counted_period);
                     $obj.attr('placeholder',parseFloat(installment_remain).toFixed(2));
                     return;
                  }


                //      $obj.attr('placeholder',parseFloat(tier[i]['installment']).toFixed(2));
                //      console.log('found');
                //      break;
                //      //$($obj).attr('placeholder','justin timeberlake'); 
                // }
            }  
    }
}

$(document).on('click','.btn-delete-plan',function(){
  $(this).parent().remove();
}
);
var resetspecialform = function(){
  $('.additional').remove();
  $('#specialform input[type="text"]').not('[name="treatment_date"]').val('');
  $('#specialform select').val('');
  $('#specialform textarea').val('');
  $('#specialform input[name="special_treatment_id"]').val('');
  $('#specialform .validation-form').empty();
  $('#specialform select').trigger('change');
      // calculateSum();
  }
  $('#addSpecialModal').on('hidden.bs.modal', function () {
      resetspecialform();
  }
  );
</script> 
<script id="special-entry-template" type="text/x-handlebars-template">
  <div class="well additional">
    
<div class="form-group">
   <label for="" class="control-label col-sm-2">ครั้งที่</label>
   <div class="col-md-4">
    <input type="text" class="form-control time" name="time[]" />
</div>
<label for="" class="control-label col-sm-2">ราคา</label>
<div class="col-md-4">
    <input type="text" class="form-control price"  name="price[]" placeholder="0.00"/>
</div>
</div>
<button type="button" class="btn btn-danger btn-cancel btn-delete-plan" >ลบ</button>
</div>
</script>
