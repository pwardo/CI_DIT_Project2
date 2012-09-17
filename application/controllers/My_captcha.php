<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class My_captcha extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('My_captcha_model');
    }

    public function index() {

        // form validation 3 parameters:
        // name of field to chack
        // name that we will return in the error message
        // and the rule

        $this->form_validation->set_rules('name', 'name', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('email', 'email', 'trim|strip_tags|xss_clean|required|valid_email');
        $this->form_validation->set_rules('comment', 'comment', 'trim|strip_tags|xss_clean|required|max_length[10]');
        $this->form_validation->set_rules('captcha', 'captcha', 'trim|strip_tags|xss_clean|callback_captcha_check|match_captcha[captcha.word]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'My_captcha Controller';
            $data['image'] = $this->My_captcha_model->create_image();

            $this->load->view('header_view', $data);
            $this->load->view('captcha_content', $data);
        } else{
            if($this->input->post('comment')){
                $email = $this->input->post('email');
                $comment = $this->input->post('comment');
                
                $this->db->insert('comments', array('email' => $email, 'comment' => $comment));
                
                $this->load->view('captcha_comment_success');
            }
        }
    }
    
    function captcha_check($value){
        if($value == ''){
            $this->form_validation->set_message('captcha_check', 'Please enter the text shown above to submit your comment.');
            return FALSE;
        } else{
            return TRUE;
        }
    }

}