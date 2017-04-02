
     <form id="methodform" action="<?php echo base_url() ?>ajax/toothplansave" >
 
<div class="row">
        <input type="hidden" name="client_cure_id" value="<?=$client_id ?>"/>
	    	<input type="hidden" name="tooth_plan_id"  value="<?php echo set_value('tooth_plan_id',(isset($tooth_plan_id))?$tooth_plan_id:" "); ?>"  />
	<div class="form-group">

	<div class="col-md-2">
      <div class="checkbox">
        <label>
				<input type="radio" name="plan_choice" value="1">
          แผน 1
        </label>
      </div>
    </div>

	<div class="col-md-2 ">
      <div class="checkbox">
       
        <label>

				<input type="radio" name="plan_choice" value="2">
          แผน 2
        </label>
      </div>
      </div>

	<div class="col-md-2 ">
      <div class="checkbox">
        <label>
				<input type="radio" name="plan_choice" value="3">
          แผน 3
        </label>
      </div>
      </div>
    </div>
    <div class="col-md-6">
    	<div class="form-group">
    	<label for="date" class="control-label col-md-2 " > วันที่ </label>
    	<div class="col-md-4">
    	<input type="text"  name="plan_date" class="form-control col-md-3 date2" value="<?php echo set_value('plan_date',(isset($plan_date))?$plan_date:" "); ?>"  />
    	</div>
    	<label for="date" class="control-label col-md-2 " > บันทึกโดย </label>
    	<div class="col-md-4">
    		<select class="form-control select2 col-md-3" name="doctor_cure_id" style="width:100%">
           <option value="">ระบุ</option>
              <?php foreach ($q_doctors->result_array() as $row){ ?>
              <option value="<?= $row['doctor_id'] ?>"  <?php echo set_select('doctor_id', $row['doctor_id'], isset($plan_doctor_id)?$row['doctor_id']==$plan_doctor_id:$row['doctor_id']==""); ?> ><?= $row['name']; ?> <?= $row['surname']; ?></option>
              <?php } ?>
          </select>
          </div>
        </div>
    </div>

</div>
<div class="row top-buffer" >
	<div class="col-md-6 text-center " style="border-right:1em;border-bottom:1em;border-color:#000;">
			 <?php for($i = 8 ;$i>0; $i--){ ?>
		  		<div class="custombtn 
           <?php if(isset($is_withdraws[''.$i])&&isset($is_withdraws[''.$i]['UL'])=='Y' ) {?> 
                  custom-circle
           <?php }?>

           <?php if(isset($is_blanks[''.$i])&&isset($is_blanks[''.$i]['UL'])=='Y' ) {?> 
                  custom-cross
           <?php }?>
          ">
          <a href="#"  class="customlink UL-<?= $i; ?> " data-side="UL" data-number="<?= $i; ?>"><?= $i; ?> </a>
            <?php if(isset($tooth_plan_detail[''.$i])&&isset($tooth_plan_detail[''.$i]['UL'])) {?>
                  <?php $detail = '';?>
                <?php foreach ($tooth_plan_detail[''.$i]['UL'] as $value) {?>
                        <?php $detail .= $value ?>

               <?php }?>
                <span class="plan_tag"> <?= $detail ?> </span>
            <?php } ?>

          </div>
		  <?php } ?>
	</div>
	<div class="col-md-6 text-center">
		  <?php for($i = 1 ;$i< 9; $i++){ ?>
		  		<div class="custombtn
           <?php if(isset($is_withdraws[''.$i])&&isset($is_withdraws[''.$i]['UR'])=='Y' ) {?> 
                  custom-circle
           <?php }?>

           <?php if(isset($is_blanks[''.$i])&&isset($is_blanks[''.$i]['UR'])=='Y' ) {?> 
                  custom-cross
           <?php }?>
          "><a href="#"  class="customlink UR-<?= $i; ?>" data-side="UR"  data-number="<?= $i; ?>"><?= $i; ?></a>
              <?php if(isset($tooth_plan_detail[''.$i])&&isset($tooth_plan_detail[''.$i]['UR'])) {?>
                  <?php $detail = '';?>
                <?php foreach ($tooth_plan_detail[''.$i]['UR'] as $value) {?>
                        <?php $detail .= $value ?>

               <?php }?>
                <span class="plan_tag"> <?= $detail ?> </span>
            <?php } ?>
          </div>

		  <?php } ?>
	</div>
</div>
<div class="row top-buffer" >
	<div class="col-md-6 text-center">
	 <?php for($i = 8 ;$i>0; $i--){ ?>
		  		<div class="custombtn
           <?php if(isset($is_withdraws[''.$i])&&isset($is_withdraws[''.$i]['LL'])=='Y' ) {?> 
                  custom-circle
           <?php }?>

           <?php if(isset($is_blanks[''.$i])&&isset($is_blanks[''.$i]['LL'])=='Y' ) {?> 
                  custom-cross
           <?php }?>
          "><a href="#"  class="customlink LL-<?= $i; ?> " data-side="LL"  data-number="<?= $i; ?>"><?= $i; ?></a>
              <?php if(isset($tooth_plan_detail[''.$i])&&isset($tooth_plan_detail[''.$i]['LL'])) {?>
                  <?php $detail = '';?>
                <?php foreach ($tooth_plan_detail[''.$i]['LL'] as $value) {?>
                        <?php $detail .= $value ?>

               <?php }?>
                <span class="plan_tag"> <?= $detail ?> </span>
            <?php } ?>
          </div>
		  <?php } ?>
	</div>
	<div class="col-md-6 text-center">
		     <?php for($i = 1 ;$i< 9; $i++){ ?>
		  		<div class="custombtn
           <?php if(isset($is_withdraws[''.$i])&&isset($is_withdraws[''.$i]['LR'])=='Y' ) {?> 
                  custom-circle
           <?php }?>

           <?php if(isset($is_blanks[''.$i])&&isset($is_blanks[''.$i]['LR'])=='Y' ) {?> 
                  custom-cross
           <?php }?>
          "><a href="#"  class="customlink LR-<?= $i; ?>" data-side="LR"  data-number="<?= $i; ?>"><?= $i; ?></a>
              <?php if(isset($tooth_plan_detail[''.$i])&&isset($tooth_plan_detail[''.$i]['LR'])) {?>
                  <?php $detail = '';?>
                <?php foreach ($tooth_plan_detail[''.$i]['LR'] as $value) {?>
                        <?php $detail .= $value ?>

               <?php }?>
                <span class="plan_tag"> <?= $detail ?> </span>
            <?php } ?>
          </div>
		  <?php } ?>
		
	</div>

</div>

<div id="addMethodModal" class="modal  fade">
	<div class="modal-dialog">
	    <div class="modal-content">
            <input type="hidden" name="tooth_number" />
            <input type="hidden" name="tooth_side" />
            <div class="modal-body" style="min-height: 150px">
            	<div class="onetothree">
            			<div class="col-md-4">
            			<input type="checkbox" name="method[]" class="La" value="La">
						<label>La</label>
						<br/>
            			<input type="checkbox" name="method[]" value="Li">
						<label>Li</label>
						<br/>
              			<input type="checkbox" name="method[]" value="I">
            			<label>I</label>
            			</div>
            			<div class="col-md-4">
            			<input type="checkbox" name="method[]" value="M">
            			<label>M</label>
						<br/>
						<input type="checkbox" name="method[]" value="D">
            			<label>D</label>
						<br/>
						<input type="checkbox" name="method[]" value="Ret">
            			<label>Ret</label>
						</div>
            			<div class="col-md-4">
						<input type="checkbox" name="method[]" value="Crown/Bridge">
						<label>Crown/Bridge</label>
						<br/>
						<input type="checkbox" name="method[]" value="Implant">
						<label>Implant</label>
						</div>
            	</div>
            	<div class="fourtosix ">
            			<div class="col-md-4">
            			<input type="checkbox" name="method[]" value="M">
						<label>M</label>
						<br/>
            			<input type="checkbox" name="method[]" value="O">
						<label>O</label>
						<br/>
              			<input type="checkbox" name="method[]" value="D">
            			<label>D</label>
            			</div>
            			<div class="col-md-4">
            			<input type="checkbox" name="method[]" value="B">
            			<label>B</label>
						<br/>
						<input type="checkbox" name="method[]" value="L">
            			<label>L</label>
						<br/>
						<input type="checkbox" name="method[]" value="Ret">
            			<label>Ret</label>
						</div>
            			<div class="col-md-4">
						<input type="checkbox" name="method[]" value="Crown/Bridge">
						<label>Crown/Bridge</label>
						<br/>
						<input type="checkbox" name="method[]" value="Implant">
						<label>Implant</label>
						</div>
            	</div>

              <div class="row">
                  <br/>
              <div class="form-group">

                  <input type="checkbox" name="is_blank" value="Y">
                        <label>ไม่มี</label>

                  <input type="checkbox" name="is_withdraw" value="Y">
                        <label>ถอน</label>

                  <input type="checkbox" name="is_finish" value="Y">
                        <label>ทำเสร็จแล้ว</label>
              </div>
              </div>
            </div>

            <div class="modal-footer">

				    <button type="button" class="btn btn-default btn-cancel" data-dismiss="modal">ปิด</button>
  
				    <button type="submit" class="btn btn-default btn-confirm" >ยืนยัน</button>
            </div>
	 	</div>
 	</div>
</div>
</form>
<style>

.top-buffer{
	margin-top: 1em;
	margin-bottom: 1em;
}
.text-center{

   min-height: 100px
}
</style>
<script > 
$(document).ready(function(){
  if(<?=$plan_choice ?>){
      $('input[name="plan_choice"][value="<?=$plan_choice ?>"]').iCheck('check');
    }
    var option = {
    checkboxClass: 'icheckbox_minimal-red',
    radioClass: 'iradio_minimal-red',
    increaseArea: '20%' // optional
  };
    $('#methodform').find('input[name="is_withdraw"]').iCheck(option);
    $('#methodform').find('input[name="is_blank"]').iCheck(option);
    $('#methodform').find('input[name="is_finish"]').iCheck(option);
	$('.customlink').click(function(){
			$('#addMethodModal .onetothree').hide();
			$('#addMethodModal .fourtosix').hide();

		$('input[name="tooth_side"]').val($(this).data('side'));
		$('input[name="tooth_number"]').val($(this).data('number'));
     $.post('<?=base_url() ?>ajax/get_method/',{tooth_side:$(this).data('side'),tooth_number:$(this).data('number'),client_id:'<?= $client_id ?>'}, function(data) {
          if(data.is_withdraw =='Y'){
            $('#methodform').find('input[name="is_withdraw"]').iCheck('check');
          }
          if(data.is_blank =='Y'){
            $('#methodform').find('input[name="is_blank"]').iCheck('check');
          }
          if(data.is_finish =='Y'){
            $('#methodform').find('input[name="is_finish"]').iCheck('check');
          }
          if(data.method){
            for(var i = 0; i<= data.method.length ;i ++ ){
              $('#methodform').find('input[name="method[]"][value="'+data.method[i]+'"]').iCheck('check');
            }
          }

          if($(this).data('number') < 4){

            $('#addMethodModal .onetothree').show();
          }else{

            $('#addMethodModal .fourtosix').show();
          }
          $('#addMethodModal').modal('show');
     });
	});
	    $('#methodform').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                type: 'POST',
                dataType: 'json',
                target: '#methodform',
                success: function(responseText, statusText, xhr, $form) {
                    if (responseText.status == '1') {
                      var data = JSON.parse(responseText.form_data);
                      console.log(data);
                        if(data.method)
                        {     
                          var uniquemethod = [];
                            $.each(data.method, function(i, el){
                                if($.inArray(el, uniquemethod) === -1) uniquemethod.push(el);
                            });
                            $('.'+data.tooth_side+'-'+data.tooth_number).parent().find('.plan_tag').html(uniquemethod.join(''));
                        }
                        if(data.is_withdraw){
                           $('.'+data.tooth_side+'-'+data.tooth_number).parent().addClass('custom-circle');
                        }else{
                          $('.'+data.tooth_side+'-'+data.tooth_number).parent().removeClass('custom-circle');
                        }
                        if(data.is_blank){
                          $('.'+data.tooth_side+'-'+data.tooth_number).parent().addClass('custom-cross');
                        }else{
                          $('.'+data.tooth_side+'-'+data.tooth_number).parent().removeClass('custom-cross');
                        }

                     $('#addMethodModal').modal('hide');
                    } else {
                      console.log(statusText);
                    }

                    // datatable.columns.adjust().draw(); // Redraw the DataTable
                }
            })
        });

})
$(document).ready(function(){

    $('#addMethodModal').on('hidden.bs.modal', function () {
        $('input[type="checkbox"]').iCheck('uncheck');
    });
  $('#methodform input[name="method[]"]').each(function(){
    var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: 'icheckbox_line-blue',
      radioClass: 'iradio_line-blue',
      insert: '<div class="icheck_line-icon"></div>' + label_text
    });
});

  $('input[name="plan_choice"]').iCheck({
    checkboxClass: 'icheckbox_square',
    radioClass: 'iradio_square',
    increaseArea: '20%' // optional
  });
});
</script>