<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diabetes_model extends CI_Model
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
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

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

    public function get_list_total()
    {
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $rs;
    }


    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get DM by villages
     *
     * @param $houses
     * @return mixed
     */
    public function get_list_by_village($houses, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->where_in('house_code', $houses)
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_by_village_total($houses)
    {
        $rs = $this->mongo_db
            ->where(array(
                'registers.clinic_code' => $this->clinic_code,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->where_in('house_code', $houses)
            ->count('person');

        return $rs;
    }

    
    public function do_register($data) {

        $rs = $this->mongo_db
            ->where('hn', (string) $data['hn'])
            ->push('registers', array(
                'clinic_code'   => $this->clinic_code,
                'owner_id'      => new MongoId($this->owner_id),
                'user_id'       => new MongoId($this->user_id),
                'reg_date'      => to_string_date($data['reg_date']),
                'reg_year'      => $data['year_regis'],
                'reg_serial'    => $data['reg_serial'],
                'hosp_serial'   => $data['hosp_serial'],
                'diag_type'     => new MongoId($data['diag_type']),
                'doctor'        => new MongoId($data['doctor']),
                'pre_regis'     => $data['pre_register'],
                'pregnancy'     => $data['pregnancy'],
                'hypertension'  => $data['hypertension'],
                'insulin'       => $data['insulin'],
                'newcase'       => $data['newcase'],
                'last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('person');
        
        return $rs;
    }
    
    public function do_update($data) {

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'registers.clinic_code' => $this->clinic_code))
            ->set(array(
                'registers.$.user_id'       => new MongoId($this->user_id),
                'registers.$.reg_date'      => to_string_date($data['reg_date']),
                'registers.$.reg_year'      => $data['year_regis'],
                'registers.$.hosp_serial'   => $data['hosp_serial'],
                'registers.$.diag_type'     => new MongoId($data['diag_type']),
                'registers.$.doctor'        => new MongoId($data['doctor']),
                'registers.$.pre_regis'     => $data['pre_register'],
                'registers.$.pregnancy'     => $data['pregnancy'],
                'registers.$.hypertension'  => $data['hypertension'],
                'registers.$.insulin'       => $data['insulin'],
                'registers.$.newcase'       => $data['newcase'],
                'registers.$.last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('person');
        
        return $rs;
    }
    
    public function remove($hn) {
        $rs = $this->mongo_db
            ->where('hn', (string) $hn)
            ->pull('registers', array('clinic_code' => $this->clinic_code))
            ->update('person');
            
        return $rs;
    }

    public function get_house_list($village_id)
    {
        $this->mongo_db->add_index('houses', array('village_id' => -1));
        $rs = $this->mongo_db
            ->select(array('_id'))
            ->where(array('village_id' => new MongoId($village_id)))
            ->get('houses');

        $arr_house = array();

        foreach($rs as $r)
        {
            $arr_house[] = $r['_id'];
        }

        return $arr_house;
    }


}