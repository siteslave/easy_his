<?php
class Ncdscreen_model extends CI_Model
{
    public $owner_id;
    public $user_id;
    public $provider_id;
    public $clinic_code;


    public function __construct()
    {
        $this->clinic_code = '06';
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get NCD list
     *
     * @param $start
     * @param $limit
     * @return mixed
     */
    public function get_list($start, $limit)
    {
        $rs = $this->mongo_db
            ->order_by(array('cid' => 'asc'))
            ->where('typearea.owner_id', new MongoId($this->owner_id))
            ->where_in('typearea.typearea', array('1', '3'))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string)(date('Y')-15).'1231')
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_last_screen($id) {
        $rs = $this->mongo_db
            ->order_by(array('date' => 'desc', 'time' => 'desc'))
            ->where('person_id', new MongoId($id))
            ->limit(1)
            ->get('ncdscreen');
        $res = '';
        if($rs) {
            $res = $rs[0]['date'].' '.$rs[0]['time'];
        }
        return $res;
    }
    //------------------------------------------------------------------------------------------------------------------
    /**
     * Get NCD by house
     *
     * @param $house_id
     * @return mixed
     */
    public function get_list_by_house($house_id, $start, $limit)
    {
        $rs = $this->mongo_db
            ->where(array(
                'typearea.owner_id' => new MongoId($this->owner_id),
                'house_code' => new MongoId($house_id)
            ))
            ->where_in('typearea.typearea', array('1', '3'))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string)(date('Y')-15).'1231')
            ->offset($start)
            ->limit($limit)
            ->get('person');
        return $rs;
    }

    public function get_list_total()
    {
        $rs = $this->mongo_db
            ->where('typearea.owner_id', new MongoId($this->owner_id))
            ->where_in('typearea.typearea', array('1', '3'))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string)(date('Y')-15).'1231')
            ->count('person');

        return $rs;
    }
    public function get_list_by_house_total()
    {
        $rs = $this->mongo_db
            ->where(array(
                        'registers.owner_id' => new MongoId($this->owner_id)
            ))
            ->where_in('typearea.typearea', array('1', '3'))
            ->where_not_in('registers.clinic_code', array('01', '02'))
            ->where_lte('birthdate', (string)(date('Y')-15).'1231')
            ->count('person');

        return $rs;
    }

    public function register($d) {
        $rs_chk_reg = $this->mongo_db
            ->where(array(
                '_id'                   => new MongoId($d['personId']),
                'registers.clinic_code' => $this->clinic_code
            ))
            ->count('person');
        if(!$rs_chk_reg) {
            $rs_chk_reg = $this->mongo_db
                ->where('_id', new MongoId($d['personId']))
                ->push('registers', array(
                    'clinic_code'   => $this->clinic_code,
                    'owner_id'      => new MongoId($this->owner_id),
                    'user_id'       => new MongoId($this->user_id),
                    'reg_date'      => $d['date'],
                    'last_update'   => date('Y-m-d H:i:s')
                ))->update('person');
        }

        $rs = $this->mongo_db
            ->insert('ncdscreen', array(
                'person_id'                                 => new MongoId($d['personId']),
                'owner_id'                                  => new MongoId($this->owner_id),
                'date'                                      => $d['date'],
                'time'                                      => $d['time'],
                'weight'                                    => $d['weight'],
                'height'                                    => $d['height'],
                'waist_line'                                => $d['waistLine'],
                'bmi'                                       => $d['bmi'],
                'service_local'                             => $d['serviceLocal'],
                'doctor'                                    => new MongoId($d['doctor']),
                'service_place'                             => $d['pcu'],

                'parental_illness_history_dm'               => $d['historyDm'],
                'parental_illness_history_ht'               => $d['historyHt'],
                'parental_illness_history_gout'             => $d['historyGout'],
                'parental_illness_history_crf'              => $d['historyCrf'],
                'parental_illness_history_mi'               => $d['historyMi'],
                'parental_illness_history_stroke'           => $d['historyStroke'],
                'parental_illness_history_copd'             => $d['historyCopd'],
                'parental_illness_history_unknown'          => $d['historyUnknown'],

                'sibling_illness_history_dm'                => $d['historyDm2'],
                'sibling_illness_history_ht'                => $d['historyHt2'],
                'sibling_illness_history_gout'              => $d['historyGout2'],
                'sibling_illness_history_crf'               => $d['historyCrf2'],
                'sibling_illness_history_mi'                => $d['historyMi2'],
                'sibling_illness_history_stroke'            => $d['historyStroke2'],
                'sibling_illness_history_copd'              => $d['historyCopd2'],
                'sibling_illness_history_unknown'           => $d['historyUnknown2'],

                'history_illness_dm'                        => $d['historyIllnessDm'],
                'history_illness_ht'                        => $d['historyIllnessHt'],
                'history_illness_liver'                     => $d['historyIllnessLiver'],
                'history_illness_paralysis'                 => $d['historyIllnessParalysis'],
                'history_illness_heart'                     => $d['historyIllnessHeart'],
                'history_illness_lipid'                     => $d['historyIllnessLipid'],
                'history_illness_footUlcers'                => $d['historyIllnessFootUlcers'],
                'history_illness_confined'                  => $d['historyIllnessConfined'],
                'history_illness_drink_water_frequently'    => $d['historyIllnessDrinkWaterFrequently'],
                'history_illness_night_urination'           => $d['historyIllnessNightUrination'],
                'history_illness_batten'                    => $d['historyIllnessBatten'],
                'history_illness_weight_down'               => $d['historyIllnessWeightDown'],
                'history_illness_ulcerated_lips'            => $d['historyIllnessUlceratedLips'],
                'history_illness_itchy_skin'                => $d['historyIllnessItchySkin'],
                'history_illness_bleary_eyed'               => $d['historyIllnessBlearyEyed'],
                'history_illness_tea_by_hand'               => $d['historyIllnessTeaByHand'],
                'history_illness_how_to_behave'             => $d['historyIllnessHowToBehave'],
                'history_illness_creased_neck'              => $d['historyIllnessCreasedNeck'],
                'history_illness_history_fpg'               => $d['historyIllnessHistoryFPG'],

                'smoking'                                   => $d['smoking'],
                'of_smoked'                                 => $d['ofSmoked'],
                'time_smoke'                                => $d['timeSmoke'],
                'smoking_number_per_day'                    => $d['smokingNumberPerDay'],
                'smoking_number_per_year'                   => $d['smokingNumberPerYear'],
                'of_smoking'                                => $d['ofSmoking'],
                'smoking_year'                              => $d['smokingYear'],

                'alcohol'                                   => $d['alcohol'],
                'alcohol_per_week'                          => $d['alcoholPerWeek'],

                'exercise'                                  => $d['exercise'],
                'food'                                      => $d['food'],

                'fcg'                                       => $d['fcg'],
                'fpg'                                       => $d['fpg'],
                'ppg'                                       => $d['ppg'],
                'ppg_hours'                                 => $d['ppgHours'],

                'pressure_measurements'                     => $d['ht'],
                'body_screen'                               => $d['bodyScreen']
            ));

        return $rs;
    }

    public function update_ncd_detail($d) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($d['id']))
            ->set(array(
                'person_id'                                 => new MongoId($d['personId']),
                'owner_id'                                  => new MongoId($this->owner_id),
                'date'                                      => $d['date'],
                'time'                                      => $d['time'],
                'weight'                                    => $d['weight'],
                'height'                                    => $d['height'],
                'waist_line'                                => $d['waistLine'],
                'bmi'                                       => $d['bmi'],
                'service_local'                             => $d['serviceLocal'],
                'doctor'                                    => new MongoId($d['doctor']),
                'service_place'                             => $d['pcu'],

                'parental_illness_history_dm'               => $d['historyDm'],
                'parental_illness_history_ht'               => $d['historyHt'],
                'parental_illness_history_gout'             => $d['historyGout'],
                'parental_illness_history_crf'              => $d['historyCrf'],
                'parental_illness_history_mi'               => $d['historyMi'],
                'parental_illness_history_stroke'           => $d['historyStroke'],
                'parental_illness_history_copd'             => $d['historyCopd'],
                'parental_illness_history_unknown'          => $d['historyUnknown'],

                'sibling_illness_history_dm'                => $d['historyDm2'],
                'sibling_illness_history_ht'                => $d['historyHt2'],
                'sibling_illness_history_gout'              => $d['historyGout2'],
                'sibling_illness_history_crf'               => $d['historyCrf2'],
                'sibling_illness_history_mi'                => $d['historyMi2'],
                'sibling_illness_history_stroke'            => $d['historyStroke2'],
                'sibling_illness_history_copd'              => $d['historyCopd2'],
                'sibling_illness_history_unknown'           => $d['historyUnknown2'],

                'history_illness_dm'                        => $d['historyIllnessDm'],
                'history_illness_ht'                        => $d['historyIllnessHt'],
                'history_illness_liver'                     => $d['historyIllnessLiver'],
                'history_illness_paralysis'                 => $d['historyIllnessParalysis'],
                'history_illness_heart'                     => $d['historyIllnessHeart'],
                'history_illness_lipid'                     => $d['historyIllnessLipid'],
                'history_illness_footUlcers'                => $d['historyIllnessFootUlcers'],
                'history_illness_confined'                  => $d['historyIllnessConfined'],
                'history_illness_drink_water_frequently'    => $d['historyIllnessDrinkWaterFrequently'],
                'history_illness_night_urination'           => $d['historyIllnessNightUrination'],
                'history_illness_batten'                    => $d['historyIllnessBatten'],
                'history_illness_weight_down'               => $d['historyIllnessWeightDown'],
                'history_illness_ulcerated_lips'            => $d['historyIllnessUlceratedLips'],
                'history_illness_itchy_skin'                => $d['historyIllnessItchySkin'],
                'history_illness_bleary_eyed'               => $d['historyIllnessBlearyEyed'],
                'history_illness_tea_by_hand'               => $d['historyIllnessTeaByHand'],
                'history_illness_how_to_behave'             => $d['historyIllnessHowToBehave'],
                'history_illness_creased_neck'              => $d['historyIllnessCreasedNeck'],
                'history_illness_history_fpg'               => $d['historyIllnessHistoryFPG'],

                'smoking'                                   => $d['smoking'],
                'of_smoked'                                 => $d['ofSmoked'],
                'time_smoke'                                => $d['timeSmoke'],
                'smoking_number_per_day'                    => $d['smokingNumberPerDay'],
                'smoking_number_per_year'                   => $d['smokingNumberPerYear'],
                'of_smoking'                                => $d['ofSmoking'],
                'smoking_year'                              => $d['smokingYear'],

                'alcohol'                                   => $d['alcohol'],
                'alcohol_per_week'                          => $d['alcoholPerWeek'],

                'exercise'                                  => $d['exercise'],
                'food'                                      => $d['food'],

                'fcg'                                       => $d['fcg'],
                'fpg'                                       => $d['fpg'],
                'ppg'                                       => $d['ppg'],
                'ppg_hours'                                 => $d['ppgHours'],

                'pressure_measurements'                     => $d['ht'],
                'body_screen'                               => $d['bodyScreen']
            ))
            ->update('ncdscreen');

        return $rs;
    }

    public function get_ncd_list($id) {
        $rs = $this->mongo_db
            ->order_by(array('date'=>'DESC', 'time'=>'ASC'))
            ->where('person_id', new MongoId($id))
            ->get('ncdscreen');

        return $rs;
    }

    public function get_standard_detail($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('person');

        return $rs;
    }

    public function remove_ncd($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->delete('ncdscreen');

        return $rs;
    }

    public function get_ncd_detail($id) {
        $rs = $this->mongo_db
            ->where('_id', new MongoId($id))
            ->get('ncdscreen');

        return $rs;
    }
}