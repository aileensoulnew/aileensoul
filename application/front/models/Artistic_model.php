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

            return $result_array;
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
}
