<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

	public function index()
	{
		
		$category_id = $this->input->post('category_id');
		$query_category = $this->db->query('select * from  category where status = "A" and   parent_id is not null  and create_user =  "'.$this->ion_auth->user()->row()->id.'" ; ');
		if(!empty($category_id))
		{
			$query_category = $this->db->query('select * from  category where status = "A" and   parent_id is not null  and create_user =  "'.$this->ion_auth->user()->row()->id.'" and category_id = '.$category_id.' ; ');
		}

		$content = array();
		$map_category = array();
		$map_parent = array();
		$query_parent_category = $this->db->query('select * from  category where status = "A" and parent_id is null ');

		foreach ($query_category->result_array() as $row) {
			$map_category[$row['category_id']] = $row['name'];
		}
		foreach ($query_parent_category->result_array() as $row) {
			$map_parent[$row['category_id']] = $row['name'];
		}
		$content['categorys'] = $query_category;
		$content['map_category'] =$map_category;
		$content['parents'] = $map_parent;
		$products = array();

		$query_product = $this->db->query('select * from  product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.' group by category_id order by category_id"; ');
		$query_expire = $this->db->query('select * from product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.'" and expire_date <= DATE_ADD(CURDATE(), INTERVAL 8 DAY)');
		foreach ($query_product->result_array() as $row) {
			$products[$row['category_id']][] = $row;
		}
		$content['products']= $products;
		$content['exp_prod']= $query_expire;
		$this->template->load('template', 'inventory/home', $content);
	}
	public function restock()
	{
		
		$category_id = $this->input->post('category_id');
		$query_category = $this->db->query('select * from  category where status = "A" and   parent_id is not null  and create_user =  "'.$this->ion_auth->user()->row()->id.'" ; ');
		if(!empty($category_id))
		{
			$query_category = $this->db->query('select * from  category where status = "A" and   parent_id is not null  and create_user =  "'.$this->ion_auth->user()->row()->id.'" and category_id = '.$category_id.' ; ');
		}

		$content = array();
		$map_category = array();
		$map_parent = array();
		$query_parent_category = $this->db->query('select * from  category where status = "A" and parent_id is null ');

		foreach ($query_category->result_array() as $row) {
			$map_category[$row['category_id']] = $row['name'];
		}
		foreach ($query_parent_category->result_array() as $row) {
			$map_parent[$row['category_id']] = $row['name'];
		}
		$content['categorys'] = $query_category;
		$content['map_category'] =$map_category;
		$content['parents'] = $map_parent;
		$products = array();

		$query_product = $this->db->query('select * from  product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.' group by category_id order by category_id"; ');
		foreach ($query_product->result_array() as $row) {
			$products[$row['category_id']][] = $row;
		}
		$content['products']= $products;
		$this->template->load('template', 'inventory/restock', $content);
	}
	public function log()
	{
		$query_deposit = $this->db->query('select deposit_date from deposit where create_user =  "'.$this->ion_auth->user()->row()->id.'" group by deposit_date ; ');
		$query_withdraw = $this->db->query('select withdraw_date from withdraw where create_user =  "'.$this->ion_auth->user()->row()->id.'" group by withdraw_date ; ');
		$content = array();
		$content['deposits']  = $query_deposit;
		$content['withdraws'] = $query_withdraw;
		$this->template->load('template', 'inventory/log', $content);
	}
	public function log_deposit($deposit_id)
	{
		$query_deposit = $this->db->query('select * from deposit_detail dt inner join deposit d on dt.deposit_id =d.deposit_id inner join  product on product.product_id = dt.product_id where dt.create_user =  "'.$this->ion_auth->user()->row()->id.'"  and d.deposit_date = '.$deposit_id.'"');
		$content = array();
		$content['deposits']  = $query_deposit;
		$this->template->load('template', 'inventory/log_deposit', $content);
	}
	public function log_withdraw($withdraw_id)
	{
		$query_withdraw = $this->db->query('select * from  withdraw_detail wd inner join withdraw w on w.withdraw_id =wd.withdraw_id inner join product on product.product_id = wd.product_id where wd.create_user =  "'.$this->ion_auth->user()->row()->id.'"  and w.withdraw_date = "'.$withdraw_id.'" ');
		$content = array();
		$content['withdraws']  = $query_withdraw;
		$this->template->load('template', 'inventory/log_withdraw', $content);
	}
	function get_numerics ($str) {
	    preg_match_all('/\d+/', $str, $matches);
	    return $matches[0][0];
	}
	public function saveStock()
	{
		$mapData =array();
		 foreach($_POST as $key => $val)  
    	{  

			if (strpos($key, 'row-') !== false) {
				$product_id = $this->get_numerics($key);
				$inventory = $val;
				$mapData[''.$product_id] = array('inventory' =>$val,'update_user'=>$this->ion_auth->user()->row()->id,'update_date'=>date('Y-m-d H:i:s'));
			}

    	}
    	if(sizeof($mapData) > 0)
    	{
    		$this->load->model('product_model');
    		$this->product_model->updateStock($mapData);
    	}
    	 redirect('/inventory', 'refresh');

	}
    public function category()
    {
    	$query_parent_category = $this->db->query('select * from  category where status = "A" and parent_id is null ');
		$content = array();
		$content['categorys'] = $query_parent_category;
		$this->template->load('template', 'inventory/category', $content);
    }
    public function product()
    {
    		$query_category = $this->db->query('select * from  category where status = "A" and   parent_id is not null  and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');

		$content = array();
		$content['categorys'] = $query_category;
		$this->template->load('template', 'inventory/product', $content);
    }
    public function deposit()
    {
    		$query_product = $this->db->query('select * from  product where status = "A"  and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
    		$products = array();
    		$product_exp = array();
    		foreach ($query_product->result_array() as $row) {
    			$products[$row['code']]= array($row['price'],$row['name'],$row['product_id'],$row['expire_date']);
    			if(!empty($row['expire_date']))
    			{
    				$product_exp[$row['code']][] = $row['expire_date'];
    			}

    		}
		$content = array();
		$content['product'] = $products;
		$content['product_exp'] = $product_exp;
		$this->template->load('template', 'inventory/deposit', $content);
    }
    public function withdraw()
    {
    		$query_product = $this->db->query('select code,price,name,sum(inventory) as suminv from  product where status = "A"  and inventory > 0 and create_user =  "'.$this->ion_auth->user()->row()->id.'" group by code ; ');
    		$products = array();
    		foreach ($query_product->result_array() as $row) {
    			$products[$row['code']]= array($row['price'],$row['name'],$row['suminv']);
    		}
		$content = array();
		$content['product'] = $products;

		$this->template->load('template', 'inventory/withdraw', $content);
    }
     public function listproduct()
	{
		$query_product = $this->db->query('select * from  product where status = "A" and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$query_category = $this->db->query('select * from  category where status = "A" and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');

		$map_category = array();

		foreach ($query_category->result_array() as $row) {
			$map_category[$row['category_id']]  = $row['name'];
		}
		$struct = array();
		foreach ($query_product->result_array() as $row) {
			
			$category_name = (isset($row['category_id']))?$map_category[$row['category_id']]:"-";
			
			$expire_date = '-';
		if(!empty($row['expire_date'])){
			$expire_date = date('d-m-Y',strtotime($row['expire_date']));
		}
		
			$struct[] = array($row['product_id'],$row['code'],$row['name'],$row['price'],$category_name,$expire_date);

		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
    public function listcategory()
	{
		$query_category = $this->db->query('select * from  category where status = "A"  and parent_id is not null and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$query_parent_category = $this->db->query('select * from  category where status = "A" and parent_id is null ');
		$map_parent = array();

		foreach ($query_parent_category->result_array() as $row) {
			$map_parent[$row['category_id']]  = $row['name'];
		}
		$struct = array();
		foreach ($query_category->result_array() as $row) {
			
			$parent_name = (isset($row['parent_id']))?$map_parent[$row['parent_id']]:"-";
			$struct[] = array($row['category_id'],$row['name'],$parent_name);
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function savecategory()
	{
		$this->category_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$category_id = $this->input->post('category_id');
        	if(!empty($category_id))
        	{
				$this->load->model("category_model");
        		$result = $this->category_model->update_entry();
        	}else{
				$this->load->model("category_model");
				$this->category_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function saveproduct()
	{
		$this->product_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$product_id = $this->input->post('product_id');
        	if(!empty($product_id))
        	{
				$this->load->model("product_model");
        		$result = $this->product_model->update_entry();
        	}else{
				$this->load->model("product_model");
				$this->product_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function get_category($category_id)
	{
		$this->load->model('category_model');
		$result = array();
		$category = $this->category_model->get($category_id);
		$result['category'] =$category;
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function get_product($product_id)
	{
		$this->load->model('product_model');
		$result = array();
		$product = $this->product_model->get($product_id);
		$result['product'] =$product;
		if(!empty($product['expire_date'])){
			$result['product']['expire_date'] = date('d-m-Y',strtotime($product['expire_date']));
		}
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function delete_category($id)
	{
		$this->load->model('category_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->category_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_product($id)
	{
		$this->load->model('product_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->product_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function savedeposit()
	{	
		$this->deposit_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        		$this->load->model("deposit_model");
        		$result = $this->deposit_model->insert_entry();
        		echo json_encode(array('status'=>'1'));
			header('Content-Type: application/json');
        }
	}
	public function savewithdraw()
	{	
		$this->withdraw_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        		$this->load->model("withdraw_model");
        		$result = $this->withdraw_model->insert_entry();
        		echo json_encode(array('status'=>'1'));
			header('Content-Type: application/json');
        }
	}
	public function deposit_validation(){
		$this->form_validation->set_rules('deposit_date', 'วันที่นำเข้า', 'required');
		$data = $this->input->post('data');
		foreach ($data as $rowid => $row) {
				if(!empty($row[0])){
					$this->form_validation->set_rules('data['.$rowid.'][2]', 'จำนวน '.$data[$rowid][1], 'required');
				}
		}
	}
	public function withdraw_validation(){
		$this->form_validation->set_rules('withdraw_date', 'วันที่นำออก', 'required');
		$this->form_validation->set_rules('withdrawer', 'ผู้นำออก', 'required');
		$this->form_validation->set_rules('data[]', 'max order', 'callback_validdate_maxorder');
		$data = $this->input->post('data');
		
		if(!empty($data))
		{
			foreach ($data as $rowid => $row) {
					if(!empty($row[0])){
						$this->form_validation->set_rules('data['.$rowid.'][3]', 'จำนวน '.$data[$rowid][1], 'required');
					}
			}
		}
	}
	function validdate_maxorder($data) {
		$datas= $this->input->post("data");
		$maxper_product = array();
		$use_product = array();
		$success = true;
		if(!empty($datas))
		{
			foreach ($datas as $rowid => $row) {
				if(!empty($row[0])){
					$maxper_product[''.$row[0]] = $row[2];
					if(!isset($use_product[$row[0]]))
					{
						$use_product[''.$row[0]] = $row[3];

					}else{

						$use_product[''.$row[0]] += $row[3];
					}
				}
			}
			foreach ($use_product as $key => $value) {
				if($value > $maxper_product[$key]){
	   				$this->form_validation->set_message('validdate_maxorder', 'สินค้า '.$key.' เบิกเกินจำนวน');
	   				$success = false;
	   			}
			}
		}
	   return $success;

	} 
	function validate_unique($code, $expire_date)
	{
		$query = $this->db->query('select * from product where code = "'.$code.'" and expire_date = "'.$expire_date.'"');
		if(sizeof($query->result_array() > 0))
		{
			$this->form_validation->set_message('validate_unique', 'สินค้า รหัส '.$code.' มีอยู่แล้ว');
	   		return false;
		}else{
			return true;
		}

	}
	public function category_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('parent_id', 'หมวดหมู่หลัก', 'required');
	}
	public function product_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('code', 'รหัส', 'required');
		$this->form_validation->set_rules('price', 'ราคา', 'required');
		$this->form_validation->set_rules('category_id', 'หมวดหมู่', 'required');
		$category_id = $this->input->post('category_id');
		if($category_id == 2){

			$this->form_validation->set_rules('expire_date', 'วันหมดอายุ', 'required');
		}
		$this->form_validation->set_rules('code', 'สินค้า', 'callback_validate_unique['.$this->input->post('expire_date').']');

	}


}