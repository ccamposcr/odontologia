<?php
class Citas_model extends CI_Model
{
    function addAppointment($data){       
        $results = $this->db->insert('userappointment', $data);
        return $results;
    }

    function getAppointmentsByDateRange($data){
        $this->db->select('userappointment.id appointmentID, userappointment.userID, userappointment.date, user.name userName, user.lastName1, user.lastName2');
        $this->db->from('userappointment');
        $this->db->where('userappointment.' . $data['searchBy'] . '>=', $data['start']);
        $this->db->where('userappointment.' . $data['searchBy'] . '<=', $data['end']);
        $this->db->join('user', 'user.id = userappointment.userID', 'left');
        $query = $this->db->get();
        $results = $query->result();
        return $results;
    }

    function cancelAppointment($data){
        $results = $this->db->delete('userappointment', $data);
        return $results;
    }
}

?>