<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

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
		$sql =  array("SELECT * ,FORMAT (DATEDIFF(CURRENT_DATE, STR_TO_DATE(birth_date, '%Y-%m-%d'))/365 ,0) AS age FROM client WHERE 1=1 ");
		$name = $this->input->post('name_thai');
		$surname = $this->input->post('surname_thai');
		$phone = $this->input->post('phone_no');
		$hn = $this->input->post('hn');
		if(!empty($name))
		{
			$sql[] = "and name_thai like '".$name."%'"; 
		}
		if(!empty($surname))
		{
			$sql[] = "and surname_thai like '".$surname."%'"; 
		}
		if(!empty($phone))
		{
			$sql[] = "and phone_no  = '".$phone."'"; 
		}
		if(!empty($hn))
		{
			$sql[] = "and hn like '%".$hn."%'"; 
		}

		$query_cli = $this->db->query(implode("  ", $sql));
		$content['client'] = $query_cli;
		$this->template->load('template', 'client/list', $content);

	}
	public function view($client_id='')
	{
		
		$query_a= $this->db->query("SELECT * FROM amphur;");
		$query_p = $this->db->query("SELECT * FROM province;");
		$query_m = $this->db->query("SELECT * FROM marital_status;");
		$query_t = $this->db->query("SELECT * FROM title");
		$query_d = $this->db->query("SELECT * FROM doctor");
		$query_c = $this->db->query("SELECT * FROM company_contact where status = 'A'");

		
		$content['amphurs'] = $query_a;
		$content['provinces'] = $query_p;
		$content['maritals'] = $query_m;
		$doctors = array();
		$content['doctors'] = $query_d;
		$content['cli_doctors'] = array();
		$content['titles'] = $query_t;
		$client;
		$doclist = array();

		foreach ($query_d->result_array() as $row) {
			$doclist [$row['doctor_id']] = $row['name'].' '.$row['surname'];
		}
		$content['doctors'] = $doclist;

		$this->load->model('client_model');
		if(isset($client_id) && !empty($client_id))
		{
			$client = $this->client_model->get($client_id);

			
			if(isset($client)){
				$content= array_merge($content,$client);
			}
			$query_clid = $this->db->query("SELECT * FROM client_doctor_rel where client_id = ".$client_id);
			foreach ($query_clid->result_array() as $row) {
				$doctors[] = $row['doctor_id'];
			}

			
			$content['cli_doctors'] = $doctors;
			$cli_doctors =$this->input->post('doctor');
			if(isset($cli_doctors) and $this->form_validation->run() == FALSE)
			{
				$content['cli_doctors'] = $cli_doctors;
			}

			$this->template->load('template', 'client/view', $content);
		}else{
			$client = $this->client_model->props();
			
			$content= array_merge($content,$client);
			$content['status'] = 'P';
			$content['sex']='M';
			$this->template->load('template','client/backtolist',$content);
		}
			
	}
	public function create($client_id = '')
	{

		$query_a= $this->db->query("SELECT * FROM amphur;");
		$query_p = $this->db->query("SELECT * FROM province;");
		$query_m = $this->db->query("SELECT * FROM marital_status;");
		$query_t = $this->db->query("SELECT * FROM title");
		$query_d = $this->db->query("SELECT * FROM doctor");
		$query_c = $this->db->query("SELECT * FROM company_contact where status = 'A'");
		
		$content['amphurs'] = $query_a;
		$content['provinces'] = $query_p;
		$content['maritals'] = $query_m;
		$doctors = array();
		$content['doctors'] = $query_d;
		$content['cli_doctors'] = array();
		$content['titles'] = $query_t;
		$content['companies'] = $query_c;
		$client;
		$doclist = array();

		foreach ($query_d->result_array() as $row) {
			$doclist [$row['doctor_id']] = $row['name'].' '.$row['surname'];
		}
		$content['doctors'] = $doclist;

		$this->load->model('client_model');
		$client = $this->client_model->props();
		$content= array_merge($content,$client);
		$content['status'] = 'P';
		$content['sex']='M';
		$cli_doctors =$this->input->post('doctor');
		if(isset($cli_doctors) and $this->form_validation->run() == FALSE)
		{
			$content['cli_doctors'] = $cli_doctors;
		}

		$this->template->load('template', 'client/create', $content);
	}
	public function edit($client_id='' )
	{

		$query_a= $this->db->query("SELECT * FROM amphur;");
		$query_p = $this->db->query("SELECT * FROM province;");
		$query_m = $this->db->query("SELECT * FROM marital_status;");
		$query_t = $this->db->query("SELECT * FROM title");
		$query_d = $this->db->query("SELECT * FROM doctor");
		$query_c = $this->db->query("SELECT * FROM company_contact where status = 'A'");
		$query_parent_treatment = $this->db->query('SELECT * FROM treatment where create_user = "'.$this->ion_auth->user()->row()->id.'" and parent_id is null and status="A"');
		$query_child_treatment = $this->db->query('SELECT * FROM treatment where create_user = "'.$this->ion_auth->user()->row()->id.'" and parent_id is not null and status="A" ');
		$query_special_treatment = $this->db->query('SELECT * FROM mt_continual_treatment where create_user = "'.$this->ion_auth->user()->row()->id.'" and status="A"');
		$query_promotion_special_treatment = $this->db->query('SELECT * FROM mt_treatment_promo_rel  rel inner join mt_promotion mt 
			on mt.promotion_id = rel.promo_id  where rel.create_user  = "'.$this->ion_auth->user()->row()->id.'"  and mt.status= "A" ');
		$query_promotion_tier = $this->db->query('SELECT * from mt_promotion p inner join mt_promotion_tier t on p.promotion_id = t.promo_id
			where p.create_user  = "'.$this->ion_auth->user()->row()->id.'"  and p.status= "A" ');

		
		$query_s = $this->db->query("SELECT * FROM service where status ='A' ");
		$query_l = $this->db->query("SELECT * FROM lab  where status ='A' ");

		$query_tooth_plan = $this->db->query('select * from tooth_plan where client_id = "'.$client_id.'"');

		$query_tooth_plan_detail = $this->db->query('select * from tooth_plan  p inner join tooth_plan_detail pdetail on p.tooth_plan_id = pdetail.tooth_plan_id where p.client_id = "'.$client_id.'"');

		$content['services'] = $query_s;
		$content['parent_treatment'] =$query_parent_treatment;
		$content['child_treatment'] =$query_child_treatment;
		$parent_child_treatment = array();
		$inner_treatment = array();


		foreach ($query_child_treatment->result_array() as $row) {
			$parent_child_treatment[$row['parent_id']][] = $row;
			$inner_treatment[$row['treatment_id']] = $row;
		}
		$special_promo_tier = array();
		$special_promo_rel = array();
		$special_promo = array();
		$promotion_rel = array();
		foreach ($query_promotion_special_treatment->result_array() as $row) {
			$special_promo_rel[$row['treatment_id']][]= $row;
			$special_promo[$row['treatment_id']] = $row;
		}
		foreach ($query_promotion_tier->result_array() as $row) {
			$special_promo_tier[$row['promotion_id']][] = $row;
		}
		$tooth_plan_detail = array();
		$tooth_plan =$query_tooth_plan->row();
		if(isset($tooth_plan) && isset($query_tooth_plan->row()->plan_date)){
			$content['plan_date'] = date('d-m-Y');
		}
		$content['plan_choice'] = $query_tooth_plan->row()->plan_choice;
		$content['plan_doctor_id'] = $query_tooth_plan->row()->doctor_id;
		$content['tooth_plan_id'] = $query_tooth_plan->row()->tooth_plan_id;
		$is_blank = array();
		$is_withdraws = array();
		$is_finish = array();

		foreach ($query_tooth_plan_detail->result_array() as $row) {
			$tooth_plan_detail[$row['tooth_number']][$row['tooth_side']][] = $row['method'];
			$is_blank[$row['tooth_number']][$row['tooth_side']] = $row['is_blank'];
			$is_withdraw[$row['tooth_number']][$row['tooth_side']] = $row['is_withdraw'];
			$is_finish[$row['tooth_number']][$row['tooth_side']] = $row['is_finish'];
		}
		$content['tooth_plan_detail'] =$tooth_plan_detail;
		$content['is_blanks']=$is_blank;
		$content['is_withdraws']=$is_withdraw;
		$content['is_finishes']=$is_finish;
		$content['tooth_plan_detail_json'] =json_encode($tooth_plan_detail);

		$content['relation_treatment'] = json_encode($parent_child_treatment);
		
		$content['inner_treatment']= json_encode($inner_treatment);
		$content['special_promo'] = json_encode($special_promo);
		$content['special_promo_rel'] = json_encode($special_promo_rel);
		$content['special_promo_tier'] = json_encode($special_promo_tier);

 
		$content['labs'] = $query_l;
		$content['amphurs'] = $query_a;
		$content['provinces'] = $query_p;
		$content['maritals'] = $query_m;
		$doctors = array();
		$content['doctors'] = $query_d;
		$content['q_doctors']= $query_d;
		$content['cli_doctors'] = array();
		$content['titles'] = $query_t;
		$content['companies'] = $query_c;
		$content['special_treatments'] = $query_special_treatment;
		$client;
		$doclist = array();

		foreach ($query_d->result_array() as $row) {
			$doclist [$row['doctor_id']] = $row['name'].' '.$row['surname'];
		}
		$content['doctors'] = $doclist;

		$this->load->model('client_model');
		if(isset($client_id) && !empty($client_id))
		{
			$client = $this->client_model->get($client_id);

			
			if(isset($client)){
				$content= array_merge($content,$client);
			}
			$query_clid = $this->db->query("SELECT * FROM client_doctor_rel where client_id = ".$client_id);
			foreach ($query_clid->result_array() as $row) {
				$doctors[] = $row['doctor_id'];
			}

			
			$content['cli_doctors'] = $doctors;
			$cli_doctors =$this->input->post('doctor');
			if(isset($cli_doctors) and $this->form_validation->run() == FALSE)
			{
				$content['cli_doctors'] = $cli_doctors;
			}
			//$this->load->view('client/client_edit_medical');
			//$this->load->view('client/client_edit_other');

			$this->template->load('template', 'client/edit', $content);
		}else{
			$this->template->load('template', 'client/backtolist',$content);
		}
			
	}
	public function save()
	{
		$this->validation();
		if ($this->form_validation->run() == FALSE){
			if($this->input->post('client_id') && !empty($this->input->post('client_id'))){
                $this->edit($this->input->post('client_id'));
            }else{
            	 $this->create();
            }
        }else{

			$this->load->model("client_model");

			if($this->input->post('client_id') && !empty($this->input->post('client_id'))){
				$result = $this->client_model->update_entry();
				
			}else{
				echo 'insert';
				$this->client_model->insert_entry();
			}

			redirect(base_url()."clients/");

        }

	}

	public function delete()
	{
		$delete_id = $this->input->post('delete_id');
		$method = $this->input->method(TRUE); 
		if($method == "POST")
		{	
			$this->load->model("client_model");
			if(sizeof($delete_id) > 0){
				$status = $this->client_model->delete_array_entry($delete_id);
			}
			redirect(base_url()."client/delete");
		}else{
			$sql =  array("SELECT * ,FORMAT (DATEDIFF(CURRENT_DATE, STR_TO_DATE(birth_date, '%Y-%m-%d'))/365 ,0) AS age FROM client WHERE 1=1 ");
			$name = $this->input->post('name_thai');
			$surname = $this->input->post('surname_thai');
			$phone = $this->input->post('phone_no');
			$hn = $this->input->post('hn');
			if(!empty($name))
			{
				$sql[] = "and name_thai like '".$name."%'"; 
			}
			if(!empty($surname))
			{
				$sql[] = "and surname_thai like '".$surname."%'"; 
			}
			if(!empty($phone))
			{
				$sql[] = "and phone_no  = '".$phone."'"; 
			}
			if(!empty($hn))
			{
				$sql[] = "and hn like '%".$hn."%'"; 
			}

			$query_cli = $this->db->query(implode("  ", $sql));
			$content['client'] = $query_cli;
			$this->template->load('template', 'client/delete', $content);
		}
		//redirect(base_url()."clients/");

	}
	public function validation(){
		$this->form_validation->set_rules('name_thai', 'ชื่อ', 'required');
		$this->form_validation->set_rules('surname_thai', 'นามสกุล', 'required');
		$this->form_validation->set_rules('phone_no', 'เบอร์ติดต่อ', 'required');
	}
}
