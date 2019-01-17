<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artistic_model extends CI_Model {

    public function getArtUserData($user_id = '') {
        $this->db->select("a.art_id,a.art_name,a.art_lastname,a.art_city,a.art_country,a.art_skill,a.other_skill,a.user_id,a.status,a.is_delete,a.art_step,a.art_user_image,a.profile_background,a.designation,a.slug")->from("art_reg a");
        $this->db->where(array('a.user_id' => $user_id, 'a.is_delete' => '0', 'a.status' => '1'));
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    public function artistCategory($limit = '') {
        $this->db->select('category_id,art_category,category_slug,art_category_img')->from('art_category ac');
        $this->db->where('ac.status', '1');
        $this->db->where('ac.category_id !=', '26');
        $query = $this->db->get();
        $art_category = $query->result_array();
        $return_array = array();
        foreach ($art_category as $key => $value) {
            $return = array();
            $category_id = $value['category_id'];
            $this->db->select('count(art_id) as count')->from('art_reg ar');
            $this->db->where('FIND_IN_SET(ar.art_skill, ' . $category_id . ')');
            $this->db->where('ar.status', '1');
            $this->db->where('ar.art_step', '4');
            $this->db->where('ar.is_delete', '0');
            $query = $this->db->get();
            $cat_count = $query->row_array();
            $return['count'] = $cat_count['count'];
            $return['category_id'] = $value['category_id'];
            $return['art_category'] = $value['art_category'];
            $return['category_slug'] = $value['category_slug'];
            $return['art_category_img'] = $value['art_category_img'];

            array_push($return_array, $return);
        }
        array_multisort(array_column($return_array, 'count'), SORT_DESC, $return_array);
        array_splice($return_array, $limit);

        return $return_array;
    }

    /*function artistAllCategory() {
        $this->db->select('category_id,art_category,category_slug')->from('art_category ac');
        $this->db->where('ac.status', '1');
        $this->db->where('ac.category_id !=', '26');
        $query = $this->db->get();
        $art_category = $query->result_array();
        $return_array = array();
        foreach ($art_category as $key => $value) {
            $return = array();
            $category_id = $value['category_id'];
            $this->db->select('count(art_id) as count')->from('art_reg ar');
            $this->db->where('FIND_IN_SET(ar.art_skill, ' . $category_id . ')');
            $this->db->where('ar.status', '1');
            $this->db->where('ar.art_step', '4');
            $this->db->where('ar.is_delete', '0');
            $query = $this->db->get();
            $cat_count = $query->row_array();

            $return['count'] = $cat_count['count'];
            $return['category_id'] = $value['category_id'];
            $return['art_category'] = $value['art_category'];
            $return['category_slug'] = $value['category_slug'];

            array_push($return_array, $return);
        }
        array_multisort(array_column($return_array, 'count'), SORT_DESC, $return_array);

        return $return_array;
    }*/

    function artistAllCategory($page = "",$limit = '5') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "SELECT count(ar.art_id) as count, ct.category_id, ct.art_category, ct.category_slug,ct.art_category_img
            FROM ailee_art_category ct,ailee_art_reg ar
            WHERE ct.category_id !=26 AND FIND_IN_SET(ct.category_id,ar.art_skill) > 0 AND ct.status = '1' 
            AND ct.type = '1' AND ar.status = '1' AND ar.art_step = '4' AND ar.is_delete = '0'
            GROUP BY ct.category_id ORDER BY count DESC";

        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }

        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function artistAllCategoryTotalRec() {        
        $sql = "SELECT count(ar.art_id) as count, ct.category_id, ct.art_category, ct.category_slug
            FROM ailee_art_category ct,ailee_art_reg ar
            WHERE ct.category_id !=26 AND FIND_IN_SET(ct.category_id,ar.art_skill) > 0 AND ct.status = '1' 
            AND ct.type = '1' AND ar.status = '1' AND ar.art_step = '4' AND ar.is_delete = '0'
            GROUP BY ct.category_id ORDER BY count DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return count($result_array);
    }

    function otherCategoryCount() {
        $category_id = '26';
        $this->db->select('count(art_id) as count')->from('art_reg ar');
        $this->db->where('FIND_IN_SET(ar.art_skill, ' . $category_id . ')');
        $this->db->where('ar.status', '1');
        $this->db->where('ar.art_step', '4');
        $this->db->where('ar.is_delete', '0');
        $query = $this->db->get();
        $cat_count = $query->row_array();
        return $cat_count['count'];
    }

    function artistListByCategory($id = '') {
        $this->db->select("ar.art_user_image,ar.profile_background,ar.slug,ar.other_skill,CONCAT(ar.art_name,' ',ar.art_lastname) as fullname,ar.art_country,ar.art_city,ar.art_desc_art,ar.user_id,ac.art_category,ct.city_name as city,cr.country_name as country")->from("art_reg ar");
        $this->db->join('art_category ac', 'ac.category_id = ar.art_skill', 'left');
        $this->db->join('cities ct', 'ct.city_id = ar.art_city', 'left');
        $this->db->join('countries cr', 'cr.country_id = ar.art_country', 'left');
        $this->db->where('ar.art_skill', $id);
        $this->db->where('ar.status', '1');
        $this->db->where('ar.is_delete', '0');
        $this->db->where('ar.art_step', '4');
        $query = $this->db->get();
        $result_array = $query->result_array();
        // foreach ($result_array as $key => $value) {
        //     $user_id = $value['user_id'];
        //     $new_slug = $this->get_artistic_slug($user_id);
        //     $result_array[$key]['slug'] = $new_slug;
        // }
        return $result_array;
    }

    function findArtistCategory($keyword = '') {
        $this->db->select('category_id')->from('art_category ac');
        if ($keyword != '') {
            $this->db->where("(ac.art_category LIKE '%$keyword%')");
        }
        $this->db->where('ac.status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['category_id'];
    }

    function searchArtistData2($keyword = '', $location = '') {
        $keyword = str_replace('%20', ' ', $keyword);
        $location = str_replace('%20', ' ', $location);

        $artCat = $this->findArtistCategory($keyword);

        $this->db->select("ar.art_user_image,ar.profile_background,ar.slug,ar.other_skill,CONCAT(ar.art_name,' ',ar.art_lastname) as fullname,ar.art_country,ar.art_city,ar.art_desc_art,ar.user_id,ac.art_category,ct.city_name as city,cr.country_name as country")->from("art_reg ar");
        $this->db->join('art_category ac', 'ac.category_id = ar.art_skill', 'left');
        $this->db->join('cities ct', 'ct.city_id = ar.art_city', 'left');
        $this->db->join('countries cr', 'cr.country_id = ar.art_country', 'left');
        $this->db->join('states s', 's.state_name = ar.art_state', 'left');
        if ($keyword != '' && $artCat == '') {
            $this->db->where("(ar.art_name LIKE '%$keyword%' OR ar.art_lastname LIKE '%$keyword%' OR CONCAT(ar.art_name, ' ',ar.art_lastname) LIKE '%$keyword%' OR ar.art_email LIKE '%$keyword%' OR ar.art_phnno LIKE '%$keyword%' OR ar.art_address LIKE '%$keyword%' OR ar.art_yourart LIKE '%$keyword%' OR ar.art_desc_art LIKE '%$keyword%' OR ar.art_inspire LIKE '%$keyword%' OR ar.art_bestofmine LIKE '%$keyword%' OR ar.art_portfolio LIKE '%$keyword%' OR ar.other_skill LIKE '%$keyword%' OR ar.slug LIKE '%$keyword%')");
        } elseif ($keyword != '' && $artCat != '') {
            $this->db->where("(ar.art_name LIKE '%$keyword%' OR ar.art_lastname LIKE '%$keyword%' OR CONCAT(ar.art_name, ' ',ar.art_lastname) LIKE '%$keyword%' OR ar.art_email LIKE '%$keyword%' OR ar.art_phnno LIKE '%$keyword%' OR ar.art_address LIKE '%$keyword%' OR ar.art_yourart LIKE '%$keyword%' OR ar.art_desc_art LIKE '%$keyword%' OR ar.art_inspire LIKE '%$keyword%' OR ar.art_bestofmine LIKE '%$keyword%' OR ar.art_portfolio LIKE '%$keyword%' OR ar.other_skill LIKE '%$keyword%' OR ar.slug LIKE '%$keyword%' OR ar.art_skill = '$artCat')");
        }
        if ($location != '') {
            $this->db->where("(ct.city_name = '$location' OR cr.country_name = '$location' OR s.state_name = '$location')");
        }

        $this->db->where('ar.status', '1');
        $this->db->where('ar.is_delete', '0');
        $this->db->where('ar.art_step', '4');

        $query = $this->db->get();
        $result_array = $query->result_array();
        
        foreach ($result_array as $key => $value) {
            $user_id = $value['user_id'];
            $new_slug = $this->get_artistic_slug($user_id);
            $result_array[$key]['slug'] = $new_slug;
        }
        return $result_array;
    }

    function get_artistic_slug($userid = '') {
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

        $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

        $category = $arturl[0]['art_skill'];
        $category = explode(',', $category);

        foreach ($category as $catkey => $catval) {
            $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
            $categorylist[] = $art_category;
        }

        $listfinal1 = array_diff($categorylist, array('other'));
        $listFinal = implode('-', $listfinal1);

        if (!in_array(26, $category)) {
            $category_url = $this->common->clean($listFinal);
        } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

            $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
            $category_url = trim($trimdata, '-');
        } else {
            $category_url = $this->common->clean($art_othercategory);
        }

        $city_get = $this->common->clean($city_url);

        if (!$city_get) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $arturl[0]['art_id'];
        } else if (!$category_url) {
            $url = $arturl[0]['slug'] . '-' . $city_get . '-' . $arturl[0]['art_id'];
        } else if ($city_get && $category_url) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
        }
        return $url;
    }

    // Get data of artistic post 
    function get_artist_home_post($login_userid,$page,$limit = '4'){
        // Get artistic data
        /*$artregid = "";
        $artskill = "";
        $artistsql = "SELECT * FROM `ailee_art_reg` WHERE `user_id` = '" . $login_userid ."' AND `status` = '1'";
        // print_r($artdata);
        $artquery = $this->db->query($artistsql);
        $artdata = $artquery->result_array();*/
        //print_r($artdata);exit;
        if(count($artdata) > 0){
            $artregid = $artdata[0]['art_id'];
            $artskill = $artdata[0]['art_skill'];
        }

        // Start limit
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        /*$sql = "SELECT `ailee_art_reg`.`art_user_image`, `ailee_art_reg`.`art_name`, `ailee_art_reg`.`art_lastname`, `ailee_art_reg`.`art_skill`, `ailee_art_reg`.`slug`, `ailee_art_post`.`art_post_id`, `ailee_art_post`.`art_post`, `ailee_art_post`.`art_description`, `ailee_art_post`.`art_likes_count`, `ailee_art_post`.`art_like_user`, `ailee_art_post`.`created_date`, `ailee_art_post`.`posted_user_id`, `ailee_art_reg`.`user_id` 
            FROM `ailee_art_post` 
            JOIN `ailee_art_reg` ON `ailee_art_reg`.`user_id`=`ailee_art_post`.`user_id` 
            WHERE `ailee_art_post`.`is_delete` = '0' 
            AND `ailee_art_post`.`status` = '1' AND 
            `art_post_id` NOT IN (
                SELECT art_post_id FROM `ailee_art_post` 
                WHERE `ailee_art_post`.`is_delete` = '0' AND `ailee_art_post`.`status` = '1' 
                AND FIND_IN_SET ('". $login_userid  ."', delete_post) != '0'
            ) AND (
             `ailee_art_post`.`user_id` 
                = '". $login_userid ."'
                OR
                `ailee_art_post`.`user_id` 
                IN (
                    SELECT user_id FROM `ailee_follow` 
                    JOIN `ailee_art_reg` ON `ailee_art_reg`.`art_id`=`ailee_follow`.`follow_to` 
                    WHERE `follow_from` = '". $artregid ."' AND `follow_status` = '1' AND `follow_type` = '1' 
                    AND `ailee_art_reg`.`status` = '1' AND `ailee_art_reg`.`is_delete` = '0'
                ) 
                OR
              `ailee_art_post`.`user_id` 
                IN (      
                    SELECT user_id FROM `ailee_art_reg` 
                    WHERE `ailee_art_reg`.`is_delete` = '0' AND `ailee_art_reg`.`status` = '1' 
                    AND `ailee_art_reg`.`art_step` = '4' AND (
                        `art_skill` IN (
                                   ". $artskill ."
                                )
                        )
                    )
            ) 
            ORDER BY `art_post_id` DESC";*/

        $sql = "SELECT ar.art_user_image, ar.art_name, ar.art_lastname, ar.art_skill, ar.slug, ap.art_post_id, ap.art_post, ar.user_id, ar.designation, ar.art_skill, ap.art_description, ap.art_likes_count, ap.art_like_user, ap.created_date, ap.posted_user_id
            FROM ailee_art_post as ap
            JOIN ailee_art_reg as ar ON ar.user_id=ap.user_id 
            WHERE ap.is_delete = '0' 
            AND ap.status = '1' 
            AND ar.status = '1' 
            AND ar.is_delete = '0' 
            ORDER BY ap.art_post_id DESC";
            if($limit != '') {
                $sql .= " LIMIT $start,$limit";
            }

            $query = $this->db->query($sql);
            $result_array = $query->result_array();
            foreach ($result_array as $key => $value) {
                $art_like_arr = $this->get_artist_like_count_user($value['art_like_user']);
                $result_array[$key]['art_likes_count'] = $art_like_arr['art_like_count'];
                $result_array[$key]['art_like_user'] = $art_like_arr['art_like_user'];
            }

            return $result_array;
    } 

    function get_artist_like_count_user($art_like_user)
    {
        $art_like_user_arr = explode(",", $art_like_user);
        $ret_arr = array();
        foreach ($art_like_user_arr as $key => $value) {
            $art_user = $this->db->select('art_name')->get_where('art_reg', array('user_id' => $value, 'status' => '1'))->row();
            if(isset($art_user) && !empty($art_user))
            {
                $ret_arr[] = $value;
            }
        }
        return array("art_like_count"=>count($ret_arr),"art_like_user"=>implode(",", $ret_arr));
    }

    // Get count of artistic post data 
    function get_artist_home_post_count($login_userid){
        $artregid = "";
        $artskill = "";
        $artistsql = "SELECT * FROM `ailee_art_reg` WHERE `user_id` = '" . $login_userid ."' AND `status` = '1'";
        $artquery = $this->db->query($artistsql);
        $artdata = $artquery->result_array();
        if(count($artdata) > 0){
            $artregid = $artdata[0]['art_id'];
            $artskill = $artdata[0]['art_skill'];
        }

        /*$sql = "SELECT count(*) as total_record
            FROM `ailee_art_post` 
            JOIN `ailee_art_reg` ON `ailee_art_reg`.`user_id`=`ailee_art_post`.`user_id` 
            WHERE `ailee_art_post`.`is_delete` = '0' 
            AND `ailee_art_post`.`status` = '1' AND 
            `art_post_id` NOT IN (
                SELECT art_post_id FROM `ailee_art_post` 
                WHERE `ailee_art_post`.`is_delete` = '0' AND `ailee_art_post`.`status` = '1' 
                AND FIND_IN_SET ('". $login_userid  ."', delete_post) != '0'
            ) AND (
             `ailee_art_post`.`user_id` 
                = '". $login_userid ."'
                OR
                `ailee_art_post`.`user_id` 
                IN (
                    SELECT user_id FROM `ailee_follow` 
                    JOIN `ailee_art_reg` ON `ailee_art_reg`.`art_id`=`ailee_follow`.`follow_to` 
                    WHERE `follow_from` = '". $artregid ."' AND `follow_status` = '1' AND `follow_type` = '1' 
                    AND `ailee_art_reg`.`status` = '1' AND `ailee_art_reg`.`is_delete` = '0'
                ) 
                OR
              `ailee_art_post`.`user_id` 
                IN (      
                    SELECT user_id FROM `ailee_art_reg` 
                    WHERE `ailee_art_reg`.`is_delete` = '0' AND `ailee_art_reg`.`status` = '1' 
                    AND `ailee_art_reg`.`art_step` = '4' AND (
                        `art_skill` IN (
                                   ". $artskill ."
                                )
                        )
                    )
            ) 
            ORDER BY `art_post_id` DESC";*/
        $sql = "SELECT count(*) as total_record
            FROM ailee_art_post as ap
            JOIN ailee_art_reg as ar ON ar.user_id=ap.user_id 
            WHERE ap.is_delete = '0' 
            AND ap.status = '1'
            AND ar.status = '1' 
            AND ar.is_delete = '0' 
            ORDER BY ap.art_post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row()->total_record;
        return $result_array;
    }
    
    // GET TOP LOCATION OF ARTIST
    public function gettoplocationsofartist($limitstart, $limit){
        $limitstart = ($limitstart) ? $limitstart : 0;
        $limit = ($limit) ? $limit : 8;
        $sql = "select count(*) as count, ac.city_name,ac.city_image 
                    from ailee_art_reg as ar
                    left join ailee_cities as ac on ac.city_id = ar.art_city
                    where city_name IS NOT NULL and ar.status = 1 
                    group by art_city
                    order by count desc LIMIT ". $limitstart .",". $limit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    // GET ID OF LOCATION ARTIST
    public function getidfromnameoflocation($city_name = ''){
        $sql = "SELECT group_concat(city_id) as city_id FROM `ailee_cities` WHERE `city_name` = '". $city_name ."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    public function getidfromslugoflocation($city_name = ''){
        $sql = "SELECT group_concat(city_id) as city_id FROM `ailee_cities` WHERE `slug` = '". $city_name ."'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    function artistListByLocation($id = '') {
        $sql = "SELECT ar.art_user_image, ar.profile_background, ar.slug, ar.other_skill, 
                CONCAT(ar.art_name, ' ', ar.art_lastname) as fullname, ar.art_country, ar.art_city, ar.art_desc_art, 
                ar.user_id, ct.city_id, ct.city_name as city, cr.country_name as country 
                FROM ailee_art_reg as ar  
                LEFT JOIN ailee_cities as ct ON ct.city_id = ar.art_city 
                LEFT JOIN ailee_countries as cr ON cr.country_id = ar.art_country 
                WHERE ar.art_city IN ($id) AND ar.status = '1' AND ar.is_delete = '0' AND ar.art_step = '4'";
        
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        // foreach ($result_array as $key => $value) {
        //     $user_id = $value['user_id'];
        //     $new_slug = $this->get_artistic_slug($user_id);
        //     $result_array[$key]['slug'] = $new_slug;
        // }
        return $result_array;
    }

    function artistAllLocation($limit = '') {
        $sql = "select ar.art_city as location_id,ac.city_name as art_location,ac.slug as location_slug, count(ar.art_id) as total
            from ailee_art_reg as ar
            left join ailee_cities as ac on ac.city_id = ar.art_city
            where ar.status = 1 and ar.art_step = 4 and ar.is_delete = '0' and ac.city_name IS NOT NULL 
            group by ar.art_city order by total desc";
        if($limit != ''){
            $sql .= " LIMIT " . $limit;
        }
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function artistAllLocationList($page = 1, $limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $sql = "SELECT count(ar.art_id) as count, ar.art_city as location_id, ac.city_name as art_location, ac.slug as location_slug,ac.city_image 
                FROM ailee_cities ac 
                LEFT JOIN ailee_art_reg ar ON ar.art_city = ac.city_id
                WHERE ac.status = '1' AND ar.status = '1'
                AND ar.art_step = '4' 
                GROUP BY ar.art_city 
                ORDER BY count DESC";

        $total_query = $this->db->query($sql);
        $totalartistLocation = $total_query->result_array();   
        $result_array['total_record'] = count($totalartistLocation);
        
        if($limit != ''){
            $sql .= " LIMIT ". $start . "," . $limit;
        }
        // echo $sql;
        // exit;
        $query = $this->db->query($sql);
        $businessLocation = $query->result_array();   
        $result_array['art_loc'] = $businessLocation;
        return $result_array;
    }

    function artistListByFilter($category_id = '', $location_id = '', $limit = '') {
        // $limit = ($limit == '') ? 5 : $limit;
        $sql = "SELECT ar.art_user_image, ar.profile_background, ar.slug, ar.other_skill, ac.art_category, CONCAT(ar.art_name, ' ', ar.art_lastname) as fullname, ar.art_country, ar.art_city, ar.art_desc_art, 
                ar.user_id, ct.city_id, ct.city_name as city, cr.country_name as country 
                FROM ailee_art_reg as ar 
                LEFT JOIN ailee_art_category ac ON ac.category_id = ar.art_skill  
                LEFT JOIN ailee_cities as ct ON ct.city_id = ar.art_city 
                LEFT JOIN ailee_countries as cr ON cr.country_id = ar.art_country 
                WHERE ar.status = '1' AND ar.is_delete = '0' AND ar.art_step = '4'";
        if($category_id != ''){
            $sql .= " AND ar.art_skill IN (". $category_id .")";
        }   
        
        if($location_id != ''){
            $sql .= " AND ar.art_city IN (". $location_id .")";
        }
        if($limit){
            $sql .= " Limit ". $limit;   
        }
        // echo $sql;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();

        return $result_array;
    }

    function artistListLocationCategory($category_id = '', $location_id = '', $page ='',$limit = '',$art_category = array(),$art_location = array()) {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "SELECT ar.art_user_image, ar.profile_background, ar.slug, ar.other_skill, ac.art_category, CONCAT(ar.art_name, ' ', ar.art_lastname) as fullname, ar.art_country, ar.art_city, ar.art_desc_art, 
                ar.user_id, ct.city_id, ct.city_name as city, cr.country_name as country 
                FROM ailee_art_reg as ar 
                LEFT JOIN ailee_art_category ac ON ac.category_id = ar.art_skill  
                LEFT JOIN ailee_cities as ct ON ct.city_id = ar.art_city 
                LEFT JOIN ailee_countries as cr ON cr.country_id = ar.art_country 
                WHERE ar.status = '1' AND ar.is_delete = '0' AND ar.art_step = '4'";
        if($category_id != ''){
            $sql .= " AND (ar.art_skill IN (". $category_id .")";
            if(isset($art_category) && !empty($art_category))
            {
                $sql .= " OR ar.art_skill IN (". implode(",", $art_category) .")";
            }
            $sql .= " )";
        }   
        
        if($location_id != ''){
            $sql .= " AND (ar.art_city IN (". $location_id .")";
            if(isset($art_location) && !empty($art_location))
            {
                $sql .= " OR ar.art_city IN (". implode(",", $art_location) .")";
            }
            $sql .= " )";
        }

        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();

        return $result_array;
    }

    function artistListLocationCategoryTotalRec($category_id = "",$location_id = "",$art_category = array(),$art_location = array()) {
        // $limit = ($limit == '') ? 5 : $limit;
        $sql = "SELECT ar.art_user_image, ar.profile_background, ar.slug, ar.other_skill, ac.art_category, CONCAT(ar.art_name, ' ', ar.art_lastname) as fullname, ar.art_country, ar.art_city, ar.art_desc_art, 
                ar.user_id, ct.city_id, ct.city_name as city, cr.country_name as country 
                FROM ailee_art_reg as ar 
                LEFT JOIN ailee_art_category ac ON ac.category_id = ar.art_skill  
                LEFT JOIN ailee_cities as ct ON ct.city_id = ar.art_city 
                LEFT JOIN ailee_countries as cr ON cr.country_id = ar.art_country 
                WHERE ar.status = '1' AND ar.is_delete = '0' AND ar.art_step = '4'";
        if($category_id != ''){
            $sql .= " AND (ar.art_skill IN (". $category_id .")";
            if(isset($art_category) && !empty($art_category))
            {
                $sql .= " OR ar.art_skill IN (". implode(",", $art_category) .")";
            }
            $sql .= " )";
        }   
        
        if($location_id != ''){
            $sql .= " AND (ar.art_city IN (". $location_id .")";
            if(isset($art_location) && !empty($art_location))
            {
                $sql .= " OR ar.art_city IN (". implode(",", $art_location) .")";
            }
            $sql .= " )";
        }
        if($limit){
            $sql .= " Limit ". $limit;   
        }
        // echo $sql;exit;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();

        return count($result_array);
    }

    // new artist search result
    function searchArtistData($keyword = '', $location = '',  $category_id = '',$location_id = '',$page = 0,$limit = '5'){
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
                $sqlkeyword .= " ar.art_name LIKE '". $val ."' OR ar.art_lastname LIKE '". $val ."' OR CONCAT(ar.art_name, ' ',ar.art_lastname) LIKE '". $val ."' OR ar.art_skill_txt LIKE '". $val ."'";
            }
        }

        if($category_id != ""){
            $sqlcategoryfilter = ($sqlkeyword == "") ? " AND " : " OR ";
            $sqlcategoryfilter .= "ar.art_skill IN (". $category_id .")";
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
                $sqllocation .= " ar.city_name LIKE '". $val ."'
                    OR ar.country_name LIKE '". $val ."'
                    OR ar.state_name LIKE '". $val ."'";
            }
        }
        
        if($location_id != ""){
            $sqllocationfilter = ($sqllocation == "") ? " AND " : " OR ";
            $sqllocationfilter .= "ar.art_city IN (". $location_id .")";  
            $sqllocationfilter .= ($sqllocation != "") ? ")" : ""; 
        }else{
            $sqllocationfilter = ($sqllocation != "") ? ")" : ""; 

        }

        $tot_sql = $sql = "SELECT ar.art_id,ar.art_user_image,ar.profile_background,ar.slug,ar.other_skill,ar.art_skill, CONCAT(ar.art_name,' ',ar.art_lastname) as fullname,ar.art_country,ar.art_city,
            ar.art_desc_art,ar.user_id,ar.art_skill_txt as art_category,ar.city_name as city,ar.country_name as country
            from ailee_art_reg_search_tmp ar                
            WHERE ar.status = '1' AND ar.is_delete = '0' AND ar.art_step = '4'"
            . $sqlkeyword .$sqlcategoryfilter . $sqllocation . $sqllocationfilter;    

        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        // echo $sql;
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        // echo $this->db->last_query();
        // exit;
        $query2 = $this->db->query($tot_sql);
        $total_record = $query2->num_rows();

        $ret_arr = array("seach_artist"=>$result_array,"total_record"=>$total_record);
        return $ret_arr;
    }

     // new artist search suggetion
    function artistic_search_keyword($keyword = ''){
        $keyword = urldecode($keyword) . '%';
        $sql = "SELECT art_category as value FROM ailee_art_category 
                WHERE status = '1' AND (art_category LIKE '". $keyword ."') 
                GROUP BY art_category 
                Union all
                SELECT CONCAT(art_name, ' ',art_lastname) as value 
                FROM ailee_art_reg 
                WHERE status = '1' AND art_name LIKE '". $keyword . "' OR 
                CONCAT(art_name, ' ',art_lastname) LIKE '". $keyword ."' 
                GROUP BY CONCAT(art_name, ' ',art_lastname)";
            $query = $this->db->query($sql);
            $result_array = $query->result_array();
            return $result_array;
    }

    function get_artist_by_categories($page = 0,$limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        
        $sql = "SELECT count(ar.art_id) as count, ct.category_id, ct.art_category, ct.category_slug
                FROM ailee_art_category ct,ailee_art_reg ar
                WHERE ct.category_id != 26 AND FIND_IN_SET(ct.category_id,ar.art_skill) > 0 AND ct.status = '1' 
                AND ct.type = '1' AND ar.status = '1' AND ar.art_step = '4' AND ar.is_delete = '0'
                GROUP BY ct.category_id ORDER BY count DESC";

        if($limit != '') {
            $sql .= " LIMIT $start,$limit";
        }
        $query = $this->db->query($sql);
        $result_array['art_cat'] = $query->result_array();
        $result_array['total_record'] = $this->get_artist_category_total_rec();

        return $result_array;
    }

    function get_artist_category_total_rec() {
        $sql = "SELECT count(ar.art_id) as count, ct.category_id, ct.art_category, ct.category_slug
                FROM ailee_art_category ct,ailee_art_reg ar
                WHERE FIND_IN_SET(ct.category_id,ar.art_skill) > 0 AND ct.status = '1' 
                AND ct.type = '1' AND ar.status = '1' AND ar.art_step = '4' AND ar.is_delete = '0'
                GROUP BY ct.category_id ORDER BY count DESC";
        $query = $this->db->query($sql);
        $totalcount = count($query->result_array());
        return $totalcount;
    }

    function get_artist_city($page = 1, $limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $sql = "SELECT count(ar.art_id) as count, ar.art_city as location_id, ac.city_name as art_location, ac.slug as location_slug
                FROM ailee_cities ac 
                LEFT JOIN ailee_art_reg ar ON ar.art_city = ac.city_id
                WHERE ac.status = '1' AND ar.status = '1'
                AND ar.art_step = '4' 
                GROUP BY ar.art_city 
                ORDER BY count DESC";

        $total_query = $this->db->query($sql);
        $totalartistLocation = $total_query->result_array();   
        $result_array['total_record'] = count($totalartistLocation);
        
        if($limit != ''){
            $sql .= " LIMIT ". $start . "," . $limit;
        }
        $query = $this->db->query($sql);
        $businessLocation = $query->result_array();   
        $result_array['art_loc'] = $businessLocation;
        return $result_array;
    }

    function art_related_blog_list() {
        $sql = "SELECT * FROM ailee_blog
                WHERE status='publish' AND
                blog_slug = 'aileensoul-a-unique-platform-to-showcase-your-artistic-sensibilities' 
                OR blog_slug = 'show-your-art-to-the-world'
                OR blog_slug = 'art-to-awaken-your-soul'";

        $query = $this->db->query($sql);
        $result_array = $query->result_array();   
        return $result_array;
    }

    function getCategoryNames($category)
    {
        $sql = "SELECT GROUP_CONCAT(DISTINCT(art_category)) as category_name FROM ailee_art_category WHERE category_id != 26 AND category_id IN (".$category.")";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array['category_name'];
    }

    function art_create_search_table()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        echo "<pre>";
        $sql = "SELECT * from ailee_art_reg WHERE status = '1' AND is_delete = '0' AND art_step = '4'";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();        
        foreach ($result_array as $key => $value) {            
            if($value['art_skill'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$value['art_skill']) as $skk => $skv) {
                    if($skv != "" && $skv != "26")
                    {
                        $s_name = $this->db->get_where('art_category', array('category_id' => $skv, 'status' => '1' , 'type'=> '1'))->row()->art_category;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }

                    if($skv != "" && $skv == "26")
                    {                        
                        $os_name = $this->db->get_where('art_other_category', array('other_category_id' => $value['other_skill'], 'status' => '1' , 'is_delete' => '0'))->row()->other_category;                        
                        if(trim($os_name) != "")
                        {
                            $skill_name .= $os_name.",";
                        }
                        $skill_name;
                    }
                }
                $value['art_skill_txt'] = trim($skill_name,",");
            }
            if(trim($value['art_country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $value['art_country'], 'status' => '1'))->row()->country_name;

                $value['country_name'] = trim($country_name);
            }

            if(trim($value['art_state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $value['art_state'], 'status' => '1'))->row()->state_name;

                $value['state_name'] = trim($state_name);
            }

            if(trim($value['art_city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $value['art_city'], 'status' => '1'))->row()->city_name;

                $value['city_name'] = trim($city_name);
            }
            $this->db->insert('ailee_art_reg_search_tmp', $value);
        }
        echo "Done";
    }

    public function get_url($userid) {

        $contition_array = array('user_id' => $userid, 'status' => '1');
        $arturl = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_city,art_skill,other_skill,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        return $arturl[0]['slug'];

        $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;

        $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;

        $category = $arturl[0]['art_skill'];
        $category = explode(',', $category);

        foreach ($category as $catkey => $catval) {
            $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
            $categorylist[] = $art_category;
        }

        $listfinal1 = array_diff($categorylist, array('other'));
        $listFinal = implode('-', $listfinal1);

        if (!in_array(26, $category)) {
            $category_url = $this->common->clean($listFinal);
        } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

            $trimdata = $this->common->clean($listFinal) . '-' . $this->common->clean($art_othercategory);
            $category_url = trim($trimdata, '-');
        } else {
            $category_url = $this->common->clean($art_othercategory);
        }

        $city_get = $this->common->clean($city_url);

        if (!$city_get) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $arturl[0]['art_id'];
        } else if (!$category_url) {
            $url = $arturl[0]['slug'] . '-' . $city_get . '-' . $arturl[0]['art_id'];
        } else if ($city_get && $category_url) {
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
        }
        return $url;
    }

    // Get data of artistic dashboard post 
    function get_artist_dashboard_post($userid,$page,$limit = '4'){        
        // Start limit
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;        

        $sql = "SELECT ar.art_user_image, ar.art_name, ar.art_lastname, ar.art_skill, ar.slug, ap.art_post_id, ap.art_post, ar.user_id, ar.designation, ar.art_skill, ap.art_description, ap.art_likes_count, ap.art_like_user, ap.created_date, ap.posted_user_id
            FROM ailee_art_post as ap
            JOIN ailee_art_reg as ar ON ar.user_id=ap.user_id 
            WHERE ap.user_id = '".$userid."' 
            AND ap.is_delete = '0' 
            AND ap.status = '1' 
            AND ar.status = '1' 
            AND ar.is_delete = '0' 
            ORDER BY ap.art_post_id DESC";
            if($limit != '') {
                $sql .= " LIMIT $start,$limit";
            }

            $query = $this->db->query($sql);
            $result_array = $query->result_array();
            return $result_array;
    } 

    // Get count of artistic dashboard post data 
    function get_artist_dashboard_count($userid){        
        $sql = "SELECT count(*) as total_record
            FROM ailee_art_post as ap
            JOIN ailee_art_reg as ar ON ar.user_id=ap.user_id 
            WHERE ap.user_id = '".$userid."' 
            AND ap.is_delete = '0' 
            AND ap.status = '1'
            AND ar.status = '1' 
            AND ar.is_delete = '0' 
            ORDER BY ap.art_post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row()->total_record;
        return $result_array;
    }
    
    public function set_user_education($userid,$edu_school_college = "",$edu_university = "",$edu_other_university = "",$edu_degree = "",$edu_stream = "",$edu_other_degree = "",$edu_other_stream = "",$edu_start_date = "",$edu_end_date = "",$edu_nograduate = "",$edu_file = "",$edit_edu = 0)
    {
        if($edit_edu == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'edu_school_college' => trim($edu_school_college),
                'edu_university' => trim($edu_university),
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
            $insert_id = $this->common->insert_data($data, 'art_user_education');
            return $insert_id;
        }
        else
        {
            $data = array(
                'edu_school_college' => trim($edu_school_college),
                'edu_university' => trim($edu_university),
                'edu_other_university' => $edu_other_university,
                'edu_degree' => $edu_degree,
                'edu_other_degree' => $edu_other_degree,
                'edu_stream' => $edu_stream,
                'edu_other_stream' => $edu_other_stream,
                'edu_start_date' => $edu_start_date,
                'edu_end_date' => $edu_end_date,
                'edu_nograduate' => $edu_nograduate,
                'edu_file' => $edu_file,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_education', $edit_edu);
            $this->db->update('art_user_education', $data);
            return true;
        }
    }

    public function delete_user_education($userid,$edu_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_education', $edu_id);
            $this->db->update('art_user_education', $data);
            return true;
    }

    public function get_user_education($userid)
    {
        $this->db->select("jue.id_education, jue.user_id, jue.edu_school_college, jue.edu_university, jue.edu_other_university, jue.edu_degree, jue.edu_other_degree, jue.edu_stream, jue.edu_other_stream, jue.edu_start_date, jue.edu_end_date, jue.edu_nograduate, jue.edu_file, jue.status, jue.created_date, jue.modify_date, d.degree_name, s.stream_name, u.university_name, DATE_FORMAT(CONCAT(jue.edu_start_date,'-1'),'%b %Y') as start_date_str, DATE_FORMAT(CONCAT(jue.edu_end_date,'-1'),'%b %Y') as end_date_str")->from("art_user_education jue");
        $this->db->join('degree d', 'd.degree_id = jue.edu_degree', 'left');
        $this->db->join('stream s', 's.stream_id = jue.edu_stream', 'left');
        $this->db->join('university u', 'u.university_id = jue.edu_university', 'left');
        $this->db->where('jue.user_id', $userid);
        $this->db->where('jue.status', '1');
        $this->db->order_by('jue.created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function set_user_addicourse($userid,$addicourse_name = "",$addicourse_org = "",$addicourse_start_date = "",$addicourse_end_date = "",$addicourse_url = "",$addicourse_document = "",$edit_addicourse = 0)
    {
        if($edit_addicourse == 0)
        {            
            $data = array(
                'user_id' => $userid,
                'addicourse_name' => trim($addicourse_name),
                'addicourse_org' => $addicourse_org,
                'addicourse_start_date' => $addicourse_start_date,
                'addicourse_end_date' => $addicourse_end_date,
                'addicourse_url' => $addicourse_url,
                'addicourse_file' => $addicourse_document,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'art_user_addicourse');
            return $insert_id;
        }
        else
        {
            $data = array(
                'addicourse_name' => trim($addicourse_name),
                'addicourse_org' => $addicourse_org,
                'addicourse_start_date' => $addicourse_start_date,
                'addicourse_end_date' => $addicourse_end_date,
                'addicourse_url' => $addicourse_url,
                'addicourse_file' => $addicourse_document,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_addicourse', $edit_addicourse);
            $this->db->update('art_user_addicourse', $data);
            return true;
        }
    }

    public function delete_user_addicourse($userid,$addicourse_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_addicourse', $addicourse_id);
            $this->db->update('art_user_addicourse', $data);
            return true;
    }

    public function get_user_addicourse($userid)
    {
        $this->db->select("jua.*,DATE_FORMAT(CONCAT(jua.addicourse_start_date,'-1'),'%b %Y') as start_date_str, DATE_FORMAT(CONCAT(jua.addicourse_end_date,'-1'),'%b %Y') as end_date_str")->from("art_user_addicourse jua");
        $this->db->where('jua.user_id', $userid);
        $this->db->where('jua.status', '1');
        $this->db->order_by('jua.created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function set_user_award($userid,$award_title = "",$award_org = "",$award_date = "",$award_desc = "",$award_document = "",$edit_awards = 0)
    {
        if($edit_awards == 0)
        {
            $data = array(
                'user_id' => $userid,
                'award_title' => trim($award_title),
                'award_org' => $award_org,
                'award_date' => $award_date,
                'award_desc' => $award_desc,
                'award_file' => $award_document,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'art_user_award');
            return $insert_id;
        }
        else
        {
            $data = array(
                'award_title' => trim($award_title),
                'award_org' => $award_org,
                'award_date' => $award_date,
                'award_desc' => $award_desc,
                'award_file' => $award_document,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_award', $edit_awards);
            $this->db->update('art_user_award', $data);
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
            $this->db->update('art_user_award', $data);
            return true;
    }

    public function get_user_award($userid)
    {
        $this->db->select("jua.*,DATE_FORMAT(jua.award_date,'%d %b %Y') as award_date_str")->from("art_user_award jua");
        $this->db->where('jua.user_id', $userid);
        $this->db->where('jua.status', '1');
        $this->db->order_by('jua.created_date',"desc");
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
                'exp_company_name' => trim($exp_company_name),
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
            $insert_id = $this->common->insert_data($data, 'art_user_experience');
            $data1 = array(
                'exp_y' => $expy,
                'exp_m' => $expm,
                'experience' => "Experience"
            );
            $this->db->where('user_id', $userid);            
            $this->db->update('job_reg', $data1);

            return $insert_id;
        }
        else
        {
            $data = array(
                'exp_company_name' => trim($exp_company_name),
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
            $this->db->update('art_user_experience', $data);
            $data1 = array(
                'exp_y' => $expy,
                'exp_m' => $expm,
                'experience' => "Experience"
            );
            $this->db->where('user_id', $userid);            
            $this->db->update('job_reg', $data1);
            return true;
        }
    }

    public function delete_user_experience($userid,$exp_id)    
    {
        $data = array(                
                'status' => "0",
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_experience', $exp_id);
            $this->db->update('art_user_experience', $data);
            return true;
    }

    public function get_user_experience($userid)
    {

        $this->db->select("jue.id_experience, jue.user_id, jue.exp_company_name, jue.exp_designation,jt.name as designation, jue.exp_company_website, jue.exp_field, jue.exp_other_field, jue.exp_country, jue.exp_state, jue.exp_city, jue.exp_start_date, jue.exp_end_date, DATE_FORMAT(CONCAT(jue.exp_start_date,'-1'),'%b %Y') as start_date_str,DATE_FORMAT(CONCAT(jue.exp_end_date,'-1'),'%b %Y') as end_date_str,jue.exp_isworking, jue.exp_desc, jue.exp_file, jue.status, jue.created_date, jue.modify_date,cr.country_name,st.state_name,ct.city_name")->from("art_user_experience jue");
        $this->db->join('countries cr', 'cr.country_id = jue.exp_country', 'left');
        $this->db->join('states st', 'st.state_id = jue.exp_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = jue.exp_city', 'left');
        $this->db->join('job_title jt', 'jt.title_id = jue.exp_designation', 'left');
        $this->db->where('jue.user_id', $userid);
        $this->db->where('jue.status', '1');
        // $this->db->where('FIND_IN_SET(jt.title_id, jue.exp_designation) !=', 0);
        // $this->db->group_by('jue.exp_designation,jue.id_experience');
        $this->db->order_by('jue.created_date',"desc");
        $query = $this->db->get();
        $user_data_exp = $query->result_array();        
        return $user_data_exp;
    }

    public function save_portfolio($userid,$portfolio_title = "",$portfolio_desc = "",$portfolio_file = "",$edit_portfolio_id = 0)
    {
        if($edit_portfolio_id == 0)
        {
            $data = array(
                'user_id' => $userid,
                'portfolio_title' => trim($portfolio_title),
                'portfolio_desc' => $portfolio_desc,                
                'portfolio_file' => $portfolio_file,                
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'art_user_portfolio');
            return $insert_id;
        }
        else
        {
            $data = array(
                'portfolio_title' => trim($portfolio_title),
                'portfolio_desc' => $portfolio_desc,                
                'portfolio_file' => $portfolio_file,
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $this->db->where('user_id', $userid);
            $this->db->where('id_portfolio', $edit_portfolio_id);
            $this->db->update('art_user_portfolio', $data);
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
            $this->db->update('art_user_portfolio', $data);
            return true;
    }

    public function get_portfolio($userid)
    {
        $this->db->select("*")->from("art_user_portfolio");
        $this->db->where('user_id', $userid);
        $this->db->where('status', '1');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_links($userid)
    {
        $this->db->select("*")->from("art_user_links");
        $this->db->where('user_id', $userid);
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_social_links($userid)
    {
        $this->db->select("*")->from("art_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type != ','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_personal_links($userid)
    {
        $this->db->select("*")->from("art_user_links");
        $this->db->where('user_id', $userid);
        $this->db->where('user_links_type','Personal');
        $this->db->order_by('created_date',"desc");
        $query = $this->db->get();
        $user_data_links = $query->result_array();        
        return $user_data_links;
    }

    public function get_user_languages($userid)
    {
        $this->db->select("user_id,language_txt as language_name,proficiency,status")->from("art_user_languages");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $user_data_lang = $query->result_array();        
        return $user_data_lang;
    }

    public function get_user_bio($userid)
    {
        $this->db->select("art_desc_art")->from("art_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['art_desc_art'];
    }

    public function get_user_specialities($userid)
    {
        $this->db->select("art_spl_tags,art_spl_desc")->from("art_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $return_array = $query->row_array();        
        return $return_array;
    }

    public function get_user_soft_inst_skill_data($userid)
    {
        $this->db->select("art_soft_inst_skill")->from("art_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['art_soft_inst_skill'];
    }

    public function get_user_talent_cat_data($userid)
    {
        $this->db->select("art_talent_category")->from("art_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['art_talent_category'];
    }

    public function get_user_art_imp_data($userid)
    {
        $this->db->select("art_active_status")->from("art_reg");
        $this->db->where('user_id', $userid);
        $query = $this->db->get();
        $about_user_data = $query->row_array();        
        return $about_user_data['art_active_status'];
    }

    public function get_artist_basic_info($userid)
    {
        $this->db->select("a.art_name,a.art_lastname,a.art_skill,a.other_skill,a.art_gender,a.art_email,a.art_phnno,a.art_dob,a.art_country,a.art_state,a.art_city,oc.other_category as other_category_txt,GROUP_CONCAT(DISTINCT(ac.art_category)) as art_category_txt,DATE_FORMAT(a.art_dob,'%d/%M/%Y') as art_dob_txt, cr.country_name, st.state_name, ct.city_name")->from("art_reg a,art_category ac");
        $this->db->join('countries cr', 'cr.country_id = a.art_country', 'left');
        $this->db->join('states st', 'st.state_id = a.art_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = a.art_city', 'left');
        $this->db->join('art_other_category oc', 'oc.other_category_id = a.other_skill', 'left');
        $this->db->where(array('a.user_id' => $userid, 'a.is_delete' => '0', 'a.status' => '1'));
        $this->db->where('FIND_IN_SET(ac.category_id, a.art_skill) !=', 0);
        $this->db->group_by('a.art_skill,a.art_id');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function art_basic_info_save($user_id, $art_fname = "", $art_lname = "", $art_email = "", $art_gender = "", $birth_date = "", $art_phnno = "", $art_basic_country = "", $art_basic_state = "", $art_basic_city = "", $category = "", $art_other_category_id = "")
    {
        $data = array(                
            'art_name' => trim($art_fname),
            'art_lastname' => trim($art_lname),
            'art_email' => trim($art_email),
            'art_gender' => $art_gender,
            'art_dob' => $birth_date,
            'art_phnno' => $art_phnno,
            'art_country' => $art_basic_country,
            'art_state' => $art_basic_state,
            'art_city' => $art_basic_city,
            'art_skill' => $category,
            'other_skill' => $art_other_category_id,
            'modified_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('art_reg', $data);

        $skill_name = "";
        foreach (explode(',',$data['art_skill']) as $skk => $skv) {
            if($skv != "" && $skv != "26")
            {
                $s_name = $this->db->get_where('art_category', array('category_id' => $skv, 'status' => '1' , 'type'=> '1'))->row()->art_category;
                if(trim($s_name) != "")
                {
                    $skill_name .= $s_name.",";
                }
            }

            if($skv != "" && $skv == "26")
            {                        
                $os_name = $this->db->get_where('art_other_category', array('other_category_id' => $data['other_skill'], 'status' => '1' , 'is_delete' => '0'))->row()->other_category;                        
                if(trim($os_name) != "")
                {
                    $skill_name .= $os_name.",";
                }
                $skill_name;
            }
        }
        $data['art_skill_txt'] = trim($skill_name,",");        
        $this->db->where('user_id', $user_id);
        $this->db->update('art_reg_search_tmp', $data);
        return true;
    }

    public function get_artist_preferred_info($userid)
    {
        $this->db->select("a.preffered_skills, a.preffered_country, a.preffered_state, a.preffered_city, a.preffered_availability, cr.country_name as preffered_country_name, st.state_name as preffered_state_name, ct.city_name as preffered_city_name")->from("art_reg a,art_category ac");
        $this->db->join('countries cr', 'cr.country_id = a.preffered_country', 'left');
        $this->db->join('states st', 'st.state_id = a.preffered_state', 'left');
        $this->db->join('cities ct', 'ct.city_id = a.preffered_city', 'left');
        $this->db->where(array('a.user_id' => $userid, 'a.is_delete' => '0', 'a.status' => '1'));
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    public function art_preferred_info_save($user_id,$category = "",$art_other_category_id = "",$preferred_skill_tags = "",$art_preffered_country = "",$art_preffered_state = "",$art_preffered_city = "",$preffered_availability = "")
    {
        $data = array(
            'preffered_skills' => trim($preferred_skill_tags),
            'preffered_country' => $art_preffered_country,
            'preffered_state' => $art_preffered_state,
            'preffered_city' => $art_preffered_city,
            'preffered_availability' => $preffered_availability,
            'art_skill' => $category,
            'other_skill' => $art_other_category_id,
            'modified_date' => date('Y-m-d H:i:s', time()),
        );
        $this->db->where('user_id', $user_id);
        $this->db->update('art_reg', $data);

        $skill_name = "";
        foreach (explode(',',$data['art_skill']) as $skk => $skv) {
            if($skv != "" && $skv != "26")
            {
                $s_name = $this->db->get_where('art_category', array('category_id' => $skv, 'status' => '1' , 'type'=> '1'))->row()->art_category;
                if(trim($s_name) != "")
                {
                    $skill_name .= $s_name.",";
                }
            }

            if($skv != "" && $skv == "26")
            {                        
                $os_name = $this->db->get_where('art_other_category', array('other_category_id' => $data['other_skill'], 'status' => '1' , 'is_delete' => '0'))->row()->other_category;                        
                if(trim($os_name) != "")
                {
                    $skill_name .= $os_name.",";
                }
                $skill_name;
            }
        }
        $data['art_skill_txt'] = trim($skill_name,",");        
        $this->db->where('user_id', $user_id);
        $this->db->update('art_reg_search_tmp', $data);
        return true;
    }

    public function get_artist_follower_count($art_id)
    {
        $this->db->select("COUNT(*) as follower_count")->from("follow f");
        $this->db->join('art_reg a', 'a.art_id = f.follow_from', 'left');
        $this->db->where('a.status', '1');
        $this->db->where('a.is_delete', '0');
        $this->db->where('f.follow_type', '1');
        $this->db->where('f.follow_to', $art_id);
        $this->db->where('f.follow_status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['follower_count'];
    }

    public function get_artist_following_count($art_id)
    {
        $this->db->select("COUNT(*) as following_count")->from("follow f");
        $this->db->join('art_reg a', 'a.art_id = f.follow_to', 'left');
        $this->db->where('a.status', '1');
        $this->db->where('a.is_delete', '0');
        $this->db->where('f.follow_type', '1');
        $this->db->where('f.follow_from', $art_id);
        $this->db->where('f.follow_status', '1');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['following_count'];
    }
}
