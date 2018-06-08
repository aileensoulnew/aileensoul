<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
        include ('main_profile_link.php');
        $this->load->model('sitemap_model');

        $this->data['sitemap_header'] = $this->load->view('sitemap/sitemap_header', $this->data, true);
        if($this->session->userdata('aileenuser')){
            $this->data['sitemap_with_login_job'] = $this->data['job_right_profile_link'];
            $this->data['sitemap_with_login_rec'] = $this->data['recruiter_right_profile_link'];
            $this->data['sitemap_with_login_free_emp'] = $this->data['freelance_hire_right_profile_link'];
            $this->data['sitemap_with_login_free_pro'] = $this->data['freelance_apply_right_profile_link'];
            $this->data['sitemap_with_login_bus'] = $this->data['business_right_profile_link'];
            $this->data['sitemap_with_login_art'] = $this->data['artist_right_profile_link'];

            $this->data['sitemap_with_signup_bus'] = $business_right_profile_link;
            $this->data['sitemap_with_signup_art'] = base_url().'artist-profile/signup';
        }else{
            // Without login page
            $this->data['sitemap_with_login_job'] = base_url(). 'login';
            $this->data['sitemap_with_login_rec'] = base_url(). 'login';
            $this->data['sitemap_with_login_free_emp'] = base_url(). 'login';
            $this->data['sitemap_with_login_free_pro'] = base_url(). 'login';
            $this->data['sitemap_with_login_bus'] = base_url(). 'login';
            $this->data['sitemap_with_login_art'] = base_url(). 'login';

            $this->data['sitemap_with_signup_bus'] = base_url('business-profile/create-account');
            $this->data['sitemap_with_signup_art'] = base_url().'artist-profile/create-account';
            $this->data['sitemap_with_signup_rec'] = base_url().'artist-profile/create-account';
        }
    }

    public function index() {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);

        $contition_array = array('');
        $this->data['business_profile'] = $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->load->view('sitemap/index', $this->data);
    }

    public function job_profile() {
        $this->data['title'] = 'Job Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getJobDataByLocation'] = $this->sitemap_model->getJobDataByLocation();
        $this->data['getRecruiter'] = $this->sitemap_model->getRecruiter();
        $this->load->view('sitemap/job', $this->data);
    }

    public function recruiter_profile() {
        $this->data['title'] = 'Recruiter Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getJobseekers'] = $this->sitemap_model->getJobseekers();
        $contition_array = array('');
        $this->data['business_profile'] = $userdata = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $this->load->view('sitemap/recruiter', $this->data);
    }

    public function freelance_profile() {
        $this->data['title'] = 'Freelance Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getFreepostDataByCategory'] = $this->sitemap_model->getFreepostDataByCategory();
        $this->data['getFreelancers'] = $this->sitemap_model->getFreelancers();
        $this->data['getEmployees'] = $this->sitemap_model->getEmployees();
        $this->load->view('sitemap/freelance', $this->data);
    }

    public function business_profile() {
        $this->data['title'] = 'Business Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getBusinessDataByCategory'] = $this->sitemap_model->getBusinessDataByCategory();
        $this->load->view('sitemap/business', $this->data);
    }

    public function artistic_profile() {
        $this->data['title'] = 'Artistic Profile | Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['getArtistDataByCategory'] = $this->sitemap_model->getArtistDataByCategory();
        $this->load->view('sitemap/artistic', $this->data);
    }

    public function get_artistic_url($userid) {

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

        $url = $arturl[0]['slug'] . '-' . $category_url . '-' . $city_get . '-' . $arturl[0]['art_id'];

        return $url;
    }

    public function clean($string) {

        $string = str_replace(' ', '-', $string);  // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // replace double --- in single -

        return preg_replace('/-+/', '-', $string); // Removes special chars.
    }

    //NEW SITEMAP VIEW
    public function sitemap() {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('sitemap/sitemap', $this->data);
    }

    //NEW BLOG VIEW
    public function blogs() {
        $this->data['title'] = 'Sitemap Blogs - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('sitemap/sitemap-blog', $this->data);
    }

    //NEW BLOG CATEGORY VIEW
    public function blogs_category($category = '') {
        $this->data['title'] = 'Sitemap Blogs - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $category = str_replace('-', ' ', $category);
        $this->data['cate_name'] = $category;
        $this->data['cate_id'] = $this->get_blog_cat_id($category);
        $this->load->view('sitemap/sitemap-blog-inner', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function sitemap_inner($searchword = '') {
        $this->data['title'] = 'Sitemap - Aileensoul';
        $this->data['login_header'] = $this->load->view('login_header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['searchword'] = $searchword;
        $this->load->view('sitemap/sitemap-inner', $this->data);
    }

    public function sitemap_art_list() {
        $this->load->view('sitemap/sitemap_art_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_artist_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $result['artist_list'] = $this->sitemap_model->get_artist_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_artist_list_total($searchword);
        echo json_encode($result);
    }

    //NEW SITEMAP INNER VIEW
    function get_blog_cat_id($category = ''){
        $sql = "SELECT id as cate_id  FROM ailee_blog_category where name ='". $category ."'";
        $query = $this->db->query($sql);
        $result = $query->row_array();
        if(count($result) > 0){
            return $result['cate_id'];
        }
        return false;
    }

    public function sitemap_company_list() {
        $this->load->view('sitemap/sitemap_business_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_company_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $result['company_list'] = $this->sitemap_model->get_company_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_company_list_total($searchword);
        echo json_encode($result);
    }

    public function sitemap_job_list() {
        $this->load->view('sitemap/sitemap_job_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_job_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $result['job_list'] = $this->sitemap_model->get_job_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_job_list_total($searchword);
        echo json_encode($result);
    }

    public function sitemap_freelancer_list() {
        $this->load->view('sitemap/sitemap_freelance_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_freelancer_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $result['freelancer_list'] = $this->sitemap_model->get_freelancer_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_freelancer_list_total($searchword);
        echo json_encode($result);
    }

    public function sitemap_member_list() {
        $this->load->view('sitemap/sitemap_member_list', $this->data);
    }

    //NEW SITEMAP INNER VIEW
    public function get_member_list() {
        $perpage = 100;
        $page = 1;
        if (!empty($_GET["searchword"]) && $_GET["searchword"] != 'undefined') {
            $searchword = $_GET["searchword"];
        }
        if (!empty($_GET["page_id"]) && $_GET["page_id"] != 'undefined') {
            $page = $_GET["page_id"];
        }
        if (!empty($_GET["limit"]) && $_GET["limit"] != 'undefined') {
            $perpage = $_GET["limit"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        
        $result['member_list'] = $this->sitemap_model->get_member_list($searchword,$start,$perpage);
        $result['total_record'] = $this->sitemap_model->get_member_list_total($searchword);
        echo json_encode($result);
    }

}
