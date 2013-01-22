<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointment controller
 *
 * @package     Controllers
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Appoint_model extends CI_Model {
	//-----------------------------------------------------------------------------------------------------------------
	/*
	 * Global parameters
	 */
	public $owner_id;
	public $user_id;
	public $provider_id;
	//-----------------------------------------------------------------------------------------------------------------
	/*
	 * Get appoint list
	 * 
	 * @param	string	$apdate		Appoint date in yyyymmdd format.
	 * @param	string	$apclinic	Appoint clinic.
	 * @param	string	$apstatus	Appoint status, 0 = All, 1 = Ok, 2 = Absent.
	 * 
	 * @return	array
	 */
	public function get_list($apdate, $apclinic, $apstatus){
		if($apstatus == '0'){
			if($apclinic == '00000'){ // all clinic
				
				$rs = $this->mongo_db
				->where(array(
						'owner_id' 	=> $this->owner_id,
						//'apclinic' 	=> $apclinic,
						'apdate'	=> $apdate
				))
				->get('appoints');
				
			}else{
				
				$rs = $this->mongo_db
				->where(array(
						'owner_id' 	=> $this->owner_id,
						'apclinic' 	=> $apclinic,
						'apdate'	=> $apdate
				))
				->get('appoints');
				
			}
			
		}else{
			if($apclinic == '00000'){
				
				$rs = $this->mongo_db
				->where(array(
						'owner_id' 	=> $this->owner_id,
						//'apclinic' 	=> $apclinic,
						'apdate'	=> $apdate,
						'apstatus'	=> $apstatus
				))
				->get('appoints');
				
			}else{
				$rs = $this->mongo_db
				->where(array(
						'owner_id' 	=> $this->owner_id,
						'apclinic' 	=> $apclinic,
						'apdate'	=> $apdate,
						'apstatus'	=> $apstatus
				))
				->get('appoints');
			}
			
		}
		
		return $rs;
	}
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Register new appoint
	 * 
	 * @param	array	$data	The data for save.
	 * @return	boolean		TRUE if success, FALSE if failed.
	 * 
	 */
	public function do_register($data){
		$rs = $this->mongo_db
					->insert('appoints', array(
							'vn' => $data['vn'],
							'hn' => $data['hn'],
							'apdate' => to_string_date($data['apdate']),
							'aptime' => $data['aptime'],
							'aptype_id' => new MongoId($data['aptype']),
							'apclinic_id' => new MongoId($data['clinic']),
							'provider_id' => new MongoId($this->provider_id),
							'user_id' => new MongoId($this->user_id),
							'owner_id' => new MongoId($this->owner_id),
							'visit_status' => '0',
							'visit_vn' => ''
							));
		return $rs;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Search visit
	 * 
	 * @param	string	$hn The person hn.
	 */
	public function do_search_visit($hn){
		$rs = $this->mongo_db->where(array('hn' => (string) $hn))->get('visit');
		return $rs;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Check duplicate appoint
	 * 
	 * @param	string	$vn		The visit number.
	 * @param	string	$clinic	The clinic that appoint.
	 */
	
	public function check_duplicate($apdate, $aptype){
		$rs = $this->mongo_db
				->where(array(
						'apdate' => $apdate,
						'aptype_id' => new MongoId($aptype)))
				->count('appoints');
				
		return $rs > 0 ? TRUE : FALSE;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/*
	 * Remove appointment
	 * 
	 * @param	ObjectId	$id	The appointment id.
	 * @return	boolean		TRUE if success, FALSE if failed.
	 */
	
	public function do_remove($id){
		$rs = $this->mongo_db->where(array('_id' => new MongoId($id)))->delete('appoints');
		
		return $rs;
	}
}

