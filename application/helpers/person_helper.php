<?php
/**
 * Person Helper
 *
 * @package     Helpers
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

if( ! function_exists('count_person')){
    /**
     * @param $house_code
     * @return int
     */
    function count_person($house_code){
        $ci =& get_instance();

        $ci->load->model('Person_model', 'person');

        $person = $ci->person->count_person($house_code);

        return $person;
    }
}
if( ! function_exists('get_person_detail')){

    function get_person_detail($id){
        $ci =& get_instance();

        $ci->load->model('Person_model', 'person');

        $rs = $ci->person->get_person_detail($id);

        return $rs;
    }
}
if( ! function_exists('get_person_detail_with_hn')){

    function get_person_detail_with_hn($hn){
        $ci =& get_instance();

        $ci->load->model('Person_model', 'person');

        $rs = $ci->person->get_person_detail_with_hn($hn);

        return $rs;
    }
}
if( ! function_exists('get_person_detail_with_cid')){

    function get_person_detail_with_cid($hn){
        $ci =& get_instance();

        $ci->load->model('Person_model', 'person');

        $rs = $ci->person->get_person_detail_with_cid($hn);

        return $rs;
    }
}
/**
 * Count age
 *
 * @param   string  $birthdate  The person birthdate in format yyyymmdd Exam. 19800819
 * @return  int The Age
 */

/**
 * function calage($pbday){
3.$today = date(“d/m/Y”);
4.list($bady , $bmonth , $byear) = explode(“/” , $pbday);
5.list($tday , $tmonth , $tyear) = explode(“/” , $today);

6. if($byear < 1970){
7.  $yearad =1970 – $byear;
8. $byear =1970;
9.  }else{
10.  $yearad = 0;}

11.  $mbirth = mktime(0,0,0,$bmonth,$bday,$byear);
12.  $mnow = mktime(0,0,0,$tmonth,$tday,$tyear);

14.  $mage= ($mnow – $mbirth);
15. $age = (date(“Y”,$mage)-1970 + $yearad).”ปี”.
16.  (date(“m”, $mage)-1).” เดือน ” .
17. (date(“d”, $mage)-1).” วัน” ; return($age);
18. }
19. $birthday = “07/08/1985″;
20. print “วันเกิด  $birthday <BR>”;
21. print “อายุของคุณคือ “.calage($birthday);
22.?>
 *
 *
 *
 *
 * 		$year = (int) substr($mongo_date, 0, 4) + 543;
$month = substr($mongo_date, 4, 2);
$day = substr($mongo_date, 6, 2);


 */
if(!function_exists('count_age')){
    function count_age($birthdate){
        if($birthdate || strlen($birthdate) == 8){
            $y1 = (int) substr($birthdate, 0, 4);
            $y2 = (int) date('Y');

            $age = $y2 - $y1;

            return $age;
        }else{
            return 0;
        }
    }
}

if(!function_exists('get_sex')){
    function get_sex($sex = '1'){
        return $sex == '1' ? 'ชาย' : 'หญิง';
    }
}


if(!function_exists('get_village_list'))
{
    $ci =& get_instance();

    $owner_id = $ci->session->userdata('owner_id');

    $ci->load->model('Person_model', 'person');

    $ci->person->owner_id = $owner_id;
    $rs = $ci->person->get_villages();

    return $rs;
}
