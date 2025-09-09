<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Login_with_pass extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->model('login_model');
    }

    // Show login form
    public function index() {
        $this->load->view('login_page'); // your HTML page
    }

    // Handle login check
    public function login() {
    // Set validation rules
    $this->form_validation->set_rules('username', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('password', 'Phone', 'required');

    if ($this->form_validation->run() == FALSE) {
        // Validation failed → show errors
        $this->load->view('login_page');
    } else {
        $email = $this->input->post('username');
        $phone = $this->input->post('password');

        $user = $this->login_model->login($email, $phone);

        if ($user) {
            // Save session
            $this->session->set_userdata('user_id', $user->id);
            $this->session->set_userdata('username', $user->username);
            redirect('welcome');
        } else {
            // Custom error message for invalid login
            $data['login_error'] = "Invalid Gmail or Phone Number!";
            $this->load->view('login_page', $data);
        }
    }
}


    // Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('login_with_pass');
    }
}
