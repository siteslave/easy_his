<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Refer controller
 *
 * @package     Controller
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Refers extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Referout_model', 'rfo');

        $this->rfo->user_id = $this->user_id;
        $this->rfo->provider_id = $this->provider_id;
        $this->rfo->owner_id = $this->owner_id;
    }

    public function save_service()
    {
        $data = $this->input->post('data');
        if(!empty($data))
        {
            //check if update
            if($data['id'])
            {
                //update

            }
            else
            {
                //insert
            }
        }
        else
        {
            $json = '{"success": false, "msg": "ไม่พบข้อมูลที่ต้องการบันทึก"}';
        }

        render_json($json);
    }

}