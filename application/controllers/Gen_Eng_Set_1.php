<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gen_Eng_Set_1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Gen_Eng_Set_1_model');
    }

    public function index() {
        // Load all questions from model
        $data['questions'] = $this->Gen_Eng_Set_1_model->get_all_questions();

        // Load view
        $this->load->view('gen_eng_set_1', $data);
    }
}
