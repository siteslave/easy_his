<?php
class Fp_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;

    public function check_visit_duplicate($date_serv, $fp_type)
    {
        $this->mongo_db->add_index('visit_fp', array('date_serv' => -1));
        $rs = $this->mongo_db->where(array('date_serv' => to_string_date($date_serv), 'fp_type' => (string) $fp_type))->count('visit_fp');

        return $rs > 0 ? TRUE : FALSE;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save visit fp
     *
     * @param 	array 	$data
     * @return 	boolean
     */
    public function save_fp($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_fp',
                array(
                   // '_id'           => $data['_id'],
                    'provider_id'   => new MongoId($data['provider_id']),
                    'owner_id'      => new MongoId($this->owner_id),
                    'vn'            => (string) $data['vn'],
                    'hn'            => (string) $data['hn'],
                    'date_serv'     => to_string_date($data['date_serv']),
                    'hospcode'      => (string) $data['hospcode'],
                    'fp_type'       => $data['fp_type'],
                    'user_id'       => new MongoId($this->user_id),
                    'last_update'   => date('Y-m-d H:i:s')
                )
            );
        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get FP list
     *
     *
     */
    public function get_list($vn)
    {
        $this->mongo_db->add_index('visit_fp', array('vn' => -1));
        $rs = $this->mongo_db->where(array('vn' => $vn))->get('visit_fp');
        return $rs;
    }

    public function get_history($hn)
    {
        $this->mongo_db->add_index('visit_fp', array('hn' => -1));
        $rs = $this->mongo_db->where(array('hn' => (string) $hn))->get('visit_fp');
        return $rs;
    }

    public function remove($id)
    {
        $rs = $this->mongo_db
            ->where(array('_id' => new MongoId($id)))
            ->delete('visit_fp');

        return $rs;
    }

}
