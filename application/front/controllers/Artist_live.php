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
        $this->load->library('upload');


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
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['title'] = "Search Creative Artist in any Profession | Aileensoul";
        $this->data['metadesc'] = "Find and Connect with great talents from photographers, designers, models, musicians, actor, dancer to writers from all over the world only at Aileensoul. ";
        $limit = 8;
        $this->data['artistCategory'] = $this->artistic_model->artistCategory($limit);
        $this->data['artistLocation'] = $this->artistic_model->gettoplocationsofartist(0,$limit);
        $this->data['art_related_list'] = $this->artistic_model->art_related_blog_list();

        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $this->load->view('artist_live/index', $this->data);
        // }
    }

    public function category() {

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        
        $this->data['title'] = "Find Artist by Category and Connect with Them | Aileensoul";
        $this->data['metadesc'] = "Explore top artist by various categories such as painter, writer, photographer, dancer, model, and so on. Register free to connect with them."; 
        
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);

        $limit = 15;
        $config = array(); 
        $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2);
        $config["total_rows"] = $this->artistic_model->artistAllCategoryTotalRec();
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
        $this->data['artistAllCategory'] = $this->artistic_model->artistAllCategory($page,$limit);
        $this->data['links'] = $this->pagination->create_links();

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

    public function categoryArtistList($category = '', $location = '',$sertype = "") {
        // echo $category."1-----".$location."2-----3".$sertype;exit;
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

        $this->data['category_id'] = "";
        $category_id = "";
        if($category != "")
        {        
            $category_id = $this->db->select('category_id')->get_where('art_category', array('category_slug' => $category))->row_array('category_id');
            $this->data['category_id'] = $category_id = $category_id['category_id'];
        }

        $this->data['location_id'] = '';
        $location_id = "";
        if($location != "")
        {
            $city_id = $this->db->select('city_id')->get_where('cities', array('slug' => $location))->row('city_id');            
            $this->data['location_id'] = $location_id = $city_id;
        }

        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['q'] = $category;
        $this->data['l'] = $location;
        $this->data['category_txt'] = $tmCat = ucwords(str_replace("-"," ",$category));
        $this->data['location_txt'] = $tmLoc = ucwords(str_replace("-"," ",$location));

        if($sertype == 1)
        {
            if($tmCat == "")
            {
                $tmCat = "Artist";
            }
            $this->data['title'] = "Find and Connect with ".$tmCat." in ".$tmLoc;
            $this->data['metadesc'] = "Looking for great skilful ".$tmCat." in ".$tmLoc."? Connect with them on Aileensoul. Search and explore their portfolio and work details. Join Now to create something artistic!";
        }
        else if($sertype == 2)
        {
            $this->data['title'] = "Search ".$tmCat." and their work details |Aileensoul";
            $this->data['metadesc'] = "Looking for great skilful ".$tmCat."? Connect with them on Aileensoul. Search and explore their portfolio and work details. ";
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        
        $this->data['art_category'] = $art_category = ($this->input->post('art_category') ? $this->input->post('art_category') : "");
        $this->data['art_location'] = $art_location = ($this->input->post('art_location') ? $this->input->post('art_location') : "");
        $limit_cl = 5;
        $this->data['artistCategory'] = $this->artistic_model->artistCategory($limit_cl);
        $this->data['artistLocation'] = $this->artistic_model->artistAllLocation($limit_cl);
        $this->data['artist_left'] = $this->load->view('artist_live/artist_left', $this->data, TRUE);

        // print_r($this->uri->segment_array());
        $limit = 15;
        $config = array();
        if($this->uri->segment(1) == "artist")
        {
            $url = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2);
            $uri_segment = 3;
        }
        else
        {
            $url = base_url().$this->uri->segment(1);
            $uri_segment = 2;
        }
        $config["base_url"] = $this->data["filter_url"] = $url;
        $config["total_rows"] = $this->artistic_model->artistListLocationCategoryTotalRec($category_id,$location_id,$art_category,$art_location);
        $config["per_page"] = $limit;
        $config["uri_segment"] = $uri_segment;
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

        $this->data['page'] = $page = ($this->uri->segment($uri_segment)) ? $this->uri->segment($uri_segment) : 0;
        $this->data['artistList'] = $artistList = $this->artistic_model->artistListLocationCategory($category_id,$location_id,$page,$limit,$art_category,$art_location);
        // print_r($this->data['artistList']);
        $this->data['links'] = $this->pagination->create_links();
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
        $page = $_GET['page'];
        $limit = '5';
        $category_id = $_GET['category_id'];
        $location_id = $_GET['location_id'];

        $searchArtistData = $this->artistic_model->searchArtistData($keyword, $city, $category_id,$location_id,$page,$limit);
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
            if($userid)
            {
                $this->load->view('artist_live/profile', $this->data);
            }
            else
            {
                redirect('find-artist', refresh);
            }
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
            $this->data['title'] = 'Artist Profile | Aileensoul';
            $this->data['metadesc'] = 'Grow your artist network by connecting with other artist that share the same or similar interest at Aileensoul platform.';
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
        $this->data['artisticdata'] = $artisticdata = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_step,user_id,art_user_image,art_name,art_lastname,designation,slug,art_id,art_skill,art_yourart,art_desc_art,art_email,art_city,art_state,art_country,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if(empty($artisticdata))
        {
            redirect("404");
        }
        $this->data['artid'] = $this->data['artisticdata'][0]['user_id'];
        $this->data['get_url'] = $get_url = $this->get_url($this->data['artisticdata'][0]['user_id']);
        $artistic_name = $this->get_artistic_name($this->data['artid']);

        $cityname = $this->db->get_where('cities', array('city_id' => $this->data['artisticdata'][0]['art_city']))->row()->city_name;
        $statename = $this->db->get_where('states', array('state_id' => $this->data['artisticdata'][0]['art_state']))->row()->state_name;
        $countryname = $this->db->get_where('countries', array('country_id' => $this->data['artisticdata'][0]['art_country']))->row()->country_name;
        $category_name = $this->artistic_model->getCategoryNames($this->data['artisticdata'][0]['art_skill']);
        $art_othercategory = "";
        if($this->data['artisticdata'][0]['other_skill'] != "")
        {
            $art_othercategory = $this->db->select('other_category')->get_where('art_other_category', array('other_category_id' => $this->data['artisticdata'][0]['other_skill']))->row()->other_category;
        }
        
        $this->data['title'] = "Artist ".$artistic_name." ".($category_name).($art_othercategory != "" && $category_name != "" ? "," : "").$art_othercategory." From ".($cityname != "" ? $cityname."," : "")." ".$statename.", ".$countryname;
        
        $this->data['metadesc'] = "Artist ".$artistic_name." from ".($cityname != "" ? $cityname."," : "")." ".$statename.", ".$countryname." is a ".($category_name).($art_othercategory != "" && $category_name != "" ? "," : "").$art_othercategory." ".($this->data['artisticdata'][0]['art_yourart'] != '' ? 'specailist in '.$this->data['artisticdata'][0]['art_yourart'] : '').". Visit Aileensoul to view full ".$artistic_name." portfolio.";        

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

        
        $contition_array = array('user_id' => $userid, 'status' => '1', 'art_step' => '4');
        $this->data['login_art_data'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_email,art_phnno,art_country,art_state,art_city,art_pincode,art_address,art_yourart,art_skill,art_desc_art,art_inspire,art_bestofmine,art_portfolio,user_id,art_step,art_user_image,profile_background,designation,slug,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('art_id' => $regid, 'status' => '1', 'art_step' => '4');
        $this->data['artisticdata'] = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_id,art_name,art_lastname,art_email,art_phnno,art_country,art_state,art_city,art_pincode,art_address,art_yourart,art_skill,art_desc_art,art_inspire,art_bestofmine,art_portfolio,user_id,art_step,art_user_image,profile_background,designation,slug,other_skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');        

        $this->data['get_url'] = $this->get_url($this->data['artisticdata'][0]['user_id']);

        $this->data['artistic_name'] = $artistic_name = $this->get_artistic_name($this->data['artisticdata'][0]['user_id']);
        $this->data['title'] = $this->data['title'] = $artistic_name . ' | Details' . '- Artistic Profile' . TITLEPOSTFIX;
        $contition_array = array('status' => '1');
        $this->data['art_category'] = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userid && count($artistic_deactive) <= 0 && $this->data['artist_isregister']) {
            if ($this->data['artisticdata']) {
                $this->data['artistic_common'] = $this->load->view('artist_live/artistic_common', $this->data, true);
                $this->load->view('artist_live/artistic_profile_new', $this->data);
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
            // $this->load->view('artist_live/art_profile_live', $this->data);
            redirect(base_url('artist/p/'.$slugname));
        }
    }

    public function artistic_profile_new($slugname = "") {
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
                $this->load->view('artist_live/artistic_profile_new', $this->data);
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
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        
        $this->data['title'] = "Find Artist by Location and Connect with Them | Aileensoul";
        $this->data['metadesc'] = "Explore top location-wise various artist like painter, writer, photographer, dancer, model, and so on. Register free to connect with them."; 

        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);

        $limit = 15;
        $this->data['page'] = $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $artistAllLocation = $this->artistic_model->artistAllLocationList($page,$limit);
        $config = array(); 
        $config["base_url"] = base_url().$this->uri->segment(1).'/'.$this->uri->segment(2);
        $config["total_rows"] = $artistAllLocation['total_record'];
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

        
        $this->data['artistAllLocation'] = $artistAllLocation['art_loc'];
        $this->data['links'] = $this->pagination->create_links();
        $this->load->view('artist_live/location', $this->data);
    }
    
    public function artist_by_artist() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Find Top Location-Wise Artist by Category and Connect with Them | Aileensoul";
        $this->data['metadesc'] = "Explore top 20 categories wise artist near your location. Register free to connect with them."; 
        $this->data['ismainregister'] = false;
        if($userid){
            $this->data['ismainregister'] = true;
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        }
        $this->data['search_banner'] = $this->load->view('artist_live/search_banner', $this->data, TRUE);
        $page = 1;
        $limit = 20;
        $artistCat = $this->artistic_model->get_artist_by_categories($page,$limit);
        // print_r($artistCat);
        // exit;
        $artistCity = $this->artistic_model->artistAllLocationList($page,$limit); 
        $all_link = array();
        foreach ($artistCity['art_loc'] as $key => $value) {
            foreach ($artistCat['art_cat'] as $jck => $jcv) {
                $total_artist = $this->artistic_model->artistListLocationCategoryTotalRec($jcv['category_id'],$value['location_id'],$art_category = array(),$art_location = array());
                if($total_artist > 0)
                {                    
                    $all_link[$value['location_slug']][$i]['name'] = $jcv['art_category']." In ".$value['art_location'];
                    $all_link[$value['location_slug']][$i]['slug'] = $jcv['category_slug']."-in-".$value['location_slug'];
                    $i++;
                }
            }
        }
        
        $this->data['artistByArtist'] = $all_link;
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
        $this->data['title'] = "Signup - Show Your Artwork with Aileensoul";
        $this->data['metadesc'] = "You are just one step away from showcasing your talent to the whole world. Sign up now! And amaze the world with your art. ";
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

    public function art_create_search_table()
    {
        $this->artistic_model->art_create_search_table();
    }

    public function save_user_education()
    {
        $edit_edu = $this->input->post('edit_edu');
        $edu_file_old = $this->input->post('edu_file_old');
        $edu_school_college = $this->input->post('edu_school_college');
        $edu_university = $this->input->post('edu_university');
        if($edu_university == 0)
        {
            $edu_other_university = $this->input->post('edu_other_university');
        }
        else
        {
            $edu_other_university = "";
        }
        $edu_degree = $this->input->post('edu_degree');
        $edu_stream = $this->input->post('edu_stream');
        if($edu_degree == 0)
        {            
            $edu_other_degree = $this->input->post('edu_other_degree');
            $edu_other_stream = $this->input->post('edu_other_stream');
        }
        else
        {
            $edu_other_degree = "";
            $edu_other_stream = "";
        }
        $edu_start_date = $this->input->post('edu_s_year').'-'.$this->input->post('edu_s_month');
        $edu_end_date = $this->input->post('edu_e_year').'-'.$this->input->post('edu_e_month');
        $edu_nograduate = $this->input->post('edu_nograduate');
        if($edu_nograduate == 1)
        {
            $edu_end_date = "";
        }

        $fileName = $edu_file_old;
        if(isset($_FILES['edu_file']['name']) && $_FILES['edu_file']['name'] != "")
        {
            $art_education_upload_path = $this->config->item('art_education_upload_path');
            $user_edu_file_old = $art_education_upload_path . $edu_file_old;
            if (isset($user_edu_file_old)) {
                unlink($user_edu_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $art_education_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['edu_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('edu_file')){
                $main_image = $art_education_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_project_insert = $this->artistic_model->set_user_education($user_id,$edu_school_college,$edu_university,$edu_other_university,$edu_degree,$edu_stream,$edu_other_degree,$edu_other_stream,$edu_start_date,$edu_end_date,$edu_nograduate,$fileName,$edit_edu);
            $user_education = $this->artistic_model->get_user_education($user_id);            
            $ret_arr = array("success"=>1,"user_education"=>$user_education);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_education()
    {
        $edu_id = $this->input->post('edu_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->artistic_model->delete_user_education($user_id,$edu_id);
            $user_education = $this->artistic_model->get_user_education($user_id);            
            $ret_arr = array("success"=>1,"user_education"=>$user_education);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_education()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_education = $this->artistic_model->get_user_education($userid);        
        $ret_arr = array("success"=>1,"user_education"=>$user_education);        
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_addicourse()
    {
        $edit_addicourse = $this->input->post('edit_addicourse');
        $addicourse_file_old = $this->input->post('addicourse_file_old');
        $addicourse_name = $this->input->post('addicourse_name');
        $addicourse_org = $this->input->post('addicourse_org');        
        $addicourse_start_date = $this->input->post('addicourse_s_year').'-'.$this->input->post('addicourse_s_month');
        $addicourse_end_date = $this->input->post('addicourse_e_year').'-'.$this->input->post('addicourse_e_month');
        $addicourse_url = $this->input->post('addicourse_url');
        $fileName = $addicourse_file_old;
        if(isset($_FILES['addicourse_file']['name']) && $_FILES['addicourse_file']['name'] != "")
        {
            $art_addicourse_upload_path = $this->config->item('art_addicourse_upload_path');
            $user_addicourse_file_old = $art_addicourse_upload_path . $addicourse_file_old;
            if (isset($user_addicourse_file_old)) {
                unlink($user_addicourse_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $art_addicourse_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['addicourse_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('addicourse_file')){
                $main_image = $art_addicourse_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_activity_insert = $this->artistic_model->set_user_addicourse($user_id,$addicourse_name,$addicourse_org,$addicourse_start_date,$addicourse_end_date,$addicourse_url,$fileName,$edit_addicourse);
            $user_addicourse = $this->artistic_model->get_user_addicourse($user_id);
            $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_addicourse()
    {
        $addicourse_id = $this->input->post('addicourse_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_addicourse_insert = $this->artistic_model->delete_user_addicourse($user_id,$addicourse_id);
            $user_addicourse = $this->artistic_model->get_user_addicourse($user_id);
            $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_addicourse()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_addicourse = $this->artistic_model->get_user_addicourse($userid);        
        $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_award()
    {
        $edit_awards = $this->input->post('edit_awards');
        $awards_file_old = $this->input->post('awards_file_old');
        $award_title = $this->input->post('award_title');
        $award_org = $this->input->post('award_org');        
        $award_date = $this->input->post('award_year').'-'.$this->input->post('award_month').'-'.$this->input->post('award_day');
        $award_desc = $this->input->post('award_desc');
        $fileName = $awards_file_old;
        if(isset($_FILES['award_file']['name']) && $_FILES['award_file']['name'] != "")
        {
            $art_user_award_upload_path = $this->config->item('art_user_award_upload_path');
            $user_award_file_old = $art_user_award_upload_path . $awards_file_old;
            if (isset($user_award_file_old)) {
                unlink($user_award_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $art_user_award_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['award_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('award_file')){
                $main_image = $art_user_award_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_award_insert = $this->artistic_model->set_user_award($user_id,$award_title,$award_org,$award_date,$award_desc,$fileName,$edit_awards);
            $user_award = $this->artistic_model->get_user_award($user_id);
            $ret_arr = array("success"=>1,"user_award"=>$user_award);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_award()
    {
        $award_id = $this->input->post('award_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_addicourse_insert = $this->artistic_model->delete_user_award($user_id,$award_id);
            $user_award = $this->artistic_model->get_user_award($user_id);
            $ret_arr = array("success"=>1,"user_award"=>$user_award);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_award()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_award = $this->artistic_model->get_user_award($userid);
        $ret_arr = array("success"=>1,"user_award"=>$user_award);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_experience()
    {
        $edit_exp = $this->input->post('edit_exp');
        $exp_file_old = $this->input->post('exp_file_old');
        $exp_company_name = $this->input->post('exp_company_name');
        $exp_designation = $this->input->post('exp_designation');
        $exp_company_website = $this->input->post('exp_company_website');
        $exp_field = $this->input->post('exp_field');        
        $exp_country = $this->input->post('exp_country');
        $exp_state = $this->input->post('exp_state');
        $exp_city = $this->input->post('exp_city');
        $exp_start_date = $this->input->post('exp_s_year').'-'.$this->input->post('exp_s_month');
        $exp_end_date = $this->input->post('exp_e_year').'-'.$this->input->post('exp_e_month');
        $exp_isworking = $this->input->post('exp_isworking');
        $exp_desc = $this->input->post('exp_desc');
        $fileName = "";
        if($exp_isworking == 1)
        {
            $exp_end_date = "";
        }
        if($exp_field == 0)
        {
            $exp_other_field = $this->input->post('exp_other_field');
        }
        else
        {
            $exp_other_field = "";
        }
        $exp_designation_id = "";
        // foreach ($exp_designation as $title) {
            $designation = $this->data_model->findJobTitle($exp_designation);
            if ($designation['title_id'] != '') {
                $jobTitleId = $designation['title_id'];
            } else {
                $data = array();
                $data['name'] = $title['name'];
                $data['created_date'] = date('Y-m-d H:i:s', time());
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = 'draft';
                $data['slug'] = $this->common->clean($title['name']);
                $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
            }
            $exp_designation_id = $jobTitleId;
        // }        
        $fileName = $exp_file_old;
        if(isset($_FILES['exp_file']['name']) && $_FILES['exp_file']['name'] != "")
        {            
            $art_experience_upload_path = $this->config->item('art_experience_upload_path');
            $user_exp_file_old = $art_experience_upload_path . $exp_file_old;
            if (isset($user_exp_file_old)) {
                unlink($user_exp_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $art_experience_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['exp_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('exp_file')){
                $main_image = $art_experience_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->artistic_model->set_user_experience($user_id,$exp_company_name,$exp_designation_id,$exp_company_website,$exp_field,$exp_other_field,$exp_country,$exp_state,$exp_city,$exp_start_date,$exp_end_date,$exp_isworking,$exp_desc,$fileName,$edit_exp);
            $user_experience = $this->artistic_model->get_user_experience($user_id);
            $year = array();
            $month = array();
            foreach ($user_experience as $_user_experience) {
                $datetime1 = new DateTime($_user_experience['exp_start_date']."-1");
                if($_user_experience['exp_isworking'] == 1)
                {
                    $datetime2 = new DateTime();
                }
                else
                {
                    $datetime2 = new DateTime($_user_experience['exp_end_date']."-1");
                }
                $interval = $datetime1->diff($datetime2);                
                $year[] = $interval->format('%y');
                $month[] = $interval->format('%m') + 1;
            }
            $years = array_sum($year);
            $cal_years = array_sum($month);
            $total_month = $cal_years % 12;
            $years = $years + intval($cal_years / 12);            
            $ret_arr = array("success"=>1,"user_experience"=>$user_experience,"exp_years"=>$years,"exp_months"=>$total_month);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_experience()
    {
        $exp_id = $this->input->post('exp_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->artistic_model->delete_user_experience($user_id,$exp_id);
            $user_experience = $this->artistic_model->get_user_experience($user_id);
            $year = array();
            $month = array();
            foreach ($user_experience as $_user_experience) {
                $datetime1 = new DateTime($_user_experience['exp_start_date']."-1");
                if($_user_experience['exp_isworking'] == 1)
                {
                    $datetime2 = new DateTime();
                }
                else
                {
                    $datetime2 = new DateTime($_user_experience['exp_end_date']."-1");
                }
                $interval = $datetime1->diff($datetime2);                
                $year[] = $interval->format('%y');
                $month[] = $interval->format('%m') + 1;
            }
            $years = array_sum($year);
            $cal_years = array_sum($month);
            $total_month = $cal_years % 12;
            $years = $years + intval($cal_years / 12);            
            $ret_arr = array("success"=>1,"user_experience"=>$user_experience,"exp_years"=>$years,"exp_months"=>$total_month);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_experience()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_experience = $this->artistic_model->get_user_experience($userid);
        $year = array();
        $month = array();
        foreach ($user_experience as $_user_experience) {
            $datetime1 = new DateTime($_user_experience['exp_start_date']."-1");
            if($_user_experience['exp_isworking'] == 1)
            {
                $datetime2 = new DateTime();
            }
            else
            {
                $datetime2 = new DateTime($_user_experience['exp_end_date']."-1");
            }
            $interval = $datetime1->diff($datetime2);                
            $year[] = $interval->format('%y');
            $month[] = $interval->format('%m') + 1;
        }
        $years = array_sum($year);
        $cal_years = array_sum($month);
        $total_month = $cal_years % 12;
        $years = $years + intval($cal_years / 12);
        $ret_arr = array("success"=>1,"user_experience"=>$user_experience,"exp_years"=>$years,"exp_months"=>$total_month);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_portfolio()
    {
        $edit_portfolio_id = $this->input->post('edit_portfolio_id');
        $portfolio_file_old = $this->input->post('portfolio_file_old');
        $portfolio_title = $this->input->post('portfolio_title');
        $portfolio_desc = $this->input->post('portfolio_desc');
        $fileName = $portfolio_file_old;
        if(isset($_FILES['portfolio_file']['name']) && $_FILES['portfolio_file']['name'] != "")
        {
            $art_user_portfolio_upload_path = $this->config->item('art_user_portfolio_upload_path');
            $user_portfolio_file_old = $art_user_portfolio_upload_path . $portfolio_file_old;
            if (isset($user_portfolio_file_old)) {
                unlink($user_portfolio_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $art_user_portfolio_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['portfolio_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('portfolio_file')){
                $main_image = $art_user_portfolio_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_portfolio_insert = $this->artistic_model->save_portfolio($user_id,$portfolio_title,$portfolio_desc,$fileName,$edit_portfolio_id);
            $user_portfolio = $this->artistic_model->get_portfolio($user_id);
            $ret_arr = array("success"=>1,"user_portfolio"=>$user_portfolio);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_portfolio()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_portfolio = $this->artistic_model->get_portfolio($user_id);
        $ret_arr = array("success"=>1,"user_portfolio"=>$user_portfolio);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_portfolio()
    {
        $edit_portfolio_id = $this->input->post('edit_portfolio_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $portfolio_delete = $this->artistic_model->delete_portfolio($user_id,$edit_portfolio_id);
            $user_portfolio = $this->artistic_model->get_portfolio($user_id);
            $ret_arr = array("success"=>1,"user_portfolio"=>$user_portfolio);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    function save_user_links()
    {
        $userid = $this->session->userdata('aileenuser');
        $link_type = $this->input->post('link_type');
        $link_url = $this->input->post('link_url');
        $personal_link_url = $this->input->post('personal_link_url');

        $this->db->where('user_id', $userid);
        $this->db->delete('art_user_links');

        if(count($link_type) == count($link_url))
        {
            foreach($link_url as $k=>$v)
            {                    
                if($v['value'] != "")
                {                        
                    $data = array(
                        'user_id' => $userid,
                        'user_links_txt' => $v['value'],
                        'user_links_type' => $link_type[$k]['value'],
                        'status' => '1',
                        'created_date' => date('Y-m-d H:i:s', time()),
                        'modify_date' => date('Y-m-d H:i:s', time()),
                    );
                    $insert_id = $this->common->insert_data($data, 'art_user_links');
                }
            }
        }

        if(count($personal_link_url) > 0)
        {
            foreach($personal_link_url as $k=>$v)
            {                    
                if($v['value'] != "")
                {                        
                    $data = array(
                        'user_id' => $userid,
                        'user_links_txt' => $v['value'],
                        'user_links_type' => "Personal",
                        'status' => '1',
                        'created_date' => date('Y-m-d H:i:s', time()),
                        'modify_date' => date('Y-m-d H:i:s', time()),
                    );
                    $insert_id = $this->common->insert_data($data, 'art_user_links');
                }
            }
        }

        $user_social_links_data = $this->artistic_model->get_user_social_links($userid);        
        $user_personal_links_data = $this->artistic_model->get_user_personal_links($userid);        
        $ret_arr = array("success"=>1,"user_social_links_data"=>$user_social_links_data,"user_personal_links_data"=>$user_personal_links_data);
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_links()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_social_links_data = $this->artistic_model->get_user_social_links($user_id);        
        $user_personal_links_data = $this->artistic_model->get_user_personal_links($user_id);        
        if(empty($user_social_links_data) && empty($user_personal_links_data))
        {
            $ret_arr = array("success"=>0);
        }
        else
        {
            $ret_arr = array("success"=>1,"user_social_links_data"=>$user_social_links_data,"user_personal_links_data"=>$user_personal_links_data,"user_social_links_data_edit"=>$user_social_links_data,"user_personal_links_data_edit"=>$user_personal_links_data);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_language()
    {
        $userid = $this->session->userdata('aileenuser');

        $language = $this->input->post('language');
        $proficiency = $this->input->post('proficiency');        
        
        if(isset($language) && isset($proficiency) && !empty($language) && !empty($proficiency))
        {
            $this->db->where('user_id', $userid);
            $this->db->delete('art_user_languages');

            if(count($language) == count($proficiency))
            {
                foreach($language as $k=>$v)
                {                    
                    if($v['value'] != "")
                    {                        
                        $data = array(
                            'user_id' => $userid,
                            'language_txt' => $v['value'],
                            'proficiency' => $proficiency[$k]['value'],
                            'status' => '1',
                            'created_date' => date('Y-m-d H:i:s', time()),
                            'modify_date' => date('Y-m-d H:i:s', time()),
                        );
                        $insert_id = $this->common->insert_data($data, 'art_user_languages');
                    }
                }
            }            
        }

        $user_languages = $this->artistic_model->get_user_languages($userid);
        $ret_arr = array("success"=>1,"user_languages"=>$user_languages);
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_languages()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_languages = $this->artistic_model->get_user_languages($user_id);
        $ret_arr = array("success"=>1,"user_languages"=>$user_languages);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_art_bio()
    {
        $user_bio = $this->input->post('user_bio');
        $userid = $this->session->userdata('aileenuser');
        $data = array('art_desc_art' => $user_bio);
        $udpate_data = $this->common->update_data($data, 'art_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $udpate_data = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $userid);
            $ret_arr = array("success"=>1,"user_bio"=>$user_bio);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_bio()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_bio = $this->artistic_model->get_user_bio($user_id);
        $ret_arr = array("success"=>1,"user_bio"=>$user_bio);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_specialities()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $art_speciality_data = $this->artistic_model->get_user_specialities($user_id);
        $ret_arr = array("success"=>1,"art_speciality_data"=>$art_speciality_data);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_speciality()
    {
        $user_id = $this->session->userdata('aileenuser');
        $speciality_txt = $this->input->post('speciality_txt');
        $speciality_desc = $this->input->post('speciality_desc');        
        $user_spl_tag_txt = "";
        if(isset($speciality_txt) && !empty($speciality_txt))
        {
            foreach ($speciality_txt as $key => $value) {
                $user_spl_tag_txt .= $value['speciality'].",";
            }
        }
        $user_spl_tag_txt = trim($user_spl_tag_txt,",");

        $data = array('art_spl_tags' => $user_spl_tag_txt,'art_spl_desc' => $speciality_desc);        
        $udpate_data = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
        if($udpate_data)
        {
            $udpate_data = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $user_id);
            $art_speciality_data = $this->artistic_model->get_user_specialities($user_id);
            $ret_arr = array("success"=>1,"art_speciality_data"=>$art_speciality_data);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }        
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_soft_inst_skill_data()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $art_soft_inst_skill = $this->artistic_model->get_user_soft_inst_skill_data($user_id);
        $ret_arr = array("success"=>1,"art_soft_inst_skill"=>$art_soft_inst_skill);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_soft_inst_skill()
    {
        $user_id = $this->session->userdata('aileenuser');
        $soft_inst_skill_txt = $this->input->post('soft_inst_skill_txt');        
        $soft_inst_skill_tags = "";
        if(isset($soft_inst_skill_txt) && !empty($soft_inst_skill_txt))
        {
            foreach ($soft_inst_skill_txt as $key => $value) {
                $soft_inst_skill_tags .= $value['sis'].",";
            }
        }
        $soft_inst_skill_tags = trim($soft_inst_skill_tags,",");

        $data = array('art_soft_inst_skill' => $soft_inst_skill_tags);        
        $udpate_data = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
        if($udpate_data)
        {
            $udpate_data = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $user_id);
            $art_soft_inst_skill = $this->artistic_model->get_user_soft_inst_skill_data($user_id);
            $ret_arr = array("success"=>1,"art_soft_inst_skill"=>$art_soft_inst_skill);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }        
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_talent_cat_data()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $art_talent_category = $this->artistic_model->get_user_talent_cat_data($user_id);
        $ret_arr = array("success"=>1,"art_talent_category"=>$art_talent_category);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_talent_cat()
    {
        $user_id = $this->session->userdata('aileenuser');
        $talent_cat_txt = $this->input->post('talent_cat_txt');        
        $talent_cat_tags = "";
        if(isset($talent_cat_txt) && !empty($talent_cat_txt))
        {
            foreach ($talent_cat_txt as $key => $value) {
                $talent_cat_tags .= $value['tal_cat'].",";
            }
        }
        $talent_cat_tags = trim($talent_cat_tags,",");

        $data = array('art_talent_category' => $talent_cat_tags);        
        $udpate_data = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
        if($udpate_data)
        {
            $udpate_data = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $user_id);
            $art_talent_category = $this->artistic_model->get_user_talent_cat_data($user_id);
            $ret_arr = array("success"=>1,"art_talent_category"=>$art_talent_category);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }        
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_art_imp_data()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $art_imp_data = $this->artistic_model->get_user_art_imp_data($user_id);
        $ret_arr = array("success"=>1,"art_imp_data"=>$art_imp_data);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function art_imp_save()
    {
        $art_status = $this->input->post('art_status');
        $user_id = $this->session->userdata('aileenuser');

        $data1 = array(
            'art_active_status' => $art_status,
            'modified_date' => date('Y-m-d h:i:s', time()),            
        );
        $insert_id = $this->common->update_data($data1, 'art_reg', 'user_id', $user_id);
        $insert_id = $this->common->update_data($data1, 'art_reg_search_tmp', 'user_id', $user_id);
        $art_imp_data = $this->artistic_model->get_user_art_imp_data($user_id);
        $ret_arr = array("success"=>1,"art_imp_data"=>$art_imp_data);
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_artist_basic_info()
    {
        $user_slug = $this->input->post('user_slug');
        $user_id = $this->db->select('user_id')->get_where('art_reg', array('slug' => $user_slug,'status' => '1'))->row('user_id');
        $artist_basic_info = $this->artistic_model->get_artist_basic_info($user_id);
        $artist_preferred_info = $this->artistic_model->get_artist_preferred_info($user_id);
        $ret_arr = array("success"=>1,"artist_basic_info"=>$artist_basic_info,"artist_preferred_info"=>$artist_preferred_info);
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function art_basic_info_save()
    {
        $user_id = $this->session->userdata('aileenuser');
        $art_fname = $this->input->post('art_fname');
        $art_lname = $this->input->post('art_lname');
        $art_email = $this->input->post('art_email');
        $art_gender = $this->input->post('art_gender');
        $birth_date = $this->input->post('art_dob_year').'-'.$this->input->post('art_dob_month').'-'.$this->input->post('art_dob_day');
        $art_phnno = $this->input->post('art_phnno');        
        $art_basic_country = $this->input->post('art_basic_country');
        $art_basic_state = $this->input->post('art_basic_state');
        $art_basic_city = $this->input->post('art_basic_city');
        $art_category = $this->input->post('art_category');        
        if(in_array("26", $art_category))
        {
            $art_other_category = $this->input->post('art_other_category');            
            $contition_array = array('other_category' => $art_other_category, 'status' => '1');
            $exist_other = $this->common->select_data_by_condition('art_other_category', $contition_array, $data = 'other_category,other_category_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

            if ($art_other_category) {
                if ($exist_other) {
                    $art_other_category_id = $exist_other[0]['other_category_id'];
                } else {

                    $data1 = array(
                        'other_category' => $art_other_category,
                        'status' => '1',
                        'is_delete' => '0',
                        'user_id' => $user_id,
                        'created_date' => date('Y-m-d', time()),
                    );
                    $art_other_category_id = $this->common->insert_data_getid($data1, 'art_other_category');
                }
            }
        }
        else
        {
            $art_other_category_id = "";
        }
        $category = implode(",", $art_category);

        if($user_id != "")
        {
            $basic_info_insert = $this->artistic_model->art_basic_info_save($user_id, $art_fname, $art_lname, $art_email, $art_gender, $birth_date, $art_phnno, $art_basic_country, $art_basic_state, $art_basic_city, $category, $art_other_category_id);
            $artist_basic_info = $this->artistic_model->get_artist_basic_info($user_id);
            $artist_preferred_info = $this->artistic_model->get_artist_preferred_info($user_id);
            $ret_arr = array("success"=>1,"artist_basic_info"=>$artist_basic_info,"artist_preferred_info"=>$artist_preferred_info);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function art_preferred_info_save()
    {
        $user_id = $this->session->userdata('aileenuser');

        $art_category = $this->input->post('pref_cate');        
        if(in_array("26", $art_category))
        {
            $art_other_category = $this->input->post('art_other_pref_cate');            
            $contition_array = array('other_category' => $art_other_category, 'status' => '1');
            $exist_other = $this->common->select_data_by_condition('art_other_category', $contition_array, $data = 'other_category,other_category_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

            if ($art_other_category) {
                if ($exist_other) {
                    $art_other_category_id = $exist_other[0]['other_category_id'];
                } else {

                    $data1 = array(
                        'other_category' => $art_other_category,
                        'status' => '1',
                        'is_delete' => '0',
                        'user_id' => $user_id,
                        'created_date' => date('Y-m-d', time()),
                    );
                    $art_other_category_id = $this->common->insert_data_getid($data1, 'art_other_category');
                }
            }
        }
        else
        {
            $art_other_category_id = "";
        }
        $category = implode(",", $art_category);

        $preferred_skill_txt = $this->input->post('preferred_skill_txt');
        $art_preffered_country = $this->input->post('art_preffered_country');
        $art_preffered_state = $this->input->post('art_preffered_state');
        $art_preffered_city = $this->input->post('art_preffered_city');
        $preffered_availability = $this->input->post('preffered_availability');

        $preferred_skill_tags = "";
        if(isset($preferred_skill_txt) && !empty($preferred_skill_txt))
        {
            foreach ($preferred_skill_txt as $key => $value) {
                $preferred_skill_tags .= $value['pref_skill'].",";
            }
        }
        $preferred_skill_tags = trim($preferred_skill_tags,",");

        if($user_id != "")
        {
            $basic_info_insert = $this->artistic_model->art_preferred_info_save($user_id, $category, $art_other_category_id, $preferred_skill_tags ,$art_preffered_country ,$art_preffered_state ,$art_preffered_city ,$preffered_availability);
            $artist_basic_info = $this->artistic_model->get_artist_basic_info($user_id);
            $artist_preferred_info = $this->artistic_model->get_artist_preferred_info($user_id);
            $ret_arr = array("success"=>1,"artist_basic_info"=>$artist_basic_info,"artist_preferred_info"=>$artist_preferred_info);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function progressbar_new($user_id)
    {
        $contition_array = array('user_id' => $user_id, 'status' => '1', 'is_delete' => '0');

        $art_data = $this->common->select_data_by_condition('art_reg', $contition_array, $data = 'art_user_image, profile_background, art_desc_art, art_name, art_lastname, art_skill, art_gender, art_email, art_phnno, art_dob, art_country, art_state, art_city, art_active_status, preffered_skills, preffered_country, preffered_state, preffered_city, preffered_availability', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array())[0];

        $count = 0;
        $progress_status = array();
        $user_image = 0;        
        if($art_data['art_user_image'] != '')
        {
            $user_image = 1;
            $count = $count + 3;
        }
        $progress_status['user_image_status'] = $user_image;

        $profile_background = 0;
        if($art_data['profile_background'] != '')
        {
            $profile_background = 1;
            $count = $count + 3;
        }
        $progress_status['profile_background_status'] = $profile_background;

        $user_bio = 0;
        if($art_data['art_desc_art'] != '')
        {
            $user_bio = 1;
            $count = $count + 1;
        }
        $progress_status['user_bio_status'] = $user_bio;

        //Basic Info
        $fname = 0;
        if($art_data['art_name'] != '')
        {
            $fname = 1;
            $count = $count + 1;
        }
        $progress_status['fname_status'] = $fname;

        $lname = 0;
        if($art_data['art_lastname'] != '')
        {
            $lname = 1;
            $count = $count + 1;
        }
        $progress_status['lname_status'] = $lname;

        $category = 0;
        if($art_data['art_skill'] != '')
        {
            $category = 1;
            $count = $count + 1;
        }
        $progress_status['category_status'] = $category;

        $gender = 0;
        if($art_data['art_gender'] != '')
        {
            $gender = 1;
            $count = $count + 1;
        }
        $progress_status['gender_status'] = $gender;

        $email = 0;
        if($art_data['art_email'] != '')
        {
            $email = 1;
            $count = $count + 1;
        }
        $progress_status['email_status'] = $email;

        $phnno = 0;
        if($art_data['art_phnno'] != '')
        {
            $phnno = 1;
            $count = $count + 1;
        }
        $progress_status['phnno_status'] = $phnno;

        $dob = 0;
        if($art_data['art_dob'] != '')
        {
            $dob = 1;
            $count = $count + 1;
        }
        $progress_status['dob_status'] = $dob;

        $country = 0;
        if($art_data['art_country'] != '')
        {
            $country = 1;
            $count = $count + 1;
        }
        $progress_status['country_status'] = $country;

        $state = 0;
        if($art_data['art_state'] != '')
        {
            $state = 1;
            $count = $count + 1;
        }
        $progress_status['state_status'] = $state;

        $city = 0;
        if($art_data['art_city'] != '')
        {
            $city = 1;
            $count = $count + 1;
        }
        $progress_status['city_status'] = $city;
        //artist Active Status
        
        $active_status = 0;
        if($art_data['art_active_status'] != '')
        {
            $active_status = 1;
            $count = $count + 1;
        }
        $progress_status['active_status_status'] = $active_status;

        //Preferred Detail
        $preffered_skills = 0;
        if($art_data['preffered_skills'] != '')
        {
            $preffered_skills = 1;
            $count = $count + 1;
        }
        $progress_status['preffered_skills_status'] = $preffered_skills;

        $preffered_country = 0;
        if($art_data['preffered_country'] != '')
        {
            $preffered_country = 1;
            $count = $count + 1;
        }
        $progress_status['preffered_country_status'] = $preffered_country;

        $preffered_state = 0;
        if($art_data['preffered_state'] != '')
        {
            $preffered_state = 1;
            $count = $count + 1;
        }
        $progress_status['preffered_state_status'] = $preffered_state;

        $preffered_city = 0;
        if($art_data['preffered_city'] != '')
        {
            $preffered_city = 1;
            $count = $count + 1;
        }
        $progress_status['preffered_city_status'] = $preffered_city;

        $preffered_availability = 0;
        if($art_data['preffered_availability'] > -1 && $art_data['preffered_availability'] != '')
        {
            $preffered_availability = 1;
            $count = $count + 1;
        }
        $progress_status['preffered_availability_status'] = $preffered_availability;

        $user_education = $this->artistic_model->get_user_education($user_id);
        $user_education_status = 0;
        if(isset($user_education) && !empty($user_education))
        {
            $user_education_status = 1;
            $count = $count + 3;
        }
        $progress_status['user_education_status'] = $user_education_status;
        
        $user_portfolio_status = 0;
        $user_portfolio = $this->artistic_model->get_portfolio($user_id);
        if(isset($user_portfolio) && !empty($user_portfolio))
        {
            $user_portfolio_status = 1;
            $count = $count + 3;
        }
        $progress_status['user_portfolio_status'] = $user_portfolio_status;

        $user_experience_status = 0;
        $user_experience = $this->artistic_model->get_user_experience($user_id);  
        if(isset($user_experience) && !empty($user_experience))
        {
            $user_experience_status = 1;
            $count = $count + 3;
        }
        $progress_status['user_experience_status'] = $user_experience_status;
        
        $user_languages = $this->artistic_model->get_user_languages($user_id);
        $user_languages_status = 0;
        if(isset($user_languages) && !empty($user_languages))
        {
            $user_languages_status = 1;
            $count = $count + 3;
        }
        $progress_status['user_languages_status'] = $user_languages_status;

        $user_links = $this->artistic_model->get_user_links($user_id);
        $user_links_status = 0;
        if(isset($user_links) && !empty($user_links))
        {
            $user_links_status = 1;
            $count = $count + 3;
        }
        $progress_status['user_links_status'] = $user_links_status;
        // print_r($progress_status);
        // echo $count;exit();
        $user_process = ($count * 100) / 38;        
        $user_process_value = ($user_process / 100);

        if ($user_process == 100) {
            //if ($job_data['progress_new'] != 1) {
                $data = array(
                    'progressbar' => '1',
                    'modified_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
                $updatedata = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $user_id);
            //}
        } else {
            $data = array(
                'progressbar' => '0',
                'modified_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'art_reg', 'user_id', $user_id);
            $updatedata = $this->common->update_data($data, 'art_reg_search_tmp', 'user_id', $user_id);
        }
        return array("user_process"=>$user_process,"user_process_value"=>$user_process_value,"progress_status"=>$progress_status);
    }
}