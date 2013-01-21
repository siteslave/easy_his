<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Services controller
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
	
	public function get_list(){
		
	}
	/*
	 * data[apdate]	15/01/2013
		data[apdiag]	Z097
		data[aptime]	12:00
		data[aptype]	50fcc5d500082f1784622c86
		data[clinic]	50caaf79c4d635581300009c
		data[hn]	550000028
		data[vn]	560000003
	 */
	public function do_register($data){
		$rs = $this->mongo_db
					->insert('appoints', array(
							'vn' => $data['vn'],
							'hn' => $data['hn'],
							'apdate' => to_string_date($data['apdate']),
							'aptime' => $data['aptime'],
							'aptype' => new MongoId($data['aptype']),
							'apclinic_id' => new MongoId($data['clinic']),
							'provider_id' => new MongoId($this->provider_id),
							'user_id' => new MongoId($this->user_id),
							'owner_id' => new MongoId($this->owner_id)
							));
		return $rs;
	}
}

