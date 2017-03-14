<?php
class Product_model extends CI_Model {


	public $name;
	public $price;
	public $code;
	public $expire_date;
	public $category_id;
	public $status;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;

	public function get($id)
	{
		$this->db->where('product_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('product');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;
	}
	
	public function updateStock ($mapData)
	{  
			$update_obj =  new stdClass();
		$this->db->trans_start();
		foreach ($mapData as $key => $value) {
			$update_obj = $value;
	        $this->db->where('product_id', $key);
	        $this->db->update('product', $update_obj);
		}
		$this->db->trans_complete();
        return $this->db->trans_status();
	}
	
	public function insert_entry()
	{
		$this->load->library('ion_auth');
		$this->db->trans_start();
		$this->name = $this->input->post('name'); 
		$this->price = $this->input->post('price');
		$this->code = $this->input->post('code');
		$this->inventory = 0;
		$expire_date = $this->input->post('expire_date');
		if(!empty($expire_date)){

			$this->expire_date =date('Y-m-d',strtotime($this->input->post('expire_date'))); 
		}else{
			$this->expire_date = null;
		}
		$this->category_id = $this->input->post('category_id');
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->status = 'A';
		$this->db->insert('product', $this);
		$product_id = $this->db->insert_id();
		

		$this->db->trans_complete();                
		return array('id'=>$product_id,'status'=> $this->db->trans_status());

	}

	public function update_entry()
	{
		$update_obj =  new stdClass();
		$this->db->trans_start();
		$update_obj->name = $this->input->post('name'); 
		$update_obj->price = $this->input->post('price');
		$update_obj->code = $this->input->post('code');
		$expire_date = $this->input->post('expire_date');
		if(!empty($expire_date)){

			$update_obj->expire_date = date('Y-m-d',strtotime($this->input->post('expire_date'))); 
		}
		$update_obj->category_id = $this->input->post('category_id');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
        $this->db->where('product_id', $this->input->post('product_id'));
        $this->db->update('product', $update_obj);
		$this->db->trans_complete();
        return $this->db->trans_status();
	}
	
  	public function delete_entry($product_id = "")
    {		
    		$this->db->trans_start();
            $sql = "UPDATE product SET status = ?, update_date= now() ,update_user = ? WHERE product_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$product_id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}