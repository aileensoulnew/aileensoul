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

    public function get_recruiter_post_data($post_id)
    {
    	$this->db->select("rp.post_id,rp.post_name,IFNULL(jt.name, rp.post_name) as string_post_name,rp.post_description,DATE_FORMAT(rp.created_date,'%d-%M-%Y') as created_date,ct.city_name,cr.country_name,rp.min_year,rp.max_year,rp.fresher,CONCAT(r.rec_firstname,' ',r.rec_lastname) as fullname, r.re_comp_name,r.comp_logo,r.user_id,IF(rp.city>0,ct.city_name,IF(rp.state>0,st.state_name,IF(rp.country>0,cr.country_name,''))) as slug_city")->from('rec_post rp');
        $this->db->join('recruiter r', 'r.user_id = rp.user_id', 'left');
        $this->db->join('cities ct', 'ct.city_id = rp.city', 'left');
        $this->db->join('states st', 'st.state_id = rp.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = rp.country', 'left');
        $this->db->join('job_title jt', 'jt.title_id = rp.post_name', 'left');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->where('r.re_status', '1');
        $this->db->where('r.is_delete', '0');
        $this->db->where('rp.post_id', $post_id);
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

    public function get_notification_unread_count($user_id)
    {
        $this->db->select("COUNT(*) as total_rec")->from("notification");
        $this->db->where('not_to_id',$user_id);
        $this->db->where('not_read','2');
        $this->db->where('not_type !=','2');        
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['total_rec'];

        // $query = $this->db->query("CALL notification_count(?)",array('user_id'=>$user_id));
        // return $query->row()->total_rec;
    }

    public function get_unread_message_count($user_slug)
    {
        $this->db->select("*")->from("user_readunread_message");
        $this->db->where('to_jid',$user_slug);
        $query = $this->db->get();
        $result = $query->result_array();
        $unread_msg = 0;
        $unread_user = 0;
        foreach ($result as $key => $value) {

            $sql = "SELECT COUNT(*) as unread_msg FROM ofMessageArchive WHERE toJID = '".$user_slug."' AND fromJID = '".$value['from_jid']."' AND sentDate >= '".$value['timestamp']."'";
            $query = $this->db->query($sql);
            $um = $query->row_array()['unread_msg'];
            if($um > 0)
            {
                $unread_msg = $unread_msg + $query->row_array()['unread_msg'];
                $unread_user = $unread_user + 1;
            }

        }
        return array("unread_message"=>$unread_msg,"unread_user"=>$unread_user);
        // print_r($result);        

        // $query = $this->db->query("CALL notification_count(?)",array('user_id'=>$user_id));
        // return $query->row()->total_rec;
    }
}
