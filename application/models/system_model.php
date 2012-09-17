<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System_model extends CI_Model {

    function get_users($per_page, $row) {
        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'asc');

        return $this->db->get('users')->result_array();
    }
}