<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_sign1 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model1');
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
    }

    // Signup form
    public function signup() {
        $this->load->view('signup_view1');
    }

    // Signup process
    public function register() {
        $username = $this->input->post('username', true);
        $email    = $this->input->post('email', true);
        $phone    = $this->input->post('phone', true);

        // Check if exists
        if ($this->User_model1->check_exists($email, $phone)) {
            $this->session->set_flashdata('error', 'Email or Phone already exists!');
            redirect('user_sign1/signup');
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'phone'    => $phone
        ];

        if ($this->User_model1->insert_user($data)) {
            $this->session->set_flashdata('success', 'Signup successful!');
            redirect('user_sign1/signup');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong, try again.');
            redirect('user_sign1/signup');
        }
    }
}
