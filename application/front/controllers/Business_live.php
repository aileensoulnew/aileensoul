<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_live extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('business_model');        
        $this->load->library('S3');
        
        include ('main_profile_link.php');
        include ('business_include.php');

        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
    }

    public function index() {
        // Check if business deactivate or not.
        $userid = $this->session->userdata('aileenuser');
        $this->data['isbusinessdeactivate'] = false;
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($business_deactive) {
            $this->data['isbusinessdeactivate'] = true;
        }
        if($this->business_profile_set==1 && !$business_deactive){
            return redirect($this->business_profile_link); 
        }
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
       
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['business_profile_set'] =  $this->business_profile_set;
        // $this->data['business_profile_link'] = $this->business_profile_link;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');
       
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->data['title'] = "Grow Business Network and Get Your Business Listed".TITLEPOSTFIX;
        $this->data['metadesc'] = "Search for Real Estate, Fashion, Home appliance, and many more businesses at your near by locations from Aileensoul. Also, you can List your business Now. It's Free.";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $limit = 8;
        $this->data['businessCategory'] = $this->business_model->businessCategory($limit);
        $this->data['businessLocation'] = $this->business_model->businessLocation($limit);
        $this->data['business_related_list'] = $this->business_model->business_related_blog_list();
        $this->load->view('business_data/index', $this->data);
    }

    public function category() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != "")
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        
        $this->data['title'] = "Search Top Businesses by Category".TITLEPOSTFIX;
        $this->data['metadesc'] = "Get details of various businesses from different field like IT sector, Automobile, Real Estate, Clothing, Beverages, and so on."; 

        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');

        $limit = 15;
        $config = array(); 
        $config["base_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->business_model->get_business_category_total_rec();
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
        $this->data['businessAllCategory'] = $this->business_model->businessAllCategory($page,$limit)['bus_cat'];
        $this->data['links'] = $this->pagination->create_links();
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);

        $this->load->view('business_data/category', $this->data);
    }

    public function categoryBusinessList($category = '', $location = '',$sertype = "") {
        $userid = $this->session->userdata('aileenuser');
        $businessresult = $this->checkbusinessdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->data['category_id'] = "";
        $category_id = "";
        if($category != "")
        {            
            $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row('industry_id');
            $this->data['category_id'] = $category_id;
        }

        $this->data['location_id'] = '';
        $location_id = "";
        if($location != "")
        {
            $location_id = $this->db->select('city_id')->get_where('cities', array('slug' => $location))->row('city_id');
            $this->data['location_id'] = $location_id;
        }
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['q'] = $category;
        $this->data['l'] = $location;
        $this->data['category_txt'] = $tmCat = ucwords(str_replace("-"," ",$category));
        $this->data['location_txt'] = $tmLoc = ucwords(str_replace("-"," ",$location));

        if($sertype == 1)
        {
            $this->data['title'] = $tmCat." Business in ".$tmLoc.TITLEPOSTFIX;
            $this->data['metadesc'] = $tmCat." Business: Find and get the contact and location details of various ".$tmCat." Business at ".$tmLoc." on Aileensoul. Visit to know more.";
        }
        else if($sertype == 2)
        {
            $this->data['title'] = $tmCat." Business".TITLEPOSTFIX;
            $this->data['metadesc'] = "Looking for ".$tmCat."? Find and get the contact details of various ".$tmCat." Business at your near by location on Aileensoul. Visit to know more.";
        }        
        
        $this->data['industry_name'] = $industry_name = ($this->input->post('industry_name') ? $this->input->post('industry_name') : "");
        $this->data['city_name'] = $city_name = ($this->input->post('city_name') ? $this->input->post('city_name') : "");
        $limit_cl = 5;
        $this->data['businessCategory'] = $this->business_model->businessCategory($limit_cl);
        $this->data['businessLocation'] = $this->business_model->businessLocation($limit_cl);
        $this->data['business_left'] = $this->load->view('business_data/business_left', $this->data, TRUE);

        $limit = 15;
        $config = array(); 
        $config["base_url"] = $this->data["filter_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->business_model->businessListByFilterTotalRec($category_id,$location_id,$industry_name,$city_name);
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
        $this->data['businessList'] = $businessListByLocation = $this->business_model->businessListByFilter($category_id,$location_id,$page,$limit,$industry_name,$city_name);
        // print_r($this->data['businessList']);
        $this->data['links'] = $this->pagination->create_links();

        $this->load->view('business_data/categoryBusinessList', $this->data);
    }

    public function business_search($searchquery = '') {
        $businessresult = $this->checkbusinessdeactivate();
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Search - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            $this->data['ismainregister'] = true;
        }
        if($searchquery != ''){
            $isloacationsearch = false;
            $search_location;
            if (substr($searchquery, 0, strlen("business-in-")) === "business-in-") {
                $search_location = explode("business-in-", $searchquery);
            }
            $search_category = explode("-in-", $searchquery);
            $this->data['q'] = '';
            $this->data['l'] = '';
            if(count($search_location) > 0){
                $this->data['q'] = '';
                $this->data['l'] = $search_location[1];
            }
            else if(count($search_category) > 0){
                $this->data['q'] = str_replace("-business", "", $search_category[0]);
                $this->data['l'] = $search_category[1];
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

        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->load->view('business_data/search', $this->data);
    }

    public function businessCategory() {
        $limit = $_GET['limit'];
        $businessCategory = $this->business_model->businessCategory($limit);
        echo json_encode($businessCategory);
    }

    public function businessAllCategory() {
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = ($_GET['limit']) ? $_GET['limit'] : 15;
        $businessAllCategory = $this->business_model->businessAllCategory($page,$limit);
        echo json_encode($businessAllCategory);
    }

    public function otherCategoryCount() {
        $otherCategoryCount = $this->business_model->otherCategoryCount();
        echo $otherCategoryCount;
    }

    public function businessListByCategory($id = '0') {
        $businessListByCategory = $this->business_model->businessListByCategory($id);
        echo json_encode($businessListByCategory);
    }

    public function searchBusinessData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];
        $page = $_GET['page'];
        $limit = '5';
        $category_id = $_GET['category_id'];
        $location_id = $_GET['location_id'];
        $searchBusinessData = $this->business_model->searchBusinessData($keyword,$city,$category_id,$location_id,$page,$limit);
        echo json_encode($searchBusinessData);
    }

    public function industry_slug() {

        $contition_array = array('industry_id !=' => '0');
        $inddata = $this->common->select_data_by_condition('industry_type', $contition_array, $data = 'industry_id,industry_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($inddata as $k => $v) {
            $data = array('industry_slug' => strtolower($this->common->clean($v['industry_name'])));
            $insert_id = $this->common->update_data($data, 'industry_type', 'industry_id', $v['industry_id']);
        }
        echo "yes";
    }

    // Top Business Location 
    public function businessLocation() {
        $limit = ($_GET['limit']) ? $_GET['limit'] : 5;
        $businessLocation = $this->business_model->businessLocation($limit);
        echo json_encode($businessLocation);
    }

    // Top Business Location 
    public function businessAllLocation() {
        $limit = ($_GET['limit']) ? $_GET['limit'] : 15;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $businessLocation = $this->business_model->businessAllLocation($page,$limit);
        echo json_encode($businessLocation);
    }

    // Get location of business
    public function location() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');

        $limit = 15;
        $config = array(); 
        $config["base_url"] = $this->data["filter_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->business_model->get_business_location_total_rec();
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
        $this->data['businessLocation'] = $this->business_model->businessAllLocation($page,$limit)['bus_loc'];
        $this->data['links'] = $this->pagination->create_links();
        $this->data['title'] = "Search Top Businesses by Location".TITLEPOSTFIX;
        $this->data['metadesc'] = "Find and get details of various business and services nearby your location on Aileensoul.com"; 
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->load->view('business_data/location', $this->data);
    }

    public function locationBusinessList($location = '') {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid)
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        // $this->data['location_txt'] = $location_txt = ucwords(str_replace("-"," ",$location));
        
        $locationdata = $this->business_model->getlocationdatafromslug($location);
        $this->data['location_id'] = $location_id = $locationdata['city_id'];
        $this->data['location_txt'] = $location_txt = $locationdata['city_name'];

        //$this->data['title'] = "Business in ".ucwords(str_replace("-"," ",$location))." | Aileensoul";
        $this->data['title'] = "Businesses in ".$location_txt.": Get Details of Top Business".TITLEPOSTFIX;
        $this->data['metadesc'] = "View address and contact information of business established in ".$location_txt.". Register to connect and know more about business."; 
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->data['business_profile_set'] = $this->business_profile_set;
        $limit = 5;
        $this->data['businessCategory'] = $this->business_model->businessCategory($limit);
        $this->data['businessLocation'] = $this->business_model->businessLocation($limit);

        $this->data['industry_name'] = $industry_name = ($this->input->post('industry_name') ? $this->input->post('industry_name') : "");
        $this->data['city_name'] = $city_name = ($this->input->post('city_name') ? $this->input->post('city_name') : "");

        $this->data['business_left'] = $this->load->view('business_data/business_left', $this->data, TRUE);
        $limit = 15;
        $config = array(); 
        $config["base_url"] = $this->data["filter_url"] = base_url().$this->uri->segment(1);
        $config["total_rows"] = $this->business_model->businessListByLocationTotalRec($location_id,$industry_name,$city_name);
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
        $this->data['businessList'] = $businessListByLocation = $this->business_model->businessListByLocation($location_id,$page,$limit,$industry_name,$city_name);
        // print_r($this->data['businessList']);exit;
        $this->data['links'] = $this->pagination->create_links();
        $this->load->view('business_data/categoryBusinessList', $this->data);
    }

    // Get Location list from city id
    public function businessListByLocation($cat_id = '0',$loc_id = '0') {
        $businessListByLocation = $this->business_model->businessListByLocation($cat_id, $loc_id);
        echo json_encode($businessListByLocation);
    }

    // Get Business list from city id or location id
    public function businessListByFilter() {
        $category_id = $_POST['category_id'];
        $location_id = $_POST['location_id'];
        $artistListByFilter = $this->business_model->businessListByFilter($category_id,$location_id);
        echo json_encode($artistListByFilter);
    }

    function checkbusinessdeactivate(){
        $userid = $this->session->userdata('aileenuser');
        $this->data['isbusinessdeactivate'] = false;
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_deleted' => '0');
        $business_deactive = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_profile_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if (count($business_deactive) > 0) {
            $this->data['isbusinessdeactivate'] = true;
        }
    }

    // Get location of business
    public function business_by_business() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');

        $page = 1;
        $limit = 20;
        $jobCat = $this->business_model->get_business_by_categories($page,$limit);
        $jobCity = $this->business_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {

                $total_buss = $this->business_model->businessListByFilterTotalRec($jcv['industry_id'],$value['city_id'],$industry_name = array(),$city_name = array());
                if($total_buss > 0)
                {                    
                    $all_link[$value['slug']][$i]['name'] = $jcv['industry_name']." Business In ".$value['city_name'];
                    $all_link[$value['slug']][$i]['slug'] = $jcv['industry_slug']."-business-in-".$value['slug'];
                    $i++;
                }
            }
        }

        $this->data['businessByBusiness'] = $all_link;
        
        $this->data['title'] = "Search Top 20 Location-Wise Business by Category | Aileensoul";
        $this->data['metadesc'] = "View details of top 20 sector businesses nearby your location. Visit Aileensoul.com to know more."; 
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->load->view('business_data/business_by_business', $this->data);
    }

    public function view_more_business()
    {
       $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if($userid != '')
        {
            $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        }
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');
        $this->data['search_banner'] = $this->load->view('business_data/search_banner', $this->data, TRUE);
        $this->load->view('business_data/view_more_business', $this->data);
    }

    public function business_by_category_location_ajax()
    {        
        $page = 1;
        $limit = 20;
        $jobCat = $this->business_model->get_business_by_categories($page,$limit);
        $jobCity = $this->business_model->get_job_city($page,$limit);        
        $all_link = array();
        foreach ($jobCity['job_city'] as $key => $value) {
            $i=0;
            foreach ($jobCat['job_cat'] as $jck => $jcv) {
                $all_link[$value['slug']][$i]['name'] = $jcv['industry_name']." Business In ".$value['city_name'];
                $all_link[$value['slug']][$i]['slug'] = $jcv['industry_slug']."-business-in-".$value['slug'];
                $i++;
            }
        }
        echo json_encode($all_link);
    }

    // GET RELATED BLOG LIST
    public function get_business_related_blog_list()
    {
        $business_related_list = $this->business_model->business_related_blog_list();
        echo json_encode($business_related_list);
    }

    public function business_create_search_table()
    {
        $this->business_model->business_create_search_table();
    }
}
