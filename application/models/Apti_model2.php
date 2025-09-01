<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apti_model2 extends CI_Model {

    private $table = 'apti_reas_set_2'; // ✅ your table

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all questions
    public function get_all_questions() {
        return $this->db->get($this->table)->result(); // return objects
    }

    // Get single question by q_no (optional)
    public function get_question($q_no) {
        return $this->db->get_where($this->table, ['q_no' => $q_no])->row();
    }
}
