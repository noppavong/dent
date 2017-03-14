<?php
class Doctor_model extends CI_Model {


	public $name;
	public $surname;
	public $phone_no;
	public $md_no;
	public $share_percentage;
	public $account_no;
	public $bank;
	public $create_date;
	public $create_user;
	public $update_date;
	public $update_user;

	public function get($id)
	{
		$this->db->where('doctor_id', $id);
            //here we select every clolumn of the table
		$q = $this->db->get('doctor');
		$result = null;
		foreach ($q->result_array() as $row) {
			$result = $row;
			break;
		}
		return $result;
	}
	
	public function get_skill($doctor_id)
	{
		$this->db->where('doctor_id', $doctor_id);
            //here we select every clolumn of the table
		$q = $this->db->get('doctor_skill_rel');
		return $q->result_array();
	}
	
	public function get_defaultstamp($doctor_id)
	{
            //here we select every clolumn of the table
		$q = $this->db->query("select *,TIME_FORMAT(start_time,'%h:%i') as start,TIME_FORMAT(end_time,'%h:%i') as end  from doctor_defaultstamp where doctor_id = ".$doctor_id);
		return $q->result_array();
	}
	public function do_inserttime($doctor_id)
	{
		$weekday = $this->input->post('weekday');
		if(isset($weekday))
		{
			if(in_array("0",$weekday))
			{
				$week_no = $this->input->post('sun_week_no');
				$timestart = $this->input->post('sun-start');
				$timeend = $this->input->post('sun-end'); 
				$data = array('doctor_id'=>$doctor_id,
					'weekday'=>0,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				$this->db->insert('doctor_defaultstamp',$data);
			}
			if(in_array("1",$weekday))
			{
				$week_no = $this->input->post('mon_week_no');

				$timestart = $this->input->post('mon-start');
				$timeend = $this->input->post('mon-end');
				$data = array('doctor_id'=>$doctor_id,
					'weekday'=>1,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				if(!empty($timestart)){
					$data['start_time'] = $timestart;
				}
				if(!empty($timeend)){
					$data['end_time'] = $timeend;
				}
				$this->db->insert('doctor_defaultstamp',$data);
			}
			if(in_array("2",$weekday))
			{

				$week_no = $this->input->post('tue_week_no');
				$timestart = $this->input->post('tue-start');
				$timeend = $this->input->post('tue-end');
				$data = array('doctor_id'=>$doctor_id,
					'weekday'=>2,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}

				$this->db->insert('doctor_defaultstamp',$data);
			}
			if(in_array("3",$weekday))
			{

				$week_no = $this->input->post('wed_week_no');
				$timestart = $this->input->post('wed-start');
				$timeend = $this->input->post('wed-end');
				$data = array('doctor_id'=>$doctor_id,
					'weekday'=>3,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				
				$this->db->insert('doctor_defaultstamp',$data);
			}
			if(in_array("4",$weekday))
			{

				$week_no = $this->input->post('thr_week_no');
				$timestart = $this->input->post('thr-start');
				$timeend = $this->input->post('thr-end');
					$data = array('doctor_id'=>$doctor_id,
					'weekday'=>4,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				
				$this->db->insert('doctor_defaultstamp',$data);
			}
			if(in_array("5",$weekday))
			{

				$week_no = $this->input->post('fri_week_no');
				$timestart = $this->input->post('fri-start');
				$timeend = $this->input->post('fri-end');
					$data = array('doctor_id'=>$doctor_id,
					'weekday'=>5,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				$this->db->insert('doctor_defaultstamp',$data);
			}

			if(in_array("6",$weekday))
			{

				$week_no = $this->input->post('sat_week_no');
				$timestart = $this->input->post('sat-start');
				$timeend = $this->input->post('sat-end');
					$data = array('doctor_id'=>$doctor_id,
					'weekday'=>6,
					'start_time'=>$timestart,
					'end_time'=>$timeend,
					'create_user'=> $this->ion_auth->user()->row()->id

					);
				if(isset($week_no)){
					foreach ($week_no as $value) {
						if($value == "1")
						{
							$data['is_firstw'] = 'Y'; 
						}
						if($value == "2")
						{
							$data['is_secondw'] = 'Y'; 
						}
						if($value == "3")
						{
							$data['is_thirdw'] = 'Y'; 
						}
						if($value == "4")
						{
							$data['is_fourthw'] = 'Y'; 
						}
						if($value == "5")
						{
							$data['is_fifthw'] = 'Y'; 
						}
					}
				}
				$this->db->insert('doctor_defaultstamp',$data);
			}
		}
	}
	public function insert_entry()
	{
		$this->load->library('ion_auth');
		$this->db->trans_start();
		$this->name = $this->input->post('name'); 
		$this->surname = $this->input->post('surname');
		$this->phone_no = $this->input->post('phone_no');
		$this->bank = $this->input->post('bank');
		$this->md_no = $this->input->post('md_no');
		$this->account_no = $this->input->post('account_no'); 
		$this->share_percentage = $this->input->post('share_percentage');
		$this->create_user = $this->ion_auth->user()->row()->id;
		$this->status = 'A';
		$this->db->insert('doctor', $this);
		$doctor_id = $this->db->insert_id();
		$skills = $this->input->post('skill');
		if(isset($skills)){
			foreach ($skills as $value) {
				$data = array(
					'doctor_id' => $doctor_id ,
					'skill_id' => intval($value) ,
					'create_user'=> $this->ion_auth->user()->row()->id
					);
				$this->db->insert('doctor_skill_rel', $data);
			}
		}
	
		$this->do_inserttime($doctor_id);

		$this->db->trans_complete();                
		return array('id'=>$doctor_id,'status'=> $this->db->trans_status());

	}

	public function update_entry()
	{
		$this->load->library('ion_auth');
		$update_obj =  new stdClass();
		$this->db->trans_start();
		$update_obj->name = $this->input->post('name'); 
		$update_obj->surname = $this->input->post('surname');
		$update_obj->phone_no = $this->input->post('phone_no');
		$update_obj->bank = $this->input->post('bank');
		$update_obj->md_no = $this->input->post('md_no');
		$update_obj->account_no = $this->input->post('account_no'); 
		$update_obj->share_percentage = $this->input->post('share_percentage');
		$update_obj->update_user = $this->ion_auth->user()->row()->id;
		$update_obj->update_date = date('Y-m-d H:i:s');
        $this->db->where('doctor_id', $this->input->post('doctor_id'));
        $this->db->update('doctor', $update_obj);
        $this->db->delete('doctor_skill_rel', array('doctor_id' => $this->input->post('doctor_id') )); 
		$skills = $this->input->post('skill');
		if(isset($skills)){
	        foreach ($skills as $value) {
				$data = array(
					'doctor_id' => $this->input->post('doctor_id') ,
					'skill_id' => intval($value) ,
					'create_user'=> $this->ion_auth->user()->row()->id
					);
				$this->db->insert('doctor_skill_rel', $data);
			}
		}
		$this->db->delete('doctor_defaultstamp', array('doctor_id' => $this->input->post('doctor_id') )); 
		$this->do_inserttime( $this->input->post('doctor_id'));
		$this->db->trans_complete();
        return $this->db->trans_status();
	}
	
  	public function delete_entry($doctor_id = "")
    {		
			$this->load->library('ion_auth');
    		$this->db->trans_start();
             $this->db->delete('doctor_skill_rel', array('doctor_id' => $doctor_id)); 
             $this->db->delete('doctor_defaultstamp', array('doctor_id' => $doctor_id)); 
            $sql = "UPDATE doctor SET status = ?, update_date= now() ,update_user = ? WHERE doctor_id = ? ";
            $this->db->query($sql, array( "D", $this->ion_auth->user()->row()->id,$doctor_id));
             $this->db->trans_complete();
            return $this->db->trans_status();

    }


}