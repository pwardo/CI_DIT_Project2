<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blog_model extends CI_Model {

    function get_posts($per_page, $row) {
        $this->db->limit($per_page, $row);
        $this->db->order_by('id', 'desc');

        return $this->db->get('posts')->result_array();
    }

    public function get_post($id) {
        $query = $this->db->get_where('posts', array('id' => $id));

        if ($query->num_rows() > 0) {
            $query = $this->db->get_where('posts', array('id' => $id))->row_array();
            return $query;
        } else {
            redirect(base_url());
        }
    }

    public function save_post($post_title, $post_body) {


        $this->db->insert('posts', array(
            'title' => "$post_title",
            'body' => "$post_body"
                )
        );

        redirect(base_url());
    }

    function create_image() {
        $abc = array(
            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
            'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
            'u', 'v', 'w', 'x', 'y', 'z');
        $word = '';
        $n = 0;
        while ($n < 5) {
            $word .= $abc[mt_rand(0, 35)];
            $n++;
        }

        $captcha = array(
            'word' => strtoupper($word),
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'font_path' => './fonts/impact.ttf',
            'img_width' => '300',
            'img_height' => '50',
            'expiration' => '60',
            'time' => time()
        );


        $values = array(
            'time' => $captcha['time'],
            'ip_address' => $this->input->ip_address(),
            'word' => $captcha['word']
        );

        // to remove expired from db
        $expire = $captcha['time'] - $captcha['expiration'];
        $this->db->where('time < ', $expire);
        $this->db->delete('captcha');



        // insert the value into captcha data
        $this->db->insert('captcha', $values);


        $img = create_captcha($captcha);

        return $data['image'] = $img['image'];
    }
    
    function get_post_comments($post_id){
        $this->db->where('post_id', $post_id);
        $this->db->order_by('date', 'desc');
        
        return $post_comments = $this->db->get('blog_comments')->result_array();
    }

}