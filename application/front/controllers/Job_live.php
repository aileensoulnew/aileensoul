<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('job_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
        include ('main_profile_link.php');
        include ('job_include.php');
    }

    public function index() {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isjobdeactivate'] = false;
        $deactivate = $this->checkisjobdeactivate($userid);
        //print_r($deactivate);exit;
        // if($this->job_profile_set == 1 && !$deactivate){
        //     redirect( $this->job_profile_link);
        // }
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['job_profile_link'] =  $this->job_profile_link;
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Job Profile | Aileensoul";
        //$this->load->view('job_live/index', $this->data);
        /*if($this->job_profile_set == 1)
            $this->load->view('job_live/index', $this->data);
        else */
        if($userid != "" || $this->job_profile_set == 1)
            $this->load->view('job_live/without_job_register', $this->data);
        else
            $this->load->view('job_live/without_main_register', $this->data);
    }

    public function category($category_slug = '') {
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('ji.industry_id')->get_where('job_industry ji', array('industry_slug' => $category_slug))->row_array('ji.industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['title'] = "Categories - Artist Profile | Aileensoul";
        $this->load->view('job_live/category', $this->data);
    }
    
    public function skill($skill_slug = '') {
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $skill_id = $this->db->select('s.skill_id')->get_where('skill s', array('skill_slug' => $skill_slug))->row_array('s.skill_id');
        $this->data['skill_id'] = $skill_id['skill_id'];
        $this->data['title'] = "Skills - Artist Profile | Aileensoul";
        $this->load->view('job_live/skill', $this->data);
    }
    
    public function company($company_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['company_id'] = $company_id;
        $this->data['title'] = "Companies - Artist Profile | Aileensoul";
        $this->load->view('job_live/company', $this->data);
    }
    
    public function city($city_slug = '') {
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $city_id = $this->db->select('c.city_id')->get_where('cities c', array('slug' => $city_slug))->row_array('c.city_id');
        $this->data['city_id'] = $city_id['city_id'];
        $this->data['title'] = "Cities - Artist Profile | Aileensoul";
        $this->load->view('job_live/city', $this->data);
    }

    public function job_search() {
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->data['w'] = $_GET['w'];
        $this->load->view('job_live/search', $this->data);
    }

    public function jobCategory() {
        $limit = $_GET['limit'];
        $jobCategory = $this->job_model->jobCategory($limit);
        echo json_encode($jobCategory);
    }

    public function jobAllCategory() {
        $jobAllCategory = $this->job_model->jobAllCategory();
        echo json_encode($jobAllCategory);
    }

    public function otherCategoryCount() {
        $otherCategoryCount = $this->job_model->otherCategoryCount();
        echo $otherCategoryCount;
    }

    public function jobListByCategory($id = '0') {
        $jobListByCategory = $this->job_model->jobListByCategory($id);
        echo json_encode($jobListByCategory);
    }

    public function jobCity() {
        $limit = $_GET['limit'];
        $jobCity = $this->job_model->jobCity($limit);
        echo json_encode($jobCity);
    }

    public function jobCompany() {
        $limit = $_GET['limit'];
        $jobCompany = $this->job_model->jobCompany($limit);
        echo json_encode($jobCompany);
    }

    public function jobSkill() {
        $limit = $_GET['limit'];
        $jobSkill = $this->job_model->jobSkill($limit);
        echo json_encode($jobSkill);
    }

    public function latestJob() {
        $userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $company_id = (isset($_POST['company_id']) && !empty($_POST['company_id']) ? $_POST['company_id'] : "");
        $category_id = (isset($_POST['category_id']) && !empty($_POST['category_id']) ? $_POST['category_id'] : "");
        $location_id = (isset($_POST['location_id']) && !empty($_POST['location_id']) ? $_POST['location_id'] : "");
        $skill_id = (isset($_POST['skill_id']) && !empty($_POST['skill_id']) ? $_POST['skill_id'] : "");
        $job_desc = (isset($_POST['job_desc']) && !empty($_POST['job_desc']) ? $_POST['job_desc'] : "");
        $period_filter = (isset($_POST['period_filter']) && !empty($_POST['period_filter']) ? $_POST['period_filter'] : "");
        $exp_fil = (isset($_POST['exp_fil']) && !empty($_POST['exp_fil']) ? $_POST['exp_fil'] : "");

        $limit = 5;        
        $latestJob = $this->job_model->latestJob($userid,$company_id,$category_id,$location_id,$skill_id,$job_desc,$period_filter,$exp_fil,$page,$limit);
        echo json_encode($latestJob);
    }

    public function get_jobtitle() {
        $limit = $_GET['limit'];
        $job_title = $this->job_model->get_jobtitle($limit);
        echo json_encode($job_title);
    }

    public function applyJobFilter() {
        $posting_period = implode(',', $_POST['posting_period']);
        $experience = implode(',', $_POST['experience']);
        $category = implode(',', $_POST['category']);
        $location = implode(',', $_POST['location']);
        $company = implode(',', $_POST['company']);
        $skill = implode(',', $_POST['skill']);

        $job_filter = $this->job_model->applyJobFilter($posting_period, $experience, $category, $location, $company, $skill);
        echo json_encode($job_filter);
    }

    public function searchJobData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $work = $_GET['w'];

        $searchJobData = $this->job_model->searchJobData($keyword, $city, $work);
        echo json_encode($searchJobData);
    }

    public function job_category_slug() {
        $contition_array = array();
        $jobCatData = $this->common->select_data_by_condition('job_industry', $contition_array, $data = 'industry_id,industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($jobCatData as $k => $v) {
            $data = array('industry_slug' => strtolower($this->common->clean($v['industry_name'])));
            $insert_id = $this->common->update_data($data, 'job_industry', 'industry_id', $v['industry_id']);
        }
        echo "yes";
    }

    // Load reactivate view
    public function reactivateacc() {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        
        $contition_array = array('user_id' => $userid, 'status' => '0');
        $reactivate = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE END    
        if ($reactivate) {
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            // Fetch data for reg.
            $this->load->view('job/reactivate', $this->data);
        } 

        if($this->job_profile_set == 1 && !$reactivate){
            redirect( $this->job_profile_link);
        }
    }

    // CHECK IS JOB DEACTIVATE OR NOT AND SET LINK VARIABLE FOR REDIRECT FROM SEARCH BANNER PAGE
    function checkisjobdeactivate($userid = ""){
        $contition_array = array('user_id' => $userid, 'status' => '0');
        $deactivate = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        
        // IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE END    
        if ($deactivate) {
            // Fetch data for reg.
            $this->data['isjobdeactivate'] = true;
            // $this->load->view('job/reactivate', $this->data);
        };
        $this->data['job_profile_set'] = $this->job_profile_set;
        $this->data['job_profile_link'] =  ($this->job_profile_set == 1)?$this->job_profile_link:base_url('job/registration');
        return $deactivate;
    }

    public function view_more_jobs()
    {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isjobdeactivate'] = false;
        $deactivate = $this->checkisjobdeactivate($userid);
        //print_r($deactivate);exit;
        // if($this->job_profile_set == 1 && !$deactivate){
        //     redirect( $this->job_profile_link);
        // }
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['job_profile_link'] =  $this->job_profile_link;
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Job Profile | Aileensoul";

        $this->load->view('job_live/view_more_jobs', $this->data);
    }

    public function jobs_by_location()
    {
        $this->load->view('job_live/jobs_by_location', $this->data);
    }
    public function jobs_by_location_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobCity = $this->job_model->get_job_city($page,$limit);
        echo json_encode($jobCity);
    }

    public function jobs_by_skills()
    {
        $this->load->view('job_live/jobs_by_skills', $this->data);
    }
    public function jobs_by_skills_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobSkill = $this->job_model->get_job_skills($page,$limit);
        echo json_encode($jobSkill);
    }

    public function jobs_by_designations()
    {
        $this->load->view('job_live/jobs_by_designation', $this->data);
    }
    public function jobs_by_designations_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobDesc = $this->job_model->get_job_designations($page,$limit);
        echo json_encode($jobDesc);
    }

    public function jobs_by_companies()
    {
        $this->load->view('job_live/jobs_by_company', $this->data);
    }
    public function jobs_by_companies_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobComp = $this->job_model->get_jobs_by_companies($page,$limit);
        echo json_encode($jobComp);
    }

    public function jobs_by_categories()
    {
        $this->load->view('job_live/jobs_by_category', $this->data);
    }
    public function jobs_by_categories_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobCat = $this->job_model->get_jobs_by_categories($page,$limit);
        echo json_encode($jobCat);
    }

    public function jobs_by_jobs()
    {
        $this->load->view('job_live/jobs_by_jobs', $this->data);
    }
    public function jobs_by_jobs_ajax()
    {        
        /*if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $jobCat = $this->job_model->get_jobs_by_categories($page,$limit);
        echo json_encode($jobCat);*/

        $page = 1;
        $limit = 20;
        $jobCat = $this->job_model->get_jobs_by_categories($page,$limit);
        $jobDesc = $this->job_model->get_job_designations($page,$limit);
        $jobSkill = $this->job_model->get_job_skills($page,$limit);
        $jobCity = $this->job_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity['job_city'] as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {
                $all_link[$value['slug']]['category'][$i]['name'] = $jcv['industry_name']." Jobs In ".$value['city_name'];
                $all_link[$value['slug']]['category'][$i]['slug'] = $jcv['industry_slug']."-jobs-in-".$value['slug'];
                $i++;
            }
            foreach ($jobDesc['job_desc'] as $jdk => $jdv) {
                $all_link[$value['slug']]['designation'][$i]['name'] = $jdv['job_title']." Jobs In ".$value['city_name'];
                $all_link[$value['slug']]['designation'][$i]['slug'] = $jdv['job_slug']."-jobs-in-".$value['slug'];
                $i++;
            }
            foreach ($jobSkill['job_skills'] as $jsk => $jsv) {
                $all_link[$value['slug']]['skills'][$i]['name'] = $jsv['skill']." Jobs In ".$value['city_name'];
                $all_link[$value['slug']]['skills'][$i]['slug'] = $jsv['skill_slug']."-jobs-in-".$value['slug'];
                $i++;
            }
        }
        echo json_encode($all_link);
        //print_r($all_link);
    }

    public function job_search_new($searchstr = "") {
        $work_timing = $_GET['work_timing'];
        // echo($work_timing);exit;
        $searchstr = str_replace("jobs/search/","",$this->uri->uri_string());
        //print_r($searchstr);exit;
        $userid = $this->session->userdata('aileenuser');
        $deactivate = $this->checkisjobdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Job Search | Aileensoul";
        $this->data['search_banner'] = $this->load->view('job_live/search_banner', $this->data, TRUE);
        /*$this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->data['w'] = $_GET['w'];*/

        if($searchstr != ''){
            $isloacationsearch = false;
            $search_location;            
            //if (substr($searchstr, 0, strlen("-jobs-in-")) === "-jobs-in-") {
            if (strpos($searchstr, "-jobs-in-") !== false)
            {
                $search_loc_cat = explode("-jobs-in-", $searchstr);                
            }
            else if (strpos($searchstr, "jobs-in-") !== false)
            {                
                $search_location = explode("jobs-in-", $searchstr);                
            }
            else
            {
                $search_category = explode("-jobs", $searchstr);                
            }            
            $this->data['q'] = '';
            $this->data['l'] = '';
            if(count($search_loc_cat) > 0){
                $this->data['q'] = $search_loc_cat[0];
                $this->data['l'] = $search_loc_cat[1];
            }
            else if(count($search_location) > 0){
                $this->data['q'] = '';
                $this->data['l'] = $search_location[1];
            }else{
                $this->data['q'] = $search_category[0];
            }
        }
        else{
            $this->data['q'] = $_GET['q'];
            $this->data['l'] = $_GET['l'];
        }

        // Replace - with ,
        $this->data['q'] = str_replace("-",",",$this->data['q']);
        $this->data['l'] = str_replace("-",",",$this->data['l']);
        $this->data['q'] = str_replace("+"," ",$this->data['q']);
        $this->data['l'] = str_replace("+"," ",$this->data['l']);
        $this->data['work_timing'] = $work_timing;
        /*print_r($this->data['work_timing']);
        echo "<--work_timing   Query--->";
        print_r($this->data['q']);
        echo "<--Query   Location--->";
        print_r($this->data['l']);exit;*/
        $this->load->view('job_live/search_new', $this->data);
    }

    public function job_search_keyword($id = "") {
        $searchTerm = $_GET['term'];
        $result1 = $this->job_model->job_search_keyword($searchTerm);
        echo json_encode($result1);
    }

    public function job_search_city($id = "") {
        $searchTerm = $_GET['term'];
        $result1 = $this->job_model->job_search_city($searchTerm);
        echo json_encode($result1);
    }

    public function job_search_new_ajax()
    {        
        $userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }

        $job_keyword = (isset($_POST['job_keyword']) && $_POST['job_keyword'] != "" ? $_POST['job_keyword'] : "");
        $job_location = (isset($_POST['job_location']) && $_POST['job_location'] != "" ? $_POST['job_location'] : "");
        $work_time = (isset($_POST['work_time']) && $_POST['work_time'] != "" ? $_POST['work_time'] : "");
        
        $company_id = (isset($_POST['company_id']) && !empty($_POST['company_id']) ? $_POST['company_id'] : "");
        $category_id = (isset($_POST['category_id']) && !empty($_POST['category_id']) ? $_POST['category_id'] : "");
        $location_id = (isset($_POST['location_id']) && !empty($_POST['location_id']) ? $_POST['location_id'] : "");
        $skill_id = (isset($_POST['skill_id']) && !empty($_POST['skill_id']) ? $_POST['skill_id'] : "");
        $job_desc = (isset($_POST['job_desc']) && !empty($_POST['job_desc']) ? $_POST['job_desc'] : "");
        $period_filter = (isset($_POST['period_filter']) && !empty($_POST['period_filter']) ? $_POST['period_filter'] : "");
        $exp_fil = (isset($_POST['exp_fil']) && !empty($_POST['exp_fil']) ? $_POST['exp_fil'] : "");

        $limit = 5;
        $searchJobs = $this->job_model->get_job_search_new_result($userid,$job_keyword,$job_location,$work_time,$company_id,$category_id,$location_id,$skill_id,$job_desc,$period_filter,$exp_fil,$page,$limit);
        echo json_encode($searchJobs);
    }

    public function job_register_new()
    {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $user_slug = $this->user_model->getUserSlugById($userid);
        $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
        $userslug = $this->session->userdata('aileenuser_slug');
        
        $ProfessionData = $this->user_model->getUserProfessionData($userid,"*");
        $StudentData = $this->user_model->getUserStudentData($userid,"*");
        $this->data['professionData'] = (isset($ProfessionData) && !empty($ProfessionData) ? 1 : 0);
        $this->data['studentData'] = (isset($StudentData) && !empty($StudentData) ? 1 : 0);       
        $this->data['title'] = "Job Register | Aileensoul"; 
        $this->load->view('job_live/job_register', $this->data);
    }

    public function job_register()
    {
        $this->load->view('job_live/job_register_main', $this->data);
    }

    public function job_basic_info()
    {
        $this->load->view('job_live/job_basic_info', $this->data);   
    }

    public function job_education_info()
    {
        $this->load->view('job_live/job_education_info', $this->data);   
    }

    public function job_create_profile()
    {
        $userid = $this->session->userdata('aileenuser');
        $this->data['job_data'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email');
        $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name !=' => "Others");
        if ($userid) {
            $search_condition = "((is_other = '1' AND user_id = $userid) OR (is_other = '0'))";
        } else {
            $search_condition = "(is_other = '0')";
        }
        $university_data = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'industry_name' => "Others", 'is_other' => '0');
        $search_condition = "((status = '1'))";
        $this->data['other_industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = 'industry_id,industry_name', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
         $this->data['user_profession_data'] = $this->user_model->getUserProfessionData($userid,"*");        
        $this->load->view('job_live/job_create_profile', $this->data);
    }

}
