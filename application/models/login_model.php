<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Check user with email + phone
    public function login($email, $phone) {
        $this->db->where('email', $email);
        $this->db->where('phone', $phone);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            return $query->row(); // return user details
        } else {
            return false;
        }
    }
}
