<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_sign extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    // Signup form
    public function signup() {
        $this->load->view('signup_view');
    }

    // Signup process
    public function register() {
        $username = $this->input->post('username', true);
        $email    = $this->input->post('email', true);
        $phone    = $this->input->post('phone', true);

        // Check if exists
        if ($this->User_model->check_exists($email, $phone)) {
            $this->session->set_flashdata('error', 'Email or Phone already exists!');
            redirect('user_sign/signup');
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'phone'    => $phone
        ];

        if ($this->User_model->insert_user($data)) {
            $this->session->set_flashdata('success', 'Signup successful!');
            redirect('user_sign/signup');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, try again.');
            redirect('user_sign/signup');
        }
    }
}
