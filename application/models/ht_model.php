<?php
class Ht_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        $this->clinic_code = '02';
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get DM list
     *
     * @param $start
     * @param $limit
     * @return mixed
     */
    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get DM by house
     *
     * @param $house_id
     * @return mixed
     */
    public function get_list_by_house($house_id)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id),
                'house_code' => new MongoId($house_id)
            ))
            //->offset($start)
            //->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.clinic_code' => $this->clinic_code,
                        'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }
    public function get_list_by_house_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.clinic_code' => $this->clinic_code,
                        'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }
    
    public function get_providers_by_active() {
        $rs = $this->mongo_db
            ->where(array(
                        'owner_id' => new MongoId($this->owner_id),
                        'active' => 'Y'
                    ))
            ->get('providers');
        
        return $rs;
    }
    
    public function do_regis_ht_clinic($hn, $hid_regis, $year_regis, $date_regis, $diag_type, $doctor, $pre_register, $pregnancy, $hypertension, $insulin, $newcase, $hosp_serial, $reg_serial) {
        $date = $date_regis;
        $date = substr($date, 6).substr($date, 3, 2).substr($date, 0, 2);
        
        $rs = $this->mongo_db
            ->where('hn', (string)$hn)
            ->push('registers', array(
                    'clinic_code' => $this->clinic_code,
                    'owner_id' => new MongoId($this->owner_id),
                    'user_id' => new MongoId($this->user_id),
                    'reg_date' => $date,
                    'reg_year' => $year_regis,
                    'reg_serial' => $reg_serial,
                    'hosp_serial' => $hosp_serial,
                    'diag_type' => $diag_type,
                    'doctor' => new MongoId($doctor),
                    'pre_regis' => $pre_register=='true'?true:false,
                    'pregnancy' => $pregnancy=='true'?true:false,
                    'hypertension' => $hypertension=='true'?true:false,
                    'insulin' => $insulin=='true'?true:false,
                    'newcase' => $newcase=='true'?true:false,
                    'last_update' => date('Y-m-d H:i:s')
                ))
            ->update('person');
        
        return $rs;
    }
    
    public function do_update_ht_clinic($hn, $hid_regis, $year_regis, $date_regis, $diag_type, $doctor, $pre_register, $pregnancy, $hypertension, $insulin, $newcase, $hosp_serial) {
        $date = $date_regis;
        $date = substr($date, 6).substr($date, 3, 2).substr($date, 0, 2);
        
        $rs = $this->mongo_db
            ->where(array('hn' => (string)$hn, 'registers.clinic_code' => $this->clinic_code))
            ->set(array(
                    'registers.$.user_id' => new MongoId($this->user_id),
                    'registers.$.reg_date' => $date,
                    'registers.$.reg_year' => $year_regis,
                    'registers.$.hosp_serial' => $hosp_serial,
                    'registers.$.diag_type' => $diag_type,
                    'registers.$.doctor' => new MongoId($doctor),
                    'registers.$.pre_regis' => $pre_register=='true'?true:false,
                    'registers.$.pregnancy' => $pregnancy=='true'?true:false,
                    'registers.$.hypertension' => $hypertension=='true'?true:false,
                    'registers.$.insulin' => $insulin=='true'?true:false,
                    'registers.$.newcase' => $newcase=='true'?true:false,
                    'registers.$.last_update' => date('Y-m-d H:i:s')
                )
            )
            ->update('person');
        
        return $rs;
    }
    
    public function remove_ht_register($person_id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->pull('registers', array('clinic_code' => $this->clinic_code))
            ->update('person');
            
        return $rs;
    }
}