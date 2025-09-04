<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gen_Eng_Set_1_model extends CI_Model {

    private $table = 'gen_english_set_1'; // ✅ DB table name

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all questions
    public function get_all_questions() {
        return $this->db->get($this->table)->result(); // return as objects
    }

    // Get single question by q_no
    public function get_question($q_no) {
        return $this->db->get_where($this->table, ['Q_no' => $q_no])->row();
    }
}
