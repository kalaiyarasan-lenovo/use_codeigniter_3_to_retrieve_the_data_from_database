<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users'; // database table name

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Insert new user (used in signup)
    public function insert_user($data) {
        return $this->db->insert($this->table, $data);
    }

    // Check if email or phone already exists
    public function check_exists($email, $phone) {
        $this->db->where('email', $email);
        $this->db->or_where('phone', $phone);
        $query = $this->db->get($this->table);
        return $query->num_rows() > 0;
    }

    // Get user by email
    public function get_user_by_email($email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    // (Optional) Check login by email only (no password)
    public function check_login($email) {
        return $this->get_user_by_email($email);
    }
}
