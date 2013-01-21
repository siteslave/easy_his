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
	
	public $owner_id;
	public $user_id;
	public $provider_id;
	
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
	/*
	 * Register new appoint
	 * 
	 * @param	string		$vn			Visit number.
	 * @param	string 		$hn			Person hn.
	 * @param	string 		$apdate		Appoint date in dd-mm-yyyy format.
	 * @param	string		$aptime		Appoint time in hh:mm format.
	 * @param	ObjectId	$apclinic	Appoint clinic.
	 * @param	ObjectId	$user_id	User id.
	 * @param	ObjectId	$owner_id	Owner id.
	 * @param	ObjectId	$provider_id Provider id.
	 * 
	 * @retur	boolean		TRUE if success, FALSE if failed.
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
							'owner_id' => new MongoId($this->owner_id)
							));
		return $rs;
	}
	
	
}

