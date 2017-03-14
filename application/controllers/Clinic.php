<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clinic extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$content = array();
		$this->template->load('template', 'clinic/home', $content);
		
	}
	function daycount($day, $startdate,$enddate, $counter)
	{

	    if($startdate >= $enddate)
	    {
	        return $counter;
	    }
	    else
	    {
	        return $this->daycount($day, strtotime("next ".$day, $startdate),$enddate, ++$counter);
	    }
	}

	public function check_overlap($starttime1,$endtime1,$starttime2,$endtime2)
	{
		//		let ConditionA Mean that DateRange A Completely After DateRange B
		// _                        |---- DateRange A ------| 
		// |---Date Range B -----|                           _
		// (True if StartA > EndB)

		// Let ConditionB Mean that DateRange A is Completely Before DateRange B
		// |---- DateRange A -----|                       _ 
		//  _                          |---Date Range B ----|
		// (True if EndA < StartB)
		//Then Overlap exists if Neither A Nor B is true -
			$d1 =  DateTime::createFromFormat('H:i',$starttime1);
			$ed1 = DateTime::createFromFormat('H:i',$endtime1);
			$d2 = DateTime::createFromFormat('H:i',$starttime2);
			$ed2 = DateTime::createFromFormat('H:i',$endtime2);
			$true1 = $d1 > $ed2;
			$true2 = $ed1 < $d2;
			return !$true1 and !$true2;

	}
	function check_in_range($start_date, $end_date, $date_from_user)
	{
	  // Convert to timestamp
	  $start_ts = strtotime($start_date);
	  $end_ts = strtotime($end_date);
	  $user_ts = strtotime($date_from_user);

	  // Check that user date is between start & end
	  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
	}
	public function get_next_calendar($mode)
	{
		$start = $this->input->get('start');
		$end = $this->input->get('end');
		$start_datestr = date('Y-m-d',$start);
		$end_datestr = date('Y-m-d',$end);
		$start_datex = new DateTime($start_datestr);
		$end_datex =  new DateTime($end_datestr);
		$map_skill_d = array();
		$map_skill_a = array();
		$query_skill_doctor = $this->db->query('select * from doctor_skill_rel  dr inner join doctor_skill  ds on ds.skill_id= dr.skill_id where dr.create_user = '.$this->ion_auth->user()->row()->id.' and ds.status="A"');

		$query_skill_assistant = $this->db->query('select * from assistant_skill_rel asr inner join assistant_skill ass on asr.skill_id = ass.skill_id where asr.create_user = '.$this->ion_auth->user()->row()->id.' and ass.status="A"');
		foreach ($query_skill_doctor->result_array() as $row) {
			$map_skill_d[$row['doctor_id']] = $row['skill_id'];
		}
		foreach ($query_skill_assistant->result_array() as $row) {
			$map_skill_a[$row['assistant_id']] = $row['skill_id'];
		}

		$weekday_doctor = array();
		$weekday_doctor[0] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =0 and d.status='A' and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[1] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =1 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[2] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =2 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[3] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =3 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[4] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =4 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[5] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =5 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_doctor[6] = $this->db->query("SELECT * FROM doctor_defaultstamp st inner join doctor d on d.doctor_id = st.doctor_id where weekday =6 and d.status='A'  and st.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();

		$weekday_assistant = array();
		$weekday_assistant[0] = $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 1) and a.status='A'  and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[1] =$this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 2) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[2] = $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 3) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[3] = $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 4) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[4] = $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 5) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[5]= $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 6) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();
		$weekday_assistant[6] = $this->db->query("SELECT * FROM assistant a  where assistant_id not in (select assistant_id from assistant_holiday ah  where ah.holiday_id = 7) and a.status='A' and a.create_user ='".$this->ion_auth->user()->row()->id."'")->result_array();


		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($start_datex, $interval, $end_datex);
		$current_month =0;

		foreach ( $period as $dt ){
			$date = $dt->format( "Y-m-d");
			$firstDayOfMonth = date('Y-m-01',strtotime($date));
			$lastDayOfMonth = date("Y-m-t", strtotime($date));


			$hasfirstday = $this->check_in_range($start_datestr, $end_datestr, $firstDayOfMonth);
			$haslastday = $this->check_in_range($start_datestr, $end_datestr, $lastDayOfMonth);
			if($hasfirstday && $haslastday)
			{
				$current_month =  date('m',strtotime($date));
				break;
			}

		}
		foreach ( $period as $dt ){
			$event = array();
			$hasDoctor = false;
			$date = $dt->format( "Y-m-d");
			$dayofWeek = date( "w", strtotime($date));
			$dayofWeekStr = strtolower(date( "l", strtotime($date)));
			$firstDayOfMonth = date('Y-m-01',strtotime($date));
			$dayofWeekoffdom = date( "w", strtotime($firstDayOfMonth));
			$month =  date( "m", strtotime($date));
			$weekNum = -1;
			if($month != $current_month)
			{
				continue;
			}
			if($dayofWeekoffdom == $dayofWeek){
				$weekNum = $this->daycount($dayofWeekStr,strtotime($firstDayOfMonth), strtotime($date), 0)+1;
			}else{
				$weekNum = $this->daycount($dayofWeekStr,strtotime($firstDayOfMonth), strtotime($date), 0);
			}
			$doctor = $weekday_doctor[$dayofWeek];
			$assistant = $weekday_assistant[$dayofWeek];
			$doctor_special_in = $this->db->query('select * from schedule s left join doctor d on d.doctor_id = s.doctor_id where start_date = "'.$date.'" and s.doctor_id is not null and s.doctor_id not in (select doctor_id from absent where absent_date =   "'.$date.'") 
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A" ;')->result_array();
			$assistant_special_in = $this->db->query('select * from schedule  s left join assistant a on a.assistant_id = s.assistant_id where start_date = "'.$date.'" and a.assistant_id is not null and s.assistant_id not in (select assistant_id from absent where absent_date =   "'.$date.'")
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A" ;')->result_array();
			$leave_doctor  = $this->db->query('select doctor_id from absent s where absent_date =   "'.$date.'"
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A" and doctor_id is not null ;')->result_array();
			$leave_assistant = $this->db->query('select assistant_id from absent s where absent_date =   "'.$date.'"
				 and s.create_user ='.$this->ion_auth->user()->row()->id.' and s.status="A"  and assistant_id is not null;')->result_array();
			$leave_doctor_id = array();
			$leave_assistant_id = array();

			foreach ($leave_doctor as $row) {
				$leave_doctor_id[] = $row['doctor_id'];
 			}
 			foreach ($leave_assistant as $row) {
				$leave_assistant_id[] = $row['assistant_id'];
 			}
 			if($mode == 0 || $mode == 1)
 			{
				foreach($doctor as $row)
				{
					$match = false;
					// echo $date.'|';
					// echo $weekNum.'|';
					switch ($weekNum) {
						case 1:
							if($row['is_firstw'] == 'Y'){

								$match = true;
							}
							break;
						case 2:
							if($row['is_secondw'] == 'Y'){
								
								$match = true;
							}
							break;
						case 3:
							if($row['is_thirdw'] == 'Y'){
								
								$match = true;
							}
							break;
						case 4:
							if($row['is_fourthw'] == 'Y'){
								
								$match = true;
							}
							break;
						case 5:
							if($row['is_fifthw'] == 'Y'){
								
								$match = true;
							}
							break;
					}
					if(in_array($row['doctor_id'], $leave_doctor_id)){

						$event= array();
						$event['id'] = 'doctor-leave-'.$row['doctor_id'];
						$event['title'] = $row['name'].' '.$row['surname'];
						$event['allDay'] = true;

						$startdate = date('c',strtotime($date));
						$event['start']  = $startdate;
						$event['backgroundColor'] = '#b052a8';
						$event['borderColor']= '#b052a8';
						$events[] = $event;
						 $match=false;	
					}
					if($match){
						$event= array();
						$event['id'] = 'doctor-'.$row['doctor_id'];
						$event['title'] = $row['name'].' '.$row['surname'];
						
						if(!empty($row['start_time']))
						{
							$startdate  = $date.' '.$row['start_time'];
							$startdate = date('c',strtotime($startdate));
							$event['start']  = $startdate;
							if(!empty($row['end_time']))
							{
								$enddate  =  $date.' '.$row['end_time'];
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}else{
								$enddate  =  $date.'  23:59:59';
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}
						}else{
							$event['allDay'] = true;
						}
						if(isset($map_skill_d[$row['doctor_id']])){


							$event['backgroundColor'] = '#f39c12';
							$event['borderColor']= '#f39c12';
						}else{		

							$event['backgroundColor'] = '#00c0ef';
							$event['borderColor']= '#00c0ef';
						}
						$events[] = $event;
					}

				}
				foreach($doctor_special_in as $row)
				{
						$event = array();
						$event['id'] = 'spd-'.$row['doctor_id'];
						$event['title'] = $row['name'].' '.$row['surname'];
						
						if(!empty($row['start_time']))
						{
							$startdate  = $date.' '.$row['start_time'];
							$startdate = date('c',strtotime($startdate));
							$event['start']  = $startdate;
							if(!empty($row['end_time']))
							{
								$enddate  =  $date.' '.$row['end_time'];
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}else{
								$enddate  =  $date.'  23:59:59';
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}
						}else{
							$event['allDay'] = true;
						}


						$event['backgroundColor'] = '#dd4b39';
						$event['borderColor']= '#dd4b39';
						$events[] = $event;

				}
			}
			if($mode == 0 || $mode == 2)
 			{
				foreach($assistant as $row)
				{
					$match = true;
					if(in_array($row['assistant_id'], $leave_assistant_id)) $match=false;
					if($match){
						$event = array();
						$event['id'] = 'assistant-'.$row['assistant_id'];
						$event['title'] = $row['name'].' '.$row['surname'];
						$event['start'] = $date.' 06:00:00';	
						$event['end'] = $date.'  23:59:59';
						$event['allDay'] = true;
						if(isset($map_skill_a[$row['assistant_id']])){

							$event['backgroundColor'] = '#00a65a';
							$event['borderColor']= '#00a65a';

						}else{
							$event['backgroundColor'] = '#CCCCCC';
							$event['borderColor']= '#CCCCCC';
						}
						$events[] = $event;
					}

				}
				foreach($assistant_special_in as $row)
				{
						$event = array();
						$event['id'] = 'spa-'.$row['assistant_id'];
						$event['title'] = $row['name'].' '.$row['surname'];
						
						if(!empty($row['start_time']))
						{
							$startdate  = $date.' '.$row['start_time'];
							$startdate = date('c',strtotime($startdate));
							$event['start']  = $startdate;
							if(!empty($row['end_time']))
							{
								$enddate  =  $date.' '.$row['end_time'];
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}else{
								$enddate  =  $date.'  23:59:59';
								$enddate = date('c',strtotime($enddate));
								$event['end']  = $enddate;
							}
						}else{
							$event['allDay'] = true;
						}


						$event['backgroundColor'] = '#dd4b39';
						$event['borderColor']= '#dd4b39';
						$events[] = $event;

				}
			}
 
		}

		header('Content-Type: application/json');
		echo json_encode($events);
	}
	public function doctor()
	{
		$content = array();
		$this->load->library('ion_auth');
		$query_s= $this->db->query("SELECT * FROM doctor_skill where status='A' and create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_b= $this->db->query("SELECT * FROM bank;"); 
		$query_h = $this->db->query("SELECT * FROM holiday");
		$mapday  = array();
		$mapskill = array();
		$mapbank = array();
		foreach ($query_h->result_array() as $row) {
			$mapday[$row['holiday_id']]=  $row['name'];
		}
		foreach ($query_s->result_array() as $row) {
			$mapskill[$row['skill_id']]=  $row['name'];
		}
		foreach ($query_b->result_array() as $row) {
			$mapbank[$row['bank_id']]=  $row['name'];
		}

		$content['banks'] = $query_b;
		$content['skills'] = $query_s;
		$content['mapday'] = $mapday;
		$content['mapbank'] = json_encode($mapbank);

		$content['mapskill'] = json_encode($mapskill);
	
		foreach ($query_s->result_array() as $row) {
			$skilllist [$row['skill_id']] = $row['name'];
		}
		$content['skills'] = $skilllist;
		$this->template->load('template', 'clinic/doctor', $content);
	}
	public function inout()
	{
		$content = array();
		$this->load->library('ion_auth');
		$query_doctors = $this->db->query("SELECT * FROM doctor where status='A' and  create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_assistant = $this->db->query("SELECT * FROM assistant where status='A' and  create_user = '".$this->ion_auth->user()->row()->id."';");
		$content['doctors'] = $query_doctors;
		$content['assistants'] = $query_assistant;
		$this->template->load('template', 'clinic/inout', $content);
	}
	public function in()
	{
		$this->load->library('ion_auth');
		$query_in = $this->db->query('select id,type,d.name as dname, d.surname as dsurname,a.name as aname,a.surname as asurname,d.phone_no as dphone , a.phone_no as aphone,s.doctor_id,s.assistant_id,start_date from  schedule s left join doctor d on d.doctor_id = s.doctor_id 
			left join assistant a on a.assistant_id = s.assistant_id
			 where s.status = "A"  and s.create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$struct = array();
		foreach ($query_in->result_array() as $row) {
			if($row['type'] == 1){
				$query = $this->db->query('select * from doctor_skill ds inner join doctor_skill_rel dsr on ds.skill_id = dsr.skill_id where dsr.doctor_id = '.$row['doctor_id']); 
				$str_skill = array();
				foreach ($query->result_array() as $row2) {
					$str_skill []= $row2['name'];
				}
				$struct[] = array($row['id'],$row['dname'].' '.$row['dsurname'],$row['dphone'],($row['type'] == 1)?'ทันตแพทย์':'ผู้ช่วย'
					,$row['start_date'],implode(',',$str_skill));
			}else{
				$query = $this->db->query('select * from assistant_skill ass inner join assistant_skill_rel asr on ass.skill_id = asr.skill_id where asr.assistant_id = '.$row['assistant_id']); 
				$str_skill = array();
				foreach ($query->result_array() as $row2) {
					$str_skill []= $row2['name'];
				}
				$struct[] = array($row['id'],$row['aname'].' '.$row['asurname'],$row['aphone'],($row['type'] == 1)?'ทันตแพทย์':'ผู้ช่วย'
					,$row['start_date'],implode(',',$str_skill));
			}
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}
	public function out()
	{
		$this->load->library('ion_auth');
		$query_in = $this->db->query('select id,type,d.name as dname, d.surname as dsurname,a.name as aname,a.surname as asurname,d.phone_no as dphone , a.phone_no as aphone,s.doctor_id,s.assistant_id,absent_date from  absent s left join doctor d on d.doctor_id = s.doctor_id 
			left join assistant a on a.assistant_id = s.assistant_id
			 where s.status = "A"  and s.create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$struct = array();
		foreach ($query_in->result_array() as $row) {
			if($row['type'] == 1){
				$query = $this->db->query('select * from doctor_skill ds inner join doctor_skill_rel dsr on ds.skill_id = dsr.skill_id where dsr.doctor_id = '.$row['doctor_id']); 
				$str_skill = array();
				foreach ($query->result_array() as $row2) {
					$str_skill []= $row2['name'];
				}
				$struct[] = array($row['id'],$row['dname'].' '.$row['dsurname'],$row['dphone'],($row['type'] == 1)?'ทันตแพทย์':'ผู้ช่วย'
					,$row['absent_date'],implode(',',$str_skill));
			}else{
				$query = $this->db->query('select * from assistant_skill ass inner join assistant_skill_rel asr on ass.skill_id = asr.skill_id where asr.assistant_id = '.$row['assistant_id']); 
				$str_skill = array();
				foreach ($query->result_array() as $row2) {
					$str_skill []= $row2['name'];
				}
				$struct[] = array($row['id'],$row['aname'].' '.$row['asurname'],$row['aphone'],($row['type'] == 1)?'ทันตแพทย์':'ผู้ช่วย'
					,$row['absent_date'],implode(',',$str_skill));
			}
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);
	}
	public function assistant()
	{
		$content = array();
		$this->load->library('ion_auth');
		$query_s= $this->db->query("SELECT * FROM assistant_skill where status='A' and create_user = '".$this->ion_auth->user()->row()->id."';");
		$query_b= $this->db->query("SELECT * FROM bank;");
		$query_h= $this->db->query("SELECT * FROM holiday");

		$content['banks'] = $query_b;
		$content['skills'] = $query_s;
		$content['holidays'] = $query_h;
		$content['assistant_skills'] = array();
		$skills = array();
		$skilllist = array();

		foreach ($query_s->result_array() as $row) {
			$skilllist [$row['skill_id']] = $row['name'];
		}
		$content['skills'] = $skilllist;
		foreach ($query_h->result_array() as $row) {
			$holidaylist [$row['holiday_id']] = $row['name'];
		}

		$content['holidays'] = $holidaylist;
		$this->template->load('template', 'clinic/assistant', $content);
	}
	
	public function listdoctor()
	{
		$this->load->library('ion_auth');
		$query_doctors = $this->db->query('select * from  doctor where status = "A" and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$struct = array();

		foreach ($query_doctors->result_array() as $row) {
			$query = $this->db->query('select * from doctor_skill ds inner join doctor_skill_rel dsr on ds.skill_id = dsr.skill_id where dsr.doctor_id = '.$row['doctor_id']); 
			$str_skill = array();
			foreach ($query->result_array() as $row2) {
				$str_skill []= $row2['name'];
			}
			$struct[] = array($row['doctor_id'],$row['name'].' '.$row['surname'],$row['phone_no'],implode(',',$str_skill));
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function listassistant()
	{
		$this->load->library('ion_auth');
		$query_doctors = $this->db->query('select * from  assistant where status = "A" and create_user =  "'.$this->ion_auth->user()->row()->id.'"; ');
		$struct = array();
		foreach ($query_doctors->result_array() as $row) {
			$query = $this->db->query('select * from assistant_skill ass inner join assistant_skill_rel asr on ass.skill_id = asr.skill_id where asr.assistant_id = '.$row['assistant_id']); 
				$str_skill = array();
				foreach ($query->result_array() as $row2) {
					$str_skill []= $row2['name'];
				}
			$struct[] = array($row['assistant_id'],$row['name'].' '.$row['surname'],$row['phone_no'],implode(',',$str_skill));
		}
		$content = array();
		$content['data'] = $struct;
		header('Content-Type: application/json');
		echo json_encode($content);

	}
	public function get_doctor($doctor_id)
	{
		$this->load->model('doctor_model');
		$result = array();
		$doctor = $this->doctor_model->get($doctor_id);
		$result['doctor'] =$doctor;
		$result['doctor_skill'] = $this->doctor_model->get_skill($doctor_id);
		$result['doctor_time'] = $this->doctor_model->get_defaultstamp($doctor_id);
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function get_assistant($assistant_id)
	{
		$this->load->model('assistant_model');
		$result = array();
		$assistant = $this->assistant_model->get($assistant_id);
		$result['assistant'] =$assistant;
		$result['assistant_skill'] = $this->assistant_model->get_skill($assistant_id);
		$result['assistant_holiday'] = $this->assistant_model->get_holiday($assistant_id);
		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function get_schedule($schedule_id)
	{

		$this->load->model('schedule_model');
		$result = array();
		$schedule = $this->schedule_model->get($schedule_id);
		$schedule['start_date'] = date('d-m-Y',strtotime($schedule['start_date']));
		$result['schedule'] =$schedule;

		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function get_absent($absent_id)
	{

		$this->load->model('absent_model');
		$result = array();
		$absent = $this->absent_model->get($absent_id);
		$absent['absent_date'] = date('d-m-Y',strtotime($absent['absent_date']));
		$result['absent'] =$absent;

		header('Content-Type: application/json');
		echo json_encode($result);
	}
	public function saveschedule()
	{
		$this->schedule_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$id = $this->input->post('id');
        	if(!empty($id))
        	{
				$this->load->model("schedule_model");
        		$result = $this->schedule_model->update_entry();
        	}else{
				$this->load->model("schedule_model");
				$this->schedule_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function saveabsent()
	{
		$this->absent_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$id = $this->input->post('id');
        	if(!empty($id))
        	{
				$this->load->model("absent_model");
        		$result = $this->absent_model->update_entry();
        	}else{
				$this->load->model("absent_model");
				$this->absent_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function savedoctor()
	{
		$this->doctor_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$doctor_id = $this->input->post('doctor_id');
        	if(!empty($doctor_id))
        	{
				$this->load->model("doctor_model");
        		$result = $this->doctor_model->update_entry();
        	}else{
				$this->load->model("doctor_model");
				$this->doctor_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function saveassistant()
	{
		$this->assistant_validation();
		if ($this->form_validation->run() == FALSE){
                
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'0','message'=>validation_errors()));
        }else{
        	$assistant_id = $this->input->post('assistant_id');
        	if(!empty($assistant_id))
        	{
				$this->load->model("assistant_model");
        		$result = $this->assistant_model->update_entry();
        	}else{
				$this->load->model("assistant_model");
				$this->assistant_model->insert_entry();
			}
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'1'));
        }
	}
	public function delete_doctor($id)
	{
		$this->load->model('doctor_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->doctor_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_assistant($id)
	{
		$this->load->model('assistant_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->assistant_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_schedule($id)
	{
		$this->load->model('schedule_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->schedule_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function delete_absent($id)
	{
		$this->load->model('absent_model');
		if(empty($id))
		{
			header('Content-Type: application/json');
			echo json_encode(array('status'=>'ไม่สามารถลบได้'));
		}else{
			$result = $this->absent_model->delete_entry($id);
			header('Content-Type: application:json');
			echo json_encode($result);
		}
	}
	public function doctor_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
		$this->form_validation->set_rules('phone_no', 'เบอร์ติดต่อ', 'required');
		$this->form_validation->set_rules('weekday[]', 'วันเข้าทำการ', 'required');
		$weekday = $this->input->post('weekday');
		if(isset($weekday))
		{
			if(in_array("0",$weekday))
			{
				$this->form_validation->set_rules('sun_week_no[]', 'อาทิตย์สัปดาห์ที่', 'required');
				$this->form_validation->set_rules('sun-start', 'อาทิตย์เวลาเริ่ม', 'required');
				$this->form_validation->set_rules('sun-end', 'อาทิตย์เวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('sun-end', 'อาทิตย์เวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('sun-start').']');
				
			}
			if(in_array("1",$weekday))
			{$this->form_validation->set_rules('mon_week_no[]', 'จันทร์สัปดาห์ที่', 'required');
				$this->form_validation->set_rules('mon-start', 'จันทร์เวลาเริ่ม', 'required');
				$this->form_validation->set_rules('mon-end', 'จันทร์เวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('mon-end', 'จันทร์เวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('mon-start').']');
				

			}
			if(in_array("2",$weekday))
			{

				$this->form_validation->set_rules('tue_week_no[]', 'อังคารสัปดาห์ที่', 'required');
				$this->form_validation->set_rules('tue-start', 'อังคารเวลาเริ่ม', 'required');
				$this->form_validation->set_rules('tue-end', 'อังคารเวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('tue-end', 'อังคารเวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('tue-start').']');
			
			}
			if(in_array("3",$weekday))
			{

				$this->form_validation->set_rules('wed_week_no[]', 'พุธสัปดาห์ที่', 'required');
				$this->form_validation->set_rules('wed-start', 'พุธเวลาเริ่ม', 'required');
				$this->form_validation->set_rules('wed-end', 'พุธเวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('wed-end', 'พุธเวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('wed-start').']');
				
			}
			if(in_array("4",$weekday))
			{

				$this->form_validation->set_rules('thr_week_no[]', 'พฤหัสสัปดาห์ที่', 'required');
				$this->form_validation->set_rules('thr-start', 'พฤหัสเวลาเริ่ม', 'required');
				$this->form_validation->set_rules('thr-end', 'พฤหัสเวลาสิ้นสุด', 'required|callback_check_equal_less['.$this->input->post('thr-start').']');
				
			}
			if(in_array("5",$weekday))
			{

				$this->form_validation->set_rules('fri_week_no[]', 'ศุกร์สัปดาห์ที่', 'required');
				$this->form_validation->set_rules('fri-start', 'ศุกร์เวลาเริ่ม', 'required');
				$this->form_validation->set_rules('fri-end', 'ศุกร์เวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('fri-end', 'ศุกร์เวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('fri-start').']');
				
			}
			if(in_array("6",$weekday))
			{

				$this->form_validation->set_rules('sat_week_no[]', 'เสาร์สัปดาห์ที่', 'required');
				$this->form_validation->set_rules('sat-start', 'เสาร์เวลาเริ่ม', 'required');
				$this->form_validation->set_rules('sat-end', 'เสาร์เวลาสิ้นสุด', 'required');
				$this->form_validation->set_rules('sat-end', 'เสาร์เวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('sat-start').']');
				
			}
		}

	}
	public function assistant_validation(){
		$this->form_validation->set_rules('name', 'ชื่อ', 'required');
		$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
		$this->form_validation->set_rules('phone_no', 'เบอร์ติดต่อ', 'required');
	}
	public function schedule_validation(){
		$this->form_validation->set_rules('start_date', 'วันที่เข้า', 'required');
		$this->form_validation->set_rules('start_time', 'เวลาที่เข้า', 'required');
		$this->form_validation->set_rules('end_time', 'เวลาที่ออก', 'required');
		$this->form_validation->set_rules('end_time', 'เวลาสิ้นสุด', 'callback_check_equal_less['.$this->input->post('start_time').']');
		$type= $this->input->post("type");
		if($type == 1){
			$this->form_validation->set_rules('doctor_id', 'ทันตแพทย์', 'required');
			$this->form_validation->set_rules('start_date', 'วันเพิ่ม', 'callback_check_indoctor_date['.$this->input->post('doctor_id').']');
		}else{
			$this->form_validation->set_rules('assistant_id', 'ผู้ช่วย', 'required');
			$this->form_validation->set_rules('start_date', 'วันเพิ่ม', 'callback_check_inassistant_date['.$this->input->post('assistant_id').']');
		}
	}
	public function absent_validation(){
		$this->form_validation->set_rules('absent_date', 'วันที่ลา', 'required');
	}
	public function check_equal_less($second_field,$first_field)
	  {

	    	if(!empty($second_field) && strtotime($second_field) <= strtotime($first_field))
	      {
	        $this->form_validation->set_message('check_equal_less','{field} ต้องมากกว่าเวลาเริ่ม');
	        return false;       
	      }
	      else
	      {
	        return true;
	      }
	  }
	public function check_indoctor_date($date_field,$doctor_id_field)
	{
		$dayofWeek = date('w',strtotime($date_field));
		$doctor_defaultstamp = $this->db->query('select * from doctor_defaultstamp where doctor_id = '.$doctor_id_field.' and create_user = '.$this->ion_auth->user()->row()->id);
		$in_doctor =$this->db->query('select * from schedule where doctor_id = '.$doctor_id_field.' and status="A" and start_date = "'.date('Y-m-d',strtotime($date_field)).'" and create_user = '.$this->ion_auth->user()->row()->id);
		if(sizeof($in_doctor->result_array()) > 0 ){
			  $this->form_validation->set_message('check_indoctor_date','ไม่สามารถลง {field} ได้เนื่องจากลงเป็นวันเข้าอยู่แล้ว');
	        return false;   
		}
		$foundErr = false;
		$firstDayOfMonth = date('Y-m-01',strtotime($date_field));
		$dayofWeekStr = strtolower(date( "l", strtotime($date_field)));
		$dayofWeekoffdom = date( "w", strtotime($firstDayOfMonth));
		$month =  date( "m", strtotime($date_field));
		$weekNum = -1;
		if($dayofWeekoffdom == $dayofWeek){
			$weekNum = $this->daycount($dayofWeekStr,strtotime($firstDayOfMonth), strtotime($date_field), 0)+1;
		}else{
			$weekNum = $this->daycount($dayofWeekStr,strtotime($firstDayOfMonth), strtotime($date_field), 0);
		}

		foreach ($doctor_defaultstamp->result_array() as $row) {
			if($row['weekday'] == $dayofWeek){
				switch ($weekNum) {
					case 1:
						if($row['is_firstw'] == 'Y'){

							$foundErr = true;
						}
						break;
					case 2:
						if($row['is_secondw'] == 'Y'){
							
							$foundErr = true;
						}
						break;
					case 3:
						if($row['is_thirdw'] == 'Y'){
							
							$foundErr = true;
						}
						break;
					case 4:
						if($row['is_fourthw'] == 'Y'){
							
							$foundErr = true;
						}
						break;
					case 5:
						if($row['is_fifthw'] == 'Y'){
							
							$foundErr = true;
						}
						break;
				}
				break;
			}
		}
		if($foundErr){
			  $this->form_validation->set_message('check_indoctor_date','ไม่สามารถลง {field} ได้เนื่องจากลงเป็นวันเข้าอยู่แล้ว');
	        return false;   
		}else{
			return true;
		}
		
	}
	public function check_inassistant_date($date_field,$assist_id_field)
	{
		$dayofWeek = date('w',strtotime($date_field));
		$assistant_holiday = $this->db->query('select * from assistant_holiday where assistant_id = '.$assist_id_field.'  and create_user = '.$this->ion_auth->user()->row()->id);
		$in_assistant =$this->db->query('select * from schedule where assistant_id = '.$assist_id_field.' and status="A" and start_date = "'.date('Y-m-d',strtotime($date_field)).'" and create_user = '.$this->ion_auth->user()->row()->id);
		if(sizeof($in_assistant->result_array()) > 0 ){
			  $this->form_validation->set_message('check_inassistant_date','ไม่สามารถลง {field} ได้เนื่องจากลงเป็นวันเข้าอยู่แล้ว');
	        return false;   
		}
		if(sizeof($assistant_holiday->result_array())==0)
		{
			$this->form_validation->set_message('check_inassistant_date','ไม่สามารถลง {field} ได้เนื่องจากลงเป็นวันเข้าอยู่แล้ว');
	        return false; 
		}
		if($dayofWeek != $assistant_holiday->result_array()[0]['holiday_id'] - 1){
 			$this->form_validation->set_message('check_inassistant_date','ไม่สามารถลง {field} ได้เนื่องจากลงเป็นวันเข้าอยู่แล้ว');
	        return false; 
		}
		return true;
	}
	
}

