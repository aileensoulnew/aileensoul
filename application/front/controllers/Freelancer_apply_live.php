<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer_apply_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('artistic_model');
        $this->load->model('freelancer_apply_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
        $this->data['freelancer_post_header2'] = $this->load->view('freelancer_live/freelancer_post/freelancer_post_header2_new', $this->data, true);
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';

        include ('main_profile_link.php');
    }

    public function index() {
        if($this->freelance_apply_profile_set == 1)
        {
            redirect(base_url()."recommended-freelance-work");
        }
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist-profile/signup');
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['fa_leftbar'] = $this->load->view('freelancer_apply_live/fa_leftbar', $this->data, TRUE);
        $this->data['title'] = "Work from Home: Online Freelance Jobs | Aileensoul";
        $this->data['metadesc'] = "Find and apply from various freelance work opportunities like web designer, digital marketing, content writing, and many more. Get the online job that interest you the most on Aileensoul. ";
        $this->data['freelance_apply_profile_set'] = $this->freelance_apply_profile_set;

        $limit = 8;
        $this->data['FAFields'] = $this->freelancer_apply_model->freelancerFields($limit);
        $this->data['FASkills'] = $this->freelancer_apply_model->get_fa_category($limit)['fa_category'];
        $this->data['free_job_related_list'] = $this->freelancer_apply_model->free_job_related_blog_list();

        if($userid != ""){
            $this->load->view('freelancer_apply_live/freelancer_apply_live', $this->data);
        }
        else{
            $this->load->view('freelancer_apply_live/freelancer_apply_without_main_regi', $this->data);
        }
    }

    public function freelancer_apply_live_post() {
        $userid = $this->session->userdata('aileenuser');
        $postdata = $this->freelancer_apply_model->getfreelancerapplypost($userid,"*");
        echo json_encode($postdata);
    }

    public function freelancer_apply_search() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist-profile/signup');
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Search - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->load->view('freelancer_apply_live/search', $this->data);
    }

    public function searchFreelancerApplyData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $time = $_GET['t'];
        $searchFreelancerApplyData = $this->freelancer_apply_model->searchFreelancerApplyData($keyword, $city, $time);
        echo json_encode($searchFreelancerApplyData);
    }
    
    public function freelancerCategory() {
        $limit = $_GET['limit'];
        $freelancerCategory = $this->freelancer_apply_model->freelancerCategory($limit);
        echo json_encode($freelancerCategory);
        
    }
    
    public function categoryFreelancerList($cat_slug = ""){
        echo 123; die();
    }

    public function freelancer_apply_register_new()
    {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $user_slug = $this->user_model->getUserSlugById($userid);
        $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
        $userslug = $this->session->userdata('aileenuser_slug');
        
        $ProfessionData = $this->user_model->getUserProfessionData($userid,"*");
        $StudentData = $this->user_model->getUserStudentData($userid,"*");
        if(!empty($ProfessionData) || !empty($StudentData))
        {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $freelancer_apply_profile = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if(isset($freelancer_apply_profile) && !empty($freelancer_apply_profile))
            {
                redirect(base_url().'recommended-freelance-work','refresh');
            }
            else
            {                
                redirect(base_url());
            }
        }
        $this->data['title'] = "Signup to get Freelancing Jobs | Aileensoul";
        $this->data['metadesc'] = "Search and Get the kind of work that you like to work upon the most. Sign up now! It's Free. ";
        $this->data['professionData'] = (isset($ProfessionData) && !empty($ProfessionData) ? 1 : 0);
        $this->data['studentData'] = (isset($StudentData) && !empty($StudentData) ? 1 : 0);        
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('freelancer_apply_live/freelancer_apply_register', $this->data);
    }

    public function freelancer_apply_register()
    {
        $this->load->view('freelancer_apply_live/freelancer_apply_register_main', $this->data);
    }

    public function freelancer_apply_basic_info_new()
    {
        $this->load->view('freelancer_apply_live/freelancer_apply_basic_info', $this->data);   
    }

    public function freelancer_apply_education_info()
    {        
        $this->load->view('freelancer_apply_live/freelancer_apply_education_info', $this->data);   
    }

    public function freelancer_apply_create_profile()
    {
        $userid = $this->session->userdata('aileenuser');
        $this->data['user_data'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email');
        
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_other' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "( status = '1')";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('freelancer_apply_live/freelancer_apply_create_profile', $this->data);
    }

    public function freelancerFields() {
        $limit = $_GET['limit'];
        $freelancerFields = $this->freelancer_apply_model->freelancerFields($limit);
        echo json_encode($freelancerFields);        
    }

    public function freelancerSkills() {
        $limit = $_GET['limit'];
        $freelancerSkills = $this->freelancer_apply_model->get_fa_category($limit);
        echo json_encode($freelancerSkills);
    }

    public function freelance_apply_field_cat_no_login($search = "",$ser_location = "")
    {
        $this->data['keyword'] = $search;
        $this->data['search_location'] = $ser_location;
        $userid = $this->session->userdata('aileenuser');

        $this->data['category_id'] = $category_id = (isset($_POST['category']) && !empty($_POST['category']) ? $_POST['category'] : "");//Field
        $this->data['skill_id'] = $skill_id = (isset($_POST['skill']) && !empty($_POST['skill']) ? $_POST['skill'] : "");
        $this->data['worktype'] = $worktype = (isset($_POST['worktype']) && !empty($_POST['worktype']) ? $_POST['worktype'] : "");
        $this->data['period_filter'] = $period_filter = (isset($_POST['posting_period']) && !empty($_POST['posting_period']) ? $_POST['posting_period'] : "");
        $this->data['exp_fil'] = $exp_fil = (isset($_POST['experience']) && !empty($_POST['experience']) ? $_POST['experience'] : "");

        $keyword = trim($search);
        $search_location = trim($ser_location);

        $fa_skills = $this->freelancer_apply_model->is_fa_skills($keyword);
        $fa_fields = $this->freelancer_apply_model->is_fa_field($keyword);
        $search_location_arr = array();

        $limit = 8;
        $config = array(); 
        $config["base_url"] = $this->data['filter_url'] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2);
        $config["total_rows"] = $this->freelancer_apply_model->ajax_project_list_no_login_tot_rec($userid,$fa_skills,$fa_fields,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$keyword,$search_location_arr);
        $config["per_page"] = $limit;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        //styling
        $config['use_page_numbers']  = TRUE;
        $config['full_tag_open']    = '<div class="pagination-button" id="pagination">';
        $config['full_tag_close']   = '</div>';
        $config['prev_link']        = '<span class="btn-p">Previous</span>';
        $config['next_link']        = '<span class="btn-p">Next</span>';
        $config['display_pages']    = FALSE; 
        $config['first_url']        = '';
        // $config['suffix']           = '-1';        

        $this->pagination->initialize($config);
        $this->data['page'] = $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $limit_fs = 10;
        $this->data['FAFields'] = $this->freelancer_apply_model->freelancerFields($limit_fs);
        $this->data['FASkills'] = $this->freelancer_apply_model->get_fa_category($limit_fs)['fa_category'];

        $this->data['searchFA'] = $searchFA = $this->freelancer_apply_model->ajax_project_list_no_login($userid,$fa_skills,$fa_fields,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$page,$limit,$keyword,$search_location_arr)['fa_projects'];
        
        $this->data['links'] = $this->pagination->create_links();


        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist-profile/signup');
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);

        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['fa_leftbar'] = $this->load->view('freelancer_apply_live/fa_leftbar', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');

        $this->data['title'] = "Freelance ".str_replace("-"," ",ucwords($search))." Jobs | Aileensoul";
        $this->data['metadesc'] = "Explore numerous ".str_replace("-"," ",ucwords($search))." Freelance Jobs on Aileensoul. Earn a little extra income plus enhance your skills. Apply Now!";


        /*$this->data['category_id'] = $category_id['industry_id'];
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];*/
        $this->load->view('freelancer_apply_live/fa_field_cat_list_no_login', $this->data);
    }

    public function ajax_project_list_no_login()
    {
        //print_r($_POST);exit;
        $userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $category_id = (isset($_POST['category_id']) && !empty($_POST['category_id']) ? $_POST['category_id'] : "");//Field
        
        $skill_id = (isset($_POST['skill_id']) && !empty($_POST['skill_id']) ? $_POST['skill_id'] : "");
        $worktype = (isset($_POST['worktype']) && !empty($_POST['worktype']) ? $_POST['worktype'] : "");
        $period_filter = (isset($_POST['period_filter']) && !empty($_POST['period_filter']) ? $_POST['period_filter'] : "");
        $exp_fil = (isset($_POST['exp_fil']) && !empty($_POST['exp_fil']) ? $_POST['exp_fil'] : "");

        $limit = 5;
        $keyword = trim($_GET['search']);
        $search_location = trim($_GET['search_location']);

        $fa_skills = $this->freelancer_apply_model->is_fa_skills($keyword);
        $fa_fields = $this->freelancer_apply_model->is_fa_field($keyword);
        /*print_r($fa_skills);
        print_r($fa_fields);
        exit;*/
        $search_location_arr = array();

        $searchFA = $this->freelancer_apply_model->ajax_project_list_no_login($userid,$fa_skills,$fa_fields,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$page,$limit,$keyword,$search_location_arr);

        echo json_encode($searchFA);
    }

    public function view_more_freelancer_apply()
    {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isjobdeactivate'] = false;
        
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        //$this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['job_profile_link'] =  $this->job_profile_link;
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Freelance Apply | Aileensoul";

        $this->load->view('freelancer_apply_live/view_more_freelancer_apply', $this->data);
    }

    public function freelance_jobs_by_fields()
    {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isjobdeactivate'] = false;
        
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        //$this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['job_profile_link'] =  $this->job_profile_link;
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Freelance Apply | Aileensoul";

        $limit = 15;
        $config = array(); 
        $config["base_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->freelancer_apply_model->get_fa_field_total_rec();
        $config["per_page"] = $limit;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        //styling
        $config['use_page_numbers']  = TRUE;
        $config['full_tag_open']    = '<div class="pagination-button" id="pagination">';
        $config['full_tag_close']   = '</div>';
        $config['prev_link']        = '<span class="btn-p">Previous</span>';
        $config['next_link']        = '<span class="btn-p">Next</span>';
        $config['display_pages']    = FALSE; 
        $config['first_url']        = '';
        // $config['suffix']           = '-1';
        $this->pagination->initialize($config);

        $this->data['page'] = $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->data['jobByField'] = $this->freelancer_apply_model->get_fa_field($limit,$page)['fa_fields'];
        $this->data['links'] = $this->pagination->create_links();

        $this->load->view('freelancer_apply_live/freelance_jobs_by_fields', $this->data);
    }

    public function freelance_jobs_by_fields_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $freelancerSkills = $this->freelancer_apply_model->get_fa_field($limit,$page);
        echo json_encode($freelancerSkills);
    }

    public function freelance_jobs_by_categories()
    {
        // check job is active or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isjobdeactivate'] = false;
        
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        //$this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['header_inner_profile'] = $this->load->view('header_inner_profile', $this->data, true);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['job_profile_link'] =  $this->job_profile_link;
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Freelance Apply | Aileensoul";

        $limit = 15;
        $config = array(); 
        $config["base_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->freelancer_apply_model->get_fa_category_total_rec();
        $config["per_page"] = $limit;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);

        //styling
        $config['use_page_numbers']  = TRUE;
        $config['full_tag_open']    = '<div class="pagination-button" id="pagination">';
        $config['full_tag_close']   = '</div>';
        $config['prev_link']        = '<span class="btn-p">Previous</span>';
        $config['next_link']        = '<span class="btn-p">Next</span>';
        $config['display_pages']    = FALSE; 
        $config['first_url']        = '';
        // $config['suffix']           = '-1';
        $this->pagination->initialize($config);

        $this->data['page'] = $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->data['jobByCategory'] = $this->freelancer_apply_model->get_fa_category($limit,$page)['fa_category'];
        $this->data['links'] = $this->pagination->create_links();

        $this->load->view('freelancer_apply_live/freelance_jobs_by_categories', $this->data);
    }

    public function freelance_jobs_by_categories_ajax()
    {        
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 15;
        $freelancerSkills = $this->freelancer_apply_model->get_fa_category($limit,$page);
        echo json_encode($freelancerSkills);
    }

    public function freelancer_apply_search_new($searchstr = "")
    {

        //$work_timing = $_GET['work_timing'];
        // echo($work_timing);exit;
        $searchstr = str_replace("freelancer/search/","",$this->uri->uri_string());
        // print_r($searchstr);exit;
        $userid = $this->session->userdata('aileenuser');
        
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Freelance Search | Aileensoul";
        $this->data['search_banner'] = $this->load->view('freelancer_apply_live/search_banner', $this->data, TRUE);
        $this->data['fa_leftbar'] = $this->load->view('freelancer_apply_live/fa_leftbar', $this->data, TRUE);
        /*$this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->data['w'] = $_GET['w'];*/

        if($searchstr != ''){
            $isloacationsearch = false;
            $search_location;            
            //if (substr($searchstr, 0, strlen("-jobs-in-")) === "-jobs-in-") {
            if (strpos($searchstr, "-projects-in-") !== false)
            {
                $search_loc_cat = explode("-projects-in-", $searchstr);                
            }
            else if (strpos($searchstr, "projects-in-") !== false)
            {                
                $search_location = explode("projects-in-", $searchstr);                
            }
            else
            {
                $search_category = $searchstr;//explode("-jobs", $searchstr);                
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
                $this->data['q'] = $search_category;
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
        //$this->data['work_timing'] = $work_timing;
        
        $this->load->view('freelancer_apply_live/search_new', $this->data);
    
    }

    public function freelancer_apply_search_new_ajax()
    {        
        $userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }

        $fa_keyword = (isset($_POST['fa_keyword']) && $_POST['fa_keyword'] != "" ? $_POST['fa_keyword'] : "");
        $fa_location = (isset($_POST['fa_location']) && $_POST['fa_location'] != "" ? $_POST['fa_location'] : "");

        $category_id = (isset($_POST['category_id']) && !empty($_POST['category_id']) ? $_POST['category_id'] : "");//Field
        
        $skill_id = (isset($_POST['skill_id']) && !empty($_POST['skill_id']) ? $_POST['skill_id'] : "");
        $worktype = (isset($_POST['worktype']) && !empty($_POST['worktype']) ? $_POST['worktype'] : "");
        $period_filter = (isset($_POST['period_filter']) && !empty($_POST['period_filter']) ? $_POST['period_filter'] : "");
        $exp_fil = (isset($_POST['exp_fil']) && !empty($_POST['exp_fil']) ? $_POST['exp_fil'] : "");

        $limit = 5;

        $searchFA = $this->freelancer_apply_model->get_freelancer_apply_search_new_result($userid,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$page,$limit,$fa_keyword,$fa_location);
        echo json_encode($searchFA);
    }

    public function freelancer_apply_search_city($id = "") {
        $searchTerm = $_GET['term'];
        $result1 = $this->freelancer_apply_model->freelancer_apply_search_city($searchTerm);
        echo json_encode($result1);
    }

    public function freelancer_apply_search_keyword($id = "") {
        $searchTerm = $_GET['term'];
        $result1 = $this->freelancer_apply_model->freelancer_apply_search_keyword($searchTerm);
        echo json_encode($result1);
    }

    // GET RELATED BLOG LIST
    public function get_free_job_related_blog_list()
    {
        $free_job_related_list = $this->freelancer_apply_model->free_job_related_blog_list();
        echo json_encode($free_job_related_list);
    }
    
}