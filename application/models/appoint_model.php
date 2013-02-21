<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Appointment model
 *
 * @package     Model
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
    public function get_list_with_clinic($data, $start, $limit)
    {
        $this->mongo_db->add_index('appoints', array('apclinic_id' => -1));
        $this->mongo_db->add_index('appoints', array('owner_id' => -1));
        $this->mongo_db->add_index('appoints', array('apdate' => -1));

        if($data['status'] == '0')
        {
            $rs = $this->mongo_db
                ->where(array(
                    'apclinic_id'   => new MongoId($data['clinic']),
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))
                ->offset($start)
                ->limit($limit)
                ->get('appoints');
        }
        else
        {
            $rs = $this->mongo_db
                ->where(array(
                    'apclinic_id'   => new MongoId($data['clinic']),
                    'visit_status'  => (string) $data['status'],
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))
                ->offset($start)
                ->limit($limit)
                ->get('appoints');
        }
        return $rs;
    }

    public function get_total_with_clinic($data)
    {
        $this->mongo_db->add_index('appoints', array('apclinic_id' => -1));
        $this->mongo_db->add_index('appoints', array('owner_id' => -1));
        $this->mongo_db->add_index('appoints', array('apdate' => -1));

        if($data['status'] == '0')
        {
            $rs = $this->mongo_db
                ->where(array(
                    'apclinic_id'   => new MongoId($data['clinic']),
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))
                ->count('appoints');
        }
        else
        {
            $rs = $this->mongo_db
                ->where(array(
                    'apclinic_id'   => new MongoId($data['clinic']),
                    'visit_status'  => (string) $data['status'],
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))

                ->count('appoints');
        }
        return $rs;
    }

    public function get_list_without_clinic($data, $start, $limit)
    {
        $this->mongo_db->add_index('appoints', array('apclinic_id' => -1));
        $this->mongo_db->add_index('appoints', array('owner_id' => -1));
        $this->mongo_db->add_index('appoints', array('apdate' => -1));

        if($data['status'] == '0')
        {
            $rs = $this->mongo_db
                ->where(array(
                    'owner_id'  => new MongoId($this->owner_id),
                    'apdate'    => to_string_date($data['date'])
                ))
                ->offset($start)
                ->limit($limit)
                ->get('appoints');
        }
        else
        {
            $rs = $this->mongo_db
                ->where(array(
                    'visit_status'  => (string) $data['status'],
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))
                ->offset($start)
                ->limit($limit)
                ->get('appoints');
        }
        return $rs;
    }
    public function get_total_without_clinic($data)
    {
        $this->mongo_db->add_index('appoints', array('apclinic_id' => -1));
        $this->mongo_db->add_index('appoints', array('owner_id' => -1));
        $this->mongo_db->add_index('appoints', array('apdate' => -1));

        if($data['status'] == '0')
        {
            $rs = $this->mongo_db
                ->where(array(
                    'owner_id'  => new MongoId($this->owner_id),
                    'apdate'    => to_string_date($data['date'])
                ))
                ->count('appoints');
        }
        else
        {
            $rs = $this->mongo_db
                ->where(array(
                    'visit_status'  => (string) $data['status'],
                    'owner_id'      => new MongoId($this->owner_id),
                    'apdate'        => to_string_date($data['date'])
                ))
                ->count('appoints');
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
                'vn'            => $data['vn'],
                'hn'            => $data['hn'],
                'apdate'        => to_string_date($data['date']),
                'aptime'        => $data['time'],
                'aptype_id'     => new MongoId($data['type']),
                'apclinic_id'   => new MongoId($data['clinic']),
                'apdiag'        => $data['diag'],
                'provider_id'   => new MongoId($this->provider_id),
                'user_id'       => new MongoId($this->user_id),
                'owner_id'      => new MongoId($this->owner_id),
                'visit_status'  => '2',
                'last_update'   => date('Y-m-d H:i:s')
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
        $this->mongo_db->add_index('visit', array('hn' => -1));
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
        $this->mongo_db->add_index('appoints', array('apdate' => -1));
        $this->mongo_db->add_index('appoints', array('aptype_id' => -1));

        $rs = $this->mongo_db
                ->where(array(
                        'apdate'    => $apdate,
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

    public function detail($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->limit(1)
            ->get('appoints');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['id'])))
            ->set(array(
                'apclinic_id'   => new MongoId($data['clinic']),
                'aptime'        => $data['time'],
                'apdiag'        => $data['diag'],
                'last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('appoints');

        return $rs;
    }

    public function update_status($data)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($data['appoint_id'])))
            ->set(array(
                'visit_vn' => $data['vn'],
                'visit_status' => '1',
                'last_update'   => date('Y-m-d H:i:s')
            ))
            ->update('appoints');

        return $rs;
    }
}

