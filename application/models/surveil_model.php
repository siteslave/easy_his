<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Women Model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Surveil_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;
    public $code506; //ICD Code in array format

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($vn, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where_in('vn', $vn)
            ->where_in('code', $this->code506)
            ->offset($start)
            ->limit($limit)
            ->order_by(array('vn' => 'ASC'))
            ->get('diagnosis_opd');
        return $rs;
    }

    public function get_list_total($vn)
    {
        $rs = $this->mongo_db
            ->where_in('vn', $vn)
            ->where_in('code', $this->code506)
            ->count('diagnosis_opd');
        return $rs;
    }

    public function get_vn($visit_date)
    {
        $rs = $this->mongo_db
            ->select(array('vn'))
            ->where(array(
                'date_serv' => (string) $visit_date,
                'owner_id' => new MongoId($this->owner_id)))
            ->get('visit');

        $vn = array();

        foreach($rs as $r)
            $vn[] = $r['vn'];

        return $vn;
    }
    public function get_506_group()
    {
        $rs = $this->mongo_db
            ->get('ref_506_groups');

        $group = array();

        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->name = $r['name'];
            $obj->code = $r['export_code'];

            $group[] = $obj;
        }

        return $group;
    }
    public function get_organism($code506)
    {
        $rs = $this->mongo_db
            ->where(array('code506' => $code506))
            ->get('ref_506_organisms');

        $org = array();

        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->name = $r['name'];
            $obj->code = $r['export_code'];

            $org[] = $obj;
        }

        return $org;
    }
    public function get_complication()
    {
        $rs = $this->mongo_db
            ->get('ref_506_complications');

        $rows = array();

        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->name = $r['name'];
            $obj->code = $r['export_code'];

            $rows[] = $obj;
        }

        return $rows;
    }
    public function get_syndromes()
    {
        $rs = $this->mongo_db
            ->get('ref_506_syndromes');

        $rows = array();

        foreach($rs as $r)
        {
            $obj = new stdClass();
            $obj->name = $r['name'];
            $obj->code = $r['export_code'];

            $rows[] = $obj;
        }

        return $rows;
    }

    public function get_visit_hn($vn)
    {
        $rs = $this->mongo_db
            ->select(array('hn'))
            ->where(array('vn' => (string) $vn))
            ->limit(1)
            ->get('visit');
        return $rs ? $rs[0]['hn'] : NULL;
    }

    public function get_detail($hn, $vn, $diagcode)
    {
        $rs = $this->mongo_db
            ->where(array(
                'hn' => (string) $hn,
                'vn' => (string) $vn,
                'diagcode' => $diagcode))
            ->limit(1)
            ->get('visit_surveillance');

        return $rs ? $rs[0] : NULL;
    }

    public function get_syndrome_name($id)
    {
        $rs = $this->mongo_db
            ->select(array('name'))
            ->where(array('_id' => new MongoId($id)))
            ->get('ref_506_syndromes');
        return $rs ? $rs[0]['name'] : '-';
    }
    public function get_code506_name($code506)
    {
        $rs = $this->mongo_db
            ->select(array('thainame'))
            ->where(array('code506' => (string) $code506))
            ->get('ref_506_code');
        return $rs ? $rs[0]['thainame'] : '-';
    }

    public function get_ptstatus_name($status)
    {
        if($status == '1') return 'หาย';
        else if($status == '2') return 'ตาย';
        else if($status == '3') return 'ยังรักษาอยู่';
        else if($status == '4') return 'ไม่ทราบ';
        else return '-';
    }

    public function check_exist($vn, $diagcode)
    {
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'diagcode' => $diagcode))
            ->count('visit_surveillance');

        return $rs > 0 ? TRUE : FALSE;
    }
    public function clear($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                'vn' => (string) $data['vn'],
                'diagcode' => $data['diag'],
                'hn' => (string) $data['hn']
            ))
            ->delete('visit_surveillance');

        return $rs ? TRUE : FALSE;
    }

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_surveillance', array(
                'hn' => $data['hn'],
                'vn' => $data['vn'],
                'syndrome' => $data['syndrome'],
                'diagcode' => $data['diagcode'],
                'code506' => $data['code506'],
                'illdate' => to_string_date($data['illdate']),
                'illhouse' => $data['illhouse'],
                'illvillage' => $data['illvillage'],
                'illtambon' => $data['illtambon'],
                'illampur' => $data['illampur'],
                'illchangwat' => $data['illchangwat'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'ptstatus' => $data['ptstatus'],
                'date_death' => to_string_date($data['date_death']),
                'complication' => $data['complication'],
                'organism' => $data['organism'],
                'school_class' => $data['school_class'],
                'school_name' => $data['school_name'],
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id)
            ));

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $data['vn'], 'diagcode' => $data['diagcode']))
            ->set(array(
                'hn' => $data['hn'],
                'vn' => $data['vn'],
                'syndrome' => $data['syndrome'],
                'diagcode' => $data['diagcode'],
                'code506' => $data['code506'],
                'illdate' => to_string_date($data['illdate']),
                'illhouse' => $data['illhouse'],
                'illvillage' => $data['illvillage'],
                'illtambon' => $data['illtambon'],
                'illampur' => $data['illampur'],
                'illchangwat' => $data['illchangwat'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'ptstatus' => $data['ptstatus'],
                'date_death' => to_string_date($data['date_death']),
                'complication' => $data['complication'],
                'organism' => $data['organism'],
                'school_class' => $data['school_class'],
                'school_name' => $data['school_name'],
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id)
            ))
            ->update('visit_surveillance');

        return $rs;
    }
}

//End of file