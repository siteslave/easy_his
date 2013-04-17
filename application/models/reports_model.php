<?php
/**
 * Created By Mr.Utit Sairat.
 * E-mail: soodteeruk@gmail.com
 * Date: 1/4/2556 10:51 น.
 */
class Reports_model extends CI_Model {

    public function get_sub_list($start, $limit, $group)
    {
        $rs = $this->mongo_db
            ->where('group', $group)
            ->offset($start)
            ->limit($limit)
            ->get('rpt_report_submenu');
        return $rs;
    }

    public function get_sub_list_total($group)
    {
        $rs = $this->mongo_db
            ->where('group', $group)
            ->count('rpt_report_submenu');

        return $rs;
    }

    public function get_main_list($start, $limit) {
        $rs = $this->mongo_db
            ->offset($start)
            ->limit($limit)
            ->get('rpt_report_mainmenu');
        return $rs;
    }

    public function get_main_list_total()
    {
        $rs = $this->mongo_db
            ->count('rpt_report_mainmenu');

        return $rs;
    }

    public function save_sub_report($d) {
        if($d['id'] == 0) {
            $rs = $this->mongo_db
                ->insert('rpt_report_submenu', array(
                    'name'  => $d['name'],
                    'url'   => $d['url'],
                    'group' => $d['group'],
                    'icon'  => 'icon-print'
                ));
        } else {
            $rs = $this->mongo_db
                ->where('_id', new MongoId($d['id']))
                ->set(array(
                    'name'  => $d['name'],
                    'url'   => $d['url'],
                    'group' => $d['group'],
                    'icon'  => 'icon-print'
                ))
                ->update('rpt_report_submenu');
        }
        return $rs;
    }

    public function save_main_report($d) {
        if($d['id'] == 0) {
            $rs = $this->mongo_db
                ->insert('rpt_report_mainmenu', array(
                    'name'  => $d['name'],
                    'icon'  => $d['icon']
                ));
        } else {
            $rs = $this->mongo_db
                ->where('_id', new MongoId($d['id']))
                ->set(array(
                    'name'  => $d['name'],
                    'icon'  => $d['icon']
                ))
                ->update('rpt_report_mainmenu');
        }

        return $rs;
    }

    public function remove_mainmenu_report($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->delete('rpt_report_mainmenu');

        return $rs;
    }

    public function remove_submenu_report($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->delete('rpt_report_submenu');

        return $rs;
    }

    public function load_sub_item($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('rpt_report_submenu');

        return $rs;
    }

    public function load_main_item($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('rpt_report_mainmenu');

        return $rs;
    }

    public function get_mainmenu() {
        $rs = $this->mongo_db
            ->limit(6)
            ->get('rpt_report_mainmenu');

        return $rs;
    }

    public function get_other_mainmenu() {
        $rs = $this->mongo_db
            ->offset(6)
            ->get('rpt_report_mainmenu');

        return $rs;
    }

    public function get_mainmenu_count() {
        $rs = $this->mongo_db
            ->count('rpt_report_mainmenu');

        return $rs;
    }
}