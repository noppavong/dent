<?php
class Withdraw_model extends CI_Model {


	public $withdraw_date;
	public $create_user;
	public $create_date;
	public $withdrawer;

	public function get($id)
	{
		$this->db->where('withdraw_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('withdraw');
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
		$withdraw_date = $this->input->post('withdraw_date');
		if(!empty($withdraw_date)){

			$this->withdraw_date =date('Y-m-d',strtotime($this->input->post('withdraw_date'))); 
		}else{
			$this->withdraw_date = null;
		}
		$this->withdrawer = $this->input->post('withdrawer');
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->db->insert('withdraw', $this);
		$withdraw_id = $this->db->insert_id();
		$query_product = $this->db->query('select * from  product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.'" and inventory > 0 order by expire_date asc');
		$products = array();
		$product_log = array();
		$mem_qty = array();
		foreach ($query_product->result_array() as $row) {
			$products[$row['code']][] = $row['product_id'];
			if(!empty($row['inventory']))
			{
				$product_log[''.$row['product_id']] =$row['inventory'];
				$mem_qty[''.$row['product_id']] =$row['inventory'];

			}else{
				$product_log[''.$row['product_id']] = 0;
				$mem_qty[''.$row['product_id']] = 0;
			}

		}
		$datas = $this->input->post('data');
		$log = array();
		if(isset($datas)){
	        foreach ($datas as $rowidx=>$row) {
	        	 if(!empty($row[0])){
					$i = 0;
					$remove_qty = intval($row[3]);

					 do{
					 	$old_qty = intval($mem_qty[''.$products[$row[0]][$i]]);
					 	if($old_qty > 0){
							if(empty($log[''.$products[$row[0]][$i]])){
								if($remove_qty > $old_qty){
									$log[''.$products[$row[0]][$i]]=$old_qty;
									$mem_qty[''.$products[$row[0]][$i]] = 0;
								}else{

									$log[''.$products[$row[0]][$i]]=$remove_qty;
									$mem_qty[''.$products[$row[0]][$i]] = $old_qty-$remove_qty;
								}
							}else{

								if($remove_qty > $old_qty){
									$log[''.$products[$row[0]][$i]]+= $old_qty;
									$mem_qty[''.$products[$row[0]][$i]] = 0;
								}else{
									$log[''.$products[$row[0]][$i]]+= $remove_qty;
									$mem_qty[''.$products[$row[0]][$i]] -= $old_qty-$remove_qty;
								}
							}

							$remove_qty = $remove_qty - $old_qty;

					 	}

						$i++;
					}while ($remove_qty > 0);
					
				}
			}

			
			foreach ($log as $key => $value) {
				$data = array(
					'withdraw_id' => $withdraw_id,
					'product_id' => $key ,
					'create_user'=> $this->ion_auth->user()->row()->id,
					'quantity' => $value,
				);

				$this->db->insert('withdraw_detail', $data);
				$data = array('product_id'=>$key 
						,'withdraw_id' =>$withdraw_id
						,'create_user'=> $this->ion_auth->user()->row()->id
					    ,'before'=>$product_log[$key]
					    ,'after'=>$mem_qty[$key]

				);
				$this->db->insert('inventory_log', $data);
				$update_obj = array('inventory'=>$product_log[$key]-$value);
                $this->db->where('product_id', $key);
                $this->db->update('product', $update_obj);
			}


		} 


		$this->db->trans_complete();                
		return array('id'=>$withdraw_id,'status'=> $this->db->trans_status());

	}



}