<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 10/5/2556 9:12 น.
 */
class Print_server_model extends CI_Model {
    public $owner_id;

    public function __construct(){
        parent::__construct();
    }

    public function get_owner($uid, $pwd) {
        $rs = $this->mongo_db
            ->where(array('username'=> $uid, 'password'=> $pwd))
            ->get('users');

        if($rs)
            return get_first_object($rs[0]['owner_id']);
        else
            return 'ERR';
    }

    public function get_pcucode($owner_id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($owner_id))
            ->get('owners');

        if($rs)
            return $rs[0]['pcucode'];
        else
            return null;
    }

    public function get_owner_detail($pcucode) {
        $rs = $this->mongo_db
            ->where('hospcode', $pcucode)
            ->get('ref_hospitals');

        return $rs;
    }

    public function get_sticker($date) {
        
    }
}