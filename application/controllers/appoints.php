<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appoint Controller
 *
 * Appoint Controller information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Appoints extends CI_Controller
{
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Global parameter
	 */
	protected $user_id;
	protected $owner_id;
	protected $provider_id;
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Construction function
	 */
    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/access_denied'));
        }
        
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Appoint_model', 'appoint');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Index function
     * 
     * Index page for appointment module
     * @param	string	$vn	The visit number, if null will display appointment list else if vn isset 
     * 						display new register.
     */
    public function index($vn = '', $hn = ''){
    	if(empty($vn) || !isset($vn)){
    		$data['clinics'] = $this->basic->get_clinic();
    		$this->layout->view('appoints/index_view', $data);
    	}else{
    		$this->register($vn, $hn);
    	}
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Register function
     * 
     * Register new appoint
     * @param	string	$vn The visit number
     * 
     */
	public function register($vn = '', $hn = ''){
		if(empty($vn) || !isset($vn) || empty($hn) || !isset($hn)){
			show_error('No vn found.', 404);
		}else if(!$this->service->check_visit_exist($vn)){
			show_error('VN don\'t exist, please check visit number and try again.', 404);
		}else{
			//show new register
			$data = get_patient_info($hn);
			$data['vn'] 		= $vn;
			$data['hn'] 		= $hn;
			$data['address'] 	= get_address($hn);
			$data['aptypes'] 	= $this->basic->get_appoint_type();
			$data['clinics'] 	= $this->basic->get_clinic();
			
			$this->layout->view('appoints/register_view', $data);
			
		}
	}    
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Save appoint registration
	 * 
	 * @param	array	$data	The data for save.
	 */
	public function do_register(){
		$data = $this->input->post('data');
		if(empty($data)){
			$json = '{"success": false, "msg": "No data for save."}';
		}else{
			if(empty($data['apdate'])){
				$json = '{"success": false, "msg": "ไม่พบวันที่นัด"}';
			}else if(empty($data['aptime'])){
				$json = '{"success": false, "msg": "ไม่พบเวลานัด"}';
			}else if(empty($data['clinic'])){
				$json = '{"success": false, "msg": "ไม่พบแผนกที่นัด"}';
			}else if(empty($data['aptype'])){
				$json = '{"success": false, "msg": "ไม่พบประเภทการนัด"}';
			}else{
				
				$duplicated = $this->appoint->check_duplicate(to_string_date($data['apdate']), $data['aptype']);
				
				if($duplicated){
					$json = '{"success": false, "msg": "ข้อมูลซ้ำ กรุณาเลือกแผลกและประเภทการนัดใหม่"}';
				}else{
					$this->appoint->provider_id = $this->provider_id;
					$this->appoint->user_id 	= $this->user_id;
					$this->appoint->owner_id 	= $this->owner_id;
					
					$rs = $this->appoint->do_register($data);
					
					if($rs){
						$json = '{"success": true}';
					}else{
						$json = '{"success": false, "msg": "Can\'t save appointment."}';
					}
				}
			}
		}
		
		render_json($json);
	}
    //-----------------------------------------------------------------------------------------------------------------
	/*
	 * Get appointment list
	 * 
	 * @internal	param	string	$apdate		Appoint date in format dd/mm/yyyy
	 * @internal	param	string	$apclinic	Appoint clinic id.
	 * @internal	param	string	$apstatus	Appoint status, 0 = All, 1 = Ok, 2 = Absent.
	 */
	public function get_list(){
		
		$apdate 	= $this->input->post('apdate');
		$apclinic 	= $this->input->post('apclinic');
		$apstatus 	= $this->input->post('apstatus');
		
		$apdate 	= empty($apdate) ? date('Ymd') : to_string_date($apdate);
		$apclinic 	= empty($apclinic) ? '00000' : $apclinic; // 00000 = All clinic
		$apstatus 	= empty($apstatus) ? '0' : $apstatus; // 0 = All, 1 = Ok, 2 = Absent
		
		$this->appoint->owner_id = $this->owner_id;

		$rs = $this->appoint->get_list($apdate, $apclinic, $apstatus);
		
		if($rs){
			
			$arr_result = array();
			
			foreach($rs as $r){
				$obj = new stdClass();
				
				$obj->clinic_name = get_clinic_name(get_first_object($r['apclinic_id']));
				$obj->provider_name = get_provider_name_by_id($r['provider_id']);
				$obj->apdate = $r['apdate'];
				$obj->aptime = $r['aptime'];
				$obj->aptype_name = get_appoint_type_name($r['aptype_id']);
								
				$person = $this->service->get_person_detail($r['hn']);
				
				$obj->id = get_first_object($r['_id']);
				$obj->person_name = $person['first_name'] . ' ' . $person['last_name'];
				$obj->hn = $r['hn'];
				$obj->vn = $r['vn'];
				$obj->vstatus = $r['visit_status'];
				
				array_push($arr_result, $obj);
			}
			
			$rows = json_encode($arr_result);
			$json = '{"success": true, "rows": '.$rows.'}';
		}else{
			$json = '{"success": false, "msg": "No record found."}';
		}
		
		render_json($json);
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Search visit
	*
	* @param	string 	$query	The query for search
	* @param	string	$filter	The filter type. 0 = CID, 1 = HN, 2 = First name and last name
	*/
	public function search_visit(){
		$query = $this->input->post('query');
		$filter = $this->input->post('filter');
	
		$filter = empty($filter) ? '0' : $filter;
	
		if(empty($query)){
			$json = '{"success": false, "msg": "No query found"}';
		}else{
			
			$hn = NULL;
			
			if($filter == '0'){
				//get hn by cid
				$hn = $this->person->get_hn_from_cid($query);
			}else if($filter == '2'){
				//get hn by first name and last name
				$fullname = explode(' ', $query); // [0] = first name, [1] = last name
				$hn = $this->person->get_hn_from_first_last_name($fullname[0], $fullname[1]);
			}else{
				$hn = $query;
			}
			
			//$json = '{"success": true, "hn": "'.$hn.'"}';
			
			$rs = $this->appoint->do_search_visit($hn);
			
			if($rs){
				
				$arr_result = array();
				foreach($rs as $r){
					$obj = new stdClass();
					
					$person = $this->service->get_person_detail($r['hn']);
					$obj->person_name = $person['first_name'] . ' ' . $person['last_name'];

					$obj->hn = $r['hn'];
					$obj->vn = $r['vn'];
					$obj->date_serv = from_mongo_to_thai_date($r['date_serv']);
					$obj->time_serv = $r['time_serv'];
					$obj->clinic_name = get_clinic_name(get_first_object($r['clinic']));
					
					array_push($arr_result, $obj);
				}
				
				$rows = json_encode($arr_result);
				$json = '{"success": true, "rows": '.$rows.'}';
			}else{
				$json = '{"success": false, "msg": "No result."}';
			}
			
		}
	
		render_json($json);
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Remove appointment
	 * 
	 * @param	MongoId	$id The appointment id.
	 */
	public function remove(){
		
		$id = $this->input->post('id');
		if(empty($id)){
			$json = '{"success": false, "msg": "ไม่พบรหัสการนัดที่ต้องการลบ"}';
		}else{
			//do remove
			$rs = $this->appoint->do_remove($id);
			if($rs){
				$json = '{"success": true}';
			}else{
				$json = '{"success": false, "msg": "ไม่สามารถลบรายการได้ กรุณาตรวจสอบ"}';
			}
		}
		
		render_json($json);
	}
}

//End file