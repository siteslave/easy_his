<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 1/4/2556 10:42 น.
 */
class Reports extends CI_Controller {
    protected $provider_id;
    protected $user_id;
    protected $owner_id;

    public function __construct() {
        parent::__construct();

        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');

        if(empty($this->owner_id)){
            redirect(site_url('users/login'));
        }

        $this->provider_id = $this->session->userdata('provider_id');
        $this->load->helper('person');
        $this->load->model('Reports_model', 'report');
    }

    public function index() {
        $data['id'] = '1';

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }

    public function menu($id) {
        $id = empty($id)?'1':$id;
        $id = !isset($id)?'1':$id;
        $data['id'] = $id;

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }

    public function addreport() {
        redirect('reports/add_report/1');
    }

    public function add_report($id) {
        $id = empty($id)?'1':$id;
        $id = !isset($id)?'1':$id;
        $data['id'] = $id;

        $this->layout->layout('report_layout');
        $this->layout->view('reports/add_report', $data);
    }

    public function save_report() {
        $data = $this->input->post('data');

        $rs = $this->report->save_report($data);

        if($rs)
            $json = '{ "success": true, "msg": "บันทึกข้อมูลแล้ว" }';
        else
            $json = '{ "success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้" }';

        render_json($json);
    }

    public function get_list() {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $group = $this->input->post('group');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->report->owner_id = $this->owner_id;
        $rs = $this->report->get_list($start, $limit, $group);
        if($rs)
        {
            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->name = $r['name'];
                $obj->url = $r['url'];
                $obj->group = $r['group'];

                $arr_result[] = $obj;
            }

            $rows = json_encode($arr_result);
            $json = '{"success": true, "rows": '.$rows.'}';
        }
        else
        {
            $json = '{"success": false, "msg": "No result."}';
        }

        render_json($json);
    }

    public function get_list_total()
    {
        $group = $this->input->post('group');

        $this->report->owner_id = $this->owner_id;
        $total = $this->report->get_list_total($group);
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }
}