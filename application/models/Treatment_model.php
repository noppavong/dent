<?php
class Treatment_model extends CI_Model {


	public $treatment_id;
	public $parent_id;
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
		$q = $this->db->get('treatment');
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
		$this->promotion_id = $this->input->post('promotion_id');
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

	public function update_entry()
	{
		$update_obj =  new stdClass();
		$parent_id =  $this->input->post('parent_id'); 
		if(!empty($parent_id)){
			$update_obj->parent_id = $this->input->post('parent_id'); 
		}

		$update_obj->name=  $this->input->post('name');
		$update_obj->code = $this->input->post('code');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
		$update_obj->unit = $this->input->post('unit');
		$update_obj->price = $this->input->post('price');
	    $this->db->where('treatment_id', $this->input->post('treatment_id'));
	    $this->db->update('treatment', $update_obj);	
		
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  	public function delete_entry($id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
    		 $this->db->delete('treatment_pricing', array('treatment_id' => $id)); 
            $sql = "UPDATE treatment SET status = ?, update_date= now() ,update_user = ? WHERE treatment_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}