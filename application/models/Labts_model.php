<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Labts_model extends CI_Model {

       // public $trans_id;
        // public $name_eng;
        // public $surname_eng;
        public $lab;
        public $service;
        public $doctor;
        public $price;
        public $send_date;
      //  public $cellphone_no;
        public $is_received;
        public $remark;
        public $create_date;
        public $client_id;
        public $create_user;
        public $update_date;
        public $update_user;
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
             $this->db->where('trans_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('lab_transaction');
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
                $this->lab = $this->input->post('lab'); 
                $this->service = $this->input->post('service');
                $this->price = $this->input->post('price');
                $this->doctor = $this->input->post('doctor');

                $this->send_date = date('Y-m-d',strtotime($this->input->post('send_date')));
                $this->is_received = $this->input->post('is_received'); 
                $this->remark = $this->input->post('remark');
                $this->client_id = $this->input->post('client_id');
                $this->create_user = $this->ion_auth->user()->row()->id;

                 $this->db->insert('lab_transaction', $this);
                $trans_id = $this->db->insert_id();
                $this->db->trans_complete();                
                return array('id'=>$trans_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry($trans_id = "")
        {
            $this->db->trans_start();
             $this->db->delete('lab_transaction', array('trans_id' => $trans_id)); 
             $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {
               
               $this->db->trans_start();
               $update_obj = new stdClass();
                $update_obj->lab = $this->input->post('lab'); 
                $update_obj->service = $this->input->post('service');
                $update_obj->price = $this->input->post('price');
                $update_obj->doctor = $this->input->post('doctor');
                $update_obj->send_date = date('Y-m-d',strtotime($this->input->post('send_date')));
                $update_obj->is_received = $this->input->post('is_received');
                $update_obj->remark = $this->input->post('remark');
                $update_obj->client_id = $this->input->post('client_id');
                $update_obj->update_user = $this->ion_auth->user()->row()->id;
                $update_obj->update_date =  date('Y-m-d H:i:s');

                
                $this->db->where('trans_id', $this->input->post('trans_id'));
                $this->db->update('lab_transaction', $update_obj);
                $this->db->trans_complete();
                return $this->db->trans_status();
        }
}
