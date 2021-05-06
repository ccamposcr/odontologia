<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        if (!in_array("8", json_decode($this->session->userdata('roleAccessList')))) {
            redirect('denied');
        }
        $this->load->library('form_validation');
        $this->load->model('generic_model');
    }
    
    function index(){
        $data['title'] = 'Administracion';
        $this->load->view('global/header', $data);
        $this->load->view('global/welcome');
        $this->load->view('global/navigation');
        $this->load->view('global/body');
        $this->load->view('global/footer');
    }
    
}

?>