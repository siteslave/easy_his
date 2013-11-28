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

class Person_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

    public function get_villages(){

        $this->mongo_db->add_index('villages', array('owner_id' => -1));

        $result = $this->mongo_db
                        ->where(array('owner_id' => new MongoId($this->owner_id)))
                        ->order_by(array('village_code' => 1))
                        ->get('villages');
        return $result;
    }

    public function get_houses($village_id){

        $this->mongo_db->add_index('houses', array('village_id' => -1));

        $result = $this->mongo_db
                        ->where(array('village_id' => new MongoId($village_id)))
                        ->order_by(array('house' => 1))
                        ->get('houses');
        return $result;
    }

    public function save_house($data){

        $result = $this->mongo_db->insert('houses', array(
            'hid'           => $data['hid'],
            'owner_id'      => new MongoId($this->owner_id),
            'house'         => $data['house'],
            'house_id'      => $data['house_id'],
            'house_type'    => $data['house_type'],
            'room_no'       => $data['room_no'],
            'condo'         => $data['condo'],
            'soi_sub'       => $data['soi_sub'],
            'soi_main'      => $data['soi_main'],
            'road'          => $data['road'],
            'village_name'  => $data['village_name'],
            'village_id'    => new MongoId($data['village_id']),
            'last_update' => date('Ymd H:i:s')
        ));

        return $result;
    }

    public function check_duplicate_house($house, $village_id){

        $this->mongo_db->add_index('houses', array('house' => -1));
        $this->mongo_db->add_index('houses', array('owner_id' => -1));
        $this->mongo_db->add_index('houses', array('village_id' => -1));

        $result = $this->mongo_db->where(array('house' => $house))
                                //->where(array('owner_id' => new MongoId($this->owner_id)))
                                ->where(array('village_id' => new MongoId($village_id)))
                                ->count('houses');

        return $result > 0 ? TRUE : FALSE;
    }

    public function search_dbpop_by_cid($query){
        $this->mongo_db->add_index('dbpop', array('pid' => -1));
        $result = $this->mongo_db->where(array('pid' => (float) $query))->get('dbpop');
        return $result;
    }
    public function search_dbpop_by_name($query){

        $name = explode(' ', $query);
        $first_name = $name[0];
        $last_name = $name[1];

        $this->mongo_db->add_index('dbpop', array('fname' => -1));
        $this->mongo_db->add_index('dbpop', array('lname' => -1));
        $result = $this->mongo_db->where(array('fname' => $first_name, 'lname' => $last_name))->get('dbpop');
        return $result;
    }

    public function get_house_survey($house_id){
        $result = $this->mongo_db
                        ->select(array('surveys'))
                        ->where(array('_id' => new MongoId($house_id)))->get('houses');
        return count($result) > 0 ? $result[0] : null;
    }

    public function save_house_survey($data){
        $result = $this->mongo_db
                        ->where('_id', new MongoId($data['house_id']))
                        ->set(
                                array(
                                    'surveys.latitude'      => $data['latitude'],
                                    'surveys.longitude'     => $data['longitude'],
                                    'surveys.locatype'      => $data['locatype'],
                                    'surveys.vhvid'         => $data['vhvid'],
                                    'surveys.headid'        => $data['headid'],
                                    'surveys.toilet'        => $data['toilet'],
                                    'surveys.water'         => $data['water'],
                                    'surveys.watertype'     => $data['watertype'],
                                    'surveys.garbage'       => $data['garbage'],
                                    'surveys.housing'       => $data['housing'],
                                    'surveys.durability'    => $data['durability'],
                                    'surveys.cleanliness'   => $data['cleanliness'],
                                    'surveys.ventilation'   => $data['ventilation'],
                                    'surveys.light'         => $data['light'],
                                    'surveys.watertm'       => $data['watertm'],
                                    'surveys.mfood'         => $data['mfood'],
                                    'surveys.bcontrol'      => $data['bcontrol'],
                                    'surveys.acontrol'      => $data['acontrol'],
                                    'surveys.chemical'      => $data['chemical'],
                                    'last_update'           => date('Ymd H:i:s')
                                )
                        )
                        ->update('houses');
        return $result;
    }
    public function save_person($data){
        $result = $this->mongo_db->insert('person', array(
            'cid'               => $data['cid'],
            'hn'                => $data['hn'],
            'owner_id'          => new MongoId($this->owner_id),
            'house_code'        => new MongoId($data['house_code']),
            'title'             => new MongoId($data['title']),
            'first_name'        => $data['first_name'],
            'last_name'         => $data['last_name'],
            'sex'               => $data['sex'],
            'birthdate'         => to_string_date($data['birthdate']),
            'mstatus'           => new MongoId($data['mstatus']),
            'occupation'        => new MongoId($data['occupation']),
            'race'              => new MongoId($data['race']),
            'nation'            => new MongoId($data['nation']),
            'religion'          => new MongoId($data['religion']),
            'education'         => new MongoId($data['education']),
            'fstatus'           => $data['fstatus'],
            'father_cid'        => $data['father_cid'],
            'mother_cid'        => $data['mother_cid'],
            'couple_cid'        => $data['couple_cid'],
            'vstatus'           => new MongoId($data['vstatus']),
            'movein_date'       => to_string_date($data['movein_date']),
            'discharge_status'  => $data['discharge_status'],
            'discharge_date'    => to_string_date($data['discharge_date']),
            'abogroup'           => $data['abogroup'],
            'rhgroup'           => $data['rhgroup'],
            'labor_type'        => new MongoId($data['labor_type']),
            'passport'          => $data['passport'],
            'last_update' => date('Ymd H:i:s')
        ));

        return $result;
    }

    public function update_person($data){
        $result = $this->mongo_db->where(array('hn' => (string) $data['hn']))
                ->set(array(
                    'cid'               => $data['cid'],
                    'owner_id'          => new MongoId($this->owner_id),
                    'title'             => new MongoId($data['title']),
                    'first_name'        => $data['first_name'],
                    'last_name'         => $data['last_name'],
                    'sex'               => $data['sex'],
                    'birthdate'         => to_string_date($data['birthdate']),
                    'mstatus'           => new MongoId($data['mstatus']),
                    'occupation'        => new MongoId($data['occupation']),
                    'race'              => new MongoId($data['race']),
                    'nation'            => new MongoId($data['nation']),
                    'religion'          => new MongoId($data['religion']),
                    'education'         => new MongoId($data['education']),
                    'fstatus'           => $data['fstatus'],
                    'father_cid'        => $data['father_cid'],
                    'mother_cid'        => $data['mother_cid'],
                    'couple_cid'        => $data['couple_cid'],
                    'vstatus'           => new MongoId($data['vstatus']),
                    'movein_date'       => to_string_date($data['movein_date']),
                    'discharge_status'  => $data['discharge_status'],
                    'discharge_date'    => to_string_date($data['discharge_date']),
                    'abogroup'           => $data['abogroup'],
                    'rhgroup'           => $data['rhgroup'],
                    'labor_type'        => new MongoId($data['labor_type']),
                    'passport'          => $data['passport'],
                    'last_update'       => date('Ymd H:i:s')

                ))->update('person');

        return $result;
    }

    /**
     * Remove address
     *
     * @param $person_id
     * @return mixed
     */
    public function remove_person_address($hn){
        $result = $this->mongo_db
                    ->where(array('hn' => (string) $hn))
                    ->unset_field('address')
                    ->update('person');
        return $result;
    }

    /**
     * Remove insurances
     *
     * @param $person_id
     * @return mixed
     */
    public function remove_person_insurance($hn){
        $result = $this->mongo_db
                    ->where(array('hn' => (string) $hn))
                    ->unset_field('insurances')
                    ->update('person');
        return $result;
    }

    /**
     * Save person address
     * @param $person_id
     * @param $data
     * @return mixed
     */
    public function save_person_address($hn, $data){

        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->set(array(
                    'address.address_type'  => $data['address_type'],
                    'address.house_id'      => $data['house_id'],
                    'address.house_type'    => new MongoId($data['house_type']),
                    'address.room_no'       => $data['room_no'],
                    'address.condo'         => $data['condo'],
                    'address.houseno'       => $data['houseno'],
                    'address.soi_sub'       => $data['soi_sub'],
                    'address.soi_main'      => $data['soi_main'],
                    'address.road'          => $data['road'],
                    'address.village_name'  => $data['village_name'],
                    'address.village'       => $data['village'],
                    'address.tambon'        => $data['tambon'],
                    'address.ampur'         => $data['ampur'],
                    'address.changwat'      => $data['changwat'],
                    'address.postcode'      => $data['postcode'],
                    'address.telephone'     => $data['telephone'],
                    'address.mobile'        => $data['mobile'],
                    'last_update'           => date('Ymd H:i:s')
                ))->update('person');

        return $result;
    }

    /**
     * Save person insurance
     *
     * @param   ObjectId  $person_id    The person id.
     * @param   Array     $data         The array of insurance detail.
     * @return  boolean
     */
    public function save_insurance($hn, $data){

        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->set(array(
                    'insurances.id'             => $data['id'],
                    'insurances.code'           => $data['code'],
                    'insurances.start_date'     => to_string_date($data['start_date']),
                    'insurances.expire_date'    => to_string_date($data['expire_date']),
                    'insurances.hmain'          => $data['hmain'],
                    'insurances.hsub'           => $data['hsub'],
                    'last_update'               => date('Y-m-d H:i:s')
                ))->update('person');

        return $result;
    }


    public function save_person_typearea($hn, $typearea){
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->push('typearea',
                array(
                    'typearea'      => $typearea,
                    'owner_id'      => new MongoId($this->owner_id),
                    'last_update'   => date('Y-m-d H:i:s')
                )
            )
            ->update('person');
        return $result;
    }
    public function update_person_typearea($hn, $typearea){
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'typearea.owner_id' => new MongoId($this->owner_id)))
            ->set(array(
                    'typearea.$.typearea'   => $typearea
                )
            )
            ->update('person');
        return $result;
    }
    public function save_person_typearea_with_cid($hn, $typearea){
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->push('typearea',
                array(
                    'typearea'      => $typearea,
                    'owner_id'      => new MongoId($this->owner_id),
                    'last_update'   => date('Y-m-d H:i:s')
                )
            )
            ->update('person');
        return $result;
    }

    public function check_house_exist($house_id){

        $result = $this->mongo_db->where(array('_id' => new MongoId($house_id)))->count('houses');

        return $result > 0 ? TRUE : FALSE;
    }


    public function check_person_exist($cid){

        $result = $this->mongo_db->where(array('cid' => (string) $cid))->count('person');

        return $result > 0 ? TRUE : FALSE;
    }
    public function check_person_exist_by_hn($hn){

        $result = $this->mongo_db->where(array('hn' => (string) $hn))->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    /**
     * @param   MongoId $house_code
     * @return  int
     */
    public function count_person($house_code){
        $this->mongo_db->add_index('person', array('house_code' => -1));
        $result = $this->mongo_db->where(array('house_code' => new MongoId($house_code)))->count('person');
        return (int) $result;
    }

    /**
     * Get person in house
     *
     * @param $house_code
     * @return mixed
     */
    public function get_list($house_code, $start, $limit){
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $result = $this->mongo_db
            ->where(array(
                'house_code' => new MongoId($house_code),
                'typearea.owner_id' => new MongoId($this->owner_id)
            ))
            ->order_by(array('first_name' => 1))
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $result;
    }

    public function get_list_total($house_code){
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $result = $this->mongo_db
            ->where(array(
                'house_code' => new MongoId($house_code),
                'typearea.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');
        return $result;
    }

    public function get_list_all($village_id, $start, $limit){
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $houses = $this->_get_house_list($village_id);

        $result = $this->mongo_db
            ->where(array(
                'typearea.owner_id' => new MongoId($this->owner_id)
            ))
            ->where_in('house_code', $houses)
            ->order_by(array('first_name' => 1))
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $result;
    }
    public function get_list_all_total($village_id){
        $this->mongo_db->add_index('person', array('house_code' => -1));

        $houses = $this->_get_house_list($village_id);

        $result = $this->mongo_db
            ->where(array(
                'typearea.owner_id' => new MongoId($this->owner_id)
            ))
            ->where_in('house_code', $houses)
            ->count('person');
        return $result;
    }


    private function _get_house_list($village_id)
    {
        $this->mongo_db->add_index('houses', array('village_id' => -1));

        $rs = $this->mongo_db
            ->select(array('_id'))
            ->where(array('village_id' => new MongoId($village_id)))
            ->get('houses');

        $arr = array();
        foreach($rs as $r)
            $arr[] = $r['_id'];

        return $arr;
    }

    /**
     * Get person detail for edit
     *
     * @param $person_id
     * @return mixed
     */
    public function detail($hn){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $result = $this->mongo_db->where(array('hn' => (string) $hn))->limit(1)->get('person');
        return count($result) > 0 ? $result[0] : $result;
    }

    public function save_drug_allergy($data){
        $result = $this->mongo_db
            ->where(array('hn' => (string) $data['hn']))
            ->push('allergies',
                array(
                    'record_date'   => to_string_date($data['record_date']),
                    'drug_id'       => new MongoId($data['drug_id']),
                    'diag_type_id'  => new MongoId($data['diag_type_id']),
                    'alevel_id'     => new MongoId($data['alevel_id']),
                    'symptom_id'    => new MongoId($data['symptom_id']),
                    'informant_id'  => new MongoId($data['informant_id']),
                    'hospcode'      => $data['hospcode'],
                    'user_id'       => new MongoId($this->user_id)
                )
            )
            ->update('person');
        return $result;
    }

    public function check_drug_allergy_duplicate($hn, $drug_id){
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'allergies.drug_id' => new MongoId($drug_id)))
            ->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    public function get_drug_allergy_list($hn){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $result = $this->mongo_db
            ->select(array('allergies'))
            ->where(array('hn' => (string) $hn))
            ->get('person');

        return $result;
    }

    public function get_drug_allergy_detail($hn, $drug_id){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('allergies.drug_id' => -1));

        $result = $this->mongo_db
            ->select(array('allergies'))
            ->where(array(
                'hn' => (string) $hn,
                'allergies' =>
                array(
                    '$elemMatch' =>
                    array(
                        'drug_id' => new MongoId($drug_id)
                    )
                )
            ))
            ->get('person');

        return count($result) > 0 ? $result[0]['allergies'][0] : NULL;
    }

    public function update_drug_allergy($data){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('allergies.drug_id' => -1));

        $result = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'allergies.drug_id' => new MongoId($data['drug_id'])))
            ->set(array(
                    'allergies.$.record_date'   => to_string_date($data['record_date']),
                    //'drug_id'       => new MongoId($data['drug_id']),
                    'allergies.$.diag_type_id'  => new MongoId($data['diag_type_id']),
                    'allergies.$.alevel_id'     => new MongoId($data['alevel_id']),
                    'allergies.$.symptom_id'    => new MongoId($data['symptom_id']),
                    'allergies.$.informant_id'  => new MongoId($data['informant_id']),
                    'allergies.$.hospcode'      => $data['hospcode'],
                    'allergies.$.user_id'       => new MongoId($this->user_id)
                )
            )
            ->update('person');
        return $result;
    }

    public function remove_drug_allergy($hn, $drug_id){
        $this->mongo_db->add_index('person', array('hn' => -1));

        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->pull('allergies', array('drug_id' => new MongoId($drug_id)))
            ->update('person');
        return $result;
    }

    public function save_chronic($data){
        $this->mongo_db->add_index('person', array('hn' => -1));

        $result = $this->mongo_db
            ->where(array('hn' => (string) $data['hn']))
            ->push('chronics',
            array(
                'diag_date'         => to_string_date($data['diag_date']),
                'chronic'           => $data['chronic'],
                'discharge_date'    => to_string_date($data['discharge_date']),
                'discharge_type'    => new MongoId($data['discharge_type']),
                'hosp_dx'           => $data['hosp_dx'],
                'hosp_rx'           => $data['hosp_rx']
            )
        )
            ->update('person');
        return $result;
    }

    public function update_chronic($data){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('chronics.chronic' => -1));

        $result = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'chronics.chronic' => $data['chronic']))
            ->set(array(
                'chronics.$.diag_date'         => to_string_date($data['diag_date']),
                'chronics.$.chronic'           => $data['chronic'],
                'chronics.$.discharge_date'    => to_string_date($data['discharge_date']),
                'chronics.$.discharge_type'    => new MongoId($data['discharge_type']),
                'chronics.$.hosp_dx'           => $data['hosp_dx'],
                'chronics.$.hosp_rx'           => $data['hosp_rx']
            )
        )
            ->update('person');
        return $result;
    }


    public function remove_chronic($hn, $chronic){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->pull('chronics', array('chronic' =>$chronic))
            ->update('person');
        return $result;
    }
    public function get_chronic_list($hn){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $result = $this->mongo_db
            ->select(array('chronics'))
            ->where(array('hn' => (string) $hn))
            ->get('person');

        return $result;
    }

    public function check_chronic_duplicate($hn, $chronic){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $result = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'chronics.chronic' => $chronic))
            ->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    /**
     * Register person clinic
     *
     * @param   $hn
     * @param   $clinic     string  The clinic number, 01=DM, 02=HT, 03=STOKE, 04=ANC/MCH, 05=EPI, 06=NCD
     * @return  mixed
     */
    public function do_register_clinic($hn, $clinic)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));

        $rs = $this->mongo_db
            ->where('hn', (string) $hn)
            ->push('registers', array(
            'clinic_code' => $clinic,
            'owner_id' => new MongoId($this->owner_id),
            'reg_date' => date('Ymd'),
            'user_id' => new MongoId($this->user_id)
        ))
            ->update('person');

        return $rs;
    }

    public function check_clinic_exist($hn, $clinic){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('registers.clinic_code' => -1));
        $this->mongo_db->add_index('person', array('registers.owner_id' => -1));

        $result = $this->mongo_db
            ->where(array(
                'hn' => (string) $hn,
                'registers.clinic_code' => $clinic,
                'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    public function get_person_detail($id){
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'cid', 'birthdate', 'sex', 'mstatus'))
            ->where('_id', new MongoId($id))
            ->limit(1)
            ->get('person');

        return count($rs) ? $rs[0] : NULL;
    }
    
    public function get_person_detail_with_hn($hn){
        $this->mongo_db->add_index('person', array('hn' => -1));
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'cid', 'birthdate', 'sex', 'mstatus'))
            ->where(array('hn' => (string) $hn))
            ->limit(1)
            ->get('person');

        return count($rs) ? $rs[0] : NULL;
    }

    public function get_person_detail_with_cid($cid){
        $this->mongo_db->add_index('person', array('cid' => -1));
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'cid', 'birthdate', 'sex', 'mstatus'))
            ->where('cid', $cid)
            ->limit(1)
            ->get('person');

        return count($rs) ? $rs[0] : NULL;
    }

    public function get_cid($hn){
        $this->mongo_db->add_index('person', array('cid' => -1));
        $rs = $this->mongo_db
            ->select(array('cid'))
            ->where('hn', $hn)
            ->limit(1)
            ->get('person');

        return count($rs) ? $rs[0]['cid'] : '-';
    }

	public function get_hn_from_cid($cid){
        $this->mongo_db->add_index('person', array('cid' => -1));
		$rs = $this->mongo_db
				->select(array('hn'))
				->where('cid', $cid)
				->limit(1)
				->get('person');
		
		if($rs){
			return count($rs) ? $rs[0]['hn'] : '000000000';
		}else{
			return '000000000';
		}
	}
	
	public function get_hn_from_first_last_name($first_name, $last_name){
        $this->mongo_db->add_index('person', array('first_name' => -1));
        $this->mongo_db->add_index('person', array('last_name' => -1));
		$rs = $this->mongo_db
		->select(array('hn'))
		->where(array(
            'first_name' => $first_name,
            'last_name' => $last_name
        ))
		->limit(1)
		->get('person');
	
		if($rs){
			return count($rs) ? $rs[0]['hn'] : '000000000';
		}else{
			return '000000000';
		}
	}

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Search person by first name and last name
     *
     * @param   string  $first_name
     * @param   string $last_name
     */

    public function search_person_by_first_last_name($first_name, $last_name)
    {
        $this->mongo_db->add_index('person', array('first_name' => -1));
        $this->mongo_db->add_index('person', array('last_name' => -1));
        $rs = $this->mongo_db
            ->where(array('first_name' => $first_name, 'last_name' => $last_name))
            ->get('person');
        return $rs;
    }

    public function search_person_all_ajax($query, $start, $limit)
    {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $this->mongo_db->add_index('person', array('first_name' => -1));
        $this->mongo_db->add_index('person', array('hn' => -1));

        $rs = $this->mongo_db
            ->or_where(array(
                'cid' => $query,
                'first_name' => new MongoRegex('/'. $query . '/'),
                'hn' => new MongoRegex('/^' . $query . '/')
            ))
            ->limit($limit)
            ->offset($start)
            ->get('person');

        return $rs;
    }

    public function search_person_all_ajax_total($query)
    {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $this->mongo_db->add_index('person', array('first_name' => -1));
        $this->mongo_db->add_index('person', array('hn' => -1));

        $rs = $this->mongo_db
            ->or_where(array(
                'cid' => $query,
                'first_name' => new MongoRegex('/'. $query . '/'),
                'hn' => new MongoRegex('/^' . $query . '/')
            ))
            //->limit($limit)
            //->offset($start)
            ->count('person');

        return $rs;
    }

	//------------------------------------------------------------------------------------------------------------------
    /**
     * Search person by cid
     *
     * @param   string  $cid
     */
    public function search_person_by_cid($cid)
    {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $rs = $this->mongo_db
            ->where('cid', $cid)
            ->get('person');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Search person by hn
     */
    public function search_person_by_hn($hn)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->get('person');

        return $rs;
    }

    public function search_person_ajax_by_hn($query)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'birthdate'))
            ->like('hn', (string) $query)
            ->order_by(array('hn' => 1))
            ->limit(20)
            ->get('person');

        return $rs;
    }

    public function search_person_ajax_by_cid($query)
    {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'birthdate'))
            ->where(array('cid' =>(string) $query))
            ->order_by(array('hn' => 1))
            ->limit(20)
            ->get('person');

        return $rs;
    }

    public function search_person_ajax_by_name($first_name, $last_name)
    {
        $this->mongo_db->add_index('person', array('first_name' => -1));
        $this->mongo_db->add_index('person', array('last_name' => -1));
        $rs = $this->mongo_db
            ->select(array('hn', 'first_name', 'last_name', 'birthdate'))
            ->where(array('first_name' => (string) $first_name, 'last_name' => (string) $last_name))
            ->order_by(array('hn' => 1))
            ->limit(20)
            ->get('person');

        return $rs;
    }

    /**
     * Check Owner
     *
     * @param   string  $hn
     * @param   string  $owner_id
     * @return bool
     */
    public function check_owner($hn)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('typearea.typearea' => -1));
        $this->mongo_db->add_index('person', array('typearea.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'hn' => (string) $hn,
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->count('person');
        return $rs > 0 ? TRUE : FALSE;
    }
    public function check_owner_with_cid($cid)
    {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $this->mongo_db->add_index('person', array('typearea.typearea' => -1));
        $this->mongo_db->add_index('person', array('typearea.owner_id' => -1));

        $rs = $this->mongo_db
            ->where(array(
                'cid' => (string) $cid,
                'typearea' =>
                array(
                    '$elemMatch' =>
                    array(
                        'typearea' => array('$in' => array('1', '3')),
                        'owner_id' => new MongoId($this->owner_id)
                    )
                )))
            ->count('person');
        return $rs > 0 ? TRUE : FALSE;
    }

    public function search_person_by_hn_with_owner($hn) {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $this->mongo_db->add_index('person', array('typearea.owner_id' => -1));
        $rs = $this->mongo_db
            ->where(array(
            'hn' => (string)$hn,
            'typearea.owner_id' => new MongoId($this->owner_id)
        ))
            ->limit(1)
            ->get('person');

        return $rs;
    }
    public function search_person_by_cid_with_owner($cid) {
        $this->mongo_db->add_index('person', array('cid' => -1));
        $this->mongo_db->add_index('person', array('typearea.owner_id' => -1));
        $rs = $this->mongo_db
            ->where(array(
            'cid' => (string)$cid,
            'typearea.owner_id' => new MongoId($this->owner_id)
        ))
            ->get('person');

        return $rs;
    }

    public function save_village_survey($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['village_id'])))
            ->set(array(
                'survey.ntraditional'       => isset($data['ntraditional']) ? (int) $data['ntraditional'] : 0,
                'survey.nmonk'              => isset($data['nmonk']) ? (int) $data['nmonk'] : 0,
                'survey.nreligionleader'    => isset($data['nreligionleader']) ? (int) $data['nreligionleader'] : 0,
                'survey.nbroadcast'         => isset($data['nbroadcast']) ? (int) $data['nbroadcast'] : 0,
                'survey.nradio'             => isset($data['nradio']) ? (int) $data['nradio'] : 0,
                'survey.npchc'              => isset($data['npchc']) ? (int) $data['npchc'] : 0,
                'survey.nclinic'            => isset($data['nclinic']) ? (int) $data['nclinic'] : 0,
                'survey.ndrugstore'         => isset($data['ndrugstore']) ? (int) $data['ndrugstore'] : 0,
                'survey.nchildcenter'       => isset($data['nchildcenter']) ? (int) $data['nchildcenter'] : 0,
                'survey.npschool'           => isset($data['npschool']) ? (int) $data['npschool'] : 0,
                'survey.nsschool'           => isset($data['nsschool']) ? (int) $data['nsschool'] : 0,
                'survey.ntemple'            => isset($data['ntemple']) ? (int) $data['ntemple'] : 0,
                'survey.nreligiousplace'    => isset($data['nreligiousplace']) ? (int) $data['nreligiousplace'] : 0,
                'survey.nmarket'            => isset($data['nmarket']) ? (int) $data['nmarket'] : 0,
                'survey.nshop'              => isset($data['nshop']) ? (int) $data['nshop'] : 0,
                'survey.nfoodshop'          => isset($data['nfoodshop']) ? (int) $data['nfoodshop'] : 0,
                'survey.nstall'             => isset($data['nstall']) ? (int) $data['nstall'] : 0,
                'survey.nraintank'          => isset($data['nraintank']) ? (int) $data['nraintank'] : 0,
                'survey.nchickenfarm'       => isset($data['nchickenfarm']) ? (int) $data['nchickenfarm'] : 0,
                'survey.npigfarm'           => isset($data['npigfarm']) ? (int) $data['npigfarm'] : 0,
                'survey.wastewater'         => isset($data['wastewater']) ? $data['wastewater'] : 0,
                'survey.garbage'            => isset($data['garbage']) ? $data['garbage'] : 0,
                'survey.nfactory'           => isset($data['nfactory']) ? (int) $data['nfactory'] : 0,
                'survey.latitude'           => isset($data['latitude']) ? (float) $data['latitude'] : 0,
                'survey.longitude'          => isset($data['longitude']) ? (float) $data['longitude'] : 0,
                'survey.outdate'            => isset($data['outdate']) ? to_string_date($data['outdate']) : NULL,
                'survey.numactually'        => isset($data['numactually']) ? (int) $data['numactually'] : 0,
                'survey.risktype'           => isset($data['risktype']) ? (int) $data['risktype'] : 0,
                'survey.numstateless'       => isset($data['numstateless']) ? (int) $data['numstateless'] : 0,
                'survey.nexerciseclub'      => isset($data['nexerciseclub']) ? (int) $data['nexerciseclub'] : 0,
                'survey.nolderlyclub'       => isset($data['nolderlyclub']) ? (int) $data['nolderlyclub'] : 0,
                'survey.ndisableclub'       => isset($data['ndisableclub']) ? (int) $data['ndisableclub'] : 0,
                'survey.nnumberoneclub'     => isset($data['nnumberoneclub']) ? (int) $data['nnumberoneclub'] : 0,
            ))
            ->update('villages');

        return $rs;
    }

    public function get_village_survey($id)
    {
        $rs = $this->mongo_db
            ->select(array('survey'))
            ->where(array('_id' => new MongoId($id)))
            ->get('villages');

        return $rs ? $rs[0]['survey'] : NULL;
    }

    public function remove($hn)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $rs = $this->mongo_db->where(array('hn' => (string) $hn))
            ->set(array('marked_delete' => 'Y'))
            ->update('person');
        return $rs;
    }

    public function get_typearea($hn)
    {
        $this->mongo_db->add_index('person', array('hn' => -1));
        $rs = $this->mongo_db
            ->select(array('typearea'))
            ->where(array('hn' => (string) $hn))
            ->limit(1)
            ->get('person');

        if($rs)
        {
            foreach($rs[0]['typearea'] as $r)
            {
                if(get_first_object($r['owner_id']) == $this->owner_id)
                {
                    return $r['typearea'];
                }
                else
                {
                    return NULL;
                }
            }
        }
        else
        {
            return NULL;
        }

    }

    public function get_houses_in_village($village_id)
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

    //================ Move person ===================//
    public function do_move_person($house_id, $hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->set(array(
                'house_code' => new MongoId($house_id)
            ))
            ->update('person');
        return $rs;
    }
}