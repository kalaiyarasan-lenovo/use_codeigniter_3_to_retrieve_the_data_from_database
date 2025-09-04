<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Insert multiple rows into mcq_questions
    public function insert_batch($data) {
        return $this->db->insert_batch('gen_english_set_1', $data);
    }

    // Fetch all rows (optional, for display)
    public function get_all() {
        return $this->db->get('gen_english_set_1')->result_array();
    }
}
