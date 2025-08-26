<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class excel_retrieve extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model("excel_retrieve_model");
    }

    // Show all questions as MCQ test
    public function display(){
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
}
?>
