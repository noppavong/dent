<?php
class Continual_model extends CI_Model {


	public $treatment_id;
	public $status;
	public $name;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;

	public function get($id)
	{
		$this->db->where('treatment_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('mt_continual_treatment');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;

	}
	public function insert_entry()
	{
		$this->db->trans_start();
		$this->name = $this->input->post('name');
		$this->code = $this->input->post('code');
		$this->status='A';	
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->db->insert('mt_continual_treatment', $this);
		$treatment_id = $this->db->insert_id();

	    $promotion_id = $this->input->post('promotion_id');
	    foreach ($promotion_id as $value) {
	        $data = array(
	               'treatment_id' => $treatment_id ,
	               'promo_id' => intval($value) ,
	               'create_user' => $this->ion_auth->user()->row()->id
	            );
	         $this->db->insert('mt_treatment_promo_rel', $data);
	    }
	    
		$this->db->trans_complete();                
		return array('id'=>$treatment_id,'status'=> $this->db->trans_status());

	}

	public function update_entry()
	{
		$update_obj =  new stdClass();
		$update_obj->name =  $this->input->post('name');
		$update_obj->code = $this->input->post('code');
		$update_obj->status ='A';
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
	    $this->db->where('treatment_id', $this->input->post('treatment_id'));
	    $this->db->update('mt_continual_treatment', $update_obj);	
		$this->db->delete('mt_treatment_promo_rel', array('treatment_id' => $this->input->post('treatment_id') ));
	    $promotion_id = $this->input->post('promotion_id');
	    foreach ($promotion_id as $value) {
	        $data = array(
	               'treatment_id' => $this->input->post('treatment_id') ,
	               'promo_id' => intval($value) ,
	               'create_user' => $this->ion_auth->user()->row()->id
	            );
	         $this->db->insert('mt_treatment_promo_rel', $data);
	    }
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  	public function delete_entry($id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
            $this->db->delete('mt_treatment_promo_rel', array('treatment_id' => $treatment_id)); 
            $sql = "UPDATE mt_continual_treatment SET status = ?, update_date= now() ,update_user = ? WHERE treatment_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}