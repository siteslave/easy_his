<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin model
 *
 * @package     Model
 * @author      Mr.Satit Rianpit <rianpit@gmail.com>
 * @since       Version 1.0.0
 * @copyright   Copyright 2013 Data center of Maha Sarakham Hospital
 * @license     http://his.mkh.go.th/licenses
 */

class Admin extends CI_Model {

    public $owner_id;
    public $user_id;

    public function __construct()
    {
        parent::__construct();
    }
}