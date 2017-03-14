


var alertbox = ['<div class="alert alert-danger alert-dismissible">',
                '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>',
                '<h4><i class="icon fa fa-ban"></i> เกิดข้อผิดพลาด</h4>',
                '#errormessage',
              '</div>']

var option_num = function()
{
	var result ='';
	for (var i = 0; i < 32 ; i++) {
		result+= '<option value="'+(i+1)+'" > '+(i+1)+'</option>';

	}
	return result;
}



var addlab =function(){
	var name = $('#name_lab').val();
	if(name){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/add_lab',
		  data: {name:name},
		  success: function(data){
		  	if(data.id)
		  	{
		  		   var newLab = new Option(name, data.id, true, true);
		        // Append it to the select
		        $('select[name="lab"]').append(newLab).trigger('change');
		  		//$('select[name="lab"]').select2('data', {id: data.id, text: name});   
		  		$('#name_lab').val('');
		  		$('#labform').find('.alert').remove();
		  		$('#labmodal').modal('hide');

		  	}else{

		  		$('#labform').find('.alert').remove();
	           $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#labform').find('.alert').remove();
           $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ lab"));
	}
	

	
}
var addCompany =function(){
	var name = $('#name_company').val();
	if(name){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/add_company',
		  data: {name:name},
		  success: function(data){
		  	if(data.id)
		  	{
		  		   var newLab = new Option(name, data.id, true, true);
		        // Append it to the select
		        $('select[name="company"]').append(newLab).trigger('change');
		  		//$('select[name="lab"]').select2('data', {id: data.id, text: name});   
		  		$('#name_company').val('');
		  		$('#companyform').find('.alert').remove();
		  		$('#companymodal').modal('hide');

		  	}else{

		  		$('#companyform').find('.alert').remove();
	           $('#companyform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#companyform').find('.alert').remove();
           $('#companyform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ บริษัท"));
	}
	

	
}
var addJob =function(){
	var name = $('#job_name').val();
	if(name){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/add_job',
		  data: {name:name},
		  success: function(data){
		  	if(data.id)
		  	{
		  		   var newLab = new Option(name, data.id, true, true);
		        // Append it to the select
		        $('select[name="job_id"]').append(newLab).trigger('change');
		  		//$('select[name="lab"]').select2('data', {id: data.id, text: name});   
		  		$('#job_name').val('');
		  		$('#jobform').find('.alert').remove();
		  		$('#appointmentJobmodal').modal('hide');

		  	}else{

		  		$('#jobform').find('.alert').remove();
	           $('#jobform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		   $('#jobform').find('.alert').remove();
           $('#jobform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ บริษัท"));
	}
	

	
}
var deleteJob =function(){
	var id = $('select[name="job_id"]').val();
	console.log(id);
	if(id){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/delete_job',
		  data: {job_id:id},
		  success: function(data){
		  	if(!data.status)
		  	{
				    var $element = $('select[name="job_id"] option[value="'+$('select[name="job_id"]').val()+'"]');
				    console.log('#jobform option[value="'+$('select[name="job_id"]').val()+'"]');
				    $element.remove();
				     $('select[name="job_id"]').trigger("change");
		  			$('#errorAppointmentJobmodal').modal('hide');

		  	}else{

		  		//$('#').find('.alert').remove();
	           //$('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#jobform').find('.alert').remove();
           $('#jobform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ lab"));
	}
		
}
var deleteLab =function(){
	var id = $('select[name="lab"]').val();
	console.log(id);
	if(id){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/delete_lab',
		  data: {lab_id:id},
		  success: function(data){
		  	if(!data.status)
		  	{
				    var $element = $('select[name="lab"] option[value="'+$('select[name="lab"]').val()+'"]');
				    console.log('#labform option[value="'+$('select[name="lab"]').val()+'"]');
				    $element.remove();
				     $('select[name="lab"]').trigger("change");
		  			$('#errorLabmodal').modal('hide');

		  	}else{

		  		//$('#').find('.alert').remove();
	           //$('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#labform').find('.alert').remove();
           $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ lab"));
	}
		
}
var addservice =function(){
	var name = $('#name_service').val();
	if(name){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/add_service',
		  data: {name:name},
		  success: function(data){
		  	 if(data.id)
		  	{
		  		var newService = new Option(name, data.id, true, true);
		        // Append it to the select
		        $('select[name="service"]').append(newService).trigger('change');
		  		$('#name_service').val('');
		  		$('#serviceform').find('.alert').remove();
		  		$('#servicemodal').modal('hide');

		  	}else{
		  		
		  		$('#serviceform').find('.alert').remove();
	           	$('#serviceform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#serviceform').find('.alert').remove();
           $('#serviceform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ บริการ"));
	}
}
var deleteService =function(){
	var id = $('select[name="service"]').val();
	console.log(id);
	if(id){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/delete_service',
		  data: {service_id:id},
		  success: function(data){
		  	if(!data.status)
		  	{
		  		  
				    var $element = $('select[name="service"] option[value="'+$('select[name="service"]').val()+'"]');
				    console.log('#labform option[value="'+$('select[name="service"]').val()+'"]');
				    $element.remove();
				     $('select[name="service"]').trigger("change");
		  			$('#errorServicemodal').modal('hide');

		  	}else{

		  		//$('#labform').find('.alert').remove();
	          // $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#labform').find('.alert').remove();
           $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ lab"));
	}
		
}
var deleteCompany =function(){
	var id = $('select[name="company"]').val();
	if(id){
		$.ajax({
		  type: "POST",
		  url: '/dent/ajax/delete_company',
		  data: {company_id:id},
		  success: function(data){
		  	if(!data.status)
		  	{
		  		  
				    var $element = $('select[name="company"] option[value="'+$('select[name="company"]').val()+'"]');
				    $element.remove();
				     $('select[name="company"]').trigger("change");
		  			$('#errorCompanymodal').modal('hide');

		  	}else{

		  		//$('#labform').find('.alert').remove();
	          // $('#labform').prepend(alertbox.join('').replace(/#errormessage/g, "ระบบเกิดข้อผิดพลาด"));
		  	}
		  },
		  dataType: 'json'
		});
	}else{

		  		$('#companyform').find('.alert').remove();
           $('#companyform').prepend(alertbox.join('').replace(/#errormessage/g, "กรุณาระบุชื่อ lab"));
	}
		
}

var findLabByDoc = function(value){
	docTable =  $('#doctortable').DataTable( {
        "ajax": '/dent/ajax/listbydoctor/'+value,
         "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    } );
}
var findLabByDate = function(value){
	dateTable = $('#datetable').DataTable( {
        "ajax": '/dent/ajax/listbydate/'+value,
         "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    } );
}

var docTable;
var dateTable; 

jQuery(document).ready(function(){

         $('select[name="lab"]').select2();
         $('select[name="service"]').select2();
         $('select[name="doctor"]').select2();
	jQuery('.btn-cancel').click(function(){
		$(this).parent().parent().find('.alert').remove();
	});
	$("#labmodal").find('.btn-save').click(function(){
		addlab();
	});
	$("#servicemodal").find('.btn-save').click(function(){
		addservice();
	});
	$("#companymodal").find('.btn-save').click(function(){
		addCompany();
	});

	$("#appointmentJobmodal").find('.btn-save').click(function(){
		console.log('add job');
		addJob();
	});

	$("#errorAppointmentJobmodal").find('.btn-delete').click(function(){
		deleteJob();
	});
	$("#errorLabmodal").find('.btn-delete').click(function(){
		deleteLab();
	});
	$("#errorServicemodal").find('.btn-delete').click(function(){
		deleteService();
	});
	$("#errorCompanymodal").find('.btn-delete').click(function(){
		deleteCompany();
	});
	$('.ajax-date').click(function(){
		var id = $(this).data('id');
		$('#datemodal').find('h4').html('รายการ Lab วันที่ '+id);
		if(dateTable){
			dateTable.destroy();
		}
		findLabByDate(id);

	});
	$('.ajax-doctor').click(function(){
		var id = $(this).data('id');
		var name = $(this).data('name');
		$('#doctormodal').find('h4').html('รายการ Lab ของทันตแพทย์ '+name);
		if(docTable){
			docTable.destroy();
		}
		findLabByDoc(id);
		
	});
});