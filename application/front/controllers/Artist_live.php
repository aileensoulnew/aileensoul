<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Artist_live extends MY_Controller {

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
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';

        include ('main_profile_link.php');
        include ('artistic_include.php');
    }

    public function index() {
        if($this->artist_profile_set ==1){
            redirect( $this->artist_profile_link);
        }
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist/registration');
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);

        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Artist Profile | Aileensoul";
    

        $this->load->view('artist_live/index', $this->data);
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
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Categories - Artist Profile | Aileensoul";
        $this->load->view('artist_live/category', $this->data);
    }

    public function categoryArtistList($category = '') {
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
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        echo$category_id = $this->db->select('category_id')->get_where('art_category', array('category_slug' => $category))->row_array('category_id');
        $this->data['category_id'] = $category_id['category_id'];
        $this->load->view('artist_live/categoryArtistList', $this->data);
    }

    public function artist_search() {
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
        $this->data['title'] = "Opportunities | Aileensoul";
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->data['q'] = $_GET['q'];
        $this->data['l'] = $_GET['l'];
        $this->load->view('artist_live/search', $this->data);
    }

    public function artistCategory() {
        $limit = $_GET['limit'];
        $artistCategory = $this->artistic_model->artistCategory($limit);
        echo json_encode($artistCategory);
    }

    public function artistAllCategory() {
        $artistAllCategory = $this->artistic_model->artistAllCategory();
        echo json_encode($artistAllCategory);
    }

    public function otherCategoryCount() {
        $otherCategoryCount = $this->artistic_model->otherCategoryCount();
        echo $otherCategoryCount;
    }

    public function artistListByCategory($id = '0') {
        $artistListByCategory = $this->artistic_model->artistListByCategory($id);
        echo json_encode($artistListByCategory);
    }

    public function searchArtistData() {
        $keyword = $_GET['q'];
        $city = $_GET['l'];

        $searchArtistData = $this->artistic_model->searchArtistData($keyword, $city);
        echo json_encode($searchArtistData);
    }

    public function art_category_slug() {
        $contition_array = array();
        $artCatData = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($artCatData as $k => $v) {
            $data = array('category_slug' => strtolower($this->common->clean($v['art_category'])));
            $insert_id = $this->common->update_data($data, 'art_category', 'category_id', $v['category_id']);
        }
        echo "yes";
    }

    // Signup Registration page
    public function registration() {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1');
        $this->data['art_category'] = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userid) {
            $this->data['profile_login'] = "login";
        } else {
            $this->data['profile_login'] = "live";
        }
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $recuser = $this->db->select('user_id')->get_where('art_reg', array('user_id' => $userid))->row()->user_id;
        }
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if ($recuser) {
            redirect('artist/home', refresh);
        } else {
            $this->load->view('artist_live/profile', $this->data);
        }
    }

    // Get country, state, city from id
    public function ajax_data() {

        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
            //Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Count total number of rows
            //Display states list
            if (count($state) > 0) {
                echo '<option value="">Select state</option>';
                foreach ($state as $st) {
                    echo '<option value="' . $st['state_id'] . '">' . $st['state_name'] . '</option>';
                }
            } else {
                echo '<option value="">State not available</option>';
            }
        }

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
            //Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => '1');
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Display cities list
            if (count($city) > 0) {
                echo '<option value="">Select city</option>';
                foreach ($city as $cit) {
                    echo '<option value="' . $cit['city_id'] . '">' . $cit['city_name'] . '</option>';
                }
            } else {
                echo '<option value="0">City not available</option>';
            }
        }
    }

    // Artist home tab. for post , after register success open this view
    public function art_post() {

        $user_name = $this->session->userdata('user_name');
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);
        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id,slug,art_user_image,art_name,art_lastname,profile_background,designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // for three userlist box condition_array start
        $contition_array = array('status' => '1', 'art_step' => '4', 'is_delete' => '0');
        $this->data['usercount'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('follow_type' => '1', 'follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1');
        $this->data['followcount'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('profile' => '1', 'user_from' => $artisticdata[0]['art_id']);
        $this->data['crosscount'] = $this->common->select_data_by_condition('user_ignore', $contition_array, $data = 'id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['get_url'] = $this->get_url($userid);

        if (!$this->data['artisticdata']) {
            redirect('find-artist');
        } else {
            $this->data['left_artistic'] = $this->load->view('artist/left_artistic', $this->data, true);
            $artistic_name = $this->get_artistic_name($id);
            $this->data['title'] = 'Home | Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/art_post', $this->data);
        }
    }

    public function get_url($userid) {

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

    //Get artistic Name for title Start
    public function get_artistic_name($id = '') {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $id, 'status' => '1', 'is_delete' => '0');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        return $artistic_name = ucfirst($artdata[0]['art_name']) . ' ' . ucwords($artdata[0]['art_lastname']);
    }
}
