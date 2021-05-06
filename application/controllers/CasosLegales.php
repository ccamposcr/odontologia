<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CasosLegales extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('casosLegales_model');
    }
    
    function addLegalCase(){
        $data = array(
            'internalCode' => $this->input->post('internalCode'),
            'subjectID' => $this->input->post('subjectID'), 
            'userID' => $this->input->post('userID'), 
            'judicialStatusID' => $this->input->post('judicialStatusID'),
            'administrativeStatusID' => $this->input->post('administrativeStatusID'), 
            'nextNotification' => $this->input->post('nextNotification'),
            'locationID' => $this->input->post('locationID')
        );

        $legalCaseID = $this->casosLegales_model->addLegalCase($data);

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'legalCaseID' => $legalCaseID
        );

        echo json_encode($response);
    }

    function addLegalCaseNote(){
        $data = array(
            'note' => $this->input->post('note'),
            'legalCaseID' => $this->input->post('legalCaseID'),
            'userID' => $this->input->post('userID')
        );

        $this->casosLegales_model->addLegalCaseNote($data);

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        echo json_encode($response);
    }

    function editLegalCase(){
        $data = array(
            'internalCode' => $this->input->post('internalCode'),
            'subjectID' => $this->input->post('subjectID'), 
            'userID' => $this->input->post('userID'), 
            'judicialStatusID' => $this->input->post('judicialStatusID'),
            'administrativeStatusID' => $this->input->post('administrativeStatusID'),
            'nextNotification' => $this->input->post('nextNotification'),
            'locationID' => $this->input->post('locationID')
        );
        
        $id = $this->input->post('id');
        $this->casosLegales_model->editLegalCase($id, $data);

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        echo json_encode($response);
    }

    function getLegalCasesBy(){
        $data = array(
            'searchBy' => $this->input->post('searchBy'), 
            'value' => $this->input->post('value')
        );

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'response' => $this->casosLegales_model->getLegalCasesBy($data)
        );

        echo json_encode($response);
    }

    function getLegalCaseNotesBy(){
        $data = array(
            'searchBy' => $this->input->post('searchBy'), 
            'value' => $this->input->post('value')
        );

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'response' => $this->casosLegales_model->getLegalCaseNotesBy($data)
        );

        echo json_encode($response);
    }

    function getLegalCasesByDateRange(){
        $data = array(
            'searchBy' => $this->input->post('searchBy'), 
            'start' => $this->input->post('start'),
            'end' => $this->input->post('end')
        );

        $response = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash(),
            'response' => $this->casosLegales_model->getLegalCasesByDateRange($data)
        );

        echo json_encode($response);
    }
    
}

?>