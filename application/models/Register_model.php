<?php
class Register_model extends CI_Model
{
    function createUser($data){
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
}

?>
