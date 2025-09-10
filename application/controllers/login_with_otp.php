<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_with_otp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'email']);
        $this->load->helper(['form', 'url']);
        $this->load->database();
    }

    // Show login form
    public function index()
    {
        $this->load->view('login_page_otp');
    }

    // Send OTP
    public function send_otp()
    {
        $email = $this->input->post('email');

        $this->db->where('email', $email);
        $query = $this->db->get('users');

        if ($query->num_rows() == 1) {
            $user = $query->row();

            $otp = rand(100000, 999999);

            $this->session->set_userdata([
                'otp'      => $otp,
                'email'    => $user->email,
                'username' => $user->username,
                'otp_time' => time()
            ]);

            // Email config
            $config = [
                'protocol'    => 'smtp',
                'smtp_host'   => 'smtp.gmail.com',
                'smtp_port'   => 587,
                'smtp_user'   => 'kalai2003testing@gmail.com',
                'smtp_pass'   => 'wmpuudckyedcgesf',
                'mailtype'    => 'html',
                'charset'     => 'utf-8',
                'newline'     => "\r\n",
                'smtp_crypto' => 'tls'
            ];

            $this->email->initialize($config);
            $this->email->from('kalai2003testing@gmail.com', 'My App');
            $this->email->to($user->email);
            $this->email->subject('Your OTP Code');

            $message = "
                <h2>Hello, {$user->username}</h2>
                <p>Your One-Time Password (OTP) is:</p>
                <h3 style='color:blue;'>{$otp}</h3>
                <p>Please use this code to verify your login. It will expire in 5 minutes.</p>
            ";

            $this->email->message($message);

            if ($this->email->send()) {
                $this->session->set_flashdata('success', '✅ OTP sent successfully! Please check your email.');
                $this->session->set_flashdata('otp_sent', true);
                $this->session->set_flashdata('email_entered', $email);
                redirect('login_with_otp');
            } else {
                echo $this->email->print_debugger();
            }
        } else {
            $this->session->set_flashdata('error', '❌ Email not found!');
            redirect('login_with_otp');
        }
    }

    // Validate OTP
    public function check_otp()
    {
        $input_otp   = $this->input->post('otp');
        $session_otp = $this->session->userdata('otp');
        $username    = $this->session->userdata('username');
        $email       = $this->session->userdata('email');
        $otp_time    = $this->session->userdata('otp_time');

        // Expiry check (5 mins)
        if (time() - $otp_time > 300) {
            $this->session->set_flashdata('error', '❌ OTP expired! Please request a new one.');
            redirect('login_with_otp');
            return;
        }

        if ($input_otp == $session_otp) {
            $this->session->set_userdata([
                'logged_in' => true,
                'username'  => $username,
                'email'     => $email
            ]);
            redirect('qr_code');
        } else {
            $this->session->set_flashdata('error', '❌ Invalid OTP! Please try again.');
            redirect('login_with_otp');
        }
    }
}
