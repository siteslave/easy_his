<?php
class Depress_model extends CI_Model
{
    public $owner_id;
    public $user_id;

    public function save($data)
    {
        $rs = $this->mongo_db
            ->insert('visit_depress', array(
                'vn' => (string) $data['vn'],
                'hn' => (string) $data['hn'],
                'q21' => (string) $data['q21'],
                'q22' => (string) $data['q22'],
                'q91' => (string) $data['q91'],
                'q92' => (string) $data['q92'],
                'q93' => (string) $data['q93'],
                'q94' => (string) $data['q94'],
                'q95' => (string) $data['q95'],
                'q96' => (string) $data['q96'],
                'q97' => (string) $data['q97'],
                'q98' => (string) $data['q98'],
                'q99' => (string) $data['q99'],
                'user_id' => new MongoId($this->user_id),
                'owner_id' => new MongoId($this->owner_id),
                'last_update' => date('Y-m-d H:i:s')
            ));

        return $rs;
    }

    public function update($data)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $data['hn'], 'vn' => (string) $data['vn']))
            ->set(array(
                'q21' => (string) $data['q21'],
                'q22' => (string) $data['q22'],
                'q91' => (string) $data['q91'],
                'q92' => (string) $data['q92'],
                'q93' => (string) $data['q93'],
                'q94' => (string) $data['q94'],
                'q95' => (string) $data['q95'],
                'q96' => (string) $data['q96'],
                'q97' => (string) $data['q97'],
                'q98' => (string) $data['q98'],
                'q99' => (string) $data['q99'],
                'user_id' => new MongoId($this->user_id),
                'last_update' => date('Y-m-d H:i:s')
            ))
            ->update('visit_depress');

        return $rs;
    }

    public function detail($hn, $vn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->get('visit_depress');

        return $rs ? $rs[0] : NULL;
    }
    public function remove($hn, $vn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->delete('visit_depress');

        return $rs;
    }

    public function check_exist($hn, $vn)
    {
        $rs = $this->mongo_db
            ->where(array('hn' => (string) $hn, 'vn' => (string) $vn))
            ->count('visit_depress');

        return $rs > 0 ? TRUE : FALSE;
    }
}