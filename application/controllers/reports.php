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
        $this->load->helper('report');
        $this->load->model('Reports_model', 'report');
    }

    public function index() {
        $first_id = '';
        $data['id'] = '1';
        $rs = $this->report->get_mainmenu();
        $arr_result = array();
        $i = 0;
        foreach($rs as $r) {
            if($i == 0) $first_id = get_first_object($r['_id']);
            $i = 1;
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            $arr_result[] = $obj;
        }
        $data['mainmenu'] = $arr_result;

        if($rs)
            redirect(site_url('reports/menu/'. $first_id));
        else
            redirect(site_url('reports/addreport'));

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }

    public function menu($id) {
        if(empty($id)) {
            redirect(site_url('reports'));
        }
        $data['id'] = $id;
        $rs = $this->report->get_mainmenu();
        $arr_result = array();
        foreach($rs as $r) {
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            $arr_result[] = $obj;
        }
        $data['mainmenu'] = $arr_result;

        $this->layout->layout('report_layout');
        $this->layout->view('reports/index_view', $data);
    }

    public function addreport() {
        redirect('reports/add_report/main');
    }

    public function add_report($id) {
        $id = empty($id)?'main':$id;
        $id = !isset($id)?'main':$id;
        $data['id'] = $id;

        if($id == 'main') {
            $this->layout->layout('report_layout');
            $this->layout->view('reports/add_report');
        } else {
            $rs = $this->report->get_mainmenu();
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->name = $r['name'];

                $arr_result[] = $obj;
            }
            $data['mainmenu'] = $arr_result;

            $this->layout->layout('report_layout');
            $this->layout->view('reports/add_sub_report', $data);
        }
    }

    public function save_main_report() {
        $data = $this->input->post('data');

        $rs = $this->report->save_main_report($data);

        if($rs)
            $json = '{ "success": true, "msg": "บันทึกข้อมูลแล้ว" }';
        else
            $json = '{ "success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้" }';

        render_json($json);
    }

    public function save_sub_report() {
        $data = $this->input->post('data');

        $rs = $this->report->save_sub_report($data);

        if($rs)
            $json = '{ "success": true, "msg": "บันทึกข้อมูลแล้ว" }';
        else
            $json = '{ "success": false, "msg": "ไม่สามารถบันทึกข้อมูลได้" }';

        render_json($json);
    }

    public function get_sub_list() {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');
        $group = $this->input->post('group');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->report->owner_id = $this->owner_id;
        $rs = $this->report->get_sub_list($start, $limit, $group);
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

    public function get_main_list() {
        $start = $this->input->post('start');
        $stop = $this->input->post('stop');

        $start = empty($start) ? 0 : $start;
        $stop = empty($stop) ? 25 : $stop;

        $limit = (int) $stop - (int) $start;

        $this->report->owner_id = $this->owner_id;
        $rs = $this->report->get_main_list($start, $limit);
        if($rs)
        {
            $arr_result = array();

            foreach($rs as $r)
            {
                $obj = new stdClass();
                $obj->id = get_first_object($r['_id']);
                $obj->name = $r['name'];
                $obj->icon = $r['icon'];

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

    public function get_sub_list_total()
    {
        $group = $this->input->post('group');

        $this->report->owner_id = $this->owner_id;
        $total = $this->report->get_sub_list_total($group);
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function get_main_list_total()
    {
        $this->report->owner_id = $this->owner_id;
        $total = $this->report->get_main_list_total();
        $json = '{"success": true, "total": '.$total.'}';

        render_json($json);
    }

    public function remove_mainmenu_report() {
        $id = $this->input->post('id');

        $rs = $this->report->remove_mainmenu_report($id);
        if($rs)
            $json = '{ "success": true, "msg":"ลบรายงานแล้ว" }';
        else
            $json = '{ "success": false, "msg": "ไม่สามารถลบรายงานได้" }';

        render_json($json);
    }

    public function remove_submenu_report() {
        $id = $this->input->post('id');

        $rs = $this->report->remove_submenu_report($id);
        if($rs)
            $json = '{ "success": true, "msg":"ลบรายงานแล้ว" }';
        else
            $json = '{ "success": false, "msg": "ไม่สามารถลบรายงานได้" }';

        render_json($json);
    }

    public function load_sub_item() {
        $id = $this->input->post('id');

        $rs = $this->report->load_sub_item($id);
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->id    = get_first_object($r['_id']);
                $obj->name  = $r['name'];
                $obj->url   = $r['url'];
                $obj->group = $r['group'];

                $arr_result[] = $obj;
            }

            $json = '{ "success": true, "rows": '.json_encode($arr_result).' }';
        } else {
            $json = '{ "success": false, "msg": "No result." }';
        }
        render_json($json);
    }

    public function load_main_item() {
        $id = $this->input->post('id');

        $rs = $this->report->load_main_item($id);
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj = new stdClass();
                $obj->id    = get_first_object($r['_id']);
                $obj->name  = $r['name'];
                $obj->icon   = $r['icon'];

                $arr_result[] = $obj;
            }

            $json = '{ "success": true, "rows": '.json_encode($arr_result).' }';
        } else {
            $json = '{ "success": false, "msg": "No result." }';
        }
        render_json($json);
    }
}