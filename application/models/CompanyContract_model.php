<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CompanyContract_model extends CI_Model {

        public $company_id;
        public $name;
        public $create_user;
        public $create_date;
        public $update_user;
        public $update_date;
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
             $this->db->where('company_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('company');
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
                $this->create_user = $this->ion_auth->user()->row()->id;
                $this->status = 'A';
                $this->db->insert('company_contact', $this);
                $lab_id = $this->db->insert_id();
                $this->db->trans_complete();                
                return array('id'=>$lab_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry()
        {

            $this->db->trans_start();
           
            $sql = "UPDATE company_contact SET status = ?, update_date= now() ,update_user = ? WHERE company_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$this->input->post('company_id')));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {   
            $update_obj = new stdClass();
            $this->db->trans_start();
            $update_obj->name = $this->input->post('name');  
            $update_obj->status = 'A';             
            $update_obj->update_user = $this->ion_auth->user()->row()->id;
            $update_obj->update_date = date('Y-m-d H:i:s');
            $this->db->where('company_id', $this->input->post('company_id'));
                $this->db->update('company_contact', $update_obj);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
}
