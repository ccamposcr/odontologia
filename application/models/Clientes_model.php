<?php
class Clientes_model extends CI_Model
{
    function addClient($data){       
        $this->db->insert('user', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function editClient($id, $data){    
        $this->db->where('id', $id);
        $results = $this->db->update('user', $data);
        return $results;
    }

    function getAllClients(){
        $this->db->select('id, personalID, name, lastName1, lastName2, status, phone, email, address, roleID');
        $this->db->order_by('name ASC');
        $this->db->where('roleID', '0');
        $query = $this->db->get('user');
        $results = $query->result();
        return $results;
    }

    function getAllUsers(){
        $this->db->select('user.id id, user.personalID, user.name, user.lastName1, user.lastName2, user.status, user.roleID, rolelist.role');
        $this->db->order_by('user.name ASC');
        $this->db->where('user.roleID !=', '0');
        $this->db->where('user.status', '1');
        $this->db->join('rolelist', 'rolelist.id = user.roleID', 'left');
        $query = $this->db->get('user');
        $results = $query->result();
        return $results;
    }

    function getClientBy($data){
        $this->db->select('id, personalID, name, lastName1, lastName2, status, phone, email, address, roleID');
        $this->db->where($data['searchBy'], $data['value']);
        $query = $this->db->get('user');
        $results = $query->result();
        return $results;
    }

    function updateUser($id, $data){
        $this->db->where('id', $id);
        $results = $this->db->update('user', $data);
        return $results;
    }
}

?>