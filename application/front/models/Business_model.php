<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_model extends CI_Model {

    function businessCategory($limit = '') {
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug,industry_image')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function businessAllCategory($page = 0,$limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug,industry_image')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        if($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        $businessCategory = $query->result_array();   
        // echo $this->db->last_query();
        // exit;
        $result_array['bus_cat'] = $businessCategory;
        $result_array['total_record'] = $this->get_business_category_total_rec();
        return $result_array;
    }

    function get_business_category_total_rec() {
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();   
        return count($result_array);
    }

    function otherCategoryCount() {
        $this->db->select('count(bp.business_profile_id) as count')->from('business_profile bp');
        $this->db->where('bp.industriyal', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['count'];
    }

    function businessListByCategory($id = '0') {
        $this->db->select('bp.business_user_image,bp.profile_background,bp.other_industrial,bp.company_name,bp.country,bp.city,bp.details,bp.contact_website,it.industry_name,ct.city_name as city,cr.country_name as country, IF (bp.city != "",CONCAT(bp.business_slug, "-", ct.city_name),IF(st.state_name != "",CONCAT(bp.business_slug, "-", st.state_name),CONCAT(bp.business_slug, "-", cr.country_name))) as business_slug')->from('business_profile bp');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
        $this->db->join('states st', 'st.state_id = bp.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
        $this->db->where('bp.industriyal', $id);
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function isBusinessAvailable($id = '') {
        $this->db->select('count(*) as total')->from('business_profile bp');
        $this->db->where('bp.user_id', $id);
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function findBusinesCategory($keyword=''){
        $this->db->select('industry_id')->from('industry_type it');
        if ($keyword != '') {
            $this->db->where("(it.industry_name LIKE '%$keyword%')");
        }
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['industry_id'];
    }
    
    /*function searchBusinessData($keyword = '', $location = '') {
        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);
        
        $busCat = $this->findBusinesCategory($keyword);
        
        $this->db->select('bp.business_user_image,bp.profile_background,bp.business_slug,bp.other_industrial,bp.company_name,bp.country,bp.city,bp.details,bp.contact_website,it.industry_name,ct.city_name as city,cr.country_name as country')->from('business_profile bp');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
        $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
        $this->db->join('states s', 's.state_name = bp.state', 'left');
        if ($keyword != '' && $busCat == '') {
            $this->db->where("(bp.company_name LIKE '%$keyword%' OR bp.address LIKE '%$keyword%' OR bp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%')");
        }elseif ($keyword != '' && $busCat != '') {
            $this->db->where("(bp.company_name LIKE '%$keyword%' OR bp.address LIKE '%$keyword%' OR bp.contact_person LIKE '%$keyword%' OR bp.contact_mobile LIKE '%$keyword%' OR bp.details LIKE '%$keyword%' OR bp.business_slug LIKE '%$keyword%' OR bp.other_business_type LIKE '%$keyword%' OR bp.other_industrial LIKE '%$keyword%' OR bp.industriyal = '$busCat')");
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR s.state_name = '$location')");
        }
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $query = $this->db->get();
        $result_array = $query->result_array();
        echo $this->db->last_query();
        exit;
        return $result_array;
    }*/

    function searchBusinessData($keyword = '', $location = '',  $category_id = '',$location_id = '',$page = 0,$limit = '5') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
         // $keyword = str_replace('%20', ' ', $keyword);
        $keyword = urldecode($keyword);
        // $location = str_replace('%20', ' ', $location);
        $location = urldecode($location);
        $sqlkeyword = "";
        $sqllocation = "";
        $sqlfilter = "";
        $sqlcategoryfilter = "";
        $sqllocationfilter = "";
        
        // If Category search
        if($keyword != ""){
            $keyworddata = explode(',', $keyword);
            $sqlkeyword = " AND (";
            foreach($keyworddata as $key => $val){
                $val = $val.'%';
                $sqlkeyword .= ($key == 0) ? "" : " OR ";
                $sqlkeyword .= " (bp.company_name LIKE '". $val ."' OR bp.address LIKE '". $val ."' 
                OR bp.contact_person LIKE '". $val ."' OR bp.contact_mobile LIKE '". $val ."' 
                OR bp.details LIKE '". $val ."' OR bp.business_slug LIKE '". $val ."' 
                OR bp.other_business_type LIKE '". $val ."' OR bp.other_industrial LIKE '". $val ."' 
                OR bp.industry_name LIKE '". $val ."') ";
            }
        } 

        if($category_id != ""){
            $sqlcategoryfilter = ($sqlkeyword == "") ? " AND " : " OR ";
            $sqlcategoryfilter .= "bp.industriyal IN (". $category_id .")";
            $sqlcategoryfilter .= ($sqlkeyword != "") ? ")" : "";
        }
        else
        {
            $sqlcategoryfilter = ($sqlkeyword != "") ? ")" : "";
        }

        // IF LOCATION SEARCH
        if($location != ""){
            $locationdata = explode(',', $location);
            $sqllocation = " AND (";
            foreach($locationdata as $key => $val){
                $val = $val.'%';
                $sqllocation .= ($key == 0) ? "" : " OR ";
                $sqllocation .= " bp.city_name LIKE '". $val ."'
                    OR bp.country_name LIKE '". $val ."'
                    OR bp.state_name LIKE '". $val ."'";
            }
        }
        
        if($location_id != ""){
            $sqllocationfilter = ($sqllocation == "") ? " AND " : " OR ";
            $sqllocationfilter .= "bp.city IN (". $location_id .")";  
            $sqllocationfilter .= ($sqllocation != "") ? ")" : ""; 
        }
        else
        {
            $sqllocationfilter = ($sqllocation != "") ? ")" : ""; 
        }


        $tot_sql = $sql = "SELECT bp.business_user_image, bp.profile_background, bp.other_industrial, bp.company_name, bp.country, bp.details, bp.contact_website, bp.industry_name, bp.city_name AS city, bp.country_name AS country, IF (bp.city != '',CONCAT(bp.business_slug, '-', bp.city_name),IF(bp.state_name != '',CONCAT(bp.business_slug, '-', bp.state_name),CONCAT(bp.business_slug, '-', bp.country_name))) AS business_slug ,bp.other_city
            FROM ailee_business_profile_search_tmp bp                 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4'"
            . $sqlkeyword .$sqlcategoryfilter . $sqllocation . $sqllocationfilter;


        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();

        $query2 = $this->db->query($tot_sql);
        $total_record = $query2->num_rows();
        
        $ret_arr = array("seach_business"=>$result_array,"total_record"=>$total_record);
        return $ret_arr;
    }

    function business_followers($follow_to = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('ul.*,f.*,bp.business_profile_id,bp.company_name,bp.country,bp.state,bp.city,bp.pincode,bp.address,bp.contact_person,bp.contact_mobile,bp.contact_email,bp.contact_website,bp.business_type,bp.industriyal,bp.details,bp.addmore,bp.user_id,bp.status,bp.is_deleted,bp.created_date,bp.modified_date,bp.business_step,bp.business_user_image,bp.profile_background,bp.profile_background_main,bp.business_slug,bp.other_business_type,bp.other_industrial,ct.city_name,st.state_name,IF (bp.city != "",CONCAT(bp.business_slug, "-", ct.city_name),IF(st.state_name != "",CONCAT(bp.business_slug, "-", st.state_name),CONCAT(bp.business_slug, "-", cr.country_name))) as business_slug')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_from = bp.business_profile_id');
        $this->db->join('cities ct', 'ct.city_id = bp.city');
        $this->db->join('countries cr', 'cr.country_id = bp.country');
        $this->db->join('states st', 'st.state_id = bp.state');
        $this->db->where('f.follow_to', $follow_to);
        $this->db->where('f.follow_status', '1');
        $this->db->where('f.follow_type', '2');
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_following($follow_from = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('ul.*,f.*,bp.business_profile_id,bp.company_name,bp.country,bp.state,bp.city,bp.pincode,bp.address,bp.contact_person,bp.contact_mobile,bp.contact_email,bp.contact_website,bp.business_type,bp.industriyal,bp.details,bp.addmore,bp.user_id,bp.status,bp.is_deleted,bp.created_date,bp.modified_date,bp.business_step,bp.business_user_image,bp.profile_background,bp.profile_background_main,bp.business_slug,bp.other_business_type,bp.other_industrial,ct.city_name,st.state_name,IF (bp.city != "",CONCAT(bp.business_slug, "-", ct.city_name),IF(st.state_name != "",CONCAT(bp.business_slug, "-", st.state_name),CONCAT(bp.business_slug, "-", cr.country_name))) as business_slug')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_to = bp.business_profile_id');
        $this->db->join('cities ct', 'ct.city_id = bp.city');
        $this->db->join('countries cr', 'cr.country_id = bp.country');
        $this->db->join('states st', 'st.state_id = bp.state');
        $this->db->where('f.follow_from', $follow_from);
        $this->db->where('f.follow_status', '1');
        $this->db->where('f.follow_type', '2');
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_userlist($user_id = '', $sortby = '', $orderby = '', $limit = '', $offset = '', $category_id = '', $location_id = '') {
       /* $this->db->select('ul.*,bp.business_profile_id,bp.company_name,bp.country,bp.state,bp.city,bp.pincode,bp.address,bp.contact_person,bp.contact_mobile,bp.contact_email,bp.contact_website,bp.business_type,bp.industriyal,bp.details,bp.addmore,bp.user_id,bp.status,bp.is_deleted,bp.created_date,bp.modified_date,bp.business_step,bp.business_user_image,bp.profile_background,bp.profile_background_main,bp.business_slug,bp.other_business_type,bp.other_industrial,ct.city_name,st.state_name,IF (bp.city IS NULL, concat(bp.business_slug, "-", st.state_name) ,concat(bp.business_slug, "-", ct.city_name)) as business_slug')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal');
        $this->db->join('ailee_cities ct', 'ct.city_id = bp.city');
        $this->db->join('ailee_states st', 'st.state_id = bp.state');
        $this->db->where('bp.user_id !=', $user_id);
        $this->db->where('bp.business_step', '4');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('ul.status', '1');
        $this->db->where('ul.is_delete', '0');*/

        $sql = "SELECT ul.*, bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug
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
        if($location_id != ""){
            $sql .= " AND ct.city_id IN (". $location_id .")";
        }
        if($category_id != ""){
            $sql .= " AND bp.industriyal IN (". $category_id .")";
        }
        if ($orderby != '') {
            $sql .= " ORDER BY ". $sortby . " " .$orderby;
        }
        if ($limit != '') {
            $sql .= " Limit ". $offset . "," . $limit;
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessPostComment($post_id = '', $sortby = '', $orderby = '', $limit = '') {
        $this->db->select('bppc.*,bp.company_name,business_user_image,IF (bp.city IS NULL, concat(bp.business_slug, "-", st.state_name) ,concat(bp.business_slug, "-", ct.city_name)) as business_slug')->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->join('business_profile bp', 'bp.user_id = bppc.user_id');
        $this->db->join('cities ct', 'bp.city = ct.city_id');
        $this->db->join('states st', 'bp.state = st.state_id');
        $this->db->where('business_profile_post_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessLikeComment($post_id = '') {
        $this->db->select('bppc.*')->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->where('business_profile_post_comment_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessCommentData($post_id = '', $select_data = '') {
        $this->db->select($select_data)->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
        $this->db->where('business_profile_post_comment_id', $post_id);
        $this->db->where('bppc.status', '1');
        $this->db->where('bppc.is_delete', '0');
        $this->db->where('ul.is_delete', '0');
        $this->db->where('ul.status', '1');
        if ($orderby != '') {
            $this->db->order_by($sortby, $orderby);
        }
        if ($limit != '') {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getBusinessDataBySlug($business_slug = '', $select_data = '*') {
        $this->db->select($select_data)->from('business_profile');
        $this->db->where("business_slug='$business_slug'");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getBusinessTypeName($business_type = '') {
        $business_name = $this->db->select('business_name')->get_where('business_type', array('type_id' => $business_type, 'status' => '1', 'is_delete' => '0'))->row('business_name');
        return $business_name;
    }

    function getIndustriyalName($industriyal = '') {
        $industriyal_name = $this->db->select('industry_name')->get_where('industry_type', array('industry_id' => $industriyal, 'status' => '1', 'is_delete' => '0'))->row('industry_name');
        return $industriyal_name;
    }

    function get_business_home_post($business_profile_id,$city,$user_id,$industriyal,$other_industrial,$login_userid,$page = "",$limit = '4')
    {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $sql = "SELECT (SELECT city_name FROM aileensoul.ailee_cities where city_id = ailee_business_profile.city) as city_name,(SELECT state_name FROM aileensoul.ailee_states where state_id = ailee_business_profile.state) as state_name,ailee_business_profile.business_user_image, ailee_business_profile.company_name, ailee_business_profile.industriyal, ailee_business_profile.business_slug, ailee_business_profile.other_industrial, ailee_business_profile.business_slug, ailee_business_profile_post.business_profile_post_id, ailee_business_profile_post.product_name, ailee_business_profile_post.product_description, ailee_business_profile_post.business_likes_count, ailee_business_profile_post.business_like_user, ailee_business_profile_post.created_date, ailee_business_profile_post.posted_user_id, ailee_business_profile.user_id 
            FROM ailee_business_profile_post 
            JOIN ailee_business_profile ON ailee_business_profile.user_id=ailee_business_profile_post.user_id 
            JOIN ailee_user_login ON ailee_user_login.user_id=ailee_business_profile.user_id 
            WHERE ailee_business_profile_post.is_delete = '0' 
            AND ailee_business_profile_post.user_id != $login_userid
            AND ailee_business_profile_post.status = '1' 
            AND ailee_user_login.is_delete = '0' 
            AND ailee_user_login.status = '1' 
            AND (business_profile_post_id NOT IN ( SELECT business_profile_post_id FROM ailee_business_profile_post WHERE ailee_business_profile_post.is_delete = '0' AND ailee_business_profile_post.status = '1' AND FIND_IN_SET ('".$user_id."', delete_post) != '0')
            OR (
            ailee_business_profile_post.user_id IN (SELECT user_id FROM ailee_follow JOIN ailee_business_profile ON ailee_business_profile.business_profile_id=ailee_follow.follow_to WHERE follow_from = '".$business_profile_id."' AND follow_status = '1' AND follow_type = '2') OR 
            ailee_business_profile_post.user_id IN (SELECT user_id FROM ailee_business_profile WHERE ailee_business_profile.is_deleted = '0' AND ailee_business_profile.status = '1' AND ailee_business_profile.business_step = '4' AND (ailee_business_profile.industriyal = '".$industriyal."' AND ailee_business_profile.industriyal !=0) AND (ailee_business_profile.other_industrial = '".$other_industrial."' AND ailee_business_profile.other_industrial != '') OR (ailee_business_profile.city = '".$city."' AND ailee_business_profile.industriyal = '$industriyal'))
                ))
            ORDER BY business_profile_post_id DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;
        // exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_home_post_total_rec($business_profile_id,$city,$user_id,$industriyal,$other_industrial,$login_userid)
    {
        $sql = "SELECT count(*) as total_record
            FROM ailee_business_profile_post 
            JOIN ailee_business_profile ON ailee_business_profile.user_id=ailee_business_profile_post.user_id 
            JOIN ailee_user_login ON ailee_user_login.user_id=ailee_business_profile.user_id 
            WHERE ailee_business_profile_post.is_delete = '0' 
            AND ailee_business_profile_post.user_id != $login_userid
            AND ailee_business_profile_post.status = '1' 
            AND ailee_user_login.is_delete = '0' 
            AND ailee_user_login.status = '1' 
            AND (business_profile_post_id NOT IN ( SELECT business_profile_post_id FROM ailee_business_profile_post WHERE ailee_business_profile_post.is_delete = '0' AND ailee_business_profile_post.status = '1' AND FIND_IN_SET ('".$user_id."', delete_post) != '0')
            OR (
            ailee_business_profile_post.user_id IN (SELECT user_id FROM ailee_follow JOIN ailee_business_profile ON ailee_business_profile.business_profile_id=ailee_follow.follow_to WHERE follow_from = '".$business_profile_id."' AND follow_status = '1' AND follow_type = '2') OR 
            ailee_business_profile_post.user_id IN (SELECT user_id FROM ailee_business_profile WHERE ailee_business_profile.is_deleted = '0' AND ailee_business_profile.status = '1' AND ailee_business_profile.business_step = '4' AND (ailee_business_profile.industriyal = '".$industriyal."' AND ailee_business_profile.industriyal !=0) AND (ailee_business_profile.other_industrial = '".$other_industrial."' AND ailee_business_profile.other_industrial != '') OR (ailee_business_profile.city = '".$city."' AND ailee_business_profile.industriyal = '$industriyal'))
                ))
            ORDER BY business_profile_post_id DESC";        
        $query = $this->db->query($sql);
        $result_array = $query->row()->total_record;
        return $result_array;        
    }

    // Get city id form city name
    function getlocationdatafromname($location = ''){
        $sql = "SELECT group_concat(city_id) as city_id FROM `ailee_cities` WHERE `city_name` = '". $location ."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    // Get city id form slug
    function getlocationdatafromslug($location = ''){
        $sql = "SELECT group_concat(city_id) as city_id,city_name FROM `ailee_cities` WHERE `slug` = '". $location ."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    // Get all location of business
    function businessLocation($limit = '') {
        $sql = "SELECT count(bp.business_profile_id) as count, ac.city_id, ac.city_name, ac.slug,ac.city_image
                FROM ailee_cities ac 
                LEFT JOIN ailee_business_profile bp ON bp.city = ac.city_id
                WHERE ac.status = '1' AND bp.status = '1' AND bp.is_deleted = '0' 
                AND bp.business_step = '4' 
                GROUP BY bp.city 
                ORDER BY count DESC"; 

        if($limit != ''){
            $sql .= " LIMIT ". $limit;
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    // Get all location of business
    function businessAllLocation($page = 0,$limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $sql = "SELECT count(bp.business_profile_id) as count, ac.city_id, ac.city_name, ac.slug,ac.city_image
                FROM ailee_cities ac 
                LEFT JOIN ailee_business_profile bp ON bp.city = ac.city_id
                WHERE ac.status = '1' AND bp.status = '1' AND bp.is_deleted = '0' 
                AND bp.business_step = '4' 
                GROUP BY bp.city 
                ORDER BY count DESC"; 

        if($limit != ''){
            $sql .= " LIMIT ". $start . "," . $limit;
        }
        $query = $this->db->query($sql);
        $businessLocation = $query->result_array();   
        $result_array['bus_loc'] = $businessLocation;
        $result_array['total_record'] = $this->get_business_location_total_rec();

        return $result_array;
    }

    function get_business_location_total_rec(){
        $sql = "SELECT count(bp.business_profile_id) as count, ac.city_id, ac.city_name, ac.slug 
                FROM ailee_cities ac 
                LEFT JOIN ailee_business_profile bp ON bp.city = ac.city_id
                WHERE ac.status = '1' AND bp.status = '1' AND bp.is_deleted = '0' 
                AND bp.business_step = '4' 
                GROUP BY bp.city 
                ORDER BY count DESC"; 

        if($limit != ''){
            $sql .= " LIMIT ". $start . "," . $limit;
        }
        $query = $this->db->query($sql);
        $businessLocation = $query->result_array(); 
        return count($businessLocation);  
    }

    // Get Location List based on city id
    function businessListByLocation($id = '0',$page = "",$limit = '',$industry_name = array(),$city_name = array()) {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $sql = "SELECT bp.business_user_image, bp.profile_background, bp.other_industrial, 
        IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,
            bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, ct.city_name as city, 
            cr.country_name as country 
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4' ";

        if(isset($industry_name) && !empty($industry_name))
        {
            $sql .= "AND bp.industriyal IN (". implode(",", $industry_name) .")";
        }
        
        if($id != ''){
            $sql .= " AND (bp.city IN(". $id .")";
            if(isset($city_name) && !empty($city_name))
            {
                $sql .= " OR bp.industriyal IN (". implode(",", $city_name) .")";
            }
            $sql .= ")";
        }

        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function businessListByLocationTotalRec($id = '0',$industry_name = array(),$city_name = array()) {
        $sql = "SELECT bp.business_user_image, bp.profile_background, bp.other_industrial, 
        IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,
            bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, ct.city_name as city, 
            cr.country_name as country 
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4' ";
        if(isset($industry_name) && !empty($industry_name))
        {
            $sql .= "AND bp.industriyal IN (". implode(",", $industry_name) .")";
        }
        
        if($id != ''){
            $sql .= " AND (bp.city IN(".$id.")";
            if(isset($city_name) && !empty($city_name))
            {
                $sql .= " OR bp.industriyal IN (". implode(",", $city_name) .")";
            }
            $sql .= ")";
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return count($result_array);
    }

    // Get Location List based on city id
    function businessListByFilter($category_id = '', $location_id = '', $page = "",$limit = '',$industry_name = array(),$city_name = array()) {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "SELECT bp.business_user_image, bp.profile_background,IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug, bp.other_industrial, bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, ct.city_name as city, cr.country_name as country ,bp.other_city
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_states st ON st.state_id = bp.state 
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4'";

            if($category_id != ''){
                $sql .= " AND (bp.industriyal IN (". $category_id .")";
                if(isset($industry_name) && !empty($industry_name))
                {
                    $sql .= " OR bp.industriyal IN (". implode(",", $industry_name) .")";
                }
                $sql .= ")";
            }   
            
            if($location_id != ''){
                $sql .= " AND (bp.city IN (". $location_id .")";
                if(isset($city_name) && !empty($city_name))
                {
                    $sql .= " OR bp.industriyal IN (". implode(",", $city_name) .")";
                }
                $sql .= ")";
            }
            if($limit != '') {
                $sql .= " LIMIT $start,$limit";
            }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function businessListByFilterTotalRec($category_id = '', $location_id = '',$industry_name = array(),$city_name = array()) {        

        $sql = "SELECT bp.business_user_image, bp.profile_background,IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug, bp.other_industrial, bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, 
            ct.city_name as city, 
            cr.country_name as country 
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_states st ON st.state_id = bp.state 
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4'";

            if($category_id != ''){
                $sql .= " AND (bp.industriyal IN (". $category_id .")";
                if(isset($industry_name) && !empty($industry_name))
                {
                    $sql .= " OR bp.industriyal IN (". implode(",", $industry_name) .")";
                }
                $sql .= ")";
            }   
            
            if($location_id != ''){
                $sql .= " AND (bp.city IN (". $location_id .")";
                if(isset($city_name) && !empty($city_name))
                {
                    $sql .= " OR bp.industriyal IN (". implode(",", $city_name) .")";
                }
                $sql .= ")";
            }            
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return count($result_array);
    }
    
    public function business_user_following_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_from' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_to';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_ing_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as following_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $following_count = $bus_user_f_ing_count[0]['following_count'];

        return $following_count;
    }

    // BUSIENSS PROFILE USER FOLLOWING COUNT END
    // BUSIENSS PROFILE USER FOLLOWER COUNT START

    public function business_user_follower_count($business_profile_id = '') {
        /*$s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id == '') {
            $business_profile_id = $this->db->get_where('business_profile', array('user_id' => $userid, 'status' => '1'))->row()->business_profile_id;
        }

        $contition_array = array('follow_to' => $business_profile_id, 'follow_status' => '1', 'follow_type' => '2', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');

        $join_str_following[0]['table'] = 'follow';
        $join_str_following[0]['join_table_id'] = 'follow.follow_from';
        $join_str_following[0]['from_table_id'] = 'business_profile.business_profile_id';
        $join_str_following[0]['join_type'] = '';

        $bus_user_f_er_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'count(*) as follower_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_following, $groupby = '');

        $follower_count = $bus_user_f_er_count[0]['follower_count'];*/
        $where = "((uf.follow_to = '" . $business_profile_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where('uf.follow_type', '2');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['total'];
    }

    // BUSIENSS PROFILE USER FOLLOWER COUNT END
    // 
    public function business_user_contacts_count($business_profile_id = '') {
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        if ($business_profile_id != '') {
            $userid = $this->db->get_where('business_profile', array('business_profile_id' => $business_profile_id, 'status' => '1'))->row()->user_id;
        }

        $contition_array = array('contact_type' => '2', 'contact_person.status' => 'confirm', 'business_profile.status' => '1', 'business_profile.is_deleted' => '0');
        $search_condition = "((contact_from_id = ' $userid') OR (contact_to_id = '$userid'))";

        $join_str_contact[0]['table'] = 'business_profile';
        $join_str_contact[0]['join_table_id'] = 'business_profile.user_id';
        $join_str_contact[0]['from_table_id'] = 'contact_person.contact_from_id';
        $join_str_contact[0]['join_type'] = '';

        $contacts_count = $this->common->select_data_by_search('contact_person', $search_condition, $contition_array, $data = 'count(*) as contact_count', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str_contact, $groupby = '');
        $contacts_count = $contacts_count[0]['contact_count'];

        return $contacts_count;
    }

    public function removelocationfromslug($slug){
        $business_slugdata = explode('-', $slug);
        array_pop($business_slugdata);
        $slug = implode('-', $business_slugdata);
        return $slug;
    }

    function get_business_by_categories($page = 0,$limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug')->from('industry_type it');
        $this->db->join('business_profile bp', 'bp.industriyal = it.industry_id', 'left');
        $this->db->where('it.status', '1');
        $this->db->where('it.is_delete', '0');
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.industriyal');
        $this->db->order_by('count', 'desc');
        if($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        $businessCat = $query->result_array();   
        
        foreach ($businessCat as $k => $v) {
            if(!file_exists(JOB_INDUSTRY_IMG_PATH."/".$businessCat[$k]['industry_image']))
            {
                $businessCat[$k]['industry_image'] = "job_industry_image_default.png";
            }
        }
        $result_array['job_cat'] = $businessCat;
        $result_array['total_record'] = $this->get_business_category_total_rec();

        return $result_array;
    }


    function business_related_blog_list() {
        $sql = "SELECT * FROM ailee_blog
                WHERE status = 'publish' AND
                blog_slug = 'how-to-build-a-startup-from-scratch' 
                OR blog_slug = '10-prerequisites-to-be-a-successful-entrepreneur-amid-cut-throat-competition' 
                OR blog_slug = 'top-10-free-business-listing-websites-to-improve-brand-awareness-outreach'";

        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    function get_bussiness_from_user_id($user_id)
    {
        $sql = "SELECT *,IF(bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) AS business_slug,it.industry_name FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it on it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct on bp.city = ct.city_id
            LEFT JOIN ailee_states st on bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND user_id = '". $user_id ."'";
            $query = $this->db->query($sql);
            $posted_business_slug = $query->row();
            return $posted_business_slug;
    }

    function business_create_search_table()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * from ailee_business_profile WHERE status = '1' AND is_deleted = '0' AND business_step = '4'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();        
        // print_r($result_array);exit;
        foreach ($result_array as $key => $value) {            
            
            if(trim($value['industriyal']) != "")
            {
                $industriyal = $this->db->get_where('industry_type', array('industry_id' => $value['industriyal'], 'status' => '1'))->row()->industry_name;

                $value['industry_name'] = trim($industriyal);
            }

            if(trim($value['country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $value['country'], 'status' => '1'))->row()->country_name;

                $value['country_name'] = trim($country_name);
            }

            if(trim($value['state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $value['state'], 'status' => '1'))->row()->state_name;

                $value['state_name'] = trim($state_name);
            }

            if(trim($value['city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $value['city'], 'status' => '1'))->row()->city_name;

                $value['city_name'] = trim($city_name);
            }
            $this->db->insert('ailee_business_profile_search_tmp', $value);
        }
        echo "Done";
    }

    public function get_user_links($userid)
    {
        $this->db->select("*")->from("business_user_links");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_social_links($userid)
    {
        $this->db->select("*")->from("business_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type != ','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_personal_links($userid)
    {
        $this->db->select("*")->from("business_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function set_user_award($userid,$award_title = "",$award_org = "",$award_date = "",$award_desc = "",$award_document = "",$edit_awards = 0)
    {
        if($edit_awards == 0)
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
            $insert_id = $this->common->insert_data($data, 'business_user_award');
            return $insert_id;
        }
        else
        {
            $data = array(
                'award_title' => $award_title,
                'award_org' => $award_org,
                'award_date' => $award_date,
                'award_desc' => $award_desc,
                'award_file' => $award_document,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_award', $edit_awards);
            $this->db->update('business_user_award', $data);
            return true;
        }
    }

    public function delete_user_award($userid,$award_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_award', $award_id);
            $this->db->update('business_user_award', $data);
            return true;
    }

    public function get_user_award($userid)
    {
        $this->db->select("ua.*,DATE_FORMAT(ua.award_date,'%d %b %Y') as award_date_str")->from("business_user_award ua");
        $this->db->where('ua.user_id', $userid);
        $this->db->where('ua.status', '1');
        $this->db->order_by('ua.created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_press_release($userid)
    {
        $this->db->select("*")->from("business_user_news_press_release");
        $this->db->where('user_id', $userid);
        $this->db->where('status', '1');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function save_press_release($user_id,$press_rel_title = "",$press_rel_link = "",$edit_press_release = 0)
    {
        if($edit_press_release == 0)
        {
            $data = array(
                'user_id' => $user_id,
                'news_press_release_title' => $press_rel_title,
                'news_press_release_link' => $press_rel_link,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'business_user_news_press_release');
            return $insert_id;
        }
        else
        {
            $data = array(
                'news_press_release_title' => $press_rel_title,
                'news_press_release_link' => $press_rel_link,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $user_id);
            $this->db->where('id_news_press_release', $edit_press_release);
            $this->db->update('business_user_news_press_release', $data);
            return true;
        }
    }

    public function delete_press_release($user_id,$edit_press_release_id)    
    {
        $data = array(                
            'status' => "0",
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('id_news_press_release', $edit_press_release_id);
        $this->db->update('business_user_news_press_release', $data);
        return true;
    }

    public function save_portfolio($userid,$portfolio_title = "",$portfolio_desc = "",$portfolio_file = "",$edit_portfolio_id = 0)
    {
        if($edit_portfolio_id == 0)
        {
            $data = array(
                'user_id' => $userid,
                'portfolio_title' => $portfolio_title,
                'portfolio_desc' => $portfolio_desc,                
                'portfolio_file' => $portfolio_file,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'business_user_portfolio');
            return $insert_id;
        }
        else
        {
            $data = array(
                'portfolio_title' => $portfolio_title,
                'portfolio_desc' => $portfolio_desc,                
                'portfolio_file' => $portfolio_file,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_portfolio', $edit_portfolio_id);
            $this->db->update('business_user_portfolio', $data);
            return true;
        }
    }

    public function delete_portfolio($userid,$edit_portfolio_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_portfolio', $edit_portfolio_id);
            $this->db->update('business_user_portfolio', $data);
            return true;
    }

    public function get_portfolio($userid)
    {
        $this->db->select("*")->from("business_user_portfolio");
        $this->db->where('user_id', $userid);
        $this->db->where('status', '1');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_save_review($to_user_id)
    {
        // $this->db->select("bp.company_name,bp.business_user_image as user_image,br.*")->from('business_review br');
        $this->db->select("u.user_id,u.first_name, u.last_name, u.user_slug, u.user_gender, ui.user_image,br.*")->from('business_review br');
        $this->db->join('user u', 'u.user_id = br.from_user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->where('br.to_user_id', $to_user_id);
        $this->db->where('br.status', '1');
        $this->db->where("ul.status","1");
        $this->db->where("ul.is_delete","0");
        $this->db->order_by('br.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_review_avarage($to_user_id)
    {
        $this->db->select("br.review_star,count(br.from_user_id) as rating_count")->from('business_review br');
        $this->db->join('user_login ul', 'ul.user_id = br.from_user_id', 'left');
        $this->db->where('br.to_user_id', $to_user_id);
        $this->db->where('br.status', '1');
        $this->db->where("ul.status","1");
        $this->db->where("ul.is_delete","0");
        $this->db->group_by('br.review_star');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_review_count($to_user_id)
    {
        $this->db->select("COUNT(*) total_review")->from('business_review br');
        $this->db->join('user_login ul', 'ul.user_id = br.from_user_id', 'left');
        $this->db->where('br.to_user_id', $to_user_id);
        $this->db->where('br.status', '1');
        $this->db->where("ul.status","1");
        $this->db->where("ul.is_delete","0");
        /*$this->db->join('business_profile bp', 'bp.user_id = br.from_user_id', 'left');
        $this->db->where('br.to_user_id', $to_user_id);
        $this->db->where('br.status', '1');*/
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function set_save_review($from_user_id,$to_user_id,$review_star,$review_desc ='',$fileName = '')
    {
        $data = array(
            'to_user_id' => $to_user_id,
            'from_user_id' => $from_user_id,
            'review_star' => $review_star,
            'review_desc' => $review_desc,
            'review_file' => $fileName,    
            'status' => '1',
            'created_date' => date('Y-m-d H:i:s', time()),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $insert_id = $this->common->insert_data_getid($data, 'business_review');
        return $insert_id;
    }

    public function get_business_story($user_id)
    {
        $this->db->select("*")->from('business_user_how_start');        
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->row_array();        
        return $result_array;
    }

    public function get_business_timeline($user_id)
    {
        $this->db->select("timeline_date,DATE_FORMAT(timeline_date,'%e/%c/%Y') as timeline_date_a,DATE_FORMAT(timeline_date,'%e %b') as timeline_date_li")->from('business_user_timeline');       
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->group_by('timeline_date');
        $this->db->order_by('timeline_date');
        $query = $this->db->get();
        $result_datewise = $query->result_array();
        foreach ($result_datewise as $key => $value) {            
            $this->db->select("*,DATE_FORMAT(timeline_date,'%e/%c/%Y') as timeline_date_a,DATE_FORMAT(timeline_date,'%e %b') as timeline_date_li,DATE_FORMAT(timeline_date,'%D %M, %Y') as timeline_date_str")->from('business_user_timeline');       
            $this->db->where('timeline_date', $value['timeline_date']);
            $this->db->where('user_id', $user_id);
            $this->db->where('status', '1');
            $qur = $this->db->get();
            $result_array = $qur->result_array();            
            $result_datewise[$key]['timeline_inner_data'] = $result_array;
        }
        return $result_datewise;
    }

    public function save_timeline($user_id,$timeline_title = "",$timeline_desc = "",$timeline_date = "",$timeline_file = "",$edit_timeline_id = 0)
    {
        if($edit_timeline_id == 0)
        {
            $data = array(
                'user_id' => $user_id,
                'timeline_title' => $timeline_title,
                'timeline_desc' => $timeline_desc,                
                'timeline_file' => $timeline_file,                
                'timeline_date' => $timeline_date,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'business_user_timeline');
            return $insert_id;
        }
        else
        {
            $data = array(
                'timeline_title' => $timeline_title,
                'timeline_desc' => $timeline_desc,                
                'timeline_file' => $timeline_file,
                'timeline_date' => $timeline_date,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $user_id);
            $this->db->where('id_timeline', $edit_timeline_id);
            $this->db->update('business_user_timeline', $data);
            return true;
        }
    }

    public function delete_timeline($userid,$edit_timeline_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_timeline', $edit_timeline_id);
            $this->db->update('business_user_timeline', $data);
            return true;
    }

    public function get_business_job_opening($company_name)
    {
        $this->db->select("rp.*, IFNULL(jt.name, rp.post_name) as post_name_txt,IF(rp.city>0,ct.city_name,IF(rp.state>0,st.state_name,IF(rp.country>0,cr.country_name,''))) as slug_city, ct.city_name, cr.country_name,st.state_name")->from('rec_post rp');
        $this->db->join('job_title jt', 'jt.title_id = rp.post_name', 'left');
        $this->db->join('cities ct', 'ct.city_id = rp.city', 'left');
        $this->db->join('states st', 'st.state_id = rp.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = rp.country', 'left');
        $this->db->where('TRIM(LOWER(rp.comp_name))', trim(strtolower($company_name)));
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->order_by('rp.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();        
        return $result_array;
    }

    public function check_recruiter_profile($user_id)
    {
        $this->db->select("*")->from('recruiter');        
        $this->db->where('user_id', $user_id);
        $this->db->where('re_status', '1');
        $this->db->where('is_delete', '0');        
        $this->db->where('re_step', '3');        
        $query = $this->db->get();
        $result_array = $query->row_array();        
        return $result_array;
    }

    public function save_opening_hours($user_id,$opening_hour = '', $sunday_time = '', $monday_time = '', $tuesday_time = '', $wednesday_time = '', $thursday_time = '', $friday_time = '', $saturday_time = '')
    {
        $cur_datetime = date('Y-m-d H:i:s', time());
        $this->db->select("*")->from('business_opening_hours');        
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');        
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data_array = array(
                'opening_hour' => $opening_hour,
                'sunday_time' => $sunday_time,
                'monday_time' => $monday_time,
                'tuesday_time' => $tuesday_time,
                'wednesday_time' => $wednesday_time,
                'thursday_time' => $thursday_time,
                'friday_time' => $friday_time,
                'saturday_time' => $saturday_time,
                'modify_date' => $cur_datetime
            );
            
            $this->db->where('user_id', $user_id);            
            $this->db->update('business_opening_hours', $data_array);
            return true;
        }
        else
        {
            $data_array = array(
                'user_id' => $user_id,
                'opening_hour' => $opening_hour,
                'sunday_time' => $sunday_time,
                'monday_time' => $monday_time,
                'tuesday_time' => $tuesday_time,
                'wednesday_time' => $wednesday_time,
                'thursday_time' => $thursday_time,
                'friday_time' => $friday_time,
                'saturday_time' => $saturday_time,
                'status' => '1',
                'created_date' => $cur_datetime,
                'modify_date' => $cur_datetime
            );
            $insert_id = $this->common->insert_data($data_array, 'business_opening_hours');
            return $insert_id;   
        }
    }

    public function get_opening_hours($user_id)
    {
        $this->db->select("*")->from('business_opening_hours');        
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->row_array();
        if(isset($result_array) && !empty($result_array))
        {
            $sunday_array = explode("to", $result_array['sunday_time']);
            $sun_from_time_arr = explode("-", $sunday_array[0]);
            $result_array['sun_from_time'] = $sun_from_time_arr[0];
            $result_array['sun_from_ap'] = $sun_from_time_arr[1];
            $sun_to_time_arr = explode("-", $sunday_array[1]);
            $result_array['sun_to_time'] = $sun_to_time_arr[0];
            $result_array['sun_to_ap'] = $sun_to_time_arr[1];

            $monday_array = explode("to", $result_array['monday_time']);
            $mon_from_time_arr = explode("-", $monday_array[0]);
            $result_array['mon_from_time'] = $mon_from_time_arr[0];
            $result_array['mon_from_ap'] = $mon_from_time_arr[1];
            $mon_to_time_arr = explode("-", $monday_array[1]);
            $result_array['mon_to_time'] = $mon_to_time_arr[0];
            $result_array['mon_to_ap'] = $mon_to_time_arr[1];

            $tuesday_array = explode("to", $result_array['tuesday_time']);
            $tue_from_time_arr = explode("-", $tuesday_array[0]);
            $result_array['tue_from_time'] = $tue_from_time_arr[0];
            $result_array['tue_from_ap'] = $tue_from_time_arr[1];
            $tue_to_time_arr = explode("-", $tuesday_array[1]);
            $result_array['tue_to_time'] = $tue_to_time_arr[0];
            $result_array['tue_to_ap'] = $tue_to_time_arr[1];

            $wednesday_array = explode("to", $result_array['wednesday_time']);
            $wed_from_time_arr = explode("-", $wednesday_array[0]);
            $result_array['wed_from_time'] = $wed_from_time_arr[0];
            $result_array['wed_from_ap'] = $wed_from_time_arr[1];
            $wed_to_time_arr = explode("-", $wednesday_array[1]);
            $result_array['wed_to_time'] = $wed_to_time_arr[0];
            $result_array['wed_to_ap'] = $wed_to_time_arr[1];

            $thursday_array = explode("to", $result_array['thursday_time']);
            $thu_from_time_arr = explode("-", $thursday_array[0]);
            $result_array['thu_from_time'] = $thu_from_time_arr[0];
            $result_array['thu_from_ap'] = $thu_from_time_arr[1];
            $thu_to_time_arr = explode("-", $thursday_array[1]);
            $result_array['thu_to_time'] = $thu_to_time_arr[0];
            $result_array['thu_to_ap'] = $thu_to_time_arr[1];

            $friday_array = explode("to", $result_array['friday_time']);
            $fri_from_time_arr = explode("-", $friday_array[0]);
            $result_array['fri_from_time'] = $fri_from_time_arr[0];
            $result_array['fri_from_ap'] = $fri_from_time_arr[1];
            $fri_to_time_arr = explode("-", $friday_array[1]);
            $result_array['fri_to_time'] = $fri_to_time_arr[0];
            $result_array['fri_to_ap'] = $fri_to_time_arr[1];

            $saturday_array = explode("to", $result_array['saturday_time']);
            $sat_from_time_arr = explode("-", $saturday_array[0]);
            $result_array['sat_from_time'] = $sat_from_time_arr[0];
            $result_array['sat_from_ap'] = $sat_from_time_arr[1];
            $sat_to_time_arr = explode("-", $saturday_array[1]);
            $result_array['sat_to_time'] = $sat_to_time_arr[0];
            $result_array['sat_to_ap'] = $sat_to_time_arr[1];
        }
        return $result_array;
    }

    public function get_key_member($user_id)
    {
        $this->db->select("bk.*, jt.name as member_job_title_txt")->from('business_key_member bk');
        $this->db->join('job_title jt', 'jt.title_id = bk.member_job_title', 'left');
        $this->db->where('bk.status', '1');
        $this->db->where('bk.user_id', $user_id);
        $this->db->order_by('bk.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();        
        return $result_array;
    }

    public function save_member($user_id,$member_name = "",$jobtitle = "",$member_gender = "",$member_bio = "",$linkedin_url = "",$twitter_url = "",$member_img = "",$edit_member_id = 0)
    {
        if($edit_member_id == 0)
        {
            $curr_date = date('Y-m-d H:i:s', time());
            $data = array(
                'user_id' => $user_id,
                'member_name' => $member_name,
                'member_job_title' => $jobtitle,                
                'member_gender' => $member_gender,                
                'member_bio' => $member_bio,                
                'linkedin_url' => $linkedin_url,                
                'twitter_url' => $twitter_url,                
                'member_img' => $member_img,                
                'status' => '1',
                'created_date' => $curr_date,
                'modify_date' => $curr_date,
            );
            $insert_id = $this->common->insert_data($data, 'business_key_member');
            return $insert_id;
        }
        else
        {
            $data = array(
                'member_name' => $member_name,
                'member_job_title' => $jobtitle,                
                'member_gender' => $member_gender,                
                'member_bio' => $member_bio,                
                'linkedin_url' => $linkedin_url,                
                'twitter_url' => $twitter_url,                
                'member_img' => $member_img,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $user_id);
            $this->db->where('id_key_member', $edit_member_id);
            $this->db->update('business_key_member', $data);
            return true;
        }
    }

    public function delete_member($user_id,$edit_member_id)    
    {
        $data = array(                
            'status' => "0",
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('id_key_member', $edit_member_id);
        $this->db->update('business_key_member', $data);
        return true;
    }

    public function get_contact_info($user_id)
    {
        $this->db->select("bp.contact_person,bp.contact_mobile,bp.contact_email,bp.contact_website,bp.contact_job_title,bp.contact_fax,bp.contact_tollfree, IF(jt.name != '',jt.name,'') as contact_job_title_txt")->from('business_profile bp');
        $this->db->join('job_title jt', 'jt.title_id = bp.contact_job_title', 'left');
        $this->db->where('bp.user_id', $user_id);
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->order_by('bp.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->row_array();        
        return $result_array;
    }

    public function save_contact_info($user_id,$contact_person = "",$jobtitle = "",$contact_mobile = "",$contact_email = "",$contact_website = "",$contact_fax = "",$contact_tollfree = "")    
    {
        $data = array(                
            'contact_person' => $contact_person,
            'contact_job_title' => $jobtitle,
            'contact_mobile' => $contact_mobile,
            'contact_email' => $contact_email,
            'contact_website' => $contact_website,
            'contact_fax' => $contact_fax,
            'contact_tollfree' => $contact_tollfree,
            'modified_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile', $data);

        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile_search_tmp', $data);
        return true;
    }

    public function save_menu($user_id,$file_name = "")
    {
        $curr_date = date('Y-m-d H:i:s', time());
        $data = array(
            'user_id' => $user_id,
            'file_name' => $file_name,                
            'status' => '1',
            'created_date' => $curr_date,
            'modify_date' => $curr_date,
        );
        $insert_id = $this->common->insert_data($data, 'business_user_menu');
        return $insert_id;
    }

    public function delete_menu($user_id,$menu_id)    
    {
        $data = array(                
            'status' => "0",
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->where('id_user_menu', $menu_id);
        $this->db->update('business_user_menu', $data);
        return true;
    }

    public function get_menu_info($user_id)
    {
        $this->db->select("*")->from('business_user_menu');        
        $this->db->where('user_id', $user_id);
        $this->db->where('status', '1');
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();        
        return $result_array;
    }

    public function get_address_info($user_id)
    {
        $this->db->select("bp.country, bp.state, bp.city, bp.other_city, bp.pincode, bp.address, ct.city_name, st.state_name, cr.country_name, bp.business_no_location, bp.business_office_location")->from('business_profile bp');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
        $this->db->join('states st', 'st.state_id = bp.state', 'left');
        $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
        $this->db->where('bp.user_id', $user_id);
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->order_by('bp.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->row_array();        
        return $result_array;
    }

    public function save_address_info($user_id,$address_country = "",$address_state = "",$address_city = "",$address_other_city = "",$address_address = "",$address_pincode = "",$address_no_location = "",$address_office_location = "")    
    {
        $sql = "SELECT * FROM ailee_cities WHERE state_id = '".$address_state."' AND LOWER(city_name) = '". trim(strtolower($address_other_city)) ."'";

        $query = $this->db->query($sql);
        $city_data = $query->row_array();
        if(isset($city_data) && !empty($city_data))
        {
            $other_city_name = $city_data['city_name'];
        }
        else
        {
            $city_slug = $this->common->set_city_slug(trim($address_other_city), 'slug', 'cities');
            $data_city = array();
            $data_city['city_name'] = $address_other_city;
            $data_city['state_id'] = $address_state;
            $data_city['status'] = '2';
            $data_city['group_id'] = '0';
            $data_city['city_image'] =  $city_slug.'.png';
            $data_city['slug'] = $city_slug;
            $cityId = $this->common->insert_data_getid($data_city, 'cities');

        }

        $data = array(                
            'country' => $address_country,
            'state' => $address_state,
            'city' => $address_city,
            'other_city' => $address_other_city,
            'pincode' => $address_pincode,
            'address' => $address_address,
            'business_no_location' => $address_no_location,
            'business_office_location' => $address_office_location,
            'modified_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile', $data);

        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile_search_tmp', $data);
        return true;
    }

    function searchCityList($search_keyword = '') {
        $this->db->select('c.city_id,c.city_name')->from('cities c');
        $sql = "c.city_name LIKE '".$search_keyword."%' AND c.status = '1' AND c.state_id != '0'";
        $this->db->where($sql);
        $this->db->limit('20');
        $query = $this->db->get();        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_business_info($user_id)
    {
        $this->db->select("bp.company_name, bp.business_type, bp.other_business_type, bp.industriyal, bp.other_industrial, bp.details, bp.business_tot_emp, bp.business_year_found, bp.business_ext_benifit, bp.business_pay_mode, bp.business_keyword, bp.business_mission, bp.business_legal_name, bp.business_ser_pro, bp.business_serve_area, bp.business_tagline, bp.business_formly_known,bt.business_name as business_type_txt,it.industry_name as industriyal_txt,IF(bp.business_serve_area != '',GROUP_CONCAT(DISTINCT(ct.city_name)),'') as business_serve_area_txt")->from('business_profile bp,cities ct');
        $this->db->join('business_type bt', 'bt.type_id = bp.business_type', 'left');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $sql = "IF(bp.business_serve_area != '', FIND_IN_SET(ct.city_id, bp.business_serve_area) != '0', '1=1')";
        $this->db->where($sql);
        $this->db->where('bp.user_id', $user_id);
        $this->db->where('bp.status', '1');
        $this->db->where('bp.is_deleted', '0');
        $this->db->where('bp.business_step', '4');
        $this->db->group_by('bp.business_serve_area,bp.business_profile_id');
        $this->db->order_by('bp.created_date', 'desc');
        $query = $this->db->get();
        $result_array = $query->row_array();        
        return $result_array;
    }

    public function save_business($user_id,$business_name = "",$business_type = "",$other_business_type = "",$business_category = "",$other_business_category = "",$business_desc = "",$business_tot_emp = "",$business_year_found,$business_ext_benifit_txt = "",$business_pay_mode = "",$business_keyword_txt = "",$business_mission = "",$business_legal_name = "",$business_ser_pro_txt = "",$city_txt = "",$business_tagline = "",$business_formly_known = "")    
    {
        $data = array(                
            'company_name' => $business_name,
            'business_type' => $business_type,
            'other_business_type' => $other_business_type,
            'industriyal' => $business_category,
            'other_industrial' => $other_business_category,
            'details' => $business_desc,
            'business_tot_emp' => $business_tot_emp,
            'business_year_found' => $business_year_found,
            'business_ext_benifit' => $business_ext_benifit_txt,
            'business_pay_mode' => $business_pay_mode,
            'business_keyword' => $business_keyword_txt,
            'business_mission' => $business_mission,
            'business_legal_name' => $business_legal_name,
            'business_ser_pro' => $business_ser_pro_txt,
            'business_serve_area' => $city_txt,
            'business_tagline' => $business_tagline,
            'business_formly_known' => $business_formly_known,
            'modified_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile', $data);

        $industriyal = "";
        if(trim($data['industriyal']) != "" && $data['industriyal'] != 0)
        {
            $industriyal = $this->db->get_where('industry_type', array('industry_id' => $data['industriyal'], 'status' => '1'))->row()->industry_name;
        }
        $data['industry_name'] = trim($industriyal);
        
        $this->db->where('user_id', $user_id);
        $this->db->update('business_profile_search_tmp', $data);
        return true;
    }

    public function getFollowerCount($user_id = '', $select_data = '') {
        $where = "((uf.follow_to = '" . $user_id . "'))";
        $this->db->select("count(*) as total")->from("user_follow  uf");
        $this->db->where('uf.status', '1');
        $this->db->where('uf.follow_type', '2');
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_business_follower_data($user_id = '', $sortby = '', $orderby = '', $limit = '', $page = '',$login_user_id) {        
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $where = "((uf.follow_to = '" . $user_id . "'))";

        $this->db->select("u.user_id,u.first_name,u.last_name,u.user_gender,ui.user_image,jt.name as title_name,d.degree_name,u.user_slug")->from("user_follow  uf");
        $this->db->join('user u', 'u.user_id = uf.follow_from', 'left');
        $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
        $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
        $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
        $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
        $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
        $this->db->where('uf.status', '1');
        $this->db->where('uf.follow_type', '2');
        $this->db->where("ul.status","1");
        $this->db->where("ul.is_delete","0");
        $this->db->where($where);
        $this->db->order_by("uf.id", "DESC");
        if($limit != '') {
            $this->db->limit($limit,$start);
        }

        $query = $this->db->get();
        $result_array = $query->result_array();        
        // echo $this->db->last_query();die;
        // echo '<pre>'; print_r($result_array); die();        
        foreach ($result_array as $key => $result) {
            if($login_user_id != $result['user_id'])
            {
                $condition = "((uf.follow_to = '" . $login_user_id . "' AND uf.follow_from = '" . $result['user_id'] . "'))";
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
        $total_record = $this->getFollowerCount($user_id, $select_data = '');
        $page_array['page'] = $page;
        $page_array['total_record'] = $total_record[0]['total'];
        $page_array['perpage_record'] = $limit;

        $data = array(
            'followerrecord' => $result_array,
            'pagedata' => $page_array
        );
        return $data;
        // return $result_array;
    }

    public function get_user_business_article($user_id,$login_userid,$limit = "")
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
        $this->db->where('a.user_type', '2');   
        $this->db->order_by('a.id_post_article', 'desc');
        if($limit != ''){
            $this->db->limit('6');
        }
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        $article_data = $query->result_array();
        if($login_userid == $user_id)
        { 
            foreach ($article_data as $k=>$v)
            {
                $check_article = $this->user_post_model->check_article($v['id_post_article']);             
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
        return $article_data;
    }

}