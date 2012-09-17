<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    var $account_locked, $locked, $logged;

    function __construct() {
        parent::__construct();
        $this->account_locked = 'locked';
        $this->locked = 'yes';
        $this->logged = 'yes';
    }

    public function get_user($name, $password) {

        // get_where(Table_Name, array('Field_Name' => 'Value we are looking for'))
        $query = $this->db->get_where('users', array('username' => $name));

        if ($query->num_rows() > 0) {
            $query = $query->row_array();
            //print_r($query);

            // Retrieve account status
            $account_status = $query['locked_status'];

            // Check account status
            if ($account_status === 'yes') {
                return $this->account_locked;
            }

            // get user id
            $user_id = $query['id'];

            // if user_id not set, then assign it
            if (!$this->session->userdata['user_id']) {
                $this->session->set_userdata('user_id', $user_id);
            }

            $user_name = $query['username'];
            $user_password = $query['password'];


            if ($password != $user_password) {
                //$session_id = $this->session->userdata['session_id'];
                return $this->update_ci_session($user_id);
            }

            // check if passwords do match, then set session and log the user.
            else if (($password === $user_password)) {
                $userdata = array('user_id' => $user_id, 'user_name' => $user_name);
                $this -> session -> set_userdata($userdata);
                $this -> update_users_activity($user_id, $this -> logged);

                return true;
            }
        } else {
            return false;
        }
    }

    function update_ci_session($user_id) {
        $attempt = $this->session->userdata['login_attempt'];

        if ($attempt == 0) {
            $this->session->set_userdata('login_attempt', 1);
        } else if ($attempt > 0) {
            $attempt = $this->session->userdata['login_attempt'] + 1;
            $this->session->set_userdata('login_attempt', $attempt);
        }

        if ($attempt === 3) {
            $this->lock_user_account($user_id);
            return $this->account_locked;
        } else {
            return FALSE;
        }
    }

    function lock_user_account($user_id) {
        // update the users account status to locked === yes
        $this->db->where('id', $user_id);
        $this->db->update('users', array('locked_status' => $this->locked, 'logged_in' => 'no'));
        $this->session->sess_destroy();
    }

    function update_users_activity($user_id, $logged) {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('logged_in' => $logged));
    }

    function update_session_start($user_id, $session_id) {

        $session_start = time();
        $this->db->where('session_id', $session_id);
        $this->db->update('ci_sessions', array('session_start' => $session_start, 'user_id' => $user_id));
    }

    function update_session_end($user_id, $session_id) {

        $session_end = time();
        $this->db->where('session_id', $session_id);
        $this->db->update('ci_sessions', array('session_end' => $session_end, 'user_id' => $user_id));
    }
}