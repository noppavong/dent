<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Treatment extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


	public function index()
	{

    	$query_category = $this->db->query('select * from  treatment where status = "A" and   parent_id is  null  and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');

		$content = array();
		$content['treatment_parent'] = $query_category;
		$this->template->load('template', 'treatment/treatment',$content);
	}
	public function listtreatment()
	{

    	$query_treatment = $this->db->query('select *,t.treatment_id as treatment from  treatment t where t.status = "A" and   t.parent_id is not  null  and t.create_user = "'.$this->ion_auth->user()->row()->id.'"; ');
    	$struct = array();
		foreach ($query_treatment->result_array() as $row) {
			
			$struct[] = array($row['treatment'],$row['code'],$row['name'],$row['unit'],$row['price']);

		}
		$content = array();
		$content['data'] = $struct;
		
		header('Content-Type: application/json'); 
		echo json_encode($content);

	}
	public function get_treatment($treatment_id)
	{

		$this->load->model('treatment_model');
		$result = array();
		$treatment = $this->treatment_model->get($treatment_id);
		$result['treatment'] = $treatment;
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function savetreatment()
	{
		$this->treatment_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$id = $this->input->post('treatment_id');
        	if(!empty($id))
        	{
				$this->load->model("treatment_model");
        		$result = $this->treatment_model->update_entry();
        	}else{
				$this->load->model("treatment_model");
				$this->treatment_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function delete_treatment($id)
	{
		$this->load->model('treatment_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->treatment_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function treatment_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('price', 'ราคา', 'required');
		$this->form_validation->set_rules('parent_id', 'ประเภท', 'required');
	}

}
