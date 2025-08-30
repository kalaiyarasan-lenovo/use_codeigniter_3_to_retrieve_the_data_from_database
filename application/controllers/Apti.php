<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apti extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Apti_model');
    }

    // Show all questions
    public function index() {
        $data['data'] = $this->Apti_model->get_all_questions();
        $this->load->view('apti_view', $data);
    }
}
