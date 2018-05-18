<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_model extends CI_Model {

    function businessCategory($limit = '') {
        $this->db->select('count(bp.business_profile_id) as count,industry_id,industry_name,industry_slug')->from('industry_type it');
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

    function businessAllCategory() {
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
        return $result_array;
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
        $this->db->select('bp.business_user_image,bp.profile_background,bp.business_slug,bp.other_industrial,bp.company_name,bp.country,bp.city,bp.details,bp.contact_website,it.industry_name,ct.city_name as city,cr.country_name as country')->from('business_profile bp');
        $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');
        $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
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
        return $result_array;
    }*/

    function searchBusinessData($keyword = '', $location = '',  $category_id = '',$location_id = '') {
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
                OR it.industry_name LIKE '". $val ."') ";
            }
        } 

        if($category_id != ""){
            $sqlcategoryfilter = ($sqlkeyword == "") ? " AND " : " OR ";
            $sqlcategoryfilter .= "bp.industriyal IN (". $category_id .")";
            $sqlcategoryfilter .= ($sqlkeyword != "") ? ")" : "";
        }else{
            $sqlcategoryfilter = ($sqlkeyword != "") ? ")" : "";
        }

        // IF LOCATION SEARCH
        if($location != ""){
            $locationdata = explode(',', $location);
            $sqllocation = " AND (";
            foreach($locationdata as $key => $val){
                $val = $val.'%';
                $sqllocation .= ($key == 0) ? "" : " OR ";
                $sqllocation .= " ct.city_name LIKE '". $val ."'
                    OR cr.country_name LIKE '". $val ."'
                    OR s.state_name LIKE '". $val ."'";
            }
        }
        
        if($location_id != ""){
            $sqllocationfilter = ($sqllocation == "") ? " AND " : " OR ";
            $sqllocationfilter .= "ct.city_id IN (". $location_id .")";  
            $sqllocationfilter .= ($sqllocation != "") ? ")" : ""; 
        }else{
            $sqllocationfilter = ($sqllocation != "") ? ")" : ""; 
        }


        $sql = "SELECT bp.business_user_image, bp.profile_background, bp.business_slug, 
                bp.other_industrial, bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, ct.city_name as city, cr.country_name as country 
                FROM ailee_business_profile bp 
                LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
                LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
                LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
                LEFT JOIN ailee_states s ON s.state_name = bp.state 
                WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4'"
                . $sqlkeyword .$sqlcategoryfilter . $sqllocation . $sqllocationfilter;


            if($limit){
                $sql .= " LIMIT ". $limit;
            }
            $query = $this->db->query($sql);
            $result_array = $query->result_array();
            return $result_array;
    }

    function business_followers($follow_to = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_from = bp.business_profile_id');
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
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->join('follow f', 'f.follow_to = bp.business_profile_id');
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

    function business_userlist($user_id = '', $sortby = '', $orderby = '', $limit = '', $offset = '') {
        $this->db->select('*')->from('business_profile bp');
        $this->db->join('user_login ul', 'ul.user_id = bp.user_id');
        $this->db->where('bp.user_id !=', $user_id);
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

    function getBusinessPostComment($post_id = '', $sortby = '', $orderby = '', $limit = '') {
        $this->db->select('bppc.*')->from('business_profile_post_comment bppc');
        $this->db->join('user_login ul', 'ul.user_id = bppc.user_id');
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
        $sql = "SELECT `ailee_business_profile`.`business_user_image`, `ailee_business_profile`.`company_name`, `ailee_business_profile`.`industriyal`, `ailee_business_profile`.`business_slug`, `ailee_business_profile`.`other_industrial`, `ailee_business_profile`.`business_slug`, `ailee_business_profile_post`.`business_profile_post_id`, `ailee_business_profile_post`.`product_name`, `ailee_business_profile_post`.`product_description`, `ailee_business_profile_post`.`business_likes_count`, `ailee_business_profile_post`.`business_like_user`, `ailee_business_profile_post`.`created_date`, `ailee_business_profile_post`.`posted_user_id`, `ailee_business_profile`.`user_id` 
            FROM `ailee_business_profile_post` 
            JOIN `ailee_business_profile` ON `ailee_business_profile`.`user_id`=`ailee_business_profile_post`.`user_id` 
            JOIN `ailee_user_login` ON `ailee_user_login`.`user_id`=`ailee_business_profile`.`user_id` 
            WHERE `ailee_business_profile_post`.`is_delete` = '0' 
            AND `ailee_business_profile_post`.`status` = '1' 
            AND `ailee_user_login`.`is_delete` = '0' 
            AND `ailee_user_login`.`status` = '1' 
            AND `business_profile_post_id` NOT IN ( SELECT business_profile_post_id FROM `ailee_business_profile_post` WHERE `ailee_business_profile_post`.`is_delete` = '0' AND `ailee_business_profile_post`.`status` = '1' AND FIND_IN_SET ('".$user_id."', delete_post) != '0')
            AND (
            `ailee_business_profile_post`.`user_id` IN (SELECT user_id FROM `ailee_follow` JOIN `ailee_business_profile` ON `ailee_business_profile`.`business_profile_id`=`ailee_follow`.`follow_to` WHERE `follow_from` = '".$business_profile_id."' AND `follow_status` = '1' AND `follow_type` = '2') OR 
            `ailee_business_profile_post`.`user_id` IN (SELECT user_id FROM `ailee_business_profile` WHERE `ailee_business_profile`.`is_deleted` = '0' AND `ailee_business_profile`.`status` = '1' AND `ailee_business_profile`.`business_step` = '4' AND (`ailee_business_profile`.`industriyal` = '".$industriyal."' AND `ailee_business_profile`.`industriyal` !=0) AND (`ailee_business_profile`.`other_industrial` = '".$other_industrial."' AND `ailee_business_profile`.`other_industrial` != '') OR (`ailee_business_profile`.`city` = '".$city."' AND `ailee_business_profile`.`industriyal` = '$industriyal'))
                )
            OR (`ailee_business_profile_post`.`posted_user_id` = '".$user_id."' AND `ailee_business_profile_post`.`is_delete` =0)
            ORDER BY `business_profile_post_id` DESC";
        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function business_home_post_total_rec($business_profile_id,$city,$user_id,$industriyal,$other_industrial,$login_userid)
    {
        $sql = "SELECT count(*) as total_record
            FROM `ailee_business_profile_post` 
            JOIN `ailee_business_profile` ON `ailee_business_profile`.`user_id`=`ailee_business_profile_post`.`user_id` 
            JOIN `ailee_user_login` ON `ailee_user_login`.`user_id`=`ailee_business_profile`.`user_id` 
            WHERE `ailee_business_profile_post`.`is_delete` = '0' 
            AND `ailee_business_profile_post`.`status` = '1' 
            AND `ailee_user_login`.`is_delete` = '0' 
            AND `ailee_user_login`.`status` = '1' 
            AND `business_profile_post_id` NOT IN ( SELECT business_profile_post_id FROM `ailee_business_profile_post` WHERE `ailee_business_profile_post`.`is_delete` = '0' AND `ailee_business_profile_post`.`status` = '1' AND FIND_IN_SET ('".$user_id."', delete_post) != '0')
            AND (
            `ailee_business_profile_post`.`user_id` IN (SELECT user_id FROM `ailee_follow` JOIN `ailee_business_profile` ON `ailee_business_profile`.`business_profile_id`=`ailee_follow`.`follow_to` WHERE `follow_from` = '".$business_profile_id."' AND `follow_status` = '1' AND `follow_type` = '2') OR 
            `ailee_business_profile_post`.`user_id` IN (SELECT user_id FROM `ailee_business_profile` WHERE `ailee_business_profile`.`is_deleted` = '0' AND `ailee_business_profile`.`status` = '1' AND `ailee_business_profile`.`business_step` = '4' AND (`ailee_business_profile`.`industriyal` = '".$industriyal."' AND `ailee_business_profile`.`industriyal` !=0) AND (`ailee_business_profile`.`other_industrial` = '".$other_industrial."' AND `ailee_business_profile`.`other_industrial` != '') OR (`ailee_business_profile`.`city` = '".$city."' AND `ailee_business_profile`.`industriyal` = '$industriyal'))
                )
            OR (`ailee_business_profile_post`.`posted_user_id` = '".$user_id."' AND `ailee_business_profile_post`.`is_delete` =0)
            ORDER BY `business_profile_post_id` DESC";        
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;        
    }

    // Get city id form city name
    function getlocationdatafromname($location = ''){
        $sql = "SELECT group_concat(city_id) as city_id FROM `ailee_cities` WHERE `city_name` = '". $location ."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    // Get all location of business
    function businessLocation($limit = '') {
        $sql = "SELECT count(bp.business_profile_id) as count, ac.city_id, ac.city_name, ac.slug 
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

    // Get Location List based on city id
    function businessListByLocation($id = '0') {
        $sql = "SELECT bp.business_user_image, bp.profile_background, bp.business_slug, bp.other_industrial, 
            bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, ct.city_name as city, 
            cr.country_name as country 
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4' and
            bp.city = '" . $id ."'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    // Get Location List based on city id
    function businessListByFilter($category_id = '', $location_id = '', $limit = '') {
        $sql = "SELECT bp.business_user_image, bp.profile_background, bp.business_slug, bp.other_industrial, bp.company_name, bp.country, bp.city, bp.details, bp.contact_website, it.industry_name, 
            ct.city_name as city, 
            cr.country_name as country 
            FROM ailee_business_profile bp 
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal 
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step = '4'";

            if($category_id != ''){
                $sql .= " AND bp.industriyal IN (". $category_id .")";
            }   
            
            if($location_id != ''){
                $sql .= " AND bp.city IN (". $location_id .")";
            }
            if($limit){
                $sql .= " Limit ". $limit;   
            }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
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
        $s3 = new S3(awsAccessKey, awsSecretKey);
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

        $follower_count = $bus_user_f_er_count[0]['follower_count'];

        return $follower_count;
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

}
