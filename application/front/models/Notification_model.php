<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {
    public function get_notification($user_id)
    {
        $sql = "SELECT * FROM `ailee_notification` WHERE not_to_id = '".$user_id."' ORDER BY not_created_date DESC LIMIT 10";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    public function get_notification_ajax($user_id,$limit = '10',$offset = '0')
    {
        $sql = "SELECT * FROM `ailee_notification` WHERE not_to_id = '".$user_id."' ORDER BY not_created_date DESC";
        if($limit != '') {
            $sql .= " LIMIT $offset,$limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    public function get_notification_ajax_total_rec($user_id)
    {
        $sql = "SELECT COUNT(*) as total_record FROM `ailee_notification` WHERE not_to_id = '".$user_id."' ORDER BY not_created_date DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();   
        return $result_array['total_record'];
    }

    public function get_recruiter_info($user_id)
    {
    	$this->db->select("r.rec_id,r.rec_firstname,r.rec_lastname,r.rec_email,r.re_status,r.rec_phone,r.re_comp_name,r.re_comp_email,r.re_comp_site,r.re_comp_country,r.re_comp_state,r.re_comp_city,r.user_id,r.re_comp_profile,r.re_comp_sector,r.re_comp_activities,r.re_step,r.re_comp_phone,r.recruiter_user_image,r.profile_background,r.profile_background_main,r.designation,r.comp_logo")->from("recruiter r");
        $this->db->where(array('r.user_id' => $user_id,'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function get_artist_comment_data($comment_id)
    {
    	$this->db->select("*")->from("artistic_post_comment");
        $this->db->where('artistic_post_comment_id',$comment_id);
        $this->db->where('status','1');
        $this->db->where('is_delete','0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getFreelancerApplyPostDetail($post_id) {
        $select_data = "fp.post_id,fp.post_name,fp.post_slug,fp.user_id,c.category_name";
        $this->db->select($select_data)->from('freelancer_post fp');
        $this->db->join('category c', 'c.category_id = fp.post_field_req', 'left');
        $this->db->where('fp.post_id', $post_id);
        $this->db->where(array('fp.is_delete' => '0', 'fp.status' => '1'));
        
        $query = $this->db->get();
        $result_array = $query->first_row();
        return $result_array;
    }
}
