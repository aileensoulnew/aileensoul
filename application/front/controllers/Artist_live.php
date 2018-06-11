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
        $art_country_data = $this->getcountryandskill();
        include ('main_profile_link.php');
        include ('artistic_include.php');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
        // $artresult = $this->checkisartistdeactivate();
        // else {
        if($this->artist_profile_set == 1 && $this->data['isartistactivate'] == true){
            redirect($this->artist_profile_link);
        }
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Artist Profile | Aileensoul";
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->load->view('artist_live/index', $this->data);
        // }
    }

    public function category() {
        $this->load->view('artist_live/category', $this->data);
    }

    public function view_more_artist() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Categories - Artist Profile | Aileensoul";
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->load->view('artist_live/view_more_artist', $this->data);
    }

    public function categoryArtistList($category = '', $location = '') {
        $userid = $this->session->userdata('aileenuser');
        // $artresult = $this->checkisartistdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Artist Category | Aileensoul";
        
        $category_id = $this->db->select('category_id')->get_where('art_category', array('category_slug' => $category))->row_array('category_id');
        $this->data['category_id'] = $category_id['category_id'];

        $city_id = $this->db->select('city_id')->get_where('cities', array('slug' => $location))->row('city_id');
        $this->data['location_id'] = '';
        if($location != "")
            $this->data['location_id'] = $city_id;

        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['q'] = $category;
        $this->data['l'] = $location;
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->load->view('artist_live/categoryArtistList', $this->data);
    }

    public function artist_search($searchquery = '') {
        $userid = $this->session->userdata('aileenuser');
        // $artresult = $this->checkisartistdeactivate();
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Artist Search | Aileensoul";
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            $this->data['ismainregister'] = true;
        }
        if($searchquery != ''){
            $isloacationsearch = false;
            $search_location;
            if (substr($searchquery, 0, strlen("artist-in-")) === "artist-in-") {
                $search_location = explode("artist-in-", $searchquery);
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
        $this->data['is_artist_profile_set'] = $this->artist_profile_set;
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
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
        $category_id = $_GET['category_id'];
        $location_id = $_GET['location_id'];

        $searchArtistData = $this->artistic_model->searchArtistData($keyword, $city, $category_id,$location_id);
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
        if (count($recuser) > 0) {
            redirect('artist-profile', refresh);
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

    //Get artistic Name for title Start
    public function get_artistic_name($id = '') {

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $id, 'status' => '1', 'is_delete' => '0');
        $artdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        return $artistic_name = ucfirst($artdata[0]['art_name']) . ' ' . ucwords($artdata[0]['art_lastname']);
    }

    // Art dashboard
    public function art_manage_post($slugname = "") {
        $userid = $this->session->userdata('aileenuser');
        // $this->data['slugid'] = $id;
        if ($slugname == '' && $userid == '') {
            redirect('login');
        } elseif ($slugname == '' && $userid != '') {
            redirect('find-artist');
        }

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);
        
        // $artcountrydata = $this->getcountryandskill();
       
        // if (count($artistic_deactive) > 0) {
        //     redirect('find-artist');
        // }
        //if user deactive profile then redirect to artist/index untill active profile End
        $user_name = $this->session->userdata('user_name');
      
        // $segment3 = explode('-', $this->uri->segment(2));
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];
        // $regid = $slugdata[0];
        $artisticslug = $this->db->select('art_id')->get_where('art_reg', array('user_id' => $this->session->userdata('aileenuser')))->row()->art_id;

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step,user_id,art_user_image,art_name,art_lastname,designation,slug,art_id,art_skill,art_yourart,art_desc_art,art_email,art_city,art_country,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        
        $this->data['artid'] = $this->data['artisticdata'][0]['user_id'];
        $this->data['get_url'] = $get_url = $this->get_url($this->data['artisticdata'][0]['user_id']);
        $artistic_name = $this->get_artistic_name($this->data['artid']);
        $this->data['title'] = $artistic_name . ' | Dashboard' . '- Artistic Profile' . TITLEPOSTFIX;

        if ($userid && count($artistic_deactive) <= 0 && $this->data['artist_isregister']) {
            if (!$this->data['artisticdata'] && !$this->data['artsdata']) {
                $this->load->view('artist/notavalible');
            } else if ($this->data['artisticdata'][0]['art_step'] != '4') {
                redirect('find-artist');
            } else {
                $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
                if ($get_url == $slugname) {
                    $this->load->view('artist_live/art_manage_post', $this->data);
                } else {
                    redirect('artist/p/'. $get_url .'/dashboard', refresh);
                }
            }
        } else {
            if (!$this->data['artisticdata'] && !$this->data['artsdata']) {
                $this->load->view('artist/notavalible');
            } else {
                include ('artistic_include.php');
                $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
                $this->data['artistic_common_profile'] = $this->load->view('artist_live/artistic_common_profile', $this->data, true);
                if ($get_url == $slugname) {
                    $this->load->view('artist_live/art_dashboard_live', $this->data);
                } else {
                    redirect('artist/p/'. $get_url .'/dashboard', refresh);
                }
            }
        }
    }

    // ARTIST PROFILE DETAIL
    public function artistic_profile($slugname = "") {
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            
        // $artcountrydata = $this->getcountryandskill();
        if (count($artistic_deactive) > 0) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];

        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_email,art_phnno,art_country,art_state,art_city,art_pincode,art_address,art_yourart,art_skill,art_desc_art,art_inspire,art_bestofmine,art_portfolio,user_id,art_step,art_user_image,profile_background,designation,slug,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['get_url'] = $this->get_url($this->data['artisticdata'][0]['user_id']);

        $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
        $this->data['title'] = $this->data['title'] = $artistic_name . ' | Details' . '- Artistic Profile' . TITLEPOSTFIX;

        if ($userid && count($artistic_deactive) <= 0 && $this->data['artist_isregister']) {
            if ($this->data['artisticdata']) {
                $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
                $this->load->view('artist_live/artistic_profile', $this->data);
            } else if (!$this->data['artisticdata'] && $id != $userid) {
                $this->load->view('artist_live/notavalible');
            } else if (!$this->data['artisticdata'] && ($id == $userid || $id == "")) {
                redirect('find-artist');
            }
        } else {
            include ('artistic_include.php');
            $this->data['artistic_name'] = ucwords($artresult[0]['art_name']) . ' ' . ucwords($artresult[0]['art_lastname']);
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            $this->data['artistic_common_profile'] = $this->load->view('artist_live/artistic_common_profile', $this->data, true);
            $this->load->view('artist_live/art_profile_live', $this->data);
        }
    }

    // ARTIST PTHOTO
    public function art_photos($slugname = "") {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if (count($artistic_deactive) > 0) {
            // $this->getcountryandskill();
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];

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
    public function art_videos($slugname = '') {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if (count($artistic_deactive) > 0) {
            // $this->getcountryandskill();
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];
        
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
            redirect('find-artist');
        }
    }

    //multiple videos for user end 
    //multiple audios for user start

    //  ARTIST AUDIO
    public function art_audios($slugname = '') {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if (count($artistic_deactive) > 0) {
            // $this->getcountryandskill();
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];

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
            redirect('find-artist');
        }
    }

    //multiple audios for user end  
    //multiple pdf for user start

    // ARTIST PDF  
    public function art_pdf($slugname = '') {

        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if (count($artistic_deactive) > 0) {
            $this->getcountryandskill();
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];

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
            redirect('find-artist');
        }
    }

    public function followers($slugname = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        // $this->getcountryandskill();
        if (count($artistic_deactive) > 0) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];
        
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
            redirect('find-artist');
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


                    $return_html .= '<a href="' . base_url('artist/p/' . $geturl) . '">';

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
                                                <a href="' . base_url('artist/p/' . $geturl) . '">' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '</a></div>
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

    public function following($slugname = "") {

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if (count($artistic_deactive) > 0) {
            // $this->getcountryandskill();
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        // $segment3 = explode('-', $this->uri->segment(3));
        // $slugdata = array_reverse($segment3);
        // $regid = $slugdata[0];
        $slugdata = $this->getdatafromslug($slugname);
        $regid = $slugdata['art_id'];

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
            redirect('find-artist');
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


                    $return_html .= '<a href="' . base_url('artist/p/' . $geturl) . '" title="' . ucfirst(strtolower($artaval[0]['art_name'])) . ' ' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '">';

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
                                                <a title="' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '" href="' . base_url('artist/p/' . $geturl) . '">' . ucfirst(strtolower($artaval[0]['art_name'])) . '&nbsp;' . ucfirst(strtolower($artaval[0]['art_lastname'])) . '</a></div>
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

    // EDIT ARTIST PROFILE
    public function art_basic_information_update() {
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_email,art_phnno,art_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == 1 || $step > 1) {
                $this->data['firstname1'] = $userdata[0]['art_name'];
                $this->data['lastname1'] = $userdata[0]['art_lastname'];
                $this->data['email1'] = strtolower($userdata[0]['art_email']);
                $this->data['phoneno1'] = $userdata[0]['art_phnno'];
            }
        }

        $this->data['title'] = 'Basic Information | Artistic Profile' . TITLEPOSTFIX;
        $this->load->view('artist_live/art_basic_information', $this->data);
    }

    public function art_basic_information_insert() {
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $this->form_validation->set_rules('firstname', 'First name', 'required');
        $this->form_validation->set_rules('lastname', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email id', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('artist/art_basic_information');
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($userdata) {
                $data = array(
                    'art_name' => $this->input->post('firstname'),
                    'art_lastname' => $this->input->post('lastname'),
                    'art_email' => $this->input->post('email'),
                    'art_phnno' => $this->input->post('phoneno'),
                    'modified_date' => date('Y-m-d', time()),
                    'slug' => $this->setcategory_slug($this->input->post('firstname') . '-' . $this->input->post('lastname'), 'slug', 'art_reg')
                );

                // echo "<pre>"; print_r($data); die();
                $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);

                if ($updatdata) {
                    redirect('artist/artistic-address', refresh);
                } else {
                    redirect('artist/artistic-basic-information-insert', refresh);
                }
            } else {
                $data = array(
                    'art_name' => $this->input->post('firstname'),
                    'art_lastname' => $this->input->post('lastname'),
                    'art_email' => $this->input->post('email'),
                    'art_phnno' => $this->input->post('phoneno'),
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d H:i:s', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'art_step' => '1',
                    'slug' => $this->setcategory_slug($this->input->post('firstname') . '-' . $this->input->post('lastname'), 'slug', 'art_reg')
                );

                $insert_id = $this->common->insert_data_getid($data, 'art_reg');
                if ($insert_id) {


                    $this->session->set_flashdata('success', 'Basic Information updated successfully');
                    redirect('artist/artistic-address', refresh);
                } else {
                    $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    redirect('artist/artistic-basic-information-insert', refresh);
                }
            }
        }
    }

    // EDIT PROFILE ADDRESS
    public function art_address() {
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'user_id,art_country,art_state,art_city,art_pincode,art_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting state data
        $contition_array = array('status' => '1', 'country_id' => $userdata[0]['art_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting city data
        $contition_array = array('status' => '1', 'state_id' => $userdata[0]['art_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == '2' || $step > '2' || ($step >= '1' && $step <= '2')) {
                $this->data['country1'] = $userdata[0]['art_country'];
                $this->data['state1'] = $userdata[0]['art_state'];
                $this->data['city1'] = $userdata[0]['art_city'];
                $this->data['pincode1'] = $userdata[0]['art_pincode'];
            }
        }
        $this->data['title'] = 'Address | Artistic Profile' . TITLEPOSTFIX;
        $this->load->view('artist_live/art_address', $this->data);
    }

    public function art_address_insert() {
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        //if ($this->input->post('next')) {

        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('artist_live/art_address');
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $artuserdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($artuserdata[0]['art_step'] == 4) {

                $data = array(
                    'art_country' => $this->input->post('country'),
                    'art_state' => $this->input->post('state'),
                    'art_city' => $this->input->post('city'),
                    'art_pincode' => $this->input->post('pincode'),
                    'modified_date' => date('Y-m-d', time())
                );
            } else {

                $data = array(
                    'art_country' => $this->input->post('country'),
                    'art_state' => $this->input->post('state'),
                    'art_city' => $this->input->post('city'),
                    'art_pincode' => $this->input->post('pincode'),
                    'modified_date' => date('Y-m-d', time()),
                    'art_step' => '2'
                );
            }
            $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
            if ($updatdata) {
                redirect('artist/artistic-information', refresh);
            } else {
                redirect('artist/artistic-address', refresh);
            }
        }
        // }
    }

    // EDIT PROFILE INFORMATION
    public function art_information() {
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->data['userdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step,art_skill,art_yourart,art_desc_art,art_inspire,other_skill,art_bestofmine', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $work_skill = explode(',', $userdata[0]['art_skill']);
        $contition_array = array('status' => '1');
        $this->data['art_category'] = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $contition_array = array('other_category_id' => $userdata[0]['other_skill']);
        $other_category = $this->common->select_data_by_condition('art_other_category', $contition_array, $data = 'other_category_id, other_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['art_step'];

            if ($step == '2' || ($step >= '1' && $step <= '2') || $step > '2') {
                $this->data['artname1'] = $userdata[0]['art_yourart'];
                $this->data['desc_art1'] = $userdata[0]['art_desc_art'];
                $this->data['inspire1'] = $userdata[0]['art_inspire'];
                $this->data['art_category1'] = $userdata[0]['art_skill'];
                $this->data['othercategory1'] = $other_category[0]['other_category'];
                $this->data['bestofmine1'] = $userdata[0]['art_bestofmine'];
            }
        }
        $this->data['get_url'] = $this->get_url($userid);

        $this->data['title'] = 'Art Information | Artistic Profile' . TITLEPOSTFIX;
        $this->load->view('artist_live/art_information', $this->data);
    }

    public function check_category() {
        $category = $_GET['category'];
        $contition_array = array('status' => '1', 'art_category' => $category);
        $checkvalue = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($checkvalue) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function art_information_insert() {
        $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }

        $art_category = $this->input->post('skills');
        $category_trim = trim($this->input->post('othercategory'));
        $speciality = $this->input->post('artname');
        $bestmine = $this->input->post('bestmine');


        $config = array(
            'upload_path' => $this->config->item('art_portfolio_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('art_portfolio_main_allowed_types'),
            'file_name' => $_FILES['bestofmine']['name']
        );
        $images = array();
        $files = $_FILES;
        $this->load->library('upload');

        $fileName = $_FILES['bestofmine']['name'];
        $images[] = $fileName;
        $config['file_name'] = $fileName;
        $this->upload->initialize($config);
        $this->upload->do_upload('bestofmine');

        $main_image = $this->config->item('art_portfolio_main_upload_path') . $fileName;

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);


        $main_file = $this->config->item('art_portfolio_main_upload_path') . $config['file_name'];

        $other_category = $category_trim;
        $contition_array = array('other_category' => $other_category, 'status' => '1');
        $exist_other = $this->common->select_data_by_condition('art_other_category', $contition_array, $data = 'other_category,other_category_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        if ($other_category) {
            if ($exist_other) {
                $insertid = $exist_other[0]['other_category_id'];
            } else {

                $data1 = array(
                    'other_category' => $other_category,
                    'status' => '1',
                    'is_delete' => '0',
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                );
                $insertid = $this->common->insert_data_getid($data1, 'art_other_category');
            }
        }

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $artuserdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $checkval = $art_category;
        if (in_array(26, $art_category)) {
            $otherid = $insertid;
        } else {
            $otherid = '';
        }

        $category = $art_category;
        $category = implode(",", $category);

        $data = array(
            'art_yourart' => $speciality,
            'art_skill' => $category,
            'art_bestofmine' => $fileName,
            'modified_date' => date('Y-m-d', time()),
            'art_step' => '4',
            'other_skill' => $otherid,
        );

        $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        $this->data['get_url'] = $get_url = $this->get_url($userid);

        if ($updatdata) {


            if ($_SERVER['HTTP_HOST'] != "localhost") {
                if (isset($main_file)) {
                    unlink($main_file);
                }
            }
            redirect('artist/details/' . $get_url, refresh);
        }
    }

    // user list of artistic users
    public function userlist() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name,art_lastname,profile_background,art_user_image,designation,slug,user_id');

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);

        if ($this->data['artdata']) {
            $this->data['left_artistic'] = $this->load->view('artist_live/left_artistic', $this->data, true);
            $artistic_name = $this->get_artistic_name($artisticdata[0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Userlist' . '- Artistic Profile' . TITLEPOSTFIX;
            $this->load->view('artist_live/artistic_userlist', $this->data);
        } else {
            redirect('find-artist');
        }
    }

    public function ajax_userlist() {

        $perpage = 7;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;
        $userid = $this->session->userdata('aileenuser');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_id('art_reg', 'user_id', $userid, $data = 'art_name,art_lastname,profile_background,art_user_image,designation,slug,art_id');

        $limit = $perpage;
        $offset = $start;
        $contition_array = array('art_step' => '4', 'is_delete' => '0', 'status' => '1', 'user_id !=' => $userid);
        $userlist = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_name,art_lastname,art_user_image,designation,slug,user_id,art_id', $sortby = 'art_id', $orderby = 'DESC', $limit, $offset, $join_str = array(), $groupby = '');
        $userlist1 = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id', $sortby = 'art_id', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($userlist1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        foreach ($userlist as $user) {
            $return_html .= '
                                                <div class="profile-job-post-detail clearfix">
                                                    <div class="profile-job-post-title-inside clearfix">
                                                        <div class="profile-job-post-location-name">
                                                            <div class="user_lst"><ul>
                                                                <li class="fl padding_less_left">
                                                                        <div class="follow-img">';

            $geturl = $this->get_url($user['user_id']);

            $return_html .= '<a href="' . base_url('artist/p/' . $geturl) . '">';

            if (IMAGEPATHFROM == 'upload') {
                if ($user['art_user_image']) {
                    if (!file_exists($this->config->item('art_profile_thumb_upload_path') . $user['art_user_image'])) {

                        $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                    } else {
                        $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $user['art_user_image'] . '" alt="' . $user['art_user_image'] . '" >';
                    }
                } else {
                    $return_html .= '<img src = "' . base_url(NOARTIMAGE) . '" alt = "NOARTIMAGE">';
                }
            } else {

                $filename = $this->config->item('art_profile_thumb_upload_path') . $user['art_user_image'];
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $this->data['info'] = $info = $s3->getObjectInfo(bucket, $filename);

                if ($info) {
                    $return_html .= '<img src="' . ART_PROFILE_THUMB_UPLOAD_URL . $user['art_user_image'] . '" height="50px" width="50px" alt="' . $user['art_user_image'] . '" >';
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
                                                <a title="' . ucfirst(strtolower($user['art_name'])) . '&nbsp;' . ucfirst(strtolower($user['art_lastname'])) . '" href="' . base_url('artist/p/' . $geturl) . '">' . ucfirst(strtolower($user['art_name'])) . '&nbsp;' . ucfirst(strtolower($user['art_lastname'])) . '</a>
                                                                            </div>
                                                                            <div>';
            $return_html .= '<a>';
            if ($user['designation']) {
                $return_html .= ucfirst(strtolower($user['designation']));
            } else {
                $return_html .= 'Current Work';
            }
            $return_html .= '</a>
                                                                            </div>
                                                                    </li>
                                                                    <li class="fruser' . $user['art_id'] . ' fr">';

            $status = $this->db->select('follow_status')->get_where('follow', array('follow_type' => '1', 'follow_from' => $artisticdata[0]['art_id'], 'follow_to' => $user['art_id']))->row()->follow_status;
            if ($status == 0 || $status == " ") {
                $return_html .= '<div id= "followdiv " class="user_btn">
                                                                                <button id="follow' . $user['art_id'] . '" onClick="followuser(' . $user['art_id'] . ')">
                                                                                  <span> Follow </span>
                                                                                </button></div>';
            } elseif ($status == 1) {
                $return_html .= '<div id= "unfollowdiv"  class="user_btn" > 
                                                                                <button class="bg_following" id="unfollow' . $user['art_id'] . '" onClick="unfollowuser(' . $user['art_id'] . ')">
                                                                                 <span>   Following </span>
                                                                                </button></div>';
            }
            $return_html .= '</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
        }
        echo $return_html;
    }

    // DEACTIVATE ARTIST PROFILE
    public function deactivate() {
        $id = $_POST['id'];
        $data = array(
            'status' => '0'
        );
        $update = $this->common->update_data($data, 'art_reg', 'user_id', $id);
    }

    // REACTIVATE ARTIST PROFILE
    public function reactivate() {
        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => '1',
            'modified_date' => date('y-m-d h:i:s')
        );
        $updatdata = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        if ($updatdata) {
            redirect('artist-profile', refresh);
        } else {
            redirect('artist/reactivate', refresh);
        }
    }

    // click on post after post open on new page start
    public function postnewpage($id = '') {
        $userid = $this->session->userdata('aileenuser');

        //if user deactive profile then redirect to artist/index untill active profile start
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');

        $artistic_deactive = $this->data['artistic_deactive'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($artistic_deactive) {
            redirect('find-artist');
        }
        //if user deactive profile then redirect to artist/index untill active profile End
        $contition_array = array('user_id' => $userid, 'status' => '1');
        $artisticdata = $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('art_post_id' => $id, 'status' => '1', 'is_delete' => '0');
        $this->data['art_data'] = $this->common->select_data_by_condition('art_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $artistdata = $this->common->select_data_by_id('art_reg', 'user_id', $this->data['art_data'][0]['user_id'], $data = 'user_id');

        $this->data['get_url'] = $this->get_url($artisticdata[0]['user_id']);

        if ($this->data['artisticdata']) {
            $artistic_name = $this->get_artistic_name($artistdata[0]['user_id']);
            $this->data['title'] = $artistic_name . ' | Post Detail' . ' | Artistic Profile' . TITLEPOSTFIX;
            $this->data['left_artistic'] = $this->load->view('artist/left_artistic', $this->data, true);
            $this->load->view('artist_live/postnewpage', $this->data);
        } else {
            redirect('find-artist');
        }
    }

    public function reactivateacc() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '0');
        $artresult = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
         // print_r($contition_array);
         // exit;
        //echo "<pre>"; print_r($artresult); die();
        if ($artresult) {
            $this->data['artistic_name'] = ucwords($artresult[0]['art_name']) . ' ' . ucwords($artresult[0]['art_lastname']);
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            $this->load->view('artist_live/reactivate', $this->data);
        } 
        else {
            if($this->artist_profile_set==1 && !$artresult){
                redirect($this->artist_profile_link);
            }
        }
    }

    // GET TOP LOCATION OF ARTIST 
    public function gettoploactionofartist(){
        $limitstart = $_POST['limitstart'];
        $limit = $_POST['limit'];
        $result = $this->artistic_model->gettoplocationsofartist($limitstart,$limit);
        echo json_encode($result);
    }

    // OPEN ALL LOCATION VIEW
    public function location() {
        $this->load->view('artist_live/location', $this->data);
    }
    
    public function artist_by_artist() {
        $this->load->view('artist_live/artist_by_artist', $this->data);
    }

    // GET RESULT OF PERTICULAR LOCATION ARTIST LIST
    public function locationArtistList($location = '') {
        $userid = $this->session->userdata('aileenuser');
        // $artresult = $this->checkisartistdeactivate();
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
        // echo $category_id = $this->db->select('category_id')->get_where('art_category', array('category_slug' => $category))->row_array('category_id');
        $locationdata = $this->artistic_model->getidfromslugoflocation($location);

        // echo $locationdata['city_id'];
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['location_id'] = $locationdata['city_id'];
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->load->view('artist_live/categoryArtistList', $this->data);
    }

    // GET ARTIST LIST BASED ON LOCATION
    public function artistListByLocation($id = '0') {
        $artistListByLocation = $this->artistic_model->artistListByLocation($id);
        echo json_encode($artistListByLocation);
    }

    public function artistAllLocation() {
        $limit = $_GET['limit'];
        $artistAllLocation = $this->artistic_model->artistAllLocation($limit);
        echo json_encode($artistAllLocation);
    }

    public function artistAllLocationList() {
        $limit = ($_GET['limit']) ? $_GET['limit'] : 15;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $artistAllLocation = $this->artistic_model->artistAllLocationList($page,$limit);
        echo json_encode($artistAllLocation);
    }

    public function artistListByFilter() {
        $category_id = $_POST['category_id'];
        $location_id = $_POST['location_id'];
        $artistListByFilter = $this->artistic_model->artistListByFilter($category_id,$location_id);
        echo json_encode($artistListByFilter);
    }

    function getdatafromslug($slug){
        $sql = "SELECT * FROM ailee_art_reg WHERE slug = '". $slug ."' AND status = '1'";
        $query = $this->db->query($sql);
        $result_array = $query->row_array();
        return $result_array;
    }

    public function checkisartistdeactivate(){
        $userid = $this->session->userdata('aileenuser');        
        $contition_array = array('user_id' => $userid, 'status' => '0');
        $artresult = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['isartistactivate'] = false;
        if (count($artresult) > 0) {
            $this->data['artistic_name'] = ucwords($artresult[0]['art_name']) . ' ' . ucwords($artresult[0]['art_lastname']);
            $this->data['isartistactivate'] = true;
            // $this->load->view('artist_live/reactivate', $this->data);
        } 
        $this->data['artist_profile_link'] =  ($this->artist_profile_set == 1)?$this->artist_profile_link:base_url('artist-profile/signup');
        return $artresult;
    }

    function getcountryandskill(){
        $userid = $this->session->userdata('aileenuser');  
        $contition_array = array('user_id' => $userid);
        $artistregdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['artist_isregister'] = false;
        if(count($artistregdata) > 0){
            $this->data['artist_isregister'] = true;
        }
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        
        $contition_array = array('status' => '1');
        $this->data['art_category'] = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
    }

    public function artist_by_category_location_ajax()
    {        
        $page = 1;
        $limit = 20;
        $artistCat = $this->artistic_model->get_artist_by_categories($page,$limit);
        // print_r($artistCat);
        // exit;
        $artistCity = $this->artistic_model->artistAllLocationList($page,$limit); 
        $all_link = array();
        foreach ($artistCity['art_loc'] as $key => $value) {
            foreach ($artistCat['art_cat'] as $jck => $jcv) {
                $all_link[$value['location_slug']][$i]['name'] = $jcv['art_category']." In ".$value['art_location'];
                $all_link[$value['location_slug']][$i]['slug'] = $jcv['category_slug']."-in-".$value['location_slug'];
                $i++;
            }
        }
        echo json_encode($all_link);
    }

    public function artist_register_new()
    {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $user_slug = $this->user_model->getUserSlugById($userid);
        $this->session->set_userdata('aileenuser_slug', $user_slug['user_slug']);
        $userslug = $this->session->userdata('aileenuser_slug');
        
        $ProfessionData = $this->user_model->getUserProfessionData($userid,"*");
        $StudentData = $this->user_model->getUserStudentData($userid,"*");
        if(!empty($ProfessionData) || !empty($StudentData))
        {
            if(isset($this->data['artdata']) && !empty($this->data['artdata']))
            {
                redirect(base_url().'artist-profile','refresh');
            }
            else
            {                
                redirect(base_url());
            }
        }
        $this->data['professionData'] = (isset($ProfessionData) && !empty($ProfessionData) ? 1 : 0);
        $this->data['studentData'] = (isset($StudentData) && !empty($StudentData) ? 1 : 0);        
        $this->load->view('artist_live/artist_register', $this->data);
    }

    public function artist_register()
    {
        $this->load->view('artist_live/artist_register_main', $this->data);
    }

    public function artist_basic_info()
    {
        $this->load->view('artist_live/artist_basic_info', $this->data);   
    }

    public function artist_education_info()
    {        
        $this->load->view('artist_live/artist_education_info', $this->data);   
    }

    public function artist_create_profile()
    {
        $userid = $this->session->userdata('aileenuser');
        $this->data['user_data'] = $this->user_model->getUserSelectedData($userid, $select_data = 'u.first_name,u.last_name,ul.email');

        $contition_array = array('status' => '1');
        $this->data['art_category'] = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->load->view('artist_live/artist_create_profile', $this->data);
    }

    // GET RELATED BLOG LIST
    public function get_art_related_blog_list()
    {
        $art_related_list = $this->artistic_model->art_related_blog_list();
        echo json_encode($art_related_list);
    }
}
