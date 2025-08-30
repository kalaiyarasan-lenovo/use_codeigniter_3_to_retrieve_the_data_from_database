<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tnpsc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("excel_retrieve_model");


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
    public function online_test1(){
        $result['data'] = $this->excel_retrieve_model->display_records();  
        $this->load->view('excel_retrieve_view', $result);
    }

    // Handle submitted answers
    public function submit_test(){
        $answers = $this->input->post('answer'); // answers submitted from form
        $questions = $this->excel_retrieve_model->display_records(); // get original questions

        $score = 0;
        $total = count($questions);

        echo "<h1>Test Results</h1>";

        if (!empty($answers)) {
            foreach ($questions as $q) {
                $q_no = $q->q_no;
                $user_answer = isset($answers[$q_no]) ? $answers[$q_no] : "Not Answered";
                $correct_answer = $q->E_correct_option;

                // Check correctness
                if ($user_answer == $correct_answer) {
                    $score++;
                    $status = "<span style='color:green;'>Correct</span>";
                } else {
                    $status = "<span style='color:red;'>Wrong</span> (Correct: $correct_answer)";
                }

                echo "<p><b>Q$q_no:</b> {$q->English_Q}<br>";
                echo "Your Answer: $user_answer → $status</p>";
            }

            echo "<h2>Final Score: $score / $total</h2>";

        } else {
            echo "<p>No answers selected.</p>";
        }
    }
    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
