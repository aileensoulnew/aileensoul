<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_post_model extends CI_Model {

    public function getContactSuggetion($user_id = '', $detailsdata = '') {

        if ($detailsdata == "student") {

            $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id !=', $user_id);
            // $this->db->where('u.user_gender', 'F');
            $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
            $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
            $condition = '(us.current_study = (select us.current_study from ailee_user_student where user_id=' . $user_id . ') AND us.city = (select us.city from ailee_user_student where user_id=' . $user_id . '))';
            // $this->db->where($condition);
            $this->db->where('ui.user_image != ""');
            $this->db->where('ui.profile_background != ""');
            $this->db->where('us.current_study != ""');
            $this->db->where('ul.status', '1');
            $this->db->where('ul.is_delete', '0');
            // $this->db->order_by('us.current_study', 'asc');
            // $this->db->order_by('us.city', 'asc');
            $this->db->order_by('u.user_id', 'desc');

            $this->db->limit('30');
            $query = $this->db->get();            
            return $result_array = $query->result_array();
        } else {
            $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,jt.name as title_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->where('u.user_id !=', $user_id);
            $this->db->where('u.user_gender', 'F');
            $this->db->where('ui.user_image != ""');
            $this->db->where('ui.profile_background != ""');
            $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
            $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
            $condition = '(up.designation IN (select up.designation from ailee_user_profession where user_id=' . $user_id . ') OR up.city = (select up.city from ailee_user_profession where user_id=' . $user_id . ') OR up.field = (select up.field from ailee_user_profession where user_id=' . $user_id . '))';
            // $this->db->where($condition);
            $this->db->where('ul.status', '1');
            $this->db->where('ul.is_delete', '0');
            $this->db->where('up.designation !=','');
            $this->db->group_by("u.user_id");
            // $this->db->order_by('up.designation', 'asc');
            // $this->db->order_by('up.field', 'asc');
            // $this->db->order_by('up.city', 'asc');
            $this->db->order_by('u.user_id', 'desc');
            $this->db->limit('30');
            $query = $this->db->get();
            $result_array = $query->result_array();
            if(isset($result_array) && empty($result_array))
            {
                $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,jt.name as title_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->where('u.user_id !=', $user_id);
                $this->db->where('u.user_gender', 'F');
                $this->db->where('ui.user_image != ""');                
                $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
                $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
                $condition = '(up.designation IN (select up.designation from ailee_user_profession where user_id=' . $user_id . ') OR up.city = (select up.city from ailee_user_profession where user_id=' . $user_id . ') OR up.field = (select up.field from ailee_user_profession where user_id=' . $user_id . '))';
                // $this->db->where($condition);
                $this->db->where('ul.status', '1');
                $this->db->where('ul.is_delete', '0');
                $this->db->where('up.designation !=','');
                $this->db->group_by("u.user_id");
                // $this->db->order_by('up.designation', 'asc');
                // $this->db->order_by('up.field', 'asc');
                // $this->db->order_by('up.city', 'asc');
                $this->db->order_by('u.user_id', 'desc');
                $this->db->limit('30');
                $query = $this->db->get();
                $in_result_array = $query->result_array();
                if(isset($in_result_array) && empty($in_result_array))
                {
                    $this->db->select("u.user_slug,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,jt.name as title_name")->from("user u");
                    $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                    $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                    $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                    $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                    $this->db->where('u.user_id !=', $user_id);
                    $this->db->where('ui.profile_background != ""');
                    $this->db->where('ui.user_image != ""');                
                    $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
                    $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
                    $condition = '(up.designation IN (select up.designation from ailee_user_profession where user_id=' . $user_id . ') OR up.city = (select up.city from ailee_user_profession where user_id=' . $user_id . ') OR up.field = (select up.field from ailee_user_profession where user_id=' . $user_id . '))';
                    // $this->db->where($condition);
                    $this->db->where('ul.status', '1');
                    $this->db->where('ul.is_delete', '0');
                    $this->db->where('up.designation !=','');
                    $this->db->group_by("u.user_id");
                    // $this->db->order_by('up.designation', 'asc');
                    // $this->db->order_by('up.field', 'asc');
                    // $this->db->order_by('up.city', 'asc');
                    $this->db->order_by('u.user_id', 'desc');
                    $this->db->limit('30');
                    $query = $this->db->get();
                    $result_array = $query->result_array();
                }
                else
                {
                    $result_array = $in_result_array;
                }
            }
            //print_r($this->db->last_query());die;
            return $result_array;
        }
    }

    public function getContactAllSuggetion($user_id = '', $page = "",$limit = "40") {
        
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $this->db->distinct();
        
        $this->db->select("u.user_id,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_gender,u.user_slug,up.designation,us.current_study")->from("user u");
        //jt.name as title_name,d.degree_name
        // $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        // $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        // $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
        $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
        // $this->db->order_by('u.user_id', 'DESC');
        $this->db->where('(
         u.user_id IN (SELECT DISTINCT user_id 
                             FROM   ailee_user_profession 
                             WHERE  user_id != '.$user_id.')
        OR u.user_id IN (SELECT DISTINCT user_id 
                             FROM   ailee_user_student 
                             WHERE  user_id != '.$user_id.')
        )');
        // $this->db->order_by('up.designation', 'asc');
        // $this->db->order_by('up.field', 'asc');
        // $this->db->order_by('up.city', 'asc');
        // $this->db->order_by('us.city', 'asc');
        $this->db->order_by('u.user_id', 'DESC');
        if($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();

        // echo $this->db->last_query();exit;
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {

            $img_data = $this->db->select('user_image,profile_background')->get_where('user_info', array('user_id' => $value['user_id']))->row();
            $result_array[$key]['user_image'] = $img_data->user_image;
            $result_array[$key]['profile_background'] = $img_data->profile_background;            
            $result_array[$key]['title_name'] = $this->user_model->getAnyJobTitle($value['designation'])['job_name'];
            $result_array[$key]['degree_name'] = $this->user_model->getAnyDegreename($value['current_study'])['degree_name'];
        }
        $ret_array['con_sugg_data'] = $result_array;
        $ret_array['total_record'] =$this->getContactAllSuggetion_total_rec($user_id);
        return $ret_array;
    }

    public function getContactAllSuggetion_total_rec($user_id = '') {
        

        $this->db->distinct();
        
        $this->db->select("u.user_id,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_gender,u.user_slug,up.designation,us.current_study")->from("user u");
        //jt.name as title_name,d.degree_name
        // $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        // $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        // $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        // $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('u.user_id NOT IN (select from_id from ailee_user_contact where to_id=' . $user_id . ')', NULL, FALSE);
        $this->db->where('u.user_id NOT IN (select to_id from ailee_user_contact where from_id=' . $user_id . ')', NULL, FALSE);
        // $this->db->order_by('u.user_id', 'DESC');
        $this->db->where('(
         u.user_id IN (SELECT DISTINCT user_id 
                             FROM   ailee_user_profession 
                             WHERE  user_id != '.$user_id.')
        OR u.user_id IN (SELECT DISTINCT user_id 
                             FROM   ailee_user_student 
                             WHERE  user_id != '.$user_id.')
        )');
        
        $this->db->order_by('u.user_id', 'DESC');
       
        $query = $this->db->get();
        $result_array = $query->result_array();
        return count($result_array);
    }

    public function checkContact($user_id = '', $to_user_id = '') {
        $this->db->select("count(*) as total,id,status")->from("user_contact uc");
        $this->db->where('(from_id =' . $user_id . ' and to_id =' . $to_user_id . ') OR ( to_id =' . $user_id . ' AND from_id =' . $to_user_id . ')');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

//    public function get_jobtitle($search){
//        $this->db->select("name")->from("job_title jt");
//        $this->db->where('status','publish');
//        $this->db->like('name',$search);
//        $query = $this->db->get();
//        $result_array = $query->result_array();
//        return $result_array;
//    }
    public function get_jobtitle() {
        $this->db->select("name")->from("job_title jt");
        $this->db->where('status', 'publish');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_location() {
        $this->db->distinct();
        $this->db->select("city_name")->from("cities");
        $this->db->where('status', '1');
        $this->db->where('state_id !=', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_category() {
        $this->db->select("name")->from("tags t");
        $this->db->where('status', 'publish');
        $this->db->where('is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function is_likepost($userid = '', $post_id = '') {
        $this->db->select("upl.id,upl.is_like")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.user_id', $userid);
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function likepost_count($post_id = '') {
        $this->db->select("COUNT(*) as like_count")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function is_userlikePost($user_id = '', $post_id = '') {
        $this->db->select("COUNT(*) as like_count")->from("user_post_like upl");
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('upl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function is_user_saved_post($user_id = '', $post_id = '') {
        $this->db->select("*")->from("user_post_save");
        $this->db->where('save_post_id', $post_id);
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');        
        $query = $this->db->get();
        $result_array = $query->row_array();
        if($result_array)
        {
            return 1;
        }
        else
        {
            return 0;
        }
        
    }

    public function postLikeData($post_id = '') {
        $this->db->select("CONCAT(u.first_name,' ',u.last_name) as username,u.user_id")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('upl.is_like', '1');
        $this->db->where('ul.status', '1');
        $this->db->order_by('upl.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        return $post_like_data = $query->row_array();
    }

    public function postCommentCount($post_id = '') {
        $this->db->select("COUNT(upc.id) as comment_count")->from("user_post_comment upc");
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->where('upc.reply_comment_id IS NULL');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['comment_count'];
    }

    public function postShareCount($post_id = '') {
        $this->db->select("COUNT(ups.id_user_post_share) as share_count")->from("user_post_share ups");
        $this->db->join('user_post up', 'up.id = ups.post_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = up.user_id', 'left');
        $this->db->where('ups.shared_post_id', $post_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('ul.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['share_count'];
    }

    public function postCommentData($post_id = '',$user_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('upc.reply_comment_id IS NULL');
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment'] = nl2br($this->common->make_links($post_comment_data[$key]['comment']));
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value['comment_id']);
            $post_comment_data[$key]['comment_reply_data'] = $this->post_comment_reply_data($post_id,$value['comment_id'],$user_id);
        }
        return $post_comment_data;
    }

    public function viewAllComment($post_id = '', $user_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->where('upc.reply_comment_id IS NULL');
        $this->db->order_by('upc.id', 'asc');
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment'] = nl2br($this->common->make_links($post_comment_data[$key]['comment']));
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value['comment_id']);
            $post_comment_data[$key]['comment_reply_data'] = $this->post_comment_reply_data($post_id,$value['comment_id'],$user_id);
        }
        return $post_comment_data;
    }

    public function userlikePostCommentData($user_id = '', $comment_id = '') {
        $this->db->select("upcl.id,upcl.is_like")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('upcl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function postCommentDetail($comment_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment, upc.post_id, upc.created_date")->from("user_post_comment upc");
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.id', $comment_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function is_userlikePostComment($user_id = '', $comment_id = '') {
        $this->db->select("COUNT(upcl.id) as like_count")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('upcl.user_id', $user_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function postCommentLikeCount($comment_id = '') {
        $this->db->select("COUNT(upcl.id) as like_count")->from("user_post_comment_like upcl");
        $this->db->join('user_login ul', 'ul.user_id = upcl.user_id', 'left');
        $this->db->where('upcl.comment_id', $comment_id);
        $this->db->where('ul.status', '1');
        $this->db->where('is_like', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['like_count'];
    }

    public function userPostCount($user_id) {
        
        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field,other_field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field'],$getUserProfessionData['other_field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        /*if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }*/
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function userPostCountBySlug($user_slug = '') {
        $user_id = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');


        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field,other_field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field'],$getUserProfessionData['other_field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser > 0) {
            $field = $getUserProfessionData['field'];
            $other_field = $getUserProfessionData['other_field'];
            $getSameFieldProUser_sql = "SELECT GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user FROM ailee_user_profession up WHERE ";
            if($field == 0)
            {
                if($other_field != ""){
                    $of_sql = "";
                    foreach (explode(" ", $other_field) as $key => $value) {
                        if($value != ""){                    
                            $of_sql .= " other_field LIKE '%".addslashes($value)."%' OR";
                        }
                    }
                    $getSameFieldProUser_sql .= "(".trim($of_sql," OR").")";
                }
                else
                {
                    // $this->db->where("up.field =" . $field);
                    $getSameFieldProUser_sql .= "up.field =". $field;
                }
            }
            else
            {
                // $this->db->where("up.field =" . $field);
                $getSameFieldProUser_sql .= "up.field =". $field;
            }

            $this->db->where('up.user_id IN (' . $getSameFieldProUser_sql . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser > 0) {

            $current_study = $getUserStudentData['current_study'];
            $getSameFieldStdUser_sql = "SELECT GROUP_CONCAT(CONCAT('''', `user_id`, '''' )) AS group_user FROM ailee_user_student us WHERE ";
            $getSameFieldStdUser_sql .= "us.current_study =". $current_study;

            $this->db->where('up.user_id IN (' . $getSameFieldStdUser_sql . ')');
        }
        if ($getDeleteUserPost) {
            
            $current_study = $getUserStudentData['current_study'];
            $getDeleteUserPost_sql = "SELECT GROUP_CONCAT(CONCAT('''', `post_id`, '''' )) AS group_post FROM ailee_user_post_delete upd WHERE ";
            $getDeleteUserPost_sql .= "upd.user_id =". $user_id;

            $this->db->where('up.id NOT IN (' . $getDeleteUserPost_sql . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function getPostUserId($post_id = '') {
        $this->db->select("user_id")->from("user_post up");
        //$this->db->where('up.post_id', $post_id);
        $this->db->where('up.id', $post_id);//Pratik Change
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['user_id'];
    }

    public function deletePostUser($user_id = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `post_id`, '''' )) AS group_post")->from("user_post_delete upd");
        $this->db->where("upd.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_post'];
    }

    public function userPost($user_id = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'designation,field,other_field,city');        
        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field'],$getUserProfessionData['other_field']);
        $getSameJobTitleProUser = $this->user_model->getJobTitleCityProUser($getUserProfessionData['designation']);
        $getSameCityProUser = $this->user_model->getJobTitleCityProUser('',$getUserProfessionData['city']);        
        
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'us.current_study, us.city, us.university_name,us.interested_fields,us.other_interested_fields');
        
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);
        $getUnivetsityStdUser = $this->user_model->getUnivetsityCityStdUser($getUserStudentData['university_name']);
        $getSameCityStdUser = $this->user_model->getUnivetsityCityStdUser('',$getUserStudentData['city']);
        
        if($getUserProfessionData['designation'] != "")
            $job_name = $this->user_model->getAnyJobTitle($getUserProfessionData['designation']);
        elseif ($getUserStudentData['interested_fields'] != "") {
            $job_name = ($getUserStudentData['interested_fields'] == 0 ? $getUserStudentData['other_interested_fields'] : $this->user_model->getAnyIndustryName($getUserStudentData['interested_fields']));
        }
        

        $job_sql = "";
        if(isset($job_name) && !empty($job_name) && isset($job_name['job_name']) && $job_name['job_name'] != ""){
            $job_name = explode(" ", $job_name['job_name']);
            foreach ($job_name as $key => $value) {
                if($value != ""){                    
                    $job_sql .= " name LIKE '%".$value."%' OR";
                }
            }
            $job_sql = trim($job_sql," OR");
        }
        
        
        $oppPostIds = "";
        $quePostIds = "";
        if($job_sql != "")
        {
            $jobsData = $this->user_model->getAnyJobIds($job_sql);            
            $oppPostIds = $this->user_model->getPostIdsForOppQue('user_opportunity',$jobsData['jobs_id']);
            $quePostIds = $this->user_model->getPostIdsForOppQue('user_ask_question',$jobsData['jobs_id']);
        }

        $getInContactData = $this->user_model->getIncontactData($user_id);

        $followersData = $this->user_model->getFollowersData($user_id);

        $getDeleteUserPost = $this->deletePostUser($user_id);

        
        $proSqlIn = "";
        $stdSqlIn = "";
        if ($getUserProfessionData && $getSameFieldProUser)
        {
            //$this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
            $proSqlIn .= 'up.user_id IN (' . $getSameFieldProUser . ')';
        }
        elseif ($getUserStudentData && $getSameFieldStdUser)
        {
            //$this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
            $stdSqlIn .= 'up.user_id IN (' . $getSameFieldStdUser . ')';
        }

        if($getUserProfessionData && $getSameJobTitleProUser != "")
        {
            //$this->db->where('up.user_id IN (' . $getSameJobTitleProUser . ')');
            $proSqlIn .= ($proSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getSameJobTitleProUser . ')';
        }
        elseif($getUserStudentData && $getUnivetsityStdUser != "")
        {
            //$this->db->where('up.user_id IN (' . $getUnivetsityStdUser . ')');
            $stdSqlIn .= ($stdSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getUnivetsityStdUser . ')';
        }

        if($getUserProfessionData && $getSameCityProUser != "")
        {
            //$this->db->where('up.user_id IN (' . $getSameCityProUser . ')');
            $proSqlIn .= ($proSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getSameCityProUser . ')';
        }
        elseif($getUserStudentData && $getSameCityStdUser != "")
        {
            //$this->db->where('up.user_id IN (' . $getSameCityStdUser . ')');
            $stdSqlIn .= ($stdSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getSameCityStdUser . ')';
        }

        if($getUserProfessionData && $getInContactData['group_user'] != "")
        {
            $proSqlIn .= ($proSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getInContactData['group_user'] . ')';   
        }
        elseif($getUserStudentData && $getInContactData['group_user'] != "")
        {
            $stdSqlIn .= ($stdSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $getInContactData['group_user'] . ')';
        }

        if($getUserProfessionData && $followersData['follower_user'] != "")
        {
            $proSqlIn .= ($proSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $followersData['follower_user']. ')';   
        }
        elseif($getUserStudentData && $followersData['follower_user'] != "")
        {
            $stdSqlIn .= ($stdSqlIn!= '' ? ' OR ' : '').'up.user_id IN (' . $followersData['follower_user'] . ')';
        }

        /*$this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date

        if($proSqlIn != "")
        {
            $this->db->where('('.$proSqlIn.')');   
        }
        elseif($stdSqlIn != "")
        {
            $this->db->where('('.$stdSqlIn.')');   
        }*/
        /*if($oppPostIds != "")
        {
            $this->db->where('(up.id IN (' . $oppPostIds['post_id'] . ') OR up.id IN('.$quePostIds['post_id'].'))');
        }*/

        /*if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit,$start);
        }*/
        $sql = "SELECT main.* FROM (
                SELECT up.id, up.user_id, up.post_for, up.created_date, up.post_id FROM ailee_user_post up                
                WHERE up.status = 'publish' AND up.is_delete = '0'";
        $proSqlIn = '';
        $stdSqlIn = '';
        if($proSqlIn != "")
        {
            $sql .= ' AND ('.$proSqlIn.')';
        }
        elseif($stdSqlIn != "")
        {
            $sql .= ' AND ('.$stdSqlIn.')';   
        }
        $oppPostIds['post_id'] = "";
        $quePostIds['post_id'] = "";
        if($oppPostIds['post_id'] != "" || $quePostIds['post_id'] != "")
        {
            $sql .= " UNION
                SELECT up.id, up.user_id, up.post_for, up.created_date, up.post_id FROM ailee_user_post up                
                WHERE up.status = 'publish' AND up.is_delete = '0' ";        
            $sql .= 'AND (';
            if($oppPostIds['post_id'] != "")
            {
                $sql .= 'up.id IN (' . $oppPostIds['post_id'] . ')';
            }
            if($oppPostIds['post_id'] != "" && $quePostIds['post_id'] != "")
            {
                $sql .= ' OR ';
            }
            if($quePostIds['post_id'] != "")
            {
                $sql .= 'up.id IN('.$quePostIds['post_id'].')';
            }
            $sql .= ')';
        }        
        $sql .= ") as main WHERE (main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' ) ";
        if ($getDeleteUserPost) {
            $sql .= "AND main.id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.id DESC";
        
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);
        //$query = $this->db->get();
        // echo $this->db->last_query();exit;
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;

            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('id_post_article', $value['post_id']);
                $this->db->where('status', 'publish');
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            } /*elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }*/
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($user_id, $value['id']);
            if($user_id == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
             $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function get_new_signup($user_id = '')
    {
         $this->db->select("new_signup")->from("user");                
        $this->db->where('user_id', $user_id);        
        $query = $this->db->get();                
        $user_data = $query->row_array();                
        return $user_data['new_signup'];
    }

    public function user_post_new_total($user_id = '')
    {
        $new_signup = $this->get_new_signup($user_id);
        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'designation,field,other_field,city');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'us.current_study, us.city, us.university_name,us.interested_fields,us.other_interested_fields');

        //Start Old Feed before 14-03-2019
        /*if($getUserProfessionData)
        {
            $sql = "SELECT COUNT(*) as total FROM(
                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as con1

                    UNION

                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0'  AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ) as con2

                    UNION

                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con3

                    UNION

                    SELECT con3a.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con3a

                    UNION

                    SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as con4

                    UNION

                    SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con5

                    UNION

                    SELECT con5a.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END)
                            WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS con5a
                    UNION

                    SELECT con5b.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con5b
                    
                    UNION

                    SELECT con5c.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con5c

                    UNION

                    SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con6

                    UNION

                    SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con7

                    UNION

                    SELECT con8.* FROM (SELECT up.* FROM ailee_user_post up 
                    WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con8
                ) as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
        }

        if($getUserStudentData)
        {
            $sql = "SELECT COUNT(*) as total FROM(

                SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields` AND c1.`city` = us.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as con1

                UNION

                SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as con2

                UNION

                SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`city` = us.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as con3

                UNION

                SELECT con4.* FROM (SELECT up.* FROM ailee_user_post up 
                    WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS con4
                
            ) as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id);";
        }*/
        //End Old Feed before 14-03-2019

        //Start New Feed After 09-04-2019
        if($new_signup == 1)
        {
            if($getUserProfessionData)
            {
                $sql = "SELECT COUNT(*) as total FROM(
                        SELECT oppcon1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_opportunity uo JOIN ailee_user_post up  ON up.post_id = uo.id WHERE upr.`user_id` = $user_id AND (IF(upr.field = 0, CONCAT(LOWER(uo.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(uo.other_field) LIKE '%'),'%'),upr.field = uo.field)) AND FIND_IN_SET(upr.city , uo.location) != 0 AND up.status = 'publish' AND FIND_IN_SET(upr.designation , uo.opportunity_for) != 0 AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') as oppcon1
                        
                        UNION

                        SELECT main1.* FROM(
                            SELECT inner_cond.* FROM(
                                SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con1
                                UNION
                                
                                SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up 
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity'  ORDER BY up.created_date DESC) as con2

                                UNION

                                SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con3                    

                                UNION

                                SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con4

                                UNION

                                SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con5                    
                                
                                UNION

                                SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con6

                                UNION

                                SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con7
                                
                            ) as inner_cond WHERE inner_cond.status = 'publish' AND inner_cond.is_delete = '0' ORDER BY inner_cond.created_date DESC
                        ) as main1

                        UNION

                        SELECT main2.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                            LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                            JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                            WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article') as main2
                        UNION

                        SELECT main3.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                            LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                            JOIN ailee_user_post up  ON up.id = c1.post_id
                            WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main3

                        UNION

                        SELECT main4.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main4

                        UNION

                        SELECT main5.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main5
                        
                        UNION

                        SELECT main6.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main6
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE main.user_id != $user_id AND ul.status = '1' AND ul.is_delete = '0' AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND  main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
            }

            if($getUserStudentData)
            {
                $sql = "SELECT COUNT(*) as total FROM(
                    SELECT main1.* FROM(
                        SELECT inner_cond.* FROM(

                            SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con1

                            UNION

                            SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con2
                            
                            UNION

                            SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con3
                        ) as inner_cond ORDER BY inner_cond.created_date DESC
                    ) as main1

                    UNION

                    SELECT main2.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                        LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                        JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                        WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article') as main2
                    UNION

                    SELECT main3.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                        LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                        JOIN ailee_user_post up  ON up.id = c1.post_id
                        WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main3

                    UNION

                    SELECT main4.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main4

                    UNION

                    SELECT main5.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main5
                    
                    UNION

                    SELECT main6.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main6
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE main.user_id != $user_id AND ul.status = '1' AND ul.is_delete = '0' AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
            }
        }
        if($new_signup == 0)
        {
            if($getUserProfessionData)
            {
                $sql = "SELECT COUNT(*) as total FROM(
                    SELECT inner1.* FROM(
                        SELECT main1.* FROM(
                            SELECT main11.* FROM(
                                SELECT inner_cond.* FROM(
                                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con1
                                    UNION
                                    
                                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity'  ORDER BY up.created_date DESC) as con2

                                    UNION

                                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con3                    

                                    UNION

                                    SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con4

                                    UNION

                                    SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con5                    
                                    
                                    UNION

                                    SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con6

                                    UNION

                                    SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) AS con7
                                    
                                ) as inner_cond WHERE inner_cond.status = 'publish' AND inner_cond.is_delete = '0' ORDER BY inner_cond.created_date DESC
                            ) as main11

                            UNION

                            SELECT main12.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article') as main12
                            UNION

                            SELECT main13.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main13
                            UNION

                            SELECT main14.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main14
                            UNION

                            SELECT main15.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main15
                            
                            UNION

                            SELECT main16.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main16

                        ) as main1 WHERE main1.user_id != $user_id AND main1.status = 'publish' AND main1.is_delete = '0' AND main1.post_for != '' AND  main1.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main1.created_date >= NOW() - INTERVAL 5 DAY
                    ) as inner1
                    UNION
                    SELECT inner2.* FROM(
                        SELECT main2.* FROM(
                            SELECT main21.* FROM(
                                SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') as con1

                                UNION

                                SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0'  AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') as con2

                                UNION

                                SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') AS con3                    

                                UNION

                                SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field`
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') as con4

                                UNION

                                SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') AS con5                    
                                
                                UNION

                                SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') AS con6

                                UNION

                                SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field`
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity') AS con7
                                
                            ) as main21

                            UNION

                            SELECT main22.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article') as main22
                            UNION

                            SELECT main23.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main23
                            UNION

                            SELECT main24.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main24
                            UNION

                            SELECT main25.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main25
                            
                            UNION

                            SELECT main26.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main26

                        ) as main2 WHERE main2.user_id != $user_id AND main2.status = 'publish' AND main2.is_delete = '0' AND main2.post_for != '' AND  main2.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main2.created_date < NOW() - INTERVAL 5 DAY
                    ) as inner2

                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE ul.status = '1' AND ul.is_delete = '0' ";
            }

            if($getUserStudentData)
            {
                $sql = "
                SELECT COUNT(*) as total FROM(
                    SELECT inner1.* FROM(
                        SELECT main1.* FROM(
                            SELECT main11.* FROM(
                                SELECT inner_cond.* FROM(

                                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con1

                                    UNION

                                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con2
                                    
                                    UNION

                                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC) as con3
                                ) as inner_cond ORDER BY inner_cond.created_date DESC
                            ) as main11

                            UNION

                            SELECT main12.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ) as main12
                            UNION

                            SELECT main13.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main13

                            UNION

                            SELECT main14.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main14

                            UNION

                            SELECT main15.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main15
                            
                            UNION

                            SELECT main16.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ) AS main16
                        ) as main1 WHERE main1.user_id != $user_id AND main1.status = 'publish' AND main1.is_delete = '0' AND main1.post_for != '' AND main1.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main1.created_date >= NOW() - INTERVAL 5 DAY ORDER BY RAND() 
                    ) as inner1
                    UNION
                    SELECT inner2.* FROM(
                        SELECT main2.* FROM(
                            SELECT main21.* FROM(

                                SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields` AND c1.`city` = us.`city` 
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity') as con1

                                UNION

                                SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields`
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity') as con2
                                
                                UNION

                                SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`city` = us.`city` 
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ) as con3

                            ) as main21

                            UNION

                            SELECT main22.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ) as main22
                            UNION

                            SELECT main23.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question') as main23

                            UNION

                            SELECT main24.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm') AS main24

                            UNION

                            SELECT main25.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main25
                            
                            UNION

                            SELECT main26.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') AS main26
                        ) as main2 WHERE main2.user_id != $user_id AND main2.status = 'publish' AND main2.is_delete = '0' AND main2.post_for != '' AND main2.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main2.created_date < NOW() - INTERVAL 5 DAY ORDER BY RAND() 
                    ) as inner2
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE ul.status = '1' AND ul.is_delete = '0' ";
            }
        }

        if($user_id == 103 || $user_id == 29112)
        {
            $sql = "SELECT COUNT(*) as total FROM (SELECT up.* FROM ailee_user_post up WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update') as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";   
        }
        //End New Feed After 09-04-2019
        // echo $sql;exit();
        $query = $this->db->query($sql);
        $user_post_total = $query->row_array();
        return $user_post_total['total'];
    }

    public function user_post_new($user_id = '', $page = '')
    {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $total_record  = $this->user_post_new_total($user_id);
        $new_signup = $this->get_new_signup($user_id);

        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'designation,field,other_field,city');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'us.current_study, us.city, us.university_name,us.interested_fields,us.other_interested_fields');
        //Start Old Feed before 14-03-2019
        /*if($getUserProfessionData)
        {
            $sql = "SELECT main.* FROM(
                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                    UNION

                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0'  AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update'  ORDER BY up.created_date DESC LIMIT $total_record) as con2

                    UNION

                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con3

                    UNION

                    SELECT con3a.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con3a

                    UNION

                    SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con4

                    UNION

                    SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con5

                    UNION

                    SELECT con5a.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS con5a
                    
                    UNION

                    SELECT con5b.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con5b
                    
                    UNION

                    SELECT con5c.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con5c
                    
                    UNION

                    SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`city` = upr.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con6

                    UNION

                    SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr 
                    LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con7

                    UNION

                    SELECT con8.* FROM (SELECT up.* FROM ailee_user_post up 
                    WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con8
                ) as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
        }

        if($getUserStudentData)
        {
            $sql = "SELECT main.* FROM(

                SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields` AND c1.`city` = us.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                UNION

                SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields`
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con2

                UNION

                SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us 
                    LEFT JOIN ailee_user_student c1 ON c1.`city` = us.`city` 
                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con3

                UNION

                SELECT con4.* FROM (SELECT up.* FROM ailee_user_post up 
                    WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS con4
                
            ) as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
        }*/
        //End Old Feed before 14-03-2019

        //Start New Feed After 09-04-2019
        if($new_signup == 1)
        {
            if($getUserProfessionData)
            {
                $sql = "SELECT main.* FROM(
                    SELECT oppcon1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_opportunity uo JOIN ailee_user_post up  ON up.post_id = uo.id WHERE upr.`user_id` = $user_id AND (IF(upr.field = 0, CONCAT(LOWER(uo.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(uo.other_field) LIKE '%'),'%'),upr.field = uo.field)) AND FIND_IN_SET(upr.city , uo.location) != 0 AND up.status = 'publish' AND FIND_IN_SET(upr.designation , uo.opportunity_for) != 0 AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as oppcon1

                    UNION

                    SELECT main1.* FROM(
                        SELECT inner_cond.* FROM(
                            SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1
                            UNION
                            
                            SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity'  ORDER BY up.created_date DESC LIMIT $total_record) as con2

                            UNION

                            SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con3                    

                            UNION

                            SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con4

                            UNION

                            SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con5                    
                            
                            UNION

                            SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con6

                            UNION

                            SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con7
                            
                        ) as inner_cond WHERE inner_cond.status = 'publish' AND inner_cond.is_delete = '0' ORDER BY inner_cond.created_date DESC LIMIT $total_record
                    ) as main1

                    UNION

                    SELECT main2.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                        LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                        JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                        WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main2
                    UNION

                    SELECT main3.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                        LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                        JOIN ailee_user_post up  ON up.id = c1.post_id
                        WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main3

                    UNION

                    SELECT main4.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main4

                    UNION

                    SELECT main5.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main5
                    
                    UNION

                    SELECT main6.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main6
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE main.user_id != $user_id AND ul.status = '1' AND ul.is_delete = '0' AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND  main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
            }

            if($getUserStudentData)
            {
                $sql = "SELECT main.* FROM(
                    SELECT main1.* FROM(
                        SELECT inner_cond.* FROM(

                            SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                            UNION

                            SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con2
                            
                            UNION

                            SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                            LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                            WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con3
                        ) as inner_cond ORDER BY inner_cond.created_date DESC LIMIT $total_record
                    ) as main1

                    UNION

                    SELECT main2.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                        LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                        JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                        WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main2
                    UNION

                    SELECT main3.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                        LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                        JOIN ailee_user_post up  ON up.id = c1.post_id
                        WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main3

                    UNION

                    SELECT main4.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main4

                    UNION

                    SELECT main5.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main5
                    
                    UNION

                    SELECT main6.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main6
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND ul.status = '1' AND ul.is_delete = '0' AND main.post_for != '' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ";
            }
        }
        if($new_signup == 0)
        {
            if($getUserProfessionData)
            {
                $sql = "SELECT main.* FROM(
                    SELECT inner1.* FROM(
                        SELECT main1.* FROM(
                            SELECT main11.* FROM(
                                SELECT inner_cond.* FROM(
                                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1
                                    UNION
                                    
                                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity'  ORDER BY up.created_date DESC LIMIT $total_record) as con2

                                    UNION

                                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`)  AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con3                    

                                    UNION

                                    SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con4

                                    UNION

                                    SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`designation` IN(c1.`opportunity_for`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con5                    
                                    
                                    UNION

                                    SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND upr.`city` IN (c1.`location`) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con6

                                    UNION

                                    SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr, ailee_user_post up
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE upr.`user_id` = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),upr.`field` = c1.`field`)) AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con7
                                    
                                ) as inner_cond WHERE inner_cond.status = 'publish' AND inner_cond.is_delete = '0' ORDER BY inner_cond.created_date DESC LIMIT $total_record
                            ) as main11

                            UNION

                            SELECT main12.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main12
                            UNION

                            SELECT main13.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main13
                            UNION

                            SELECT main14.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main14
                            UNION

                            SELECT main15.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main15
                            
                            UNION

                            SELECT main16.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main16

                        ) as main1 WHERE main1.user_id != $user_id AND main1.status = 'publish' AND main1.is_delete = '0' AND main1.post_for != '' AND  main1.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main1.created_date >= NOW() - INTERVAL 5 DAY ORDER BY RAND() LIMIT $total_record
                    ) as inner1
                    UNION
                    SELECT inner2.* FROM(
                        SELECT main2.* FROM(
                            SELECT main21.* FROM(
                                SELECT con1.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                                UNION

                                SELECT con2.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0'  AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity'  ORDER BY up.created_date DESC LIMIT $total_record) as con2

                                UNION

                                SELECT con3.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field` AND c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con3                    

                                UNION

                                SELECT con4.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` AND c1.`field` = upr.`field`
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con4

                                UNION

                                SELECT con5.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`designation` = upr.`designation` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con5                    
                                
                                UNION

                                SELECT con6.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`city` = upr.`city` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con6

                                UNION

                                SELECT con7.* FROM (SELECT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_profession c1 ON c1.`field` = upr.`field`
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) AS con7
                                
                            ) as main21

                            UNION

                            SELECT main22.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = upr.`field` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE upr.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main22
                            UNION

                            SELECT main23.* FROM (SELECT DISTINCT up.* FROM ailee_user_profession upr 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = upr.field
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE upr.user_id = $user_id AND up.user_id != $user_id AND (IF(upr.`field` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(upr.other_field,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main23
                            UNION

                            SELECT main24.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main24
                            UNION

                            SELECT main25.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main25
                            
                            UNION

                            SELECT main26.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main26

                        ) as main2 WHERE main2.user_id != $user_id AND main2.status = 'publish' AND main2.is_delete = '0' AND main2.post_for != '' AND  main2.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main2.created_date < NOW() - INTERVAL 5 DAY ORDER BY RAND() LIMIT $total_record
                    ) as inner2
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE ul.status = '1' AND ul.is_delete = '0' ";
            }

            if($getUserStudentData)
            {
                $sql = "SELECT main.* FROM(
                    SELECT inner1.* FROM(
                        SELECT main1.* FROM(
                            SELECT main11.* FROM(
                                SELECT inner_cond.* FROM(

                                    SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                                    UNION

                                    SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_field) LIKE '%'),'%'),us.`interested_fields` = c1.`field`)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con2
                                    
                                    UNION

                                    SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us, ailee_user_post up 
                                    LEFT JOIN ailee_user_opportunity c1 ON c1.post_id = up.id
                                    WHERE us.`user_id` = $user_id AND up.user_id != $user_id AND us.`city` IN (c1.`location`) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con3
                                ) as inner_cond ORDER BY inner_cond.created_date DESC LIMIT $total_record
                            ) as main11

                            UNION

                            SELECT main12.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main12
                            UNION

                            SELECT main13.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main13

                            UNION

                            SELECT main14.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main14

                            UNION

                            SELECT main15.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main15
                            
                            UNION

                            SELECT main16.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main16
                        ) as main1 WHERE main1.user_id != $user_id AND main1.status = 'publish' AND main1.is_delete = '0' AND main1.post_for != '' AND main1.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main1.created_date >= NOW() - INTERVAL 5 DAY ORDER BY RAND() 
                    ) as inner1
                    UNION
                    SELECT inner2.* FROM(
                        SELECT main2.* FROM(
                            SELECT main21.* FROM(

                                SELECT con1.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields` AND c1.`city` = us.`city` 
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con1

                                UNION

                                SELECT con2.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`interested_fields` = us.`interested_fields`
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.other_interested_fields) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.other_interested_fields) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for = 'opportunity' ORDER BY up.created_date DESC LIMIT $total_record) as con2
                                
                                UNION

                                SELECT con3.* FROM (SELECT up.* FROM ailee_user_student us 
                                    LEFT JOIN ailee_user_student c1 ON c1.`city` = us.`city` 
                                    JOIN ailee_user_post up  ON up.user_id = c1.user_id
                                    WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as con3

                            ) as main21

                            UNION

                            SELECT main22.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_post_article c1 ON c1.`article_main_category` = us.`interested_fields` 
                                JOIN ailee_user_post up  ON up.user_id = c1.user_id AND up.post_id = c1.id_post_article
                                WHERE us.`user_id` = $user_id AND c1.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.article_other_category) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.article_other_category) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND c1.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'article' ORDER BY up.created_date DESC LIMIT $total_record) as main22
                            UNION

                            SELECT main23.* FROM (SELECT DISTINCT up.* FROM ailee_user_student us 
                                LEFT JOIN ailee_user_ask_question c1 ON c1.field = us.interested_fields
                                JOIN ailee_user_post up  ON up.id = c1.post_id
                                WHERE us.user_id = $user_id AND up.user_id != $user_id AND (IF(us.`interested_fields` = 0, CONCAT(LOWER(c1.others_field) LIKE '%',REPLACE(us.other_interested_fields,' ','%' OR LOWER(c1.others_field) LIKE '%'),'%'),1 = 1)) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for = 'question' ORDER BY up.created_date DESC LIMIT $total_record) as main23

                            UNION

                            SELECT main24.* FROM (SELECT up.* FROM ailee_user_contact  uc JOIN ailee_user_post up  ON up.user_id = (CASE WHEN uc.from_id=$user_id THEN uc.to_id ELSE uc.from_id END) WHERE (uc.from_id =  $user_id  OR uc.to_id = $user_id) AND up.status = 'publish' AND up.is_delete = '0' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' AND uc.status = 'confirm' ORDER BY up.created_date DESC LIMIT $total_record) AS main24

                            UNION

                            SELECT main25.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '1' AND up.user_type = '1' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main25
                            
                            UNION

                            SELECT main26.* FROM (SELECT up.* FROM ailee_user_follow uf JOIN ailee_user_post up  ON up.user_id = uf.follow_to WHERE uf.follow_from =  $user_id AND up.status = 'publish' AND up.is_delete = '0' AND uf.follow_type = '2' AND up.user_type = '2' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) AS main26
                        ) as main2 WHERE main2.user_id != $user_id AND main2.status = 'publish' AND main2.is_delete = '0' AND main2.post_for != '' AND main2.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) AND main2.created_date < NOW() - INTERVAL 5 DAY ORDER BY RAND() 
                    ) as inner2
                ) as main LEFT JOIN ailee_user_login ul ON ul.user_id = main.user_id WHERE ul.status = '1' AND ul.is_delete = '0' ";
            }
        }
        //End New Feed After 09-04-2019
        
        if($user_id == 103 || $user_id == 29112)
        {
            $sql = "SELECT * FROM (SELECT up.* FROM ailee_user_post up WHERE up.`user_id` != $user_id AND up.status = 'publish' AND up.is_delete = '0' AND up.post_for != '' AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $total_record) as main WHERE main.user_id != $user_id AND main.status = 'publish' AND main.is_delete = '0' AND main.post_for != '' AND main.post_for != 'profile_update' AND main.post_for != 'cover_update' AND main.id NOT IN(SELECT post_id FROM ailee_user_post_delete WHERE user_id = $user_id) ORDER BY main.created_date DESC";   
        }
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $user_post = $query->result_array();
        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {                
                $this->db->select("count(*) as file_count")->from("user_post_file upf");
                $this->db->where('upf.post_id', $value['id']);
                $query = $this->db->get();
                $total_post_files = $query->row_array('file_count');
                $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;

            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $this->db->where('pa.status', 'publish');
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            }
            elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $result_array[$key]['share_data'] = $share_data;
            } /*elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }*/
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;
            
            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($user_id, $value['id']);

            $result_array[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if($user_id == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function userDashboardPost($user_id = '', $page = '') {
        $userid_login = $this->session->userdata('aileenuser');
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->where('user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.user_type', '1');
        $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.created_date', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.user_gender,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $this->db->where('pa.status', 'publish');                
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            } elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $result_array[$key]['share_data'] = $share_data;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($userid_login, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($userid_login, $value['id']);
            
            $result_array[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if($userid_login == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $postCommentData[$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($userid_login, $value1['comment_id']);
                $postCommentData[$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
            $result_array[$key]['post_comment_data'] = $postCommentData;

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function getUserSavedPost($user_id = '', $page = '') {
        $userid_login = $this->session->userdata('aileenuser');
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");
        $this->db->join('user_post_save ups', 'ups.save_post_id = up.id', 'left');
        $this->db->where('ups.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('ups.status', '1');
        // $this->db->where('up.user_type', '1');        
        $this->db->where('up.is_delete', '0');
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.created_date', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();        
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            /*$this->db->select("u.user_id,u.user_slug,u.user_gender,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;*/
            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {                
                $this->db->select("count(*) as file_count")->from("user_post_file upf");
                $this->db->where('upf.post_id', $value['id']);
                $query = $this->db->get();
                $total_post_files = $query->row_array('file_count');
                $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $result_array[$key]['share_data'] = $share_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $this->db->where('pa.status', 'publish');
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($userid_login, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($user_id, $value['id']);
            
            $result_array[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if($userid_login == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $postCommentData[$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($userid_login, $value1['comment_id']);
                $postCommentData[$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
            $result_array[$key]['post_comment_data'] = $postCommentData;

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function userDashboardImage($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);

        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.user_type = '1' AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND up.user_type = '1' AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC LIMIT 6";
        

        $query = $this->db->query($sql);
        /*$this->db->select('upf.filename,upu.data_key,upu.data_value')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_profile_update upu', 'upu.id = up.post_id', 'left');
        $this->db->where('upf.file_type', 'image');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        echo $this->db->last_query();exit;*/
        $userDashboardImage = $query->result_array();
        //$result_array['userDashboardImage'] = $userDashboardImage;
        return $userDashboardImage;
    }

    public function userDashboardImageAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        
        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.user_type = '1' AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND up.user_type = '1' AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC";

        $query = $this->db->query($sql);

        $userDashboardImage = $query->result_array();
        //$result_array['userDashboardImageAll'] = $userDashboardImage;
        return $userDashboardImage;
    }

    public function userDashboardVideo($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('filename')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'video');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '1');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardVideo = $query->result_array();
        //$result_array['userDashboardVideo'] = $userDashboardVideo;
        return $userDashboardVideo;
    }

    public function userDashboardVideoAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('filename')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'video');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '1');
        $this->db->order_by('upf.id', 'desc');        
        $query = $this->db->get();
        $userDashboardVideoAll = $query->result_array();
        //$result_array['userDashboardVideo'] = $userDashboardVideo;
        return $userDashboardVideoAll;
    }

    public function userDashboardAudio($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');
        $this->db->where('upf.file_type', 'audio');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '1');
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardAudio = $query->result_array();
        //$result_array['userDashboardAudio'] = $userDashboardAudio;
        return $userDashboardAudio;
    }

    public function userDashboardAudioAll($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');
        $this->db->where('upf.file_type', 'audio');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '1');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('upf.id', 'desc');        
        $query = $this->db->get();
        $userDashboardAudioAll = $query->result_array();
        
        return $userDashboardAudioAll;
    }

    public function userDashboardPdf($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');;
        $this->db->where('upf.file_type', 'pdf');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '1');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('upf.id', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        $userDashboardPdf = $query->result_array();
        $result_array['userDashboardPdf'] = $userDashboardPdf;
        return $result_array;
    }

    public function getUserDashboardArticle($user_id,$login_userid)
    {
        $this->db->select("a.id_post_article, a.article_title, a.article_featured_image, a.article_slug, a.unique_key")->from("post_article a");
        if($login_userid != $user_id)
        {            
            $this->db->join('user_post up', 'up.post_id = a.id_post_article', 'left');
            $this->db->where('up.user_id', $user_id);
            $this->db->where('up.status', 'publish');
            $this->db->where('up.post_for', 'article');
        }
        else
        {
            $this->db->where('a.user_id', $user_id);
            $this->db->where('a.status != ', 'delete');   
        }
        $this->db->where('a.user_type', '1');   
        $this->db->order_by('a.id_post_article', 'desc');
        $this->db->limit('6');
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        $article_data = $query->result_array();
        if($login_userid == $user_id)
        { 
            foreach ($article_data as $k=>$v)
            {
                $check_article = $this->check_article($v['id_post_article']);             
                if(isset($check_article) && !empty($check_article))
                {
                    if($check_article['status'] == "publish")
                    {
                        $article_data[$k]['article_slug'] = base_url().'article/'.$v['article_slug'];
                    }
                    else
                    {
                        $article_data[$k]['article_slug'] = base_url().'article-preview/'.$v['article_slug'];  
                    }
                }
                else
                {
                    $article_data[$k]['article_slug'] = base_url().'edit-article/'.$v['unique_key'];
                }
            }            
        }
        else
        {
            foreach ($article_data as $k=>$v)
            {
                $article_data[$k]['article_slug'] = base_url().'article/'.$v['article_slug'];
            }    
        }
        $result_array['userDashboardArticle'] = $article_data;
        return $result_array;
    }
    public function check_article($post_id = '') {
        $this->db->select('*')->from('user_post');
        $this->db->where('post_id', $post_id);
        $this->db->where('post_for', 'article');
        $this->db->where('is_delete', '0');
        $query = $this->db->get();
        $article_data = $query->row_array();
        return $article_data;
    }
    public function simplePost($post_id = '') {
        $this->db->select('description')->from('user_simple_post usp');
        $this->db->where('usp.post_id', $post_id);
        $query = $this->db->get();
        $userSimplePost = $query->row_array();
        return $userSimplePost;
    }

    public function opportunityPost($post_id = '') {
        $this->db->select("uo.post_id,field, uo.other_field,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
        $this->db->where('uo.post_id', $post_id);
        $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
        $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
        $this->db->group_by('uo.opportunity_for', 'uo.location');
        $query = $this->db->get();
        $opportunity_data = $query->row_array();
        return $opportunity_data;
    }

    public function askQuestionPost($post_id = '') {
        $this->db->select("question,description,category,field,GROUP_CONCAT(DISTINCT(tg.name)) as tag_name")->from("user_ask_question uaq, ailee_tags tg");
        $this->db->where('uaq.post_id', $post_id);
        $this->db->where('FIND_IN_SET(tg.id, uaq.`category`) !=', 0);
        $this->db->group_by('uaq.category');
        $query = $this->db->get();
        $userAskPost = $query->row_array();
        return $userAskPost;
    }

    public function GetQuestionCategoryName($categoryId = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(t.name)) as category")->from("ailee_tags t");
        $this->db->where('FIND_IN_SET(t.id,"' . $categoryId . '") !=', 0);
        $query = $this->db->get();
        $category = $query->row_array();
        return $category;
    }

    public function GetLocationName($city_id = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(c.city_name)) as location")->from("ailee_cities c");
        $this->db->where('FIND_IN_SET(c.city_id,"' . $city_id . '") !=', 0);
        $query = $this->db->get();
        $location = $query->row_array();
        return $location;
    }

    public function GetJobTitleName($job_title_id = '') {
        $this->db->select("GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for")->from("ailee_job_title jt");
        $this->db->where('FIND_IN_SET(jt.title_id,"' . $job_title_id . '") !=', 0);
        $query = $this->db->get();
        $title = $query->row_array();
        return $title;
    }

    public function GetIndustryFieldName($ask_field = '') {
        $this->db->select("it.industry_name as field")->from("industry_type it");
        $this->db->where('it.industry_id', $ask_field);
        $query = $this->db->get();
        $field = $query->row_array();
        return $field;
    }

    public function searchData($userid = '', $searchKeyword = '') {

        $sql_ser = "LOWER(u.first_name) Like '%".strtolower($searchKeyword)."%' OR LOWER(u.last_name) Like '%".strtolower($searchKeyword)."%' OR LOWER(CONCAT(u.first_name,' ',u.last_name)) LIKE '%".strtolower($searchKeyword)."%' OR LOWER(CONCAT(u.last_name,' ',u.first_name)) LIKE '%".strtolower($searchKeyword)."%'";
        $sql_post = "LOWER(uo.opportunity) LIKE '%".strtolower($searchKeyword)."%' OR LOWER(usp.description) LIKE '%".strtolower($searchKeyword)."%' OR LOWER(uaq.question) LIKE '%".strtolower($searchKeyword)."%' OR LOWER(uaq.description) LIKE '%".strtolower($searchKeyword)."%'";
        
        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];
            $sql_ser .= " OR up.city = '$keywordCity' OR us.city = '$keywordCity'";
            $sql_post .= " OR FIND_IN_SET('" . $keywordCity . "',uo.location)";
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword,1);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];
            $sql_ser .= " OR up.designation = '$keywordJobTitle'";
            $sql_post .= " OR FIND_IN_SET('" . $keywordJobTitle . "',uo.opportunity_for)";
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];
            $sql_ser .= " OR up.field = '$keywordFieldList'";
            $sql_post .= " OR  uo.field = '$keywordFieldList' OR uaq.field = '$keywordFieldList'";
        }

        $checkKeywordUniversityList = $this->data_model->findUniversityList($searchKeyword);
        if ($checkKeywordUniversityList['university_id'] != '') {
            $keywordUniversityList = $checkKeywordUniversityList['university_id'];
            $sql_ser .= " OR us.university_name = '$keywordUniversityList'";
        }
        $checkKeywordDegreeList = $this->data_model->findDegreeList($searchKeyword);
        if ($checkKeywordDegreeList['degree_id'] != '') {
            $keywordDegreeList = $checkKeywordDegreeList['degree_id'];
            $sql_ser .= " OR us.current_study = '$keywordDegreeList'";
        }

        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_slug,ui.user_image,jt.name as title_name,d.degree_name,it.industry_name,up.city as profession_city,us.city as student_city,d.degree_name,un.university_name")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->join('university un', 'un.university_name = us.university_name', 'left');

        $this->db->where("u.user_id !=  $userid AND ( $sql_ser )");
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        $this->db->limit(5);
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $searchProfileData = $query->result_array();
        foreach ($searchProfileData as $key => $value) {
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['user_id']);
            if ($is_userBasicInfo) {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['profession_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['student_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['user_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['user_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileData[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileData[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileData[$key]['contact_not_read'] = $contact_detail['not_read'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_from =' . $value['user_id'] . ' AND follow_to =' . $userid . ') OR (follow_to =' . $value['user_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileData[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileData[$key]['follow_status'] = $follow_detail['status'];
        }

        $searchData['profile'] = $searchProfileData;


        $searchPostData = array();
        $getDeleteUserPost = $this->deletePostUser($userid);

        
        
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");
        $this->db->join('user_opportunity uo', 'uo.post_id = up.id', 'left');
        $this->db->join('user_simple_post usp', 'usp.post_id = up.id', 'left');
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where("up.status","publish");
        $this->db->where("up.is_delete","0");
        $this->db->where("(".$sql_post.")");
        // echo $sql_post;
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->limit(3);
        $this->db->order_by('up.id', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string($value['created_date']);
            $searchPostData[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchPostData[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchPostData[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchPostData[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $searchPostData[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $searchPostData[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();
                $question_data = $query->row_array();
                $searchPostData[$key]['question_data'] = $question_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $searchPostData[$key]['share_data'] = $share_data;
            } 
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchPostData[$key]['post_file_data'] = $post_file_data;

            $searchPostData[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $searchPostData[$key]['post_like_count'] = $post_like_count;
            $searchPostData[$key]['is_userlikePost'] = $this->is_userlikePost($userid, $value['id']);
            $searchPostData[$key]['is_user_saved_post'] = $this->is_user_saved_post($userid, $value['id']);

            $searchPostData[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if ($post_like_count > 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchPostData[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $searchPostData[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchPostData[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($userid, $value1['comment_id']);
                $searchPostData[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
        }

        $searchData['post'] = $searchPostData;
        $searchData['profile_total_rec'] = $this->searchDataProfileTotalRecAjax($userid,$searchKeyword);
        $searchData['post_total_rec'] = $this->searchDataPostTotalRecAjax($userid,$searchKeyword);
        return $searchData;
    }

    public function searchDataProfileAjax($userid = '', $searchKeyword = '',$start = "",$limit = "5") {

        $sql_ser = "u.first_name Like '%$searchKeyword%' OR u.last_name Like '%$searchKeyword%' OR CONCAT(u.first_name,' ',u.last_name) LIKE '%$searchKeyword%' OR CONCAT(u.last_name,' ',u.first_name) LIKE '%$searchKeyword%'";

        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];
            $sql_ser .= " OR up.city = '$keywordCity' OR us.city = '$keywordCity'";            
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword,1);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];
            $sql_ser .= " OR up.designation = '$keywordJobTitle'";            
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];
            $sql_ser .= " OR up.field = '$keywordFieldList'";            
        }

        $checkKeywordUniversityList = $this->data_model->findUniversityList($searchKeyword);
        if ($checkKeywordUniversityList['university_id'] != '') {
            $keywordUniversityList = $checkKeywordUniversityList['university_id'];
            $sql_ser .= " OR us.university_name = '$keywordUniversityList'";
        }
        $checkKeywordDegreeList = $this->data_model->findDegreeList($searchKeyword);
        if ($checkKeywordDegreeList['degree_id'] != '') {
            $keywordDegreeList = $checkKeywordDegreeList['degree_id'];
            $sql_ser .= " OR us.current_study = '$keywordDegreeList'";
        }

        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_slug,ui.user_image,jt.name as title_name,d.degree_name,it.industry_name,up.city as profession_city,us.city as student_city,d.degree_name,un.university_name")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->join('university un', 'un.university_name = us.university_name', 'left');

        $this->db->where("u.user_id !=  $userid AND ( $sql_ser )");
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $searchProfileData = $query->result_array();
        foreach ($searchProfileData as $key => $value) {
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['user_id']);
            if ($is_userBasicInfo) {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['profession_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['student_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['user_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['user_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileData[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileData[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileData[$key]['contact_not_read'] = $contact_detail['not_read'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_from =' . $value['user_id'] . ' AND follow_to =' . $userid . ') OR (follow_to =' . $value['user_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileData[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileData[$key]['follow_status'] = $follow_detail['status'];
        }

        $searchData['profile'] = $searchProfileData;
        $searchData['profile_total_rec'] = $this->searchDataProfileTotalRecAjax($userid,$searchKeyword);
        return $searchData;
    }

    public function searchDataProfileTotalRecAjax($userid = '', $searchKeyword = '') {

        $sql_ser = "u.first_name Like '%$searchKeyword%' OR u.last_name Like '%$searchKeyword%' OR CONCAT(u.first_name,' ',u.last_name) LIKE '%$searchKeyword%' OR CONCAT(u.last_name,' ',u.first_name) LIKE '%$searchKeyword%'";

        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];
            $sql_ser .= " OR up.city = '$keywordCity' OR us.city = '$keywordCity'";            
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword,1);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];
            $sql_ser .= " OR up.designation = '$keywordJobTitle'";            
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];
            $sql_ser .= " OR up.field = '$keywordFieldList'";            
        }

        $checkKeywordUniversityList = $this->data_model->findUniversityList($searchKeyword);
        if ($checkKeywordUniversityList['university_id'] != '') {
            $keywordUniversityList = $checkKeywordUniversityList['university_id'];
            $sql_ser .= " OR us.university_name = '$keywordUniversityList'";
        }
        $checkKeywordDegreeList = $this->data_model->findDegreeList($searchKeyword);
        if ($checkKeywordDegreeList['degree_id'] != '') {
            $keywordDegreeList = $checkKeywordDegreeList['degree_id'];
            $sql_ser .= " OR us.current_study = '$keywordDegreeList'";
        }

        $this->db->select("count(*) as total_record")->from("user u");
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->join('industry_type it', 'it.industry_id = up.field', 'left');
        $this->db->join('university un', 'un.university_name = us.university_name', 'left');

        $this->db->where("u.user_id !=  $userid AND ( $sql_ser )");        
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $total_rec = $query->row_array();
        return $total_rec['total_record'];
    }

    public function searchDataPostAjax($userid = '', $searchKeyword = '',$start = "",$limit = "5") {
        $sql_post = "uo.opportunity LIKE '%$searchKeyword%' OR usp.description LIKE '%$searchKeyword%' OR uaq.question LIKE '%$searchKeyword%' OR uaq.description LIKE '%$searchKeyword%'";
        
        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];            
            $sql_post .= " OR FIND_IN_SET('" . $keywordCity . "',uo.location)";
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword,1);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];            
            $sql_post .= " OR FIND_IN_SET('" . $keywordJobTitle . "',uo.opportunity_for)";
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];            
            $sql_post .= " OR  uo.field = '$keywordFieldList' OR uaq.field = '$keywordFieldList'";
        }

        $getDeleteUserPost = $this->deletePostUser($userid);
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");
        $this->db->join('user_opportunity uo', 'uo.post_id = up.id', 'left');
        $this->db->join('user_simple_post usp', 'usp.post_id = up.id', 'left');
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where("up.status","publish");
        $this->db->where("up.is_delete","0");
        $this->db->where("(".$sql_post.")");
        // echo $sql_post;
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('up.id', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $user_post = $query->result_array();
        $searchPostData = array();
        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string($value['created_date']);
            $searchPostData[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchPostData[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchPostData[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as user_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchPostData[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $searchPostData[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $searchPostData[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();
                $question_data = $query->row_array();
                $searchPostData[$key]['question_data'] = $question_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $searchPostData[$key]['share_data'] = $share_data;
            } 
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchPostData[$key]['post_file_data'] = $post_file_data;

            $searchPostData[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $searchPostData[$key]['post_like_count'] = $post_like_count;
            $searchPostData[$key]['is_userlikePost'] = $this->is_userlikePost($userid, $value['id']);
            $searchPostData[$key]['is_user_saved_post'] = $this->is_user_saved_post($userid, $value['id']);

            $searchPostData[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if ($post_like_count > 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchPostData[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchPostData[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $searchPostData[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchPostData[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($userid, $value1['comment_id']);
                $searchPostData[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
        }

        $searchData['post'] = $searchPostData;
        $searchData['post_total_rec'] = $this->searchDataPostTotalRecAjax($userid,$searchKeyword);

        return $searchData;
    }

    public function searchDataPostTotalRecAjax($userid = '', $searchKeyword = '',$start = "",$limit = "5") {
        $sql_post = "uo.opportunity LIKE '%$searchKeyword%' OR usp.description LIKE '%$searchKeyword%' OR uaq.question LIKE '%$searchKeyword%' OR uaq.description LIKE '%$searchKeyword%'";
        
        $checkKeywordCity = $this->data_model->findCityList($searchKeyword);
        if ($checkKeywordCity['city_id'] != '') {
            $keywordCity = $checkKeywordCity['city_id'];            
            $sql_post .= " OR FIND_IN_SET('" . $keywordCity . "',uo.location)";
        }
        $checkKeywordJobTitle = $this->data_model->findJobTitle($searchKeyword,1);
        if ($checkKeywordJobTitle['title_id'] != '') {
            $keywordJobTitle = $checkKeywordJobTitle['title_id'];            
            $sql_post .= " OR FIND_IN_SET('" . $keywordJobTitle . "',uo.opportunity_for)";
        }
        $checkKeywordFieldList = $this->data_model->findFieldList($searchKeyword);
        if ($checkKeywordFieldList['industry_id'] != '') {
            $keywordFieldList = $checkKeywordFieldList['industry_id'];            
            $sql_post .= " OR  uo.field = '$keywordFieldList' OR uaq.field = '$keywordFieldList'";
        }

        $getDeleteUserPost = $this->deletePostUser($userid);
        $this->db->select("count(*) as total_record")->from("user_post up");
        $this->db->join('user_opportunity uo', 'uo.post_id = up.id', 'left');
        $this->db->join('user_simple_post usp', 'usp.post_id = up.id', 'left');
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where("up.status","publish");
        $this->db->where("up.is_delete","0");
        $this->db->where("(".$sql_post.")");
        // echo $sql_post;
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->order_by('up.id', 'desc');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        $total_rec = $query->row_array();
        return $total_rec['total_record'];
    }
    
    
    public function getLikeUserList($post_id = '') {
        $this->db->select("upl.id,upl.post_id,upl.user_id,upl.modify_date,u.user_slug,u.user_gender,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = upl.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = upl.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('upl.post_id',$post_id);
        $this->db->where('upl.is_like','1');
        $this->db->where('ul.status','1');
        $this->db->where('ul.is_delete', '0');
        $this->db->order_by('upl.id', 'DESC');
        $query = $this->db->get();
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $result_array[$key]['time_string'] = $this->common->time_elapsed_string($value['modify_date']);    
        }
        return $result_array;
    }

    public function getQuestionDataFromId($post_id)
    {
        $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
        $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
        $this->db->where('uaq.post_id', $post_id);
        //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
        $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
        $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
        $this->db->where($sql);
        $this->db->group_by('uaq.category','uaq.hashtag');
        $query = $this->db->get();                
        $question_data = $query->row_array();
        $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
        return $question_data;
    }

    public function getOpportunityDataFromId($post_id)
    {
        $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle, uo.oppslug, uo.company_name, IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
        $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
        $this->db->where('uo.post_id', $post_id);
        $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
        $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
        $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
        $this->db->where($sql);
        $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
        $query = $this->db->get();
        $opportunity_data = $query->row_array();
        $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
        return $opportunity_data;
    }

    public function postDetail($post_id = '', $user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->where('up.id', $post_id);
        $this->db->where('up.status', 'publish');
        // $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.id', 'desc');
        
        $query = $this->db->get();
        $user_post = $query->result_array();
        
        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];            

            if($value['user_type'] == '1')
            {
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $result_array[$key]['share_data'] = $share_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("article_slug,user_id")->from("post_article");                
                $this->db->where('id_post_article', $value['post_id']);
                $this->db->where('status', 'publish');                
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($user_id, $value['id']);

            $result_array[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if($user_id == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            /*$result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;*/
        }
       // echo '<pre>';
       // print_r($result_array);
       // exit;
        return $result_array;
    }

    public function create_opp_slug()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * from ailee_user_opportunity ORDER BY post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        // print_r($result_array);exit;
        foreach ($result_array as $key => $value) {
            $opportunity_for = explode(",", $value['opportunity_for']);
            $opptitle = $this->db->get_where('job_title', array('title_id' => $opportunity_for[0]))->row()->name;            
            $oppslug = $this->common->set_slug($opptitle, 'oppslug', 'user_opportunity');
            $update_data = array(
                "opptitle"=>trim($opptitle),
                "oppslug"=>trim($oppslug)
            );
            // $value['opptitle'] = trim($opptitle);
            // $value['oppslug'] = trim($oppslug);
            // print_r($value);
            $update_post = $this->common->update_data($update_data, 'user_opportunity', 'id', $value['id']);
        }
        echo "Done";
    }

    public function get_opportunity_from_slug($slug)
    {
        $this->db->select("uo.post_id,up.user_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field,uo.other_field,uo.opptitle,uo.oppslug,up.created_date")->from("user_opportunity uo, job_title jt, cities c");
        $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
        $this->db->join('user_post up', 'up.id = uo.post_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = up.user_id', 'left');
        $this->db->where('uo.oppslug', $slug);
        $this->db->where('FIND_IN_SET(jt.title_id, uo.opportunity_for) !=', 0);
        $this->db->where('FIND_IN_SET(c.city_id, uo.location) !=', 0);
        $this->db->where('ul.status','1');
        $this->db->where('ul.is_delete','0');
        $this->db->group_by('uo.opportunity_for', 'uo.location');

        // $this->db->select("uo.post_id,up.user_id,uo.opptitle,uo.oppslug")->from("user_opportunity uo");
        // $this->db->join('user_post up', 'up.id = uo.post_id', 'left');
        
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        $opportunity_data = $query->row_array();        
        return $opportunity_data;
    }

    public function get_business_contact_suggetion($user_id)
    {
        $sql = "SELECT bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name
            FROM ailee_business_profile bp
            LEFT JOIN ailee_user_login ul ON ul.user_id = bp.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city
            LEFT JOIN ailee_states st ON st.state_id = bp.state
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.user_id != '". $user_id ."'
            AND bp.business_step = '4'
            AND bp.is_deleted = '0'
            AND bp.status = '1'
            AND ul.status = '1'
            AND ul.is_delete = '0'
            AND bp.user_id NOT IN (select follow_to from ailee_user_follow where follow_from='" . $user_id . "' AND follow_type = '2' AND status = '1')";

        $sql .= " ORDER BY bp.business_profile_id DESC LIMIT 30";
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_user_like_list($post_id = '') {
        $this->db->select("upl.user_id,u.first_name,u.last_name,u.user_slug,CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_gender,ui.user_image")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id',$post_id);
        $this->db->where('upl.is_like','1');
        $this->db->where('ul.status','1');
        $this->db->where('ul.is_delete', '0');
        $this->db->order_by('upl.id', 'DESC');
        $this->db->limit(2);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function business_user_post_new($user_id = '', $page = '')
    {
        $userid_login = $this->session->userdata('aileenuser');
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->where('user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '2');
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->order_by('up.created_date', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
            $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
            $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
            $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
            $this->db->join('states st', 'st.state_id = bp.state', 'left');
            $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
            $this->db->where('bp.user_id', $value['user_id']);
            $query = $this->db->get();
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            }
            elseif($value['post_for'] == 'share'){
                $this->db->select("*")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
                $share_data['data'] = $this->get_post_from_id($share_data['shared_post_id']);
                $result_array[$key]['share_data'] = $share_data;
            }
            elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $this->db->where('pa.status', 'publish');
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($userid_login, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($userid_login, $value['id']);

            $result_array[$key]['post_share_count'] = $this->postShareCount($value['id']);

            if($userid_login == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($userid_login, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->businessUserPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }

        return $result_array;
    }

    public function businessUserPostCount($user_id) {

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");        
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.user_type', '2');

        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function get_post_comment_reply_id($post_id = '',$comment_id='') {
        $this->db->select("upc.*")->from("user_post_comment upc");
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('upc.id', $comment_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function post_comment_reply_data($post_id = '',$comment_id = '',$user_id = '') {
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('upc.reply_comment_id',$comment_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'asc');        
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment'] = nl2br($this->common->make_links($post_comment_data[$key]['comment']));
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value['comment_id']);
        }
        return $post_comment_data;
    }

    public function get_simepl_post_data_from_id($post_id)
    {
        $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
        $this->db->where('usp.post_id', $post_id);
        $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
        $this->db->where($sql);
        $this->db->group_by('usp.hashtag');
        $query = $this->db->get();
        $simple_data = $query->row_array();
        $simple_data['description'] = nl2br($this->common->make_links($simple_data['description']));
        return $simple_data;
    }

    public function get_simplepost_from_slug($slug)
    {
        $this->db->select("usp.post_id,up.user_id,usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
        $this->db->join('user_post up', 'up.id = usp.post_id', 'left');
        $this->db->where('usp.simslug', $slug);
        $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
        $this->db->where($sql);
        $this->db->group_by('usp.hashtag');
        $query = $this->db->get();
        $simple_data = $query->row_array();
        $simple_data['description'] = nl2br($this->common->make_links($simple_data['description']));
        return $simple_data;
    }

    public function get_post_detail_from_comment_id($comment_id = '', $user_id = '') {

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user_post_comment upc', 'upc.post_id = up.id', 'left');
        $this->db->where('upc.id', $comment_id);
        $this->db->where('up.status', 'publish');        
        $this->db->where('up.is_delete', '0');
        $this->db->where('up.id NOT IN (SELECT post_id FROM ailee_user_post_delete WHERE user_id = "'.$user_id.'")');
        
        $this->db->order_by('up.id', 'desc');
        
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];            

            if($value['user_type'] == '1')
            {
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $result_array[$key]['user_like_list'] = $this->get_user_like_list($value['id']);
            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            $result_array[$key]['is_user_saved_post'] = $this->is_user_saved_post($user_id, $value['id']);
            if($user_id == $post_like_data['user_id'])
            {
                $postLikeUsername = "You";
            }
            else
            {
                $postLikeUsername = $post_like_data['username'];
            }
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $postLikeUsername;
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id'],$user_id);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
        }
        return $result_array;
    }

    public function get_contact_sugetion_in_post($user_id,$page)
    {
        $limit = '21';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'designation,field,other_field,city');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'us.current_study, us.city, us.university_name,us.interested_fields,us.other_interested_fields');
        if($getUserProfessionData)
        {
            $sql = "SELECT main.* FROM(SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, jt.name as title_name from ailee_user_profession up 
                LEFT JOIN ailee_user_profession up1 ON up1.designation = up.designation 
                LEFT JOIN ailee_user u ON u.user_id = up1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = up1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = up1.user_id 
                LEFT JOIN ailee_job_title jt ON jt.title_id = up1.designation
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)                

                UNION

                SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, jt.name as title_name from ailee_user_profession up 
                LEFT JOIN ailee_user_profession up1 ON up1.city = up.city 
                LEFT JOIN ailee_user u ON u.user_id = up1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = up1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = up1.user_id 
                LEFT JOIN ailee_job_title jt ON jt.title_id = up1.designation
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)                

                UNION

                SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, jt.name as title_name from ailee_user_profession up 
                LEFT JOIN ailee_user_profession up1 ON up1.field = up.field 
                LEFT JOIN ailee_user u ON u.user_id = up1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = up1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = up1.user_id 
                LEFT JOIN ailee_job_title jt ON jt.title_id = up1.designation
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)
                AND (IF(up1.field = 0, CONCAT(LOWER(up.other_field) LIKE '%',REPLACE(up1.other_field,' ','%' OR LOWER(up.other_field) LIKE '%'),'%'),1=1))
                
            ) as main where main.user_id != $user_id";
        }

        if($getUserStudentData)
        {
            $sql = "SELECT main.* FROM(SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, d.degree_name as title_name from ailee_user_student up 
                LEFT JOIN ailee_user_student us1 ON us1.current_study = up.current_study 
                LEFT JOIN ailee_user u ON u.user_id = us1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = us1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = us1.user_id 
                LEFT JOIN ailee_degree d ON d.degree_id = us1.current_study
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)

                UNION

                SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, d.degree_name as title_name from ailee_user_student up 
                LEFT JOIN ailee_user_student us1 ON us1.city = up.city 
                LEFT JOIN ailee_user u ON u.user_id = us1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = us1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = us1.user_id 
                LEFT JOIN ailee_degree d ON d.degree_id = us1.current_study
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)                

                UNION

                SELECT u.user_slug, u.user_id, u.first_name, u.last_name, u.user_gender, ui.user_image, ui.profile_background, d.degree_name as title_name from ailee_user_student up 
                LEFT JOIN ailee_user_student us1 ON us1.interested_fields = up.interested_fields 
                LEFT JOIN ailee_user u ON u.user_id = us1.user_id 
                LEFT JOIN ailee_user_info ui ON ui.user_id = us1.user_id 
                LEFT JOIN ailee_user_login ul ON ul.user_id = us1.user_id 
                LEFT JOIN ailee_degree d ON d.degree_id = us1.current_study
                WHERE up.user_id = $user_id 
                AND u.user_id != $user_id
                AND ul.status = '1'
                AND ul.is_delete = '0'
                AND u.user_id NOT IN (select from_id from ailee_user_contact where to_id=$user_id)
                AND u.user_id NOT IN (select to_id from ailee_user_contact where from_id=$user_id)
                AND (IF(us1.interested_fields = 0, CONCAT(LOWER(up.other_interested_fields) LIKE '%',REPLACE(us1.other_interested_fields,' ','%' OR LOWER(up.other_interested_fields) LIKE '%'),'%'),1=1))
            ) as main where main.user_id != $user_id";
        }
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;exit();
        
        $query = $this->db->query($sql);
        $user_contact = $query->result_array();
        return $user_contact;
    }

    public function get_post_from_id($post_id = '') {
        
        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->where('up.id', $post_id);
        $this->db->where('up.status', 'publish');
        // $this->db->where('up.post_for != ', 'question');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
        
        $query = $this->db->get();
        $user_post = $query->row_array();
        
        // foreach ($user_post as $key => $value) {
            $user_post['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post['created_date'])));
            $result_array['post_data'] = $user_post;

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $user_post['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array['post_data']['total_post_files'] = $total_post_files['file_count'];            

            if($user_post['user_type'] == '1')
            {
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $user_post['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $user_post['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array['user_data'] = $user_data;
            }

            if ($user_post['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $user_post['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array['opportunity_data'] = $opportunity_data;
            } elseif ($user_post['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $user_post['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array['simple_data'] = $simple_data;
            } elseif ($user_post['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $user_post['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array['question_data'] = $question_data;
            } elseif ($user_post['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $user_post['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array['profile_update'] = $profile_update;
            } elseif ($user_post['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $user_post['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array['cover_update'] = $cover_update;
            }
            elseif ($user_post['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $user_post['post_id']);
                $this->db->where('pa.status', 'publish');
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array['article_data'] = $article_data;

            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $user_post['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array['post_file_data'] = $post_file_data;
        // }      
        return $result_array;
    }

    public function get_sharepost_from_slug($slug)
    {
        $this->db->select("ups.post_id,up.user_id,ups.description, ups.shared_post_slug")->from("user_post_share ups");
        $this->db->join('user_post up', 'up.id = ups.post_id', 'left');
        $this->db->join('user_post upmain', 'upmain.id = ups.shared_post_id', 'left');
        $this->db->where('ups.shared_post_slug', $slug);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->where('upmain.status', 'publish');
        $this->db->where('upmain.is_delete', '0');
        $query = $this->db->get();        
        $shared_data = $query->row_array();
        if(isset($shared_data) && !empty($shared_data))
        {
            $shared_data['description'] = nl2br($this->common->make_links($shared_data['description']));
        }
        return $shared_data;
    }

    public function get_sharepost_from_shareid($id_user_post_share)
    {
        $this->db->select("ups.post_id,up.user_id,ups.description, ups.shared_post_slug")->from("user_post_share ups");
        $this->db->join('user_post up', 'up.id = ups.post_id', 'left');
        $this->db->where('ups.id_user_post_share', $id_user_post_share);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();        
        $shared_data = $query->row_array();
        $shared_data['description'] = nl2br($this->common->make_links($shared_data['description']));
        return $shared_data;
    }

    public function get_user_payment_history($userid)
    {
        $this->db->select("*,DATE_FORMAT(modify_date, '%d %M, %Y') as modify_date_str ,DATE_FORMAT(payment_date, '%d %M, %Y') as payment_date_str")->from("user_payment_mapper");        
        $this->db->where('user_id', $userid);        
        $this->db->where('earn_amount >= 10');        
        $this->db->order_by('created_date', 'desc');        
        $query = $this->db->get();        
        $payment_data = $query->result_array();        
        return $payment_data;
    }

    public function get_user_bank_detail($userid)
    {
        $this->db->select("*")->from("user_bank_detail");
        $this->db->where('user_id', $userid);
        $this->db->where('status','1');
        $query = $this->db->get();
        $bank_data = $query->row_array();
        return $bank_data;
    }
}
