<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Women Model
 *
 * @package     Model
 * @author      Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mhkdc.com/licenses
 */

class Women_model extends CI_Model
{

    public $owner_id;
    public $user_id;
    public $provider_id;

    public function __construct()
    {
        parent::__construct();
    }

}

//End of file