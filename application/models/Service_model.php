<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Service_model extends CI_Model {

        public $service_id;
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
             $this->db->where('service_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('service');
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
                $this->db->insert('service', $this);
                $service_id = $this->db->insert_id();
                $this->db->trans_complete();           
                $this->create_date = date('Y-m-d');     
                return array('id'=>$service_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry2($service_id)
        {


            $this->db->trans_start();
            $sql = "UPDATE service SET status = ? WHERE service_id = ?";
            $this->db->query($sql, array( "D", $service_id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }

        public function delete_entry($service_id = "")
        {
           

            $this->db->trans_start();
            $sql = "UPDATE service SET status = ? WHERE service_id = ?";
            $this->db->query($sql, array( "D", $this->input->post('service_id')));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }


        public function update_entry()
        {
               
               $this->db->trans_start();
               $updatestd = new stdClass();
                $updatestd->name = $this->input->post('name'); 
                 $updatestd->status = 'A';                           
                 $updatestd->update_user = 1;
                 $updatestd->update_date = date('Y-m-d H:i:s');
                $this->db->where('service_id', $this->input->post('service_id'));
                 $this->db->update('service', $updatestd);
                $this->db->trans_complete();
                return $this->db->trans_status();
        }
}
