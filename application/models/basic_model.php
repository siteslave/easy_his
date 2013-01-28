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

class Basic_model extends CI_Model
{

    public function __construct(){
        parent::__construct();
    }
    public function get_insurance()
    {
        $result = $this->mongo_db
            ->order_by(array('code' => 1))
            ->get('ref_insurances');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['code'];
            $obj->name = $r['name'];
            //$obj->c = $r['inscl'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function search_drug_usage_by_alias($query)
    {
        $this->mongo_db->add_index('ref_drug_usages', array('alias_code' => -1));
        $this->mongo_db->add_index('ref_drug_usages', array('name1' => -1));

        $result = $this->mongo_db
            ->like('alias_code', $query)
            ->limit(50)
            ->get('ref_drug_usages');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->alias_code = $r['alias_code'];
            $obj->name1 = $r['name1'];
            $obj->name2 = $r['name2'];
            $obj->name3 = $r['name3'];
            $obj->id = get_first_object($r['_id']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }


    public function search_drug_usage_by_name($query)
    {
        $this->mongo_db->add_index('ref_drug_usages', array('alias_code' => -1));
        $this->mongo_db->add_index('ref_drug_usages', array('name1' => -1));

        $result = $this->mongo_db
            ->like('name1', $query)
            ->limit(50)
            ->get('ref_drug_usages');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->alias_code = $r['alias_code'];
            $obj->name1 = $r['name1'];
            $obj->name2 = $r['name2'];
            $obj->name2 = $r['name3'];
            $obj->id = get_first_object($r['_id']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_occupation()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_occupations');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_labor_type()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_labor_types');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_title()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_titles');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_marry_status()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_marry_status');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_education()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_educations');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_vstatus()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_vstatus');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_house_type()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_house_types');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_typearea()
    {
        $result = $this->mongo_db->order_by(array('code' => 1))->get('ref_typeareas');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['code'];
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_races()
    {
        $result = $this->mongo_db
            ->where(array('actived' => 'Y'))
            ->order_by(array('name' => 1))->get('ref_races');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_nationalities()
    {
        $result = $this->mongo_db
            ->where(array('actived' => 'Y'))
            ->order_by(array('name' => 1))->get('ref_nations');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_drinking()
    {
        $result = $this->mongo_db
            ->order_by(array('export_code' => 1))->get('ref_drinkings');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_smoking()
    {
        $result = $this->mongo_db
            ->order_by(array('export_code' => 1))->get('ref_smokings');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_religions()
    {
        $result = $this->mongo_db
            ->where(array('actived' => 'Y'))
            ->order_by(array('name' => 1))->get('ref_religions');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function search_hospital_by_name($query){

        $this->mongo_db->add_index('ref_hospitals', array('hospname' => -1));

        $result = $this->mongo_db
            ->like('hospname', $query)
            ->order_by(array('hospcode' => 1))
            ->limit(25)
            ->get('ref_hospitals');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function search_hospital_ajax_by_name($query){

        $this->mongo_db->add_index('ref_hospitals', array('hospname' => -1));

        $result = $this->mongo_db
            ->like('hospname', $query)
            ->order_by(array('hospcode' => 1))
            ->limit(25)
            ->get('ref_hospitals');

        $arr_result = array();

        foreach ($result as $r) {
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->fullname = $r['hospname'] . '#' . $r['hospcode'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function search_hospital_by_code($query){
        $this->mongo_db->add_index('ref_hospitals', array('hospcode' => -1));

        $result = $this->mongo_db
            ->order_by(array('hospcode' => 1))
            ->where(array('hospcode' => $query))
            ->get('ref_hospitals');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function search_hospital_ajax_by_code($query){
        $this->mongo_db->add_index('ref_hospitals', array('hospcode' => -1));

        $result = $this->mongo_db
            ->order_by(array('hospcode' => 1))
            ->where(array('hospcode' => $query))
            ->get('ref_hospitals');

        $arr_result = array();

        foreach ($result as $r) {
            $obj = new stdClass();
            $obj->code = $r['hospcode'];
            $obj->name = $r['hospname'];
            $obj->fullname = $r['hospname'] . '#' . $r['hospcode'];
            $obj->province = get_changwat($r['changwat']);

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_province(){
        $this->mongo_db->add_index('ref_provinces', array('code' => -1));

        $result = $this->mongo_db
            ->order_by(array('name' => 1))
            ->get('ref_provinces');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['code'];
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_provider_type(){

        $result = $this->mongo_db
        //->order_by(array('name' => 1))
            ->get('ref_provider_types');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_drug_allergy_diag_type(){

        //$this->mongo_db->add_index('ref_drug_allergy_type_diags', array('code' => -1));

        $result = $this->mongo_db
        //->order_by(array('name' => 1))
            ->get('ref_drug_allergy_diag_types');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_drug_allergy_alevel(){

        //$this->mongo_db->add_index('ref_drug_allergy_type_diags', array('code' => -1));

        $result = $this->mongo_db
        //->order_by(array('name' => 1))
            ->get('ref_drug_allergy_alevels');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_drug_allergy_symptom(){

        //$this->mongo_db->add_index('ref_drug_allergy_type_diags', array('code' => -1));

        $result = $this->mongo_db
        //->order_by(array('name' => 1))
            ->get('ref_drug_allergy_symptoms');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_chronic_discharge_type(){

        //$this->mongo_db->add_index('ref_drug_allergy_type_diags', array('code' => -1));

        $result = $this->mongo_db
            ->order_by(array('export_code' => 1))
            ->get('ref_chronic_discharge_types');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }


    public function get_doctor_room()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_doctor_rooms');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }
    public function get_clinic()
    {
        $result = $this->mongo_db->order_by(array('name' => 1))->get('ref_clinics');

        $arr_result = array();
        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }


    public function get_drug_allergy_informant(){

        //$this->mongo_db->add_index('ref_drug_allergy_type_diags', array('code' => -1));

        $result = $this->mongo_db
        //->order_by(array('name' => 1))
            ->get('ref_drug_allergy_informants');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->id = get_first_object($r['_id']);
            $obj->name = $r['name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_province_name($code){
        $result = $this->mongo_db->where(array('code' => $code))->get('ref_provinces');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }

    public function get_ampur($chw){
        $this->mongo_db->add_index('ref_catms', array('catm_code' => -1));
        $this->mongo_db->add_index('ref_catms', array('changwat' => -1));
        $this->mongo_db->add_index('ref_catms', array('ampur' => -1));
        $this->mongo_db->add_index('ref_catms', array('tambon' => -1));
        $this->mongo_db->add_index('ref_catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('tambon' => '00'))
            ->where(array('moo' => '00'))
            ->where_ne('ampur', '00')
            ->order_by(array('catm_name' => 1))
            ->get('ref_catms');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['ampur'];
            $obj->name = $r['catm_name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    public function get_ampur_name($chw, $amp){
        $this->mongo_db->add_index('ref_catms', array('catm_code' => -1));
        $this->mongo_db->add_index('ref_catms', array('changwat' => -1));
        $this->mongo_db->add_index('ref_catms', array('ampur' => -1));
        $this->mongo_db->add_index('ref_catms', array('tambon' => -1));
        $this->mongo_db->add_index('ref_catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('ampur' => $amp))
            ->where(array('tambon' => '00'))
            ->where(array('moo' => '00'))
            ->limit(1)
            ->get('ref_catms');

        return count($result) > 0 ? $result[0]['catm_name'] : '-';
    }
    public function get_tambon_name($chw, $amp, $tmb){
        $this->mongo_db->add_index('ref_catms', array('catm_code' => -1));
        $this->mongo_db->add_index('ref_catms', array('changwat' => -1));
        $this->mongo_db->add_index('ref_catms', array('ampur' => -1));
        $this->mongo_db->add_index('ref_catms', array('tambon' => -1));
        $this->mongo_db->add_index('ref_catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('tambon' => $tmb))
            ->where(array('moo' => '00'))
            ->where(array('ampur' => $amp))
            ->limit(1)
            ->get('ref_catms');

        return count($result) > 0 ? $result[0]['catm_name'] : '-';
    }

    public function get_tambon($chw, $amp){
        $this->mongo_db->add_index('ref_catms', array('catm_code' => -1));
        $this->mongo_db->add_index('ref_catms', array('changwat' => -1));
        $this->mongo_db->add_index('ref_catms', array('ampur' => -1));
        $this->mongo_db->add_index('ref_catms', array('tambon' => -1));
        $this->mongo_db->add_index('ref_catms', array('moo' => -1));

        $result = $this->mongo_db
            ->where(array('changwat' => $chw))
            ->where(array('ampur' => $amp))
            ->where_ne('tambon', '00')
            ->where(array('moo' => '00'))
            ->order_by(array('catm_name' => 1))
            ->get('ref_catms');

        $arr_result = array();

        foreach($result as $r){
            $obj = new stdClass();
            $obj->code = $r['tambon'];
            $obj->name = $r['catm_name'];

            array_push($arr_result, $obj);
        }

        return $arr_result;
    }

    /**
     * Get family status name
     *
     * @param $id   Family status code
     * @return string   Family status name
     */
    public function get_fstatus_name($id){
        return $id == '1' ? 'เจ้าบ้าน' : 'ผู้อาศัย';
    }

    public function get_title_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_titles');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_provider_type_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_provider_types');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }

    public function get_streng_name($code){
        $result = $this->mongo_db->where(array('code' => (string) $code))->get('ref_drug_strengs');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }

    public function get_drug_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drugs');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }

    public function get_usage_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drug_usages');

        return count($result) > 0 ? $result[0]['name1'] : '-';
    }

    public function get_charge_name($code){
        $result = $this->mongo_db->where(array('code' => $code))->get('ref_charge_items');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }


    public function get_clinic_name($id){
    	$result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_clinics');
    
    	return count($result) > 0 ? $result[0]['name'] : '-';
    }
    
    public function get_appoint_type_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_appoint_types');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    
    
    public function get_diag_name($code){
        $result = $this->mongo_db->where(array('code' => $code))->get('ref_icd10');

        return count($result) > 0 ? $result[0]['desc_r'] : '-';
    }
    public function get_insurance_name($code){
        $result = $this->mongo_db->where(array('code' => new MongoInt32($code)))->get('ref_insurances');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_symptom_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drug_allergy_symptoms');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_chronic_discharge_type_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_chronic_discharge_types');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }

    public function get_drug_allergy_diag_type_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drug_allergy_diag_types');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_drug_allergy_level_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drug_allergy_alevels');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_informant_name($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drug_allergy_informants');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_diag_type_name($code){
        $result = $this->mongo_db->where(array('code' => $code))->get('ref_diag_types');

        return count($result) > 0 ? $result[0]['name'] : '-';
    }
    public function get_procedure_name($code){
        $result = $this->mongo_db->where(array('code' => $code))->get('ref_icd9');

        return count($result) > 0 ? $result[0]['desc_r'] : '-';
    }

    public function get_provider_name_by_id($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('providers');

        if(count($result) > 0){
            $fullname = $result[0]['first_name'] . ' ' . $result[0]['last_name'];
            return $fullname;
        }else{
            return '-';
        }
    }

    public function get_provider_name($code){
    	$result = $this->mongo_db->where(array('provider' => (string) $code))->get('providers');
    
    	return $result ? $result[0]['first_name'] . ' ' . $result[0]['last_name'] : '-';
    }
    
    public function get_owner_pcucode($id){
    	$result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('owners');
    
    	return $result ? $result[0]['pcucode'] : '-';
    }
    
    
    public function get_drug_detail($id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($id)))->get('ref_drugs');

        if(count($result) > 0){
            $obj = new stdClass();
            $obj->stdcode = $result[0]['stdcode'];
            $obj->name = $result[0]['name'];
            $obj->unit = $result[0]['unit'];
            $obj->streng = get_streng_name($result[0]['streng_code']);
            $obj->price = $result[0]['price'];
            $obj->cost = $result[0]['cost'];

            return $obj;
        }else{
            $obj = new stdClass();
            return $obj;
        }


    }

    public function get_diag_type(){
        $result = $this->mongo_db
            ->order_by(array('code' => 'ASC'))
            ->get('ref_diag_types');
        
        $arr_result = array();
        foreach($result as $r){
        	$obj = new stdClass();
        	$obj->code = $r['code'];
        	$obj->name = $r['name'];
        
        	array_push($arr_result, $obj);
        }
        
        return $arr_result;
    }

    public function search_drug($query){
        $result = $this->mongo_db
            ->like('name', $query)
            ->limit(10)
            ->get('ref_drugs');
        return $result;
    }

    public function search_icd10_by_name($query){
        $result = $this->mongo_db
            ->like('desc_r', $query)
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }
    public function search_icd_chronic_by_name($query){
        $result = $this->mongo_db
            ->like('desc_r', $query)
            ->where(array('valid' => 'T', 'chronic' => 'Y'))
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }
    public function search_icd_by_name($query){
        $result = $this->mongo_db
            ->like('desc_r', $query)
            ->where(array('valid' => 'T'))
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }

    public function search_icd_chronic_by_code($query){
        $result = $this->mongo_db
            ->like('code', $query)
            ->where(array('valid' => 'T', 'chronic' => 'Y'))
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }

    public function search_procedure_by_code($query){
        $result = $this->mongo_db
            ->like('code', $query)
            ->where(array('valid_code' => 'T'))
            ->limit(10)
            ->get('ref_icd9');
        return $result;
    }

    public function search_procedure_by_name($query){
        $result = $this->mongo_db
            ->like('desc_r', $query)
            ->where(array('valid_code' => 'T'))
            ->limit(10)
            ->get('ref_icd9');
        return $result;
    }
    public function search_charge_item_ajax($query){
        $result = $this->mongo_db
            ->like('name', $query)
            ->where(array('active' => 'Y'))
            ->limit(10)
            ->get('ref_charge_items');
        return $result;
    }

    public function search_icd_by_code($query){
        $result = $this->mongo_db
            ->like('code', $query)
            ->where(array('valid' => 'T'))
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }

    public function search_icd10_by_code($query){
        $result = $this->mongo_db
            ->like('code', $query)
            ->limit(10)
            ->get('ref_icd10');
        return $result;
    }


    public function search_provider_by_code($query){
        $result = $this->mongo_db
            ->like('provider', $query)
            ->where(array('active' => 'Y'))
            ->limit(10)
            ->get('providers');
        return $result;
    }

    public function search_provider_by_name($query){
        $result = $this->mongo_db
            ->like('first_name', $query)
            ->where(array('active' => 'Y'))
            ->limit(10)
            ->get('providers');
        return $result;
    }

    public function get_house_detail($id){
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('houses');
        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function get_house_code($hn){
        $rs = $this->mongo_db
            ->select(array('house_code'))
            ->where('hn', $hn)
            ->get('person');

        return count($rs) > 0 ? $rs[0]['house_code'] : NULL;
    }

    public function get_village_detail($id)
    {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('villages');
        
        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function search_drug_ajax($query){
        $rs = $this->mongo_db
            ->like('name', $query)
            ->limit(25)
            ->get('ref_drugs');

        if(count($rs) > 0){
            $arr_result = array();

            foreach($rs as $r){
                $obj = new stdClass();
                $obj->name = $r['name'] . '#' . get_first_object($r['_id']);

                array_push($arr_result, $obj);
            }

            return $arr_result;

        }else{
            $obj = new stdClass();
            return $obj;
        }

    }


    public function get_appoint_type(){
    	$rs = $this->mongo_db->order_by(array('name' => -1))->get('ref_appoint_types');

    	$arr_result = array();
    	foreach($rs as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['name'];
    		$obj->desc = $r['desc'];
    	
    		array_push($arr_result, $obj);
    	}
    	
    	return $arr_result;
    }
    
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get Accident type
     */
    public function get_aetype()
    {
    	$result = $this->mongo_db->order_by(array('th_name' => 1))->get('ref_aetypes');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['th_name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get Accident place
    */
    public function get_aeplace()
    {
    	$result = $this->mongo_db->order_by(array('export_code' => 1))->get('ref_aeplaces');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get Accident type in
    */
    public function get_aetypein()
    {
    	$result = $this->mongo_db->order_by(array('export_code' => 1))->get('ref_aetypeins');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get Accident traffice
    */
    public function get_aetraffic()
    {
    	$result = $this->mongo_db->order_by(array('export_code' => 1))->get('ref_aetraffics');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get Accident vehicle
    */
    public function get_aevehicle()
    {
    	$result = $this->mongo_db->order_by(array('export_code' => 1))->get('ref_aevehicles');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->id = get_first_object($r['_id']);
    		$obj->name = $r['name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    
    //------------------------------------------------------------------------------------------------------------------
    /*
     * Get FP type
    */
    public function get_fp_type()
    {
    	$result = $this->mongo_db->order_by(array('code' => 1))->get('ref_fp_types');
    
    	$arr_result = array();
    	foreach($result as $r){
    		$obj = new stdClass();
    		$obj->code = $r['code'];
    		$obj->name = $r['name'];
    
    		array_push($arr_result, $obj);
    	}
    
    	return $arr_result;
    }
    
    public function get_fp_type_name($code){
    	$result = $this->mongo_db->where(array('code' => $code))->get('ref_fp_types');
    
    	return count($result) > 0 ? $result[0]['name'] : '-';
    }
    
    public function get_fp_type_sex($code)
    {
    	$rs = $this->mongo_db->where('code', (string) $code)->get('ref_fp_types');
    	return $rs ? $rs[0]['sex'] : NULL;
    }
    /**
     * Get person sex
     * @param 	string $hn
     * @return 	string
     */
    public function get_person_sex($hn)
    {
    	$rs = $this->mongo_db->select(array('sex'))
    						->where('hn', (string) $hn)
    						->get('person');
    	return $rs ? $rs[0]['sex'] : NULL;
    }
}
