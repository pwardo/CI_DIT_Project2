<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('pagination', TRUE);
    }

    public function index() {
        $this->home();
    }

    public function home() {
        $this->load->library('pagination');

        $per_page = $this->config->item('per_page', 'pagination');
        //echo $this->config->item('total_rows', 'pagination');

        $row = $this->uri->segment(3);

        $data['posts'] = $this->blog_model->get_posts($per_page, $row);
        $data['page_links'] = $this->pagination->create_links();

        $this->load->view('header_view');
        $this->load->view('nav_view');
        $this->load->view('blog_view', $data);
        $this->load->view('footer_view');
    }

    public function about() {
        $this->load->view('header_view');
        $this->load->view('nav_view');
        $this->load->view('about_view');
        $this->load->view('footer_view');
    }

    public function contact() {
        $this->load->view('header_view');
        $this->load->view('nav_view');
        $this->load->view('contact_view');
        $this->load->view('footer_view');
    }

    public function post_look_up() {
        $this->form_validation->set_rules('name', 'name', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('email', 'email', 'trim|strip_tags|xss_clean|required|valid_email');
        $this->form_validation->set_rules('comment', 'comment', 'trim|strip_tags|xss_clean|required|max_length[500]');
        $this->form_validation->set_rules('captcha', 'captcha', 'trim|strip_tags|xss_clean|callback_captcha_check|match_captcha[captcha.word]');

        if ($this->form_validation->run() === FALSE) {
            
            // stay on the page
            $id = $this->uri->segment(2, end($this->uri->segment_array()));
            $start = strrpos($id, '_');
            $post_id = substr($id, $start + 1);

            // print_r($this->blog_model->get_post($post_id));

            $data['post'] = $this->blog_model->get_post($post_id);

            // $this->load->model('my_captcha_model');
            $data['image'] = $this->blog_model->create_image();
            
            // get comments
            $data['post_comments'] = $this->blog_model->get_post_comments($post_id);

            $this->load->view('header_view', $data);
            $this->load->view('nav_view');
            $this->load->view('post_view', $data);
            $this->load->view('footer_view');
            
        } else {
            if($this->input->post('comment')){
                
                $post_id = $this->input->post('post_id');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $comment = $this->input->post('comment');
                
                $this->db->insert('blog_comments', array('name' => $name, 'email' => $email, 'comment' => $comment, 'post_id' => $post_id));
                
                redirect(current_url());
            }
        }
    }

    function captcha_check($value) {
        if ($value == '') {
            $this->form_validation->set_message('captcha_check', 'Please enter the text shown above to submit your comment.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

}