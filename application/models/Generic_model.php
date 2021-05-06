<?php
class Generic_model extends CI_Model
{

    function getRoleList(){
        $query = $this->db->get('rolelist');
        $results = $query->result();
        return $results;
    }

    function getAccessList(){
        $query = $this->db->get('accessList');
        $results = $query->result();
        return $results;
    }

    function getJudicialStatusList(){
        $query = $this->db->get('judicialstatuslist');
        $results = $query->result();
        return $results;
    }

    function getAdministrativeStatusList(){
        $query = $this->db->get('administrativestatuslist');
        $results = $query->result();
        return $results;
    }

    function getSubjectList(){
        $query = $this->db->get('subjectlist');
        $results = $query->result();
        return $results;
    }

    function setRolePrivilegeAccess($data){
        $this->db->empty_table('roleprivilegeaccess');
        $this->db->query('ALTER TABLE roleprivilegeaccess AUTO_INCREMENT 1');
        if( !empty($data) ){
            $results = $this->db->insert_batch('roleprivilegeaccess', $data);
            return $results;
        }
    }

    function getRolePrivilegeAccess(){
        //$this->db->join('rolelist', 'rolelist.id = roleprivilegeaccess.roleID', 'left');
        //$this->db->join('accesslist', 'accesslist.id = roleprivilegeaccess.accessID', 'left');
        $query = $this->db->get('roleprivilegeaccess');
        $results = $query->result();
        return $results;
    }

    function getPrivilegeAccessByRole($data){
        $this->db->where('roleprivilegeaccess.' . $data['searchBy'], $data['value']);
        //$this->db->join('rolelist', 'rolelist.id = roleprivilegeaccess.roleID', 'left');
        //$this->db->join('accesslist', 'accesslist.id = roleprivilegeaccess.accessID', 'left');
        $query = $this->db->get('roleprivilegeaccess');
        $results = $query->result();
        return $results;
    }
}

?>