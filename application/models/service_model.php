<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model
 *
 * Model information information
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Service_model extends CI_Model
{
    public $owner_id;
    public $user_id;

    public function search_person_by_name($query)
    {
        $rs = $this->mongo_db
            ->select(array('first_name', 'last_name', 'cid', 'hn', 'sex', 'birthdate'))
            ->like('first_name', $query)
            ->limit(10)
            ->get('person');
        return $rs;
    }
    public function search_person_by_cid($query)
    {
        $rs = $this->mongo_db
            ->select(array('first_name', 'last_name', 'cid', 'hn', 'sex', 'birthdate'))
            ->where('cid', $query)
            ->limit(10)
            ->get('person');
        return $rs;
    }
    public function search_person_by_hn($query)
    {
        $rs = $this->mongo_db
            ->select(array('first_name', 'last_name', 'cid', 'hn', 'sex', 'birthdate'))
            ->where('hn', $query)
            ->limit(10)
            ->get('person');
        return $rs;
    }

    public function get_person_detail($hn){
        $rs = $this->mongo_db
            ->select(array('first_name', 'last_name', 'cid', 'hn', 'sex', 'birthdate', 'house_code'))
            ->where('hn', $hn)
            ->limit(1)
            ->get('person');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    /*
     * items.person_id = $('#txt_person_id').val();
        items.vn = $('#txt_service_vn').val();
        items.date_serv = $('#txt_reg_service_date').val();
        items.time_serv = $('#txt_reg_service_time').val();
        items.clinic = $('#sl_reg_service_clinic').val();
        items.doctor_room = $('#sl_reg_service_doctor_room').val();
        items.patient_type = $('#sl_reg_service_pttype').val();
        items.location = $('#sl_reg_service_location').val();
        items.type_in = $('#sl_reg_service_typein').val();
        items.service_place = $('#sl_reg_service_service_place').val();
        items.insc_id = $('#sl_reg_service_insc').val();
        items.insc_code = $('#sl_reg_service_insc').val();
        items.insc_start_date = $('#txt_reg_service_insc_start_date').val();
        items.insc_expire_date = $('#txt_reg_service_insc_expire_date').val();
        items.insc_hosp_main = $('#txt_reg_service_insc_hosp_main_code').val();
        items.insc_hosp_sub = $('#txt_reg_service_insc_hosp_sub_code').val();

     */
    public function do_register($data){
        $rs = $this->mongo_db
            ->insert('visit', array(
                    'owner_id' => new MongoId($this->owner_id),
                    'person_id' => new MongoId($data['person_id']),
                    'vn' => $data['vn'],
                    'date_serv' => to_string_date($data['date_serv']),
                    'time_serv' => $data['time_serv'],
                    'clinic' => new MongoId($data['clinic']),
                    'doctor_room' => new MongoId($data['doctor_room']),
                    'patient_type' => $data['patient_type'],
                    'location' => $data['location'],
                    'type_in' => $data['type_in'],
                    'service_place' => $data['service_place'],
                    'screenings' => array(
                        'cc' => $data['cc']
                    ),
                    'insurances' => array(
                                        'id' => $data['insc_id'],
                                        'code' => $data['insc_code'],
                                        'start_date' => to_string_date($data['insc_start_date']),
                                        'expire_date' => to_string_date($data['insc_expire_date']),
                                        'hosp_main' => $data['insc_hosp_main'],
                                        'hosp_sub' => $data['insc_hosp_sub']
                                    ),
                    'user_id' => new MongoId($this->user_id)
                 ));

        return $rs;
    }

    public function do_update($data){

    }

    public function get_list_by_date($date, $offset, $limit){
        $rs = $this->mongo_db
            ->where('date_serv', $date)
            ->offset($offset)
            ->limit($limit)
            ->get('visit');

        return $rs;

    }

    public function get_service_screening($vn){
        $result = $this->mongo_db
            ->select(array('screenings'))
            ->where(array('vn' => (string) $vn))
            ->get('visit');

        return count($result) > 0 ? $result[0]['screenings'] : NULL;
    }

    public function get_person_id($vn){
        $result = $this->mongo_db
            ->select(array('person_id'))
            ->where(array('vn' => $vn))
            ->get('visit');

        return count($result) > 0 ? get_first_object($result[0]['person_id']) : NULL;
    }

    public function check_visit_exist($vn){
        $rs = $this->mongo_db
            ->where('vn', $vn)
            ->count('visit');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save_screening($data){
        $rs = $this->mongo_db
            ->where('vn', $data['vn'])
            ->set(array(
                'screenings.cc' => $data['cc'],
                'screenings.pe' => $data['pe'],
                'screenings.body_tmp' => (float) $data['body_tmp'],
                'screenings.breathe' => (float) $data['breathe'],
                'screenings.dbp' => (float) $data['dbp'],
                'screenings.sbp' => (float) $data['sbp'],
                'screenings.height' => (float) $data['height'],
                'screenings.weight' => (float) $data['weight'],
                'screenings.waist' => (float) $data['waist'],
                'screenings.pluse' => (float) $data['pluse'],
                'screenings.ill_history' => $data['ill_history'],
                'screenings.ill_history_ill_detail' => $data['ill_history_ill_detail'],
                'screenings.operate' => $data['operate'],
                'screenings.operate_year' => $data['operate_year'],
                'screenings.operate_detail' => $data['operate_detail'],
                'screenings.smoking' => new MongoId($data['smoking']),
                'screenings.drinking' => new MongoId($data['drinking']),
                //สุขภาพจิต
                'screenings.mind_strain' => $data['mind_strain'],
                'screenings.mind_work' => $data['mind_work'],
                'screenings.mind_family' => $data['mind_family'],
                'screenings.mind_other' => $data['mind_other'],
                'screenings.mind_other_detail' => $data['mind_other_detail'],
                //ความเสี่ยง
                'screenings.risk_ht' => $data['risk_ht'],
                'screenings.risk_dm' => $data['risk_dm'],
                'screenings.risk_stoke' => $data['risk_stoke'],
                'screenings.risk_other' => $data['risk_other'],
                'screenings.risk_other_detail' => $data['risk_other_detail'],
                //lmp
                'screenings.lmp' => $data['lmp'],
                'screenings.lmp_start' => to_string_date($data['lmp_start']),
                'screenings.lmp_finished' => to_string_date($data['lmp_finished']),
                //consult
                'screenings.consult_drug' => $data['consult_drug'],
                'screenings.consult_activity' => $data['consult_activity'],
                'screenings.consult_food' => $data['consult_food'],
                'screenings.consult_appoint' => $data['consult_appoint'],
                'screenings.consult_exercise' => $data['consult_exercise'],
                'screenings.consult_complication' => $data['consult_complication'],
                'screenings.consult_other' => $data['consult_other'],
                'screenings.consult_other_detail' => $data['consult_other_detail'],
            ))
            ->update('visit');

        return $rs;
    }

    public function get_screening($vn){
        $rs = $this->mongo_db
            ->select(array('screenings'))
            ->where('vn', $vn)
            ->get('visit');

        if(isset($rs[0]['screenings'])){
            $obj = new stdClass();

            $obj->cc = isset($rs[0]['screenings']['cc']) ? $rs[0]['screenings']['cc'] : '';
            $obj->pe = isset($rs[0]['screenings']['pe']) ? $rs[0]['screenings']['pe'] : '';
            $obj->body_tmp = isset($rs[0]['screenings']['body_tmp']) ? $rs[0]['screenings']['body_tmp'] : 0;
            $obj->breathe = isset($rs[0]['screenings']['breathe']) ? $rs[0]['screenings']['breathe'] : 0;
            $obj->dbp = isset($rs[0]['screenings']['dbp']) ? $rs[0]['screenings']['dbp'] : 0;
            $obj->sbp = isset($rs[0]['screenings']['sbp']) ? $rs[0]['screenings']['sbp'] : 0;
            $obj->height = isset($rs[0]['screenings']['height']) ? $rs[0]['screenings']['height'] : 0;
            $obj->weight = isset($rs[0]['screenings']['weight']) ? $rs[0]['screenings']['weight'] : 0;
            $obj->waist = isset($rs[0]['screenings']['waist']) ? $rs[0]['screenings']['waist'] : 0;
            $obj->pluse = isset($rs[0]['screenings']['pluse']) ? $rs[0]['screenings']['pluse'] : 0;
            $obj->ill_history = isset($rs[0]['screenings']['ill_history']) ? $rs[0]['screenings']['ill_history'] : 0;
            $obj->ill_history_ill_detail = isset($rs[0]['screenings']['ill_history_ill_detail']) ? $rs[0]['screenings']['ill_history_ill_detail'] : '';
            $obj->operate = isset($rs[0]['screenings']['operate']) ?  $rs[0]['screenings']['operate'] : 0;
            $obj->operate_detail = isset($rs[0]['screenings']['operate_detail']) ?  $rs[0]['screenings']['operate_detail'] : '';
            $obj->operate_year = isset($rs[0]['screenings']['operate_year']) ?  $rs[0]['screenings']['operate_year'] : '';
            //other screening
            $obj->drinking = isset($rs[0]['screenings']['drinking']) ? get_first_object($rs[0]['screenings']['drinking']) : '';
            $obj->smoking = isset($rs[0]['screenings']['smoking']) ? get_first_object($rs[0]['screenings']['smoking']) : '';
            $obj->mind_strain = isset($rs[0]['screenings']['mind_strain']) ? $rs[0]['screenings']['mind_strain'] : '';
            $obj->mind_work = isset($rs[0]['screenings']['mind_work']) ? $rs[0]['screenings']['mind_work'] : '';
            $obj->mind_family = isset($rs[0]['screenings']['mind_family']) ? $rs[0]['screenings']['mind_family'] : '';
            $obj->mind_other = isset($rs[0]['screenings']['mind_other']) ? $rs[0]['screenings']['mind_other'] : '';
            $obj->mind_other_detail = isset($rs[0]['screenings']['mind_other_detail']) ? $rs[0]['screenings']['mind_other_detail'] : '';
            $obj->risk_ht = isset($rs[0]['screenings']['risk_ht']) ? $rs[0]['screenings']['risk_ht'] : '';
            $obj->risk_dm = isset($rs[0]['screenings']['risk_dm']) ? $rs[0]['screenings']['risk_dm'] : '';
            $obj->risk_stoke = isset($rs[0]['screenings']['risk_stoke']) ? $rs[0]['screenings']['risk_stoke'] : '';
            $obj->risk_other = isset($rs[0]['screenings']['risk_other']) ? $rs[0]['screenings']['risk_other'] : '';
            $obj->risk_other_detail = isset($rs[0]['screenings']['risk_other_detail']) ? $rs[0]['screenings']['risk_other_detail'] : '';

            //lmp

            $obj->lmp = isset($rs[0]['screenings']['lmp']) ? $rs[0]['screenings']['lmp'] : '';
            $obj->lmp_start = isset($rs[0]['screenings']['lmp_start']) ? $rs[0]['screenings']['lmp_start'] : '';
            $obj->lmp_finished = isset($rs[0]['screenings']['lmp_finished']) ? $rs[0]['screenings']['lmp_finished'] : '';

            //consult
            $obj->consult_drug = isset($rs[0]['screenings']['consult_drug']) ? $rs[0]['screenings']['consult_drug'] : '';
            $obj->consult_activity = isset($rs[0]['screenings']['consult_activity']) ? $rs[0]['screenings']['consult_activity'] : '';
            $obj->consult_appoint = isset($rs[0]['screenings']['consult_appoint']) ? $rs[0]['screenings']['consult_appoint'] : '';
            $obj->consult_complication = isset($rs[0]['screenings']['consult_complication']) ? $rs[0]['screenings']['consult_complication'] : '';
            $obj->consult_exercise = isset($rs[0]['screenings']['consult_exercise']) ? $rs[0]['screenings']['consult_exercise'] : '';
            $obj->consult_food = isset($rs[0]['screenings']['consult_food']) ? $rs[0]['screenings']['consult_food'] : '';
            $obj->consult_other = isset($rs[0]['screenings']['consult_other']) ? $rs[0]['screenings']['consult_other'] : '';
            $obj->consult_other_detail = isset($rs[0]['screenings']['consult_other_detail']) ? $rs[0]['screenings']['consult_other_detail'] : '';

            return $obj;
        }else{
            $obj = new stdClass();
            return $obj;
        }
    }

    public function check_principle_opd_exist($vn){
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'diag_type' => '1'))
            ->count('diagnosis_opd');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function check_diag_opd_exist($vn, $diag_code){
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'code' => $diag_code))
            ->count('diagnosis_opd');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function save_diag_opd($data){
        $rs = $this->mongo_db
            ->insert('diagnosis_opd', array(
                'vn' => (string) $data['vn'],
                'code' => $data['code'],
                'diag_type' => $data['diag_type']
            ));
        return $rs;
    }

    public function get_service_diag_opd($vn){
        $rs = $this->mongo_db
            ->order_by(array('diag_type' => 'ASC'))
            ->where('vn', (string) $vn)
            ->get('diagnosis_opd');
        return $rs;
    }

    public function remove_diag_opd($vn, $diag_code){
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'code' => $diag_code))
            ->delete('diagnosis_opd');
        return $rs;
    }


    public function  save_proced_opd($data){
        $rs = $this->mongo_db
            ->insert('procedures_opd', array(
            'code' => $data['code'],
            'price' => (float) $data['price'],
            'provider' => (string) $data['provider'],
            'vn' => (string) $data['vn']
        ));
        return $rs;
    }


    public function check_duplicate_opd_proced($vn, $code){
        $rs = $this->mongo_db
            ->where(array('vn' => $vn, 'code' => $code))
            ->count('procedures_opd');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_service_proced_opd($vn){
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn))
            ->get('procedures_opd');
        return $rs;
    }

    public function remove_proced_opd($vn, $code){
        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'code' => (string) $code))
            ->delete('procedures_opd');
        return $rs;
    }

    public function update_opd_proced($data){
        $rs = $this->mongo_db
            ->where('vn', $data['vn'])
            ->set(array(
            'price' => $data['price'],
            'provider' => $data['provider'],
        ))
            ->update('procedures_opd');

        return $rs;
    }

    ####################### Drug modules #######################

    /*
     * Save drug items
     *
     * @param  array   $data
     * @retrun  boolean
     */
    public function  save_drug_opd($data){
        $rs = $this->mongo_db
            ->insert('drugs_opd', array(
            'vn' => (string) $data['vn'],
            'drug_id' => new MongoId($data['drug_id']),
            'usage_id' => new MongoId($data['usage_id']),
            'price' => (float) $data['price'],
            'qty' => (int) $data['qty'],
            'provider_id' => new MongoId($data['provider_id'])
        ));
        return $rs;
    }
    /*
     * Update drug item
     *
     * @param   array   $data
     */
    public function update_drug_opd($data){
        $rs = $this->mongo_db
            ->where(array('vn' => $data['vn'], 'drug_id' => new MongoId($data['drug_id'])))
            ->set(array(
                'qty' => (float) $data['qty'],
                'price' => (float) $data['price']
            ))->update('drugs_opd');
        return $rs;
    }

    /*
     * Remove drug
     */
    public function remove_drug_opd($id){
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->delete('drugs_opd');
        return $rs;
    }
    /*
     * Check duplicate drug
     *
     * @param   string      $vn The visit number
     * @param   ObjectId    $drug_id    The drug id
     *
     * @return  boolean TRHE if duplicate, else is FALSE
     */

    public function check_drug_duplicate($vn, $drug_id){
        $this->mongo_db->add_index('drugs_opd', array('vn' => -1));
        $this->mongo_db->add_index('drugs_opd', array('drug_id' => -1));

        $rs = $this->mongo_db
            ->where(array('vn' => (string) $vn, 'drug_id' => new MongoId($drug_id)))
            ->count('drugs_opd');
        return $rs > 0 ? TRUE : FALSE;
    }

    /*
     * Get drug list
     *
     * @param  string  $vn The visit number
     * @retrun  array
     */
    public function get_drug_list($vn){

        $this->mongo_db->add_index('drugs_opd', array('vn' => -1));

        $rs = $this->mongo_db
            ->where('vn',(string) $vn)
            ->get('drugs_opd');

        return $rs;
    }
}

/* End of file service_model.php */
/* Location: ./models/service_model.php */