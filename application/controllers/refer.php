<?php
/**
 * Created by Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 11/3/2556 10:53 น.
 */
class Refer extends CI_Controller {
    /*
     * Global parameter
     */
    protected $user_id;
    protected $owner_id;
    protected $provider_id;

    public function __construct() {
        parent::__construct();
        $this->owner_id = $this->session->userdata('owner_id');
        if(empty($this->owner_id))
        {
            redirect(site_url('users/access_denied'));
        }
        $this->owner_id = $this->session->userdata('owner_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->provider_id = $this->session->userdata('provider_id');

        $this->load->model('Refer_model', 'refer');
        $this->load->model('Person_model', 'person');

        $this->load->helper(array('person', 'his'));
    }

    public function index() {
        $this->layout->view('refer/index_view');
    }

    public function search_person()
    {
        $query = $this->input->post('query');
        $filter = $this->input->post('filter');

        $filter = empty($filter) ? '0' : $filter;

        if(empty($query))
        {
            $json = '{"success": false, "msg": "No query found"}';
        }
        else
        {

            if($filter == '0') //by cid
            {
                $rs = $this->person->search_person_by_cid($query);
            }
            else if($filter == '2')
            {
                //get hn by first name and last name
                $name = explode(' ', $query); // [0] = first name, [1] = last name

                $first_name = count($name) == 2 ? $name[0] : '';
                $last_name = count($name) == 2 ? $name[1] : '';

                $rs = $this->person->search_person_by_first_last_name($first_name, $last_name);

            }
            else
            {
                $rs = $this->person->search_person_by_hn($query);
            }

            if($rs)
            {

                $arr_result = array();

                foreach($rs as $r)
                {
                    $obj = new stdClass();
                    $obj->id = get_first_object($r['_id']);
                    $obj->hn = $r['hn'];
                    $obj->cid = $r['cid'];
                    $obj->first_name = $r['first_name'];
                    $obj->last_name = $r['last_name'];
                    $obj->birthdate = $r['birthdate'];
                    $obj->sex = $r['sex'] == '1' ? 'ชาย' : 'หญิง';
                    $obj->age = count_age($r['birthdate']);

                    $arr_result[] = $obj;
                }

                $rows = json_encode($arr_result);
                $json = '{"success": true, "rows": '.$rows.'}';
            }
            else
            {
                $json = '{"success": false, "msg ": "ไม่พบรายการ"}';
            }

        }

        render_json($json);
    }

    public function get_visit() {
        $id = $this->input->post('id');
        $hn = $this->input->post('hn');

        $rs = $this->refer->get_visit($id);
        if($rs) {
            $arr_result = array();
            foreach($rs as $r) {
                $obj        = new stdClass();
                $obj->id    = get_first_object($r['_id']);
                $obj->hn    = $hn;
                $obj->vn    = $r['vn'];
                $obj->date  = $r['date_serv'];
                $obj->time  = $r['time_serv'];
                $obj->cc    = $r['screenings']['cc'];

                $arr_result[] = $obj;
            }
            $rows = json_encode($arr_result);
            $json = '{ "success": true, "rows": '.$rows.' }';
        } else {
            $json = '{ "success": false, "msg": "ไม่มีข้อมูลบริการ" }';
        }
        render_json($json);
    }

    public function register($hn = '', $vn = '') {
        if(empty($hn) || empty($vn)) {
            echo '<script> alert("HN or VN not found."); history.go(-1); </script>';
        } else {
            $this->layout->view('refer/refer_register');
        }
    }
}