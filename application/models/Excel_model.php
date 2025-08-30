<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Insert multiple rows into mcq_questions
    public function insert_batch($data) {
        return $this->db->insert_batch('mcq_questions_answers', $data);
    }

    // Fetch all rows (optional, for display)
    public function get_all() {
        return $this->db->get('mcq_questions')->result_array();
    }
}
