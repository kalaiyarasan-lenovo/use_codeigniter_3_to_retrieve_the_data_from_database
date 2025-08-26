<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class new_wel extends CI_Controller {
    public function index(){
        $this->load->helper('url');
        $this->load->library("session");
        $this->load->view("new_welcome_msg");
    }
    public function save(){
        $this->load->helper('url'); 
        $this->load->library("session");
        $name = $this->input->post("name");
        $this->session->set_userdata('savename',$name);
        redirect('new_wel');
    }

    public function clear(){
        $this->load->helper('url'); 
        $this->load->library("session");
        $this->session->unset_userdata('savename');
        redirect('new_wel');
    }
}
?>