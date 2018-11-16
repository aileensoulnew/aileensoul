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

    function get_artist_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

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
        return $result_array['total_artist'];
    }

    function get_company_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND company_name like '". $searchword ."'";
        }
        $sql = "SELECT bp.*, 
                IF (ct.city_name != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug, 
                IF (bp.industriyal = 0, bp.other_industrial , it.industry_name) as bus_industry_name
                FROM ailee_business_profile bp
                LEFT JOIN ailee_industry_type it on it.industry_id = bp.industriyal
                LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
                LEFT JOIN ailee_states st ON st.state_id = bp.state 
                LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
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
        return $result_array['total_rec'];
    }


    function get_job_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND jt.name like '". $searchword ."'";
        }
        $sql = "SELECT rp.post_id,rp.city, IF(jt.name != '',jt.name,rp.post_name) as post_name, rp.post_id,IFNULL(jt.name, rp.post_name) as string_post_name,rp.user_id, r.re_comp_name, rp.user_id as post_user_id, IF(c.city_name != '',c.city_name,IF(s.state_name != '',s.state_name,cn.country_name)) as city_name
                FROM ailee_rec_post rp 
                LEFT JOIN ailee_job_title jt on rp.post_name = jt.title_id
                LEFT JOIN ailee_cities c on c.city_id = rp.city
                LEFT JOIN ailee_states s on s.state_id = rp.state
                LEFT JOIN ailee_countries cn on cn.country_id = rp.country
                JOIN ailee_recruiter r ON rp.user_id = r.user_id 
                WHERE rp.status = '1' AND rp.is_delete = '0'". $search_query ." AND DATEDIFF(rp.post_last_date,NOW()) >= 0 ORDER BY rp.post_id DESC";
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
                WHERE rp.status = '1' AND rp.is_delete = '0'". $search_query ." AND DATEDIFF(rp.post_last_date,NOW()) >= 0 ORDER BY rp.post_id DESC";
        $query = $this->db->query($sql);
        //DATEDIFF(NOW(),fp.created_date) >= 0

        $result_array = $query->row_array();
        return $result_array['total_rec'];
    } 

    function get_freelancer_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

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
        return $result_array['total_rec'];
    }

    function get_opportunities_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND uo.opptitle like '". $searchword ."'";
        }
        
        $sql = "SELECT uo.post_id, up.user_id, uo.opportunity, it.industry_name as field_txt,uo.field,uo.other_field, uo.opptitle, uo.oppslug FROM ailee_user_opportunity uo LEFT JOIN ailee_industry_type it ON it.industry_id = uo.field LEFT JOIN ailee_user_post up ON up.id = uo.post_id WHERE up.status = 'publish' ". $search_query ." ORDER BY uo.id DESC";

        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_opportunities_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND uo.opptitle like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec 
                FROM ailee_user_opportunity uo LEFT JOIN ailee_user_post up ON up.id = uo.post_id WHERE up.status = 'publish'".$search_query." ORDER BY uo.id DESC";
                
        $query = $this->db->query($sql);
        
        $result_array = $query->row_array();
        return $result_array['total_rec'];
    }

    function get_article_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND a.article_title like '". $searchword ."'";
        }
        
        $sql = "SELECT a.article_title, a.article_featured_image, a.article_slug FROM ailee_post_article a LEFT JOIN ailee_user_post up ON up.post_id = a.id_post_article WHERE up.status = 'publish' AND up.is_delete = '0' AND up.post_for = 'article' ". $search_query ." ORDER BY up.post_id DESC";

        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_article_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND a.article_title like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec 
                FROM ailee_post_article a LEFT JOIN ailee_user_post up ON up.post_id = a.id_post_article WHERE up.status = 'publish' AND up.is_delete = '0' AND up.post_for = 'article' ".$search_query." ORDER BY up.post_id DESC";
                
        $query = $this->db->query($sql);
        
        $result_array = $query->row_array();
        return $result_array['total_rec'];
    }

    function get_questions_list($searchword = '',$page = 0, $limit = 100){
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND uaq.question like '". $searchword ."'";
        }
        
        $sql = "SELECT up.id,uaq.id as question_id,up.user_id, up.post_for, up.created_date, up.post_id, uaq.question, uaq.description FROM ailee_user_post up LEFT JOIN ailee_user_ask_question uaq ON uaq.post_id = up.id WHERE up.post_for = 'question' AND up.status = 'publish' AND up.is_delete = '0' ". $search_query ." ORDER BY up.id DESC";

        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }
        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    public function get_questions_list_total($searchword = '') {
        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND uaq.question like '". $searchword ."'";
        }
        $sql = "SELECT count(*) as total_rec 
                FROM ailee_user_post up LEFT JOIN ailee_user_ask_question uaq ON uaq.post_id = up.id WHERE up.post_for = 'question' AND up.status = 'publish' AND up.is_delete = '0' ".$search_query." ORDER BY up.post_id DESC";
                
        $query = $this->db->query($sql);
        
        $result_array = $query->row_array();
        return $result_array['total_rec'];
    }

    function get_member_list($searchword = '',$page = 0, $limit = 100){

        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $search_query = "";
        if($searchword != ""){
            $searchword = $searchword. '%';
            $search_query = " AND LOWER(first_name) like '". $searchword ."'";
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
            $search_query = " AND LOWER(first_name) like '". $searchword ."'";
        }
        $sql = "SELECT COUNT(*) AS total_rec 
                FROM ailee_user u
                LEFT JOIN ailee_user_profession up on up.user_id = u.user_id
                LEFT JOIN ailee_job_title jt on up.designation = jt.title_id
                LEFT JOIN ailee_user_student us on us.user_id = u.user_id
                LEFT JOIN ailee_degree d on d.degree_id = us.current_study
                WHERE user_slug != '' AND (
                    u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_profession)
                    OR u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_student)
        )". $search_query ." ORDER BY u.user_id DESC";

        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array['total_rec'];
    }

    public function get_blog_list($cateid = '', $page = '', $limit = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $sql = "SELECT b.*,DATE_FORMAT(b.created_date,'%D %M %Y') as created_date_formatted
                    FROM ailee_blog b
                    WHERE b.status = 'publish'";
        $sql .= " AND FIND_IN_SET(". $cateid .",blog_category_id) != '0'";
        $sql .= " ORDER BY b.created_date DESC";        
        if($limit != ""){
            $sql .= " LIMIT $start, $limit";
        }        
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    public function get_blog_list_total_rec($cateid = '') {        

        $sql = "SELECT COUNT(*) as total_rec FROM ailee_blog b WHERE b.status = 'publish'";
        $sql .= " AND FIND_IN_SET(". $cateid .",blog_category_id) != '0'";
        $sql .= " ORDER BY b.created_date DESC";        
        $query = $this->db->query($sql);        
        $result = $query->row_array();        
        return $result['total_rec'];
    }

    // Get all category of blog list
    public function get_blog_cat_list(){
        $sql = "SELECT id,name FROM ailee_blog_category where status = 'publish'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function generate_sitemap_member(){
        $sql = "SELECT u.* FROM ailee_user u
                LEFT JOIN ailee_user_profession up on up.user_id = u.user_id
                LEFT JOIN ailee_user_student us on us.user_id = u.user_id
                WHERE u.user_slug != '' AND (
                    u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_profession)
                    OR u.user_id IN (SELECT DISTINCT user_id FROM ailee_user_student)
                ) ORDER BY u.user_id DESC";        
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_listing(){
        $sql = "SELECT rp.post_id,rp.city, rp.post_id, IF(jt.name != '',jt.name,rp.post_name) as post_name, rp.user_id, r.re_comp_name, rp.user_id as post_user_id,IF(c.city_name != '',c.city_name,IF(s.state_name != '',s.state_name,cn.country_name)) as city_name 
            FROM ailee_rec_post rp 
            LEFT JOIN ailee_job_title jt on rp.post_name = jt.title_id
            LEFT JOIN ailee_cities c on c.city_id = rp.city
            LEFT JOIN ailee_states s on s.state_id = rp.state
            LEFT JOIN ailee_countries cn on cn.country_id = rp.country
            JOIN ailee_recruiter r ON rp.user_id = r.user_id 
            WHERE rp.status = '1' AND rp.is_delete = '0' AND DATEDIFF(rp.post_last_date,NOW()) >= 0 ORDER BY rp.post_id DESC";
            // DATEDIFF(NOW(),rp.post_last_date) >= 0 
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_by_category_listing() {
        $this->db->select('count(rp.post_id) as count,ji.industry_id,ji.industry_name,ji.industry_slug, ji.industry_image')->from('job_industry ji');
        $this->db->join('rec_post rp', 'rp.industry_type = ji.industry_id', 'left');
        $this->db->where('ji.status', '1');
        $this->db->where('ji.is_delete', '0');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->where('DATEDIFF(NOW(),rp.post_last_date) >= ','0');
        $this->db->group_by('rp.industry_type');
        $this->db->order_by('count', 'desc');        

        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_by_skills_listing() {
        $sql = "SELECT count(rp.post_id) as count, s.skill_id, s.skill, s.skill_slug, s.skill_image FROM ailee_skill s,ailee_rec_post rp WHERE FIND_IN_SET(s.skill_id,rp.post_skill) > 0 AND s.status = '1' AND s.type = '1' AND rp.status = '1' AND rp.is_delete = '0' AND DATEDIFF(NOW(),rp.post_last_date) >= 0 GROUP BY s.skill_id ORDER BY count DESC";

        $query = $this->db->query($sql);

        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_by_location_listing() {
        $this->db->select('count(rp.post_id) as count,c.city_id,c.city_name,c.slug,c.city_image')->from('cities c');
        $this->db->join('rec_post rp', 'rp.city = c.city_id', 'left');
        $this->db->where('c.status', '1');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->where('DATEDIFF(NOW(),rp.post_last_date) >= ','0');
        $this->db->group_by('rp.city');        
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_by_company_listing()
    {
        $this->db->select('count(rp.user_id) as count,r.user_id,r.rec_id, r.re_comp_name as company_name,r.comp_logo')->from('recruiter r');
        $this->db->join('rec_post rp', 'rp.user_id = r.user_id', 'left');
        $this->db->where('r.re_status', '1');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->where('DATEDIFF(NOW(),rp.post_last_date) >= ','0');
        $this->db->group_by('rp.user_id');
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();        
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_job_by_desi_listing()
    {
        $this->db->select('count(jt.title_id) as count,jt.title_id,jt.name as job_title,jt.slug as job_slug, jt.job_title_img')->from('job_title jt');
        $this->db->join('rec_post rp', 'rp.post_name = jt.title_id', 'left');
        $this->db->where('jt.status', 'publish');
        $this->db->where('rp.status', '1');
        $this->db->where('rp.is_delete', '0');
        $this->db->where('DATEDIFF(NOW(),rp.post_last_date) >= ','0');
        $this->db->group_by('jt.title_id');
        $this->db->order_by('count', 'desc');
        $query = $this->db->get();        
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_bussiness_listing(){        
        $sql = "SELECT IF (ct.city_name != '',concat(bp.business_slug, '-', ct.city_name), IF(st.state_name != '', concat(bp.business_slug, '-', st.state_name),concat(bp.business_slug, '-', cn.country_name))) as business_slug, IF (bp.industriyal = 0, bp.other_industrial , it.industry_name) as bus_industry_name
            FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it on it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON ct.city_id = bp.city 
            LEFT JOIN ailee_states st ON st.state_id = bp.state
            LEFT JOIN ailee_countries cn on cn.country_id = bp.country
            WHERE bp.status = '1' AND business_step = '4' AND bp.is_deleted = '0' ORDER BY business_profile_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_business_by_category_listing()
    {
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

    function generate_sitemap_business_by_location_listing()
    {
        $sql = "SELECT count(bp.business_profile_id) as count, ac.city_id, ac.city_name, ac.slug 
                FROM ailee_cities ac 
                LEFT JOIN ailee_business_profile bp ON bp.city = ac.city_id
                WHERE ac.status = '1' AND bp.status = '1' AND bp.is_deleted = '0' 
                AND bp.business_step = '4' 
                GROUP BY bp.city 
                ORDER BY count DESC"; 
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_freelance_listing()
    {
        $sql = "SELECT fp.*, c.*,fp.user_id as post_user_id 
                FROM ailee_freelancer_post fp
                LEFT JOIN ailee_category c on fp.post_field_req = c.category_id 
                WHERE fp.is_delete = '0' AND fp.status = '1' ORDER BY post_id DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_freelance_by_category_listing()
    {
        $sql = "SELECT count(fp.post_id) as count, s.skill_id, s.skill, s.skill_slug, s.skill_image FROM ailee_skill s,ailee_freelancer_post fp WHERE FIND_IN_SET(s.skill_id,fp.post_skill) > 0 AND s.status = '1' AND s.type = '1' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY s.skill_id ORDER BY count DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_freelance_by_field_listing()
    {
        $sql = "SELECT count(fp.post_id) as count,c.category_id,c.category_name,c.category_slug,c.category_image FROM ailee_category c,ailee_freelancer_post fp WHERE fp.post_field_req = c.category_id AND c.category_id != 15 AND c.status = '1' AND c.is_delete = '0' AND c.is_other = '0' AND fp.status = '1' AND fp.is_delete = '0' GROUP BY fp.post_field_req ORDER BY count DESC";
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_artist_listing()
    {
        $sql = "SELECT art_id, art_name, art_lastname, art_email, slug FROM ailee_art_reg 
                WHERE status = '1'
                AND art_step = '4' AND is_delete = '0' ORDER BY art_id DESC";        
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_artist_by_category_listing()
    {
        $sql = "SELECT count(ar.art_id) as count, ct.category_id, ct.art_category, ct.category_slug
                FROM ailee_art_category ct,ailee_art_reg ar
                WHERE ct.category_id != 26 AND FIND_IN_SET(ct.category_id,ar.art_skill) > 0 AND ct.status = '1' 
                AND ct.type = '1' AND ar.status = '1' AND ar.art_step = '4' AND ar.is_delete = '0'
                GROUP BY ct.category_id ORDER BY count DESC";

        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_artist_by_location_listing()
    {
        $sql = "SELECT count(ar.art_id) as count, ar.art_city as location_id, ac.city_name as art_location, ac.slug as location_slug
                FROM ailee_cities ac 
                LEFT JOIN ailee_art_reg ar ON ar.art_city = ac.city_id
                WHERE ac.status = '1' AND ar.status = '1'
                AND ar.art_step = '4' 
                GROUP BY ar.art_city 
                ORDER BY count DESC";        

        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_opportunity_listing(){
        
        $sql = "SELECT uo.post_id, up.user_id, uo.opportunity, it.industry_name as field_txt,uo.field,uo.other_field, uo.opptitle, uo.oppslug FROM ailee_user_opportunity uo LEFT JOIN ailee_industry_type it ON it.industry_id = uo.field LEFT JOIN ailee_user_post up ON up.id = uo.post_id WHERE up.status = 'publish' ORDER BY up.id DESC";

        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_article_listing(){        
        
        $sql = "SELECT a.article_title, a.article_featured_image, a.article_slug FROM ailee_post_article a LEFT JOIN ailee_user_post up ON up.post_id = a.id_post_article WHERE up.status = 'publish' AND up.is_delete = '0' AND up.post_for = 'article' ORDER BY up.post_id DESC";

        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_questions_listing(){        
        
        $sql = "SELECT up.id,uaq.id as question_id,up.user_id, up.post_for, up.created_date, up.post_id, uaq.question, uaq.description FROM ailee_user_post up LEFT JOIN ailee_user_ask_question uaq ON uaq.post_id = up.id WHERE up.post_for = 'question' AND up.status = 'publish' AND up.is_delete = '0'";
        $query = $this->db->query($sql);        
        $result_array = $query->result_array();
        return $result_array;
    }

    function generate_sitemap_blog_listing()
    {
        $sql = "SELECT id, title, blog_slug, status FROM ailee_blog WHERE status = 'publish' ORDER BY id DESC";
        
        $query = $this->db->query($sql);
        $result_array = $query->result_array();
        return $result_array;
    }

}