<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        if (!in_array("7", json_decode($this->session->userdata('roleAccessList')))) {
            redirect('denied');
        }
        $this->load->library('form_validation');
        $this->load->model('register_model');
        $this->load->model('generic_model');
    }
    
    function index(){
        $data['title'] = 'Register';
        $data['roleList'] = $this->generic_model->getRoleList();
        $this->load->view('global/header', $data);
        $this->load->view('global/welcome');
        $this->load->view('global/navigation');
        $this->load->view('register', $data);
        $this->load->view('global/footer');
    }

    function hash_password($password){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $hashed_password;
    }
    
    function validation(){
        //$this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('roleID', 'Rol', 'required|trim',
            array('required' => 'Por favor seleccione el rol')
        );
        $this->form_validation->set_rules('personalID', 'Cedula', 'required|trim|is_unique[user.personalID]',
            array('required' => 'Por favor ingrese una cédula.', 'is_unique' => 'La cédula ingresada ya existe')
        );
        $this->form_validation->set_rules('name', 'Nombre', 'required|trim',
            array('required' => 'Por favor ingrese un nombre')
        );
        $this->form_validation->set_rules('lastName1', 'Apellido', 'required|trim',
            array('required' => 'Por favor ingrese el primer apellido')
        );
        $this->form_validation->set_rules('lastName2', 'Apellido', 'required|trim',
            array('required' => 'Por favor ingrese el segundo apellido')
        );
        $this->form_validation->set_rules('password', 'Contraseña', 'required', 
            array('required' => 'Por favor ingrese una contraseña')
        );
        $this->form_validation->set_rules('confirmPassword', 'Confirmar contraseña', 'required|matches[password]', 
            array('required' => 'Por favor ingrese una contraseña', 'matches' => 'Ambas contraseñas deben ser iguales')
        );
        if ($this->form_validation->run()) {
            $verificationKey    = md5(rand());
            $encrypted_password = $this->hash_password($this->input->post('password'));
            $data               = array(
                'roleID' => $this->input->post('roleID'),
                'personalID' => $this->input->post('personalID'),
                'name' => $this->input->post('name'),
                //'email' => $this->input->post('email'),
                'lastName1' => $this->input->post('lastName1'),
                'lastName2' => $this->input->post('lastName2'),
                'password' => $encrypted_password,
                'status' => '1',
                'verificationKey' => $verificationKey
            );
            $id = $this->register_model->createUser($data);
            $message = 'Usuario Creado';
            $this->session->set_flashdata('message', $message);
            redirect('register');
        } else {
            $this->index();
        }
    }
}

?>