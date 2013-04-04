<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dm_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        $this->clinic_code = '01';
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
    
    public function do_regis_dm_clinic($data) {

        $rs = $this->mongo_db
            ->where('hn', (string) $data['hn'])
            ->push('registers', array(
                'clinic_code'   => $this->clinic_code,
                'owner_id'      => new MongoId($this->owner_id),
                'user_id'       => new MongoId($this->user_id),
                'reg_date'      => to_string_date($data['date_regis']),
                'reg_year'      => $data['year_regis'],
                'reg_serial'    => $data['reg_serial'],
                'hosp_serial'   => $data['hosp_serial'],
                'diag_type'     => $data['diag_type'],
                'doctor'        => new MongoId($data['doctor']),
                'pre_regis'     => $data['pre_register'] == 'true' ? TRUE : FALSE,
                'pregnancy'     => $data['pregnancy'] == 'true' ? TRUE : FALSE,
                'hypertension'  => $data['hypertension'] == 'true' ? TRUE : FALSE,
                'insulin'       => $data['insulin'] == 'true' ? TRUE : FALSE,
                'newcase'       => $data['newcase'] == 'true' ? TRUE : FALSE,
                'last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('person');
        
        return $rs;
    }
    
    public function do_update_dm_clinic($data) {

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'registers.clinic_code' => $this->clinic_code))
            ->set(array(
                'registers.$.user_id'       => new MongoId($this->user_id),
                'registers.$.reg_date'      => to_string_date($data['date_regis']),
                'registers.$.reg_year'      => $data['year_regis'],
                'registers.$.hosp_serial'   => $data['hosp_serial'],
                'registers.$.diag_type'     => $data['diag_type'],
                'registers.$.doctor'        => new MongoId($data['doctor']),
                'registers.$.pre_regis'     => $data['pre_register'] == 'true' ? TRUE : FALSE,
                'registers.$.pregnancy'     => $data['pregnancy'] == 'true' ? TRUE : FALSE,
                'registers.$.hypertension'  => $data['hypertension'] == 'true' ? TRUE : FALSE,
                'registers.$.insulin'       => $data['insulin'] == 'true' ? TRUE : FALSE,
                'registers.$.newcase'       => $data['newcase'] == 'true' ? TRUE : FALSE,
                'registers.$.last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('person');
        
        return $rs;
    }
    
    public function remove_dm_register($person_id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->pull('registers', array('clinic_code' => $this->clinic_code))
            ->update('person');
            
        return $rs;
    }
}