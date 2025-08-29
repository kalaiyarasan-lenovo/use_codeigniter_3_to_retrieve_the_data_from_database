<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load helpers, libraries
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper(array('form', 'url'));
    }

    // Form to get username & email
    public function index() {
        $this->load->view('auth_form'); // simple form (username, email, submit)
    }

    // Send OTP
    public function send_otp() {
        $username = $this->input->post('username');
        $email    = $this->input->post('email');

        // ✅ Generate OTP
        $otp = rand(100000, 999999);

        // ✅ Store OTP in session
        $this->session->set_userdata('otp', $otp);
        $this->session->set_userdata('email', $email);

        // ✅ Email Config
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_user' => 'kalai2003testing@gmail.com',   // your email
            'smtp_pass' => 'wmpuudckyedcgesf',             // ⚠️ app password
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'smtp_crypto' => 'tls'
        );

        $this->email->initialize($config);
        $this->email->from('kalai2003testing@gmail.com', 'My App');
        $this->email->to($email);
        $this->email->subject('Your OTP Code');

        $message = "
            <h2>Hello, $username</h2>
            <p>Your One-Time Password (OTP) is:</p>
            <h3 style='color:blue;'>$otp</h3>
            <p>Please use this code to verify your email. It will expire in 5 minutes.</p>
        ";
        $this->email->message($message);

        if ($this->email->send()) {
            redirect('auth/verify');
        } else {
            echo $this->email->print_debugger();
        }
    }

    // Verify OTP page
    public function verify() {
        $this->load->view('verify_otp'); // form to input OTP
    }

    // Check OTP
    public function check_otp() {
        $input_otp   = $this->input->post('otp');
        $session_otp = $this->session->userdata('otp');

        if ($input_otp == $session_otp) {
            // ✅ OTP correct → redirect to dashboard
            redirect('excel_retrieve/display');
        } else {
            // ❌ Invalid OTP → reload verify page with error
            $this->session->set_flashdata('error', '❌ Invalid OTP! Please try again.');
            redirect('auth/verify');
        }
    }
}
