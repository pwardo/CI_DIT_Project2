<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->jquery->script(base_url() . 'js/jquery.js', TRUE);
        $this->jquery->script(base_url() . 'js/jquery-ui-1.8.21.custom.min.js', TRUE);
        $this->load->model('admin_model');
        $this->admin_model->javascript_functions();

        if (!$this->session->userdata('user_name')) {
            //echo "You are not logged in";
            redirect(base_url() . 'login');
        } else {
            $config['userID'] = $this->session->userdata['user_id'];
            $this->load->library('acl', $config);
            if (!$this->acl->hasPermission('access_admin') === TRUE) {
                redirect(base_url() . 'logout');
            }
        }
    }

    public function index() {
//        if (!$this->session->userdata('user_name')) {
//            //echo "You are not logged in";
//            redirect(base_url() . 'login');
//        } else {
//            $config['userID'] = $this->session->userdata['user_id'];
//            $this->load->library('acl', $config);
//
//            if ($this->acl->hasPermission('access_admin') === TRUE) {
        $data['title'] = "Admin Page";

        $data['user_name'] = ucfirst($this->session->userdata('user_name'));

        //$data['welcome'] = "Welcome back ".ucfirst($data['user_name']).'.';
        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/admin_content', $data);
        $this->load->view('footer_view');
//            } else {
//                echo 'No Access';
//            }
//        }
    }

    public function logout() {
        redirect(base_url() . 'logout/');
    }

    //--------------------------------------------------------------------------------------------------------

    /*
     * User Managment functions 
     */
    public function manage_users() {
        $this->load->library('pagination');

        $this->config->load('pagination_courses', TRUE);
        $config['base_url'] = base_url() . 'admin/manage_users';
        ;

        $config['total_rows'] = $this->admin_model->count_users();
        $config['per_page'] = $this->config->item('per_page', 'pagination_courses');
        $config['num_links'] = $this->config->item('num_links', 'pagination_courses');
        $config['use_page_numbers'] = $this->config->item('use_page_numbers', 'pagination_courses');

        $per_page = $config['per_page'];

        $row = $this->uri->segment(3);

        $this->pagination->initialize($config);

        $data['title'] = 'User List';
        $data['users'] = $this->admin_model->get_users($per_page, $row);

        $data['page_links'] = $this->pagination->create_links($config);


        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/user_list', $data);
        $this->load->view('footer_view');
    }

    public function manage_locked_users() {
        $this->load->library('pagination');

        $this->config->load('pagination_courses', TRUE);
        $config['base_url'] = base_url() . 'admin/manage_locked_users';

        $config['total_rows'] = $this->admin_model->count_locked_users();
        $config['per_page'] = $this->config->item('per_page', 'pagination_courses');
        $config['num_links'] = $this->config->item('num_links', 'pagination_courses');
        $config['use_page_numbers'] = $this->config->item('use_page_numbers', 'pagination_courses');

        $per_page = $config['per_page'];

        $row = $this->uri->segment(3);

        $this->pagination->initialize($config);

        $data['title'] = 'User List';
        $data['users'] = $this->admin_model->locked_users($per_page, $row);

        $data['page_links'] = $this->pagination->create_links($config);


        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/user_list', $data);
        $this->load->view('footer_view');
    }

    public function unlock() {
        $id = $this->uri->segment(3, end($this->uri->segment_array()));
        $this->admin_model->unlock_user($id);

        redirect(base_url() . 'admin/manage_users');
    }

    public function user_look_up() {
        // stay on the page
        $id = $this->uri->segment(2, end($this->uri->segment_array()));
        $start = strrpos($id, '_');
        $user_id = substr($id, $start);

        $data['user'] = $this->admin_model->get_user($user_id);
        $data['user_sessions'] = $this->admin_model->get_user_sessions($user_id);

        $data['title'] = 'Details User ID : ' . $user_id;

        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/user_view', $data);
        $this->load->view('footer_view');
    }

    private function _add_user() {
        $db_result = $this->admin_model->get_user_roles();

        $dd_menu = array();

        foreach ($db_result->result_array() as $tablerow) {

            $dd_menu[$tablerow['id']] = $tablerow['roleName'];
        }

        $data['title'] = 'Add a new user';
        $data['options'] = $dd_menu;

        $this->form_validation->set_rules('roles', 'User Type', 'required|xss_clean');

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/add_new_user_view', $data);
            $this->load->view('footer_view');
        } else {
            // Save to db
            $user_role = $this->input->post('roles');
            //echo $user_role;

            if ($user_role == 2) {
                $this->create_new_admin();
            } else if ($user_role == 3) {
                $this->create_new_lecturer();
            } else if ($user_role == 4) {
                redirect(base_url().'admin/add_new_student');
//                $this->add_new_student();
            } else if ($user_role == 1) {
                echo 'System Admin user functions not activated!!!!<br/>';
                echo 'Go back and choose a different user type.';
            }
        }
    }

    public function create_new_admin() {
        echo 'Create New Admin Function';
    }

    public function create_new_lecturer() {
        echo 'Create New lecturer Function';
    }

    public function add_new_student() {
        $this->form_validation->set_rules('username', 'User Name', 'required|xss_clean|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('student_id', 'Student ID', 'required|xss_clean|is_unique[students.student_id]');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('course', 'Course', 'required|xss_clean');
        $this->form_validation->set_rules('stage', 'Stage of Course', 'required|xss_clean');        
//        $this->form_validation->set_rules('address_1', 'Address Line 1', 'required|xss_clean');        
//        $this->form_validation->set_rules('address_2', 'Address Line 2', 'required|xss_clean');        
//        $this->form_validation->set_rules('address_3', 'Address Line 3', 'required|xss_clean');        
        
        $db_result = $this->admin_model->get_all_courses();

        $dd_menu1 = array();
        foreach ($db_result->result_array() as $tablerow) {

            $dd_menu1[$tablerow['id']] = $tablerow['code'];
        }        
        $data['courses'] = $dd_menu1;
 
        $db_result = $this->admin_model->get_course_stages();
        $dd_menu2 = array();
        foreach ($db_result->result_array() as $tablerow) {

            $dd_menu2[$tablerow['id']] = $tablerow['stage'];
        }        
        $data['stages'] = $dd_menu2;
       
        
        
        $db_result = $this->admin_model->get_all_semesters();
        $dd_menu3 = array();
        foreach ($db_result->result_array() as $tablerow) {

            $dd_menu3[$tablerow['id']] = $tablerow['start_date']. ' to '.
                    $tablerow['end_date'];
        }        
        $data['semesters'] = $dd_menu3;
        
        $data['title'] = 'Add a new student';
                       
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/add_student', $data);
            $this->load->view('footer_view');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $student_id = $this->input->post('student_id');
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $course = $this->input->post('course');
            $stage = $this->input->post('stage');
            $add_L1 = $this->input->post('address_1');
            $add_L2 = $this->input->post('address_2');
            $add_L3 = $this->input->post('address_3');
                                    
            $id = $this->admin_model->add_new_student($username, $password, 
                    $student_id, $first_name, $last_name, $course, $stage, $add_L1, $add_L2, $add_L3
                    );
            
            redirect(base_url() . 'users/' . $id);        
        }
       
    }

    //--------------------------------------------------------------------------------------------------------

    /*
     * Course Managment functions 
     */

    public function courses() {
        $this->load->library('pagination');

        $this->config->load('pagination_courses', TRUE);
        $config['base_url'] = $this->config->item('base_url', 'pagination_courses');
        $config['total_rows'] = $this->config->item('total_rows', 'pagination_courses');
        $config['per_page'] = $this->config->item('per_page', 'pagination_courses');
        $config['num_links'] = $this->config->item('num_links', 'pagination_courses');
        $config['use_page_numbers'] = $this->config->item('use_page_numbers', 'pagination_courses');

        $per_page = $config['per_page'];

        $row = $this->uri->segment(3);

        $this->pagination->initialize($config);

        $data['page_links'] = $this->pagination->create_links($config);
        $data['title'] = 'Course List';
        $data['courses'] = $this->admin_model->get_courses($per_page, $row);


        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/course_list', $data);
        $this->load->view('footer_view');
    }

    public function course_look_up() {
        $this->form_validation->set_rules('code', 'code', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('title', 'title', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('stage', 'stage', 'trim|strip_tags|xss_clean|required');

        if ($this->form_validation->run() === FALSE) {

            // stay on the page
            $id = $this->uri->segment(2, end($this->uri->segment_array()));
            $start = strrpos($id, '_');
            $course_id = substr($id, $start + 1);

            // print_r($this->blog_model->get_post($post_id));

            $data['course'] = $this->admin_model->get_course($course_id);
            $data['title'] = 'Course Details';


            // get modules
            $data['course_modules'] = $this->admin_model->get_course_modules($course_id);

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/course_view', $data);
            $this->load->view('footer_view');
        } else {
            if ($this->input->post('title')) {

                $module_code = $this->input->post('code');
                $course_id = $this->input->post('course_id');
                $module_title = $this->input->post('title');
                $module_stage = $this->input->post('stage');

                $this->admin_model->save_module($module_code, $module_title, $module_stage, $course_id);

                redirect(current_url());
            }
        }
    }

    public function add_course() {
        $this->form_validation->set_rules('title', 'Course Title', 'required|xss_clean|is_unique[courses.title]');
        $this->form_validation->set_rules('code', 'Course Code', 'required|xss_clean|is_unique[courses.code]');

        $data['title'] = 'New Course';

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/course_create');
            $this->load->view('footer_view');
        } else {
            // Save to db
            $course_title = $this->input->post('title');
            $course_code = $this->input->post('code');

            $id = $this->admin_model->save_course($course_title, $course_code);
            redirect(base_url() . 'courses/' . str_replace(' ', '_', $course_title . '_id_' . $id));
        }
    }

    public function module_look_up() {
        $this->form_validation->set_rules('code', 'code', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('title', 'title', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('stage', 'stage', 'trim|strip_tags|xss_clean|required');

        if ($this->form_validation->run() === FALSE) {

            $course_id = $this->uri->segment(2, end($this->uri->segment_array()));
            $module_id = $this->uri->segment(3, end($this->uri->segment_array()));

            $data['title'] = 'Module Details';
            $data['course'] = $this->admin_model->get_course($course_id);
            $data['module'] = $this->admin_model->get_module($module_id);

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/module_view', $data);
            $this->load->view('footer_view');
        } else {
            if ($this->input->post('title')) {
                
                $module_id = $this->uri->segment(3, end($this->uri->segment_array()));
                $module_code = $this->input->post('code');
                $module_title = $this->input->post('title');
                $module_stage = $this->input->post('stage');

                $this->admin_model->edit_module($module_id, $module_code, $module_title, $module_stage);

                redirect(current_url());
            }
        }
    }

    //--------------------------------------------------------------------------------------------------------

    /*
     * Semesters Managment functions 
     */

    public function semesters() {
        $this->load->library('pagination');

        $this->config->load('pagination_courses', TRUE);
        $config['base_url'] = base_url() . 'admin/semesters';

        $config['total_rows'] = $this->admin_model->count_semesters();
        $config['per_page'] = $this->config->item('per_page', 'pagination_courses');
        $config['num_links'] = $this->config->item('num_links', 'pagination_courses');
        $config['use_page_numbers'] = $this->config->item('use_page_numbers', 'pagination_courses');

        $per_page = $config['per_page'];

        $row = $this->uri->segment(3);

        $this->pagination->initialize($config);

        $data['title'] = 'Scheduled Semesters List';
        $data['semesters'] = $this->admin_model->get_semesters($per_page, $row);

        $data['page_links'] = $this->pagination->create_links($config);


        //$data['courses'] = $this->admin_model->get_semesters($per_page, $row);

        $this->load->view('admin_views/header_view', $data);
        $this->load->view('admin_views/semesters_list', $data);
        $this->load->view('footer_view');
    }

    public function add_semester() {
        $this->form_validation->set_rules('from', 'Start Date', 'required|xss_clean');
        $this->form_validation->set_rules('to', 'End Date', 'required|xss_clean');

        $data['title'] = 'Schedule a New Semester';

        if ($this->form_validation->run() === FALSE) {

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/semester_create');
            $this->load->view('footer_view');
        } else {
            // Save to db
            $start_date = date ("y/m/d", strtotime($this->input->post('from')));        
            $end_date = date ("y/m/d", strtotime($this->input->post('to')));
            
            $id = $this->admin_model->save_semester($start_date, $end_date);
            redirect(base_url() . 'semesters/' . str_replace(' ', '_', $start_date . '_id_' . $id));
        }
    }

    public function date_check($dateTime) {
        if (preg_match("/^(\d{2})-(\d{2})-(\d{4}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
            if (checkdate($matches[2], $matches[3], $matches[1])) {
                return true;
            }
        }
        return false;
    }
    
    public function semester_look_up() {
//        $this->form_validation->set_rules('code', 'code', 'trim|strip_tags|xss_clean|required');
//        $this->form_validation->set_rules('title', 'title', 'trim|strip_tags|xss_clean|required');
//        $this->form_validation->set_rules('stage', 'stage', 'trim|strip_tags|xss_clean|required');

//        if ($this->form_validation->run() === FALSE) {

            // stay on the page
            $id = $this->uri->segment(2, end($this->uri->segment_array()));
            $start = strrpos($id, '_');
            $semester_id = substr($id, $start + 1);

            $data['semester'] = $this->admin_model->get_semester($semester_id);
            $data['title'] = 'Semester Details';


            // get running courses
//            $data['course_modules'] = $this->admin_model->get_course_modules($course_id);

            $this->load->view('admin_views/header_view', $data);
            $this->load->view('admin_views/semester_view', $data);
            $this->load->view('footer_view');
//        } else {
//            if ($this->input->post('title')) {
//
//                $module_code = $this->input->post('code');
//                $course_id = $this->input->post('course_id');
//                $module_title = $this->input->post('title');
//                $module_stage = $this->input->post('stage');
//
//                $this->admin_model->save_module($module_code, $module_title, $module_stage, $course_id);
//
//                redirect(current_url());
//            }
//        }
    }  

}