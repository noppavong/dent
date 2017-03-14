<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lab_model extends CI_Model {

        public $lab_id;
        public $name;
        public $create_user;
        public $create_date;
        public $status;

        public function props() {
            return get_object_vars($this);
        }
        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_last_ten_entries()
        {
                $query = $this->db->get('entries', 10);
                return $query->result();
        }
        public function get($id)
        {
             $this->db->where('lab_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('lab');
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
                $this->create_user = 1;
                $this->status = 'A';
                $this->create_date = date('Y-m-d');
                $this->db->insert('lab', $this);
                $lab_id = $this->db->insert_id();
                $this->db->trans_complete();                
                return array('id'=>$lab_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry2($lab_id)
        {

            $this->db->trans_start();
            $sql = "UPDATE lab SET status = ? WHERE lab_id = ?";
            $this->db->query($sql, array( "D", $lab_id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function delete_entry()
        {

            $this->db->trans_start();
            $sql = "UPDATE lab SET status = ? WHERE lab_id = ?";
            $this->db->query($sql, array( "D", $this->input->post('id')));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {   
            $this->db->trans_start();
            $update = new stdClass();
            $update->name = $this->input->post('name');  
            $update->status = 'A';             
            $this->db->where('lab_id', $this->input->post('lab_id'));
                $this->db->update('lab', $update);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
}
