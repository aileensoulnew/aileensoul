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
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['business_profile_set'] =  $this->business_profile_set;
        // $this->data['business_profile_link'] = $this->business_profile_link;
        $this->data['business_profile_link'] =  ($this->business_profile_set == 1)? $this->business_profile_link :base_url('business-profile/registration/business-information');
       
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->load->view('business_live/index', $this->data);
    }

    public function category() {
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
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['page'] = '';
        $this->load->view('business_live/category', $this->data);
    }

    public function categoryBusinessList($category = '') {
        $userid = $this->session->userdata('aileenuser');
        $businessresult = $this->checkbusinessdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Category - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $category_id = $this->db->select('industry_id')->get_where('industry_type', array('industry_slug' => $category))->row_array('industry_id');
        $this->data['category_id'] = $category_id['industry_id'];
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->load->view('business_live/categoryBusinessList', $this->data);
    }

    public function business_search($searchquery = '') {
        $businessresult = $this->checkbusinessdeactivate();
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Search - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
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
                $this->data['q'] = $search_category[0];
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
        $this->load->view('business_live/search', $this->data);
    }

    public function businessCategory() {
        $limit = $_GET['limit'];
        $businessCategory = $this->business_model->businessCategory($limit);
        echo json_encode($businessCategory);
    }

    public function businessAllCategory() {
        $businessAllCategory = $this->business_model->businessAllCategory();
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
        $category_id = $_GET['category_id'];
        $location_id = $_GET['location_id'];
        $searchBusinessData = $this->business_model->searchBusinessData($keyword,$city,$category_id,$location_id);
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
        $limit = $_GET['limit'];
        $businessLocation = $this->business_model->businessLocation($limit);
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
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Categories - Business Profile | Aileensoul";
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->data['page'] = 'location';

        $this->load->view('business_live/category', $this->data);
    }

    public function locationBusinessList($location = '') {
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
        $this->data['title'] = "Category - Business Profile | Aileensoul";
        $this->data['search_banner'] = $this->load->view('business_live/search_banner', $this->data, TRUE);
        $locationdata = $this->business_model->getlocationdatafromname($location);
        $this->data['location_id'] = $locationdata['city_id'];
        $this->data['business_profile_set'] = $this->business_profile_set;
        $this->load->view('business_live/categoryBusinessList', $this->data);
    }

    // Get Location list from city id
    public function businessListByLocation($id = '0') {
        $businessListByLocation = $this->business_model->businessListByLocation($id);
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
}
