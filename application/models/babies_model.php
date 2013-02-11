<?php
class Babies_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;


    public function __construct()
    {
        //constructor
    }

    public function do_register($hn)
    {
        $rs = $this->mongo_db
            ->insert('babies',
            array(
                'hn' => $hn,
                'reg_date' => date('Ymd'),
                'discharge_status' => 'N',
                'discharge_date' => NULL,
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Ymd H:i:s')
            ));

        return $rs;
    }

    public function check_register_status($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->count('babies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id), 'discharge_status' => 'N'))
            ->offset($start)
            ->limit($limit)
            ->get('babies');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('babies');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get labor detail
     *
     * @param   string  $hn
     * @return  mixed
     */
    public function get_labor_detail($hn)
    {
        $rs = $this->mongo_db
            ->select(array(
                            'hn', 'reg_date', 'discharge_status', 'discharge_date',
                            'anc_code', 'bweight', 'asphyxia', 'vitk', 'tsh', 'tshresult'
                          ))
            ->where(array('hn' => (string) $hn))
            ->get('babies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save mother detail
     *
     * @param   mixed   $data
     * @return  boolean
     */
    public function save_mother($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['baby_hn']))
            ->set(array(
                    'mother_hn' => (string) $data['mother_hn'],
                    'gravida' => (string) $data['gravida'],
                    'last_update' => date('Ymd H:i:s')
                ))
            ->update('babies');

        return $rs;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save babies detail
     *
     * @param   array   $data
     * @return  boolean
     */

    public function save_babies_detail($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn']))
            ->set(array(
                    'birthno'   => $data['birthno'],
                    'bweight'   => (float) $data['bweight'],
                    'asphyxia'  => (string) $data['asphyxia'],
                    'vitk'      => (string) $data['vitk'],
                    'tsh'       => (string) $data['tsh'],
                    'tshresult' => (string) $data['tshresult'],
                    'last_update' => date('Ymd H:i:s')
                 ))
            ->update('babies');

        return $rs;
    }

    public function check_mother_babies_gravida($hn, $mother_hn, $gravida)
    {
        $rs = $this->mongo_db
            ->where_ne('hn', (string) $hn)
            ->where(array('gravida' => (string) $gravida, 'mother_hn' => (string) $mother_hn))
            ->count('babies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_babies_detail($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->get('babies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }
}