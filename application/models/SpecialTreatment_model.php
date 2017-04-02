<?php
class SpecialTreatment_model extends CI_Model {


	public $special_treatment_id;
	public $continual_treatment_id;
	public $promotion_id;
	public $client_id;
	public $doctor_id;
	public $status;
	public $treatment_date;

	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;



	public function get($id)
	{
		$this->db->where('special_treatment_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('special_treatment');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;

	}
	public function get_price($treatment_id)
	{
		$this->db->where('treatment_id',$treatment_id);
		$q = $this->db->get('treatment_pricing');
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
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->client_id = $this->input->post('client_special_id');
		$this->continual_treatment_id = $this->input->post('continual_treatment_id');
		$this->promotion_id = $this->input->post('promotion_id');
		$this->status = 'A';
		$this->doctor_id = $this->input->post('doctor_id');
		$treatment_date = $this->input->post('treatment_date');
		$this->treatment_date = date('Y-m-d',strtotime($treatment_date));
		$this->db->insert('special_treatment', $this);
		$special_treatment_id = $this->db->insert_id();

		$times = $this->input->post('time[]');
		$prices = $this->input->post('price[]');
		$doctor_id = $this->input->post('doctor_id');


		if(!empty($times)){
			$i = 0;
			for($i = 0 ; $i< sizeof($times); $i++) {
				$data = array('time'=>$times[$i],
									'price'=>$prices[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'special_treatment_id'=>$special_treatment_id
 									);

				$this->db->insert('special_treatment_trans',$data);
			}
		}
		$this->db->trans_complete();          

	}

	public function update_entry()
	{
		$this->db->trans_start();
		$update_obj =  new stdClass();
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->client_id = $this->input->post('client_special_id');
		$update_obj->continual_treatment_id = $this->input->post('continual_treatment_id');
		$update_obj->promotion_id = $this->input->post('promotion_id');
		$update_obj->status = 'A';
		$update_obj->update_date =  date('Y-m-d H:i:s');
		$update_obj->doctor_id = $this->input->post('doctor_id');
		$treatment_date = $this->input->post('treatment_date');
		$update_obj->treatment_date = date('Y-m-d',strtotime($treatment_date));
	    $this->db->where('special_treatment_id', $this->input->post('special_treatment_id'));
	    $this->db->update('special_treatment', $update_obj);
		$special_treatment_id =  $this->input->post('special_treatment_id');
        $this->db->delete('special_treatment_trans', array('special_treatment_id' => $special_treatment_id)); 

		$times = $this->input->post('time[]');
		$prices = $this->input->post('price[]');
		$doctor_id = $this->input->post('doctor_id');


		if(!empty($times)){
			$i = 0;
			for($i = 0 ; $i< sizeof($times); $i++) {
				$data = array('time'=>$times[$i],
									'price'=>$prices[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'special_treatment_id'=>$special_treatment_id
 									);

				$this->db->insert('special_treatment_trans',$data);
			}
		}
		$this->db->trans_complete();          
	}

  	public function delete_entry($id = "")
    {		
            $this->db->trans_start();
             $this->db->delete('special_treatment_trans', array('special_treatment_id' => $id)); 
             $this->db->delete('special_treatment', array('special_treatment_id' => $id)); 
             $this->db->trans_complete();
            return $this->db->trans_status();
    }


}