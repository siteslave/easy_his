<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

    /*
     * Owner id for assign owner.
     */
    var $owner_id;

    public function __construct(){
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->load->model('Basic_model', 'basic');
        $this->load->model('Service_model', 'service');
        $this->load->model('Appoint_model', 'appoint');

        $this->service->owner_id = $this->owner_id;
        $this->basic->owner_id = $this->owner_id;
    }
    public function index()
    {
        //$this->twiggy->display();
        $this->layout->view('pages/index_view');
    }

    public function procedure($vn='', $code='')
    {
        if(empty($vn))
        {
            echo 'VN not found.';
        }
        else
        {
            $data['providers'] = $this->basic->get_providers();
            $data['clinics']   = $this->basic->get_clinic();
            $data['vn'] = $vn;
            $data['update'] = empty($code) ? '0' : 1;
            //proced
            if(!empty($code))
            {
                $proced = $this->service->get_service_proced_opd_detail($vn, $code);
                $obj = new stdClass();
                $obj->code = $proced['code'];
                $obj->proced_name = get_procedure_name($obj->code);
                $obj->price = $proced['price'];
                $obj->start_time = isset($proced['start_time']) ? $proced['start_time'] : NULL;
                $obj->end_time = isset($proced['end_time']) ? $proced['end_time'] : NULL;
                $obj->provider_id = isset($proced['provider_id']) ? get_first_object($proced['provider_id']) : NULL;
                $obj->clinic_id = isset($proced['clinic_id']) ? get_first_object($proced['clinic_id']) : NULL;
                $data['proced'] = $obj;
            }

            $this->load->view('pages/procedure_view', $data);
        }
    }

    public function diagnosis()
    {
        $data['diag_types']= $this->basic->get_diag_type();
        $data['clinics']   = $this->basic->get_clinic();
        $this->load->view('pages/diagnosis_view', $data);
    }

    public function drugs($vn='', $id='')
    {
        $data['update'] = empty($id) ? '0' : 1;
        if(!empty($id))
        {
            $drugs = $this->service->get_drug_detail($id);

            $obj = new stdClass();
            $obj->id = $id;
            $obj->drug_id = get_first_object($drugs['drug_id']);
            $obj->drug_name = get_drug_name($drugs['drug_id']);
            $obj->usage_name = get_usage_name($drugs['usage_id']);
            $obj->usage_id = $drugs['usage_id'];
            $obj->qty = $drugs['qty'];
            $obj->price = $drugs['price'];
            $data['drug'] = $obj;
        }

        $this->load->view('pages/drug_view', $data);
    }

    public function charges($hn='', $vn='', $id='')
    {
        if(!empty($id))
        {
            $rs = $this->service->get_charge_opd($id);
            $obj = new stdClass();
            $obj->charge_code = $rs['charge_code'];
            $obj->charge_name = get_charge_name($obj->charge_code);
            $obj->qty = $rs['qty'];
            $obj->price = $rs['price'];

            $data['items'] = $obj;
            $data['id'] = $id;
        }

        $data['vn'] = $vn;
        $data['hn'] = $hn;
        $this->load->view('pages/charge_view', $data);
    }

    public function appoints($hn='', $vn='', $id='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;
        $data['providers'] = $this->basic->get_providers();
        $data['clinics']        = $this->basic->get_clinic();
        $data['aptypes']        = $this->basic->get_appoint_type();

        if(!empty($id))
        {
            $rs = $this->appoint->detail($id);

            $data['id'] = get_first_object($rs['_id']);
            $data['clinic_id'] = get_first_object($rs['apclinic_id']);
            $data['provider_id'] = get_first_object($rs['provider_id']);
            $data['diag_code'] = $rs['apdiag'];
            $data['type'] = get_first_object($rs['aptype_id']);
            $data['diag_name'] = get_diag_name($rs['apdiag']);
            $data['apdate'] = from_mongo_to_thai_date($rs['apdate']);
            $data['aptime'] = $rs['aptime'];
        }

        $this->load->view('pages/appoint_view', $data);
    }

    public function refer_out($hn='', $vn='', $id='')
    {
        $data['hn'] = $hn;
        $data['vn'] = $vn;
        $data['providers'] = $this->basic->get_providers();
        $data['clinics']        = $this->basic->get_clinic();

        $this->load->view('pages/refer_out_view', $data);
    }
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */