<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion extends CI_Controller {

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
		$content = array();
		$query_promotions = $this->db->query('select * from mt_promotion where status="A" and create_user = "'.$this->ion_auth->user()->row()->id.'"');

		$promolist = array();
		foreach ($query_promotions->result_array() as $row) {
			$promolist [$row['promotion_id']] = $row['code'].'  '.$row['name'].' '.$row['sum_price'];
		}
		$content['promotions'] = $promolist;
		$this->template->load('template', 'promotion/continual_list',$content);
	}
	public function promos()
	{
		$content = array();
		$this->template->load('template','promotion/promo_list',$content);
	}
	public function listtreatment()
	{

    	$query_treatment = $this->db->query('select *,t.treatment_id as treatment from mt_continual_treatment t where t.status = "A"   and t.create_user = "'.$this->ion_auth->user()->row()->id.'"; ');
    	$struct = array();
		foreach ($query_treatment->result_array() as $row) {
			
			$struct[] = array($row['treatment'],$row['code'],$row['name']);

		}
		$content = array();
		$content['data'] = $struct;
		
		header('Content-Type: application/json'); 
		echo json_encode($content);

	}
	public function listpromotion()
	{
		 $query_promotion = $this->db->query("select * from mt_promotion where status = 'A' and create_user = '".$this->ion_auth->user()->row()->id."'; ");
		 $struct  = array();
		 foreach ($query_promotion->result_array() as $row) {
			$struct[] = array($row['promotion_id'],$row['code'],$row['name'],$row['sum_price'],$row['times']);	
		 }

		$content = array();
		$content['data'] = $struct;
		
		header('Content-Type: application/json'); 
		echo json_encode($content);
	}
	public function get_treatment($treatment_id)
	{

		$this->load->model('continual_model');
		$result = array();
		$treatment = $this->continual_model->get($treatment_id);
		$result['treatment'] = $treatment;
		$query_promotion = $this->db->query('select * from mt_treatment_promo_rel where treatment_id = "'.$treatment_id.'"');
		foreach ($query_promotion->result_array() as $row) {
			$result['promos'][] = $row;
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function get_promotion($promotion_id)
	{

		$this->load->model('promotion_model');
		$result = array();
		if(!empty($promotion_id))
		{
			$promotion = $this->promotion_model->get($promotion_id);
			$result['promotion'] = $promotion;

			$query_detail = $this->db->query('select * from mt_promotion_tier where promo_id ="'.$promotion_id.'"');

			foreach ($query_detail->result_array() as $row) {
				$result['tier'][] = $row;
			}
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function savetreatment()
	{
		$this->continual_treatment_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$id = $this->input->post('treatment_id');
        	if(!empty($id))
        	{
				$this->load->model("continual_model");
        		$result = $this->continual_model->update_entry();
        	}else{
				$this->load->model("continual_model");
				$this->continual_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function savepromotion()
	{
		$this->promotion_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$id = $this->input->post('promotion_id');
        	if(!empty($id))
        	{
				$this->load->model("promotion_model");
        		$result = $this->promotion_model->update_entry();
        	}else{
				$this->load->model("promotion_model");
				$this->promotion_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function delete_treatment($id)
	{
		$this->load->model('continual_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->continual_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_promotion($promotion_id)
	{
		$this->load->model('promotion_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->promotion_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	

	public function continual_treatment_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
	}
	public function promotion_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('code', 'รหัส', 'required');
		$this->form_validation->set_rules('sumprice', 'ราคา', 'required');
		$this->form_validation->set_rules('times', 'ครั้ง', 'required');
	}

}
