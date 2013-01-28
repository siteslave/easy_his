<?php
class Accident_model extends CI_Model 
{
	public $owner_id;
	public $user_id;
	public $provider_id;
	
	//------------------------------------------------------------------------------------------------------------------
	/**
	 * Save accident data
	 * 
	 * @param mixed $data
	 * @return boolean
	 */
	public function save($data) 
	{
		$rs = $this->mongo_db
					->insert('accidents', 
							array(
									'owner_id'			=> new MongoId($this->owner_id),
									'user_id'			=> new MongoId($this->user_id),
									'vn'				=> $data['vn'],
									'hn'				=> $data['hn'],
									'ae_date' 			=> $data['ae_date'],
									'ae_time' 			=> $data['ae_time'],
									'ae_urgency' 		=> $data['ae_urgency'],
									'ae_type' 			=> new MongoId($data['ae_type']),
									'ae_place' 			=> new MongoId($data['ae_place']),
									'ae_typein' 		=> new MongoId($data['ae_typein']),
									'ae_traffic' 		=> new MongoId($data['ae_traffic']),
									'ae_vehicle' 		=> new MongoId($data['ae_vehicle']),
									'ae_alcohol' 		=> $data['ae_alcohol'],
									'ae_nacrotic_drug' 	=> $data['ae_nacrotic_drug'],
									'ae_belt' 			=> $data['ae_belt'],
									'ae_helmet' 		=> $data['ae_helmet'],
									'ae_airway' 		=> $data['ae_airway'],
									'ae_stopbleed' 		=> $data['ae_stopbleed'],
									'ae_splint' 		=> $data['ae_splint'],
									'ae_fluid' 			=> $data['ae_fluid'],
									'ae_coma_eye' 		=> $data['ae_coma_eye'],
									'ae_coma_speak' 	=> $data['ae_coma_speak'],
									'ae_coma_movement' 	=> $data['ae_coma_movement']
							));
		return $rs;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/**
	 * Update accident data
	 *
	 * @param mixed $data
	 * @return boolean
	 */
	public function update($data)
	{
		$rs = $this->mongo_db
		->where('vn', $data['vn'])
		->set(
				array(
						//'owner_id'			=> new MongoId($this->owner_id),
						//'user_id'			=> new MongoId($this->user_id),
						//'vn'				=> $data['vn'],
						//'hn'				=> $data['hn'],
						'ae_date' 			=> $data['ae_date'],
						'ae_time' 			=> $data['ae_time'],
						'ae_urgency' 		=> $data['ae_urgency'],
						'ae_type' 			=> new MongoId($data['ae_type']),
						'ae_place' 			=> new MongoId($data['ae_place']),
						'ae_typein' 		=> new MongoId($data['ae_typein']),
						'ae_traffic' 		=> new MongoId($data['ae_traffic']),
						'ae_vehicle' 		=> new MongoId($data['ae_vehicle']),
						'ae_alcohol' 		=> $data['ae_alcohol'],
						'ae_nacrotic_drug' 	=> $data['ae_nacrotic_drug'],
						'ae_belt' 			=> $data['ae_belt'],
						'ae_helmet' 		=> $data['ae_helmet'],
						'ae_airway' 		=> $data['ae_airway'],
						'ae_stopbleed' 		=> $data['ae_stopbleed'],
						'ae_splint' 		=> $data['ae_splint'],
						'ae_fluid' 			=> $data['ae_fluid'],
						'ae_coma_eye' 		=> $data['ae_coma_eye'],
						'ae_coma_speak' 	=> $data['ae_coma_speak'],
						'ae_coma_movement' 	=> $data['ae_coma_movement']
				))
		->update('accidents');
		
		return $rs;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/**
	 * Check visit exist
	 * 
	 * @param 	string 	$vn
	 * @return 	boolean
	 */
	public function check_exist($vn) {
		$rs = $this->mongo_db
					->where('vn', $vn)
					->count('accidents');
		
		return $rs > 0 ? TRUE : FALSE;
	}
	
	//------------------------------------------------------------------------------------------------------------------
	/**
	 * Get accident data for update
	 * 
	 * @param	string	$vn
	 */
	
	public function get_data($vn)
	{
		$rs = $this->mongo_db->where('vn', $vn)->limit(1)->get('accidents');
		return $rs ? $rs[0] : NULL;
	}
}