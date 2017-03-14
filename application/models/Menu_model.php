<?php
class Menu_model extends CI_Model {

	public function all()
	{
		return $this->db->get("menu")
					->result_array();
	}
	public function getbyParentId($menu_id = '')
	{
		  $this->db->where('parent_id', $menu_id);
		  return  $this->db->get('menu')->result_array();
	}

}