<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->config->load('pagination', TRUE);
    }

    public function index() {
        if (!$this->session->userdata('user_name')) {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        } else {
            $config['userID'] = $this->session->userdata['user_id'];
            $this->load->library('acl', $config);

            if ($this->acl->hasPermission('access_system') === TRUE) {
                $data['title'] = "System Admin Page";

                $data['user_name'] = ucfirst($this->session->userdata('user_name'));

                //$data['welcome'] = "Welcome back ".ucfirst($data['user_name']).'.';
                $this->load->view('header_view', $data);
                $this->load->view('system_admin_views/system_nav');
                $this->load->view('system_admin_views/system_content', $data);
                $this->load->view('footer_view');
            } else {
                echo 'No Access';
            }
        }
    }
    
    public function logout() {
        redirect(base_url() . 'logout/');
    }
    
    public function manage_users() {
        if (!$this->session->userdata('user_name')) {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        } else {
            $config['userID'] = $this->session->userdata['user_id'];
            $this->load->library('acl', $config);

            if ($this->acl->hasPermission('access_system') === TRUE) {
                $data['title'] = "System Admin Page";

                $data['user_name'] = ucfirst($this->session->userdata('user_name'));

                $this->load->model('system_model');


                $per_page = $this->config->item('per_page', 'pagination');

                $row = $this->uri->segment(3);

                $data['users'] = $this->system_model->get_users($per_page, $row);
                //$data['page_links'] = $this->pagination->create_links();
                $data['title'] = 'Manage Users';

                $this->load->view('header_view', $data);
                $this->load->view('system_admin_views/system_nav');
                $this->load->view('system_admin_views/list_users', $data);
                $this->load->view('footer_view');
            } else {
                echo 'No Access';
            }
        }
    }

    function manage_roles() {
        echo 'manage_roles';
    }

    function manage_permissions() {
        echo 'manage_permissions';
    }

    function user_look_up() {
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
            if ($this->input->post('comment')) {

                $post_id = $this->input->post('post_id');
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $comment = $this->input->post('comment');

                $this->db->insert('blog_comments', array('name' => $name, 'email' => $email, 'comment' => $comment, 'post_id' => $post_id));

                redirect(current_url());
            }
        }
    }

}
