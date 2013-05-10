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
        $rs_visit = $this->mongo_db
            ->select(array('_id', 'vn', 'hn', 'date_serv'))
            ->where(array('date_serv'=> $date, 'owner_id'=> new MongoId($this->owner_id)))
            ->get('visit');
        if($rs_visit) {
            $arr_result = array();
            foreach ($rs_visit as $r) {
                $obj = new stdClass();
                $obj->id        = get_first_object($r['_id']);
                $obj->vn        = $r['vn'];
                $obj->hn        = $r['hn'];
                $obj->date_serv = $r['date_serv'];

                $rs_person = $this->mongo_db
                    ->select(array('title', 'first_name', 'last_name'))
                    ->where('hn', $r['hn'])
                    ->limit(1)
                    ->get('person');
                if($rs_person) {
                    $rs_title = $this->mongo_db
                        ->select('name')
                        ->where('_id', $rs_person[0]['title'])
                        ->get('ref_titles');
                    if($rs_title)
                        $obj->title         = $rs_title[0]['name'];
                    $obj->fname             = $rs_person[0]['first_name'];
                    $obj->lname             = $rs_person[0]['last_name'];
                }

                $rs_drug_opd = $this->mongo_db
                    ->select(array('qty', 'drug_id', 'usage_id'))
                    ->where('vn', $r['vn'])
                    ->get('drugs_opd');
                if($rs_drug_opd) {
                    $arr_drug = array();
                    foreach($rs_drug_opd as $ad) {
                        $obj1 = new stdClass();
                        $rs_drug = $this->mongo_db
                            ->select(array('name', 'unit'))
                            ->where('_id', $ad['drug_id'])
                            ->limit(1)
                            ->get('ref_drugs');
                        if($rs_drug) {
                            $obj1->name     = $rs_drug[0]['name'];
                            $obj1->unit     = $rs_drug[0]['unit'];

                            $obj1->hint     = '';
                        }
                        $obj1->qty    = $ad['qty'];

                        $rs_usage = $this->mongo_db
                            ->select(array('name1', 'name2', 'name3'))
                            ->where('_id', $ad['usage_id'])
                            ->limit(1)
                            ->get('ref_drug_usages');
                        if($rs_usage) {
                            $obj1->usage1   = $rs_usage[0]['name1'];
                            $obj1->usage2   = $rs_usage[0]['name2'];
                            $obj1->usage3   = $rs_usage[0]['name3'];
                        }

                        $arr_drug[] = $obj1;
                    }
                    $obj->drug              = $arr_drug;
                }

                $arr_result[] = $obj;
            }

            return $arr_result;
        } else {
            return null;
        }
    }
}