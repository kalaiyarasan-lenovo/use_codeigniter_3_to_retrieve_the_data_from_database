<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class excel_retrieve_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all questions
    public function display_records() {
        $query = $this->db->get('mcq_questions_answers');
        return $query->result();
    }

    // Get single question by ID
    public function get_question_by_id($q_no) {
        $query = $this->db->get_where('mcq_questions', array('q_no' => $q_no));
        return $query->row();
    }

    // Count total questions
    public function count_questions() {
        return $this->db->count_all('mcq_questions');
    }

    // Check if user answer is correct
    public function check_answer($q_no, $user_answer) {
        $this->db->select('E_correct_option');
        $this->db->where('q_no', $q_no);
        $query = $this->db->get('mcq_questions');
        $row = $query->row();

        if ($row && $row->E_correct_option == $user_answer) {
            return true; // correct
        }
        return false; // wrong
    }
}
?>
