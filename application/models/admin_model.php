<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    function get_user_roles() {
        $this->db->get('acl_role');
        $this->db->order_by('id', 'asc');

        return $this->db->get('acl_role');
    }

    //--------------------------------------------------------------------------------------------------------

    /*
     * Courses data 
     */
    function get_courses($per_page, $row) {
        $this->db->get('courses');
        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'asc');

        return $this->db->get('courses')->result_array();
    }
    
    function get_all_courses() {
        $this->db->get('courses');
        $this->db->order_by('id', 'asc');
        
        return $this->db->get('courses');
    }
    
    function get_course_stages() {
        $this->db->get('course_stages');
        $this->db->order_by('id', 'asc');
        
        return $this->db->get('course_stages');
    }

    public function get_course($id) {
        $query = $this->db->get_where('courses', array('id' => $id));

        if ($query->num_rows() > 0) {
            $query = $this->db->get_where('courses', array('id' => $id))->row_array();
            return $query;
        } else {
            redirect(base_url().'admin');
        }
    }

    public function save_course($course_title, $course_code) {

        $this->db->insert('courses', array(
            'title' => $course_title,
            'code' => $course_code,
        ));

        return $this->db->insert_id();
    }

    function get_course_modules($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('id', 'asc');

        return $post_comments = $this->db->get('modules')->result_array();
    }

    public function save_module($module_code, $module_title, $module_stage, $course_id) {

        $this->db->insert('modules', array(
            'code' => $module_code,
            'title' => $module_title,
            'stage' => (int) $module_stage,
            'course_id' => (int) $course_id
        ));

        // Redirect to module
        return;
    }
    
    public function edit_module($module_id, $module_code, $module_title, $module_stage) {
        $this->db->where('id',$module_id);
        
        $this->db->update('modules', array(
            'code' => $module_code,
            'title' => $module_title,
            'stage' => (int) $module_stage,
        ));

        return;        
    }

    public function get_module($id) {
        $query = $this->db->get_where('modules', array('id' => $id));

        if ($query->num_rows() > 0) {
            $query = $this->db->get_where('modules', array('id' => $id))->row_array();
            return $query;
        } else {
            redirect(base_url().'admin');
        }
    }    
   
     //--------------------------------------------------------------------------------------------------------

    /*
     * Semesters data 
     */
    function count_semesters() {
        $total_rows = $this->db->count_all('semesters');
        return $total_rows;
    }
          
    function get_semesters($per_page, $row) {
        $this->db->get('semesters');
        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'asc');

        return $this->db->get('semesters')->result_array();
    }
    
    function get_all_semesters() {
        $this->db->get('semesters');
        $this->db->order_by('id', 'asc');
        
        return $this->db->get('semesters');
    }

    public function get_semester($id) {
        $query = $this->db->get_where('semesters', array('id' => $id));

        if ($query->num_rows() > 0) {
            $query = $this->db->get_where('semesters', array('id' => $id))->row_array();
            return $query;
        } else {
            redirect(base_url().'admin');
        }
    }
    
    public function save_semester($start_date, $end_date) {

        $this->db->insert('semesters', array(
            'start_date' => $start_date,
            'end_date' => $end_date,
        ));

        return $this->db->insert_id();
    }    
 
  
    
    //--------------------------------------------------------------------------------------------------------

    /*
     * User data 
     */
    function count_users() {
        $total_rows = $this->db->count_all('users');
        return $total_rows;
    }
        
    function get_users($per_page, $row) {
        $this->db->get('users');
        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'asc');

        return $this->db->get('users')->result_array();
    }
    
    function count_locked_users() {
        $total_rows = $this->db->count_all('users');
        return $total_rows;
    }
    
    function locked_users($per_page, $row) {
        $this->db->limit($per_page, $row);
        $this->db->where('locked_status', 'yes');
        $this->db->order_by('id', 'asc');

        return $this->db->get('users')->result_array();
    }
    
    function unlock_user($id) {
        $this->db->where('id',$id);
        $this->db->update('users', array(
            'locked_status' => 'no',
        ));        
    }

    public function get_user($id) {
        $query = $this->db->get_where('users', array('id' => $id));

        if ($query->num_rows() > 0) {
            $query = $this->db->get_where('users', array('id' => $id))->row_array();
            return $query;
        }else {
            redirect(base_url().'admin');
        }
    }

    public function get_user_sessions($id) {
        $query = $this->db->query('SELECT * FROM ci_sessions WHERE user_id = '.$id);

        return $query->result_array();
    }
    
    public function add_new_student($username, $password, $student_id, $first_name, $last_name, $course, $stage, $add_L1, $add_L2, $add_L3){
        $this->db->trans_start();
        
        $this->db->insert('users', array(
            'username' => $username,
            'password' => $password,
        ));
        
        $user_id = $this->db->insert_id();    
        $this->db->insert('address', array(
            'line1' => $add_L1,
            'line2' => $add_L2,
            'line3' => $add_L3,
        ));
        
        $add_id = $this->db->insert_id();
        $this->db->insert('students', array(
            'student_id' => $student_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_id' => $user_id,
            'address_id' => $add_id,
        ));
//        $datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
//        $time = time();

//        echo mdate($datestring, $time);


        $this->db->insert('registrations', array(
            'student_id' => $student_id,
            'course_id' => $course,
            'date' => date("Y-m-d", now()),
            'stage' => $stage,
        ));
        
        $this->db->trans_complete();
        
        return $user_id;
    }
    
    
    
    
    function javascript_functions() {

//        $function = "
//            $('.field_set').fadeIn(600);
//            $('.this_day').removeClass('selected');
//            $(this).addClass('selected');
//            var day_event = $('.selected .day_event').text();
//            $('#day_event').val(day_event);
//            if (day_event !=''){
//                $('#addEvent').val('Update Event');
//                $('#delete').show();
//            }else {
//                $('#addEvent').val('Add Event');
//                $('#delete').hide();
//            }
//            
//            
//        ";
//
//        $add_new_event = "
//           var selected_day = $('.selected .day_num').text();
//           var event = $('#day_event').val();
//           if ( (selected_day == '') || (event == '')){
//              if (selected_day == ''){
//                  alert('select a valid day')
//                  $('.this_day').removeClass('selected');
//                  exit;
//              }     
//              if (event == ''){
//                  alert('enter an event')
//                  
//              }     
//           }
//           else 
//           {
//               $.ajax({
//                        url: window.location,
//                        type: 'POST',
//                        data: {
//                            day: selected_day,
//                            event: event
//                        },
//                        success: function(msg) {
//                            location.reload();
//                        }                       
//                    }); 
//           }
//        ";
//
//        $cancel_button = "
//            $('.field_set').hide();
//            $('.this_day').removeClass('selected');                
//        ";
//
//        $delete_button = "
//            var selected_day = $('.selected .day_num').text();
//            var day_event = $('.selected .day_event').text();
//            if (day_event != ''){
//                
//                $.ajax({
//                        url: window.location,
//                        type: 'POST',
//                        data: {
//                            day_to_delete: selected_day,
//                            
//                        },
//                        success: function(msg) {
//                            location.reload();
//                        }                       
//                    }); 
//            }
//        ";
//        
//        $click = "
//            var div = $('.alink').attr('href');
//             $('#' + div).toggle();
//        ";   
//        
        $start_date = "
		$( '#from' ).datepicker({
			defaultDate: '+1w',
			changeMonth: true,
			numberOfMonths: 3,
                        dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				$( '#to' ).datepicker( 'option', 'minDate', selectedDate );
			}
		});
		$( '#to' ).datepicker({
			defaultDate: '+1w',
			changeMonth: true,
			numberOfMonths: 3,
                        dateFormat: 'yy-mm-dd',
			onSelect: function( selectedDate ) {
				$( '#from' ).datepicker('option', 'maxDate', selectedDate );
			}
		});
        ";
        
 
                
        $this -> javascript -> click('#from', $start_date);
//        $this -> javascript -> click('.this_day', $function);
//        $this -> javascript -> click('#addEvent', $add_new_event);
//        $this -> javascript -> click('#cancel', $cancel_button);
//        $this -> javascript -> click('#click', $click);
//        $this -> javascript -> click('#delete', $delete_button);
        $this -> javascript -> compile();
    } 
}