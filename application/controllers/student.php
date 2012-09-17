<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller{
    public function index(){
        $data['title'] = 'Student Index page.';
        
        $this->load->view('header_view', $data);
        $this->load->view('student_views/student_nav');
        $this->load->view('student_views/student_content');
        $this->load->view('footer_view');
    }
    
    public function logout(){
        redirect(base_url().'logout');
    }
}