<?php
class Login_model extends CI_Model
{

    function login($personalID){
        $this->db->select('id, name, lastName1, lastName2, roleID, password');
        $this->db->where('personalID', $personalID);
        $this->db->where('status', '1');
        $query = $this->db->get('user');
        $results = $query->row();
       
        return $results;
    }
}

?>