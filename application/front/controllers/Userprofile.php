<?php
header('Access-Control-Allow-Origin: '.CROSSDOMAIN);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('userprofile_model');
        $this->load->model('user_post_model');
        $this->load->model('data_model');
        $this->load->library('S3');
        $this->load->library('form_validation');
        $this->load->library('inbackground');
        $this->load->helper('cookie');
        //  include('userprofile_include.php');
        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="#"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
       
       include ('main_profile_link.php');
    }

    public function index() {
        // exit;
        $this->data['slug'] = $slug = $this->session->userdata('aileenuser_slug');
        $userid = $this->session->userdata('aileenuser');
        //$seg_slug = $this->uri->segment(2);
        $seg_slug = $this->uri->segment(1);//Pratik
        if($userid == "" && $this->uri->segment(2) != "")
        {
            redirect(base_url().$seg_slug);
        }

        if ($seg_slug == $slug) {
            $userslug = $slug;
        } else {
            if($this->uri->segment(2) == 'savedpost' || $this->uri->segment(2) == 'monetization-analytics')
            {
                redirect(base_url().$seg_slug);
            }
            $userslug = $seg_slug;
        }
        $userdata = $this->data['userdata'] = $this->user_model->getUserDataByslug($userslug, $datat = "u.user_id,u.first_name,u.last_name,u.user_dob,u.user_gender,u.user_agree,u.created_date,u.verify_date,u.user_verify,u.user_slider,u.user_slug,ui.user_image,ui.modify_date,ui.edit_ip,ui.profile_background,ui.profile_background_main,ul.email,ul.password,ul.is_delete,ul.status,ul.password_code");
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userSlugBasicInfo'] = $this->user_model->getUserProfessionDataBySlug($userslug, $data = "jt.name as Designation,it.industry_name as Industry,c.city_name as City");
        $this->data['is_userSlugStudentInfo'] = $this->user_model->getUserStudentDataBySlug($userslug, $data = "d.degree_name as Degree,u.university_name as University,c.city_name as City");
        // $this->data['is_userPostCount'] = $this->user_post_model->userPostCountBySlug($userslug);
        $fullname = $userdata['first_name']." ".$userdata['last_name'];
        if(isset($this->data['is_userSlugBasicInfo']) && !empty($this->data['is_userSlugBasicInfo']))
        {
            $desg = $this->data['is_userSlugBasicInfo']['Designation'];
        }
        if(isset($this->data['is_userSlugStudentInfo']) && !empty($this->data['is_userSlugStudentInfo']))
        {
            $desg = $this->data['is_userSlugStudentInfo']['Degree'];
        }
        $this->data['title'] = "About ".ucwords($fullname).TITLEPOSTFIX;
        $this->data['metadesc'] = "Connect with ".ucwords($fullname).", ".ucwords($desg)." and know more about him only at Aileensoul.com. Join Now!";

        $this->data['professionData'] = $this->user_model->getUserProfessionData($userid,"*");        
        $this->data['studentData'] = $this->user_model->getUserStudentData($userid,"*");
        
        $is_userContactInfo = $this->userprofile_model->userContactStatus($userid, $userdata['user_id']);
        $is_userFollowInfo = $this->userprofile_model->userFollowStatus($userid, $userdata['user_id']);
        $this->data['to_id'] = $userdata['user_id'];

        if (count($is_userContactInfo) != 0) {
            $this->data['contact_status'] = 1;
            $this->data['contact_value'] = $is_userContactInfo['status'];
            $this->data['contact_id'] = $is_userContactInfo['id'];
            $this->data['from_id'] = $is_userContactInfo['from_id'];
        } else {
            $this->data['contact_value'] = 'new';
            $this->data['contact_status'] = 0;
            $this->data['contact_id'] = ($is_userContactInfo['id'] ? $is_userContactInfo['id'] : "");
            $this->data['from_id'] = $is_userContactInfo['from_id'];
        }

        if (count($is_userFollowInfo) != 0) {
            $this->data['follow_status'] = 1;
            $this->data['follow_id'] = $is_userFollowInfo['id'];
            $this->data['follow_value'] = $is_userFollowInfo['status'];
        } else {
            $this->data['follow_value'] = 'new';
            $this->data['follow_id'] = ($is_userFollowInfo['id'] ? $is_userFollowInfo['id'] : "");
            $this->data['follow_status'] = 0;
        }
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['header'] = $this->load->view('userprofile/header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['footer'] = $this->load->view('userprofile/footer', $this->data, TRUE);

        if (count($userdata) > 0) {
            $this->load->view('userprofile/index', $this->data);
        } else {
            $this->data['title'] = "404".TITLEPOSTFIX;
            $this->load->view('404', $this->data);
            // $this->load->view('userprofile/notavalible');
        }
    }

    public function looping() {
        $this->load->view('userprofile/looping');
    }

    public function contact_request() {
        $userid = $this->session->userdata('aileenuser');

        $contactRequestUpdate = $this->user_model->contact_request_read($userid);
        $contactRequest = $this->user_model->contact_request($userid);
        echo json_encode($contactRequest);
    }

    public function contactRequestAction() {
        $userid = $this->session->userdata('aileenuser');
        $from_id = $_POST['from_id'];
        $action = $_POST['action'];

        $contactRequest = $this->user_model->contactRequestAction($userid, $from_id, $action);
        if($action == 'confirm')
        {
            //Send Mail Start
            $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $from_id))->row()->email;
            $login_userdata = $this->user_model->getUserData($userid);
            if($login_userdata['user_image'] != "")
            {
                $login_user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
            }
            else
            {
                if($login_userdata['user_gender']  == 'M')
                {
                    $login_user_img = base_url('assets/img/man-user.jpg');
                }

                if($login_userdata['user_gender']  == 'F')
                {
                    $login_user_img = base_url('assets/img/female-user.jpg');
                }
            }

            $url = base_url().$login_userdata['user_slug'];
            $email_html = '';
            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="'.MAIL_TD_1.'">
                                    <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                </td>
                                <td style="padding:5px;">
                                    <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> accepted your contact request.</p>
                                    <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                </td>
                                <td style="'.MAIL_TD_3.'">
                                    <p><a class="btn" href="'.$url.'">view</a></p>
                                </td>
                            </tr>
                            </table>';
            $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' accepted your contact request in Aileensoul.';

            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $from_id))->row();

            $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
            {
                // $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
                $url = base_url()."user_post/send_email_in_background";
                $param = array(
                    "subject"=>$subject,
                    "email_html"=>$email_html,
                    "to_email"=>$to_email_id,
                    "unsubscribe"=>$unsubscribe,
                );
                $this->inbackground->do_in_background($url, $param);
            }
            //Send Mail End
        }
        echo json_encode($contactRequest);
    }

    public function contactRequestActionNode() {
        $user_slug = $this->input->post('username'); 
        $ast = $this->input->post('ast'); 
        $ask = $this->input->post('ask'); 
        
        $user_data = $this->user_model->get_user_from_cookies($user_slug,base64_decode(base64_decode($ast)),base64_decode(base64_decode($ask)));        
        if($user_data)
        {
            $userid = $user_data['user_id'];
            $from_id = $_POST['from_id'];
            $action = $_POST['action'];

            $contactRequest = $this->user_model->contactRequestAction($userid, $from_id, $action);
            if($action == 'confirm')
            {
                //Send Mail Start
                $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $from_id))->row()->email;
                $login_userdata = $this->user_model->getUserData($userid);
                if($login_userdata['user_image'] != "")
                {
                    $login_user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
                }
                else
                {
                    if($login_userdata['user_gender']  == 'M')
                    {
                        $login_user_img = base_url('assets/img/man-user.jpg');
                    }

                    if($login_userdata['user_gender']  == 'F')
                    {
                        $login_user_img = base_url('assets/img/female-user.jpg');
                    }
                }

                $url = base_url().$login_userdata['user_slug'];
                $email_html = '';
                $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="'.MAIL_TD_1.'">
                                        <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                    </td>
                                    <td style="padding:5px;">
                                        <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> accepted your contact request.</p>
                                        <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                    </td>
                                    <td style="'.MAIL_TD_3.'">
                                        <p><a class="btn" href="'.$url.'">view</a></p>
                                    </td>
                                </tr>
                                </table>';
                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' accepted your contact request in Aileensoul.';

                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $from_id))->row();

                $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
                {
                    // $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
                    $url = base_url()."user_post/send_email_in_background";
                    $param = array(
                        "subject"=>$subject,
                        "email_html"=>$email_html,
                        "to_email"=>$to_email_id,
                        "unsubscribe"=>$unsubscribe,
                    );
                    $this->inbackground->do_in_background($url, $param);
                }
                //Send Mail End
            }
            echo json_encode($contactRequest);
        }
    }

    public function contactRequestCount() {
        $userid = $this->session->userdata('aileenuser');

        $contactRequestCount = $this->user_model->contactRequestCount($userid);
        echo json_encode($contactRequestCount);
    }

    public function data() {

        $this->load->view('loadmore/index', $this->data);
    }

    public function getdata() {
        echo "hi";
        die();
    }

    public function getUserDashboardPost() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_data = $this->userprofile_model->userDashboardPost($userid, $page);
        echo json_encode($post_data);
    }

    public function noscript()
    {
        $this->load->view('noscript');   
    }

    public function get_profile_menu()
    {
        $user_slug = $this->input->post('username'); 
        $ast = $this->input->post('ast'); 
        $ask = $this->input->post('ask'); 
        
        $user_data = $this->user_model->get_user_from_cookies('',base64_decode(base64_decode($ast)),base64_decode(base64_decode($ask)));        
        // print_r($user_data);
        // exit;
        if($user_data)
        {
            $userid = $user_data['user_id'];
            /*code for business profile link start */

            $contition_array = array('user_id' => $userid, 'is_deleted' => '0', 'status' => '1');
            $business_profile_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = 'business_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->business_profile_link = base_url("business-search/");
            if(isset($business_profile_count) && !empty($business_profile_count) && isset($business_profile_count[0]['business_count']) && $business_profile_count[0]['business_count']==1){
                $this->business_profile_link = base_url("business-profile/home");
            }
            /*Code for business profile link end*/

            /*code for Artis profile link start */
            $contition_array = array('user_id' => $userid);
            $artist_profile_count = $this->common->select_data_by_condition('art_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            /*Code for artist profile link ends*/ 

            /*code for Job profile link start */
            $contition_array = array('user_id' => $userid);
            $job_profile_count = $this->common->select_data_by_condition('job_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array_job = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
            $job_deactive = $this->common->select_data_by_condition('job_reg', $contition_array_job, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);

            $job_deactive = $job_deactive[0]['total'];
            /*Code for Job profile link ends*/
            /*code for recruiter profile link start */
            $contition_array = array('user_id' => $userid);
            $recruiter_profile_count = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            /*Code for recuiter profile link ends*/

            /*code for freelance hire link start */
            $contition_array = array('user_id' => $userid,'is_delete' => '0', 'status' => '1');
            $freelancer_hire_profile_count = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');        
            /*Code for freelance hire profile link ends*/

            /*code for freelace apply link start */
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $freelancer_apply_profile_count = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            /*Code for freelance aply link ends*/

            $this->business_profile_link = base_url("business-search");
            $this->artist_profile_link = base_url("find-artist");
            $this->job_profile_link = base_url("job-search");
            $this->recruiter_profile_link = base_url("recruiter");
            $this->freelance_hire_profile_link = base_url("freelance-profile");
            $this->freelance_apply_profile_link = base_url("freelance-profile");
            $this->business_profile_set = 0;
            $this->artist_profile_set = 0;
            $this->job_profile_set = 0;
            $this->recruiter_profile_set = 0;
            $this->freelance_hire_profile_set = 0;
            $this->freelance_apply_profile_set = 0;


            if(!empty($business_profile_count) &&  $business_profile_count[0]['business_step']==4){
                $this->business_profile_link = base_url("business-profile");
                $this->business_profile_set = 1;
            }
            if(!empty($artist_profile_count) &&  count($artist_profile_count)>0){
                $this->artist_profile_link = base_url("artist-profile");
                $this->artist_profile_set = 1;
            }
            if(!empty($job_profile_count) &&  count($job_profile_count)>0 && $job_deactive == 0){
                $this->job_profile_link = base_url("recommended-jobs");
                $this->job_profile_set = 1;
            }
            if(!empty($recruiter_profile_count) &&  count($recruiter_profile_count)>0){
                $this->recruiter_profile_link = base_url("recommended-candidates");
                $this->recruiter_profile_set = 1;
            }
            if(!empty($freelancer_hire_profile_count) &&  count($freelancer_hire_profile_count)>0){
                $this->freelance_hire_profile_link = base_url("hire-freelancer");                
                $this->freelance_hire_profile_set = 1;
            }
            if(!empty($freelancer_apply_profile_count) &&  count($freelancer_apply_profile_count)>0){
                $this->freelance_apply_profile_link = base_url("recommended-freelance-work");                
                $this->freelance_apply_profile_set = 1;
            }
            
            $login_user_totalpost = 0;
            if($userid){
                $login_data_sql = "SELECT user_slug FROM ailee_user where user_id = ".$userid;
                $login_data_query = $this->db->query($login_data_sql);        
                $login_user_totalpost = $login_data_query->row_array()['user_slug'];
            }
            if($userid){
                $all_path_link = base_url(). $login_user_totalpost . '/profiles';
            }else{
                $all_path_link = base_url('profiles');
            }            

            /*Code for business profile link end*/
            $header = '<div class="dropdown-title"> Profiles <a href="'. $all_path_link .'" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="'. $this->artist_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->business_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.  $this->job_profile_link .'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.$this->recruiter_profile_link.'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="'.base_url('freelance-profile').'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';            
            echo json_encode($header);exit();
        }
    }

    public function contact_request_node() {        
        $ast = $this->input->post('ast'); 
        $ask = $this->input->post('ask'); 
        
        $user_data = $this->user_model->get_user_from_cookies('',base64_decode(base64_decode($ast)),base64_decode(base64_decode($ask)));        
        // print_r($user_data);
        // exit;
        if($user_data)
        {
            $userid = $user_data['user_id'];

            $contactRequestUpdate = $this->user_model->contact_request_read($userid);
            $contactRequest = $this->user_model->contact_request($userid);
            echo json_encode($contactRequest);
        }
    }

    public function get_user_list()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $user_list = $this->user_model->get_user_list($searchTerm,$userid);
        }
        else
        {
            $user_list = array();
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($user_list));
    }

    public function monetize()
    {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");

        $this->data['is_user_monetize'] = $this->common->is_user_monetize($userid);
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);        
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        
        
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Monetize | Aileensoul";
        $this->load->view('user_post/monetize', $this->data);
    }

    public function save_monetize()
    {
        $userid = $this->session->userdata('aileenuser');
        $return_arr = array();
        if($userid != '')
        {
            $is_user_monetize = $this->common->is_user_monetize();
            if($is_user_monetize > 0)
            {
                $data = array();
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = '1';
                $user_monetize_id = $this->common->update_data($data, 'user_monetize', 'user_id', $userid);
            }
            else
            {
                $data = array();
                $data['user_id'] = $userid;                
                $data['created_date'] = date('Y-m-d H:i:s', time());
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = '1';
                $user_monetize_id = $this->common->insert_data_getid($data, 'user_monetize');
            }
            if($user_monetize_id > 0)
            {
                $return_arr['success'] = '1';
            }
            else
            {
                $return_arr['success'] = '0';
            }
        }
        else
        {
            $return_arr['success'] = '0';
        }
            return $this->output->set_content_type('application/json')->set_output(json_encode($return_arr));
    }

}
