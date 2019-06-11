<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Userprofile_page extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('S3');
        $this->load->library('form_validation');

        $this->load->model('data_model');
        $this->load->model('user_model');
        $this->load->model('userprofile_model');
        $this->load->model('email_model');
        $this->load->model('searchelastic_model');
        $this->load->library('upload');
        $this->load->library('inbackground');
        include ('main_profile_link.php');
    }

    public function profile() {
        $this->load->view('userprofile/profiles', $this->data);
    }

    public function monetization_analytics() {

        $this->load->view('userprofile/monetization-analytics', $this->data);
    }

    public function dashboard() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->load->view('userprofile/dashboard', $this->data);
    }

    public function details() {

        $this->load->view('userprofile/details-new', $this->data);
    }

    public function contacts() {
        $this->load->view('userprofile/contacts', $this->data);
    }

    public function followers() {
        $this->load->view('userprofile/followers', $this->data);
    }

    public function following() {
        $this->load->view('userprofile/following', $this->data);
    }

    public function questions() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->load->view('userprofile/questions', $this->data);
    }

    public function savedpost() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->load->view('userprofile/savedpost', $this->data);
    }

    public function contact_request() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");

        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);

        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['title'] = "Contact Request".TITLEPOSTFIX;
        $this->load->view('userprofile/contact_request', $this->data);
    }

    public function pending_contact_request() {
        $userid = $this->session->userdata('aileenuser');
        $pendingContactRequest = $this->user_model->contact_request_pending($userid);
        echo json_encode($pendingContactRequest);
    }

    public function contactRequestNotification() {
        $userid = $this->session->userdata('aileenuser');
        $contactRequestNotification = $this->user_model->contact_request_accept($userid);
        echo json_encode($contactRequestNotification);
    }

    public function detail_data() {
        //$userid = $this->session->userdata('aileenuser');//old
        $user_slug = $_POST['u'];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $is_basicInfo = $this->data['is_basicInfo'] = $this->user_model->is_userBasicInfo($userid);
        if ($is_basicInfo == 0) {
            $detailsData = $this->data['detailsData'] = $this->user_model->getUserStudentData($userid, $data = "d.degree_name as Degree,u.university_name as University,c.city_name as City,CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) as first_name,usr.first_name as First name,CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2))) as last_name,usr.last_name as Last name,  CONCAT(CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) ,' ',CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2)))) as fullname , DATE_FORMAT(usr.user_dob, '%D %M %Y') as DOB,IF(us.interested_fields = 0 , us.other_interested_fields ,it.industry_name) as interested_fields,usr.user_dob");
        } else {
            $detailsData = $this->data['detailsData'] = $this->user_model->getUserProfessionData($userid, $data = "jt.name as Designation,CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) as first_name,CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2))) as last_name,IF(up.field = 0 , up.other_field ,it.industry_name) as Industry,c.city_name as City, CONCAT(CONCAT(UCASE(LEFT(usr.first_name,1)),LCASE(SUBSTRING(usr.first_name,2))) ,' ',CONCAT(UCASE(LEFT(usr.last_name,1)),LCASE(SUBSTRING(usr.last_name,2)))) as fullname , usr.first_name as First name,usr.last_name as Last name,DATE_FORMAT(usr.user_dob, '%D %M %Y') as DOB,'' as interested_fields,usr.user_dob");
        }
        $user_bio = $this->db->select('user_bio')->get_where('user_info', array('user_id' => $userid))->row('user_bio');
        $skills_data = $this->userprofile_model->get_user_skills($userid);
        $ret_arr['profile_progress'] = $this->progressbar($userid);
        $ret_arr['detail_data'] = $detailsData;
        $ret_arr['user_bio'] = $user_bio;
        $ret_arr['skills_data'] = $skills_data;
        $ret_arr['skills_data_edit'] = $skills_data;
        echo json_encode($ret_arr);
    }

    public function progressbar($user_id)
    {
        $contition_array = array('user_id' => $user_id);

        $user_data = $this->common->select_data_by_condition('user_info', $contition_array, $data = 'user_image, profile_background, user_bio, user_skills, user_hobbies, user_fav_quote_headline, user_fav_artist, user_fav_book, user_fav_sport,progressbar', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array())[0];
        $user_languages = $this->userprofile_model->get_user_languages($user_id);
        $user_experience = $this->userprofile_model->get_user_experience($user_id);
        $user_education = $this->userprofile_model->get_user_education($user_id);
        $user_links = $this->userprofile_model->get_user_links($user_id);
        $user_idol = $this->userprofile_model->get_user_idols($user_id);
        $count = 5;
        $progress_status = array();
        $user_image = 0;
        if($user_data['user_image'] != '')
        {
            $count = $count + 3;
            $user_image = 1;
        }
        $profile_background = 0;
        if($user_data['profile_background'] != '')
        {
            $count = $count + 3;
            $profile_background = 1;
        }
        $user_bio = 0;
        if($user_data['user_bio'] != '')
        {
            $count = $count + 1;
            $user_bio = 1;
        }
        $user_skills = 0;
        if($user_data['user_skills'] != '')
        {
            $count = $count + 3;
            $user_skills = 1;
        }
        $user_hobbies = 0;
        if($user_data['user_hobbies'] != '')
        {
            $count = $count + 1;
            $user_hobbies = 1;
        }
        $user_fav_quote_headline = 0;
        if($user_data['user_fav_quote_headline'] != '')
        {
            $count = $count + 1;
            $user_fav_quote_headline = 1;
        }
        $user_fav_artist = 0;
        if($user_data['user_fav_artist'] != '')
        {
            $count = $count + 1;
            $user_fav_artist = 1;
        }
        $user_fav_book = 0;
        if($user_data['user_fav_book'] != '')
        {
            $count = $count + 1;
            $user_fav_book = 1;
        }
        $user_fav_sport = 0;
        if($user_data['user_fav_sport'] != '')
        {
            $count = $count + 1;
            $user_fav_sport = 1;
        }
        $user_languages_status = 0;
        if(isset($user_languages) && !empty($user_languages))
        {
            $count = $count + 1;
            $user_languages_status = 1;
        }
        $user_experience_status = 0;
        if(isset($user_experience) && !empty($user_experience))
        {
            $count = $count + 3;
            $user_experience_status = 1;
        }
        $user_education_status = 0;
        if(isset($user_education) && !empty($user_education))
        {
            $count = $count + 3;
            $user_education_status = 1;
        }
        $user_links_status = 0;
        if(isset($user_links) && !empty($user_links))
        {
            $count = $count + 3;
            $user_links_status = 1;
        }
        $user_idol_status = 0;
        if(isset($user_idol) && !empty($user_idol))
        {
            $count = $count + 3;
            $user_idol_status = 1;
        }
        // echo $count;exit();
        $progress_status['user_image'] = $user_image;
        $progress_status['profile_background'] = $profile_background;
        $progress_status['user_bio'] = $user_bio;
        $progress_status['user_skills'] = $user_skills;
        $progress_status['user_hobbies'] = $user_hobbies;
        $progress_status['user_fav_quote_headline'] = $user_fav_quote_headline;
        $progress_status['user_fav_artist'] = $user_fav_artist;
        $progress_status['user_fav_book'] = $user_fav_book;
        $progress_status['user_fav_sport'] = $user_fav_sport;
        $progress_status['user_languages_status'] = $user_languages_status;
        $progress_status['user_experience_status'] = $user_experience_status;
        $progress_status['user_education_status'] = $user_education_status;
        $progress_status['user_links_status'] = $user_links_status;
        $progress_status['user_idol_status'] = $user_idol_status;

        $user_process = ($count * 100) / 33;        
        $user_process_value = ($user_process / 100);

        if ($user_process == 100) {
            //if ($user_data['progressbar'] != 1) {
                $data = array(
                    'progressbar' => '1',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'user_info', 'user_id', $user_id);
            //}
        } else {
            $data = array(
                'progressbar' => '0',
                'modify_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'user_info', 'user_id', $user_id);
        }
        return array("user_process"=>$user_process,"user_process_value"=>$user_process_value,"progress_status"=>$progress_status);
    }

    public function profiles_data() {
        $userid = $this->session->userdata('aileenuser');
        $profilesData = $this->data['profilesData'] = $this->userprofile_model->getdashboardata($userid, $data = "a.status as ap_status,a.art_step as ap_step,a.is_delete as ap_delete,r.re_status as rp_status,r.is_delete as rp_delete,r.re_step as rp_step,jr.is_delete as jp_delete,jr.status as jp_status,jr.job_step as jp_step,bp.status as bp_status,bp.is_deleted as bp_delete,bp.business_step as bp_step,fh.status as fh_status,fh.is_delete as fh_delete,fh.free_hire_step as fh_step,fp.status as fp_status,fp.is_delete as fp_delete,fp.free_post_step as fp_step");
        echo json_encode($profilesData);
    }

    public function followers_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        //$userid = $this->session->userdata('aileenuser');
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        $followersData = $this->data['followersData'] = $this->userprofile_model->getFollowersData($userid, $data = "", $page,$login_user_id);
        echo json_encode($followersData);
    }

    public function contacts_data() {

        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
       
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        $contactsData = $this->data['contactsData'] = $this->userprofile_model->getContactData($userid, $data = "", $page,$login_user_id);
        if (count($contactsData) == 0) {
            echo count($contactsData);
        } else {
            echo json_encode($contactsData);
        }
    }

    public function following_data() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }        
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $login_user_id = $this->session->userdata('aileenuser');
        
        $followingData = $this->data['followingData'] = $this->userprofile_model->getFollowingData($userid, $data = "", $page,$login_user_id);
        if (count($followingData) == 0) {
            echo count($followingData);
        } else {
            echo json_encode($followingData);
        }
    }

    public function vsrepeat() {
        $this->load->view('vsrepeat');
    }

    public function vsrepeat_data() {
        $this->db->select('first_name as name,user_id as id');
        $this->db->from('user');
        $this->db->limit('50');
        $query = $this->db->get();
        $data = $query->result_array();
        echo json_encode($data);
    }

    public function removeContacts() {
        $userid = $this->session->userdata('aileenuser');
        $id = $_POST['id'];
        $remove = $this->data['remove'] = $this->userprofile_model->userContactStatus($userid, $id);

        if (count($remove) != 0) {
            $data = array('status' => 'cancel');
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $remove['id']);
            $response = 1;
        } else {
            $response = 0;
        }
        $contactdata = $this->userprofile_model->getContactCount($userid);

        $removjson['response'] = $response;
        $removjson['contactcount'] = $contactdata[0]['total'];
        echo json_encode($removjson);
    }

    public function unfollowingContacts() {
        $userid = $this->session->userdata('aileenuser');
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);
        if (count($follow) != 0) {
            $data = array('status' => '0');
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $response = 1;
            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        } else {
            $response = 0;
            $html = '<a class="btn3 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        }
        $followingdata = $this->userprofile_model->getFollowingCount($userid);

        $unfollowingjson['response'] = $response;
        $unfollowingjson['unfollowingcount'] = $followingdata[0]['total'];
        $unfollowingjson['follow_view'] = $html;

        echo json_encode($unfollowingjson);
    }

    public function follow_business_user() {
        $userid = $this->session->userdata('aileenuser');
        //$follow_id = $_POST['follow_id'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userBusinessFollowStatus($userid, $id);

        if (count($follow) != 0) {           
            
            $data = array('status' => '1','modify_date' => date("Y-m-d h:i:s"));
            $where = array('id' => $follow['id'], 'follow_type' => '2');
            $this->db->where($where);
            $updatdata = $this->db->update('user_follow', $data);

            //   $response = $status;
            $html = '<a class="btn1 following"  ng-click="unfollow_business_user(' . $id . ')">Following</a>';
        } else {
            $data = array(
                'status' => '1',
                'follow_from' => $userid,
                'follow_to' => $id,
                'follow_type' => '2',
                'created_date' => date("Y-m-d h:i:s"),
                'modify_date' => date("Y-m-d h:i:s"),
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            // $response = $status;
            $html = '<a class="btn1 following"  ng-click="unfollow_business_user(' . $id . ')">Following</a>';
        }


        echo $html;
    }

    public function unfollowing_business_user() {
        $userid = $this->session->userdata('aileenuser');
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userBusinessFollowStatus($userid, $id);
        if (count($follow) != 0) {
            // $data = array('status' => '0');
            // $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);

            $data = array('status' => '0','modify_date' => date("Y-m-d h:i:s"));
            $where = array('id' => $follow['id'], 'follow_type' => '2');
            $this->db->where($where);
            $updatdata = $this->db->update('user_follow', $data);

            $response = 1;
            $html = '<a class="btn3 follow"  ng-click="follow_business_user(' . $id . ')">Follow</a>';
        } else {
            $response = 0;
            $html = '<a class="btn3 following"  ng-click="unfollow_business_user(' . $id . ')">Following</a>';
        }
        $followingdata = $this->userprofile_model->getFollowingCount($userid);

        $unfollowingjson['response'] = $response;
        $unfollowingjson['unfollowingcount'] = $followingdata[0]['total'];
        $unfollowingjson['follow_view'] = $html;

        echo json_encode($unfollowingjson);
    }

    public function addcontact() {
        $userid = $this->session->userdata('aileenuser');
        $contact_id = $_POST['contact_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $contact = $this->userprofile_model->userContactStatus($userid, $id);//Login user id,To user id

        if (count($contact) != 0) {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'not_read' => '2',
                'modify_date' => date('Y-m-d H:i:s', time()));
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $contact['id']);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'not_read' => '2',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_contact');
            $response = $status;
        }
        if($status == "pending")
        {            
            //Send Mail Start
            $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $id))->row()->email;
            $login_userdata = $this->user_model->getUserData($userid);

            $url = base_url().$login_userdata['user_slug'];
            if($login_userdata['user_image'] != "")
            {
                $user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
            }
            else
            {
                if($login_userdata['user_gender']  == 'M')
                {
                    $user_img = base_url('assets/img/man-user.jpg');
                }

                if($login_userdata['user_gender']  == 'F')
                {
                    $user_img = base_url('assets/img/female-user.jpg');
                }
            }
            $email_html = '';
            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="'.MAIL_TD_1.'">
                                    <img src="' . $user_img . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                </td>
                                <td style="padding:5px;">
                                    <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> sent you a contact request.</p>
                                    <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                </td>
                                <td style="'.MAIL_TD_3.'">
                                    <p><a class="btn" href="'.$url.'">view</a></p>
                                </td>
                            </tr>
                            </table>';
            $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' sent you a contact request in Aileensoul.';
            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $id))->row();
            $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
            {
                $url = base_url()."user_post/send_email_in_background";
                $param = array(
                    "subject"=>$subject,
                    "email_html"=>$email_html,
                    "to_email"=>$to_email_id,
                    "unsubscribe"=>$unsubscribe,
                );
                $this->inbackground->do_in_background($url, $param);
                // $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
            }
            //Send Mail End
        }
        echo $response;
    }

    public function addToContactNew() {
        $userid = $this->session->userdata('aileenuser');
        $contact_id = $_POST['contact_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $indexCon = $_POST['indexCon'];
        $contact = $this->userprofile_model->userContactStatus($userid, $id);

        if (count($contact) != 0) {
            $data = array('status' => $status, 'modify_date' => date('Y-m-d H:i:s', time()));
            $insert_id = $this->common->update_data($data, 'user_contact', 'id', $contact['id']);
            $response['status'] = $status;
        } else {
            $data = array(
                'status' => $status,
                'from_id' => $userid,
                'to_id' => $id,
                'not_read' => '2',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_contact');
            $response['status'] = $status;
        }

        if($status == "cancel")
        {            
            $response['button'] = '<a class="btn3" ng-click="contact('. $contact_id.', \'pending\', '.$id.','.$indexCon.')">Add to contact</a>';
        }
        if($status == "pending")
        {
            //Send Mail Start
            $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $id))->row()->email;
            $login_userdata = $this->user_model->getUserData($userid);

            $url = base_url().$login_userdata['user_slug'];
            if($login_userdata['user_image'] != "")
            {
                $user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
            }
            else
            {
                if($login_userdata['user_gender']  == 'M')
                {
                    $user_img = base_url('assets/img/man-user.jpg');
                }

                if($login_userdata['user_gender']  == 'F')
                {
                    $user_img = base_url('assets/img/female-user.jpg');
                }
            }
            $email_html = '';
            $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="'.MAIL_TD_1.'">
                                    <img src="'.$user_img.'" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                </td>
                                <td style="padding:5px;">
                                    <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> sent you a contact request.</p>
                                    <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                </td>
                                <td style="'.MAIL_TD_3.'">
                                    <p><a class="btn" href="'.$url.'">view</a></p>
                                </td>
                            </tr>
                            </table>';
            $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' sent you a contact request in Aileensoul.';

            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $id))->row();
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
            $response['button'] = '<a class="btn3" ng-click="contact('. $contact_id.', \'cancel\', '.$id.','.$indexCon.')">Request sent</a>';
        }
        echo json_encode($response);
    }

    public function addfollow() {
        $userid = $this->session->userdata('aileenuser');
        $follow_id = $_POST['follow_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => $status,'modify_date' => date("Y-m-d h:i:s"));
            $where = array('id' => $follow['id'], 'follow_type' => '1');
            $this->db->where($where);
            $updatdata = $this->db->update('user_follow', $data);
            // $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'follow_from' => $userid,
                'follow_to' => $id,
                'follow_type' => '1',
                'created_date' => date("Y-m-d h:i:s"),
                'modify_date' => date("Y-m-d h:i:s"),
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            $response = $status;
        }

        if($status == 1)
        {
            if($userid != $id)
            {
                $contition_array = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $id, 'not_from' => '7', 'not_img' => '0');
                $follownotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($follownotification[0]['not_read'] == 2) {                
                }
                elseif($follownotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $id, 'not_from' => '7', 'not_img' => '0');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '8',
                        'not_from_id' => $userid,
                        'not_to_id' => $id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '0',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $id))->row()->email;
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

                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="'.MAIL_TD_1.'">
                                                <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                            </td>
                                            <td style="padding:5px;">
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> started following you.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.BASEURL.$login_userdata['user_slug'].'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' started following you in Aileensoul.';
                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $id))->row();
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
                    }
                }
            }            
        }
        echo $response;
    }

    public function follow_user() {
        $userid = $this->session->userdata('aileenuser');
        //$follow_id = $_POST['follow_id'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => '1');
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            //   $response = $status;
            $html = '<a class="btn1 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        } else {
            $data = array(
                'status' => '1',
                'follow_from' => $userid,
                'follow_to' => $id,
                'created_date' => date("Y-m-d h:i:s"),
                'modify_date' => date("Y-m-d h:i:s"),
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            // $response = $status;
            $html = '<a class="btn1 following"  ng-click="unfollow_user(' . $id . ')">Following</a>';
        }


        echo $html;
    }

    public function unfollow_user() {
        $userid = $this->session->userdata('aileenuser');
        //$follow_id = $_POST['follow_id'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userFollowStatus($userid, $id);

        if (count($follow) != 0) {
            $data = array('status' => '0','modify_date' => date("Y-m-d h:i:s"));
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            //   $response = $status;

            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        } else {
            $data = array(
                'status' => '0',
                'follow_from' => $userid,
                'follow_to' => $id,
                'created_date' => date("Y-m-d h:i:s"),
                'modify_date' => date("Y-m-d h:i:s"),
            );
            $insert_id = $this->common->insert_data($data, 'user_follow');
            // $response = $status;
            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        }


        echo $html;
    }

    //PROFILE PIC INSERT END  

    public function user_profile_pic_update() {
        $userid = $this->session->userdata('aileenuser');
        $userslug = $this->session->userdata('aileenuser_slug');
        $userdata = $this->user_model->getUserDataByslug($userslug, $data = 'ui.user_image,u.user_slug,u.user_id');

        $user_prev_image = $userdata['user_image'];

        /*if ($user_prev_image != '') {
            $user_image_main_path = $this->config->item('user_main_upload_path');
            $user_img_full_image = $user_image_main_path . $user_prev_image;
            if (isset($user_img_full_image)) {
                unlink($user_img_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }*/


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('user_main_upload_path');
        $imageName = time() . '.jpg';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);

        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }


        /* RESIZE */
        $freelancer_hire_profile['image_library'] = 'gd2';
        $freelancer_hire_profile['source_image'] = $main_image;
        $freelancer_hire_profile['new_image'] = $main_image;
        $freelancer_hire_profile['quality'] = $quality;
        $instanse10 = "image10";
        $this->load->library('image_lib', $freelancer_hire_profile, $instanse10);
        /* RESIZE */
        

        $user_thumb_path = $this->config->item('user_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_thumb_width');
        $user_thumb_height = $this->config->item('user_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;       

        $data = array(
            'user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userdata['user_id']);

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['data_key'] = "profile_picture";
        $insert_data['data_value'] = $imageName;
        $insert_data['date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_data, 'user_profile_update');

        $insert_post_data = array();
        $insert_post_data['user_id'] = $userid;
        $insert_post_data['post_for'] = "profile_update";
        $insert_post_data['post_id'] = $inserted_id;
        $insert_post_data['status'] = 'publish';
        $insert_post_data['is_delete'] = '0';
        $insert_post_data['created_date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_post_data, 'user_post');

        if ($update) {
            $userdata = $this->user_model->getUserDataByslug($userslug, $data = 'ui.user_image');

            $new_people = $this->searchelastic_model->add_edit_single_people($userid);

            $userImageContent = '<a class="other-user-profile" hrerf="#" data-toggle="modal" data-target="#other-user-profile-img"><img src="' . USER_MAIN_UPLOAD_URL . $userdata['user_image'] . '"></a>';
            $userImageContent .= '<div class="upload-profile"><a class="cusome_upload" href="#" onclick="updateprofilepopup();" title="Update profile picture">
                            <img src="' . base_url('assets/n-images/cam.png') . '"  alt="CAMERAIMAGE">Update Profile Picture
                        </a>
                        <a data-toggle="modal" data-target="#view-profile-img" class="cusome_upload"  href="#">
                            <img src="'.base_url('assets/img/v-pic.png').'"  alt="CAMERAIMAGE">View
                        </a></div>';

            $this->session->set_userdata('aileenuser_userimage', $userdata['user_image']);
            $resData['userImageContent'] = $userImageContent;
            $resData['userProfilePicMain'] = USER_MAIN_UPLOAD_URL.$userdata['user_image'];
            $resData['userProfilePicThumb'] = USER_THUMB_UPLOAD_URL.$userdata['user_image'];

            echo json_encode($resData);
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect(base_url().$userdata['user_slug'], refresh);
        }
    }

    // cover pic controller
    public function ajaxpro() {

        $userid = $this->session->userdata('aileenuser');
        $user_reg_data = $this->userprofile_model->getUserBackImage($userid);

        $user_reg_prev_image = $user_reg_data['profile_background'];
        $user_reg_prev_main_image = $user_reg_data['profile_background_main'];

        /*if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('user_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('user_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('user_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }*/


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('user_bg_main_upload_path');
        $imageName = time() . '.jpg';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        //$this->thumb_img_uplode($file, $imageName, $user_bg_path, 1920, 500);

        $user_post_resize4['image_library'] = 'gd2';
        $user_post_resize4['source_image'] = $this->config->item('user_bg_main_upload_path') . $imageName;
        $user_post_resize4['new_image'] =  $this->config->item('user_bg_main_upload_path') . $imageName;
        $user_post_resize4['create_thumb'] = FALSE;
        $user_post_resize4['maintain_ratio'] = TRUE;
        $user_post_resize4['thumb_marker'] = '';
        $user_post_resize4['width'] = 1920;
        $user_post_resize4['height'] = 500;
        //$user_post_resize4['master_dim'] = width;
        $user_post_resize4['quality'] = "100%";
        $instanse4 = "image4";
        //Loading Image Library
        $this->load->library('image_lib', $user_post_resize4, $instanse4);
        //Creating Thumbnail
        $this->$instanse4->resize();
        //$this->$instanse4->clear();

        $main_image = $user_bg_path . $imageName;        

        $main_image_size = filesize($main_image);


        if ($main_image_size > '1000000') {
            $quality = "50%";
        } elseif ($main_image_size > '50000' && $main_image_size < '1000000') {
            $quality = "55%";
        } elseif ($main_image_size > '5000' && $main_image_size < '50000') {
            $quality = "60%";
        } elseif ($main_image_size > '100' && $main_image_size < '5000') {
            $quality = "65%";
        } elseif ($main_image_size > '1' && $main_image_size < '100') {
            $quality = "70%";
        } else {
            $quality = "100%";
        }

        $user_thumb_path = $this->config->item('user_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_bg_thumb_width');
        $user_thumb_height = $this->config->item('user_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;
        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;       

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'user_info', 'user_id', $userid);

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['data_key'] = "cover_picture";
        $insert_data['data_value'] = $imageName;
        $insert_data['date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_data, 'user_profile_update');

        $insert_post_data = array();
        $insert_post_data['user_id'] = $userid;
        $insert_post_data['post_for'] = "cover_update";
        $insert_post_data['post_id'] = $inserted_id;
        $insert_post_data['status'] = 'publish';
        $insert_post_data['is_delete'] = '0';
        $insert_post_data['created_date'] = date('Y-m-d H:i:s', time());
        $inserted_id = $user_cover_id = $this->common->insert_data_getid($insert_post_data, 'user_post');

        $user_reg_data = $this->userprofile_model->getUserBackImage($userid);
        $user_reg_back_image = $user_reg_data['profile_background'];

//        echo '<img src = "' . $this->data['busdata'][0]['profile_background'] . '" />';
        $resdata['cover'] = '  <div class="bg-images"><a data-toggle="modal" data-target="#view-cover-img" class="cusome_upload" href="#"><img id="image_src" name="image_src" src = "' . USER_BG_MAIN_UPLOAD_URL . $user_reg_back_image . '" /></a></div>';
        $resdata['cover_image'] = USER_BG_MAIN_UPLOAD_URL . $user_reg_back_image;

        echo json_encode($resdata);
    }

    public function question_detail($question_id = '') {
        $userid = $this->session->userdata('aileenuser');
        $this->data['question_data'] = $question_data = $this->userprofile_model->get_question_from_id($question_id);
        if($userid == "")
        {
            $userid = $question_data['user_id'];
        }
        $title = $question_data['question'];
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['question_id'] = $question_id;
        $this->data['title'] = $title.TITLEPOSTFIX;
        if($this->session->userdata('aileenuser') != "")
        {
            $this->load->view('userprofile/question_details', $this->data);
        }
        else
        {
            $this->load->view('userprofile/question_details_nologin', $this->data);   
        }
    }

    public function question_data() {

        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        } 
        // $userid = $this->session->userdata('aileenuser');

        $question_id = $_GET['question'];
        $questionData = $this->userprofile_model->questionData($question_id, $userid);
        echo json_encode($questionData);
    }

    public function questions_list() {
        //$userid = $this->session->userdata('aileenuser');
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        } 
        $questionList = $this->userprofile_model->questionList($userid, $data = "", $page);
        echo json_encode($questionList);
    }

    public function photos() {
        $this->load->view('userprofile/photos', $this->data);
    }

    public function photos_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }       

        $resdata['photosData'] = $this->data['photosData'] = $this->userprofile_model->getPhotosData($userid, $data = "", $page);
        if($page == 1)
        {            
            $resdata['allPhotosData'] = $this->userprofile_model->userAllPhotos($userid);
        }
        echo json_encode($resdata);
    }

    public function videos() {
        $this->load->view('userprofile/videos', $this->data);
    }

    public function videos_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $resdata['videoData'] = $this->data['videosData'] = $this->userprofile_model->getVideosData($userid, $data = "", $page);
         if($page == 1)
        {            
            $resdata['allVideosData'] = $this->userprofile_model->userAllVideo($userid);
        }

        echo json_encode($resdata);
    }

    public function audios() {
        $this->load->view('userprofile/audio', $this->data);
    }

    public function audios_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $audiosData = $this->data['audiosData'] = $this->userprofile_model->getAudiosData($userid, $data = "", $page);
        echo json_encode($audiosData);
    }

    public function pdf() {
        $this->load->view('userprofile/pdf', $this->data);
    }

    public function pdf_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $pdfData = $this->data['pdfData'] = $this->userprofile_model->getPdfData($userid, $data = "", $page);
        echo json_encode($pdfData);
    }

    public function article() {
        $this->load->view('userprofile/article', $this->data);
    }

    public function article_data() {
       
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];             
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $pdfData = $this->data['articleData'] = $this->userprofile_model->getArticleData($userid, $data = "", $page);
        echo json_encode($pdfData);
    }

    public function get_post_desctiprion($post_id,$post_for)
    {
        echo $post_id,$post_for;
    }

    public function save_user_bio()
    {
        $user_bio = $this->input->post('user_bio');
        $userid = $this->session->userdata('aileenuser');
        $data = array('user_bio' => $user_bio);
        $udpate_data = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        if($udpate_data)
        {
            $ret_arr = array("success"=>1,"user_bio"=>$user_bio);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        $ret_arr['profile_progress'] = $this->progressbar($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function save_user_skills()
    {
        $userid = $this->session->userdata('aileenuser');
        $skills = $this->input->post('user_skills');
        $skill_ids = "";
        foreach ($skills as $title) {
            $ski = $title['name'];
            $contition_array = array('skill' => trim($ski), 'type' => '1');
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

            if (!$skilldata) {

                $contition_array = array('skill' => trim($ski), 'type' => '7');
                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            }
            if ($skilldata) {

                $skill_id = $skilldata[0]['skill_id'];
            } else {

                $data = array(
                    'skill' => $ski,
                    'status' => '1',
                    'type' => '7',
                    'user_id' => $userid,
                );
                $skill_id = $this->common->insert_data_getid($data, 'skill');
            }           

            $skill_ids .= $skill_id . ',';
        }
        $skill_ids = trim($skill_ids, ',');
        $data = array('user_skills' => $skill_ids);
        $udpate_data = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        if($udpate_data)
        {
            $skills_data = $this->userprofile_model->get_user_skills($userid);
            $skills_data_edit = $skills_data;
            $ret_arr = array("success"=>1,"skills_data"=>$skills_data,"skills_data_edit"=>$skills_data_edit);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_skills() {
        $skills = $this->userprofile_model->get_skills();
        echo json_encode($skills);
    }

    public function get_about_user()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $about_user_data = $this->userprofile_model->get_about_user($userid);
        $user_languages = $this->userprofile_model->get_user_languages($userid);
        if(isset($about_user_data) && !empty($about_user_data))
        {
            $ret_arr = array("success"=>1,"about_user_data"=>$about_user_data,"user_languages"=>$user_languages);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_about_user()
    {
        $userid = $this->session->userdata('aileenuser');

        $language = $this->input->post('language');
        $proficiency = $this->input->post('proficiency');        
        
        if(isset($language) && isset($proficiency) && !empty($language) && !empty($proficiency))
        {
            $this->db->where('user_id', $userid);
            $this->db->delete('user_languages');

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
                        $insert_id = $this->common->insert_data($data, 'user_languages');
                    }
                }
            }            
        }
        
        // $user_dob = $this->input->post('user_dob');
        $user_hobby = $this->input->post('user_hobby');
        $user_hobby_txt = "";
        if(isset($user_hobby) && !empty($user_hobby))
        {
            foreach ($user_hobby as $key => $value) {
                $user_hobby_txt .= $value['hobby'].",";
            }
        }
        $user_hobby_txt = trim($user_hobby_txt,",");
        
        $user_fav_quote_headline = $this->input->post('user_fav_quote_headline');

        $user_fav_artist = $this->input->post('user_fav_artist');
        $user_fav_artist_txt = "";
        if(isset($user_fav_artist) && !empty($user_fav_artist))
        {
            foreach ($user_fav_artist as $key => $value) {
                $user_fav_artist_txt .= $value['fav_artist'].",";
            }
        }
        $user_fav_artist_txt = trim($user_fav_artist_txt,",");

        $user_fav_book = $this->input->post('user_fav_book');
        $user_fav_book_txt = "";
        if(isset($user_fav_book) && !empty($user_fav_book))
        {
            foreach ($user_fav_book as $key => $value) {
                $user_fav_book_txt .= $value['fav_book'].",";
            }
        }
        $user_fav_book_txt = trim($user_fav_book_txt,",");

        $user_fav_sport = $this->input->post('user_fav_sport');
        $user_fav_sport_txt = "";
        if(isset($user_fav_sport) && !empty($user_fav_sport))
        {
            foreach ($user_fav_sport as $key => $value) {
                $user_fav_sport_txt .= $value['fav_sport'].",";
            }
        }
        $user_fav_sport_txt = trim($user_fav_sport_txt,",");
        // $data_dob = array("user_dob"=>$user_dob);
        // $udpate_data_dob = $this->common->update_data($data_dob, 'user', 'user_id', $userid);

        $data = array(
            'user_hobbies' => $user_hobby_txt,
            'user_fav_quote_headline' => $user_fav_quote_headline,
            'user_fav_artist' => $user_fav_artist_txt,
            'user_fav_book' => $user_fav_book_txt,
            'user_fav_sport' => $user_fav_sport_txt,            
        );
        $udpate_data = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        if($udpate_data)
        {
            $about_user_data = $this->userprofile_model->get_about_user($userid);
            $user_languages = $this->userprofile_model->get_user_languages($userid);
            $ret_arr = array("success"=>1,"about_user_data"=>$about_user_data,"user_languages"=>$user_languages);//,"user_dob"=>$user_dob);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_research_user()
    {
        $edit_research = $this->input->post('edit_research');
        $research_document_old = ($this->input->post('research_document_old') != "" && $this->input->post('research_document_old') != "undefined" ? $this->input->post('research_document_old') : '');
        $research_title = $this->input->post('research_title');
        $research_desc = $this->input->post('research_desc');
        $research_field = $this->input->post('research_field');
        if($research_field == 0)
        {
            $research_other_field = $this->input->post('research_other_field');
        }
        else
        {
            $research_other_field = "";
        }
            
        $research_url = $this->input->post('research_url');
        $research_published_date = $this->input->post('research_year').'-'.$this->input->post('research_month').'-'.$this->input->post('research_day');
        $fileName = $research_document_old;
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $user_research_upload_path = $this->config->item('user_research_upload_path');
            $research_document_old = $user_research_upload_path . $research_document_old;
            if (isset($research_document_old)) {
                unlink($research_document_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_research_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('file'))            {
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['file']['tmp_name'],$this->config->item('user_research_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_research = $this->userprofile_model->set_user_research($user_id,$research_title,$research_desc,$research_field,$research_other_field,$research_url,$research_published_date,$fileName,$edit_research);
            $user_research = $this->userprofile_model->get_user_research($user_id);
            $ret_arr = array("success"=>1,"user_research"=>$user_research);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_research()
    {
        $research_id = $this->input->post('research_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_research_insert = $this->userprofile_model->delete_user_research($user_id,$research_id);
            $user_research = $this->userprofile_model->get_user_research($user_id);
            $ret_arr = array("success"=>1,"user_research"=>$user_research);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    function save_user_links()
    {
        $userid = $this->session->userdata('aileenuser');
        $link_type = $this->input->post('link_type');
        $link_url = $this->input->post('link_url');
        $personal_link_url = $this->input->post('personal_link_url');

        $this->db->where('user_id', $userid);
        $this->db->delete('user_links');

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
                    $insert_id = $this->common->insert_data($data, 'user_links');
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
                    $insert_id = $this->common->insert_data($data, 'user_links');
                }
            }
        }

        $user_social_links_data = $this->userprofile_model->get_user_social_links($userid);        
        $user_personal_links_data = $this->userprofile_model->get_user_personal_links($userid);        
        $ret_arr = array("success"=>1,"user_social_links_data"=>$user_social_links_data,"user_personal_links_data"=>$user_personal_links_data);
        $ret_arr['profile_progress'] = $this->progressbar($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_links()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $user_social_links_data = $this->userprofile_model->get_user_social_links($userid);        
        $user_personal_links_data = $this->userprofile_model->get_user_personal_links($userid);        
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

    public function save_user_idol()
    {
        $edit_idols = $this->input->post('edit_idols');
        if($edit_idols == 0)
        {            
            if(isset($_FILES['user_idol_file']['name']) && $_FILES['user_idol_file']['name'] != "")
            {
                $user_idol_name = $this->input->post('user_idol_name');
                $fileName = "";
                $user_idol_upload_path = $this->config->item('user_idol_upload_path');
                $config = array(
                    'image_library' => 'gd',
                    'upload_path'   => $user_idol_upload_path,
                    'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                    'overwrite'     => true,
                    'remove_spaces' => true
                );
                $store = $_FILES['user_idol_file']['name'];
                $store_ext = explode('.', $store);        
                $store_ext = $store_ext[count($store_ext)-1];
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
                $config['file_name'] = $fileName;
                $this->upload->initialize($config);
                $imgdata = $this->upload->data();
                if($this->upload->do_upload('user_idol_file')){
                    $main_image = $user_idol_upload_path . $fileName;
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                    if (IMAGEPATHFROM == 's3bucket') {
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                    }
                }
                $userid = $this->session->userdata('aileenuser');                
                $user_idol = $this->userprofile_model->save_user_idol($userid,$user_idol_name,$fileName);

                $user_idol = $this->userprofile_model->get_user_idols($userid);
                $profile_progress = $this->progressbar($userid);
                $ret_arr = array("success"=>1,"user_idols"=>$user_idol,"profile_progress"=>$profile_progress);
            }
            else
            {
                $ret_arr = array("success"=>0);
            }
        }
        else
        {
            $user_idol_name = $this->input->post('user_idol_name');            
            $user_idol_pic_old = $this->input->post('user_idol_pic_old');
            $fileName = $user_idol_pic_old;
            if(isset($_FILES['user_idol_file']['name']) && $_FILES['user_idol_file']['name'] != "")
            {
                $user_idol_upload_path = $this->config->item('user_idol_upload_path');
                $user_idol_file_old = $user_idol_upload_path . $user_idol_pic_old;
                if (isset($user_idol_file_old)) {
                    unlink($user_idol_file_old);
                }
                $config = array(
                    'image_library' => 'gd',
                    'upload_path'   => $user_idol_upload_path,
                    'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                    'overwrite'     => true,
                    'remove_spaces' => true
                );
                $store = $_FILES['user_idol_file']['name'];
                $store_ext = explode('.', $store);        
                $store_ext = $store_ext[count($store_ext)-1];
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
                $config['file_name'] = $fileName;
                $this->upload->initialize($config);
                $imgdata = $this->upload->data();
                if($this->upload->do_upload('user_idol_file')){
                    $main_image = $user_idol_upload_path . $fileName;
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                    if (IMAGEPATHFROM == 's3bucket') {
                        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                    }
                }
            }
            $userid = $this->session->userdata('aileenuser');                
            $user_idol = $this->userprofile_model->save_user_idol($userid,$user_idol_name,$fileName,$edit_idols);
            $user_idol = $this->userprofile_model->get_user_idols($userid);
            $profile_progress = $this->progressbar($userid);                
            $ret_arr = array("success"=>1,"user_idols"=>$user_idol,"profile_progress"=>$profile_progress);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_idol()
    {
        $idol_id = $this->input->post('idol_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_idol_insert = $this->userprofile_model->delete_user_idol($user_id,$idol_id);
            $user_idol = $this->userprofile_model->get_user_idols($user_id);
            $profile_progress = $this->progressbar($user_id);  
            $ret_arr = array("success"=>1,"user_idols"=>$user_idol,"profile_progress"=>$profile_progress);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_idol()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $user_idols = $this->userprofile_model->get_user_idols($userid);
        $ret_arr = array("success"=>1,"user_idols"=>$user_idols);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_publication()
    {
        $edit_publication = $this->input->post('edit_publication');
        $pub_file_old = $this->input->post('pub_file_old');
        $pub_title = $this->input->post('pub_title');
        $pub_author = $this->input->post('pub_author');
        $pub_url = $this->input->post('pub_url');
        $pub_publisher = $this->input->post('pub_publisher');
        $pub_desc = $this->input->post('pub_desc');
        $publication_date = $this->input->post('pub_year_txt').'-'.$this->input->post('pub_month_txt').'-'.$this->input->post('pub_day_txt');
        $fileName = $pub_file_old;
        if(isset($_FILES['pub_file']['name']) && $_FILES['pub_file']['name'] != "")
        {
            $user_publication_upload_path = $this->config->item('user_publication_upload_path');
            $user_publication_file_old = $user_publication_upload_path . $pub_file_old;
            if (isset($user_publication_file_old)) {
                unlink($user_publication_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_publication_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['pub_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['pub_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('pub_file'))            {
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['pub_file']['tmp_name'],$this->config->item('user_publication_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_publication = $this->userprofile_model->set_user_publication($user_id,$pub_title,$pub_author,$pub_url,$pub_publisher,$pub_desc,$publication_date,$fileName,$edit_publication);
            $user_publication = $this->userprofile_model->get_user_publication($user_id);
            $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_publication()
    {
        $publication_id = $this->input->post('publication_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_publication_insert = $this->userprofile_model->delete_user_publication($user_id,$publication_id);
            $user_publication = $this->userprofile_model->get_user_publication($user_id);
            $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_patent()
    {
        $edit_patent = $this->input->post('edit_patent');
        $patent_file_old = $this->input->post('patent_file_old');
        $patent_title = $this->input->post('patent_title');
        $patent_creator = $this->input->post('patent_creator');
        $patent_number = $this->input->post('patent_number');
        $patent_date = $this->input->post('patent_year').'-'.$this->input->post('patent_month').'-'.$this->input->post('patent_day');
        $patent_office = $this->input->post('patent_office');
        $patent_url = $this->input->post('patent_url');
        $patent_desc = $this->input->post('patent_desc');
        // $fileName = "";
        $fileName = $patent_file_old;
        if(isset($_FILES['patent_file']['name']) && $_FILES['patent_file']['name'] != "")
        {
            $user_patent_upload_path = $this->config->item('user_patent_upload_path');
            $user_patent_file_old = $user_patent_upload_path . $patent_file_old;
            if (isset($user_patent_file_old)) {
                unlink($user_patent_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_patent_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['patent_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['patent_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('patent_file'))            {
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['patent_file']['tmp_name'],$this->config->item('user_patent_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_patent_insert = $this->userprofile_model->set_user_patent($user_id,$patent_title,$patent_creator,$patent_number,$patent_date,$patent_office,$patent_url,$patent_desc,$fileName,$edit_patent);
            $user_patent = $this->userprofile_model->get_user_patent($user_id);
            $ret_arr = array("success"=>1,"user_patent"=>$user_patent);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_patent()
    {
        $patent_id = $this->input->post('patent_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_patent_insert = $this->userprofile_model->delete_user_patent($user_id,$patent_id);
            $user_patent = $this->userprofile_model->get_user_patent($user_id);
            $ret_arr = array("success"=>1,"user_patent"=>$user_patent);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
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
            $user_award_upload_path = $this->config->item('user_award_upload_path');
            $user_award_file_old = $user_award_upload_path . $awards_file_old;
            if (isset($user_award_file_old)) {
                unlink($user_award_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_award_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['award_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['award_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('award_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['award_file']['tmp_name'],$this->config->item('user_award_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_award_insert = $this->userprofile_model->set_user_award($user_id,$award_title,$award_org,$award_date,$award_desc,$fileName,$edit_awards);
            $user_award = $this->userprofile_model->get_user_award($user_id);
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
            $user_addicourse_insert = $this->userprofile_model->delete_user_award($user_id,$award_id);
            $user_award = $this->userprofile_model->get_user_award($user_id);
            $ret_arr = array("success"=>1,"user_award"=>$user_award);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_activity()
    {
        $edit_activity = $this->input->post('edit_activity');
        $activity_file_old = $this->input->post('activity_file_old');
        $activity_participate = $this->input->post('activity_participate');
        $activity_org = $this->input->post('activity_org');        
        $award_start_date = $this->input->post('activity_s_year').'-'.$this->input->post('activity_s_month');
        $award_end_date = $this->input->post('activity_e_year').'-'.$this->input->post('activity_e_month');
        $activity_desc = $this->input->post('activity_desc');
        $fileName = $activity_file_old;
        if(isset($_FILES['activity_file']['name']) && $_FILES['activity_file']['name'] != "")
        {
            $user_activity_upload_path = $this->config->item('user_activity_upload_path');
            $user_activity_file_old = $user_activity_upload_path . $activity_file_old;
            if (isset($user_activity_file_old)) {
                unlink($user_activity_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_activity_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['activity_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];            
            $file_type = explode("/", $_FILES['activity_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('activity_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['activity_file']['tmp_name'],$this->config->item('user_activity_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_activity_insert = $this->userprofile_model->set_user_activity($user_id,$activity_participate,$activity_org,$award_start_date,$award_end_date,$activity_desc,$fileName,$edit_activity);
            $user_activity = $this->userprofile_model->get_user_activity($user_id);
            $ret_arr = array("success"=>1,"user_activity"=>$user_activity);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_activity()
    {
        $activity_id = $this->input->post('activity_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_addicourse_insert = $this->userprofile_model->delete_user_activity($user_id,$activity_id);
            $user_activity = $this->userprofile_model->get_user_activity($user_id);
            $ret_arr = array("success"=>1,"user_activity"=>$user_activity);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
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
            $user_addicourse_upload_path = $this->config->item('user_addicourse_upload_path');
            $user_addicourse_file_old = $user_addicourse_upload_path . $addicourse_file_old;
            if (isset($user_addicourse_file_old)) {
                unlink($user_addicourse_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_addicourse_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['addicourse_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['addicourse_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('addicourse_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['addicourse_file']['tmp_name'],$this->config->item('user_addicourse_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_activity_insert = $this->userprofile_model->set_user_addicourse($user_id,$addicourse_name,$addicourse_org,$addicourse_start_date,$addicourse_end_date,$addicourse_url,$fileName,$edit_addicourse);
            $user_addicourse = $this->userprofile_model->get_user_addicourse($user_id);
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
            $user_addicourse_insert = $this->userprofile_model->delete_user_addicourse($user_id,$addicourse_id);
            $user_addicourse = $this->userprofile_model->get_user_addicourse($user_id);
            $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_country() {
        $county_list = $this->user_model->getCountry();
        echo json_encode($county_list);
    }

    public function get_state_by_country_id() {
        $country_id = $this->input->post('country_id');
        $state_list = $this->user_model->getStateByCountryId($country_id);
        echo json_encode($state_list);
        
    }

    public function get_city_by_state_id() {
        $state_id = $this->input->post('state_id');
        $cityList = $this->user_model->getCityByStateId($state_id);
        if(isset($cityList) && !empty($cityList)){
            echo json_encode($cityList);
        } else {
            echo json_encode(array(array("city_id" => "0", "city_name" => "No City")));
        }
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
                $data['name'] = $exp_designation;
                $data['created_date'] = date('Y-m-d H:i:s', time());
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = 'draft';
                $data['slug'] = $this->common->clean($exp_designation);
                $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
            }
            $exp_designation_id = $jobTitleId;
        // }        
        $fileName = $exp_file_old;
        if(isset($_FILES['exp_file']['name']) && $_FILES['exp_file']['name'] != "")
        {            
            $user_experience_upload_path = $this->config->item('user_experience_upload_path');
            $user_exp_file_old = $user_experience_upload_path . $exp_file_old;
            if (isset($user_exp_file_old)) {
                unlink($user_exp_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_experience_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['exp_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['exp_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('exp_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['exp_file']['tmp_name'],$this->config->item('user_experience_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->userprofile_model->set_user_experience($user_id,$exp_company_name,$exp_designation_id,$exp_company_website,$exp_field,$exp_other_field,$exp_country,$exp_state,$exp_city,$exp_start_date,$exp_end_date,$exp_isworking,$exp_desc,$fileName,$edit_exp);
            $user_experience = $this->userprofile_model->get_user_experience($user_id);
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
        $ret_arr['profile_progress'] = $this->progressbar($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_experience()
    {
        $exp_id = $this->input->post('exp_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->userprofile_model->delete_user_experience($user_id,$exp_id);
            $user_experience = $this->userprofile_model->get_user_experience($user_id);
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
            $profile_progress = $this->progressbar($user_id);
            $ret_arr = array("success"=>1,"user_experience"=>$user_experience,"exp_years"=>$years,"exp_months"=>$total_month,"profile_progress"=>$profile_progress);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_experience()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        
        $user_experience = $this->userprofile_model->get_user_experience($userid);
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

    public function save_user_project()
    {
        $edit_project = $this->input->post('edit_project');
        $project_file_old = $this->input->post('project_file_old');
        $project_title = $this->input->post('project_title');
        $project_team = $this->input->post('project_team');
        $project_role = $this->input->post('project_role');
        $project_skill_list = json_decode($this->input->post('project_skill_list'),TRUE);
        $project_field = $this->input->post('project_field');        
        $project_url = $this->input->post('project_url');
        $project_partner = json_decode($this->input->post('project_partner'),TRUE);
        $project_start_date = $this->input->post('project_s_year').'-'.$this->input->post('project_s_month');
        $project_end_date = $this->input->post('project_e_year').'-'.$this->input->post('project_e_month');
        $project_desc = $this->input->post('project_desc');
        
        if($project_field == 0)
        {
            $project_other_field = $this->input->post('project_other_field');
        }
        else
        {
            $project_other_field = "";
        }
        
        $project_skill_ids = "";
        foreach ($project_skill_list as $title) {
            $ski = $title['name'];
            $contition_array = array('skill' => trim($ski), 'type' => '1');
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

            if (!$skilldata) {

                $contition_array = array('skill' => trim($ski), 'type' => '7');
                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            }
            if ($skilldata) {

                $skill_id = $skilldata[0]['skill_id'];
            } else {

                $data = array(
                    'skill' => $ski,
                    'status' => '1',
                    'type' => '7',
                    'user_id' => $userid,
                );
                $skill_id = $this->common->insert_data_getid($data, 'skill');
            }           

            $project_skill_ids .= $skill_id . ',';
        }
        $project_skill_ids = trim($project_skill_ids, ',');

        $project_partner_name = "";
        if(isset($project_partner) && !empty($project_partner))
        {
            foreach ($project_partner as $_project_partner) {
                if(trim($_project_partner['p_name']) != "")
                {
                    $project_partner_name .= $_project_partner['p_name'].",";
                }
            }
        }
        $project_partner_name = trim($project_partner_name, ',');

        $fileName = $project_file_old;
        if(isset($_FILES['project_file']['name']) && $_FILES['project_file']['name'] != "")
        {
            $user_project_upload_path = $this->config->item('user_project_upload_path');
            $user_proj_file_old = $user_project_upload_path . $project_file_old;
            if (isset($user_proj_file_old)) {
                unlink($user_proj_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_project_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['project_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $file_type = explode("/", $_FILES['project_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('project_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['project_file']['tmp_name'],$this->config->item('user_project_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_project_insert = $this->userprofile_model->set_user_project($user_id,$project_title,$project_team,$project_role,$project_skill_ids,$project_field,$project_other_field,$project_url,$project_partner_name,$project_start_date,$project_end_date,$project_desc,$fileName,$edit_project);
            $user_projects = $this->userprofile_model->get_user_project($user_id);            
            $ret_arr = array("success"=>1,"user_projects"=>$user_projects);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_project()
    {
        $project_id = $this->input->post('project_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->userprofile_model->delete_user_project($user_id,$project_id);
            $user_projects = $this->userprofile_model->get_user_project($user_id);
            $ret_arr = array("success"=>1,"user_projects"=>$user_projects);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_edu_degree()
    {
        $contition_array = array('is_delete' => '0', 'is_other' => '0', 'degree_name !=' => '');
        $search_condition = "(status = '1')";
        $degree_data = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = 'degree_id,degree_name', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $ret_arr = array("degree_data"=>$degree_data);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_edu_university()
    {
        $contition_array = array('is_delete' => '0','is_other' => '0','university_name !=' => "");
        $search_condition = "(status = '1')";
        $university_data = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = 'university_id,university_name', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $ret_arr = array("university_data"=>$university_data);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_stream_by_degree_id()
    {
        $degree_id = $this->input->post('degree_id');
        $contition_array = array('is_delete' => '0', 'degree_id' => $degree_id);
        $search_condition = "(status = '1')";
        $stream_data = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = 'stream_id,stream_name', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if (count($stream_data) > 0) {
            $ret_arr = array("stream_data"=>$stream_data);
        } else {
            $ret_arr = array("stream_data"=>array(array("stream_id" => "0", "stream_name" => "No Stream")));
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
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
            $user_education_upload_path = $this->config->item('user_education_upload_path');
            $user_edu_file_old = $user_education_upload_path . $edu_file_old;
            if (isset($user_edu_file_old)) {
                unlink($user_edu_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $user_education_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['edu_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];            
            $file_type = explode("/", $_FILES['edu_file']['type']);
            if($file_type[0] == 'image')
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.jpg';
            }
            else
            {
                $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;
            }
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('edu_file')){
                if($file_type[0] == 'image')
                {
                    $this->common->resizeImage($_FILES['edu_file']['tmp_name'],$this->config->item('user_education_upload_path'),$fileName,90,'','',0);
                }
            }
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_project_insert = $this->userprofile_model->set_user_education($user_id,$edu_school_college,$edu_university,$edu_other_university,$edu_degree,$edu_stream,$edu_other_degree,$edu_other_stream,$edu_start_date,$edu_end_date,$edu_nograduate,$fileName,$edit_edu);
            $user_education = $this->userprofile_model->get_user_education($user_id);            
            $ret_arr = array("success"=>1,"user_education"=>$user_education);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar($user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function delete_user_education()
    {
        $edu_id = $this->input->post('edu_id');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $user_exp_insert = $this->userprofile_model->delete_user_education($user_id,$edu_id);
            $user_education = $this->userprofile_model->get_user_education($user_id);
            $profile_progress = $this->progressbar($user_id);              
            $ret_arr = array("success"=>1,"user_education"=>$user_education,"profile_progress"=>$profile_progress);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_education()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        
        $user_education = $this->userprofile_model->get_user_education($userid);        
        $ret_arr = array("success"=>1,"user_education"=>$user_education);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_project()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        
        $user_projects = $this->userprofile_model->get_user_project($userid);        
        $ret_arr = array("success"=>1,"user_projects"=>$user_projects);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_addicourse()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_addicourse = $this->userprofile_model->get_user_addicourse($userid);        
        $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_activity()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_activity = $this->userprofile_model->get_user_activity($userid);
        $ret_arr = array("success"=>1,"user_activity"=>$user_activity);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_award()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_award = $this->userprofile_model->get_user_award($userid);
        $ret_arr = array("success"=>1,"user_award"=>$user_award);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_publication()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_publication = $this->userprofile_model->get_user_publication($userid);
        $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_patent()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_patent = $this->userprofile_model->get_user_patent($userid);
        $ret_arr = array("success"=>1,"user_patent"=>$user_patent);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_research()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');        
        $user_research = $this->userprofile_model->get_user_research($userid);
        $ret_arr = array("success"=>1,"user_research"=>$user_research);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $professionData = $this->user_model->getUserProfessionData($userid,"jt.name as job_title,c.city_name,up.field,up.other_field");        
        $studentData = $this->user_model->getUserStudentData($userid,"d.degree_name,c.city_name,u.university_name,us.interested_fields,us.other_interested_fields");
        $ret_arr = array("success"=>1,"professionData"=>$professionData,"studentData"=>$studentData);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_basicinfo()
    {
        // print_r($this->input->post());exit();
        $basic_job_title = substr($this->input->post('basic_job_title'),0,200);
        $basic_info_city = substr($this->input->post('basic_info_city'),0,200);
        $basic_info_field = $this->input->post('basic_info_field');
        if($basic_info_field == 0)
        {
            $basic_info_other_field = $this->input->post('basic_info_other_field');
        }
        else
        {
            $basic_info_other_field = ""   ;
        }        

        $designation = $this->data_model->findJobTitle($basic_job_title);
        if ($designation['title_id'] != '') {
            $jobTitleId = $designation['title_id'];
        } else {
            $data = array();
            $data['name'] = $basic_job_title;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['status'] = 'draft';
            $data['slug'] = $this->common->clean($basic_job_title);
            $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
        }

        $city = $this->data_model->findCityList($basic_info_city);
        if ($city['city_id'] != '') {
            $cityId = $city['city_id'];
        } else {
            $data = array();
            $city_slug = $this->common->set_city_slug(trim($basic_info_city), 'slug', 'cities');
            $data['city_name'] = $basic_info_city;
            $data['state_id'] = '0';
            $data['status'] = '2';
            $data['group_id'] = '0';
            $data['slug'] = $this->common->clean($city_slug);
            $data['city_image'] = $this->common->clean($city_slug).".png";
            $cityId = $this->common->insert_data_getid($data, 'cities');
        }        

        $userid = $this->session->userdata('aileenuser');
        $professionData = $this->user_model->getUserProfessionData($userid,"*"); 

        $data_user = array(
            'is_student' => '0',
        );
        $updatdata_user = $this->common->update_data($data_user, 'user', 'user_id', $userid);

        $data_up = array(
            'designation' => $jobTitleId,
            'field' => $basic_info_field,
            'other_field' => substr($basic_info_other_field, 0,300),
            'city' => $cityId,
        );

        if(isset($professionData) && !empty($professionData))
        {                
            $updatdata_up = $this->common->update_data($data_up, 'user_profession', 'user_id', $userid);
        }
        else
        {
            $data_up['user_id'] = $userid;
            $updatdata_up = $this->common->insert_data_getid($data_up, 'user_profession');
        }
        
        if($updatdata_up)
        {
            $this->common->delete_data('user_student', 'user_id', $userid);
            $ret_arr = array("success"=>1);
            $this->searchelastic_model->add_edit_single_people($userid);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_studinfo()
    {
        // print_r($this->input->post());exit();
        $stud_info_study = substr($this->input->post('stud_info_study'),0,200);
        $stud_info_city = substr($this->input->post('stud_info_city'),0,300);
        $stud_info_university = substr($this->input->post('stud_info_university'),0,300);
        $stud_info_field = $this->input->post('stud_info_field');
        if($stud_info_field == 0)
        {
            $stud_info_other_field = $this->input->post('stud_info_other_field');
        }
        else
        {
            $stud_info_other_field = ""   ;
        }

        $contition_array = array('LOWER(degree_name)' => strtolower(trim($stud_info_study)));
        $currentStudydata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
        
        if ($currentStudydata) {
            $currentStudyId = $currentStudydata[0]['degree_id'];
        } else {
            $data = array();
            $data['degree_name'] = $stud_info_study;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['status'] = '2';
            $data['is_delete'] = '0';
            $data['is_other'] = '1';
            $data['user_id'] = $userid;
            $currentStudyId = $this->common->insert_data_getid($data, 'degree');
        }

        $city = $this->data_model->findCityList($stud_info_city);
        if ($city['city_id'] != '') {
            $cityId = $city['city_id'];
        } else {
            $data = array();
            $city_slug = $this->common->set_city_slug(trim($stud_info_city), 'slug', 'cities');
            $data['city_name'] = $stud_info_city;
            $data['state_id'] = '0';
            $data['status'] = '2';
            $data['group_id'] = '0';
            $data['slug'] = $this->common->clean($city_slug);
            $data['city_image'] = $this->common->clean($city_slug).".png";
            $cityId = $this->common->insert_data_getid($data, 'cities');
        }

        $universityData = $this->data_model->findUniversityList($stud_info_university);
        if ($universityData['university_id'] != '') {
            $universityId = $universityData['university_id'];
        } else {
            $data = array();
            $data['university_name'] = $stud_info_university;
            $data['created_date'] = date('Y-m-d H:i:s',time());
            $data['status'] = '2';
            $data['is_delete'] = '0';
            $data['is_other'] = '1';
            $universityId = $this->common->insert_data_getid($data, 'university');
        }

        $userid = $this->session->userdata('aileenuser');
        $studentData = $this->user_model->getUserStudentData($userid,"*");

        $data_user = array(
            'is_student' => '1',
        );
        $updatdata_user = $this->common->update_data($data_user, 'user', 'user_id', $userid);

        $data_up = array(
            'current_study' => $currentStudyId,
            'city' => $cityId,
            'university_name' => $universityId,
            'interested_fields' => $stud_info_field,
            'other_interested_fields' => substr($stud_info_other_field,0,300),
        );

        if(isset($studentData) && !empty($studentData))
        {                
            $id = $studentData['id'];
            $updatdata_up = $this->common->update_data($data_up, 'user_student','user_id', $userid);
            $new_people = $this->searchelastic_model->add_edit_single_people($userid);
        }
        else
        {
            $data_up['user_id'] = $userid;
            $updatdata_up = $this->common->insert_data_getid($data_up, 'user_student');
        }
        if($updatdata_up)
        {
            $this->common->delete_data('user_profession', 'user_id', $userid);    
            $ret_arr = array("success"=>1);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }        
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_report_spam()
    {
        $login_user_id = $this->session->userdata('aileenuser');
        $reported_post_id = $this->input->post('reported_post_id');        
        $reported_reason = $this->input->post('reported_reason');
        if($reported_reason == 0)
        {
            $reported_reason_other = $this->input->post('reported_reason_other');
        }
        else
        {
            $reported_reason_other = "";
        }

        /*$report_data = $this->db->select('*')->get_where('user_post_report', array('reported_post_id' => $reported_post_id,'reported_user_id' => $login_user_id))->row();
        if(isset($report_data) && !empty($report_data))
        {
            $ret_arr = array("success"=>1);
        }
        else
        {*/
        if($reported_post_id != "")
        {
            $curr_date = date('Y-m-d H:i:s', time());

            $data = array(
                'reported_post_id'      => $reported_post_id,
                'reported_user_id'      => $login_user_id,
                'reported_reason'       => $reported_reason,
                'reported_reason_other' => $reported_reason_other,
                'status'                => '1',
                'created_date'          => $curr_date,
                'modify_date'           => $curr_date,
            );
            $report_id = $this->common->insert_data_getid($data, 'user_post_report');
            if($report_id)
            {
                $ret_arr = array("success"=>1);
            }
            else
            {
                $ret_arr = array("success"=>0);   
            }
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        //}
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_progress()
    {
        $userid = $this->session->userdata('aileenuser');
        $profile_progress = $this->progressbar($userid);
        $ret_arr = array("success"=>1,"profile_progress"=>$profile_progress);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_all_counter()
    {
        if (!empty($_GET["user_slug"]) && $_GET["user_slug"] != 'undefined')
        {
            $user_slug = $_GET["user_slug"];
            $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        }
        else
        {            
            $userid = $this->session->userdata('aileenuser');
        }
        $all_counter = $this->common->get_all_counter($userid);
        $progress_arr = $this->progressbar($userid);
        $user_detail_counter = $progress_arr['user_process'];
        $all_counter['detail_counter'] = round($user_detail_counter);
        return $this->output->set_content_type('application/json')->set_output(json_encode($all_counter));
    }
}