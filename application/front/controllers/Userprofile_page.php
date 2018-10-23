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
        $this->load->library('upload');
        include ('main_profile_link.php');
    }

    public function profile() {
        $this->load->view('userprofile/profiles', $this->data);
    }

    public function dashboard() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->load->view('userprofile/dashboard', $this->data);
    }

    public function details() {

        $this->load->view('userprofile/details', $this->data);
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

    public function contact_request() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");

        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);

        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['title'] = "Contact Request | Aileensoul";
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
        $ret_arr['detail_data'] = $detailsData;
        $ret_arr['user_bio'] = $user_bio;
        $ret_arr['skills_data'] = $skills_data;
        $ret_arr['skills_data_edit'] = $skills_data;
        echo json_encode($ret_arr);
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
            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $id))->row();
            $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            if($unsubscribeData->is_subscribe == 1)
            {
                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
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

            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $id))->row();
            $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            if($unsubscribeData->is_subscribe == 1)
            {
                $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
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
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'follow_from' => $userid,
                'follow_to' => $id,
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
                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="'.MAIL_TD_1.'">
                                                <img src="' . USER_THUMB_UPLOAD_URL . $login_userdata['user_image'] . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
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
                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $id))->row();
                        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                        if($unsubscribeData->is_subscribe == 1)
                        {
                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
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
            $data = array('status' => 0,'modify_date' => date("Y-m-d h:i:s"));
            $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            //   $response = $status;

            $html = '<a class="btn3 follow"  ng-click="follow_user(' . $id . ')">Follow</a>';
        } else {
            $data = array(
                'status' => 0,
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

    public function user_image_insert1() {
        $userid = $this->session->userdata('aileenuser');
        $userslug = $this->session->userdata('aileenuser_slug');
        $userdata = $this->user_model->getUserDataByslug($userslug, $data = 'ui.user_image,u.user_slug,u.user_id');

        $user_prev_image = $userdata['user_image'];

        if ($user_prev_image != '') {
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
        }


        $data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('user_main_upload_path');
        $imageName = time() . '.png';
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

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('user_thumb_upload_path');
        $user_thumb_width = $this->config->item('user_thumb_width');
        $user_thumb_height = $this->config->item('user_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

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

        if ($user_reg_prev_image != '') {
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
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('user_bg_main_upload_path');
        $imageName = time() . '.png';
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

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        if (IMAGEPATHFROM == 's3bucket') {
            $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
        }

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
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

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
        $this->data['title'] = "Question | Aileensoul";
        $this->load->view('userprofile/question_details', $this->data);
    }

    public function question_data() {
        $userid = $this->session->userdata('aileenuser');

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
        
        $user_dob = $this->input->post('user_dob');
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
        $user_fav_book = $this->input->post('user_fav_book');
        $user_fav_sport = $this->input->post('user_fav_sport');

        $data_dob = array("user_dob"=>$user_dob);
        $udpate_data_dob = $this->common->update_data($data_dob, 'user', 'user_id', $userid);

        $data = array(
            'user_hobbies' => $user_hobby_txt,
            'user_fav_quote_headline' => $user_fav_quote_headline,
            'user_fav_artist' => $user_fav_artist,
            'user_fav_book' => $user_fav_book,
            'user_fav_sport' => $user_fav_sport,            
        );
        $udpate_data = $this->common->update_data($data, 'user_info', 'user_id', $userid);
        if($udpate_data_dob && $udpate_data)
        {
            $about_user_data = $this->userprofile_model->get_about_user($userid);
            $ret_arr = array("success"=>1,"about_user_data"=>$about_user_data,"user_dob"=>$user_dob);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_research_user()
    {
        // print_r($_POST);
        // print_r($_FILES);
        // exit();
        
        $research_title = $this->input->post('research_title');
        $research_desc = $this->input->post('research_desc');
        $research_url = $this->input->post('research_url');
        $research_published_date = $this->input->post('research_year').'-'.$this->input->post('research_month').'-'.$this->input->post('research_day');
        $fileName = "";
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $user_research_upload_path = $this->config->item('user_research_upload_path');
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
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('file'))            {
                $main_image = $user_research_upload_path . $fileName;
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
            $user_research = $this->userprofile_model->set_user_research($user_id,$research_title,$research_desc,$research_url,$research_published_date,$fileName);
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
            $ret_arr = array("success"=>1,"user_social_links_data"=>$user_social_links_data,"user_personal_links_data"=>$user_personal_links_data);   
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_idol()
    {
        // print_r($_POST);
        // print_r($_FILES);
        // exit();
        
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
            $data = array(
                'user_id' => $userid,
                'user_links_name' => $user_idol_name,
                'user_links_pic' => $fileName,
                'status' => '1',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
            );
            $insert_id = $this->common->insert_data($data, 'user_idol');
            $user_idol = $this->userprofile_model->get_user_idols($userid);
            $ret_arr = array("success"=>1,"user_idol"=>$user_idol);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_publication()
    {
        $pub_title = $this->input->post('pub_title');
        $pub_author = $this->input->post('pub_author');
        $pub_url = $this->input->post('pub_url');
        $pub_publisher = $this->input->post('pub_publisher');
        $pub_desc = $this->input->post('pub_desc');
        $publication_date = $this->input->post('pub_year_txt').'-'.$this->input->post('pub_month_txt').'-'.$this->input->post('pub_day_txt');
        $fileName = "";
        if(isset($_FILES['pub_file']['name']) && $_FILES['pub_file']['name'] != "")
        {
            $user_publication_upload_path = $this->config->item('user_publication_upload_path');
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
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('pub_file'))            {
                $main_image = $user_publication_upload_path . $fileName;
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
            $user_publication = $this->userprofile_model->set_user_publication($user_id,$pub_title,$pub_author,$pub_url,$pub_publisher,$pub_desc,$publication_date,$fileName);
            $user_publication = $this->userprofile_model->get_user_publication($user_id);
            $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }
}
