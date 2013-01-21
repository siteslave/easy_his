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
	protected $user_id;
	protected $owner_id;
	protected $provider_id;

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
        
    }
    /*
     * Index function
     * 
     * Index page for appointment module
     * @param	string	$vn	The visit number, if null will display appointment list else if vn isset 
     * 						display new register.
     */
    public function index($vn = ''){
    	if(empty($vn) || !isset($vn)){
    		$data['vn'] = $vn;
    		
    		$this->layout->view('appoints/index_view', $data);
    	}else{
    		$this->register($vn);
    	}
    }
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
			$data['vn'] = $vn;
			$data['hn'] = $hn;
			$data['address'] = get_address($hn);
			$data['aptypes'] = $this->basic->get_appoint_type();
			$data['clinics'] = $this->basic->get_clinic();
			
			$this->layout->view('appoints/register_view', $data);
			
			//echo var_dump($data['first_name']);
		}
		
	}    
	
	public function do_register(){
		$data = $this->input->post('data');
		if(empty($data)){
			$json = '{"success": false, "msg": "No data for save."}';
		}else{
			if(empty($data['apdate'])){
				$json = '{"success": false, "msg": "No apdate found."}';
			}else if(empty($data['aptime'])){
				$json = '{"success": false, "msg": "No aptime found."}';
			}else if(empty($data['clinic'])){
				$json = '{"success": false, "msg": "No clinic found."}';
			}else if(empty($data['aptype'])){
				$json = '{"success": false, "msg": "No aptype found."}';
			}else{
				
				$this->appoint->provider_id = $this->provider_id;
				$this->appoint->user_id = $this->user_id;
				$this->appoint->owner_id = $this->owner_id;
				
				$rs = $this->appoint->do_register($data);
				
				if($rs){
					$json = '{"success": true}';
				}else{
					$json = '{"success": false, "msg": "Can\'t save appointment."}';
				}
			}
		}
		
		render_json($json);
	}
    
}