<?php

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
            $userslug = $seg_slug;
        }
        $userdata = $this->data['userdata'] = $this->user_model->getUserDataByslug($userslug, $datat = "u.user_id,u.first_name,u.last_name,u.user_dob,u.user_gender,u.user_agree,u.created_date,u.verify_date,u.user_verify,u.user_slider,u.user_slug,ui.user_image,ui.modify_date,ui.edit_ip,ui.profile_background,ui.profile_background_main,ul.email,ul.password,ul.is_delete,ul.status,ul.password_code");
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userSlugBasicInfo'] = $this->user_model->getUserProfessionDataBySlug($userslug, $data = "jt.name as Designation,it.industry_name as Industry,c.city_name as City");
        $this->data['is_userSlugStudentInfo'] = $this->user_model->getUserStudentDataBySlug($userslug, $data = "d.degree_name as Degree,u.university_name as University,c.city_name as City");
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCountBySlug($userslug);
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
            $this->data['contact_id'] = $is_userContactInfo['id'];
            $this->data['from_id'] = $is_userContactInfo['from_id'];
        }

        if (count($is_userFollowInfo) != 0) {
            $this->data['follow_status'] = 1;
            $this->data['follow_id'] = $is_userFollowInfo['id'];
            $this->data['follow_value'] = $is_userFollowInfo['status'];
        } else {
            $this->data['follow_value'] = 'new';
            $this->data['follow_id'] = $is_userFollowInfo['id'];
            $this->data['follow_status'] = 0;
        }
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['header'] = $this->load->view('userprofile/header', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        // $this->data['footer'] = $this->load->view('userprofile/footer', $this->data, TRUE);
        

        if (count($userdata) > 0) {
            $this->load->view('userprofile/index', $this->data);
        } else {
            $this->data['title'] = "404 | Aileensoul";
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

            $url = base_url().$login_userdata['user_slug'];
            $email_html = '';
            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="'.MAIL_TD_1.'">
                                    <img src="' . USER_THUMB_UPLOAD_URL . $login_userdata['user_image'] . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
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
                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
            }
            //Send Mail End
        }
        echo json_encode($contactRequest);
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

}
