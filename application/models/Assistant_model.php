<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Assistant_model extends CI_Model {

        public $assistant_id;
        public $name;
        public $surname;
        public $salary;
        public $phone_no;
        public $bank;
        public $account_no;
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
             $this->db->where('assistant_id', $id);
            //here we select every clolumn of the table
            $q = $this->db->get('assistant');
            $result = null;
            foreach ($q->result_array() as $row) {
                $result = $row;
                break;
            }
            return $result;
        }
        public function get_skill($assistant_id)
        {
            $this->db->where('assistant_id', $assistant_id);
            //here we select every clolumn of the table
            $q = $this->db->get('assistant_skill_rel');
            return $q->result_array();
        }
        public function get_holiday($assistant_id)
        {
            $this->db->where('assistant_id', $assistant_id);
            //here we select every clolumn of the table
            $q = $this->db->get('assistant_holiday');
            return $q->result_array();
        }
        public function insert_entry()
        {
                $this->load->library('ion_auth');
                $this->db->trans_start();

                $this->name = $this->input->post('name'); 
                $this->surname = $this->input->post('surname');
                //$this->salary = $this->input->post('salary');
                $this->phone_no = $this->input->post('phone_no');
                $this->bank = $this->input->post('bank');
                $this->account_no = $this->input->post('account_no');
                $this->status='A';
                $this->create_user = $this->ion_auth->user()->row()->id;
                $skills = $this->input->post('skill');
                $holidays = $this->input->post('holiday');
                $this->db->insert('assistant', $this);

                $assistant_id = $this->db->insert_id();
                if(isset($skills) && !empty($skills)){
                    foreach ($skills as $value) {
                        $data = array(
                               'assistant_id' => $assistant_id ,
                               'skill_id' => intval($value) ,
                               'create_user'=> $this->ion_auth->user()->row()->id
                            );
                         $this->db->insert('assistant_skill_rel', $data);
                    }
                }
                if(isset($holidays) && !empty($holidays)){
                    foreach ($holidays as $value) {
                        $data = array(
                               'assistant_id' => $assistant_id ,
                               'holiday_id' => intval($value) ,
                               'create_user'=> $this->ion_auth->user()->row()->id
                            );
                         $this->db->insert('assistant_holiday', $data);
                    }
                }
                $this->db->trans_complete();                
                return array('id'=>$assistant_id,'status'=> $this->db->trans_status());

        }
        public function delete_entry($assistant_id = "")
        {
            $this->db->trans_start();
             $this->db->delete('assistant_skill_rel', array('assistant_id' => $assistant_id)); 
             $this->db->delete('assistant_holiday', array('assistant_id' => $assistant_id)); 
            $sql = "UPDATE assistant SET status = ?, update_date= now() ,update_user = ? WHERE assistant_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$assistant_id));
             $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {   

            $this->load->library('ion_auth');
            $this->db->trans_start();

            $updateObj = new StdClass();
            $updateObj->name = $this->input->post('name'); 
            $updateObj->surname = $this->input->post('surname');
            $updateObj->phone_no = $this->input->post('phone_no');
            $updateObj->bank = $this->input->post('bank');
            $updateObj->account_no = $this->input->post('account_no');
            $updateObj->update_user = $this->ion_auth->user()->row()->id;
            $updateObj->update_date = date('Y-m-d H:i:s');
        
            $this->db->delete('assistant_skill_rel', array('assistant_id' => $this->input->post('assistant_id') )); 
            $skills = $this->input->post('skill');
            if(isset($skills) && !empty($skills)){
                foreach ($skills as $value) {
                    $data = array(
                           'assistant_id' => $this->input->post('assistant_id') ,
                           'skill_id' => intval($value) ,
                           'create_user'=> $this->ion_auth->user()->row()->id
                        );
                     $this->db->insert('assistant_skill_rel', $data);
                }
            }
            $this->db->delete('assistant_holiday', array('assistant_id' => $this->input->post('assistant_id') )); 
            $holidays = $this->input->post('holiday');
            if(isset($holidays) && !empty($holidays)){
                   foreach ($holidays as $value) {
                    $data = array(
                     'assistant_id' => $this->input->post('assistant_id') ,
                     'holiday_id' => intval($value) ,
                     'create_user'=> $this->ion_auth->user()->row()->id
                     );
                    $this->db->insert('assistant_holiday', $data);
                }
            }
            $this->db->where('assistant_id', $this->input->post('assistant_id'));
            $this->db->update('assistant', $updateObj);
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
}
