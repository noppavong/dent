<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lab extends CI_Controller {

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
	
	public function create($client_id = '')
	{
		$content = array();

		$query_d= $this->db->query("SELECT * FROM doctor;");
		$query_s = $this->db->query("SELECT * FROM service where status ='A' ");
		$query_l = $this->db->query("SELECT * FROM  lab where status ='A' ");

		$content['doctors'] = $query_d;
		$content['services'] = $query_s;
		$content['labs'] = $query_l;

		if(!empty($client_id))
		{  
			$content['client_id'] = $client_id;
			$this->template->load('template', 'lab/create', $content);
		}else{
			redirect('<?= base_url() ?>lab');
		}	
	}
	public function name()
	{
		$content = array();
		$this->template->load('template', 'lab/labname', $content);
	}
	public function servicename()
	{
		$content = array();
		$this->template->load('template', 'lab/servicename', $content);
	}
	public function edit($labts_id = '')
	{
		$content = array();
		$query_d = $this->db->query("SELECT * FROM doctor   ");
		$query_s = $this->db->query("SELECT * FROM service where status ='A' ");
		$query_l = $this->db->query("SELECT * FROM lab  where status ='A' ");

		$content['doctors'] = $query_d;
		$content['services'] = $query_s;
		$content['labs'] = $query_l;
		if(!empty($labts_id))
		{
			$this->load->model('labts_model');
			$labts = $this->labts_model->get($labts_id);			
			if(isset($labts)){
				$content= array_merge($content,$labts);
			}
			$this->template->load('template', 'lab/edit', $content);
		}else{
			$this->template->load('template', 'lab/backtolist',$content);
		}
	}
	public function index()
	{
		$sql =  array("SELECT *,l.name as lab_name,s.name as service_name ,d.name as doctor_name,d.surname as doctor_surname, c.name_thai as client_name,c.surname_thai as client_surname",
		 "FROM lab_transaction inner join doctor d on d.doctor_id = doctor  inner join client c on c.client_id = lab_transaction.client_id inner join lab l on l.lab_id = lab inner join service s on s.service_id = service  WHERE 1=1  AND lab_transaction.send_date > NOW() - INTERVAL 30 DAY");


		$query_d= $this->db->query("SELECT * FROM doctor;");
		$query_s = $this->db->query("SELECT * FROM service where status ='A' ");
		$query_l = $this->db->query("SELECT * FROM  lab where status ='A' ");
		$content['doctors'] = $query_d;
		$content['services'] = $query_s;
		$content['labs'] = $query_l;
		$send_date = $this->input->post('send_date');
		$lab = $this->input->post('lab');
		$doctor = $this->input->post('doctor');
		$is_received = $this->input->post('is_received');
		if(!empty($send_date))
		{
			$sql[] = "and send_date = '".date('Y-m-d',strtotime($send_date))."'"; 
		}
		if(!empty($lab))
		{
			$sql[] = "and lab = ".$lab.""; 
		}
		if(!empty($doctor))
		{
			$sql[] = "and doctor = ".$doctor.""; 
		}
		if(!empty($is_received))
		{
			$sql[] = "and is_received  = '".$is_received."'"; 
		}

		$query_labs = $this->db->query(implode("  ", $sql));
		$content['labts'] = $query_labs;
		$this->template->load('template', 'lab/list', $content);
	}

	public function save()
	{
		$this->validation();
		if ($this->form_validation->run() == FALSE){
                $this->create($this->input->post('client_id'));
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
			redirect(base_url()."lab/");

        }

	}
	public function validation(){
		$this->form_validation->set_rules('lab', 'ชื่อ lab', 'required');
		$this->form_validation->set_rules('service', 'ชื่อบริการ', 'required');
		$this->form_validation->set_rules('doctor', 'หมอ', 'required');
		$this->form_validation->set_rules('price','ราคา','decimal');
	}
}
