<?php
/**
 * Main Helper function
 *
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0
 * @copyright   Copyright 2013 Maha Sarakham Hospital Information center.
 */

if(!function_exists('get_salt'))
{
    function get_salt()
    {
        $salt = '739a1fd7ec6923105c5435f068fad773';
        return $salt;
    }
}
if( ! function_exists('render_json')){
    function render_json($json){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo $json;
    }
}

if(!function_exists('to_string_date')){
    function to_string_date($date){
        if(empty($date)){
            return null;
        }else{
            $d = explode('/', $date);
            // $d[0] = d, $d[1] = m, $d[2] = y
            $new_date = (int)$d[2] - 543 . $d[1] . $d[0];
            return $new_date;
        }
    }
}

if(!function_exists('from_mongo_to_thai_date')){
	function from_mongo_to_thai_date($mongo_date){
		/*
		$year = parseInt(old_date.substr(0, 4).toString()) + 543,
		month = old_date.substr(4, 2).toString(),
		day = old_date.substr(6, 2).toString();
		
		var new_date = day + '/' + month + '/' + year;
		*/
		$year = (int) substr($mongo_date, 0, 4) + 543;
		$month = substr($mongo_date, 4, 2);
		$day = substr($mongo_date, 6, 2);
		
		$new_date = $day . '/' . $month . '/' . $year;
		
		return $new_date;
	}
}

if(!function_exists('check_cid_format')){
    function check_cid_format($cid){
        if(strlen($cid) != 13) return false;

        for($i = 0, $sum = 0; $i < 12; $i++)
            $sum += (int)( $cid{ $i } ) * (13 - $i);

        if( ( 11 - ( $sum % 11 ) ) % 10 == (int)( $cid { 12 } ) )
            return true;

        return false;
    }
}

if(!function_exists('get_first_object')){

    function get_first_object($obj){
        if(empty($obj)){
            return NULL;
        }else{
            foreach($obj as $o){
                return $o;
            }
        }

    }
}

if(!function_exists('get_hospital_name')){
    function get_hospital_name($hospital_code){
        $ci =& get_instance();
        $ci->load->model('Basic_model', 'basic');
        $hospital_name = $ci->basic->get_hospital_name($hospital_code);

        return $hospital_name;
    }
}

if(!function_exists('get_user_fullname')){
    function get_user_fullname($user_id){
        if(empty($user_id)){
            return '-';
        }else{
            $ci =& get_instance();

            $result = $ci->mongo_db
                ->where('_id', new MongoId($user_id))
                ->limit(1)
                ->get('users');

            return count($result) > 0 ? $result[0]['fullname'] : '-';
        }

    }
}
/**
 * Get Main inscl name
 *
 * @param   string  $code   The main inscl code
 * @return  string  Main inscl name
 */
if(!function_exists('get_main_inscl')){
    function get_main_inscl($code){

        $ci =& get_instance();

        if($code == 'UCS'){
            return 'สิทธิประกันสุขภาพถ้วนหน้า';
        }else{
            $result = $ci->mongo_db
                ->select(array('name'))
                ->where(array('maininscl' => $code))
                ->get('ref_maininscls');

            return count($result)>0 ? $result[0]['name'] : null;
        }
    }
}

if(!function_exists('get_sub_inscl')){
    function get_sub_inscl($code){
        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('name'))
            ->where('inscl', $code)
            ->get('ref_inscls');

        return count($result) > 0 ? $result[0]['name'] : null;
    }
}

if(!function_exists('get_changwat')){
    function get_changwat($chw){
        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('catm_name'))
            ->where('changwat', $chw)
            ->where('ampur', '00')
            ->where('tambon', '00')
            ->where('moo', '00')
            ->get('ref_catms');
        return count($result) > 0 ? $result[0]['catm_name'] : null;
    }
}

if(!function_exists('get_ampur')){
    function get_ampur($chw, $amp){
        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('catm_name'))
            ->where('changwat', $chw)
            ->where('ampur', $amp)
            ->where('tambon', '00')
            ->where('moo', '00')
            ->get('ref_catms');
        return count($result) > 0 ? $result[0]['catm_name'] : null;

    }
}

if(!function_exists('get_tambon')){
    function get_tambon($chw, $amp, $tmb){

        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('catm_name'))
            ->where('changwat', $chw)
            ->where('ampur', $amp)
            ->where('tambon', $tmb)
            ->where('moo', '00')
            ->get('ref_catms');
        return count($result) > 0 ? $result[0]['catm_name'] : null;
    }
}

if(!function_exists('get_mooban')){
    function get_mooban($chw, $amp, $tmb, $moo){

        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('catm_name'))
            ->where('changwat', $chw)
            ->where('ampur', $amp)
            ->where('tambon', $tmb)
            ->where('moo', $moo)
            ->get('ref_catms');
        return count($result) > 0 ? $result[0]['catm_name'] : null;
    }
}
if(!function_exists('get_thai_time_zone')){
    function get_thai_time_zone($timestamp){
        $timezone = 'UP7';
        $daylight_saving = TRUE;

        return gmt_to_local($timestamp, $timezone, $daylight_saving);
    }
}

if(!function_exists('has_number')){
    function has_number($str){
        preg_match_all('/[0-9]/', $str, $matches);
        $count = count($matches[0]);
        return $count > 0 ? TRUE : FALSE;
    }
}

if(!function_exists('generate_serial')){
    function generate_serial($serial_type, $gen_yy = TRUE){
        $ci =& get_instance();

        $ci->load->model('Serial_model', 'serial');

        $ci->serial->serial_type = $serial_type;

        $short_yy = null;

        //if generate with date
        if($gen_yy){
            $yy = $ci->serial->get_year();

            //get current year
            $current_yy = date('Y') + 543;
            $short_yy = substr($current_yy, -2);

            if($yy != $short_yy){
                $ci->serial->update_year($short_yy);
                //reset serial to 1
                $ci->serial->reset_serial();
            }

            $serial_number = $ci->serial->get_serial();

            $new_serial = set_format_length($serial_number);

            $serial = $short_yy . $new_serial;
            //update serial
            $ci->serial->update_serial();

        }else{
            $serial = $ci->serial->get_serial();
            $ci->serial->update_serial();
        }

        return $serial;
    }

    function set_format_length($sn){
        $new_sn = null;

        switch(strlen($sn)){
            case 1: $new_sn = '00000000' . $sn; break;
            case 2: $new_sn = '0000000' . $sn; break;
            case 3: $new_sn = '000000' . $sn; break;
            case 4: $new_sn = '00000' . $sn; break;
            case 5: $new_sn = '0000' . $sn; break;
            case 6: $new_sn = '000' . $sn; break;
            case 7: $new_sn = '00' . $sn; break;
            case 8: $new_sn = '0' . $sn; break;
            case 9: $new_sn = $sn; break;
            default: $new_sn = '0000001';
        }

        return $new_sn;
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

/*
 * Get patient information
 * 
 * @param	string	$hn	Patian hn.
 * @return 	array
 */
if(!function_exists('get_patient_info')){
	function get_patient_info($hn){
		if(empty($hn) || !isset($hn)){
			return '-';
		}else{
			
			$ci =& get_instance();
			$ci->load->model('Person_model', 'person');
			
			$data = $ci->person->get_person_detail_with_hn($hn);
			//$data['address'] = get_address($hn);
			
			return $data;
		}
	}
}
	
