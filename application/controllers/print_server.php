<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 10/5/2556 9:09 น.
 */
class Print_server extends CI_Controller {
    protected $provider_id;
    protected $user_id;
    protected $owner_id;

    public function __construct() {
        parent::__construct();
        $this->load->model('Print_server_model', 'pserv');
    }

    public function get_pcu($uid, $pwd) {
        //$uid = $this->input->post('uid');
        //$pwd = $this->input->post('pwd');

        $rs = $this->pserv->get_owner($uid, $pwd);

        if($rs != 'ERR') {
            $arr_result = array();
            $obj = new stdClass();
            $obj->owner = $rs;

            $pcucode = $this->pserv->get_pcucode($rs);
            $rs1 = $this->pserv->get_owner_detail($pcucode);
            $obj->pcucode = $pcucode;
            $obj->name = $rs1[0]['hospname'];
            $arr_result[] = $obj;

            $json = '{ "success": true, "rows": '.json_encode($arr_result).' }';
        } else {
            $json = '{ "success": false, "msg": "No data result." }';
        }

        render_json($json);
    }

    public function get_pcuname($pcucode) {
        $rs = $this->pserv->get_owner_detail($pcucode);
        if($rs) {
            $obj = new stdClass();
            $arr_result = array();
            $obj->pcucode = $pcucode;
            $obj->name = $rs[0]['hospname'];
            $arr_result[] = $obj;

            $json = '{ "success": true, "rows": '.json_encode($arr_result).' }';
        } else {
            $json = '{ "success": false, "msg": "No data result." }';
        }
        render_json($json);
    }

    public function get_sticker($pcucode, $date) {
        #$uid = $this->input->post('uid');
        #$pwd = $this->input->post('pwd');
        #$date = '20130510';

        $owner = $this->pserv->get_owner_by_pcucode($pcucode);
        if($owner != 'ERR') {
            $this->pserv->owner_id = $owner;
            $rs_serv = $this->pserv->get_sticker($date);
            if($rs_serv) {
                $json = '{ "success": true, "rows": '.json_encode($rs_serv).' }';
            } else {
                $json = '{ "success": false, "msg": "No sticker in list." }';
            }
        } else {
            $json = '{ "success": false, "msg": "Invalid user or password." }';
        }
        render_json($json);
    }
}