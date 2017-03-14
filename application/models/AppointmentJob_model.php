<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AppointmentJob_model extends CI_Model {

        public $job_id;
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
             $this->db->where('job_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('job');
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
                $this->db->insert('appointment_job', $this);
                $job_id = $this->db->insert_id();
                $this->db->trans_complete();                
                return array('id'=>$job_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry2($job_id)
        {

            $this->db->trans_start();
            $sql = "UPDATE appointment_job SET status = ? WHERE job_id = ?";
            $this->db->query($sql, array( "D", $job_id));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function delete_entry()
        {

            $this->db->trans_start();
            $sql = "UPDATE appointment_job SET status = ? WHERE job_id = ?";
            $this->db->query($sql, array( "D", $this->input->post('job_id')));
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {   
            $this->db->trans_start();
            $update = new stdClass();
            $update->name = $this->input->post('name');  
            $update->status = 'A';             
            $this->db->where('job_id', $this->input->post('job_id'));
                $this->db->update('job', $update);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
}
