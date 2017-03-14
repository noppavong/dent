<?php
class TreatmentPlan_model extends CI_Model {


	public $plan_id;
	public $description;
	public $treatment_date;
	public $refer;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;
	public $client_id;
	public $doctor_id;


	public function get($id)
	{
		$this->db->where('plan_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('treatment_plan');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;
	}
	public function insert_list()
	{
		$this->db->trans_start();
		$this->description = $this->input->post('description');
		$this->refer  = $this->input->post('refer');
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->client_id = $this->input->post('client_id');
		$this->doctor_id = $this->input->post('doctor_id');
		$treatment_date = $this->input->post('treatment_date');
		$this->treatment_date = date('Y-m-d',strtotime($treatment_date));
		$this->db->insert('treatment_plan', $this);
		$plan_id = $this->db->insert_id();

		$treatment_ids = $this->input->post('treatment_id[]');
		$quantitys = $this->input->post('quantity[]');
		$prices = $this->input->post('price[]');
		$other_treatments = $this->input->post('other_treatment[]');
		$doctor_id = $this->input->post('doctor_id');


		if(!empty($treatment_ids)){
			$i = 0;
			for($i = 0 ; $i< sizeof($treatment_ids); $i++) {
				$data = array('treatment_id'=>$treatment_ids[$i],
									'quantity'=>$quantitys[$i],
									'price'=>$prices[$i],
									'other_treatment'=>$other_treatments[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'plan_id'=>$plan_id
 									);

				$this->db->insert('treatment_plan_detail',$data);
			}
		}
		$this->db->trans_complete();                
	}
	public function edit_list()
	{
		$this->db->trans_start();
		$update_obj =  new stdClass();
		$update_obj->description = $this->input->post('description');
		$update_obj->refer  = $this->input->post('refer');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->client_id = $this->input->post('client_id');
		$update_obj->doctor_id = $this->input->post('doctor_id');
		$update_obj->update_date =  date('Y-m-d H:i:s');
		$treatment_date = $this->input->post('treatment_date');
		$update_obj->treatment_date = date('Y-m-d',strtotime($treatment_date));

	    $this->db->where('plan_id', $this->input->post('plan_id'));
	    $this->db->update('treatment_plan', $update_obj);

		$plan_id =  $this->input->post('plan_id');
        $this->db->delete('treatment_plan_detail', array('plan_id' => $plan_id)); 

		$treatment_ids = $this->input->post('treatment_id[]');
		$quantitys = $this->input->post('quantity[]');
		$prices = $this->input->post('price[]');
		$other_treatments = $this->input->post('other_treatment[]');
		$doctor_id = $this->input->post('doctor_id');


		if(!empty($treatment_ids)){
			$i = 0;
			for($i = 0 ; $i< sizeof($treatment_ids); $i++) {
				$data = array('treatment_id'=>$treatment_ids[$i],
									'quantity'=>$quantitys[$i],
									'price'=>$prices[$i],
									'other_treatment'=>$other_treatments[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'plan_id'=>$plan_id
 									);

				$this->db->insert('treatment_plan_detail',$data);
			}
		}
		$this->db->trans_complete();                
	}
	public function update_entry()
	{
		$update_obj =  new stdClass();
	
		$update_obj->treatment_date=   date('Y-m-d',strtotime($this->input->post('treatment_date')));
		$update_obj->treatment_id = $this->input->post('treatment_id');
		$update_obj->description = $this->input->post('description');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->doctor_id = $this->input->post('doctor_id');
		$update_obj->update_date = date('Y-m-d H:i:s');

	    $this->db->where('plan_id', $this->input->post('plan_id'));
	    $this->db->update('treatment_plan', $update_obj);
		
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  		 public function delete_entry($plan_id = "")
        {
            $this->db->trans_start();
             $this->db->delete('treatment_plan_detail', array('plan_id' => $plan_id)); 
             $this->db->delete('treatment_plan', array('plan_id' => $plan_id)); 
             $this->db->trans_complete();
            return $this->db->trans_status();
        }


}