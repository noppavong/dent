<?php
class Deposit_model extends CI_Model {


	public $deposit_date;
	public $create_user;
	public $create_date;


	public function get($id)
	{
		$this->db->where('deposit_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('deposit');
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
		$deposit_date = $this->input->post('deposit_date');
		if(!empty($deposit_date)){

			$this->deposit_date =date('Y-m-d',strtotime($this->input->post('deposit_date'))); 
		}else{
			$this->deposit_date = null;
		}
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->db->insert('deposit', $this);
		$deposit_id = $this->db->insert_id();
		$query_product = $this->db->query('select * from  product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$products = array();
		$product_log = array();
		foreach ($query_product->result_array() as $row) {
			$expire_datestr = "";
			if(!empty($row['expire_date']))
			{
				$expire_datestr = $row['expire_date'];
			}
			$products[$row['code'].'-'.$expire_datestr]= $row['product_id'];
			if(!empty($row['inventory']))
			{

				$product_log[''.$row['product_id']] =$row['inventory'];
			}else{

				$product_log[''.$row['product_id']] = 0;
			}

		}
		$datas = $this->input->post('data');
		$log = array();
		if(isset($datas)){
	        foreach ($datas as $rowidx=>$row) {
	        	 if(!empty($row[0])){
					$data = array(
						'deposit_id' => $deposit_id,
						'product_id' => $products[$row[0].'-'.$row[1]] ,
						'create_user'=> $this->ion_auth->user()->row()->id,
						'quantity' => $row[3],
						);
					if(empty($log[''.$products[$row[0].'-'.$row[1]]])){

						$log[''.$products[$row[0].'-'.$row[1]]]= intval($row[3]);
					}else{

						$log[''.$products[$row[0].'-'.$row[1]]]+= intval($row[3]);
					}
					$this->db->insert('deposit_detail', $data);
				}
			}

			foreach ($log as $key => $value) {
				$data = array('product_id'=>$key 
						,'deposit_id' =>$deposit_id
						,'create_user'=> $this->ion_auth->user()->row()->id
					    ,'before'=>$product_log[$key]
					    ,'after'=>$product_log[$key]+$value

				);
				$this->db->insert('inventory_log', $data);
				$update_obj = array('inventory'=>$product_log[$key]+$value);
                $this->db->where('product_id', $key);
                $this->db->update('product', $update_obj);
			}


		} 


		$this->db->trans_complete();                
		return array('id'=>$deposit_id,'status'=> $this->db->trans_status());

	}

	

}