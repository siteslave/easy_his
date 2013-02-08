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
            ->count('babies');

        return $rs > 0 ? TRUE : FALSE;
    }

}