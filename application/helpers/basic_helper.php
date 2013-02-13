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


if(!function_exists('get_provider_name')){
	function get_provider_name($code){
		$ci =& get_instance();

		$ci->load->model('Basic_model', 'basic');

		$result = $ci->basic->get_provider_name($code);

		return $result;
	}
}

if(!function_exists('get_owner_name')){
	function get_owner_name($id){
		$ci =& get_instance();

		$ci->load->model('Basic_model', 'basic');

		$pcucode = $ci->basic->get_owner_pcucode($id);
		

		return $pcucode ? get_hospital_name($pcucode) : '-';
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

if(!function_exists('get_charge_name')){
    function get_charge_name($code){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_charge_name($code);

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
if(!function_exists('get_pp_special_name')){
    function get_pp_special_name($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_pp_special_name($id);

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

if(!function_exists('get_provider_name_by_id')){
    function get_provider_name_by_id($id){
        $ci =& get_instance();

        $ci->load->model('Basic_model', 'basic');

        $result = $ci->basic->get_provider_name_by_id($id);

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

if(!function_exists('get_appoint_type')){
	function get_appoint_type(){
		$ci =& get_instance();
		$ci->load->model('Basic_model', 'basic');
		$rs = $ci->basic->get_appoint_type();
		
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


if(!function_exists('get_appoint_type_name')){
	function get_appoint_type_name($id){
		$ci =& get_instance();

		$ci->load->model('Basic_model', 'basic');

		$result = $ci->basic->get_appoint_type_name($id);

		return $result;
	}
}


if(!function_exists('get_fp_type_name'))
{
	function get_fp_type_name($code){
		$ci =& get_instance();

		$ci->load->model('Basic_model', 'basic');

		$result = $ci->basic->get_fp_type_name($code);

		return $result;
	}
}
if(!function_exists('get_vaccine_name'))
{
	function get_vaccine_name($vaccine_id)
    {
		$ci =& get_instance();

		$ci->load->model('Basic_model', 'basic');

		$result = $ci->basic->get_vaccine_name($vaccine_id);

		return $result;
	}
}

if(!function_exists('get_pp_special_list'))
{
    function get_pp_special_list()
    {
        $ci =& get_instance();
        $ci->load->model('Basic_model', 'basic');

        $rs = $ci->basic->get_pp_special_list();

        return $rs;
    }
}

if(!function_exists('get_bresult_name'))
{
    function get_bresult_name($code)
    {
        switch($code)
        {
            case '1': return 'ปกติ'; break;
            case '2': return 'ผิดปกติ'; break;
            case '9': return 'ไม่ทราบ'; break;
            default: return '-'; break;
        }
    }
}
if(!function_exists('get_bfood_name'))
{
    function get_bfood_name($code)
    {
        switch($code)
        {
            case '1': return 'นมแม่อย่างเดียว'; break;
            case '2': return 'นมแม่และน้ำ'; break;
            case '3': return 'นมแม่และนมผสม'; break;
            case '4': return 'นมผสมอย่างเดียว'; break;
            default: return '-'; break;
        }
    }
}


