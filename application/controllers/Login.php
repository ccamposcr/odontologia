<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    
    public function __construct(){
        parent::__construct();
        if ($this->session->userdata('id')) {
            redirect('inicio');
        }
        $this->load->library('form_validation');
        $this->load->model('login_model');
        $this->load->model('generic_model');
    }
    
    function index(){
        $data['title'] = 'Login';
        $this->load->view('global/header', $data);
        $this->load->view('login');
        $this->load->view('global/footer');
    }

    function verify_hash($plain_password, $hashed_password){
        $result = password_verify($plain_password, $hashed_password);
        return $result;
    }
    
    function validation(){
        
        $this->form_validation->set_rules('personalID', 'Cédula', 'required|trim', 
            array('required' => 'Por favor ingrese una cédula.')
        );
        $this->form_validation->set_rules('password', 'Contraseña', 'required',
            array('required' => 'Por favor ingrese la contraseña.')
        );

        if ($this->form_validation->run()) {
      
            $message = 'Cédula o Contraseña incorrecta';
            $user = $this->login_model->login($this->input->post('personalID'));
            $passwordhashFromBD = $user->password;
            $data['searchBy'] = 'roleID';
            $data['value'] = $user->roleID;


            $roleAccessListResponse = $this->generic_model->getPrivilegeAccessByRole($data);           
            $roleAccessListData = [];

            foreach ($roleAccessListResponse as $obj) {
                $accessID = $obj->accessID;
                array_push($roleAccessListData, $accessID);
            }
            $roleAccessListData = json_encode($roleAccessListData);
            $accessListData = json_encode($this->generic_model->getAccessList());

            if($passwordhashFromBD){
                $passwordVerification = $this->verify_hash($this->input->post('password'), $passwordhashFromBD);
            
                if($passwordVerification){

                    $this->session->set_userdata('personalID', $this->input->post('personalID'));
                    $this->session->set_userdata('roleID', $user->roleID);
                    $this->session->set_userdata('id', $user->id);
                    $this->session->set_userdata('fullname', $user->name . ' ' . $user->lastName1 . ' ' . $user->lastName2);
                    $this->session->set_userdata('roleAccessList', $roleAccessListData);
                    $this->session->set_userdata('accessList', $accessListData);
                    redirect('inicio');
                    
                }
            }

            $this->session->set_flashdata('message', $message);
            redirect('login');
        } else {
            $this->index();
        }
    }
    
}

?>