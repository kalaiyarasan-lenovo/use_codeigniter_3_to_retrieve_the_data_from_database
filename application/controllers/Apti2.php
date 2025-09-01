<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apti2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Apti_model2');
    }

    // Show all questions
    public function index() {
        $data['data'] = $this->Apti_model2->get_all_questions();
        $this->load->view('apti2', $data);
    }
}
