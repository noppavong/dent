<?php
class Absent_model extends CI_Model {


	public $id;
	public $doctor_id;
	public $assistant_id;
	public $absent_date;
	public $type;
	public $create_date;
	public $create_user;
	public $status;


	public function get($id)
	{
		$this->db->where('id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('absent');
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
		$assistant_id =  $this->input->post('assistant_id'); 
		if(!empty($assistant_id)){
			$this->assistant_id = $this->input->post('assistant_id');
		}
		$this->type= (!empty($this->doctor_id))?1:0;
		$this->create_user = $this->ion_auth->user()->row()->id;

        $this->absent_date = date('Y-m-d',strtotime($this->input->post('absent_date')));
		$this->status = 'A';
		$this->db->insert('absent', $this);
		$absent_id = $this->db->insert_id();
		$this->db->trans_complete();                
		return array('id'=>$absent_id,'status'=> $this->db->trans_status());

	}

	public function update_entry()
	{
		$this->load->library('ion_auth');
		$update_obj =  new stdClass();
		$doctor_id =  $this->input->post('doctor_id'); 
		if(!empty($doctor_id)){
			$update_obj->doctor_id = $this->input->post('doctor_id'); 
		}
		$assistant_id =  $this->input->post('assistant_id'); 
		if(!empty($assistant_id)){
			$update_obj->assistant_id = $this->input->post('assistant_id');
		}
		$update_obj->type= (!empty($this->doctor_id))?1:0;
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');

        $update_obj->absent_date = date('Y-m-d',strtotime($this->input->post('absent_date')));
		
	    $this->db->where('id', $this->input->post('id'));
	    $this->db->update('absent', $update_obj);
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  	public function delete_entry($id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
            $sql = "UPDATE absent SET status = ?, update_date= now() ,update_user = ? WHERE id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}