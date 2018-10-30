<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile_model extends CI_Model {

    public function getdashboardata($user_id = '', $select_data = '') {
        $this->db->select($select_data)->from("user u");
        $this->db->join('art_reg a', 'a.user_id = u.user_id', 'left');
        $this->db->join('recruiter r', 'r.user_id = u.user_id', 'left');
        $this->db->join('job_reg jr', 'jr.user_id = u.user_id', 'left');
        $this->db->join('business_profile bp', 'bp.user_id = u.user_id', 'left');
        $this->db->join('freelancer_post_reg fp', 'fp.user_id = u.user_id', 'left');
        $this->db->join('freelancer_hire_reg fh', 'fh.user_id = u.user_id', 'left');
        $this->db->where("u.user_id =" . $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getContactData($user_id = '', $select_data = '', $page = '',$login_user_id = '') {
        $limit = '6';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("uc.id,u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_contact  uc");
        $this->db->join('user u', 'u.user_id = (CASE WHEN uc.from_id=' . $user_id . ' THEN uc.to_id ELSE uc.from_id END)', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getContactCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        foreach ($result_array as $key => $value) {
            $is_userContactInfo= $this->userContactStatus($login_user_id, $value['user_id']);
            if(isset($is_userContactInfo) && !empty($is_userContactInfo))
            {
                $result_array[$key]['contact_detail']['contact_status'] = 1;
                $result_array[$key]['contact_detail']['contact_value'] = $is_userContactInfo['status'];
                $result_array[$key]['contact_detail']['contact_id'] = $is_userContactInfo['id'];
            }
            else
            {
                $result_array[$key]['contact_detail']['contact_status'] = 0;
                $result_array[$key]['contact_detail']['contact_value'] = 'new';
                $result_array[$key]['contact_detail']['contact_id'] = $is_userContactInfo['id'];   
            }
        }

        $data = array(
            'contactrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function getFollowersData($user_id = '', $select_data = '', $page = '') {

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $where = "((uf.follow_to = '" . $user_id . "'))";

        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_follow  uf");
        $this->db->join('user u', 'u.user_id = uf.follow_from', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
//        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");

        $query = $this->db->get();
        $result_array = $query->result_array();
        $user_follow_array = array();
       // echo $this->db->last_query();die;
        // echo '<pre>'; print_r($result_array); die();
        $new_follow_array = array();
        foreach ($result_array as $result) {
            $condition = "((uf.follow_from = '" . $user_id . "' AND uf.follow_to = '" . $result['user_id'] . "'))";
            $this->db->select("uf.id as follow_user_id")->from("user_follow uf");
            $this->db->where('uf.status', '1');
            $this->db->where($condition);
            $querry = $this->db->get();
            $result_query = $querry->result_array();            
            if(isset($result_query) && !empty($result_query))
            {                
                $result['follow_user_id'] = $result_query[0]['follow_user_id'];
            }

            array_push($new_follow_array, $result);
        }        
        $total_record = $this->getFollowerCount($user_id, $select_data = '');
        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'followerrecord' => $new_follow_array,
            'pagedata' => $page_array
        );
        return $data;
        // return $new_follow_array;
    }

    public function getFollowingData($user_id = '', $select_data = '', $page = '', $login_user_id = '') {

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $where = "((uf.follow_from = '" . $user_id . "'))";
        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_follow  uf");
        $this->db->join('user u', 'u.user_id = uf.follow_to', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
//        $this->db->where('u.user_id !=', $user_id);
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");

        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getFollowingCount($user_id, $select_data = '');
        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        foreach ($result_array as $key => $value) {
            if($login_user_id != $value['user_id'])
            {      
                $condition = "((uf.follow_from = '" . $login_user_id . "' AND uf.follow_to = '" . $value['user_id'] . "'))";
                $this->db->select("uf.id as follow_user_id")->from("user_follow uf");
                $this->db->where('uf.status', '1');
                $this->db->where($condition);
                $querry = $this->db->get();
                $result_query = $querry->result_array();            
                if(isset($result_query) && !empty($result_query))
                {                
                    $result_array[$key]["follow_status"] = 1;
                }
                else
                {
                    $result_array[$key]["follow_status"] = 0;
                }
            }
        }
        $data = array(
            'followingrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        // return $result_array;
    }

    public function userContactStatus($user_id = '', $id = '') {
        $this->db->select("uc.status,uc.id,uc.from_id")->from("user_contact as uc");
        $where = "((from_id = '" . $user_id . "' AND to_id = '" . $id . "') OR (from_id = '" . $id . "' AND to_id = '" . $user_id . "'))";
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function userContactStatusNew($user_id = '', $id = '') //Login user id,To user id
    {
        $this->db->select("uc.status,uc.id")->from("user_contact as uc");
        $where = "(from_id = '" . $user_id . "' AND to_id = '" . $id . "')";
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function userFollowStatus($user_id = '', $id = '') {
        $this->db->select("uf.status,uf.id")->from("user_follow as uf");
        $where = "((follow_from = '" . $user_id . "' AND follow_to = '" . $id . "'))";
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getUserBackImage($user_id = '') {
        $this->db->select("profile_background,profile_background_main")->from("user_info");
        $this->db->where("user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getContactCount($user_id = '', $select_data = '') {

        $where = "((from_id = '" . $user_id . "' OR to_id = '" . $user_id . "'))";

        $this->db->select("count(*) as total")->from("user_contact  uc");
        $this->db->where('uc.status', 'confirm');
        $this->db->where($where);
        $this->db->order_by("uc.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowingCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_from = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getFollowerCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_to = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function userDashboardPost($user_id = '', $page = '') {
        $limit = '4';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date,up.post_id")->from("user_post up");
        $this->db->where('user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        foreach ($user_post as $key => $value) {
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id,u.user_slug,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
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
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $this->db->group_by('uo.opportunity_for', 'uo.location');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,GROUP_CONCAT(DISTINCT(t.name)) as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->group_by('uaq.category');
                $query = $this->db->get();
                $question_data = $query->row_array();
                $result_array[$key]['question_data'] = $question_data;
            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'];
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $result_array[$key]['post_comment_data'] = $postCommentData = $this->postCommentData($value['id']);

            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }
        }

        $page_array['page'] = $page;
        $page_array['total_record'] = $this->userPostCount($user_id);
        $page_array['perpage_record'] = $limit;

        $data = array(
            'postrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
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

    public function postCommentCount($post_id = '') {
        $this->db->select("COUNT(upc.id) as comment_count")->from("user_post_comment upc");
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['comment_count'];
    }

    public function postCommentData($post_id = '') {
        $this->db->select("u.user_slug,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date,u.user_gender")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        return $post_comment_data = $query->result_array();
    }

    public function userPostCount($user_id = '') {
        $getUserProfessionData = $this->user_model->getUserProfessionData($user_id, $select_data = 'field,other_field');
        $getUserStudentData = $this->user_model->getUserStudentData($user_id, $select_data = 'current_study');

        $getSameFieldProUser = $this->user_model->getSameFieldProUser($getUserProfessionData['field'],$getUserProfessionData['other_field']);
        $getSameFieldStdUser = $this->user_model->getSameFieldStdUser($getUserStudentData['current_study']);

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['post_count'];
    }

    public function deletePostUser($user_id = '') {
        $this->db->select("GROUP_CONCAT(CONCAT('''', `post_id`, '''' )) AS group_post")->from("user_post_delete upd");
        $this->db->where("upd.user_id", $user_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['group_post'];
    }

    public function userQuestionsCount($user_id = '')
    {

        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("COUNT(up.id) as post_count")->from("user_post up");
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for', 'question');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();        
        $result_array = $query->row_array();
        return $result_array['post_count'];
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

    public function questionData($question_id = '', $user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where('uaq.id', $question_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
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

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
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

            $this->db->select("uaq.*,IF(uaq.category != '',GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
            $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
            $this->db->where('uaq.id', $value['post_id']);
            $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) !=0 , 1=1)");
            $this->db->group_by('uaq.category');
            $query = $this->db->get();
            $question_data = $query->row_array();
            $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
            $result_array[$key]['question_data'] = $question_data;

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
            if ($post_like_count > 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $result_array[$key]['post_like_data'] = $post_like_data['username'];
            }
            $result_array[$key]['post_comment_count'] = $this->postCommentCount($value['id']);
            $postCommentData = $this->postCommentData($value['id']);

            foreach ($postCommentData as $key1 => $value1) {
                $postCommentData[$key1]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($postCommentData[$key1]['created_date'])));
                $postCommentData[$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $postCommentData[$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['post_comment_data'] = $postCommentData;

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userPostCount($user_id);
        }
        return $result_array;
    }

    public function questionList($user_id = '', $select_data = '', $page = '') {
        $userid_login = $this->session->userdata('aileenuser');
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $result_array = array();
        $this->db->select("up.id,up.user_id,up.post_for,up.created_date,up.post_id")->from("user_post up");//UNIX_TIMESTAMP(STR_TO_DATE(up.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        if ($getUserProfessionData && $getSameFieldProUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldProUser . ')');
        } elseif ($getUserStudentData && $getSameFieldStdUser) {
            $this->db->where('up.user_id IN (' . $getSameFieldStdUser . ')');
        }
        $this->db->join('user_ask_question uaq', 'uaq.post_id = up.id', 'left');
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for', 'question');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('up.id', 'desc');
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

            $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
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

            $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field")->from("user_ask_question uaq, ailee_tags t");
            $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
            $this->db->where('uaq.id', $value['post_id']);
            $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
            //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
            $this->db->group_by('uaq.category');
            $query = $this->db->get();
            $question_data = $query->row_array();
            $result_array[$key]['question_data'] = $question_data;

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;

            $post_like_data = $this->postLikeData($value['id']);
            $post_like_count = $this->likepost_count($value['id']);
            $result_array[$key]['post_like_count'] = $post_like_count;
            $result_array[$key]['is_userlikePost'] = $this->is_userlikePost($user_id, $value['id']);
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
            
            foreach ($postCommentData as $key1 => $value1) {
                $result_array[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->is_userlikePostComment($user_id, $value1['comment_id']);
                $result_array[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->postCommentLikeCount($value1['comment_id']);
            }

            $result_array[$key]['page_data']['page'] = $page;
            $result_array[$key]['page_data']['total_record'] = $this->userQuestionsCount($user_id);//$this->userPostCount($user_id);
            $result_array[$key]['page_data']['perpage_record'] = $limit;
        }
//        echo '<pre>';
//        print_r($result_array);
//        exit;
        return $result_array;
    }

    public function getPhotosData($user_id = '', $select_data = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $getDeleteUserPost = $this->deletePostUser($user_id);

        /*$this->db->select('filename')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'image');
        if($user_id != "")
        {
            $this->db->where('up.user_id', $user_id);
        }
        if ($getDeleteUserPost) {
            $this->db->where('up.id NOT IN (' . $getDeleteUserPost . ')');
        }

        $this->db->order_by('upf.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();*/
        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC";
        if ($limit != '') {            
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        $total_record = $this->getPhotosCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'photosrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function userAllPhotos($user_id = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $sql = "SELECT main.* FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
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

    public function getPhotosCount($user_id = '', $select_data = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);        
        $sql = "SELECT count(*) as total FROM (SELECT upf.post_id,upf.filename,'image' as filetype,up.created_date FROM ailee_user_post_file upf 
                LEFT JOIN ailee_user_post up ON up.id = upf.post_id 
                LEFT JOIN ailee_user_profile_update upu ON upu.id = up.post_id 
                WHERE upf.file_type = 'image' AND up.user_id = $user_id AND up.status = 'publish' AND up.is_delete = '0' 
                UNION
                SELECT up.id,upu.data_value as filename,upu.data_key as filetype,up.created_date FROM ailee_user_profile_update upu 
                LEFT JOIN ailee_user_post up ON upu.id = up.post_id 
                WHERE upu.user_id = $user_id AND ( up.post_for = 'profile_update' OR up.post_for = 'cover_update') AND up.status = 'publish' AND up.is_delete = '0'
                ) as main ";
        if ($getDeleteUserPost) {
            $sql .= "WHERE main.post_id NOT IN ($getDeleteUserPost) ";
        }
        $sql .= "ORDER BY main.created_date DESC";
        
        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getVideosData($user_id = '', $select_data = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

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
        $this->db->order_by('upf.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getVideosCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'videorecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function userAllVideo($user_id = '') {
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
        $this->db->order_by('upf.id', 'desc');        
        $query = $this->db->get();
        $userDashboardImage = $query->result_array();
        //$result_array['userDashboardImageAll'] = $userDashboardImage;
        return $userDashboardImage;
    }

    public function getVideosCount($user_id = '', $select_data = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('count(*) as total')->from('user_post_file upf');
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
        $this->db->order_by('upf.id', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getAudiosData($user_id = '', $select_data = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

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
        $this->db->order_by('upf.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getAudiosCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'videorecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function getAudiosCount($user_id = '', $select_data = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('count(*) as total')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
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
        $this->db->order_by('upf.id', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getPdfData($user_id = '', $select_data = '', $page = '') {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select("upf.filename,up.id,up.post_for,IF(usp.description = 'undefined','',IFNULL(usp.description,'')) as description,IF(uo.opportunity = 'undefined','',IFNULL(uo.opportunity,'')) as opportunity")->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->join('user_simple_post usp', 'up.id = usp.post_id', 'left');
        $this->db->join('user_opportunity uo', 'up.id = uo.post_id', 'left');
        $this->db->where('upf.file_type', 'pdf');
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
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        $total_record = $this->getPdfCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'pdfrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        //  return $result_array;
    }

    public function getPdfCount($user_id = '', $select_data = '') {
        $getDeleteUserPost = $this->deletePostUser($user_id);
        $this->db->select('count(*) as total')->from('user_post_file upf');
        $this->db->join('user_post up', 'up.id = upf.post_id', 'left');
        $this->db->where('upf.file_type', 'pdf');
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
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function getArticleData($user_id = '', $select_data = '', $page = '')
    {
        $limit = '5';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $login_userid = $this->session->userdata('aileenuser');
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
        $this->db->order_by('a.id_post_article', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
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
        $total_record = $this->getArticleCount($user_id, $select_data = '');

        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'articlerecord' => $article_data,
            'pagedata' => $page_array
        );
        return $data;
    }

    public function getArticleCount($user_id = '', $select_data = '')
    {
        $login_userid = $this->session->userdata('aileenuser');
        $this->db->select("count(*) as total")->from("post_article a");
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
            // $this->db->where('a.status != ', 'delete');   
        }
        $this->db->order_by('a.id_post_article', 'desc');        
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        return $query->row_array();
    }

    public function check_article($post_id = '') {
        $this->db->select('*')->from('user_post');
        $this->db->where('post_id', $post_id);
        $this->db->where('post_for', 'article');        
        $query = $this->db->get();
        $article_data = $query->row_array();
        return $article_data;
    }

    public function get_skills() {
        $this->db->select("s.skill as name")->from("skill s");
        $this->db->where("(s.type = '1' OR s.type = '2')");
        $this->db->where('s.status', '1');
        $this->db->group_by('s.skill');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_user_skills($userid)
    {
        $this->db->select("s.skill as name")->from("user_info ui, skill s");
        $this->db->where('ui.user_id', $userid);
        $this->db->where("(s.type = '1' OR s.type = '2')");
        $this->db->where('FIND_IN_SET(s.skill_id, ui.`user_skills`) !=', 0);
        // $this->db->group_by('ui.user_skills', 'uo.location');
        $query = $this->db->get();
        $skills_data = $query->result_array();        
        return $skills_data;
    }

    public function get_about_user($userid)
    {
        $this->db->select("user_hobbies, user_fav_quote_headline, user_fav_artist, user_fav_book, user_fav_sport")->from("user_info");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data;
    }

    public function get_user_languages($userid)
    {
        $this->db->select("user_id,language_txt as language_name,proficiency,status")->from("user_languages");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_research($userid,$research_title = "",$research_desc = "",$research_url = "",$research_published_date = "",$research_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'research_title' => $research_title,
            'research_desc' => $research_desc,
            'research_url' => $research_url,
            'research_publish_date' => $research_published_date,
            'research_document' => $research_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_research');
        return $insert_id;
    }

    public function get_user_research($userid)
    {
        $this->db->select("*")->from("user_research");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_links($userid)
    {
        $this->db->select("*")->from("user_links");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_social_links($userid)
    {
        $this->db->select("*")->from("user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type != ','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_personal_links($userid)
    {
        $this->db->select("*")->from("user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_idols($userid)
    {
        $this->db->select("*")->from("user_idol");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_idol_data = $query->result_array();        
        return $user_idol_data;
    }

    public function set_user_publication($userid,$pub_title = "",$pub_author = "",$pub_url = "",$pub_publisher = "",$pub_desc = "",$publication_date = "",$pub_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'pub_title' => $pub_title,
            'pub_author' => $pub_author,
            'pub_url' => $pub_url,
            'pub_publisher' => $pub_publisher,
            'pub_desc' => $pub_desc,
            'pub_date' => $publication_date,
            'pub_file' => $pub_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_publication');
        return $insert_id;
    }

    public function get_user_publication($userid)
    {
        $this->db->select("*")->from("user_publication");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_patent($userid,$patent_title = "",$patent_creator = "",$patent_number = "",$patent_date = "",$patent_office = "",$patent_url = "",$patent_desc = "",$patent_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'patent_title' => $patent_title,
            'patent_creator' => $patent_creator,
            'patent_number' => $patent_number,
            'patent_date' => $patent_date,
            'patent_office' => $patent_office,
            'patent_url' => $patent_url,
            'patent_desc' => $patent_desc,
            'patent_file' => $patent_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_patent');
        return $insert_id;
    }

    public function get_user_patent($userid)
    {
        $this->db->select("*")->from("user_patent");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_award($userid,$award_title = "",$award_org = "",$award_date = "",$award_desc = "",$award_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'award_title' => $award_title,
            'award_org' => $award_org,
            'award_date' => $award_date,
            'award_desc' => $award_desc,
            'award_file' => $award_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_award');
        return $insert_id;
    }

    public function get_user_award($userid)
    {
        $this->db->select("*")->from("user_award");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_activity($userid,$activity_participate = "",$activity_org = "",$activity_start_date = "",$activity_end_date = "",$activity_desc = "",$activity_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'activity_participate' => $activity_participate,
            'activity_org' => $activity_org,
            'activity_start_date' => $activity_start_date,
            'activity_end_date' => $activity_end_date,
            'activity_desc' => $activity_desc,
            'activity_file' => $activity_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_extra_activity');
        return $insert_id;
    }

    public function get_user_activity($userid)
    {
        $this->db->select("*")->from("user_extra_activity");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_addicourse($userid,$addicourse_name = "",$addicourse_org = "",$addicourse_start_date = "",$addicourse_end_date = "",$addicourse_url = "",$addicourse_document = "")
    {
        $data = array(
            'user_id' => $userid,
            'addicourse_name' => $addicourse_name,
            'addicourse_org' => $addicourse_org,
            'addicourse_start_date' => $addicourse_start_date,
            'addicourse_end_date' => $addicourse_end_date,
            'addicourse_url' => $addicourse_url,
            'addicourse_file' => $addicourse_document,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_addicourse');
        return $insert_id;
    }

    public function get_user_addicourse($userid)
    {
        $this->db->select("*")->from("user_addicourse");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_experience($userid,$exp_company_name = "",$exp_designation = "",$exp_company_website = "",$exp_field = "",$exp_other_field = "",$exp_country = "",$exp_state = "",$exp_city = "",$exp_start_date = "",$exp_end_date = "",$exp_isworking = "",$exp_desc = "",$exp_file = "",$edit_exp = 0)
    {
        if($edit_exp == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'exp_company_name' => $exp_company_name,
                'exp_designation' => $exp_designation,
                'exp_company_website' => $exp_company_website,
                'exp_field' => $exp_field,
                'exp_other_field' => $exp_other_field,
                'exp_country' => $exp_country,                
                'exp_state' => $exp_state,                
                'exp_city' => $exp_city,                
                'exp_start_date' => $exp_start_date,                
                'exp_end_date' => $exp_end_date,                
                'exp_isworking' => $exp_isworking,                
                'exp_desc' => $exp_desc,                
                'exp_file' => $exp_file,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_experience');
            return $insert_id;
        }
        else
        {
            $data = array(
                'exp_company_name' => $exp_company_name,
                'exp_designation' => $exp_designation,
                'exp_company_website' => $exp_company_website,
                'exp_field' => $exp_field,
                'exp_other_field' => $exp_other_field,
                'exp_country' => $exp_country,                
                'exp_state' => $exp_state,                
                'exp_city' => $exp_city,                
                'exp_start_date' => $exp_start_date,                
                'exp_end_date' => $exp_end_date,                
                'exp_isworking' => $exp_isworking,                
                'exp_desc' => $exp_desc,                
                'exp_file' => $exp_file,                
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_experience', $edit_exp);
            $this->db->update('user_experience', $data);
            return true;
        }
    }

    public function get_user_experience($userid)
    {

        $this->db->select("ue.id_experience, ue.user_id, ue.exp_company_name, ue.exp_designation,GROUP_CONCAT(DISTINCT(jt.name)) as designation, ue.exp_company_website, ue.exp_field, ue.exp_other_field, ue.exp_country, ue.exp_state, ue.exp_city, ue.exp_start_date, ue.exp_end_date, DATE_FORMAT(CONCAT(ue.exp_start_date,'-1'),'%b %Y') as start_date_str,DATE_FORMAT(CONCAT(ue.exp_end_date,'-1'),'%b %Y') as end_date_str,ue.exp_isworking, ue.exp_desc, ue.exp_file, ue.status, ue.created_date, ue.modify_date,cr.country_name,st.state_name,ct.city_name")->from("user_experience ue, job_title jt");
        $this->db->join('countries cr', 'cr.country_id = ue.exp_country', 'left');
        $this->db->join('states st', 'st.state_id = ue.exp_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = ue.exp_city', 'left');
        // $this->db->join('job_title jt', 'jt.title_id = ue.exp_designation', 'left');
        $this->db->where('user_id', $userid);
        $this->db->where('FIND_IN_SET(jt.title_id, ue.exp_designation) !=', 0);
        $this->db->group_by('ue.exp_designation,ue.id_experience');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function set_user_project($userid,$project_title = "",$project_team = "",$project_role = "",$project_skill_ids = "",$project_field = "",$project_other_field = "",$project_url = "",$project_partner_name = "",$project_start_date = "",$project_end_date = "",$project_desc = "",$project_file = "")
    {
        $data = array(
            'user_id' => $userid,
            'project_title' => $project_title,
            'project_team' => $project_team,
            'project_role' => $project_role,
            'project_skills' => $project_skill_ids,
            'project_field' => $project_field,
            'project_other_field' => $project_other_field,                
            'project_url' => $project_url,                
            'project_partner_name' => $project_partner_name,                
            'project_start_date' => $project_start_date,                
            'project_end_date' => $project_end_date,                
            'project_desc' => $project_desc,        
            'project_file' => $project_file,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_projects');
        return $insert_id;
    }

    public function get_user_project($userid)
    {
        $this->db->select("*")->from("user_projects");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function set_user_education($userid,$edu_school_college = "",$edu_university = "",$edu_other_university = "",$edu_degree = "",$edu_stream = "",$edu_other_degree = "",$edu_other_stream = "",$edu_start_date = "",$edu_end_date = "",$edu_nograduate = "",$edu_file = "")
    {
        $data = array(
            'user_id' => $userid,
            'edu_school_college' => $edu_school_college,
            'edu_university' => $edu_university,
            'edu_other_university' => $edu_other_university,
            'edu_degree' => $edu_degree,
            'edu_other_degree' => $edu_other_degree,
            'edu_stream' => $edu_stream,                
            'edu_other_stream' => $edu_other_stream,                
            'edu_start_date' => $edu_start_date,                
            'edu_end_date' => $edu_end_date,                
            'edu_nograduate' => $edu_nograduate,    
            'edu_file' => $edu_file,                
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data($data, 'user_education');
        return $insert_id;
    }

    public function get_user_education($userid)
    {
        $this->db->select("*")->from("user_education");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }
}
