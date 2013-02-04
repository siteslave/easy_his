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
                        ->order_by(array('_id' => 1))
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
            'village_id'    => new MongoId($data['village_id'])
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
                                    'surveys.chemical'      => $data['chemical']
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
            'typearea'          => $data['typearea']
        ));

        return $result; //return _id
    }

    public function update_person($data){
        $result = $this->mongo_db->where('_id', new MongoId($data['person_id']))
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
                                            'typearea'          => $data['typearea']
                                        ))->update('person');

        return $result;
    }

    /**
     * Remove address
     *
     * @param $person_id
     * @return mixed
     */
    public function remove_person_address($person_id){
        $result = $this->mongo_db
                    ->where('_id', new MongoId($person_id))
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
    public function remove_person_insurance($person_id){
        $result = $this->mongo_db
                    ->where('_id', new MongoId($person_id))
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
    public function save_person_address($person_id, $data){

        $result = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->set(array(
                    //'address.person_id'     => new MongoId($person_id),
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
                    'address.mobile'        => $data['mobile']
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
    public function save_insurance($person_id, $data){

        $result = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->set(array(
                    'insurances.id'             => $data['id'],
                    'insurances.code'           => $data['code'],
                    'insurances.start_date'     => to_string_date($data['start_date']),
                    'insurances.expire_date'    => to_string_date($data['expire_date']),
                    'insurances.hmain'          => $data['hmain'],
                    'insurances.hsub'           => $data['hsub']
                ))->update('person');

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

    /**
     * @param   MongoId $house_code
     * @return  int
     */
    public function count_person($house_code){
        $result = $this->mongo_db->where(array('house_code' => new MongoId($house_code)))->count('person');
        return (int) $result;
    }

    /**
     * Get person in house
     *
     * @param $house_code
     * @return mixed
     */
    public function get_person_list($house_code){
        $result = $this->mongo_db->where(array('house_code' => new MongoId($house_code)))->get('person');
        return $result;
    }

    /**
     * Get person detail for edit
     *
     * @param $person_id
     * @return mixed
     */
    public function detail($person_id){
        $result = $this->mongo_db->where(array('_id' => new MongoId($person_id)))->limit(1)->get('person');
        return count($result) > 0 ? $result[0] : $result;
    }

    public function save_drug_allergy($data){
        $result = $this->mongo_db
            ->where('_id', new MongoId($data['person_id']))
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

    public function check_drug_allergy_duplicate($person_id, $drug_id){
        $result = $this->mongo_db
            ->where(array('_id' => new MongoId($person_id), 'allergies.drug_id' => new MongoId($drug_id)))
            ->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    public function get_drug_allergy_list($person_id){
        $result = $this->mongo_db
            ->select(array('allergies'))
            ->where('_id', new MongoId($person_id))
            ->get('person');

        return $result;
    }

    public function get_drug_allergy_detail($person_id, $drug_id){
        $result = $this->mongo_db
            ->select(array('allergies'))
            ->where(array('_id' => new MongoId($person_id), 'allergies.drug_id' => new MongoId($drug_id)))
            ->get('person');

        return count($result) > 0 ? $result[0]['allergies'] : NULL;
    }

    public function update_drug_allergy($data){
        $result = $this->mongo_db
            ->where(array('_id' => new MongoId($data['person_id']), 'allergies.drug_id' => new MongoId($data['drug_id'])))
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

    public function remove_drug_allergy($person_id, $drug_id){
        //$this->mongo_db->pull('comments', array('comment_id'=>123))->update('blog_posts');

        $result = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->pull('allergies', array('drug_id' => new MongoId($drug_id)))
            ->update('person');
        return $result;
    }

    public function save_chronic($data){
        $result = $this->mongo_db
            ->where('_id', new MongoId($data['person_id']))
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
        $result = $this->mongo_db
            ->where(array('_id' => new MongoId($data['person_id']), 'chronics.chronic' => $data['chronic']))
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


    public function remove_chronic($person_id, $chronic){
        //$this->mongo_db->pull('comments', array('comment_id'=>123))->update('blog_posts');

        $result = $this->mongo_db
            ->where('_id', new MongoId($person_id))
            ->pull('chronics', array('chronic' =>$chronic))
            ->update('person');
        return $result;
    }
    public function get_chronic_list($person_id){
        $result = $this->mongo_db
            ->select(array('chronics'))
            ->where('_id', new MongoId($person_id))
            ->get('person');

        return $result;
    }

    public function check_chronic_duplicate($person_id, $chronic){
        $result = $this->mongo_db
            ->where(array('_id' => new MongoId($person_id), 'chronics.chronic' => $chronic))
            ->count('person');

        return $result > 0 ? TRUE : FALSE;
    }

    /**
     * Register person clinic
     *
     * @param   $hn
     * @param   $clinic     string  The clinic number, 01=DM, 02=HT, 03=STOKE, 04=ANC/MCH, 05=EPI, 06=NCD, 07=ANC
     * @return  mixed
     */
    public function do_register_clinic($hn, $clinic)
    {
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
            ->select(array('hn', 'first_name', 'last_name', 'cid', 'birthdate', 'sex'))
            ->where('_id', new MongoId($id))
            ->limit(1)
            ->get('person');

        if($rs){
            return count($rs) ? $rs[0] : NULL;
        }else{
            return NULL;
        }
    }
    
    public function get_person_detail_with_hn($hn){
    	$rs = $this->mongo_db
    	->select(array('hn', 'first_name', 'last_name', 'cid', 'birthdate', 'sex'))
    	->where('hn', $hn)
    	->limit(1)
    	->get('person');
    
    	if($rs){
    		return count($rs) ? $rs[0] : NULL;
    	}else{
    		return NULL;
    	}
    }
    
    public function get_cid($hn){
        $rs = $this->mongo_db
            ->select(array('cid'))
            ->where('hn', $hn)
            ->limit(1)
            ->get('person');

        if($rs){
            return count($rs) ? $rs[0]['cid'] : '-';
        }else{
            return '-';
        }
    }

	public function get_hn_from_cid($cid){
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
	
	public function get_all_person()
	{
		$rs = $this->mongo_db->get('person');
		return $rs;
	}
	
	public function set_hn($person_id, $hn)
	{
		$rs = $this->mongo_db
				->where('_id', new MongoId($person_id))
				->set(array('hn' => $hn))
				->update('person');
		return $rs;
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
        $rs = $this->mongo_db
            ->where(array('first_name' => $first_name, 'last_name' => $last_name))
            ->get('person');
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
        $rs = $this->mongo_db
            ->where('hn', $hn)
            ->get('person');

        return $rs;
    }
}