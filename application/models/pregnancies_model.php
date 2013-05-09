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
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
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

    public function anc_get_history($hn, $gravida)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'anc'))
            ->where(array('hn' => (string) $hn, 'gravida' => (string) $gravida))
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

    public function check_register_status($hn, $gravida)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'gravida' => $gravida))
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

    public function get_gravida($hn)
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
                        //'labor.lmp'      => to_string_date($data['lmp']),
                        //'labor.edc'      => to_string_date($data['edc']),
                        'labor.bdate'   => to_string_date($data['bdate']),
                        'labor.btime'   => $data['btime'],
                        'labor.bresult' => $data['bresult'],
                        'labor.bplace'  => $data['bplace'],
                        'labor.bhosp'   => $data['bhosp'],
                        'labor.btype'   => $data['btype'],
                        'labor.bdoctor' => $data['bdoctor'],
                        'labor.lborn'   => $data['lborn'],
                        'labor.sborn'   => $data['sborn'],
                        'last_update'   => date('Y-m-d H:i:s')
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

    /**
     * Get labor detail
     *
     * @param   string  $hn
     * @param   string  $gravida
     * @return  mixed
     */
    public function labor_get_detail_by_gravida($hn, $gravida)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'preg_status', 'labor'))
            ->where(array('gravida' => (string) $gravida, 'hn' => (string) $hn))
            ->get('pregnancies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Postnatal module
     */
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Save postnatal visit
     */
    public function postnatal_save_service($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'gravida' => (string) $data['gravida']))
            ->push('postnatal', array(
            'vn' => $data['vn'],
            'ppresult' => $data['ppresult'],
            'sugar' => $data['sugar'],
            'albumin' => $data['albumin'],
            'perineal' => $data['perineal'],
            'amniotic_fluid' => $data['amniotic_fluid'],
            'uterus' => $data['uterus'],
            'tits' => $data['tits'],
            'owner_id' => new MongoId($this->owner_id),
            'provider_id' => new MongoId($this->provider_id),
            'user_id' => new MongoId($this->user_id)
        ))->update('pregnancies');

        return $rs;
    }

    public function postnatal_update_service($data)
    {
        $rs = $this->mongo_db
            ->where(array(
                'hn' => $data['hn'],
                'gravida' => $data['gravida'],
                'postnatal.vn' => (string) $data['vn']
            ))
            ->set(array(
                'postnatal.$.ppresult'          => $data['ppresult'],
                'postnatal.$.sugar'             => $data['sugar'],
                'postnatal.$.albumin'           => $data['albumin'],
                'postnatal.$.perineal'          => $data['perineal'],
                'postnatal.$.amniotic_fluid'    => $data['amniotic_fluid'],
                'postnatal.$.uterus'            => $data['uterus'],
                'postnatal.$.tits'              => $data['tits'],
                'postnatal.$.user_id'           => new MongoId($this->user_id),
                'last_update'                   => date('Y-m-d H:i:s')
            ))->update('pregnancies');

        return $rs;
    }


    public function postnatal_check_visit_duplicated($hn, $vn, $gravida)
    {
        $rs = $this->mongo_db
            ->where(array(
                'postnatal.vn'  => (string) $vn,
                'gravida'       => (string) $gravida,
                'hn'            => (string) $hn)
                )
            ->count('pregnancies');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function postnatal_get_history($hn)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'postnatal'))
            ->where('hn', (string) $hn)
            ->get('pregnancies');

        return $rs;
    }
    public function postnatal_get_detail($hn, $vn)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'postnatal'))
            ->where(array('hn' => (string) $hn, 'postnatal.vn' => (string) $vn))
            ->limit(1)
            ->get('pregnancies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }

    public function save_anc_info($data)
    {

        $rs = $this->mongo_db
            ->where(array('hn' => $data['hn'], 'gravida' => $data['gravida']))
            ->set(array(
                'prenatal.lmp'              => to_string_date($data['lmp']),
                'prenatal.edc'              => to_string_date($data['edc']),
                'prenatal.vdrl'             => $data['vdrl'],
                'prenatal.hb'               => $data['hb'],
                'prenatal.hiv'              => $data['hiv'],
                'prenatal.hct'              => $data['hct'],
                'prenatal.hct_date'         => to_string_date($data['hct_date']),
                'prenatal.thalassemia'      => $data['thalassemia'],
                'prenatal.do_export'        => $data['do_export'],
                'prenatal.do_export_date'   => to_string_date($data['do_export_date']),
                'prenatal.user_id'          => new MongoId($this->user_id),
                'preg_status'               => $data['preg_status'],
                'last_update'                   => date('Y-m-d H:i:s')

        ))->update('pregnancies');

        return $rs;
    }
    public function get_anc_info($anc_code)
    {
        $rs = $this->mongo_db
            ->select(array('gravida', 'prenatal', 'preg_status'))
            ->where(array('anc_code' => (string) $anc_code))
            ->limit(1)
            ->get('pregnancies');

        return count($rs) > 0 ? $rs[0] : NULL;
    }


    public function get_person_list_village($persons){
        $rs = $this->mongo_db
            ->where_in('hn', $persons)
            ->get('pregnancies');

        return $rs;
    }

}

//End of file