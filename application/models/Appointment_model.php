<?php
class Appointment_model extends CI_Model {
	public $appointment_id;
	public $doctor_id;
	public $client_id;
	public $appointment_date;
	public $custom_client;
	public $start_time;
	public $end_time;
	public $note;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;
	public $period;
	public $phone_no;
	public $status;
	public $confirm_first;
	public $confirm_second;

	public function get($id)
	{
		$this->db->where('id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('appointment');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;
	}
	public function insert_entry()
	{
		$this->load->library('ion_auth');
		$this->db->trans_start();
		$doctor_id =  $this->input->post('doctor_id'); 
		if(!empty($doctor_id)){
			$this->doctor_id = $this->input->post('doctor_id'); 
		}
		$client_id =  $this->input->post('client_id'); 
		if(!empty($client_id)){
			$this->client_id = $this->input->post('client_id');
		}
		$this->note = $this->input->post('note');
		$this->custom_client = $this->input->post('custom_client');
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->job_id = $this->input->post('job_id');
        $this->appointment_date = date('Y-m-d',strtotime($this->input->post('appointment_date')));
        $this->start_time = $this->input->post('start_time');
		$this->end_time = $this->input->post('end_time');
		$this->phone_no = $this->input->post('phone_no');
		$this->period = $this->input->post('period');
		$this->status = 'A';

		$this->db->insert('appointment', $this);
		$appointment_id = $this->db->insert_id();
		$this->db->trans_complete();                
		return array('id'=>$appointment_id,'status'=> $this->db->trans_status());
	}
	public function update_endtime()
	{
		$this->load->library('ion_auth');
		$update_obj =  new stdClass();
		$update_obj->end_time = $this->input->post('end_time');	
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
		
	    $this->db->where('appointment_id', $this->input->post('appointment_id'));
	    $this->db->update('appointment', $update_obj);
		$this->db->trans_complete();
        return $this->db->trans_status();

	}
	public function update_entry()
	{
		$this->load->library('ion_auth');
		$update_obj =  new stdClass();
		$doctor_id =  $this->input->post('doctor_id'); 
		if(!empty($doctor_id)){
			$update_obj->doctor_id = $this->input->post('doctor_id'); 
		}
		$client_id =  $this->input->post('client_id'); 
		if(!empty($client_id)){
			$this->client_id = $this->input->post('client_id');
		}
		$update_obj->note = $this->input->post('note');
		$update_obj->custom_client = $this->input->post('custom_client');
		$update_obj->create_user = $this->ion_auth->user()->row()->id;
		$update_obj->job_id = $this->input->post('job_id');
        $update_obj->appointment_date = date('Y-m-d',strtotime($this->input->post('appointment_date')));
        $update_obj->start_time = $this->input->post('start_time');
		$update_obj->end_time = $this->input->post('end_time');
		$update_obj->phone_no = $this->input->post('phone_no');
		$update_obj->period = $this->input->post('period');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->confirm_first = $this->input->post('confirm_first');
		$update_obj->confirm_second = $this->input->post('confirm_second');
		$update_obj->update_date = date('Y-m-d H:i:s');

		
	    $this->db->where('appointment_id', $this->input->post('appointment_id'));
	    $this->db->update('appointment', $update_obj);
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  	public function delete_entry($id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
            $sql = "UPDATE appointment SET status = ?, update_date= now() ,update_user = ? WHERE appointment_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}