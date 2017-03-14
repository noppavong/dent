<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assistant extends CI_Controller {

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
		$sql =  array("SELECT * from assistant a  WHERE 1=1 ");
		$name = $this->input->post('name');
		$surname = $this->input->post('surname');
		$phone = $this->input->post('phone_no');
		$date = $this->input->post('date');
		if(!empty($name))
		{
			$sql[] = "and name like '".$name."%'"; 
		}
		if(!empty($surname))
		{
			$sql[] = "and surname like '".$surname."%'"; 
		}
		if(!empty($phone))
		{
			$sql[] = "and phone_no  = '".$phone."'"; 
		}
		if(!empty($date))
		{
			$sql[] = "and  assistant_id  not in (select assistant_id from assistant_holiday where holiday_id = ".(date('w',strtotime($date))+1).")"; 
		}
		$sql[] = ' group by a.assistant_id';
		$query_assistant = $this->db->query(implode("  ", $sql));

		$content['assistants'] = $query_assistant;
		$this->template->load('template', 'assistant/list', $content);

	}
	public function view($assistant_id='')
	{
		
		$query_s= $this->db->query("SELECT * FROM assistant_skill;");
		$query_b= $this->db->query("SELECT * FROM bank;");
		$query_h= $this->db->query("SELECT * FROM holiday");

		
		$content['banks'] = $query_b;
		$content['skills'] = $query_s;
		$content['assistant_skills'] = array();
		$skills = array();
		$skilllist = array();

		foreach ($query_s->result_array() as $row) {
			$skilllist [$row['skill_id']] = $row['name'];
		}
		$content['skills'] = $skilllist;

		$this->load->model('assistant_model');
		if(isset($assistant_id) && !empty($assistant_id))
		{
			$assistant = $this->assistant_model->get($assistant_id);

			
			if(isset($assistant)){
				$content= array_merge($assistant,$client);
			}
			$query_askill = $this->db->query("SELECT * FROM assistant_skill_rel where assistant_id = ".$assistant_id);
			foreach ($query_askill->result_array() as $row) {
				$doctors[] = $row['doctor_id'];
			}

			
			$content['cli_doctors'] = $doctors;
			$query_askill = $this->db->query("SELECT * FROM assistant_skill_rel where assistant_id = ".$assistant_id);
			foreach ($query_askill->result_array() as $row) {
				$skills[] = $row['skill_id'];
			}

			
			$content['assistant_skills'] = $skills;

			$this->template->load('template', 'assistant/view', $content);
		}else{
			$client = $this->client_model->props();
			
			$content= array_merge($content,$client);
			$content['status'] = 'P';
			$content['sex']='M';
		}
			
	}
	public function edit($assistant_id='' )
	{

		$query_s= $this->db->query("SELECT * FROM assistant_skill;");
		$query_b= $this->db->query("SELECT * FROM bank;");
		$query_h= $this->db->query("SELECT * FROM holiday");

		
		$content['banks'] = $query_b;
		$content['skills'] = $query_s;
		$content['holidays'] = $query_h;
		$content['assistant_skills'] = array();
		$skills = array();
		$holidays = array();
		$skilllist = array();
		$holidaylist = array();

		foreach ($query_s->result_array() as $row) {
			$skilllist [$row['skill_id']] = $row['name'];
		}
		$content['skills'] = $skilllist;
		foreach ($query_h->result_array() as $row) {
			$holidaylist [$row['holiday_id']] = $row['name'];
		}

		$content['holidays'] = $holidaylist;
		$this->load->model('assistant_model');

		if(isset($assistant_id) && !empty($assistant_id))
		{
			$assistant = $this->assistant_model->get($assistant_id);

			
			if(isset($assistant)){
				$content= array_merge($content,$assistant);
			}
			$query_askill = $this->db->query("SELECT * FROM assistant_skill_rel where assistant_id = ".$assistant_id);
			foreach ($query_askill->result_array() as $row) {
				$skills[] = $row['skill_id'];
			}
			$query_asholiday = $this->db->query("SELECT * FROM assistant_holiday where assistant_id = ".$assistant_id);
			foreach ($query_asholiday->result_array() as $row) {
				$holidays[] = $row['holiday_id'];
			}

			$content['assistant_skills'] = $skills;
			$content['assistant_holidays']= $holidays;
		}else{
			$assistant = $this->assistant_model->props();
			
			$content= array_merge($content,$assistant);
		}
			$assistant_skills =$this->input->post('skill');
			if(isset($assistant_skills) and $this->form_validation->run() == FALSE)
			{
				$content['assistant_skills'] = $assistant_skills;
			}
			$assistant_holidays=$this->input->post('holidays');
			if(isset($assistant_holidays) and $this->form_validation->run() == FALSE)
			{

				$content['assistant_holidays']=$assistant_holidays;
			}

			$this->template->load('template', 'assistant/edit', $content);

	}
	public function save()
	{
		$this->validation();
		if ($this->form_validation->run() == FALSE){
                $this->edit($this->input->post('assistant_id'));
        }else{

			$this->load->model("assistant_model");

			if($this->input->post('assistant_id') && !empty($this->input->post('assistant_id'))){
				$result = $this->assistant_model->update_entry();
				
			}else{
				echo 'insert';
				$this->assistant_model->insert_entry();
			}

			redirect(base_url()."assistants/");

        }

	}
	public function delete($assistant_id = '')
	{
		if(isset($client_id))
		{	
			$this->load->model("assistant_model");
			$this->assistant_model->delete_entry($assistant_id);
		}
		redirect(base_url()."assistants/");

	}
	public function validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
		$this->form_validation->set_rules('phone_no', 'เบอร์ติดต่อ', 'required');
	}
}
