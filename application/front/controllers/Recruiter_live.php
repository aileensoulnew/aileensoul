<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Recruiter_live extends MY_Controller {

    public $data;
    public $my_variable;
    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->model('artistic_model');
        $this->load->model('recruiter_model');
        $this->load->library('S3');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
        include ('main_profile_link.php');
        include ('rec_include.php');
    }

    public function index() {
        $reactivate = $this->checkisreacruiterdeactivate();
        $userid = $this->session->userdata('aileenuser');
        
        if($this->recruiter_profile_set == 1 && !$reactivate){
            redirect( $this->recruiter_profile_link);
        }
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image,ul.email");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        
        // FETCH COUNTRY DATA    
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // FETCH STATE DATA  
        $contition_array = array('status' => '1', 'country_id' => $this->data['recdata']['re_comp_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_id,state_name,country_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // FETCH CITY DATA
        $contition_array = array('status' => '1', 'state_id' => $this->data['recdata']['re_comp_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name,city_id,state_id', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $recuser = $this->db->select('user_id')->get_where('recruiter', array('user_id' => $userid))->row()->user_id;
        }
        $this->data['recruiter_related_list'] = $recruiter_related_list = $this->recruiter_model->recruiter_related_blog_list();
        $this->data['search_banner'] = $this->load->view('recruiter_live/search_banner', $this->data, TRUE);
        $this->data['title'] = "Hire, Post Job & Search Employees - Recruitment Solution at Aileensoul";
        $this->data['metadesc'] = "Finding right candidate seems difficult, right ? Don't worry! Aileensoul offers you a employment platfrom for Job listing, Find and Connecting with right person. Join Now! Post you Job for Free.";
        if($userid != ""){            
            $this->load->view('recruiter_live/index', $this->data);
        }
        else
        {
            $this->load->view('recruiter_live/recruiter_without_main_register', $this->data);   
        }
    }

    /*public function category() {
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

    public function art_category_slug() {
        $contition_array = array();
        $artCatData = $this->common->select_data_by_condition('art_category', $contition_array, $data = 'category_id,art_category', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

        foreach ($artCatData as $k => $v) {
            $data = array('category_slug' => strtolower($this->common->clean($v['art_category'])));
            $insert_id = $this->common->update_data($data, 'art_category', 'category_id', $v['category_id']);
        }
        echo "yes";
    }*/


    // RECRUITER HOME PAGE
    public function recommen_candidate() {
        
        $this->data['title'] = 'Get Better Candidate Suggestion Based on Your Job Posting';
        $this->data['metadesc'] = 'Aileensoul provides you the best employee recommendation based on your job listing. Connect and Hire.';
        $userid = $this->session->userdata('aileenuser');
        $this->recruiter_apply_check();
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        $sql = "SELECT count(*) as totalpost FROM ailee_rec_post where user_id = '$userid'";
        $query = $this->db->query($sql);        
        $this->data['login_user_totalpost'] = $query->row_array()['totalpost'];

        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
        //FETCH RECRUITER DATA
        $this->load->view('recruiter_live/recommen_candidate', $this->data);
    }

    // CHECK WHERE TO REDIRECT RECRUTER
    public function recruiter_apply_check() {
        $userid = $this->session->userdata('aileenuser');
        // REDIRECT USER TO REMAIN PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '1', 'is_delete' => '0');
        $apply_step = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 're_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // REDIRECT USER TO REMAIN PROFILE END
        if (count($apply_step) >= 0) {
            if ($apply_step[0]['re_step'] == 1) {
                redirect('recruiter/signup');
            }
            if ($apply_step[0]['re_step'] == 0) {
                redirect('recruiter/signup');
            }
        } else {
            redirect('recruiter/signup');
        }
    }


    // RECRUITER PROFILE START
    public function rec_profile($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');

        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        if ($id == $userid || $id == '') {
            $this->recruiter_apply_check();
        } else {
            $this->rec_avail_check($id);
        }
        $this->data['title'] = 'Recruiter ' . ucwords($this->data['recdata']['rec_firstname']) . ' ' . ucwords($this->data['recdata']['rec_lastname']) . ' for ' . ucwords($this->data['recdata']['re_comp_name']) . ' Company';

        $this->data['metadesc'] = ucwords($this->data['recdata']['rec_firstname']) . ' ' . ucwords($this->data['recdata']['rec_lastname']) .' is Recruiter at '. ucwords($this->data['recdata']['rec_lastname']) .', currently looking to hire candidate from Aileensoul platform. Follow and contact '. ucwords($this->data['recdata']['rec_firstname']) .' to get latest updates about recent job openings.';
        $this->data['reg_id'] = $id;
        if ($userid) {
            $this->load->view('recruiter_live/rec_profile', $this->data);
        } else {
            $this->load->view('recruiter_live/rec_liveprofile', $this->data);
        }
    }

    // recruiter available check
    public function rec_avail_check($userid = " ") {
        $contition_array = array('user_id' => $userid, 'is_delete' => '1');
        $availuser = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($availuser) > 0) {
            redirect('recruiter_live/noavailable');
        }
    }

    //DEACTIVATE RECRUITER ACCOUNT
    public function deactivate() {
        $this->recruiter_apply_check();
        $id = $_POST['id'];
        $data = array(
            're_status' => '0'
        );
        $update = $this->common->update_data($data, 'recruiter', 'user_id', $id);
        if ($update) {
            $this->session->set_flashdata('success', 'You are deactivate successfully.');
            redirect('profiles/' . $this->session->userdata('aileenuser_slug'), 'refresh');
        } else {
            $this->session->flashdata('error', 'Sorry!! Your are not deactivate!!');
            redirect('recruiter', 'refresh');
        }
    }

    //REACTIVATE RECRUITER ACCOUNT
    public function reactivate() {
        $userid = $this->session->userdata('aileenuser');
        $data = array(
            're_status' => '1',
            'modify_date' => date('y-m-d h:i:s')
        );
        $updatdata = $this->common->update_data($data, 'recruiter', 'user_id', $userid);
        if ($updatdata) {
            redirect('recommended-candidates', refresh);
        } else {
            redirect('recruiter/reactivate', refresh);
        }
    }

     // RECRUITER GET LOCATION END
    public function get_job_tile($id = "") {
        $userid = $this->session->userdata('aileenuser');
        //get search term
        $searchTerm = $_GET['term'];
        $limit = ($_GET['limit']) ? $_GET['limit'] : 5;
        $result = array();
        if (!empty($searchTerm)) {
            $searchTerm = $searchTerm . '%';
            $sql = "SELECT designation as value FROM ailee_job_reg WHERE status = '1' 
                    AND is_delete = '0' AND (designation LIKE '". $searchTerm ."') 
                    
                    UNION
                    SELECT degree_name as value FROM ailee_degree WHERE status = '1' AND (degree_name LIKE '". $searchTerm ."')
                    UNION
                    SELECT stream_name as value FROM ailee_stream WHERE status = '1' AND (stream_name LIKE '". $searchTerm ."')
                    UNION
                    SELECT skill as value FROM ailee_skill WHERE status = '1' AND type = '1' AND (skill LIKE '". $searchTerm ."') GROUP BY value
                    LIMIT $limit";
                // echo $sql;
            $query = $this->db->query($sql);        
            $result = $query->result_array();
        }
        echo json_encode($result);
            // JOB REGISTRATION DATA START (designation)
            // $contition_array = array('status' => '1', 'is_delete' => '0');
            // $search_condition = "(designation LIKE '" . trim($searchTerm) . "%')";
            // $designation = $this->common->select_data_by_search('job_reg', $search_condition, $contition_array, $data = 'designation', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'designation');
            
            // JOB REGISTRATION DATA END  (designation)
            // DEGREE DATA START
            // $contition_array = array('status' => '1');
            // $search_condition = "(degree_name LIKE '" . trim($searchTerm) . "%')";
            // $degreedata = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'degree_name');


            // DEGREE DATA END
            // STREAM DATA START
            // $contition_array = array('status' => '1');
            // $search_condition = "(stream_name LIKE '" . trim($searchTerm) . "%')";
            // $streamdata = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = 'stream_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'stream_name');

            // STREAM DATA END
            // SKILL DATA START
            // $contition_array = array('status' => '1', 'type' => '1');
            // $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            // $skilldata = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');

            // SKILL DATA END
            //MERGE DATA START
            // $uni = array_merge($designation, $degreedata, $streamdata, $skilldata);
            //MERGE DATA END
        // }
        // foreach ($uni as $key => $value) {
        //     foreach ($value as $ke => $val) {
        //         if ($val != "") {
        //             $result[] = $val;
        //         }
        //     }
        // }
        // foreach ($result as $key => $value) {
        //     $result1[$key]['value'] = $value;
        // }
        // $all_data = array_values($result1);
        
    }

    // RECRUITER GET LOCATION START
    public function get_location($id = "") {
        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('cities', $search_condition, $contition_array = array(), $data = 'city_id as id,city_name as text', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
            echo $this->db->last_query();
            exit;
        }
        foreach ($citylist as $key => $value) {

            $citydata[$key]['value'] = $value['text'];
        }
        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

    // RECRUITER SEARCH START
    public function recruiter_search($searchkeyword = " ", $searchplace = " ") {
        /*if ($this->input->get('search_submit')) {
            $searchkeyword = $this->input->get('skills');
            $searchplace = $this->input->get('searchplace');
        } else {
            if ($this->uri->segment(3) == "0") {
                $searchplace = urldecode($searchplace);
                $searchkeyword = "";
            } else if ($this->uri->segment(4) == "0") {
                $searchkeyword = urldecode($searchkeyword);
                $searchplace = "";
            } else {
                $searchkeyword = urldecode($searchkeyword);
                $searchplace = urldecode($searchplace);
            }
        }*/
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        if($userid == "")
        {
            redirect(base_url('recruiter'), refresh);
        }
        else
        {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 're_status' => '1');
            $recruiter_data = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if(empty($recruiter_data))
            {
                redirect(base_url('recruiter'), refresh);
            }
        }
        if ($searchkeyword == "" && $searchplace == "") {
            redirect('recommended-candidates', refresh);
        }
        $rec_search = trim($searchkeyword, ' ');
        $this->data['keyword'] = $rec_search;
        $search_place = $searchplace;
        // $this->data['key_place'] = $searchplace;
        $this->data['key_place'] = trim($searchplace, ' ');
        $cache_time = $this->db->get_where('cities', array('city_name' => $search_place))->row()->city_id;
        $this->data['keyword1'] = trim($search_place,'  ');
        //RECRUITER SEARCH END 1-9
        $title = '';
        if ($searchkeyword && $search_place) {
            $title = ucfirst($searchkeyword) . ' in ' . ucfirst($search_place);
        } elseif ($search_place) {
            $title = ucfirst($search_place);
        } elseif ($searchkeyword) {
            $title = ucfirst($searchkeyword);
        }
        $this->data['title'] = $title . " | Recruiter Profile - Aileensoul";
        $this->data['head'] = $this->load->view('head', $this->data, TRUE);

        $this->data['keyword'] = str_replace("-",",",$this->data['keyword']);
        $this->data['keyword1'] = str_replace("-",",",$this->data['keyword1']);
        $this->data['keyword'] = str_replace("+"," ",$this->data['keyword']);
        $this->data['keyword1'] = str_replace("+"," ",$this->data['keyword1']);

        $this->data['showser'] = str_replace(","," ",$this->data['keyword']);
        $this->data['showser1'] = str_replace(","," ",$this->data['keyword1']);

        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA START
        if ($this->session->userdata('aileenuser')) {
            $contition_array = array('user_id' => $this->session->userdata('aileenuser'), 'is_delete' => '0', 're_status' => '1');
            $recruiter = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($recruiter) {
                // echo "5555"; die();
                $this->load->view('recruiter_live/recommen_candidate1', $this->data);
            } else {
                // echo "999";die();
                $this->load->view('recruiter/rec_search_login', $this->data);
            }
        } else {
            $this->load->view('recruiter/rec_search_login', $this->data);
        }
        //THIS CODE IS FOR WHEN USER NOT LOGIN AND GET SEARCH DATA END
    }

    // RECRUITER ADD POST INSERT END
    public function rec_post($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        $this->data['title'] = $this->data['recdata']['rec_firstname'] . ' ' . $this->data['recdata']['rec_lastname'] . ' | Post | Recruiter Profile - Aileensoul';

        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($recruiter_deactive) {
            redirect('recruiter/');
        }
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END
        if ($id == $userid || $id == '') {
            $this->recruiter_apply_check();
                $contition_array = array('user_id' => $userid, 'is_delete' => '0');
                $this->data['postdataone'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            } else {
                $this->rec_avail_check($id);
                $contition_array = array('user_id' => $id, 'is_delete' => '0', 're_step' => '3');
                $this->data['postdataone'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id,rec_firstname,rec_lastname,recruiter_user_image,profile_background,designation,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');
            }
            if ($userid) {
                $this->load->view('recruiter_live/rec_post', $this->data);
            } else {
                redirect('login/');
            }
        }


    // RECRUITER ADD POST START
    public function add_post() {
        $this->data['title'] = 'Add Post | Recruiter Profile - Aileensoul';

        if ($this->session->userdata('aileenuser')) {

            $this->recruiter_apply_check();

            $userid = $this->session->userdata('aileenuser');

            //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE START
            $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
            $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = 'rec_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
            if ($recruiter_deactive) {
                redirect('recruiter/');
            }
            //IF USER DEACTIVATE PROFILE THEN REDIRECT TO RECRUITER/INDEX UNTILL ACTIVE PROFILE END


            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
            $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
            $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');



            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
            $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => 'publish');
            $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($jobtitle as $key1 => $value1) {
                foreach ($value1 as $ke1 => $val1) {
                    $title[] = $val1;
                }
            }
            foreach ($title as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }
            $this->data['jobtitle'] = array_values($result1);

            $this->load->view('recruiter_live/add_post', $this->data);
        } else {
            $contition_array = array('status' => '1');
            $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'is_other' => '0', 'industry_name !=' => "Others");
            $search_condition = "(status = '1')";
            $industry = $this->data['industry'] = $this->common->select_data_by_search('job_industry', $search_condition, $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $contition_array = array('is_delete' => '0', 'status' => '1', 'industry_name' => "Others");
            $this->data['industry_otherdata'] = $this->common->select_data_by_condition('job_industry', $contition_array, $data = '*', $sortby = 'industry_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
            $search_condition = "(status = '1')";
            $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
            $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = '*', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => 'publish');
            $jobtitle = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            foreach ($jobtitle as $key1 => $value1) {
                foreach ($value1 as $ke1 => $val1) {
                    $title[] = $val1;
                }
            }
            foreach ($title as $key => $value) {
                $result1[$key]['label'] = $value;
                $result1[$key]['value'] = $value;
            }
            $this->data['jobtitle'] = array_values($result1);


            $this->load->view('recruiter_live/add_post_login', $this->data);
        }
    }
    // RECRUITER SAVED CANDIDATE LIST START
    public function save_candidate() {
        $this->recruiter_apply_check();
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $recruiterdata = $this->common->select_data_by_id('recruiter', 'user_id', $userid, $data = 'user_id,designation,rec_firstname,rec_lastname', $join_str = array());
        $this->data['title'] = $recruiterdata[0]['rec_firstname'] . ' ' . $recruiterdata[0]['rec_lastname'] . ' | Saved Candidate | Recruiter Profile - Aileensoul';


        //if user deactive profile then redirect to recruiter/index untill active profile start
        $contition_array = array('user_id' => $userid, 're_status' => '0', 'is_delete' => '0');
        $recruiter_deactive = $this->data['recruiter_deactive'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

        if ($recruiter_deactive) {
            redirect('recruiter/');
        }

        $join_str1 = array(array(
                'join_type' => 'left',
                'table' => 'job_add_edu',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_add_edu.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_reg',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_reg.user_id'),
            array(
                'join_type' => 'left',
                'table' => 'job_graduation',
                'join_table_id' => 'save.to_id',
                'from_table_id' => 'job_graduation.user_id')
        );

        $data = "job_reg.user_id as userid,job_reg.fname,job_reg.lname,job_reg.email,job_reg.phnno,job_reg.keyskill,job_reg.work_job_title,job_reg.work_job_industry,job_reg.work_job_city,job_reg.job_user_image,job_add_edu.*,job_graduation.*,save.status,save.save_id";
        $contition_array1 = array('save.from_id' => $userid, 'save.status' => '0', 'save.save_type' => '1');
        $recdata1 = $this->data['recdata1'] = $this->common->select_data_by_condition('save', $contition_array1, $data, $sortby = 'save_id', $orderby = 'desc', $limit = '', $offset = '', $join_str1, $groupby = '');

        foreach ($recdata1 as $ke => $arr) {
            $recdata2[] = $arr;
        }
        $new = array();
        foreach ($recdata2 as $value) {
            $new[$value['user_id']] = $value;
        }
        $this->data['savedata'] = $new;
        $this->load->view('recruiter_live/saved_candidate', $this->data);
    }

    public function reactivateacc() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 're_status' => '0');
        $reactivate = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE END    
        if ($reactivate) {
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            // Fetch data for reg.
            $this->load->view('recruiter/reactivate', $this->data);
        } 
        else {
            if($this->recruiter_profile_set ==1 && !$reactivate){
                redirect( $this->recruiter_profile_link);
            }
        }
    }

    function checkisreacruiterdeactivate(){
        $userid = $this->session->userdata('aileenuser');
        $this->data['isrecruiteractivate'] = false;
        $contition_array = array('user_id' => $userid, 're_status' => '0');
        $reactivate = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        // IF USER IS RELOGIN AFTER DEACTIVATE PROFILE IN RECRUITER THEN REACTIVATE PROFIEL CODE END    
        if ($reactivate) {
            // Fetch data for reg.
            $this->data['isrecruiteractivate'] = true;
            // $this->load->view('recruiter/reactivate', $this->data);
        } 
        $this->data['recruiter_profile_link'] = $this->recruiter_profile_link;
        $this->data['recruiter_profile_set'] = $this->recruiter_profile_set;
        return $reactivate;
    }

    // GET RELATED BLOG LIST
    public function get_recruiter_related_blog_list()
    {
        $recruiter_related_list = $this->recruiter_model->recruiter_related_blog_list();
        echo json_encode($recruiter_related_list);
    }
}
