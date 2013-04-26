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

class Ncdscreen_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_list($start, $limit)
    {
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
            array(
                '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
            )))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->offset($start)
            ->limit($limit)
            ->order_by(array('first_name' => 'ASC'))
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->count('person');
        return $rs;
    }

    public function get_detail($year, $hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->get('ncdscreen');

        return count($rs) ? $rs[0] : NULL;
    }

    public function save($data)
    {

        $rs = $this->mongo_db
            ->insert('ncdscreen', array(

                'hn'    => $data['hn'],
                'year'  => $data['year'],

                'screen_date'       => to_string_date($data['screen_date']),
                'screen_time'       => $data['screen_time'],
                'screen_place'      => $data['screen_place'],
                'height'            => $data['height'],
                'weight'            => $data['weight'],
                'waistline'         => $data['waistline'],
                'bmi'               => $data['bmi'],

                'fm_dm'             => $data['fm_dm'],
                'fm_ht'             => $data['fm_ht'],
                'fm_gout'           => $data['fm_gout'],
                'fm_crf'            => $data['fm_crf'],
                'fm_mi'             => $data['fm_mi'],
                'fm_copd'           => $data['fm_copd'],
                'fm_stroke'         => $data['fm_stroke'],
                'fm_not_know'       => $data['fm_not_know'],
                'fm_no'             => $data['fm_no'],
                'fm_other'          => $data['fm_other'],
                'fm_other_detail'   => $data['fm_other_detail'],

                'sb_dm'             => $data['sb_dm'],
                'sb_ht'             => $data['sb_ht'],
                'sb_gout'           => $data['sb_gout'],
                'sb_crf'            => $data['sb_crf'],
                'sb_mi'             => $data['sb_mi'],
                'sb_copd'           => $data['sb_copd'],
                'sb_stroke'         => $data['sb_stroke'],
                'sb_not_know'       => $data['sb_not_know'],
                'sb_no'             => $data['sb_no'],
                'sb_other'          => $data['sb_other'],
                'sb_other_detail'   => $data['sb_other_detail'],

                'dm_history' => $data['dm_history'],
                'ht_history' => $data['ht_history'],
                'lv_history' => $data['lv_history'],
                'ds_history' => $data['ds_history'],
                'hb_history' => $data['hb_history'],
                'lb_history' => $data['lb_history'],
                'lg_history' => $data['lg_history'],
                'bb_history' => $data['bb_history'],
                'wt_history' => $data['wt_history'],
                'ur_history' => $data['ur_history'],
                'et_history' => $data['et_history'],
                'we_history' => $data['we_history'],
                'mo_history' => $data['mo_history'],
                'sk_history' => $data['sk_history'],
                'ey_history' => $data['ey_history'],
                'fg_history' => $data['fg_history'],
                'status_history'=> $data['status_history'],

                'smoke'         => $data['smoke'],
                'smoke_qty'     => $data['smoke_qty'],
                'smoke_type'    => $data['smoke_type'],
                'smoke_year'    => $data['smoke_year'],
                'smoked_type'   => $data['smoked_type'],
                'smoked_year'   => $data['smoked_year'],

                'drink'             => $data['drink'],
                'drink_qty'         => $data['drink_qty'],
                'food_taste_sweet'  => $data['food_taste_sweet'],
                'food_taste_salt'   => $data['food_taste_salt'],
                'food_taste_creamy' => $data['food_taste_creamy'],
                'food_taste_no'     => $data['food_taste_no'],

                'screen_tb' => $data['screen_tb'],

                'sbp1'  => $data['sbp1'],
                'dbp1'  => $data['dbp1'],
                'sbp2'  => $data['sbp2'],
                'dbp2'  => $data['dbp2'],
                'sbp3'  => $data['sbp3'],
                'dbp3'  => $data['dbp3'],
                'fbs'   => $data['fbs'],
                'blood_sugar' => $data['blood_sugar'],

                'risk_meta'         => $data['risk_meta'],
                'risk_meta_dm'      => $data['risk_meta_dm'],
                'risk_meta_ht'      => $data['risk_meta_ht'],
                'risk_meta_stroke'  => $data['risk_meta_stroke'],
                'risk_meta_obesity' => $data['risk_meta_obesity'],

                'risk_ncd'          => $data['risk_ncd'],
                'risk_ncd_dm'       => $data['risk_ncd'],
                'risk_ncd_ht'       => $data['risk_ncd'],
                'risk_ncd_stroke'   => $data['risk_ncd'],
                'risk_ncd_obesity'  => $data['risk_ncd'],

                'risk_disb' => $data['risk_disb'],

                'user_id'       => new MongoId($this->user_id),
                'owner_id'      => new MongoId($this->owner_id),
                'last_update'   => date('Y-m-d H:i:s')
            ));

        return $rs;
    }
    public function update($data)
    {
        $rs = $this->mongo_db
            ->set(array(

                'screen_date'   => to_string_date($data['screen_date']),
                'screen_time'   => $data['screen_time'],
                'screen_place'  => $data['screen_place'],
                'height'        => $data['height'],
                'weight'        => $data['weight'],
                'waistline'     => $data['waistline'],
                'bmi'           => $data['bmi'],

                'fm_dm'         => $data['fm_dm'],
                'fm_ht'         => $data['fm_ht'],
                'fm_gout'       => $data['fm_gout'],
                'fm_crf'        => $data['fm_crf'],
                'fm_mi'         => $data['fm_mi'],
                'fm_copd'       => $data['fm_copd'],
                'fm_stroke'     => $data['fm_stroke'],
                'fm_not_know'       => $data['fm_not_know'],
                'fm_no'             => $data['fm_no'],
                'fm_other'          => $data['fm_other'],
                'fm_other_detail'   => $data['fm_other_detail'],

                'sb_dm'             => $data['sb_dm'],
                'sb_ht'             => $data['sb_ht'],
                'sb_gout'           => $data['sb_gout'],
                'sb_crf'            => $data['sb_crf'],
                'sb_mi'             => $data['sb_mi'],
                'sb_copd'           => $data['sb_copd'],
                'sb_stroke'         => $data['sb_stroke'],
                'sb_not_know'       => $data['sb_not_know'],
                'sb_no'             => $data['sb_no'],
                'sb_other'          => $data['sb_other'],
                'sb_other_detail'   => $data['sb_other_detail'],

                'dm_history' => $data['dm_history'],
                'ht_history' => $data['ht_history'],
                'lv_history' => $data['lv_history'],
                'ds_history' => $data['ds_history'],
                'hb_history' => $data['hb_history'],
                'lb_history' => $data['lb_history'],
                'lg_history' => $data['lg_history'],
                'bb_history' => $data['bb_history'],
                'wt_history' => $data['wt_history'],
                'ur_history' => $data['ur_history'],
                'et_history' => $data['et_history'],
                'we_history' => $data['we_history'],
                'mo_history' => $data['mo_history'],
                'sk_history' => $data['sk_history'],
                'ey_history' => $data['ey_history'],
                'fg_history' => $data['fg_history'],
                'status_history' => $data['status_history'],

                'smoke'         => $data['smoke'],
                'smoke_qty'     => $data['smoke_qty'],
                'smoke_type'    => $data['smoke_type'],
                'smoke_year'    => $data['smoke_year'],
                'smoked_type'   => $data['smoked_type'],
                'smoked_year'   => $data['smoked_year'],

                'drink'             => $data['drink'],
                'drink_qty'         => $data['drink_qty'],
                'food_taste_sweet'  => $data['food_taste_sweet'],
                'food_taste_salt'   => $data['food_taste_salt'],
                'food_taste_creamy' => $data['food_taste_creamy'],
                'food_taste_no'     => $data['food_taste_no'],

                'screen_tb' => $data['screen_tb'],

                'sbp1'  => $data['sbp1'],
                'dbp1'  => $data['dbp1'],
                'sbp2'  => $data['sbp2'],
                'dbp2'  => $data['dbp2'],
                'sbp3'  => $data['sbp3'],
                'dbp3'  => $data['dbp3'],
                'fbs'   => $data['fbs'],
                'blood_sugar' => $data['blood_sugar'],

                'risk_meta'         => $data['risk_meta'],
                'risk_meta_dm'      => $data['risk_meta_dm'],
                'risk_meta_ht'      => $data['risk_meta_ht'],
                'risk_meta_stroke'  => $data['risk_meta_stroke'],
                'risk_meta_obesity' => $data['risk_meta_obesity'],

                'risk_ncd'          => $data['risk_ncd'],
                'risk_ncd_dm'       => $data['risk_ncd'],
                'risk_ncd_ht'       => $data['risk_ncd'],
                'risk_ncd_stroke'   => $data['risk_ncd'],
                'risk_ncd_obesity'  => $data['risk_ncd'],

                'risk_disb' => $data['risk_disb'],

                'user_id'       => new MongoId($this->user_id),
                'last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('ncdscreen');

        return $rs;
    }

    public function check_exist($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->count('ncdscreen');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function clear($hn, $year)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'year' => (string) $year))
            ->delete('ncdscreen');

        return $rs;
    }

    /**
     * @param   array   $house_id
     * @param   string  $year
     * @return  mixed
     */
    public function search_filter($house_id, $start, $limit)
    {
        $this->mongo_db->add_index('person', array('owner_id' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('house_code' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_in('house_code', $house_id)
            ->offset($start)
            ->limit($limit)
            ->order_by(array('first_name' => 'ASC'))
            ->get('person');
        return $rs;
    }

    public function search($hn)
    {
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where('hn', (string) $hn)
            ->get('person');
        return $rs;
    }

    public function search_filter_total($house_id)
    {
        $this->mongo_db->add_index('person', array('owner_id' => -1));
        $this->mongo_db->add_index('person', array('typearea' => -1));
        $this->mongo_db->add_index('person', array('birthdate' => -1));
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->where_lte('birthdate', (string) ((int) date('Y') - 15).'1231')
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_in('house_code', $house_id)
            ->count('person');
        return $rs;
    }

    public function get_house_list($village_id)
    {
        $this->mongo_db->add_index('houses', array('village_id' => -1));
        $rs = $this->mongo_db
            ->select(array('_id'))
            ->where(array('village_id' => new MongoId($village_id)))
            ->get('houses');

        return $rs;
    }

    public function get_result_total($year)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), 'year' => (string) $year))
            ->count('ncdscreen');

        return $rs;
    }

}

//End of file