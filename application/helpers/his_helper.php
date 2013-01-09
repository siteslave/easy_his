<?php
/**
 * Main Helper function
 *
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0
 * @copyright   Copyright 2013 Maha Sarakham Hospital Information center.
 */
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
        if(empty($date) || strlen($date) != 10){
            return null;
        }else{
            $d = explode('/', $date);
            // $d[0] = d, $d[1] = m, $d[2] = y
            $new_date = $d[2] . $d[1] . $d[0];
            return $new_date;
        }
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
        if(empty($hospital_code)){
            return '-';
        }else{
            $ci =& get_instance();

            $result = $ci->mongo_db
                ->where(array('hospcode' => $hospital_code))
                ->get('ref_hospitals');

            return count($result) > 0 ? $result[0]['hospname'] : '-';
        }

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
            case 1: $new_sn = '000000' . $sn; break;
            case 2: $new_sn = '00000' . $sn; break;
            case 3: $new_sn = '0000' . $sn; break;
            case 4: $new_sn = '000' . $sn; break;
            case 5: $new_sn = '00' . $sn; break;
            case 6: $new_sn = '0' . $sn; break;
            case 7: $new_sn = $sn; break;
            default: $new_sn = '0000001';
        }

        return $new_sn;
    }


}
