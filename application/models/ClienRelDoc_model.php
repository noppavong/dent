<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ClientRelDoc_model extends CI_Model {

        public $client_id;
        public $doctor;
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
             $this->db->where('client_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('client');
            $result = null;
            foreach ($q->result_array() as $row) {
                $result = $row;
                break;
            }
            return $result;
        }
        public function insert_entry()
        {
                

                $this->db->insert('client_doctor_rel', $this);
        }
}
