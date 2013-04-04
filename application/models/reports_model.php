<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 1/4/2556 10:51 น.
 */
class Reports_model extends CI_Model {

    public function get_list($start, $limit, $group)
    {
        $rs = $this->mongo_db
            ->where('group', $group)
            ->offset($start)
            ->limit($limit)
            ->get('rpt_report_menu');
        return $rs;
    }

    public function get_list_total($group)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }

    public function save_report($d) {
        if($d['id'] == 0) {
            $rs = $this->mongo_db
                ->insert('rpt_report_menu', array(
                    'name'  => $d['name'],
                    'url'   => $d['url'],
                    'group' => $d['group']
                ));
        } else {
            $rs = $this->mongo_db
                ->where('_id', new MongoId($d['id']))
                ->set(array(
                    'name'  => $d['name'],
                    'url'   => $d['url'],
                    'group' => $d['group']
                ))
                ->update('rpt_report_menu');
        }

        return $rs;
    }
}