<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'/third_party/tcpdf/tcpdf.php';
class Appointment extends CI_Controller {

	public function index(){

		$content = array();
		$query_doctors = $this->db->query("SELECT * FROM doctor where status='A' and  create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_client = $this->db->query("SELECT * FROM client where create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_job = $this->db->query("SELECT * FROM appointment_job where status ='A'  and create_user = '".$this->ion_auth->user()->row()->id."';");
		$content['clients'] = $query_client;
		$content['doctors'] = $query_doctors;
		$content['jobs'] = $query_job;

		$this->template->load('template', 'appointment/viewedit', $content);
	} 
	public function bydoctor($doctor_id){

		$content = array();
		$query_doctors = $this->db->query("SELECT * FROM doctor where status='A' and doctor_id= ".$doctor_id." and  create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_client = $this->db->query("SELECT * FROM client where create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_job = $this->db->query("SELECT * FROM appointment_job where status ='A'  and create_user = '".$this->ion_auth->user()->row()->id."';");
		$content['clients'] = $query_client;
		$content['doctors'] = $query_doctors;
		$content['view_doc_id'] = $doctor_id;
		$content['jobs'] = $query_job;

		$this->template->load('template', 'appointment/viewbydoc', $content);
	} 
	public function saveappointment()
	{
		// $this->doctor_validation();
		// if ($this->form_validation->run() == FALSE){
                
		// 	header('Content-Type: application/json');
		// 	echo json_encode(array('status'=>'0','message'=>validation_errors()));
  //       }else{
        	$appointment_id = $this->input->post('appointment_id');
        	if(!empty($appointment_id))
        	{
				$this->load->model("appointment_model");
        		$result = $this->appointment_model->update_entry();
        	}else{
				$this->load->model("appointment_model");
				$this->appointment_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
     //   }
	}
	public function delete_appointment()
	{
		 $appointment_id =  $this->input->post('appointment_id');
		 if(!empty($appointment_id))
         {
				$this->load->model("appointment_model");
        		$result = $this->appointment_model->delete_entry($appointment_id);
         }
		 header('Content-Type: application/json');
		 echo json_encode(array('status'=>'1'));
	}
	public function updateEndTime(){

				$this->load->model("appointment_model");
		  $this->appointment_model->update_endtime();
		  	header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
	}
	public function getDoctorGroup(){

			$start = $this->input->get('start');
			$dayofWeek = date( "w", strtotime($start));
			
			$query_doctors = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday ='".$dayofWeek."' and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'");
			$doctor_special_in = $this->db->query('select * from schedule s left join doctor d on d.doctor_id = s.doctor_id where start_date = "'.$start.'" and s.doctor_id is not null and s.doctor_id not in (select doctor_id from absent where absent_date =   "'.$start.'") 
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A" ;');
			
			$leave_doctor  = $this->db->query('select doctor_id from absent s where absent_date =   "'.$start.'"
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A" and doctor_id is not null ;');
			$resources_doctor = array();
			$doctor_normal = array();
			$doctor_special = array();
			$leave_doctor_id = array(); 
			foreach($leave_doctor->result_array() as $row){
				$leave_doctor_id[] = $row['doctor_id'];
			}
			
			foreach ($query_doctors->result_array() as $row) {
				if(!in_array($row['doctor_id'], $leave_doctor_id)){
					$resources_doctor[$row['doctor_id']] = $row['name'].' '.$row['surname'];
					$doctor_normal[] =  $row['doctor_id'];
			
				}
			}
			foreach ($doctor_special_in->result_array() as $row) {
				if(!in_array($row['doctor_id'], $doctor_normal)){
					$resources_doctor[$row['doctor_id']] = $row['name'].' '.$row['surname'];
				}

			}
			$resources=  array(); 
			foreach ($resources_doctor as $key=>$value) {
				$resource = array();
				$resource['id']= $key;
				$resource['title']=$value;
				$resources[] = $resource;
			}	
			header('Content-Type: application/json');
			echo json_encode($resources);

     //   }
	}
	public function getAppointmentGroupByDoctor()
	{
		$content = array();
		$query_appointment = $this->db->query("SELECT *,ar.name as job_name FROM appointment a join appointment_job ar on  a.job_id = ar.job_id left join client on client.client_id = a.client_id
			where a.status='A' and  a.create_user = '".$this->ion_auth->user()->row()->id."';");
		$events = array();
		foreach ($query_appointment->result_array() as $row) {
			$event = array();
			$event['id'] = 'appointment_id'.$row['appointment_id'];
			if(!empty($row['client_id'])){
				$event['title'] = $row['name_thai'].' '.$row['surname_thai'];
			}else{
				$event['title'] = $row['custom_client'];
  			}

			$date = $row['appointment_date'];
  			if(empty($row['end_time'])){
				$event['allDay'] = true;	

			}else{
				$end_date  = $date.' '.$row['end_time'];
				$end = date('c',strtotime($end_date));
				$event['end'] = $end;
				$event['allDay'] = false;				
			}
			$startdate  = $date.' '.$row['start_time'];
			$startdate = date('c',strtotime($startdate));
			$event['start']  = $startdate;
			$event['note'] = $row['note'];
			$event['custom_client'] = $row['custom_client'];
			$event['client_id'] = $row['client_id'];
			$event['doctor_id'] = $row['doctor_id'];
			$event['phone_no'] = $row['phone_no'];
			$event['backgroundColor'] = '#b052a8';

			$event['borderColor']= '#b052a8';
			if($row['confirm_first'] == 'Y')
			{
				$event['backgroundColor'] = '#f39c12';
				$event['borderColor']= '#f39c12';
			}
			if($row['confirm_second'] == 'Y')
			{
				$event['backgroundColor'] = '#00c0ef';
				$event['borderColor']= '#00c0ef';

			}
			$event['resourceId'] = $row['doctor_id'];
			$event['job_id'] = $row['job_id'];
			$event['job_name'] = $row['job_name'];
			$event['start_time'] = $row['start_time'];
			$event['end_time'] = $row['end_time'];
			$event['period'] = $row['period'];
			$event['confirm_first'] = $row['confirm_first'];
			$event['confirm_second'] = $row['confirm_second'];
			$event['appointment_date'] = date('d-m-Y',strtotime($row['appointment_date']));
			$events[] = $event;

		}

		header('Content-Type: application/json');
		echo json_encode($events);
	}
	function gen($doctor_id,$date)
	{ 

		
		$day = $date;
		$query_clinic = $this->db->query('select * from clinic where user_id = '. $this->ion_auth->user()->row()->id);
		$query_doctors = $this->db->query('select * from doctor where doctor_id  = '.$doctor_id);

		$query_appointment = $this->db->query("SELECT *,ar.name as job_name FROM appointment a join appointment_job ar on  a.job_id = ar.job_id left join client on client.client_id = a.client_id
			where a.status='A' and a.doctor_id = ".$doctor_id."  and appointment_date = '".$date."' and a.create_user = '".$this->ion_auth->user()->row()->id."';");
		foreach ($query_doctors->result_array() as $row) {
			$doctor_name = $row['name'];
			$doctor_surname = $row['surname']; 
		}
		$start_time = '';
		$end_time ='';
		foreach ($query_clinic->result_array() as $row) {
			$start_time = $row['start_time'];
			$end_time = $row['end_time'];
		}
		 $open_time = strtotime($start_time);
	    $close_time = strtotime($end_time);	
	    $now = time();
	    $output = array();

		date_default_timezone_set("Asia/Bangkok");

		$range=range(strtotime($start_time),strtotime($end_time),15*60);
		$appointment_time = array();
		foreach($query_appointment->result_array() as $row)
		{
			$appointment_time[date("H:i",strtotime($row['start_time']))] = $row;
		}
	    foreach( $range as $time) {

	        $output[] = date("H:i",$time);
	    }
		//now pass the data//
		 $this->data['title']="MY PDF TITLE 1.";
		 $this->data['description']=$doctor_name.'     '.$doctor_surname.'      '.$start_time.'-'.$end_time.'      '.date('d M Y',strtotime($date));
		 $this->data['header1']="เวลา";  
		 $this->data['header2']="ชื่อนามสกุลคนไข้/HN";  
		 $this->data['header3']="โทร";  
		 $this->data['header4']="งาน";  
		 $this->data['header5']="remark";  
		 $this->data['time_table']= $output;
		 $this->data['job_table'] = $appointment_time;
		 $this->data['open_time'] = $start_time;
		 //now pass the data //
 
		
		$html=$this->load->view('appointment/pdf_output',$this->data,true); //load the pdf_output.php by passing our data and get all data in $html varriable.
 		 $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetTitle('Doctor');
		$pdf->SetSubject($this->data['description']);

		// set default header data
		$pdf->SetHeaderData(null, null, 'Doctor', $this->data['description'], array(0,0,0), array(0,0,0));
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(10, 20, 10);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		// set font
		$pdf->SetFont('freeserif', '', 12);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		// set text shadow effect
		$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// ---------------------------------------------------------

		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output('example_001.pdf', 'I');
		//this the the PDF filename that user will get to download
		// $pdfFilePath ="mypdfName-".time()."-download.pdf";
 
		
		// //actually, you can pass mPDF parameter on this load() function
		// $pdf = $this->m_pdf->load();
		// //generate the PDF!
		// $pdf->WriteHTML($html,2);
		// //offer it to user via browser download! (The PDF won't be saved on your server HDD)
		// $pdf->Output($pdfFilePath, "D");
		 
		 	
	}

	

}