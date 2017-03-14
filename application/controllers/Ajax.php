<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {






	public function add_lab()
	{
		$this->load->model('lab_model');
		$name = $this->input->post('name');

		if(empty($name))
		{

			header('Content-Type: application/json');
			echo json_encode(array('status'=>'กรุณาระบุชื่อ'));
		}else{

			$result = $this->lab_model->insert_entry();
			header('Content-Type: application/json');
			echo json_encode($result);
		}

	}
	public function add_job()
	{
		$this->load->model('appointmentjob_model');
		$name = $this->input->post('name');

		if(empty($name))
		{

			header('Content-Type: application/json');
			echo json_encode(array('status'=>'กรุณาระบุชื่อ'));
		}else{

			$result = $this->appointmentjob_model->insert_entry();
			header('Content-Type: application/json');
			echo json_encode($result);
		}

	}
	public function labsave(){


			$this->lab_validation();
			if ($this->form_validation->run() == FALSE){
	                
				header('Content-Type: application/json');
				echo json_encode(array('status'=>'0','message'=>validation_errors()));
	        }else{
	        	$trans_id = $this->input->post('trans_id');
	        	if(!empty($trans_id))
	        	{
					$this->load->model("labts_model");
	        		$result = $this->labts_model->update_entry();
	        	}else{
					$this->load->model("labts_model");
					$this->labts_model->insert_entry();
				}
				header('Content-Type: application/json');
				echo json_encode(array('status'=>'1'));
	        }
	}
	public function planadd()
	{

			//$this->plan_validation();
			// if ($this->form_validation->run() == FALSE){
	                
			// 	header('Content-Type: application/json');
			// 	echo json_encode(array('status'=>'0','message'=>validation_errors()));
	  //       }else{
	        	
	        $plan_id = $this->input->post('plan_id');
	        if(!empty($plan_id)){

					$this->load->model("treatmentPlan_model");
					$this->treatmentPlan_model->edit_list();
	        }else{
					$this->load->model("treatmentPlan_model");
					$this->treatmentPlan_model->insert_list();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
	        //}
	}
	public function planedit()
	{

				$this->load->model("treatmentPlan_model");
				$this->treatmentPlan_model->update_entry();	
				header('Content-Type: application/json');
				echo json_encode(array('status'=>'1'));
	}
	public function labmastersave()
	{
		 $this->labmaster_validation();
	 	if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$lab_id = $this->input->post('lab_id');
        	if(!empty($lab_id))
        	{
				$this->load->model("lab_model");
        		$result = $this->lab_model->update_entry();
        	}else{
				$this->load->model("lab_model");
				$this->lab_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function  servicemastersave()
	{
		 $this->servicemaster_validation();
	 	if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$service_id = $this->input->post('service_id');
        	if(!empty($service_id))
        	{
				$this->load->model("service_model");
        		$result = $this->service_model->update_entry();
        	}else{
				$this->load->model("service_model");
				$this->service_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function delete_labts($trans_id)
	{
		if(!empty($trans_id))
		{
				$this->load->model("labts_model");
				$this->labts_model->delete_entry($trans_id);
				header('Content-Type: application/json');
				echo json_encode(array('status'=>'1'));
		}else{
			echo json_encode(array('status'=>'0'));
		}
	}
	public function add_company()
	{
		$this->load->model('companyContract_model');
		$name = $this->input->post('name');

		if(empty($name))
		{

			header('Content-Type: application/json');
			echo json_encode(array('status'=>'กรุณาระบุชื่อ'));
		}else{

			$result = $this->companyContract_model->insert_entry();
			header('Content-Type: application/json');
			echo json_encode($result);
		}

	}
	public function listbydoctor($doctor_id)
	{
		$sql =  array("SELECT *,l.name as lab_name,s.name as service_name ,d.name as doctor_name,d.surname as doctor_surname, c.name_thai as client_name,c.surname_thai as client_surname",
		 "FROM lab_transaction inner join doctor d on d.doctor_id = doctor  inner join client c on c.client_id = lab_transaction.client_id inner join lab l on l.lab_id = lab inner join service s on s.service_id = service  WHERE 1=1  AND lab_transaction.send_date > NOW() - INTERVAL 30 DAY AND doctor_id = ".$doctor_id);
	
		$query_labs = $this->db->query(implode("  ", $sql));
		$struct = array();
		foreach ($query_labs->result_array() as $row) {
			$struct[] = array(date('d-m-Y',strtotime($row['send_date'])),$row['doctor_name'].' '.$row['doctor_surname'],$row['client_name'].' '.$row['client_surname'],$row['service_name'],$row['lab_name'],number_format($row['price'],2,'.',',') ,($row['is_received']=="Y")?"ได้รับแล้ว":"ยังไม่ได้รับ");
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function listbydate($date)
	{
		$sql =  array("SELECT *,l.name as lab_name,s.name as service_name ,d.name as doctor_name,d.surname as doctor_surname, c.name_thai as client_name,c.surname_thai as client_surname",
		 "FROM lab_transaction inner join doctor d on d.doctor_id = doctor  inner join client c on c.client_id = lab_transaction.client_id inner join lab l on l.lab_id = lab inner join service s on s.service_id = service  WHERE 1=1  AND lab_transaction.send_date = '".date('Y-m-d',strtotime($date))."'");
	
		$query_labs = $this->db->query(implode("  ", $sql));
		$struct = array();
		foreach ($query_labs->result_array() as $row) {
			$struct[] = array($row['trans_id'],date('d-m-Y',strtotime($row['send_date'])),$row['doctor_name'].' '.$row['doctor_surname'],$row['client_name'].' '.$row['client_surname'],$row['service_name'],$row['lab_name'],number_format($row['price'],2,'.',',') ,($row['is_received']=="Y")?"ได้รับแล้ว":"ยังไม่ได้รับ");
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function listbyclient_id($client_id)
	{
		$sql =  array("SELECT *,l.name as lab_name,s.name as service_name ,d.name as doctor_name,d.surname as doctor_surname, c.name_thai as client_name,c.surname_thai as client_surname",
		 "FROM lab_transaction inner join doctor d on d.doctor_id = doctor  inner join client c on c.client_id = lab_transaction.client_id inner join lab l on l.lab_id = lab inner join service s on s.service_id = service  WHERE 1=1  AND lab_transaction.client_id=".$client_id);
		$query_labs = $this->db->query(implode("  ", $sql));
		$struct = array();
		foreach ($query_labs->result_array() as $row) {
			$struct[] = array($row['trans_id'],date('d-m-Y',strtotime($row['send_date'])),$row['doctor_name'].' '.$row['doctor_surname'],$row['service_name'],$row['lab_name'],number_format($row['price'],2,'.',',') ,($row['is_received']=="Y")?"ได้รับแล้ว":"ยังไม่ได้รับ");
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}
	public function treatmentsbyclient($client_id)
	{
		$sql = array("SELECT *
			, CONCAT(d.name,' ',d.surname) as doctor_name
			,tp.description as description
			,tp.refer as refer 
			from treatment_plan tp 
		 left join doctor d on tp.doctor_id =  d.doctor_id
		 where client_id = '".$client_id."'");
		$query_plans = $this->db->query(implode("  ", $sql));
		$struct = array();
		foreach ($query_plans->result_array() as $row) {
			$query_detail = $this->db->query('select *,t.name as treatment_name from treatment_plan_detail tpd 	
			inner join treatment t on tpd.treatment_id = t.treatment_id 
			 where plan_id = "'.$row['plan_id'].'"');
			$treatment_name = array();
			foreach ($query_detail->result_array() as $row2) {
				if($row2['treatment_id'] == 9999){
					$treatment_name[] = $row2['other_treatment'];

				}else{
					$treatment_name[] = $row2['treatment_name'];
				}
			}
			$treatmentlist = implode(',',$treatment_name);
			
			$struct[] = array($row['plan_id'],date('d-m-Y',strtotime($row['treatment_date'])),$treatmentlist,$row['description'],
				$row['refer'],$row['doctor_name']);
			
		}

		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function get_treatmentlist($treatment_id)
	{
		$query_child = $this->db->query("SELECT * FROM treatment t  where parent_id = '".$treatment_id."' and t.create_user = ".$this->ion_auth->user()->row()->id);
		$struct = array();
		foreach ($query_child->result_array() as $row) {
			$struct[] = array($row['treatment_id'],$row['treatment_id'],$row['name'],$row['treatment_id'],$row['treatment_id'],$row['price']);
		}

		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}

	public function listlab()
	{
		$this->load->model('lab_model');
		$query_labs = $this->db->query('select * FROM lab where status = "A"');
		$struct = array();
		foreach ($query_labs->result_array() as $row) {
			$struct[] = array($row['lab_id'],$row['name']);
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}
	public function listservice()
	{
		$this->load->model('service_model');
		$query_services = $this->db->query('select * FROM service where status = "A"');
		$struct = array();
		foreach ($query_services->result_array() as $row) {
			$struct[] = array($row['service_id'],$row['name']);
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}
	public function delete_lab()
	{
		$this->load->model('lab_model');
		$id = $this->input->post('lab_id');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->lab_model->delete_entry();
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_job()
	{
		$this->load->model('appointmentjob_model');
		$id = $this->input->post('job_id');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->appointmentjob_model->delete_entry();
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_plan($plan_id){
		if(!empty($plan_id))
		{
				$this->load->model('treatmentPlan_model');
				$this->treatmentPlan_model->delete_entry($plan_id);
				header('Content-Type: application/json');
				echo json_encode(array('status'=>'1'));
		}else{
			echo json_encode(array('status'=>'0'));
		}

	}
	public function get_lab($id)
	{
		$this->load->model('labts_model');
		$result = array();
		if(!empty($id))
		{
			$result = $this->labts_model->get($id);
			$result['send_date'] = date('d-m-Y',strtotime($result['send_date']));

		}
		header('Content-Type: application:json');
		echo json_encode($result);

	}
	public function get_plan($id)
	{
		$this->load->model('treatmentPlan_model');
		$result = array();
		if(!empty($id))
		{
			$result = $this->treatmentPlan_model->get($id);
			$query_detail = $this->db->query('select *,tpd.price as price_t from treatment_plan_detail tpd inner join treatment t on t.treatment_id = tpd.treatment_id
			 where plan_id ="'.$id.'"');

			foreach ($query_detail->result_array() as $row) {
				$result['treatment_list'][] = $row;
			}
			$result['treatment_date'] = date('d-m-Y',strtotime($result['treatment_date']));

		}

		header('Content-Type: application:json');
		echo json_encode($result);
	}
	public function delete_masterlab($id)
	{
		$this->load->model('lab_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->lab_model->delete_entry2($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}

	}
	public function delete_masterservice($id)
	{
		$this->load->model('service_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->service_model->delete_entry2($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}

	}
	public function get_masterlab($id)
	{
		$this->load->model('lab_model');
		$result = array();
		if(!empty($id))
		{
			$result = $this->lab_model->get($id);

		}
		header('Content-Type: application:json');
		echo json_encode($result);

	}
	public function get_masterservice($id)
	{
		$this->load->model('service_model');
		$result = array();
		if(!empty($id))
		{
			$result = $this->service_model->get($id);

		}
		header('Content-Type: application:json');
		echo json_encode($result);

	}
	public function add_service()
	{
		$this->load->model('service_model');
		$name = $this->input->post('name');
		// header('Content-Type: application/json');
		// echo json_encode($result);

		if(empty($name))
		{

			header('Content-Type: application/json');
			echo json_encode(array('status'=>'กรุณาระบุชื่อ'));
		}else{
			
			$result = $this->service_model->insert_entry();
			header('Content-Type: application/json');
			echo json_encode($result);
		}
	}
	public function delete_service()
	{
		$this->load->model('service_model');
		$id = $this->input->post('service_id');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->service_model->delete_entry();
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_company()
	{
		$this->load->model('companyContract_model');
		$id = $this->input->post('company_id');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->companyContract_model->delete_entry();
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function lab_validation(){
		$this->form_validation->set_rules('lab', 'ชื่อ แล็บ', 'required');
		$this->form_validation->set_rules('service', 'ชื่อบริการ', 'required');
		$this->form_validation->set_rules('doctor', 'หมอ', 'required');
	}
	public function  labmaster_validation(){
		$this->form_validation->set_rules('name','ชื่อ แล็บ','required');
	}
	public function  servicemaster_validation(){
		$this->form_validation->set_rules('name','ชื่อ บริการ','required');
	}
	public function products()
	{
		$query = $this->db->query('select distinct(code) from product where status ="A" and create_user = '.$this->ion_auth->user()->row()->id);
		$result = array();
		foreach ($query->result_array() as $row) {
			$result['data'][] = $row['code'];
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}

}