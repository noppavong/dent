<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Client_model extends CI_Model {

        public $name_thai;
        public $surname_thai;
        // public $name_eng;
        // public $surname_eng;
        public $nickname;
        public $sex;
        public $marital_id;
        public $birth_date;
        public $phone_no;
      //  public $cellphone_no;
        public $email;
        public $medication;
        public $allergic;
        public $idcard;
        public $address;
      //  public $province;
      //  public $amphur;
      //  public $postal_code;
       // public $height;
       // public $weight;
       // public $blood;
       // public $pregnant;
        public $occupation;
        public $age;
       // public $problem;
        public $create_date;
        public $title;
        public $social;
        public $medcert;
        public $otherdoc;
        //public $doctor;
        public $status;
        public $other;
        public $work_address;
        public $discount_per;
        public $employee_no;
        public $company;
        
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
                $this->db->trans_start();
                $this->name_thai = $this->input->post('name_thai'); 
                $this->surname_thai = $this->input->post('surname_thai');
                // $this->name_eng = $this->input->post('name_eng');
                // $this->surname_eng = $this->input->post('surname_eng');
                $this->nickname = $this->input->post('nickname');
                $this->sex = $this->input->post('sex');
                $this->marital_id = $this->input->post('marital_status');
                $this->birth_date = date('Y-m-d',strtotime(date('Y-m-d',strtotime($this->input->post('birth_date'))).' -543 years'));
                $this->phone_no = $this->input->post('phone_no');
                $this->email = $this->input->post('email');
                $this->medication = $this->input->post('medication');
                $this->allergic = $this->input->post('allergic');
                $this->idcard = $this->input->post('idcard');
                $this->address = $this->input->post('address');
                // $this->province = $this->input->post('province');
                // $this->amphur = $this->input->post('district');
                // $this->postal_code = $this->input->post('postal_code');
                // $this->height = $this->input->post('height');
                // $this->weight = $this->input->post('weight');
                // $this->blood = $this->input->post('bloodgroup');
                $this->occupation = $this->input->post('occupation');
                //$this->pregnant = $this->input->post('pregnant');
                $this->title = $this->input->post('title');
                $this->medcert = $this->input->post('medcert');
                $this->social = $this->input->post('social');
                $this->otherdoc = $this->input->post('otherdoc');
                //$this->doctor = $this->input->post('doctor');
                $this->status = $this->input->post('status');
                $this->other = $this->input->post('other');
                $this->work_address = $this->input->post('work_address');
                $this->age = $this->input->post('age');
                $this->discount_per = $this->input->post('discount_per');
                $this->employee_no = $this->input->post('employee_no');
                $this->company = $this->input->post('company');
                $this->create_user = $this->ion_auth->user()->row()->id;

                 $this->db->insert('client', $this);
                $client_id = $this->db->insert_id();

                $doctor_id = $this->input->post('doctor');
                foreach ($doctor_id as $value) {
                    $data = array(
                           'client_id' => $client_id ,
                           'doctor_id' => intval($value) ,
                           'create_user' => $this->ion_auth->user()->row()->id
                        );
                     $this->db->insert('client_doctor_rel', $data);
                }
                
               $this->db->trans_complete();                
                return array('id'=>$client_id,'status'=>$this->db->trans_status());

        }
        public function delete_entry($client_id = "")
        {
            $this->db->trans_start();

             $this->db->delete('client_doctor_rel', array('client_id' => $client_id)); 
             $this->db->delete('client', array('client_id' => $client_id)); 
             $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function delete_array_entry($array_id)
        {    
             $this->db->trans_start();
             $this->db->where_in('client_id', $array_id);
             $this->db->delete('lab_transaction');
             $this->db->where_in('client_id', $array_id);
             $this->db->delete('client_doctor_rel');
             $this->db->where_in('client_id', $array_id);
             $this->db->delete('client');
            $this->db->trans_complete();
            return $this->db->trans_status();
        }
        public function update_entry()
        {
               
               $this->db->trans_start();
               $update = new stdClass();
                $update->name_thai = $this->input->post('name_thai'); 
                $update->surname_thai = $this->input->post('surname_thai');
                // $this->name_eng = $this->input->post('name_eng');
                // $this->surname_eng = $this->input->post('surname_eng');
                $update->nickname = $this->input->post('nickname');

                $update->sex = $this->input->post('sex');
                $update->marital_id = $this->input->post('marital_status');
                $update->birth_date = date('Y-m-d',strtotime($this->input->post('birth_date')));
                $update->phone_no = $this->input->post('phone_no');
                $update->email = $this->input->post('email');
                $update->medication = $this->input->post('medication');
                $update->allergic = $this->input->post('allergic');
                $update->idcard = $this->input->post('idcard');
                $update->address = $this->input->post('address');
                $update->age = $this->input->post('age');
                // $this->province = $this->input->post('province');
                // $this->amphur = $this->input->post('district');
                // $this->postal_code = $this->input->post('postal_code');
                // $this->height = $this->input->post('height');
                // $this->weight = $this->input->post('weight');
                // $this->blood = $this->input->post('bloodgroup');
                $update->occupation = $this->input->post('occupation');
               // $this->pregnant = $this->input->post('pregnant');
                $update->title = $this->input->post('title');
                $update->medcert = $this->input->post('medcert');
                $update->social = $this->input->post('social');
                $update->otherdoc = $this->input->post('otherdoc');
               /// $this->doctor = $this->input->post('doctor');
                $update->status = $this->input->post('status');
                $update->other = $this->input->post('other');
                $update->work_address = $this->input->post('work_address');
                $update->discount_per = $this->input->post('discount_per');
                $update->employee_no = $this->input->post('employee_no');
                $update->company = $this->input->post('company');
                $update->update_user = $this->ion_auth->user()->row()->id;
                $update->update_date = date('Y-m-d H:i:s');

                $this->db->delete('client_doctor_rel', array('client_id' => $this->input->post('client_id') )); 
                $doctor_id = $this->input->post('doctor');
                if(isset($doctor_id)){
                    foreach ($doctor_id as $value) {
                        $data = array(
                               'client_id' => $this->input->post('client_id') ,
                               'doctor_id' => intval($value) ,

                            'create_user' => $this->ion_auth->user()->row()->id
                            );
                         $this->db->insert('client_doctor_rel', $data);
                    }
                }
                $this->db->where('client_id', $this->input->post('client_id'));
                $this->db->update('client', $update);
                $this->db->trans_complete();
                return $this->db->trans_status();
        }
}
