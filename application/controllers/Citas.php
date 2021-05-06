<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Citas extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('citas_model');
    }

    function addAppointment(){
        $data = array(
            'userID' => $this->input->post('userID'), 
            'date' => $this->input->post('date')
        );
        
        $this->citas_model->addAppointment($data);

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        echo json_encode($response);
    }

    function getAppointmentsByDateRange(){
        $data = array(
            'searchBy' => $this->input->post('searchBy'), 
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end')
        );

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'response' => $this->citas_model->getAppointmentsByDateRange($data)
        );

        echo json_encode($response);
    }

    function cancelAppointment(){
        $data = array(
            'id' => $this->input->post('id')
        );
        
        $this->citas_model->cancelAppointment($data);

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        echo json_encode($response);
    }
    
}

?>