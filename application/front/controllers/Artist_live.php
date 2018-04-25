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
        if($this->artist_profile_set==1){
            redirect($this->artist_profile_link);
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
            $this->data['left_artistic'] = $this->load->view('artist_live/left_artistic', $this->data, true);
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

    // Art dashboard
    public function art_manage_post($id = "") {

        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $user_name = $this->session->userdata('user_name');

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];
        $artisticslug = $this->db->select('art_id')->get_where('art_reg', array('user_id' => $this->session->userdata('aileenuser')))->row()->art_id;
        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step,user_id,art_user_image,art_name,art_lastname,designation,slug,art_id,art_skill,art_yourart,art_desc_art,art_email,art_city,art_country,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['artid'] = $this->data['artisticdata'][0]['user_id'];
        $this->data['get_url'] = $get_url = $this->get_url($this->data['artisticdata'][0]['user_id']);

        $artistic_name = $this->get_artistic_name($this->data['artid']);
        $this->data['title'] = $artistic_name . ' | Dashboard' . '- Artistic Profile' . TITLEPOSTFIX;

        if ($userid) {

            if (!$this->data['artisticdata'] && !$this->data['artsdata']) {
                $this->load->view('artist/notavalible');
            } else if ($this->data['artisticdata'][0]['art_step'] != '4') {
                redirect('artist');
            } else {
                $this->data['artistic_common'] = $this->load->view('artist/artistic_common', $this->data, true);
                if ($get_url == $this->uri->segment(3)) {
                    $this->load->view('artist_live/art_manage_post', $this->data);
                } else {
                    redirect('artist/dashboard/' . $get_url, refresh);
                }
            }
        } else {


            if (!$this->data['artisticdata'] && !$this->data['artsdata']) {
                $this->load->view('artist/notavalible');
            } else {

                include ('artistic_include.php');
                $this->data['artistic_common_profile'] = $this->load->view('artist/artistic_common_profile', $this->data, true);
                if ($get_url == $this->uri->segment(3)) {
                    $this->load->view('artist_live/art_dashboard_live', $this->data);
                } else {
                    redirect('artist/dashboard/' . $get_url, refresh);
                }
            }
        }
    }

    // ARTIST PROFILE DETAIL
    public function artistic_profile($id = "") {
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_email,art_phnno,art_country,art_state,art_city,art_pincode,art_address,art_yourart,art_skill,art_desc_art,art_inspire,art_bestofmine,art_portfolio,user_id,art_step,art_user_image,profile_background,designation,slug,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($this->data['artisticdata'][0]['user_id']);

        $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
        $this->data['title'] = $this->data['title'] = $artistic_name . ' | Details' . '- Artistic Profile' . TITLEPOSTFIX;

        if ($userid) {
            if ($this->data['artisticdata']) {

                $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
                $this->load->view('artist_live/artistic_profile', $this->data);
            } else if (!$this->data['artisticdata'] && $id != $userid) {
                $this->load->view('artist_live/notavalible');
            } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
                redirect('artist');
            }
        } else {

            include ('artistic_include.php');
            $this->data['artistic_common_profile'] = $this->load->view('artist_live/artistic_common_profile', $this->data, true);
            $this->load->view('artist_live/art_profile_live', $this->data);
        }
    }

    // ARTIST PTHOTO
    public function art_photos($id = "") {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];

        $contition_array = array('art_id' => $regid, 'status' => '1');

        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'is_delete' => '0');

        $artisticpost = $this->data['artisticdatapost'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        foreach ($artisticpost as $value) {


            $contition_array = array('insert_profile' => '1', 'is_deleted' => '1', 'post_id' => $value['art_post_id']);

            $art_data = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $a_d[] = $art_data;
        }

        foreach ($a_d as $key_ad => $value_ad) {
            foreach ($value_ad as $art_fn => $v) {

                $art_data[] = $v;
            }
        }

        $art_data = array_unique($art_data, SORT_REGULAR);

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);


        $this->data['artistic_data'] = $art_data;

        if ($this->data['artisticdata']) {
            $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Photos' . ' | Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/art_photos', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {

            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('find-artist');
        }
    }

    // ARTIST VIDEO
    public function art_videos($id) {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);


        if ($this->data['artisticdata']) {
            $this->data['artistic_common'] = $this->load->view('artist/artistic_common', $this->data, true);
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Video' . '- Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/art_videos', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {

            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('artist');
        }
    }

    //multiple videos for user end 
    //multiple audios for user start

    //  ARTIST AUDIO
    public function art_audios($id) {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => '1', 'is_delete' => '0');

        $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);


        if ($this->data['artisticdata']) {
            $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Audio' . ' | Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/art_audios', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {

            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('artist');
        }
    }

    //multiple audios for user end  
    //multiple pdf for user start

    // ARTIST PDF  
    public function art_pdf($id) {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];


        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $artisticdata[0]['user_id'], 'status' => '1', 'is_delete' => '0');

        $this->data['artistic_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data, $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);


        if ($this->data['artisticdata']) {
            $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | PDF' . ' | Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/art_pdf', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {

            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('artist');
        }
    }


    public function followers($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];


        $contition_array = array('art_id' => $regid, 'status' => '1', 'is_delete' => '0', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_skill,user_id,art_step,art_user_image,profile_background,designation,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($this->data['artisticdata'][0]['user_id']);


        if ($this->data['artisticdata']) {
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Followers' . '- Artistic Profile' . TITLEPOSTFIX;
            $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
            $this->load->view('artist_live/art_followers', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {
            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('artist');
        }
    }

    public function ajax_followers($id = "") {
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


        if ($id == $userid || $id == '') {

            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_id');
            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';
            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'art_reg.art_step' => '4', 'follow_status' => '1');
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1');
            $followerdata = $this->data['followingdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id,follow_type,follow_from,follow_to,follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($followerdata as $followkey) {
                $contition_array = array('art_id' => $followkey['follow_from'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artaval) {

                    $userlist1[] = $artaval;
                }
            }
        } else {

            $artdata = $this->common->select_data_by_id('art_reg', 'user_id', $id, $data = 'art_id');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_to';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => 1, 'follow_type' => '1', 'art_reg.art_step' => '4', 'follow_status' => '1',);
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');

            $contition_array = array('follow_to' => $artdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1');
            $followerdata = $this->data['followingdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id,follow_type,follow_from,follow_to,follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($followerdata as $followkey) {
                $contition_array = array('art_id' => $followkey['follow_from'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artaval) {

                    $userlist1[] = $artaval;
                }
            }
        }

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($userlist1) > 0) {
            foreach ($userlist as $user) {


                $contition_array = array('art_id' => $user['follow_from'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $geturl = $this->get_url($artaval[0]['user_id']);

                if ($artaval) {

                    $return_html .= '<div class="profile-job-post-detail clearfix">
                                                        <div class="profile-job-post-title-inside clearfix">
                                                            <div class="profile-job-post-location-name">
                                                                <div class="user_lst">
                                                                    <ul>
                                                                        <li class="fl">
                                                                            <div class="follow-img">';


                    $return_html .= '<a href="' . base_url('artist/dashboard/' . $geturl) . '">';

                    if (IMAGEPATHFROM == 'upload') {
                        if ($artaval[0]['art_user_image']) {
                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artaval[0]['art_user_image'])) {

                                $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                            } else {
                                $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $artaval[0]['art_user_image'] . '" alt="' . $artaval[0]['art_user_image'] . '" >';
                            }
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                        }
                    } else {
                        $filename = $this->config->item('art_profile_thumb_upload_path') . $artaval[0]['art_user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                        if ($info) {

                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $artaval[0]['art_user_image'] . '" height="50px" width="50px" alt="' . $artaval[0]['art_user_image'] . '" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                        }
                    }
                    $return_html .= '</a>';

                    $return_html .= '</div>
                                    </li>
                                     <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text " style="padding: 0;">
                                                <a href="' . base_url('artist/dashboard/' . $geturl) . '">' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '</a></div>
                                        <div>';
                    $return_html .= '<a>';
                    if ($artaval[0]['designation']) {
                        $return_html .= ucfirst(strtolower($artaval[0]['designation']));
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</a>
                                </div>
                                </li>
                                <li class="fr" id ="frfollow' . $user['follow_from'] . '">';
                    $contition_array = array('user_id' => $userid, 'status' => '1');
                    $artisticdatauser = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


                    $contition_array = array('follow_from' => $artisticdatauser[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'follow_to' => $user['follow_from']);
                    $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

                    //echo "<pre>"; print_r($status_list); die();

                    if (($status_list[0]['follow_status'] == '0' || $status_list[0]['follow_status'] == ' ' ) && $user['follow_from'] != $artisticdatauser[0]['art_id']) {

                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "followdiv">
                                <button id="follow' . $user['follow_from'] . '" onClick="followuser_two(' . $user['follow_from'] . ')"><span>Follow</span></button>
                                                                                </div>';
                    } else if ($user['follow_from'] == $artisticdatauser[0]['art_id']) {
                        
                    } else {
                        $return_html .= '<div class="user_btn follow_btn_' . $user['follow_from'] . '" id= "unfollowdiv">
                                        <button class="bg_following" id="unfollow' . $user['follow_from'] . '" onClick="unfollowuser_two(' . $user['follow_from'] . ')"><span>Following</span></button>
                                                                                </div>';
                    }
                    $return_html .= '</li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ';
                }
            }
        } else {
            $return_html .= '<div class="art-img-nn" id= "art-blank" style="display: block">
                                                <div class="art_no_post_img">
                                                    <img src="' . base_url('assets/img/icon_no_follower.png') . '" alt="icon_no_follower.png">
                                                </div>
                                                <div class="art_no_post_text">
                                                    No Followers Available.
                                                </div>
                                            </div>';
        }

        echo $return_html;
    }

    public function following($id = "") {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $segment3 = explode('-', $this->uri->segment(3));
        $slugdata = array_reverse($segment3);
        $regid = $slugdata[0];

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_skill,user_id,art_step,art_user_image,profile_background,designation,slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($this->data['artisticdata'][0]['user_id']);



        if ($this->data['artisticdata']) {
            $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Following' . '- Artistic Profile' . TITLEPOSTFIX;
            $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);

            $this->load->view('artist_live/art_following', $this->data);
        } else if (!$this->data['artisticdata'] && $id != $userid) {

            $this->load->view('artist_live/notavalible');
        } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
            redirect('artist');
        }
    }

// end of user lidt


    public function ajax_following($id = "") {
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        if ($id == $userid || $id == '') {
            $this->data['artisticdata'] = $artisticdata = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_id, user_id');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'art_reg.art_step' => '4', 'art_reg.status' => '1');
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');

            $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1');
            $followingdata = $this->data['followingdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id,follow_type,follow_from,follow_to,follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($followingdata as $followkey) {
                $contition_array = array('art_id' => $followkey['follow_to'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artaval) {

                    $userlist1[] = $artaval;
                }
            }
        } else {

            $this->data['artisticdata'] = $artisticdata = $this->common->select_data_by_id('art_reg', 'user_id', $id, $data = 'art_id, user_id');

            $join_str[0]['table'] = 'follow';
            $join_str[0]['join_table_id'] = 'follow.follow_from';
            $join_str[0]['from_table_id'] = 'art_reg.art_id';
            $join_str[0]['join_type'] = '';

            $limit = $perpage;
            $offset = $start;

            $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'art_reg.art_step' => '4', 'art_reg.status' => '1');
            $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit, $offset, $join_str, $groupby = '');

            $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1');
            $followingdata = $this->data['followingdata'] = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_id,follow_type,follow_from,follow_to,follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($followingdata as $followkey) {
                $contition_array = array('art_id' => $followkey['follow_to'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($artaval) {

                    $userlist1[] = $artaval;
                }
            }
        }
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($userlist1) > 0) {
            foreach ($userlist as $user) {
                $contition_array = array('art_id' => $user['follow_to'], 'status' => '1');
                $artaval = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image,art_name,art_lastname,designation,slug,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $geturl = $this->get_url($artaval[0]['user_id']);
                if ($artaval) {
                    $return_html .= '
                        <div class = "profile-job-post-detail clearfix" id = "removefollow' . $user['follow_to'] . '">
                            <div class = "profile-job-post-title-inside clearfix">
                                <div class = "profile-job-post-location-name">
                                    <div class = "user_lst">
                                        <ul>
                                            <li class = "fl padding_les_left rsp"">
                                                <div class = "follow-img">';


                    $return_html .= '<a href="' . base_url('artist/dashboard/' . $geturl) . '" title="' . ucfirst(strtolower($artaval[0]['art_name'])) . ' ' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '">';

                    if (IMAGEPATHFROM == 'upload') {
                        if ($artaval[0]['art_user_image']) {
                            if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $artaval[0]['art_user_image'])) {

                                $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                            } else {
                                $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $artaval[0]['art_user_image'] . '" alt="' . $artaval[0]['art_user_image'] . '" >';
                            }
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                        }
                    } else {
                        $filename = $this->config->item('art_profile_thumb_upload_path') . $artaval[0]['art_user_image'];
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                        if ($info) {

                            $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $artaval[0]['art_user_image'] . '" height="50px" width="50px" alt="' . $artaval[0]['art_user_image'] . '" >';
                        } else {
                            $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                        }
                    }
                    $return_html .= '</a>';

                    $return_html .= '</div>
                                    </li>
                                    <li class="folle_text">
                                        <div class="">
                                            <div class="follow-li-text" style="padding: 0;">
                                                <a title="' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '" href="' . base_url('artist/dashboard/' . $geturl) . '">' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '</a></div>
                                            <div>';

                    $return_html .= '<a>';
                    if ($artaval[0]['designation']) {
                        $return_html .= ucfirst(strtolower($artaval[0]['designation']));
                    } else {
                        $return_html .= 'Current Work';
                    }

                    $return_html .= '</a>
                                            </div>
                                    </li>';
                    $userid = $this->session->userdata('aileenuser');
                    if ($artisticdata[0]['user_id'] == $userid) {
                        $return_html .= '<li class="fr fruser' . $user['follow_to'] . '">';

                        $contition_array = array('follow_from' => $artisticdata[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'follow_to' => $user['follow_to']);
                        $status = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        if ($status[0]['follow_status'] == '1') {
                            $return_html .= '<div class="user_btn" id= "unfollowdiv">
                                            <button class="bg_following" id="unfollow' . $user['follow_to'] . '" onClick="unfollowuser_list(' . $user['follow_to'] . ')"><span>Following</span></button>
                                        </div>';
                        }
                        $return_html .= '</li>';
                    } else {
                        $return_html .= '<li class="fr" id ="frfollow' . $user['follow_to'] . '">';

                        $contition_array = array('user_id' => $userid, 'status' => '1');
                        $artisticdatauser = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        $contition_array = array('follow_from' => $artisticdatauser[0]['art_id'], 'follow_status' => '1', 'follow_type' => '1', 'follow_to' => $user['follow_to']);
                        $status_list = $this->common->select_data_by_condition('follow', $contition_array, $data = 'follow_status', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if (($status_list[0]['follow_status'] == 0 || $status_list[0]['follow_status'] == ' ' ) && $user['follow_to'] != $artisticdatauser[0]['art_id']) {
                            $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "followdiv">
                                            <button id="<?php
                                                    echo "follow"' . $user['follow_to'] . '" onClick="followuser_two(' . $user['follow_to'] . ')"><span>Follow</span></button>
                            </div>';
                        } else if ($user['follow_to'] == $artisticdatauser[0]['art_id']) {
                            
                        } else {
                            $return_html .= '<div class="user_btn follow_btn_' . $user['follow_to'] . '" id= "unfollowdiv">
                                <button class="bg_following" id="unfollow"' . $user['follow_to'] . '" onClick = "unfollowuser_two(' . $user['follow_to'] . ')"><span>Following</span></button>
                                                    </div>';
                        }
                        $return_html .= '</li>';
                    }
                    $return_html .= '</ul>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    </div>
                                                    ';
                }
            }
        } else {

            $return_html .= '<div class = "art-img-nn">
                                                    <div class = "art_no_post_img">
                                                    <img src = "' . base_url('assets/img/icon_no_following.png') . '" alt="icon_no_following.png">
                                                    </div>
                                                    <div class = "art_no_post_text">
                                                    No Following Available.
                                                    </div>
                                                    </div>';
        }
        $return_html .= '<div class = "col-md-1">
                                                    </div>';

        echo $return_html;
    }

}
