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

    public function do_register($data)
    {
        $rs = $this->mongo_db
            ->insert('babies',
            array(
                'hn' => $data['hn'],
                'owner_id' => new MongoId($this->owner_id),
                'provider_id' => new MongoId($this->provider_id),
                'user_id' => new MongoId($this->user_id)
            ));

        return $rs;
    }

}