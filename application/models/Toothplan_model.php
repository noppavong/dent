<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Toothplan_model extends CI_Model {

        public $tooth_plan_id;
        public $client_id;
        public $create_user;
        public $create_date;
        public $update_user;
        public $update_date;
        public $doctor_id;
        public $plan_date;
        public $plan_choice;
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
                $plan_date = $this->input->post('plan_date'); 
                $this->plan_choice = $this->input->post('plan_choice');
                $this->doctor_id = $this->input->post('doctor_cure_id');
                $this->create_user = $this->ion_auth->user()->row()->id;
                $this->plan_date = date('Y-m-d',strtotime($plan_date));
                $this->client_id = $this->input->post('client_cure_id');
                $this->status = 'A';
                $this->db->insert('tooth_plan', $this);
                $tooth_plan_id = $this->db->insert_id();
                $method = $this->input->post('method[]');
                $tooth_side = $this->input->post('tooth_side');
                $tooth_number = $this->input->post('tooth_number');
                $is_blank = $this->input->post('is_blank');
                $is_withdraw = $this->input->post('is_withdraw');
                $is_finish = $this->input->post('is_finish');
                $dup_method = array();
                 if(!empty($method)){

                        for($i = 0 ; $i< sizeof($method); $i++) {
                        if(!in_array($method[$i],$dup_method)){
                            $data = array('method'=>$method[$i],
                                    'tooth_side'=>$tooth_side,
                                    'tooth_number'=>$tooth_number,
                                    'create_user'=>$this->ion_auth->user()->row()->id,
                                    'tooth_plan_id'=>$tooth_plan_id,
                                    'is_blank'=>$is_blank,
                                    'is_finish'=>$is_finish,
                                    'is_withdraw'=>$is_withdraw,
                                    );

                            $dup_method[] = $method[$i];
                               $this->db->insert('tooth_plan_detail',$data);
                            }


                        }

                 }else{
                     $data = array(
                            'tooth_side'=>$tooth_side,
                            'tooth_number'=>$tooth_number,
                            'create_user'=>$this->ion_auth->user()->row()->id,
                            'tooth_plan_id'=>$tooth_plan_id,
                            'is_blank'=>$is_blank,
                            'is_finish'=>$is_finish,
                            'is_withdraw'=>$is_withdraw,
                            );

                        $this->db->insert('tooth_plan_detail',$data);
                }
                $this->db->trans_complete();                

                return array('id'=>$tooth_plan_id,'status'=> $this->db->trans_status(),'form_data'=>json_encode($_POST));

        }
        public function update_entry()
        {   
                 $this->db->trans_start();
                 $update_obj = new stdClass();
                $plan_date = $this->input->post('plan_date'); 
                $update_obj->plan_choice = $this->input->post('plan_choice');
                $update_obj->doctor_id = $this->input->post('doctor_cure_id');
                $update_obj->create_user = $this->ion_auth->user()->row()->id;
                $update_obj->plan_date = date('Y-m-d',strtotime($plan_date));
                $update_obj->client_id = $this->input->post('client_cure_id');
                $update_obj->status = 'A';
                $update_obj->update_user = $this->ion_auth->user()->row()->id;
                $update_obj->update_date =  date('Y-m-d H:i:s');

                $this->db->where('tooth_plan_id', $this->input->post('tooth_plan_id'));
                $this->db->update('tooth_plan', $update_obj);


                $tooth_plan_id = $this->input->post('tooth_plan_id');

                $method = $this->input->post('method[]');
                $tooth_side = $this->input->post('tooth_side');
                $tooth_number = $this->input->post('tooth_number');
                $is_blank = $this->input->post('is_blank');
                $is_withdraw = $this->input->post('is_withdraw');
                $is_finish = $this->input->post('is_finish');

             $this->db->delete('tooth_plan_detail',array('tooth_side'=>$tooth_side,'tooth_number'=>$tooth_number,'tooth_plan_id'=>$tooth_plan_id));
               $dup_method = array();
              
                        if(!empty($method)){
                        
                                for($i = 0 ; $i< sizeof($method); $i++) {
                                      if(!in_array($method[$i],$dup_method)){
                                    $data = array('method'=>$method[$i],
                                            'tooth_side'=>$tooth_side,
                                            'tooth_number'=>$tooth_number,
                                            'create_user'=>$this->ion_auth->user()->row()->id,
                                            'tooth_plan_id'=>$tooth_plan_id,
                                            'is_blank'=>$is_blank,
                                            'is_finish'=>$is_finish,
                                            'is_withdraw'=>$is_withdraw,
                                            );
                                         $dup_method[] = $method[$i];
                                        $this->db->insert('tooth_plan_detail',$data);

                                }
                            }


                         }else{
                             $data = array(
                                    'tooth_side'=>$tooth_side,
                                    'tooth_number'=>$tooth_number,
                                    'create_user'=>$this->ion_auth->user()->row()->id,
                                    'tooth_plan_id'=>$tooth_plan_id,
                                    'is_blank'=>$is_blank,
                                    'is_finish'=>$is_finish,
                                    'is_withdraw'=>$is_withdraw,
                                    );

                                $this->db->insert('tooth_plan_detail',$data);
                        }

                $this->db->trans_complete();                

                return array('id'=>$tooth_plan_id,'status'=> $this->db->trans_status(),'form_data'=>json_encode($_POST));
        }
}
