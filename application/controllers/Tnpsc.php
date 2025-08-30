<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tnpsc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');


        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth'); // not logged in → back to login
        }
    }

    // Dashboard
    public function dashboard()
    {
        $data['email'] = $this->session->userdata('email');
        $data['username'] = $this->session->userdata('username');
        $this->load->view('tnpsc_dashboard', $data);
    }
    public function group4()
    {
        $this->load->view('tnpsc_group4_dashboard');
    }
    
    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
