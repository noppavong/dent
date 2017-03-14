<?php
class Category_model extends CI_Model {


	public $name;
	public $parent_id;
	public $status;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;

	public function get($id)
	{
		$this->db->where('category_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('category');
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
		$parent_id = $this->input->post('parent_id');
		if(!empty($parent_id))
		{
			$this->parent_id = $parent_id;
		}
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->status = 'A';
		$this->db->insert('category', $this);
		$category_id = $this->db->insert_id();
		$this->db->trans_complete();                
		return array('id'=>$category_id,'status'=> $this->db->trans_status());
	}

	public function update_entry()
	{
		$update_obj =  new stdClass();
		$this->db->trans_start();
		$update_obj->name = $this->input->post('name'); 
		$update_obj->parent_id = $this->input->post('parent_id');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
        $this->db->where('category_id', $this->input->post('category_id'));
        $this->db->update('category', $update_obj);
		$this->db->trans_complete();
        return $this->db->trans_status();
	}
	
  	public function delete_entry($category_id = "")
    {		
    		$this->db->trans_start();
            $sql = "UPDATE category SET status = ?, update_date= now() ,update_user = ? WHERE category_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$category_id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}