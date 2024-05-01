<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('user_model');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->library('session');
    }

    public function index() {
        redirect('auth/create');
    }

    public function create() {
        $data['title'] = 'Register';
        $this->load->view('register_form', $data);
    }

    public function store() {
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[50]|is_unique[users.user_name]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.user_email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        
        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
    
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
            $user_data = array(
                'user_name' => $username,
                'user_email' => $email,
                'user_password_hash' => $hashed_password
            );
            $this->user_model->insert_user($user_data);
    
            redirect('home');
        }
    }

    public function login() {
        $data['title'] = 'Login';
        $this->load->view('login_form', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }

    public function authenticate() {
        $data['title'] = 'Login';
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        $user = $this->user_model->get_user_by_email($email);
    
        if ($user && password_verify($password, $user->user_password_hash)) {
            $this->session->set_userdata('user_id', $user->user_id);

            redirect('home');
        } else {
            $data['error'] = 'Invalid email or password.';
            $this->load->view('login_form', $data);
        }
    }

    public function change_password() {
        $data['title'] = 'Change Password';
        if ($this->input->post()) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_verify_current_password');
            $this->form_validation->set_message('verify_current_password', 'The current password is incorrect.');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
            
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('change_password', $data);
            } else {
                $user_id = $this->session->userdata('user_id');
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                
                if ($this->user_model->verify_password($user_id, $current_password)) {
                    $data['success_message'] = "Your password has successfully changed was successful.";
                    $this->user_model->change_password($user_id, $new_password);
                    $this->load->view('success_page', $data);
                } else {
                    $data['error'] = 'Current password is incorrect.';
                    $this->load->view('change_password', $data);
                }
            }
        } else {
            $this->load->view('change_password', $data);
        }
    }

    public function verify_current_password($password) {
        $user_id = $this->session->userdata('user_id');
        if (!$this->user_model->verify_password($user_id, $password)) {
            $this->form_validation->set_message('verify_current_password', 'The {field} is incorrect.');
            return FALSE;
        }
        return TRUE;
    }
    
}
