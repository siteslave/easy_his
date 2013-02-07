<?php
class Pregnancies_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        //$this->clinic_code = '04';
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get ANC list
     *
     * @param $start
     * @param $limit
     * @return mixed
     */
    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->where('owner_id', new MongoId($this->owner_id))
            ->offset($start)
            ->limit($limit)
            ->get('pregnancies');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where(array('owner_id' => new MongoId($this->owner_id)))
            ->count('pregnancies');

        return $rs;
    }

    public function anc_get_list_by_house_total()
    {
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
     * Save anc visit
     */
    public function anc_save_service($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'gravida' => (string) $data['gravida']))
            ->push('anc', array(
                'vn' => $data['vn'],
                'anc_no' => $data['anc_no'],
                'ga' => $data['ga'],
                'anc_result' => $data['anc_result'],
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id)
            ))->update('pregnancies');

        return $rs;
    }

    public function anc_update_service($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                            'hn' => $data['hn'],
                            'gravida' => $data['gravida'],
                            'anc.vn' => (string) $data['vn']
            ))
            ->set(array(
                'anc.$.anc_no' => $data['anc_no'],
                'anc.$.ga' => $data['ga'],
                'anc.$.anc_result' => $data['anc_result'],
                'anc.$.owner_id' => new MongoId($this->owner_id),
                'anc.$.provider_id' => new MongoId($this->provider_id),
                'anc.$.user_id' => new MongoId($this->user_id)
            ))->update('pregnancies');

        return $rs;
    }


    public function anc_check_visit_duplicated($hn, $vn, $gravida)
    {
        $rs = $this->mongo_db
            ->where(array(
                        'anc.vn' => (string) $vn,
                        'gravida' => (string) $gravida,
                        'hn' => (string) $hn))
            ->count('pregnancies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function anc_get_history($hn)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'anc'))
            ->where('hn', (string) $hn)
            ->get('pregnancies');

        return $rs;
    }
    public function anc_get_detail($hn, $vn)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'anc'))
            ->where(array('hn' => (string) $hn, 'anc.vn' => (string) $vn))
            ->limit(1)
            ->get('pregnancies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function get_list_by_visit($vn)
    {
        $rs = $this->mongo_db
            ->where('vn', (string) $vn)
            ->get('visit_epi');

        return $rs;
    }

    public function do_register($data)
    {
        $rs = $this->mongo_db
            ->insert('pregnancies',
                array(
                    'hn' => $data['hn'],
                    'anc_code' => $data['anc_code'],
                    'reg_date' => date('Ymd'),
                    'gravida' => $data['gravida'],
                    'preg_status' => '0',
                    'owner_id' => new MongoId($this->owner_id),
                    'provider_id' => new MongoId($this->provider_id),
                    'user_id' => new MongoId($this->user_id)
                ));

        return $rs;
    }

    public function check_register_status($hn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn))
            ->count('pregnancies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function check_exist($hn, $gravida)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => $hn, 'gravida' => $gravida))
            ->count('pregnancies');
        return $rs > 0 ? TRUE : FALSE;
    }

    public function anc_get_gravida($hn)
    {
        $rs = $this->mongo_db
            ->select(array('gravida'))
            ->where(array('hn' => (string) $hn))
            ->get('pregnancies');

        return count($rs) > 0 ? $rs : NULL;
    }

    //------------------------------------------------------------------------------------------------------------------
    // Labor module
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Save labor data
     */
    public function labor_save($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => $data['hn'], 'gravida' => $data['gravida']))
            ->set(array(
                        'labor.lmp'      => to_string_date($data['lmp']),
                        'labor.edc'      => to_string_date($data['edc']),
                        'labor.bdate'    => to_string_date($data['bdate']),
                        'labor.bresult'  => $data['bresult'],
                        'labor.bplace'   => $data['bplace'],
                        'labor.bhosp'    => $data['bhosp'],
                        'labor.btype'    => $data['btype'],
                        'labor.bdoctor'  => $data['bdoctor'],
                        'labor.lborn'    => $data['lborn'],
                        'labor.sborn'    => $data['sborn'],
                        'preg_status'    => $data['preg_status']
        ))->update('pregnancies');

        return $rs;
    }

    /**
     * Get labor detail
     *
     * @param   string  $anc_code
     * @return  mixed
     */
    public function labor_get_detail($anc_code)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'preg_status', 'labor'))
            ->where(array('anc_code' => (string) $anc_code))
            ->get('pregnancies');

        return $rs;
    }
}