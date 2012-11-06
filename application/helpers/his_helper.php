<?php

if( ! function_exists('render_json')){
    function render_json($json){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');

        echo $json;
    }
}

if(!function_exists('get_first_object')){

    function get_first_object($obj){
        foreach($obj as $o){
            return $o;
        }
    }
}

if(!function_exists('get_hospital_name')){
    function get_hospital_name($hospital_code){
        $ci =& get_instance();

        $result = $ci->mongo_db
            ->select(array('hospital_name'))
            ->where('hospital_code', $hospital_code)
            ->get('hospitals');

        return count($result) > 0 ? $result[0]['hospital_name'] : null;
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
                ->get('maininscl');

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
            ->get('inscl');

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
            ->get('catms');
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
            ->get('catms');
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
            ->get('catms');
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
            ->get('catms');
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
