<?php
class Promotion_model extends CI_Model {


	public $promotion_id;
	public $code;
	public $times;
	public $sum_price;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;
	public $name;

	public function get($id)
	{
		$this->db->where('promotion_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('mt_promotion');
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
		$this->sum_price = $this->input->post('sumprice');
		$this->code = $this->input->post('code');
		$this->times = $this->input->post('times');
		$this->name = $this->input->post('name');
		$this->status='A';	
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->db->insert('mt_promotion', $this);
		$promotion_id = $this->db->insert_id();
		$installments = $this->input->post('installment[]');
		$starts = $this->input->post('start[]');
		$ends = $this->input->post('end[]');
		if(!empty($installments)){
			$i = 0;
			for($i = 0 ; $i< sizeof($installments); $i++) {
				$data = array('installment'=>$installments[$i],
									'start'=>$starts[$i],
									'end'=>$ends[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'promo_id'=>$promotion_id
 									);

				$this->db->insert('mt_promotion_tier',$data);
			}
		}
		$this->db->trans_complete();                
		return array('id'=>$promotion_id,'status'=> $this->db->trans_status());

	}

	public function update_entry()
	{
		$update_obj =  new stdClass();
		$update_obj->sum_price =  $this->input->post('sumprice');
		$update_obj->times = $this->input->post('times');
		$update_obj->code = $this->input->post('code');
		$update_obj->name = $this->input->post('name');
		$update_obj->status ='A';
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
	    $this->db->where('promotion_id', $this->input->post('promotion_id'));
	    $this->db->update('mt_promotion', $update_obj);	
        $this->db->delete('mt_promotion_tier', array('promo_id' => $this->input->post('promotion_id')));
        $installments = $this->input->post('installment[]');
		$starts = $this->input->post('start[]');
		$ends = $this->input->post('end[]');
		if(!empty($installments)){
			$i = 0;
			for($i = 0 ; $i< sizeof($installments); $i++) {
				$data = array('installment'=>$installments[$i],
									'start'=>$starts[$i],
									'end'=>$ends[$i],
									'create_user'=>$this->ion_auth->user()->row()->id,
									'promo_id'=>$this->input->post('promotion_id')
 									);

				$this->db->insert('mt_promotion_tier',$data);
			}
		}

		
		$this->db->trans_complete();
        return $this->db->trans_status();
	}

  	public function delete_entry($id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
            $sql = "UPDATE mt_promotion SET status = ?, update_date= now() ,update_user = ? WHERE promotion_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}