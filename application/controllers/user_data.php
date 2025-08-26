<?php
class User_data extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model("user_data_model");
        $this->load->helper('url');
    }


    public function savedata(){
        $this->load->view('insert');
        if($this->input->post('save')){
            $data['user_name']=$this->input->post('user_name');
            $data['email']=$this->input->post('email');
            $data['password']=$this->input->post('password');
            $data['confirm_pass']=$this->input->post('confirm_pass');
            $response = $this->user_data_model->savedata($data);
            if($response==true){
                echo'inserted successfully';
            }
            else{
                echo 'insertion error';
            }
        }
    }
}
?>