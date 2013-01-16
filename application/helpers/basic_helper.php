<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Basic helper
 *
 * Get or Convert id to readable value
 *
 * @package     File
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

if(!function_exists('get_fstatus_name')){
    function get_fstatus_name($id = '1'){
        return $id == '1' ? 'เจ้าบ้าน' : 'ผู้อาศัย';
    }

}
if(!function_exists('to_js_date')){
    function to_js_date($date = ''){
        if(strlen($date) == 8){
            $y = substr($date, 0, 4);
            $m = substr($date, 4, 2);
            $d = substr($date, 6, 2);

            $new_date = $d . '/' . $m . '/' . $y;
            return $new_date;

        }else{
            return '';
        }
    }
}

if(!function_exists('get_ampur')){
    function get_ampur($chw){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_ampur($chw);

        return $result;
    }
}

if(!function_exists('get_title_name')){
    function get_title_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_title_name($id);

        return $result;
    }
}
if(!function_exists('get_provider_type_name')){
    function get_provider_type_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_provider_type_name($id);

        return $result;
    }
}

if(!function_exists('get_streng_name')){
    function get_streng_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_streng_name($code);

        return $result;
    }
}

if(!function_exists('get_drug_name')){
    function get_drug_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_drug_name($id);

        return $result;
    }
}

if(!function_exists('get_usage_name')){
    function get_usage_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_usage_name($id);

        return $result;
    }
}

if(!function_exists('get_symptom_name')){
    function get_symptom_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_symptom_name($id);

        return $result;
    }
}

if(!function_exists('get_informant_name')){
    function get_informant_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_informant_name($id);

        return $result;
    }
}
if(!function_exists('get_diag_name')){
    function get_diag_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_diag_name($code);

        return $result;
    }
}
if(!function_exists('get_diag_type_name')){
    function get_diag_type_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_diag_type_name($code);

        return $result;
    }
}
if(!function_exists('get_provider_name')){
    function get_provider_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_provider_name($code);

        return $result;
    }
}
if(!function_exists('get_procedure_name')){
    function get_procedure_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_procedure_name($code);

        return $result;
    }
}
if(!function_exists('get_chronic_discharge_type_name')){
    function get_chronic_discharge_type_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_chronic_discharge_type_name($id);

        return $result;
    }
}
if(!function_exists('get_drug_allergy_diag_type_name')){
    function get_drug_allergy_diag_type_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_drug_allergy_diag_type_name($id);

        return $result;
    }
}
if(!function_exists('get_drug_allergy_level_name')){
    function get_drug_allergy_level_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_drug_allergy_level_name($id);

        return $result;
    }
}
/**
 * Check empty value
 *
 * @param   $v
 * @return  Value if true, NULL if false
 */
if(!function_exists('check_key_exist')){
    function check_key_exist($v){
        return isset($v) ? $v : NULL;
    }
}

if(!function_exists('check_empty')){
    function check_empty($v){
        return !empty($v) ? $v : NULL;
    }
}

if(!function_exists('get_drug_allergy_in_array')){
    function get_drug_allergy_in_array($drugallergy, $drug_id){
        foreach($drugallergy as $r){
            if($r['drug_id'] == $drug_id){
                return $r;
            }
        }
        return NULL;
    }
}
/*
 * Get address
 *
 * @param   $hn
 * @return  string  Address
 */
if(!function_exists('get_address')){
    function get_address($hn){

        /*
         * 1. get house detail: house, village_id
         * 2. get village_code
         * 3. return address
         */
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $house_code = get_first_object($ci->basic->get_house_code($hn));

        $houses = $ci->basic->get_house_detail($house_code);
        $village_id = $houses['village_id'];

        $villages = $ci->basic->get_village_detail($village_id);

        $village_code = $villages['village_code'];
        //44010106
        $chw = substr($village_code, 0, 2);
        $amp = substr($village_code, 2, 2);
        $tmb = substr($village_code, 4, 2);
        $moo = substr($village_code, 6, 2);

        $chw_name = $ci->basic->get_province_name($chw);
        $amp_name = $ci->basic->get_ampur_name($chw, $amp);
        $tmb_name = $ci->basic->get_tambon_name($chw, $amp, $tmb);

        $address = $houses['house'];

        $address_name = $address . ' หมู่ ' . $moo . ' ต.' . $tmb_name . ' อ.' . $amp_name . ' จ.' . $chw_name;
        return $address_name;
        //return $house_code;
    }
}

if(!function_exists('get_clinic_name')){
    function get_clinic_name($id){
        $ci =& get_instance();
        $ci->load->model('Basic_model', 'basic');
        $result = $ci->basic->get_clinic_name($id);
        return $result;
    }
}

if(!function_exists('get_insurance_name')){
    function get_insurance_name($code){
        $ci =& get_instance();
        $ci->load->model('Basic_model', 'basic');
        $result = $ci->basic->get_insurance_name($code);
        return $result;
    }
}

