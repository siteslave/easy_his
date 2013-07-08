<?php
class Chronicfu_model extends CI_Model
{
    public $owner_id;
    public $user_id;

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_chronicfu', array(
                'vn' => (string) $data['vn'],
                'hn' => (string) $data['hn'],
                'eye_result_left' => $data['eye_result_left'],
                'eye_result_right' => $data['eye_result_right'],
                'eye_va_left' => $data['eye_va_left'],
                'eye_va_right' => $data['eye_va_right'],
                'eye_iop_left' => $data['eye_iop_left'],
                'eye_iop_right' => $data['eye_iop_right'],
                'eye_oth_dz_left' => $data['eye_oth_dz_left'],
                'eye_oth_dz_right' => $data['eye_oth_dz_right'],
                'eye_macular' => $data['eye_macular'],
                'eye_laser' => $data['eye_laser'],
                'eye_cataract' => $data['eye_cataract'],
                'eye_surgery' => $data['eye_surgery'],
                'eye_blindness' => $data['eye_blindness'],
                'eye_treatment' => $data['eye_treatment'],
                'eye_remark' => $data['eye_remark'],
                'foot_result_left' => $data['foot_result_left'],
                'foot_result_right' => $data['foot_result_right'],
                'foot_ulcer' => $data['foot_ulcer'],
                'foot_his_ulcer' => $data['foot_his_ulcer'],
                'foot_his_amp' => $data['foot_his_amp'],
                'foot_his_sens' => $data['foot_his_sens'],
                'foot_nail' => $data['foot_nail'],
                'foot_wart' => $data['foot_wart'],
                'foot_footshape' => $data['foot_footshape'],
                'foot_hair' => $data['foot_hair'],
                'foot_temp' => $data['foot_temp'],
                'foot_tenia' => $data['foot_tenia'],
                'foot_sensory' => $data['foot_sensory'],
                'foot_dieskin' => $data['foot_dieskin'],
                'foot_skincolor' => $data['foot_skincolor'],
                'foot_posttib_left' => $data['foot_posttib_left'],
                'foot_posttib_right' => $data['foot_posttib_right'],
                'foot_dorsped_left' => $data['foot_dorsped_left'],
                'foot_dorsped_right' => $data['foot_dorsped_right'],
                'foot_shoe' => $data['foot_shoe'],
                'foot_remark' => $data['foot_remark'],
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ));

        return $rs;
    }
    public function update($data)
    {
        $this->mongo_db->add_index('visit_chronicfu', array('hn' => -1));
        $this->mongo_db->add_index('visit_chronicfu', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'vn' => (string) $data['vn']))
            ->set(array(
                'eye_result_left' => $data['eye_result_left'],
                'eye_result_right' => $data['eye_result_right'],
                'eye_va_left' => $data['eye_va_left'],
                'eye_va_right' => $data['eye_va_right'],
                'eye_iop_left' => $data['eye_iop_left'],
                'eye_iop_right' => $data['eye_iop_right'],
                'eye_oth_dz_left' => $data['eye_oth_dz_left'],
                'eye_oth_dz_right' => $data['eye_oth_dz_right'],
                'eye_macular' => $data['eye_macular'],
                'eye_laser' => $data['eye_laser'],
                'eye_cataract' => $data['eye_cataract'],
                'eye_surgery' => $data['eye_surgery'],
                'eye_blindness' => $data['eye_blindness'],
                'eye_treatment' => $data['eye_treatment'],
                'eye_remark' => $data['eye_remark'],
                'foot_result_left' => $data['foot_result_left'],
                'foot_result_right' => $data['foot_result_right'],
                'foot_ulcer' => $data['foot_ulcer'],
                'foot_his_ulcer' => $data['foot_his_ulcer'],
                'foot_his_amp' => $data['foot_his_amp'],
                'foot_his_sens' => $data['foot_his_sens'],
                'foot_nail' => $data['foot_nail'],
                'foot_wart' => $data['foot_wart'],
                'foot_footshape' => $data['foot_footshape'],
                'foot_hair' => $data['foot_hair'],
                'foot_temp' => $data['foot_temp'],
                'foot_tenia' => $data['foot_tenia'],
                'foot_sensory' => $data['foot_sensory'],
                'foot_dieskin' => $data['foot_dieskin'],
                'foot_skincolor' => $data['foot_skincolor'],
                'foot_posttib_left' => $data['foot_posttib_left'],
                'foot_posttib_right' => $data['foot_posttib_right'],
                'foot_dorsped_left' => $data['foot_dorsped_left'],
                'foot_dorsped_right' => $data['foot_dorsped_right'],
                'foot_shoe' => $data['foot_shoe'],
                'foot_remark' => $data['foot_remark'],
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
        ->update('visit_chronicfu');

        return $rs;
    }

    public function remove($hn, $vn)
    {
        $this->mongo_db->add_index('visit_chronicfu', array('hn' => -1));
        $this->mongo_db->add_index('visit_chronicfu', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->delete('visit_chronicfu');

        return $rs;
    }

    public function check_exist($hn, $vn)
    {
        $this->mongo_db->add_index('visit_chronicfu', array('hn' => -1));
        $this->mongo_db->add_index('visit_chronicfu', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->count('visit_chronicfu');

        return $rs > 0 ? TRUE : FALSE;
    }

    public function get_detail($hn, $vn)
    {
        $this->mongo_db->add_index('visit_chronicfu', array('hn' => -1));
        $this->mongo_db->add_index('visit_chronicfu', array('vn' => -1));

        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->limit(1)
            ->get('visit_chronicfu');

        return $rs ? $rs[0] : NULL;
    }
}