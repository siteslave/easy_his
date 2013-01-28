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

        if(empty($this->owner_id))
        {
            redirect(site_url('users/access_denied'));
        }
        
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        //$this->load->model('Appoint_model', 'appoint');
        $this->load->model('Service_model', 'service');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Person_model', 'person');
        $this->load->model('Accident_model', 'accident');
        
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Index function
     * 
     * Index page for appointment module
     * @param	string	$vn	The visit number, if null will display appointment list else if vn isset 
     * 						display new register.
     */
    public function register($vn = '', $hn = '')
    {
    	$this->service->owner_id = $this->owner_id;
    	
    	$vn_exist = $this->service->check_visit_exist($vn);
    	
    	if(!$vn_exist)
    	{
    		show_error('Service not found.', 404);
    	}
    	else
    	{
    		$data = get_patient_info($hn);
    		$data['vn'] 		= $vn;
    		$data['hn'] 		= $hn;
    		$data['aetypes'] 	= $this->basic->get_aetype();
    		$data['aeplaces'] 	= $this->basic->get_aeplace();
    		$data['aetypeins'] 	= $this->basic->get_aetypein();
    		$data['aetraffics'] = $this->basic->get_aetraffic();
    		$data['aevehicles'] = $this->basic->get_aevehicle();
    		
    		//check exist
    		$data['updated'] = $this->accident->check_exist($vn) ? '1' : '0';
    		
    		$this->layout->view('accidents/register_view', $data);
    	}
    }   

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save data
     * 
     * Save accident data
     */
    public function save() 
    {
    	$data = $this->input->post('data');
    	
    	if(empty($data))
    	{
    		$json = '{"success": false, "msg": "No data for save"}';
    	}
    	else
    	{
    		$this->accident->user_id = $this->user_id;
    		$this->accident->provider_id = $this->provider_id;
    		$this->accident->owner_id = $this->owner_id;
    			
    		$data['ae_date'] = to_string_date($data['ae_date']);
    		
    		$rs = FALSE;
    		
    		if($data['isupdate'])
    		{
    			$rs = $this->accident->update($data);
    		}
    		else 
    		{
    			$rs = $this->accident->save($data);
    		}
    			
    	 	if($rs)
    	 	{
 				$json = '{"success": true}';
  			}
    	 	else
    		{
    			$json = '{"success": false, "msg": "Can\'t save data."}';
    		}
    		
    	}
    	
    	render_json($json);
    }
    
    public function get_data()
    {
    	$vn = $this->input->post('vn');
    	
    	if(empty($vn))
    	{
    		$json = '{"success": false, "msg": "No vn found"}';
    	}
    	else
    	{
    		$rs = $this->accident->get_data($vn);
    		if($rs)
    		{
    			$obj = new stdClass();
    			$obj->ae_date = to_js_date($rs['ae_date']);
    			$obj->ae_time = $rs['ae_time'];
    			$obj->ae_urgency = $rs['ae_urgency'];
    			$obj->ae_type = get_first_object($rs['ae_type']);
    			$obj->ae_place = get_first_object($rs['ae_place']);
    			$obj->ae_typein = get_first_object($rs['ae_typein']);
    			$obj->ae_traffic = get_first_object($rs['ae_traffic']);
    			$obj->ae_vehicle = get_first_object($rs['ae_vehicle']);
    			$obj->ae_alcohol = $rs['ae_alcohol'];
    			$obj->ae_nacrotic_drug = $rs['ae_nacrotic_drug'];
    			$obj->ae_belt = $rs['ae_belt'];
    			$obj->ae_helmet = $rs['ae_helmet'];
    			$obj->ae_airway = $rs['ae_airway'];
    			$obj->ae_stopbleed = $rs['ae_stopbleed'];
    			$obj->ae_splint = $rs['ae_splint'];
    			$obj->ae_fluid = $rs['ae_fluid'];
    			$obj->ae_coma_eye = $rs['ae_coma_eye'];
    			$obj->ae_coma_speak = $rs['ae_coma_speak'];
    			$obj->ae_coma_movement = $rs['ae_coma_movement'];
    				
    	
    			$rows = json_encode($obj);
    			$json = '{"success": true, "rows": '.$rows.'}';
    		}
    		else
    		{
    			$json = '{"success": false, "msg": "No data."}';
    		}
    	}
    	
    	render_json($json);
    }
}

//End file