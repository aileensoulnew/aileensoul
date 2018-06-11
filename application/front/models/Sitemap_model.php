<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap_model extends CI_Model {

    function getJobDataByLocation() {
        $this->db->select('rp.city,rp.post_name,rp.post_id,rp.user_id,c.city_name,r.re_comp_name')->from('rec_post rp');
        $this->db->join('cities c', 'rp.city = c.city_id');
        $this->db->join('recruiter r', 'rp.user_id = r.user_id');
        $this->db->where(array('rp.status' => '1', 'rp.is_delete' => '0'));
        $query = $this->db->get();
        $result = $query->result_array();
        echo $this->db->last_query();
        exit;
        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['city_name']][$key] = $value; // sort as per category name
            if (is_numeric($value['post_name'])) {
                $newArray[$value['city_name']][$key]['post_name'] = $this->db->select('name')->get_where('job_title', array('title_id' => $value['post_name']))->row('name');
            }
        }
        return $newArray;
    }

    function getJobseekers() {
        $this->db->select('jr.fname,jr.lname,jr.slug,ji.industry_name')->from('job_reg jr');
        $this->db->join('job_industry ji', 'jr.work_job_industry = ji.industry_id');
        $this->db->where(array('jr.job_step' => '10', 'jr.is_delete' => '0', 'jr.status' => '1'));
        $query = $this->db->get();
        $result = $query->result_array();

        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['industry_name']][$key] = $value; // sort as per category name
        }
        return $newArray;
    }

    function getRecruiter() {
        $this->db->select('user_id,rec_firstname,rec_lastname,re_comp_name')->from('recruiter');
        $this->db->where(array('re_step' => '3', 'is_delete' => '0', 're_status' => '1'));
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    function getEmployees() {
        $this->db->select('fhr.username,fhr.fullname,fhr.freelancer_hire_slug')->from('freelancer_hire_reg fhr');
        $this->db->where(array('fhr.free_hire_step' => '3', 'fhr.is_delete' => '0', 'fhr.status' => '1'));
        $query = $this->db->get();
        return $result = $query->result_array();
    }

    function getFreelancers() {
        $this->db->select('fpr.freelancer_post_fullname,fpr.freelancer_post_username,fpr.freelancer_apply_slug,c.category_name')->from('freelancer_post_reg fpr');
        $this->db->join('category c', 'fpr.freelancer_post_field = c.category_id');
        $this->db->where(array('fpr.free_post_step' => '7', 'fpr.is_delete' => '0', 'fpr.status' => '1'));
        $query = $this->db->get();
        $result = $query->result_array();

        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['category_name']][$key] = $value; // sort as per category name
        }
        return $newArray;
    }

    function getFreepostDataByCategory() {
        $this->db->select('fp.post_id,fp.post_name,fp.user_id,fh.username,fh.fullname,ci.city_name,c.category_name')->from('freelancer_post fp');
        $this->db->join('category c', 'fp.post_field_req = c.category_id');
        $this->db->join('freelancer_hire_reg fh', 'fp.user_id = fh.user_id');
        $this->db->join('cities ci', 'fp.city = ci.city_id', 'left');
        $this->db->where(array('fp.status' => '1', 'fp.is_delete' => '0'));
        $query = $this->db->get();
        $result = $query->result_array();
        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['category_name']][] = $value; // sort as per category name
        }
        return $newArray;
    }

    function getBusinessDataByCategory() {
        $this->db->select('bc.industry_name,b.company_name,b.business_slug,b.other_industrial')->from('industry_type bc');
        $this->db->join('business_profile b', 'b.industriyal = bc.industry_id');
        $this->db->where(array('bc.status' => '1', 'bc.is_delete' => '0', 'b.status' => '1', 'b.is_deleted' => '0', 'b.business_step' => '4'));
        $query = $this->db->get();
        $result = $query->result_array();

        $this->db->select('b.company_name,b.business_slug,b.other_industrial')->from('business_profile b');
        $this->db->where(array('b.status' => '1', 'b.is_deleted' => '0', 'b.business_step' => '4', 'b.industriyal' => '0'));
        $query1 = $this->db->get();
        $result1 = $query1->result_array();

        $newArray = array();
        foreach ($result as $key => $value) {
            $newArray[$value['industry_name']][] = $value; // sort as per category name
        }
        $newArray['Other'] = $result1;

        return $newArray;
    }

    function getArtistDataByCategory() {
        $this->db->select('a.art_name,a.art_lastname,a.art_skill,a.other_skill,a.user_id')->from('art_reg a');
        $this->db->where(array('a.status' => '1', 'a.is_delete' => '0', 'a.art_step' => '4'));
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as $key => $value) {
            $art_skill = $value['art_skill'];
            $other_skill = $value['other_skill'];
            if ($art_skill) {
                $art_skill = explode(',', $art_skill);
                $category_name = '';
                foreach ($art_skill as $key1 => $skill) {
                    $category_name .= $this->db->select('art_category')->get_where('art_category', array('category_id' => $skill))->row('art_category');
                    $category_name .= ', ';
                }
                $category_name = trim($category_name, ', ');
                $result[$key]['art_skill'] = $category_name;
            }
            if ($other_skill) {
                $other_name = '';
                $other_name .= $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $other_skill))->row('other_category');
                $other_name = trim($other_name, ',');
                $result[$key]['other_skill'] = $other_name;
            }
            //GET LINK 
            $user_id = $value['user_id'];

            $this->db->select('art_id,art_city,art_skill,other_skill,slug')->from('art_reg');
            $this->db->where(array('user_id' => $user_id, 'status' => '1'));
            $query = $this->db->get();
            $arturl = $query->result_array();

            $city_url = $this->db->select('city_name')->get_where('cities', array('city_id' => $arturl[0]['art_city'], 'status' => '1'))->row()->city_name;
            $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $arturl[0]['other_skill']))->row()->other_category;
            $category = $arturl[0]['art_skill'];
            $category = explode(',', $category);
            $categorylist = array();
            foreach ($category as $catkey => $catval) {
                $art_category = $this->db->select('art_category')->get_where('art_category', array('category_id' => $catval))->row()->art_category;
                $categorylist[] = $art_category;
            }

            $listfinal1 = array_diff($categorylist, array('other'));
            $listFinal = implode('-', $listfinal1);

            if (!in_array(26, $category)) {
                $category_url = $this->cleaning($listFinal);
            } else if ($arturl[0]['art_skill'] && $arturl[0]['other_skill']) {

                $trimdata = $this->cleaning($listFinal) . '-' . $this->cleaning($art_othercategory);
                $category_url = trim($trimdata, '-');
            } else {
                $category_url = $this->cleaning($art_othercategory);
            }

            $city_get = $this->cleaning($city_url);
            $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];
            $result[$key]['get_url'] = $url;
        }

        return $result;
    }

    function cleaning($string) {

        $string = str_replace(' ', '-', $string);  // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // replace double --- in single -

        return preg_replace('/-+/', '-', $string); // Removes special chars.
    }

    function get_artist_list($searchword = '',$start = 0, $limit = 100){
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND art_name like '". $searchword ."'";
        }
        $sql = "SELECT *, CONCAT(art_name, ' ', art_lastname) as art_fullname
                FROM ailee_art_reg 
                WHERE status = '1'
                AND art_step = '4' AND is_delete = '0'". $search_query ." ORDER BY art_id DESC";
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        foreach ($result_array as $key => $value) {
            $skills = explode(",", $value['art_skill']);            
            $pos = array_search('26',$skills);
            if($pos > -1)
            {                
                unset($skills[$pos]);
                $value['art_skill'] = implode(",",$skills);
            }
            $category_name = "";
            $other_category = "";
            if($value['art_skill'] != "")
            {
                $sql = "SELECT group_concat(art_category) as category_name FROM ailee_art_category 
                    WHERE category_id IN (". $value['art_skill'] .")";
                $query = $this->db->query($sql);
                $category_name = $query->row_array()['category_name'];
            }
            if($value['other_skill'] != "")
            {
                $sql = "SELECT other_category FROM ailee_art_other_category
                    WHERE other_category_id = ". $value['other_skill'] ."";
                $query = $this->db->query($sql);
                $other_category = $query->row_array()['other_category'];
            }
            $result_array[$key]['category_name'] = trim($category_name.",".$other_category,",");
            
        }
        return $result_array;
    }

    public function get_artist_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND art_name like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_artist FROM ailee_art_reg 
                WHERE status = '1' AND art_step = '4'"
                . $search_query;
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    function get_company_list($searchword = '',$start = 0, $limit = 100){
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND company_name like '". $searchword ."'";
        }
        $sql = "SELECT bp.*, 
                IF (bp.city IS NULL, concat(bp.business_slug, '-', st.state_name) ,concat(bp.business_slug, '-', ct.city_name)) as business_slug, 
                IF (bp.industriyal = 0, bp.other_industrial , it.industry_name) as bus_industry_name
                FROM ailee_business_profile bp
                LEFT JOIN ailee_industry_type it on it.industry_id = bp.industriyal
                LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
                LEFT JOIN ailee_states st ON st.state_name = bp.state 
                WHERE bp.status = '1'
                AND business_step = '4' AND bp.is_deleted = '0'". $search_query ." ORDER BY business_profile_id DESC";
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_company_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND company_name like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec FROM ailee_business_profile bp
                LEFT JOIN ailee_business_type bt on bt.type_id = bp.business_type
                WHERE bp.status = '1'
                AND business_step = '4' AND bp.is_deleted = '0'". $search_query ." ORDER BY business_profile_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }


    function get_job_list($searchword = '',$start = 0, $limit = 100){
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND jt.name like '". $searchword ."'";
        }
        $sql = "SELECT rp.post_id,rp.city, jt.name as post_name, rp.post_id, 
                IFNULL(jt.name, rp.post_name) as string_post_name,
                rp.user_id, r.re_comp_name, rp.user_id as post_user_id, c.city_name 
                FROM ailee_rec_post rp 
                LEFT JOIN ailee_job_title jt on rp.post_name = jt.title_id
                LEFT JOIN ailee_cities c on c.city_id = rp.city
                JOIN ailee_recruiter r ON rp.user_id = r.user_id 
                WHERE rp.status = '1' AND rp.is_delete = '0'". $search_query ." ORDER BY rp.post_id DESC";
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_job_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND jt.name like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec
                FROM ailee_rec_post rp 
                LEFT JOIN ailee_job_title jt on rp.post_name = jt.title_id
                JOIN ailee_recruiter r ON rp.user_id = r.user_id 
                WHERE rp.status = '1' AND rp.is_delete = '0'". $search_query ." ORDER BY rp.post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    } 

    function get_freelancer_list($searchword = '',$start = 0, $limit = 100){
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND post_name like '". $searchword ."'";
        }
        $sql = "SELECT fp.*, c.*,fp.user_id as post_user_id 
                FROM ailee_freelancer_post fp
                LEFT JOIN ailee_category c on fp.post_field_req = c.category_id 
                WHERE fp.is_delete = '0' AND fp.status = '1'"
                . $search_query ." ORDER BY post_id DESC";
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_freelancer_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND post_name like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec 
                FROM ailee_freelancer_post fp
                LEFT JOIN ailee_category c on fp.post_field_req = c.category_id 
                WHERE fp.is_delete = '0' AND fp.status = '1'"
                . $search_query ." ORDER BY post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    function get_member_list($searchword = '',$start = 0, $limit = 100){

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND first_name like '". $searchword ."'";
        }
        $sql = "SELECT u.*, CONCAT(first_name, ' ', last_name) as fullname, 
                jt.name as designaation,d.degree_name
                FROM ailee_user u
                LEFT JOIN ailee_user_profession up on up.user_id = u.user_id
                LEFT JOIN ailee_job_title jt on up.designation = jt.title_id
                LEFT JOIN ailee_user_student us on us.user_id = u.user_id
                LEFT JOIN ailee_degree d on d.degree_id = us.current_study
                WHERE user_slug != '' AND (
                    u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_profession)
                    OR u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_student)
        )". $search_query ." ORDER BY u.user_id DESC";
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_member_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND first_name like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec 
                FROM aileensoul.ailee_user u
                LEFT JOIN ailee_user_profession up on up.user_id = u.user_id
                LEFT JOIN ailee_job_title jt on up.designation = jt.title_id
                WHERE user_slug != '' AND (
                    u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_profession)
                    OR u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_student)
                )"
                . $search_query ." ORDER BY u.user_id DESC";

        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

}
