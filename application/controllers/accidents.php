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

}

//End file