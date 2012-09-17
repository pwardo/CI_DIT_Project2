<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index() {

//        $user_name = $this->input->post('user_name');
//        $password = $this->input->post('password');

        // Form Validation
        $this->form_validation->set_rules('user_name', 'Username', 'strip_tags|trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() === FALSE) { // if username and password not entered
            $data['error_message'] = "Please enter your password";

            $data['title'] = "Login Page";
            $this->load->view('header_view', $data);
            $this->load->view('login_view', $data);
            $this->load->view('footer_view');

        } else {

            $name = $this->input->post('user_name');
            $password = $this->input->post('password');

            $this->load->model('login_model');
            $result = $this->login_model->get_user($name, $password);

            if ($result === TRUE) {

                // get user permissions
                $config['userID'] = $this->session->userdata['user_id'];
                $this->load->library('acl',$config);
                
                if($this->acl->hasPermission('access_system') === TRUE){
                    redirect(base_url() . 'system_admin');
                } 
                else if($this->acl->hasPermission('access_admin') === TRUE){
                    redirect(base_url() . 'admin');
                } 
                else if($this->acl->hasPermission('access_lecturer') === TRUE){
                    redirect(base_url() . 'lecturer');
                }
                else if($this->acl->hasPermission('access_student') === TRUE){
                    redirect(base_url() . 'student');
                }
                
            } else {
                if ($result === FALSE) {

                    $data['error_message'] = "Invalid Username or Password.";

                    $data['title'] = "Login Page";
                    $this->load->view('header_view', $data);
                    $this->load->view('login_view', $data);
                    $this->load->view('footer_view');
                    
                } else if ($result === 'locked') {

                    $data['error_message'] = "Your account has been locked. <a href=".base_url().'unlock_account'."/>Unlock Account</a> ";

                    $data['disabled'] = 'disabled'; 
                    $data['title'] = "Login Page";
                    $this->load->view('header_view', $data);
                    $this->load->view('login_view', $data);
                    $this->load->view('footer_view');
                }
            }
        }
    }
}