<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Accidents Controller
 *
 * Appoint Controller information
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Accidents extends CI_Controller
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

        //$this->load->model('Appoint_model', 'appoint');
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
    		show_404();
    	}else{
    		$data = get_patient_info($hn);
    		$data['vn'] 		= $vn;
    		$data['hn'] 		= $hn;
    		$data['aetypes'] 	= $this->basic->get_aetype();
    		$data['aeplaces'] 	= $this->basic->get_aeplace();
    		$data['aetypeins'] 	= $this->basic->get_aetypein();
    		$data['aetraffics'] = $this->basic->get_aetraffic();
    		$data['aevehicles'] = $this->basic->get_aevehicle();
    		
    		$this->layout->view('accidents/index_view', $data);
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