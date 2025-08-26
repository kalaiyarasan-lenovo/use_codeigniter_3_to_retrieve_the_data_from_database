<?php
class User_data_model extends CI_Model{
    function savedata($data){
        $this->db->insert("user_data",$data);
        return true;
    }
}
?>