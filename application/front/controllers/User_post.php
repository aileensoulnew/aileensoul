<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_post extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('user_agent');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('user_post_model');
        $this->load->model('userprofile_model');
        $this->load->model('data_model');
        $this->load->library('S3');
        $this->load->library('inbackground');

        $this->data['no_user_post_html'] = '<div class="user_no_post_avl"><h3>Feed</h3><div class="user-img-nn"><div class="user_no_post_img"><img src=' . base_url('assets/img/bui-no.png?ver=' . time()) . ' alt="bui-no.png"></div><div class="art_no_post_text">No Feed Available.</div></div></div>';
        $this->data['no_user_contact_html'] = '<div class="art-img-nn"><div class="art_no_post_img"><img src="' . base_url('assets/img/No_Contact_Request.png?ver=' . time()) . '"></div><div class="art_no_post_text">No Contacts Available.</div></div>';
        // $this->data['header_all_profile'] = '<div class="dropdown-title"> Profiles <a href="profile.html" title="All" class="pull-right">All</a> </div><div id="abody" class="as"> <ul> <li> <div class="all-down"> <a href="'. base_url("artist/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i5.jpg') . '"> </div><div class="text-all"> Artistic Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("business-profile/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i4.jpg') . '"> </div><div class="text-all"> Business Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("job/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i1.jpg') . '"> </div><div class="text-all"> Job Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("recruiter/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i2.jpg') . '"> </div><div class="text-all"> Recruiter Profile </div></a> </div></li><li> <div class="all-down"> <a href="'. base_url("freelance/").'"> <div class="all-img"> <img src="' . base_url('assets/n-images/i3.jpg') . '"> </div><div class="text-all"> Freelance Profile </div></a> </div></li></ul> </div>';
        include ('main_profile_link.php');
    }

    public function index() {

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['is_userPostCount'] = $this->user_post_model->userPostCount($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);        
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Opportunities".TITLEPOSTFIX;
        $this->load->view('user_post/index', $this->data);
    }

    public function getContactSuggetion() {

        $userid = $this->session->userdata('aileenuser');
        $is_basicInfo = $this->data['is_basicInfo'] = $this->user_model->is_userBasicInfo($userid);
        if ($is_basicInfo == 0) {
            $detailsData = "student";
        } else {
            $detailsData = "profession";
        }
        $user_data = $this->user_post_model->getContactSuggetion($userid, $detailsData);
        echo json_encode($user_data);
    }

    public function getContactAllSuggetion() {
        // $offset = $this->input->post();
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        else
        {
            $page = 1;
        }
        $limit = 39;//40;
        $userid = $this->session->userdata('aileenuser');
        $user_data = $this->user_post_model->getContactAllSuggetion($userid,$page,$limit);
        echo json_encode($user_data);
    }

    public function addToContact() {
        $userid = $this->session->userdata('aileenuser');
        $to_user_id = $_POST['user_id'];
        $return_data = array();
        $checkContactData = $this->user_post_model->checkContact($userid, $to_user_id);
        if ($checkContactData['total'] == '0') {
            $data = array();
            $data['from_id'] = $userid;
            $data['to_id'] = $to_user_id;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['status'] = 'pending';
            $data['not_read'] = '2';
            $user_contact = $this->common->insert_data_getid($data, 'user_contact');
            if ($user_contact) {
                //Send Mail Start
                $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_user_id))->row()->email;
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

                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_user_id))->row();

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
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } else {
                $return_data['status'] = '';
                $return_data['message'] = '0';
            }
        } else {
            if ($checkContactData['status'] == 'reject' || $checkContactData['status'] == 'cancel') {
                $data = array();
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = 'pending';
                $data['not_read'] = '2';
                $user_contact = $this->common->update_data($data, 'user_contact', 'id', $checkContactData['id']);
                //Send Mail Start
                $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_user_id))->row()->email;
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
                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' sent you a contact request Aileensoul.';
                
                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_user_id))->row();

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
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } elseif ($checkContactData['status'] == 'block') {
                $return_data['status'] = 'block';
                $return_data['message'] = '0';
            } elseif ($checkContactData['status'] == 'pending') {
                $return_data['status'] = 'pending';
                $return_data['message'] = '1';
            } else {
                $return_data['status'] = '';
                $return_data['message'] = '0';
            }
        }
        echo json_encode($return_data);
    }

    public function get_jobtitle() {
        $job_title = $this->user_post_model->get_jobtitle();
        echo json_encode($job_title);
    }

    public function get_location() {
        $location = $this->user_post_model->get_location();
        echo json_encode($location);
    }

    public function get_category() {
        $category = $this->user_post_model->get_category();
        echo json_encode($category);
    }

    public function postCommentInsert() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $comment = $_POST['comment'];
        // $mention_data = $_POST['mention_data'] != '' ? json_decode($_POST['mention_data']) : '';        
        $dom = new DomDocument();
        $dom->loadHTML($comment);        
        $mention_tags = array();
        foreach ($dom->getElementsByTagName('a') as $item) {            
            if($item->nodeValue != '')
            {
                // echo $item->getAttribute('mention');
                if($item->getAttribute('mention') != '')
                {
                    $mention_tags[] = base64_decode($item->getAttribute('mention'));
                }
            }
        }        
        $mention_tags = array_unique($mention_tags);
        // exit();

        $data = array();
        $data['user_id'] = $userid;
        $data['post_id'] = $post_id;
        $data['comment'] = $comment;
        $data['created_date'] = date('Y-m-d H:i:s', time());
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $data['is_delete'] = '0';
        $postComentId = $this->common->insert_data_getid($data, 'user_post_comment');
        $return_data = array();
        if ($postComentId) {
            
            $post_data = $this->db->select('*')->get_where('user_post', array('id' => $post_id))->row();
            $comment_count_data = $this->db->select('*')->get_where('user_post_comment', array('post_id' => $post_id,'user_id' => $userid,'is_delete' => '0'))->result();

            $is_user_monetize = $this->common->is_user_monetize();            

            if($is_user_monetize > 0 && count($comment_count_data) == 0 && $post_data->post_for == 'question')
            {
                $inser_point = array(
                    "user_id"       =>  $userid,
                    "post_id"       =>  $post_id,
                    "points"        =>  5,
                    "points_for"    =>  4,
                    "description"   =>  $comment,
                    "status"        =>  '0',
                    "created_date"  =>  date('Y-m-d H:i:s', time()),
                    "modify_date"   =>  date('Y-m-d H:i:s', time()),
                );
                $this->common->insert_data_getid($inser_point, 'user_point_mapper');
            }

            $return_data['message'] = '1';
            $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id,$userid);
            $return_data['comment_data'][0]['is_userlikePostComment'] = '0';
            $return_data['comment_data'][0]['postCommentLikeCount'] = '';
            $return_data['comment_count'] = $this->user_post_model->postCommentCount($post_id);

            $to_id = $this->user_post_model->getPostUserId($post_id);
            if($userid != $to_id)
            {
                $contition_array = array('not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                $likenotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($likenotification[0]['not_read'] == 2) {                
                }
                elseif($likenotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '6',
                        'not_from_id' => $userid,
                        'not_product_id'=>$post_id,
                        'not_to_id' => $to_id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '2',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;
                        $login_userdata = $this->user_model->getUserData($userid);
                        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                        // print_r($postDetailData);exit;
                        if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                        }
                        else
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }

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
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> commented on your post.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' commented on your post in Aileensoul.';
                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

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

            if(isset($mention_tags) && !empty($mention_tags))
            {
                foreach ($mention_tags as $k => $user_slug) {
                    $userdata = $this->user_model->getUserDataByslug($user_slug, "u.user_id ,u.first_name ,u.last_name ,u.user_slug ,u.user_verify ,u.user_gender ,u.encrypt_key ,u.is_subscribe ,ui.user_image ,ul.email");
                    if($userdata['user_id'] != $userid)
                    {
                        $contition_array = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $userdata['user_id']);//Mention in Comment

                        $comment_notification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                        if ($comment_notification[0]['not_read'] == 2) {                
                        }
                        elseif($comment_notification[0]['not_read'] == 1)
                        {
                            $data_cmt = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                            $where = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $userdata['user_id']);                            
                            $this->db->where($where);
                            $updatdata = $this->db->update('notification', $data_cmt);
                        }
                        else
                        {
                            $data_cmt = array(
                                'not_from' => '7',
                                'not_type' => '6',
                                'not_img' => '4',
                                'not_from_id' => $userid,
                                'not_product_id'=>$postComentId,
                                'not_to_id' => $userdata['user_id'],
                                'not_read' => '2',                    
                                'not_created_date' => date('Y-m-d H:i:s'),
                                'not_active' => '1'
                            );
                            $insert_id = $this->common->insert_data_getid($data_cmt, 'notification');
                            if($_SERVER['HTTP_HOST'] != "aileensoul.localhost")
                            {
                                $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $userdata['user_id']))->row()->email;

                                $login_userdata = $this->user_model->getUserData($userid);
                                $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                                if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                                }
                                else
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                }

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
                                                    <td style="padding:5px;">';
                                
                                $email_html .= '<p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> mentioned you in a comment.</p>';   
                                
                                $email_html .= '<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                        </td>
                                        <td style="'.MAIL_TD_3.'">
                                            <p><a class="btn" href="'.$url.'">view</a></p>
                                        </td>
                                    </tr>
                                    </table>';

                                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' mentioned you in a comment in Aileensoul.';
                                $unsubscribe = base_url()."unsubscribe/".md5($userdata['encrypt_key'])."/".md5($userdata['user_slug'])."/".md5($userdata['user_id']);

                                if($userdata['is_subscribe'] == 1)
                                {
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
            }
        } else {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    public function deletePostComment() {
        $userid = $this->session->userdata('aileenuser');
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];

        $update_data = array();
        $update_data['modify_date'] = date('Y-m-d H:i:s', time());
        $update_data['is_delete'] = '1';
        $update_post = $this->common->update_data($update_data, 'user_post_comment', 'id', $comment_id);
        if ($update_post) {
            $return_data = array();
            $return_data['message'] = 1;
            $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id,$userid);
            $return_data['comment_count'] = $this->user_post_model->postCommentCount($post_id);
        } else {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    public function likePostComment() {
        $userid = $this->session->userdata('aileenuser');
        $comment_id = $_POST['comment_id'];
        $post_id = $_POST['post_id'];

        $userlikePostCommentData = $this->user_post_model->userlikePostCommentData($userid, $comment_id);

        $return_array = array();
        if ($userlikePostCommentData['id'] != '') {
            if ($userlikePostCommentData['is_like'] == '1') {
                $data = array();
                $data['is_like'] = '0';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_comment_like', 'id', $userlikePostCommentData['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '0';
                    $return_array['is_oldLike'] = '1';
                    $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
                }
            } else {
                $data = array();
                $data['is_like'] = '1';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_comment_like', 'id', $userlikePostCommentData['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '1';
                    $return_array['is_oldLike'] = '0';
                    $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
                }
            }
        } else {
            $data = array();
            $data['user_id'] = $userid;
            $data['comment_id'] = $comment_id;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['is_like'] = '1';
            $like_post_comment = $this->common->insert_data_getid($data, 'user_post_comment_like');
            if ($like_post_comment) {
                $return_array['message'] = '1';
                $return_array['is_newLike'] = '1';
                $return_array['is_oldLike'] = '0';
                $return_array['commentLikeCount'] = $this->user_post_model->postCommentLikeCount($comment_id) == '0' ? '' : $this->user_post_model->postCommentLikeCount($comment_id);
            } else {
                $return_array['message'] = '0';
                $return_array['is_newLike'] = '0';
                $return_array['is_oldLike'] = '0';
            }
        }
        if($return_array['is_newLike'] == 1)
        {
            $to_id = $this->user_post_model->postCommentDetail($comment_id)['commented_user_id'];
            if($userid != $to_id)
            {
                $contition_array = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$comment_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                $likenotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($likenotification[0]['not_read'] == 2) {                
                }
                elseif($likenotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$comment_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_product_id'=>$comment_id,
                        'not_to_id' => $to_id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '3',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;
                        $login_userdata = $this->user_model->getUserData($userid);
                        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                        if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                        }
                        else
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }

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
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> liked your comment.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' liked your comment in Aileensoul.';
                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

                        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                        if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
                        {
                            //$send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
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
        echo json_encode($return_array);
    }

    public function postCommentUpdate() {
        $comment_id = $_POST['comment_id'];
        $comment = $_POST['comment'];

        $data = array();
        $data['comment'] = $comment;
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $updatedata = $this->common->update_data($data, 'user_post_comment', 'id', $comment_id);
        if ($updatedata) {
            $return_array = array();
            $return_array['message'] = 1;
            echo json_encode($return_array);
        }
    }

    public function viewLastComment() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $return_data = array();
        $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id,$userid);
        $return_data['post_comment_count'] = $this->user_post_model->postCommentCount($post_id);
        echo json_encode($return_data);
    }

    public function viewAllComment() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $return_data = array();
        $return_data['all_comment_data'] = $this->user_post_model->viewAllComment($post_id,$userid);
        $return_data['post_comment_count'] = $this->user_post_model->postCommentCount($post_id);
        echo json_encode($return_data);
    }

    public function getUserPost() {
        $userid = $this->session->userdata('aileenuser');
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        // $post_data = $this->user_post_model->userPost($userid, $page);//Old Logic
        $post_data = $this->user_post_model->user_post_new($userid, $page);
        if($page == 2 || $page == 4 || $page == 6 || $page == 8 || $page == 10)
        {
            if($page == 2)
            {
                $page = 1;   
            }
            elseif($page == 4)
            {
                $page = 2;
            }
            elseif($page == 6)
            {
                $page = 3;
            }
            elseif($page == 8)
            {
                $page = 4;
            }
            elseif($page == 10)
            {
                $page = 5;
            }
            $contact_data = $this->user_post_model->get_contact_sugetion_in_post($userid, $page);
            echo json_encode(array('all_post_data'=>$post_data,'contact_suggetion_'.$page=>$contact_data));
        }
        else
        {
            echo json_encode(array('all_post_data'=>$post_data));   
        }
        // echo json_encode($post_data);
    }

    public function getUserDashboardPost() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_data = $this->user_post_model->userDashboardPost($userid, $page);
        echo json_encode($post_data);
    }

    public function getUserDashboardImage() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $resdata['userDashboardImage'] = $this->user_post_model->userDashboardImage($userid);
        $resdata['userDashboardImageAll'] = $this->user_post_model->userDashboardImageAll($userid);
        echo json_encode($resdata);
    }

    public function getUserDashboardVideo() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $resdata['userDashboardVideo'] = $this->user_post_model->userDashboardVideo($userid);
        $resdata['userDashboardVideoAll'] = $this->user_post_model->userDashboardVideo($userid);
        echo json_encode($resdata);
    }

    public function getUserDashboardAudio() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $resdata['userDashboardAudio'] = $this->user_post_model->userDashboardAudio($userid);
        $resdata['userDashboardAudioAll'] = $this->user_post_model->userDashboardAudioAll($userid);
        echo json_encode($resdata);
    }

    public function getUserDashboardPdf() {
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_pdf_data = $this->user_post_model->userDashboardPdf($userid);
        echo json_encode($post_pdf_data);
    }

    public function getUserDashboardArticle() {
        $user_slug = $_GET["user_slug"];
        $login_userid = $this->session->userdata('aileenuser');
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_pdf_data = $this->user_post_model->getUserDashboardArticle($userid,$login_userid);
        echo json_encode($post_pdf_data);
    }

    public function deletePost() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];

        $getPostUserId = $this->user_post_model->getPostUserId($post_id);

        $data = array();
        if ($userid == $getPostUserId) {
            $data['is_delete'] = '1';
            $updatedata = $this->common->update_data($data, 'user_post', 'id', $post_id);
        } else {
            $data['post_id'] = $post_id;
            $data['user_id'] = $userid;
            $data['delete_date'] = date('Y-m-d H:i:s', time());
            $deleteId = $this->common->insert_data_getid($data, 'user_post_delete');
        }

        if ($updatedata || $deleteId) {
            $return_array = array();
            $return_array['message'] = 1;
            echo json_encode($return_array);
        }
    }

    public function likePost() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];

        $is_likepost = $this->user_post_model->is_likepost($userid, $post_id);

        if ($is_likepost['id'] != '') {
            if ($is_likepost['is_like'] == '1') {
                $data = array();
                $data['is_like'] = '0';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '0';
                    $return_array['is_oldLike'] = '1';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $postLikeData = $this->user_post_model->postLikeData($post_id);
                    if($userid == $postLikeData['user_id'])
                    {
                        $postLikeUsername = "You";
                    }
                    else
                    {
                        $postLikeUsername = $postLikeData['username'];
                    }
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeUsername;
                    }
                    $return_array['user_like_list'] = $this->user_post_model->get_user_like_list($post_id);
                }
            } else {
                $data = array();
                $data['is_like'] = '1';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '1';
                    $return_array['is_oldLike'] = '0';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $postLikeData = $this->user_post_model->postLikeData($post_id);
                    if($userid == $postLikeData['user_id'])
                    {
                        $postLikeUsername = "You";
                    }
                    else
                    {
                        $postLikeUsername = $postLikeData['username'];
                    }
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeUsername;
                    }
                    $return_array['user_like_list'] = $this->user_post_model->get_user_like_list($post_id);
                }
            }
        } else {
            $insert_data = array();
            $insert_data['user_id'] = $userid;
            $insert_data['post_id'] = $post_id;
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
            $insert_data['is_like'] = '1';
            $user_post_like_id = $this->common->insert_data_getid($insert_data, 'user_post_like');
            $return_array = array();
            if ($user_post_like_id != '') {
                $return_array['message'] = '1';
                $return_array['is_newLike'] = '1';
                $return_array['is_oldLike'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $postLikeData = $this->user_post_model->postLikeData($post_id);
                if($userid == $postLikeData['user_id'])
                {
                    $postLikeUsername = "You";
                }
                else
                {
                    $postLikeUsername = $postLikeData['username'];
                }
                if ($return_array['likePost_count'] > 1) {
                    $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                } elseif ($return_array['likePost_count'] == 1) {
                    $return_array['post_like_data'] = $postLikeUsername;
                }
            } else {
                $return_array['message'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $return_array['post_like_data'] = '';
            }
            $return_array['user_like_list'] = $this->user_post_model->get_user_like_list($post_id);
        }

        if($return_array['is_newLike'] == 1)
        {
            $to_id = $this->user_post_model->getPostUserId($post_id);
            if($userid != $to_id)
            {
                $contition_array = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                $likenotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($likenotification[0]['not_read'] == 2) {                
                }
                elseif($likenotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_product_id'=>$post_id,
                        'not_to_id' => $to_id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '2',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;
                        $login_userdata = $this->user_model->getUserData($userid);
                        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                        if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                        }
                        else
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }

                        $email_html = '';
                        
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
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="'.MAIL_TD_1.'">
                                                <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                            </td>
                                            <td style="padding:5px;">
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> liked your post.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' liked your post in Aileensoul.';

                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

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

                            //$send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
                        }
                    }
                }
            }
        }
        echo json_encode($return_array);
    }

    public function likePost_count($post_id = '') {
        $userid = $this->session->userdata('aileenuser');

        $likepost_count = $this->user_post_model->likepost_count($post_id);
        return $likepost_count;
    }

    function get_hashtag_array($string) {
        /* Match hashtags */
        preg_match_all('/#(\w+)/', $string, $matches);
        /* Add all matches to array */
        foreach ($matches[1] as $match) {
            $keywords[] = $match;
        }
        return (array) $keywords;
    }

    public function post_opportunity() {
       
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');
        $is_user_monetize = $this->common->is_user_monetize();

        $opptitle = (isset($_POST['opptitle'])  && $_POST['opptitle'] != "undefined" && $_POST['opptitle'] != "" ? $_POST['opptitle'] : "");
        $sptitle = (isset($_POST['sptitle'])  && $_POST['sptitle'] != "undefined" && $_POST['sptitle'] != "" ? $_POST['sptitle'] : "");
        $field = (isset($_POST['field'])  && $_POST['field'] != "undefined" && $_POST['field'] != "" ? $_POST['field'] : "");
        $job_title = (isset($_POST['job_title']) && $_POST['job_title'] != "undefined" && $_POST['job_title'] != "" ? json_decode($_POST['job_title'], TRUE) : "");
        $location = (isset($_POST['location']) && $_POST['location'] != "undefined" && $_POST['location'] != "" ? json_decode($_POST['location'], TRUE) : "");
        $post_for = $_POST['post_for'];
        $question = (isset($_POST['question']) && $_POST['question'] != "" ? $_POST['question'] : "");
        $description = (isset($_POST['description']) && $_POST['description'] != 'undefined' && $_POST['description'] != '' ? $_POST['description'] : '');
        $hashtag = (isset($_POST['hashtag']) && $_POST['hashtag'] != 'undefined' && $_POST['hashtag'] != '' ? $_POST['hashtag'] : '');
        $other_field = (isset($_POST['other_field']) && $_POST['other_field'] != 'undefined' && $_POST['other_field'] != "" ? $_POST['other_field'] : "");
        $weblink = (isset($_POST['weblink']) && $_POST['weblink'] != 'undefined' && $_POST['weblink'] != '' ? $_POST['weblink'] : '');
        $is_anonymously = (isset($_POST['is_anonymously']) && $_POST['is_anonymously'] != 'undefined' && $_POST['is_anonymously'] != '' ? '1' : '0');
        $category = (isset($_POST['category']) && $_POST['category'] != "undefined" && $_POST['category'] != "" ? json_decode($_POST['category'], TRUE) : "");
        $company_name = (isset($_POST['company_name']) && $_POST['company_name'] != "undefined" && $_POST['company_name'] != "" ? $_POST['company_name'] : "");


        $error = '';
        if ($post_for == 'opportunity') {
            if ($field <= -1) {
                $error = 1;
            } elseif ($job_title[0]['name'] == '') {
                $error = 1;
            } elseif ($location[0]['city_name'] == '') {
                $error = 1;
            }
        }

        if ($post_for == 'question') {
            $ask_question = $question;
            $ask_description = $description == 'undefined' ? '' : $description;
            $ask_field = $field;
            $ask_category = $category;
            $ask_weblink = $weblink == 'undefined' ? '' : $weblink;

            if ($ask_question == '') {
                $error = 1;
            } elseif ($ask_field == '') {
                $error = 1;
            }
        }

        if ($error != '1') {
            if ($post_for == 'opportunity') {
                $job_title_id = "";
                foreach ($job_title as $title) {
                    $designation = $this->data_model->findJobTitle($title['name']);
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
                    $job_title_id .= $jobTitleId . ',';
                }
                $job_title_id = trim($job_title_id, ',');
                $city_id = "";
                foreach ($location as $loc) {
                    $city = $this->data_model->findCityList($loc['city_name']);
                    if ($city['city_id'] != '') {
                        $cityId = $city['city_id'];
                    } else {
                        $data = array();
                        $city_slug = $this->common->set_city_slug(trim($loc['city_name']), 'slug', 'cities');
                        $data['city_name'] = $loc['city_name'];
                        $data['state_id'] = '0';
                        $data['status'] = '2';
                        $data['group_id'] = '0';
                        $data['city_image'] =  $city_slug.'.png';
                        $data['slug'] = $city_slug;
                        $cityId = $this->common->insert_data_getid($data, 'cities');
                    }
                    $city_id .= $cityId . ',';
                }
                $city_id = trim($city_id, ',');

                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }
            elseif ($post_for == 'simple') {
                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }elseif ($post_for == 'question') {
                foreach ($ask_category as $ask) {
                    $asked = $this->data_model->findCategory($ask['name']);
                    if ($asked['id'] != '') {
                        $categoryId .= $asked['id'] . ',';
                    } else {
                        $data = array();
                        $data['name'] = $ask['name'];
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['user_id'] = $userid;
                        $data['status'] = 'draft';
                        $categorysId = $this->common->insert_data_getid($data, 'tags');
                        $categoryId .= $categorysId . ',';
                    }
                }
                $categoryId = trim($categoryId, ',');

                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }
            $this->config->item('user_post_main_upload_path');
            $config = array(
                'image_library' => 'gd',
                'upload_path' => $this->config->item('user_post_main_upload_path'),
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite' => true,
                'remove_spaces' => true);

            $images = array();
            $this->load->library('upload');

            $files = $_FILES;
            $count = count($_FILES);//$_FILES['postfiles']['name']);
            $title = time();

            $insert_data = array();
            $insert_data['user_id'] = $userid;
            if ($post_for == 'opportunity') {
                $insert_data['post_for'] = 'opportunity';
            } elseif ($post_for == 'simple') {
                $insert_data['post_for'] = 'simple';
            } elseif ($post_for == 'question') {
                $insert_data['post_for'] = 'question';
            }
            $insert_data['post_id'] = '';
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['status'] = 'publish';
            $insert_data['is_delete'] = '0';

            $user_post_id = $this->common->insert_data_getid($insert_data, 'user_post');

            $update_post_data = array();
            if ($post_for == 'opportunity') {
                $insert_data = array();
                $opptitle = substr($opptitle, 0,100);
                $oppslug = $this->common->set_slug($opptitle, 'oppslug', 'user_opportunity');
                $insert_data['post_id'] = $user_post_id;
                $insert_data['opptitle'] = $opptitle;
                $insert_data['oppslug'] = $oppslug;
                $insert_data['opportunity_for'] = $job_title_id;
                $insert_data['location'] = $city_id;
                $insert_data['opportunity'] = $description == 'undefined' ? "" : trim($description);
                $insert_data['field'] = $field;
                $insert_data['company_name'] = $company_name;
                $insert_data['other_field'] = $other_field;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

                $inserted_id = $user_opportunity_id = $this->common->insert_data_getid($insert_data, 'user_opportunity');
                if($is_user_monetize > 0)
                {

                    $inser_point = array(
                        "user_id"       =>  $userid,
                        "post_id"       =>  $user_post_id,
                        "points"        =>  50,
                        "points_for"    =>  1,
                        "description"   =>  $description,
                        "status"        =>  '0',
                        "created_date"  =>  date('Y-m-d H:i:s', time()),
                        "modify_date"   =>  date('Y-m-d H:i:s', time()),
                    );
                    $this->common->insert_data_getid($inser_point, 'user_point_mapper');
                    $update_post_data['is_monetize'] = '1';
                }                

            } elseif ($post_for == 'simple') {
                $insert_data = array();
                $sptitle = substr($sptitle, 0,100);
                $sim_title = $this->common->set_slug($sptitle, 'simslug', 'user_simple_post');
                $insert_data['post_id'] = $user_post_id;
                $insert_data['simslug'] = $sim_title;
                $insert_data['sim_title'] = $sptitle;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
                $insert_data['description'] = $description == 'undefined' ? "" : trim($description);
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_simple_post');

                if($is_user_monetize > 0){
                    $update_post_data['is_monetize'] = '1';
                }

            } elseif ($post_for == 'question') {
                $insert_data = array();
                $insert_data['post_id'] = $user_post_id;
                $insert_data['question'] = $ask_question;
                $insert_data['description'] = $ask_description;
                $insert_data['category'] = $categoryId;
                $insert_data['field'] = $ask_field;
                $insert_data['others_field'] = $other_field;
                $insert_data['link'] = $ask_weblink;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
                $insert_data['is_anonymously'] = $is_anonymously;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_ask_question');
                if($is_user_monetize > 0){

                    $update_post_data['is_monetize'] = '1';

                    $inser_point = array(
                        "user_id"       =>  $userid,
                        "post_id"       =>  $user_post_id,
                        "points"        =>  5,
                        "points_for"    =>  5,
                        "description"   =>  $ask_description,
                        "status"        =>  '0',
                        "created_date"  =>  date('Y-m-d H:i:s', time()),
                        "modify_date"   =>  date('Y-m-d H:i:s', time()),
                    );
                    $this->common->insert_data_getid($inser_point, 'user_point_mapper');
                }

            }
            
            $update_post_data['post_id'] = $inserted_id;
            $update_post = $this->common->update_data($update_post_data, 'user_post', 'id', $user_post_id);

            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

            //if ($_FILES['postfiles']['name'][0] != '') {
            if ($count >= 0) {
                $i = 0;
                //for ($i = 0; $i < $count; $i++) {
                $file_type = "";
                foreach($_FILES as $k=>$v) {

                    // $_FILES['postfiles']['name'] = $files['postfiles']['name'][$i];
                    // $_FILES['postfiles']['type'] = $files['postfiles']['type'][$i];
                    // $_FILES['postfiles']['tmp_name'] = $files['postfiles']['tmp_name'][$i];
                    // $_FILES['postfiles']['error'] = $files['postfiles']['error'][$i];
                    // $_FILES['postfiles']['size'] = $files['postfiles']['size'][$i];

                    $_FILES['postfiles']['name'] = $_FILES[$k]['name'];
                    $_FILES['postfiles']['type'] = $_FILES[$k]['type'];
                    $_FILES['postfiles']['tmp_name'] = $_FILES[$k]['tmp_name'];
                    $_FILES['postfiles']['error'] = $_FILES[$k]['error'];
                    $_FILES['postfiles']['size'] = $_FILES[$k]['size'];

                    $file_type = $_FILES[$k]['type'];
                    $file_type = explode('/', $file_type);
                    $file_type = $file_type[0];
                    if ($file_type == 'image') {
                        $file_type = 'image';
                    } elseif ($file_type == 'audio') {
                        $file_type = 'audio';
                    } elseif ($file_type == 'video') {
                        $file_type = 'video';
                    } else {
                        $file_type = 'pdf';
                    }

                    if ($_FILES[$k]['error'] == 0) {
                        $store = $_FILES[$k]['name'];
                        $store_ext = explode('.', $store);
                        $store_ext = end($store_ext);
                        $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
                        $images[] = $fileName;
                        $config['file_name'] = $fileName;
                        $this->upload->initialize($config);
                        $imgdata = $this->upload->data();

                        if ($this->upload->do_upload('postfiles')) {
                            $upload_data = $response['result'][] = $this->upload->data();

                            if ($file_type == 'video') {
                                $uploaded_url = base_url() . $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . $upload_data['file_ext'] . "");
                                exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . ".png");
                                //$fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                                $fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "" . $upload_data['file_ext'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    //unlink($this->config->item('user_post_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
                                    $abc = $s3->putObjectFile($fileName, bucket, $fileName, S3::ACL_PUBLIC_READ);
                                }
                            }                                

                            $main_image_size = $_FILES[$k]['size'];

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

                            $user_post_main[$i]['image_library'] = 'gd2';
                            $user_post_main[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['new_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['quality'] = $quality;
                            $instanse10 = "image10_$i";
                            $this->load->library('image_lib', $user_post_main[$i], $instanse10);
                            $this->$instanse10->watermark();

                            /* RESIZE */

                            //Main Image
                            $main_image = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                            }

                            $post_poster = $response['result'][$i]['file_name'];
                            $post_poster1 = explode('.', $post_poster);
                            $post_poster2 = end($post_poster1);
                            $post_poster = str_replace($post_poster2, 'png', $post_poster);

                            $main_image1 = $this->config->item('user_post_main_upload_path') . $post_poster;
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);
                            }
                            $image_width = $response['result'][$i]['image_width'];
                            $image_height = $response['result'][$i]['image_height'];
                            //Main Image
                            if ($file_type == 'image') {
                            //Thumb Image
                            $thumb_image_width = $this->config->item('user_post_thumb_width');
                            $thumb_image_height = $this->config->item('user_post_thumb_height');

                            if ($image_width > $image_height) {
                                $n_h = $thumb_image_height;
                                $image_ratio = $image_height / $n_h;
                                $n_w = round($image_width / $image_ratio);
                            } else if ($image_width < $image_height) {
                                $n_w = $thumb_image_width;
                                $image_ratio = $image_width / $n_w;
                                $n_h = round($image_height / $image_ratio);
                            } else {
                                $n_w = $thumb_image_width;
                                $n_h = $thumb_image_height;
                            }

                            $user_post_thumb[$i]['image_library'] = 'gd2';
                            $user_post_thumb[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_thumb[$i]['new_image'] = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_thumb[$i]['create_thumb'] = TRUE;
                            $user_post_thumb[$i]['maintain_ratio'] = FALSE;
                            $user_post_thumb[$i]['thumb_marker'] = '';
                            $user_post_thumb[$i]['width'] = $n_w;
                            $user_post_thumb[$i]['height'] = $n_h;
                            $user_post_thumb[$i]['quality'] = "100%";
                            $user_post_thumb[$i]['x_axis'] = '0';
                            $user_post_thumb[$i]['y_axis'] = '0';
                            $instanse = "image_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $user_post_thumb[$i], $instanse);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse->resize();

                            $thumb_image = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                            }
                            //Thumb Image


                            /* Resize1 Start CROP 335 X 320 */
                            // reconfigure the image lib for cropping

                            $resized_image_width1 = $this->config->item('user_post_resize1_width');
                            $resized_image_height1 = $this->config->item('user_post_resize1_height');
                            if ($thumb_image_width < $resized_image_width1) {
                                $resized_image_width1 = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height1) {
                                $resized_image_height1 = $thumb_image_height;
                            }

                            $conf_new[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $user_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width1,
                                'height' => $resized_image_height1
                            );

                            $conf_new[$i]['new_image'] = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];

                            $left = ($n_w / 2) - ($resized_image_width1 / 2);
                            $top = ($n_h / 2) - ($resized_image_height1 / 2);

                            $conf_new[$i]['x_axis'] = $left;
                            $conf_new[$i]['y_axis'] = $top;

                            $instanse1 = "image1_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $conf_new[$i], $instanse1);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse1->crop();

                            $resize_image = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);
                            }
                            /*  Resize1 End CROP 335 X 320 */

                            /* Resize2 Start CROP 335 X 245 */
                            // reconfigure the image lib for cropping

                            $resized_image_width2 = $this->config->item('user_post_resize2_width');
                            $resized_image_height2 = $this->config->item('user_post_resize2_height');
                            if ($thumb_image_width < $resized_image_width2) {
                                $resized_image_width2 = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height2) {
                                $resized_image_height2 = $thumb_image_height;
                            }


                            $conf_new1[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $user_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width2,
                                'height' => $resized_image_height2
                            );

                            $conf_new1[$i]['new_image'] = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];

                            $left = ($n_w / 2) - ($resized_image_width2 / 2);
                            $top = ($n_h / 2) - ($resized_image_height2 / 2);

                            $conf_new1[$i]['x_axis'] = $left;
                            $conf_new1[$i]['y_axis'] = $top;

                            $instanse2 = "image2_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $conf_new1[$i], $instanse2);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse2->crop();

                            $resize_image1 = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($resize_image1, bucket, $resize_image1, S3::ACL_PUBLIC_READ);
                            }

                            /* Resize2 End CROP 335 X 245 */

                            /* Resize3 Start CROP 210 X 210 */
                            // reconfigure the image lib for cropping

                            $resized_image_width3 = $this->config->item('user_post_resize3_width');
                            $resized_image_height3 = $this->config->item('user_post_resize3_height');
                            if ($thumb_image_width < $resized_image_width3) {
                                $resized_image_width3 = $thumb_image_width;
                            }
                            if ($thumb_image_height < $resized_image_height3) {
                                $resized_image_height3 = $thumb_image_height;
                            }

                            $conf_new2[$i] = array(
                                'image_library' => 'gd2',
                                'source_image' => $user_post_thumb[$i]['new_image'],
                                'create_thumb' => FALSE,
                                'maintain_ratio' => FALSE,
                                'width' => $resized_image_width3,
                                'height' => $resized_image_height3
                            );

                            $conf_new2[$i]['new_image'] = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];

                            $left = ($n_w / 2) - ($resized_image_width3 / 2);
                            $top = ($n_h / 2) - ($resized_image_height3 / 2);

                            $conf_new2[$i]['x_axis'] = $left;
                            $conf_new2[$i]['y_axis'] = $top;

                            $instanse3 = "image3_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $conf_new2[$i], $instanse3);
                            $dataimage = $response['result'][$i]['file_name'];
                            //Creating Thumbnail
                            $this->$instanse3->crop();
                            $resize_image2 = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($resize_image2, bucket, $resize_image2, S3::ACL_PUBLIC_READ);
                            }
                            /* Resize3 End CROP 210 X 210 */

                            /* RESIZE 4 Start */

                            $resize4_image_width = $this->config->item('user_post_resize4_width');
                            $resize4_image_height = $this->config->item('user_post_resize4_height');


                            if ($image_width > $image_height) {
                                $n_h1 = $resize4_image_height;
                                $image_ratio = $image_height / $n_h1;
                                $n_w1 = round($image_width / $image_ratio);
                            } else if ($image_width < $image_height) {
                                $n_w1 = $resize4_image_width;
                                $image_ratio = $image_width / $n_w1;
                                $n_h1 = round($image_height / $image_ratio);
                            } else {
                                $n_w1 = $resize4_image_width;
                                $n_h1 = $resize4_image_height;
                            }

                            $left = ($n_w1 / 2) - ($resize4_image_width / 2);
                            $top = ($n_h1 / 2) - ($resize4_image_height / 2);

                            $user_post_resize4[$i]['image_library'] = 'gd2';
                            $user_post_resize4[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_resize4[$i]['new_image'] = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_resize4[$i]['create_thumb'] = TRUE;
                            $user_post_resize4[$i]['maintain_ratio'] = TRUE;
                            $user_post_resize4[$i]['thumb_marker'] = '';
                            $user_post_resize4[$i]['width'] = $n_w1;
                            $user_post_resize4[$i]['height'] = $n_h1;
                            $user_post_resize4[$i]['quality'] = "100%";
                            $instanse4 = "image4_$i";
                            //Loading Image Library
                            $this->load->library('image_lib', $user_post_resize4[$i], $instanse4);
                            //Creating Thumbnail
                            $this->$instanse4->resize();
                            $this->$instanse4->clear();

                            $resize_image4 = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($resize_image4, bucket, $resize_image4, S3::ACL_PUBLIC_READ);
                            }
                            /* RESIZE 4 End */
                            }


                            /*if ($count == '3') {
                                
                            }

                            
                            if ($count == '2' || $count == '3') {
                               
                            }
                            if ($count == '4' || $count > '4') {                              
                                
                            }*/
                            
                            // $response['error'][] = $thumberror = $this->$instanse->display_errors();
                            // $return['data'][] = $imgdata;
                            // $return['status'] = "success";
                            // $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
                            

                            $insert_data = array();
                            $insert_data['post_id'] = $user_post_id;
                            $insert_data['file_type'] = $file_type;
                            $insert_data['filename'] = $fileName;
                            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                            
                            $insert_post_id = $this->common->insert_data_getid($insert_data, 'user_post_file');

                            /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */

                            /*if ($_SERVER['HTTP_HOST'] != "aileensoul.localhost") {
                                if (isset($main_image)) {
                                    unlink($main_image);
                                }
                                if (isset($thumb_image)) {
                                    unlink($thumb_image);
                                }
                                if (isset($resize_image)) {
                                    unlink($resize_image);
                                }
                                if (isset($resize_image1)) {
                                    unlink($resize_image1);
                                }
                                if (isset($resize_image2)) {
                                    unlink($resize_image2);
                                }
                                if (isset($resize_image4)) {
                                    unlink($resize_image4);
                                }
                            }*/
                            /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */
                        } else {
                            echo $this->upload->display_errors();
                            exit;
                        }
                    } else {
                        $this->session->set_flashdata('error', '<div class="col-md-7 col-sm-7 alert alert-danger1">Something went to wrong in uploded file.</div>');
                        exit;
                    }
                $i++;
                }

                // echo $file_type;exit();

                if ($is_user_monetize > 0 && $post_for == 'simple' && $file_type == 'image') {
                    $inser_point = array(
                        "user_id"       =>  $userid,
                        "post_id"       =>  $user_post_id,
                        "points"        =>  5,
                        "points_for"    =>  6,
                        "description"   =>  '',
                        "status"        =>  '0',
                        "created_date"  =>  date('Y-m-d H:i:s', time()),
                        "modify_date"   =>  date('Y-m-d H:i:s', time()),
                    );
                    $this->common->insert_data_getid($inser_point, 'user_point_mapper');
                }
                else if ($is_user_monetize > 0 && $post_for == 'simple' && $file_type == 'video') {
                    $inser_point = array(
                        "user_id"       =>  $userid,
                        "post_id"       =>  $user_post_id,
                        "points"        =>  30,
                        "points_for"    =>  2,
                        "description"   =>  '',
                        "status"        =>  '0',
                        "created_date"  =>  date('Y-m-d H:i:s', time()),
                        "modify_date"   =>  date('Y-m-d H:i:s', time()),
                    );
                    $this->common->insert_data_getid($inser_point, 'user_point_mapper');
                }
            }

            //$post_data = $this->user_post_model->userPost($userid, $start = '0', $limit = '1');
            //  echo count($post_data); '<pre>'; print_r($post_data); die();
            $postDetailData = $this->user_post_model->postDetail($user_post_id, $userid);
            echo json_encode($postDetailData[0]);
            // echo json_encode($post_data);
            // echo json_encode("1");
        }
    }

    public function getPostData() {
        $post_id = $_POST['post_id'];
        $post_for = $_POST['post_for'];

        if ($post_for == 'simple') {
            $post_data = $this->user_post_model->simplePost($post_id);
        } else if ($post_for == 'opportunity') {
            $post_data = $this->user_post_model->opportunityPost($post_id);

            $post_opp = explode(',', $post_data['opportunity_for']);
            $post_opp_loc = explode(',', $post_data['location']);

            foreach ($post_opp as $key => $value) {
                $opprtunity[$key]['name'] = $value;
            }

            foreach ($post_opp_loc as $key => $value) {
                $location[$key]['city_name'] = $value;
            }
//            $post_data['opportunity_for'] = json_encode($opprtunity);
//            $post_data['location'] = json_encode($location);
            $post_data['opportunity_for'] = $opprtunity;
            $post_data['location'] = $location;
//            echo '<pre>';
//            print_r($opprtunity);
//            print_r($location);
//            print_r($post_data);
//            exit;
        } else {
            $post_data = $this->user_post_model->askQuestionPost($post_id);

            $post_ask_que = explode(',', $post_data['tag_name']);

            foreach ($post_ask_que as $key => $value) {
                $tagname[$key]['name'] = $value;
            }

            // $post_data['tag_name'] = json_encode($tagname);
            $post_data['tag_name'] = $tagname;
        }
        echo json_encode($post_data);
    }

    public function edit_post_opportunity() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $post_for = $_POST['post_for'];

        if ($post_for == 'simple') {

            $hashtag = $_POST['hashtag'];
            $sptitle = $_POST['sptitle'];
            $sptitle = substr($sptitle, 0,100);
            // $sim_title = $this->common->set_slug($sptitle, 'simslug', 'user_simple_post');

            $description = $_POST['description'];

            $hashtag_arr = $this->get_hashtag_array($hashtag);
            $hashtag_id = "";
            foreach ($hashtag_arr as $key=>$value) {
                $ht_arr = $this->data_model->find_hashtag($value);
                if ($ht_arr['id'] != '') {
                    $ht_id = $ht_arr['id'];
                } else {
                    $data = array();
                    $data['hashtag'] = $value;
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';                        
                    $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                }
                $hashtag_id .= $ht_id . ',';
            }
            $hashtag_id = trim($hashtag_id, ',');

            $update_data = array();
            $update_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
            // $update_data['simslug'] = $sim_title;
            $update_data['sim_title'] = $sptitle;
            $update_data['description'] = $description;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_simple_post', 'post_id', $post_id);
        } else if ($post_for == 'opportunity') {

            $opp_desc = $_POST['description'];
            $opptitle = $_POST['opptitle'];
            $opp_field = $_POST['field'];
            $company_name = (isset($_POST['company_name']) && $_POST['company_name'] != "undefined" && $_POST['company_name'] != "" ? $_POST['company_name'] : "");
            if($opp_field == 0)
                $other_field = $_POST['other_field'];
            else
                $other_field = "";

            $hashtag = $_POST['hashtag'];
            $job_title = json_decode($_POST['job_title'], TRUE);
            $location = json_decode($_POST['location'], TRUE);

            $job_title_id = "";
            foreach ($job_title as $title) {
                $designation = $this->data_model->findJobTitle($title['name']);
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
                $job_title_id .= $jobTitleId . ',';
            }
            $job_title_id = trim($job_title_id, ',');

            $city_id = "";
            foreach ($location as $loc) {
                $city = $this->data_model->findCityList($loc['city_name']);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $city_slug = $this->common->set_city_slug(trim($loc['city_name']), 'slug', 'cities');
                    $data['city_name'] = $loc['city_name'];
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $data['city_image'] =  $city_slug.'.png';
                    $data['slug'] = $city_slug;
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
                $city_id .= $cityId . ',';
            }
            $city_id = trim($city_id, ',');

            $hashtag_arr = $this->get_hashtag_array($hashtag);
            $hashtag_id = "";
            foreach ($hashtag_arr as $key=>$value) {
                $ht_arr = $this->data_model->find_hashtag($value);
                if ($ht_arr['id'] != '') {
                    $ht_id = $ht_arr['id'];
                } else {
                    $data = array();
                    $data['hashtag'] = $value;
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';                        
                    $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                }
                $hashtag_id .= $ht_id . ',';
            }
            $hashtag_id = trim($hashtag_id, ',');

            $opportunity_location = $this->user_post_model->GetLocationName($city_id);
            $opportunity_title = $this->user_post_model->GetJobTitleName($job_title_id);
            $opportunity_field = $this->user_post_model->GetIndustryFieldName($opp_field);

            $update_data = array();
            $opptitle = substr($opptitle, 0,100);
            $update_data['opptitle'] = $opptitle;
            $update_data['opportunity_for'] = $job_title_id;
            $update_data['location'] = $city_id;
            $update_data['opportunity'] = $opp_desc;
            $update_data['field'] = $opp_field;
            $update_data['other_field'] = $other_field;
            $update_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
            $update_data['company_name'] = $company_name;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_opportunity', 'post_id', $post_id);
        } else if ($post_for == 'question') {
            $ask_que = $_POST['question'];
            $ask_desc = $_POST['description'];
            $ask_field = $_POST['field'];
            $ask_other_field = $_POST['other_field'];
            $ask_web_link = $_POST['weblink'];
            $hashtag = $_POST['hashtag'];
            $ask_category = json_decode($_POST['category'], TRUE);
            $is_anonymously = $_POST['is_anonymously'];

            foreach ($ask_category as $ask) {
                $asked = $this->data_model->findCategory($ask['name']);
                if ($asked['id'] != '') {
                    $categoryId .= $asked['id'] . ',';
                } else {
                    $data = array();
                    $data['name'] = $ask['name'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['user_id'] = $userid;
                    $data['status'] = 'draft';
                    $categorysId = $this->common->insert_data_getid($data, 'tags');
                    $categoryId .= $categorysId . ',';
                }
            }
            $categoryId = trim($categoryId, ',');
            
            $hashtag_arr = $this->get_hashtag_array($hashtag);
            $hashtag_id = "";
            foreach ($hashtag_arr as $key=>$value) {
                $ht_arr = $this->data_model->find_hashtag($value);
                if ($ht_arr['id'] != '') {
                    $ht_id = $ht_arr['id'];
                } else {
                    $data = array();
                    $data['hashtag'] = $value;
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';                        
                    $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                }
                $hashtag_id .= $ht_id . ',';
            }
            $hashtag_id = trim($hashtag_id, ',');

            $question_category = $this->user_post_model->GetQuestionCategoryName($categoryId);
            $question_field = $this->user_post_model->GetIndustryFieldName($ask_field);

            $update_data = array();
            $update_data['question'] = $ask_que;
            $update_data['description'] = $ask_desc;
            $update_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
            $update_data['category'] = $categoryId;
            $update_data['field'] = $ask_field;
            $update_data['others_field'] = $ask_other_field;
            $update_data['is_anonymously'] = $is_anonymously;
            $update_data['link'] = $ask_web_link;
            $update_data['modify_date'] = date('Y-m-d H:i:s', time());
            $update_post_data = $this->common->update_data($update_data, 'user_ask_question', 'post_id', $post_id);
        }

        if ($update_post_data) {
            if ($post_for == 'opportunity') {
                $opportunity_data = $this->user_post_model->getOpportunityDataFromId($post_id);
                $opp_desc = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $updatedata = array(
                    'response' => 1,
                    'opp_location' => $opportunity_location['location'],
                    'opp_opportunity_for' => $opportunity_title['opportunity_for'],
                    'opp_field' => ($opp_field != 0 ? $opportunity_field['field'] : $other_field),
                    'field_id' => $opp_field,
                    'opportunity' => $opp_desc,
                    'opptitle' => $opportunity_data['opptitle'],
                    'hashtag' => $opportunity_data['hashtag'],
                    'oppslug' => $opportunity_data['oppslug'],
                    'company_name' => $opportunity_data['company_name'],
                );                
            } else if ($post_for == 'simple') {
                // $description = nl2br($this->common->make_links($description));
                $simple_data = $this->user_post_model->get_simepl_post_data_from_id($post_id);
                $updatedata = array(
                    'response' => 1,
                    'sim_description' => $simple_data['description'],
                    'hashtag' => $simple_data['hashtag'],
                    'sim_title' => $simple_data['sim_title'],
                );
            } else if ($post_for == 'question') {
                //$ask_desc = nl2br($this->common->make_links($ask_desc));
                
                $updatedata['question_data'] = $this->user_post_model->getQuestionDataFromId($post_id);
                $updatedata['response'] = 1;
            }
        } else {
            $updatedata = array(
                'response' => 0,
            );
        }

        echo json_encode($updatedata);
    }

    public function search() {
        $q = $_GET['q'];

        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['search_keyword'] = $q;

        $this->load->view('user_post/search', $this->data);
    }

    public function searchData() {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];
        $searchData = $this->user_post_model->searchData($userid,$searchKeyword);
        echo json_encode($searchData);
    }

    public function searchDataProfileAjax() {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];
        $page = $_POST['pagenum'];
        $limit = 5;
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $searchData = $this->user_post_model->searchDataProfileAjax($userid,$searchKeyword,$start,$limit);
        echo json_encode($searchData);
    }

    public function searchDataPostAjax() {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];
        $page = $_POST['pagenum'];
        $limit = 3;
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $searchData = $this->user_post_model->searchDataPostAjax($userid,$searchKeyword,$start,$limit);
        echo json_encode($searchData);
    }
    
    public function likeuserlist() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $userListData = $this->user_post_model->getLikeUserList($post_id);

        $data = array(
            'countlike' => count($userListData),
            'likeuserlist' => $userListData
        );
        echo json_encode($data);
    }

    public function post_detail($post_id = '') {
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
        $this->data['post_id'] = $post_id;
        $this->data['title'] = "Post Detail".TITLEPOSTFIX;
        if($userid != '')
        {
            $this->load->view('user_post/post_details', $this->data);
        }
        else
        {
            redirect(base_url());
        }
    }

    public function post_data() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_GET['post_id'];
        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
        echo json_encode($postDetailData);
    }

    public function opprtunity_detail($slug = '') {
        $userid = $this->session->userdata('aileenuser');
        $this->data['opp_data'] = $opp_data = $this->user_post_model->get_opportunity_from_slug($slug);        
        if($userid == "")
        {
            $userid = $opp_data['user_id'];
        }
        $post_id = $opp_data['post_id'];
        
        $this->data['userdata'] = $userdata = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");        
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['post_id'] = $post_id;
        $this->data['title'] = $opp_data['opptitle'].TITLEPOSTFIX;
        $this->data['metadesc'] = ucwords($userdata['first_name'])." posted opportunity for ".$opp_data['opportunity_for']." in ".$opp_data['location'].".";
        if($this->session->userdata('aileenuser') != "")
        {
            if(isset($opp_data) && !empty($opp_data))
            {
                $this->load->view('user_post/post_details', $this->data);
            }
            else
            {
                $this->data['title'] = "404".TITLEPOSTFIX;
                $this->data['metadesc'] = "404";
                $this->load->view('404', $this->data);
            }
        }
        else
        {
            if(isset($opp_data) && !empty($opp_data))
            {
                $this->load->view('user_post/opprtunity_detail', $this->data);
            }
            else
            {
                $this->data['title'] = "404".TITLEPOSTFIX;
                $this->data['metadesc'] = "404";
                $this->load->view('404', $this->data);
            }
        }
    }

    public function create_opp_slug()
    {
        $this->user_post_model->create_opp_slug();        
    }

    public function send_email_in_background()
    {
        $subject = $this->input->post('subject');
        $email_html = $this->input->post('email_html');
        $to_email = $this->input->post('to_email');
        $email_data = $this->user_model->getUserByEmail($to_email);
        if($email_data)
        {
            $unsubscribe = $this->input->post('unsubscribe');
            $send_email = $this->email_model->send_email($subject, $email_html, $to_email,$unsubscribe);
        }
    }

    public function get_business_contact_suggetion() {

        $userid = $this->session->userdata('aileenuser');
        $login_userdata = $this->user_model->getUserSelectedData($userid, $select_data = "u.user_slug,u.first_name,u.last_name,ui.user_image");
        if($login_userdata)
        {
            $business_data = $this->user_post_model->get_business_contact_suggetion($userid);            
        }
        else
        {
            $business_data = array();   
        }

        echo json_encode($business_data);
    }

    public function add_business_follow() {
        $userid = $this->session->userdata('aileenuser');
        $follow_id = $_POST['follow_id'];
        $status = $_POST['status'];
        $id = $_POST['to_id'];
        $follow = $this->userprofile_model->userBusinessFollowStatus($userid, $id);
        // print_r($follow);exit();

        if (count($follow) != 0) {
            $data = array('status' => $status,'modify_date' => date("Y-m-d h:i:s"));
            // $insert_id = $this->common->update_data($data, 'user_follow', 'id', $follow['id']);
            $where = array('id' => $follow['id'], 'follow_type' => '2');
            $this->db->where($where);
            $updatdata = $this->db->update('user_follow', $data);
            $response = $status;
        } else {
            $data = array(
                'status' => $status,
                'follow_from' => $userid,
                'follow_to' => $id,
                'follow_type' => '2',
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
                $contition_array = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $id, 'not_from' => '7', 'not_img' => '1');
                $follownotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($follownotification[0]['not_read'] == 2) {                
                }
                elseif($follownotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '8', 'not_from_id' => $userid, 'not_to_id' => $id, 'not_from' => '7', 'not_img' => '1');
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
                        'not_img' => '1',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('contact_email')->get_where('business_profile', array('user_id' => $id))->row()->contact_email;
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
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> started following you in business profile.</p>
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

    public function getUserBusinessPost() {
        // $userid = $this->session->userdata('aileenuser');
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        /*$user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');*/
        $user_slug = $_GET["user_slug"];

        $contition_array = array('business_slug' => $user_slug, 'is_deleted' => '0', 'status' => '1');
        $business_profile_count = $this->common->select_data_by_condition('business_profile', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if(count($business_profile_count) > 0)
        {
            $userid = $business_profile_count[0]['user_id'];
            $post_data = $this->user_post_model->business_user_post_new($userid, $page);
        }
        else
        {
            $post_data = "";
        }
        
        echo json_encode($post_data);
    }

    public function post_opportunity_business() {

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $userid = $this->session->userdata('aileenuser');

        $opptitle = (isset($_POST['opptitle'])  && $_POST['opptitle'] != "undefined" && $_POST['opptitle'] != "" ? $_POST['opptitle'] : "");
        $sptitle = (isset($_POST['sptitle'])  && $_POST['sptitle'] != "undefined" && $_POST['sptitle'] != "" ? $_POST['sptitle'] : "");        
        $field = (isset($_POST['field'])  && $_POST['field'] != "undefined" && $_POST['field'] != "" ? $_POST['field'] : "");
        $job_title = (isset($_POST['job_title']) && $_POST['job_title'] != "undefined" && $_POST['job_title'] != "" ? json_decode($_POST['job_title'], TRUE) : "");
        $location = (isset($_POST['location']) && $_POST['location'] != "undefined" && $_POST['location'] != "" ? json_decode($_POST['location'], TRUE) : "");
        $post_for = $_POST['post_for'];
        $question = (isset($_POST['question']) && $_POST['question'] != "" ? $_POST['question'] : "");
        $description = (isset($_POST['description']) && $_POST['description'] != 'undefined' && $_POST['description'] != '' ? $_POST['description'] : '');
        $hashtag = (isset($_POST['hashtag']) && $_POST['hashtag'] != 'undefined' && $_POST['hashtag'] != '' ? $_POST['hashtag'] : '');
        $other_field = (isset($_POST['other_field']) && $_POST['other_field'] != 'undefined' && $_POST['other_field'] != "" ? $_POST['other_field'] : "");
        $weblink = (isset($_POST['weblink']) && $_POST['weblink'] != 'undefined' && $_POST['weblink'] != '' ? $_POST['weblink'] : '');
        $is_anonymously = (isset($_POST['is_anonymously']) && $_POST['is_anonymously'] != 'undefined' && $_POST['is_anonymously'] != '' ? '1' : '0');
        $category = (isset($_POST['category']) && $_POST['category'] != "undefined" && $_POST['category'] != "" ? json_decode($_POST['category'], TRUE) : "");
        $company_name = (isset($_POST['company_name']) && $_POST['company_name'] != "undefined" && $_POST['company_name'] != "" ? $_POST['company_name'] : "");


        $error = '';
        if ($post_for == 'opportunity') {
            if ($field <= -1) {
                $error = 1;
            } elseif ($job_title[0]['name'] == '') {
                $error = 1;
            } elseif ($location[0]['city_name'] == '') {
                $error = 1;
            }
        }

        if ($post_for == 'question') {
            $ask_question = $question;
            $ask_description = $description == 'undefined' ? '' : $description;
            $ask_field = $field;
            $ask_category = $category;
            $ask_weblink = $weblink == 'undefined' ? '' : $weblink;

            if ($ask_question == '') {
                $error = 1;
            } elseif ($ask_field == '') {
                $error = 1;
            }
        }

        if ($error != '1') {
            if ($post_for == 'opportunity') {
                $job_title_id = "";
                foreach ($job_title as $title) {
                    $designation = $this->data_model->findJobTitle($title['name']);
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
                    $job_title_id .= $jobTitleId . ',';
                }
                $job_title_id = trim($job_title_id, ',');
                $city_id = "";
                foreach ($location as $loc) {
                    $city = $this->data_model->findCityList($loc['city_name']);
                    if ($city['city_id'] != '') {
                        $cityId = $city['city_id'];
                    } else {
                        $data = array();
                        $city_slug = $this->common->set_city_slug(trim($loc['city_name']), 'slug', 'cities');
                        $data['city_name'] = $loc['city_name'];
                        $data['state_id'] = '0';
                        $data['status'] = '2';
                        $data['group_id'] = '0';
                        $data['city_image'] =  $city_slug.'.png';
                        $data['slug'] = $city_slug;
                        $cityId = $this->common->insert_data_getid($data, 'cities');
                    }
                    $city_id .= $cityId . ',';
                }
                $city_id = trim($city_id, ',');

                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }
            elseif ($post_for == 'simple') {
                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }elseif ($post_for == 'question') {
                foreach ($ask_category as $ask) {
                    $asked = $this->data_model->findCategory($ask['name']);
                    if ($asked['id'] != '') {
                        $categoryId .= $asked['id'] . ',';
                    } else {
                        $data = array();
                        $data['name'] = $ask['name'];
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['user_id'] = $userid;
                        $data['status'] = 'draft';
                        $categorysId = $this->common->insert_data_getid($data, 'tags');
                        $categoryId .= $categorysId . ',';
                    }
                }
                $categoryId = trim($categoryId, ',');

                $hashtag_arr = $this->get_hashtag_array($hashtag);
                $hashtag_id = "";
                foreach ($hashtag_arr as $key=>$value) {
                    $ht_arr = $this->data_model->find_hashtag($value);
                    if ($ht_arr['id'] != '') {
                        $ht_id = $ht_arr['id'];
                    } else {
                        $data = array();
                        $data['hashtag'] = $value;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = '2';                        
                        $ht_id = $this->common->insert_data_getid($data, 'hashtag');
                    }
                    $hashtag_id .= $ht_id . ',';
                }
                $hashtag_id = trim($hashtag_id, ',');
            }
            $this->config->item('user_post_main_upload_path');
            $config = array(
                'image_library' => 'gd',
                'upload_path' => $this->config->item('user_post_main_upload_path'),
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite' => true,
                'remove_spaces' => true);

            $images = array();
            $this->load->library('upload');

            $files = $_FILES;
            $count = count($_FILES);//$_FILES['postfiles']['name']);
            $title = time();

            $insert_data = array();
            $insert_data['user_id'] = $userid;
            if ($post_for == 'opportunity') {
                $insert_data['post_for'] = 'opportunity';
            } elseif ($post_for == 'simple') {
                $insert_data['post_for'] = 'simple';
            } elseif ($post_for == 'question') {
                $insert_data['post_for'] = 'question';
            }
            $insert_data['post_id'] = '';
            $insert_data['user_type'] = '2';
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['status'] = 'publish';
            $insert_data['is_delete'] = '0';

            $user_post_id = $this->common->insert_data_getid($insert_data, 'user_post');

            if ($post_for == 'opportunity') {
                $insert_data = array();
                $opptitle = substr($opptitle, 0,100);
                $oppslug = $this->common->set_slug($opptitle, 'oppslug', 'user_opportunity');
                $insert_data['post_id'] = $user_post_id;
                $insert_data['opptitle'] = $opptitle;
                $insert_data['oppslug'] = $oppslug;
                $insert_data['opportunity_for'] = $job_title_id;
                $insert_data['location'] = $city_id;
                $insert_data['opportunity'] = $description == 'undefined' ? "" : trim($description);
                $insert_data['field'] = $field;
                $insert_data['other_field'] = $other_field;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
                $insert_data['company_name'] = $company_name;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

                $inserted_id = $user_opportunity_id = $this->common->insert_data_getid($insert_data, 'user_opportunity');

            } elseif ($post_for == 'simple') {
                $insert_data = array();
                $sptitle = substr($sptitle, 0,100);
                $sim_title = $this->common->set_slug($sptitle, 'simslug', 'user_simple_post');
                $insert_data['post_id'] = $user_post_id;
                $insert_data['simslug'] = $sim_title;
                $insert_data['sim_title'] = $sptitle;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);                
                $insert_data['description'] = $description == 'undefined' ? "" : trim($description);
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_simple_post');
            } elseif ($post_for == 'question') {
                $insert_data = array();
                $insert_data['post_id'] = $user_post_id;
                $insert_data['question'] = $ask_question;
                $insert_data['description'] = $ask_description;
                $insert_data['category'] = $categoryId;
                $insert_data['hashtag'] = ($hashtag_id != '' ? $hashtag_id : NULL);
                $insert_data['field'] = $ask_field;
                $insert_data['others_field'] = $other_field;
                $insert_data['link'] = $ask_weblink;
                $insert_data['is_anonymously'] = $is_anonymously;
                $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                $inserted_id = $user_simple_id = $this->common->insert_data_getid($insert_data, 'user_ask_question');
            }
            $update_data = array();
            $update_data['post_id'] = $inserted_id;
            $update_post = $this->common->update_data($update_data, 'user_post', 'id', $user_post_id);

            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);

            //if ($_FILES['postfiles']['name'][0] != '') {
            if ($count >= 0) {
                $i = 0;
                //for ($i = 0; $i < $count; $i++) {
                foreach($_FILES as $k=>$v) {

                    // $_FILES['postfiles']['name'] = $files['postfiles']['name'][$i];
                    // $_FILES['postfiles']['type'] = $files['postfiles']['type'][$i];
                    // $_FILES['postfiles']['tmp_name'] = $files['postfiles']['tmp_name'][$i];
                    // $_FILES['postfiles']['error'] = $files['postfiles']['error'][$i];
                    // $_FILES['postfiles']['size'] = $files['postfiles']['size'][$i];

                    $_FILES['postfiles']['name'] = $_FILES[$k]['name'];
                    $_FILES['postfiles']['type'] = $_FILES[$k]['type'];
                    $_FILES['postfiles']['tmp_name'] = $_FILES[$k]['tmp_name'];
                    $_FILES['postfiles']['error'] = $_FILES[$k]['error'];
                    $_FILES['postfiles']['size'] = $_FILES[$k]['size'];

                    $file_type = $_FILES[$k]['type'];
                    $file_type = explode('/', $file_type);
                    $file_type = $file_type[0];
                    if ($file_type == 'image') {
                        $file_type = 'image';
                    } elseif ($file_type == 'audio') {
                        $file_type = 'audio';
                    } elseif ($file_type == 'video') {
                        $file_type = 'video';
                    } else {
                        $file_type = 'pdf';
                    }

                    if ($_FILES[$k]['error'] == 0) {
                        $store = $_FILES[$k]['name'];
                        $store_ext = explode('.', $store);
                        $store_ext = end($store_ext);
                        $fileName = 'file_' . $title . '_' . $this->random_string() . '.' . $store_ext;
                        $images[] = $fileName;
                        $config['file_name'] = $fileName;
                        $this->upload->initialize($config);
                        $imgdata = $this->upload->data();

                        if ($this->upload->do_upload('postfiles')) {
                            $upload_data = $response['result'][] = $this->upload->data();

                            if ($file_type == 'video') {
                                $uploaded_url = base_url() . $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                exec("ffmpeg -i " . $uploaded_url . " -vcodec h264 -acodec aac -strict -2 " . $upload_data['file_path'] . $upload_data['raw_name'] . $upload_data['file_ext'] . "");
                                exec("ffmpeg -ss 00:00:05 -i " . $upload_data['full_path'] . " " . $upload_data['file_path'] . $upload_data['raw_name'] . ".png");
                                //$fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "1" . $upload_data['file_ext'];
                                $fileName = $response['result'][$i]['file_name'] = $upload_data['raw_name'] . "" . $upload_data['file_ext'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    //unlink($this->config->item('user_post_main_upload_path') . $upload_data['raw_name'] . "" . $upload_data['file_ext']);
                                    $abc = $s3->putObjectFile($fileName, bucket, $fileName, S3::ACL_PUBLIC_READ);
                                }
                            }                                

                            $main_image_size = $_FILES[$k]['size'];

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

                            $user_post_main[$i]['image_library'] = 'gd2';
                            $user_post_main[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['new_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            $user_post_main[$i]['quality'] = $quality;
                            $instanse10 = "image10_$i";
                            $this->load->library('image_lib', $user_post_main[$i], $instanse10);
                            $this->$instanse10->watermark();

                            /* RESIZE */

                            //Main Image
                            $main_image = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                            }

                            $post_poster = $response['result'][$i]['file_name'];
                            $post_poster1 = explode('.', $post_poster);
                            $post_poster2 = end($post_poster1);
                            $post_poster = str_replace($post_poster2, 'png', $post_poster);

                            $main_image1 = $this->config->item('user_post_main_upload_path') . $post_poster;
                            if (IMAGEPATHFROM == 's3bucket') {
                                $abc = $s3->putObjectFile($main_image1, bucket, $main_image1, S3::ACL_PUBLIC_READ);
                            }
                            $image_width = $response['result'][$i]['image_width'];
                            $image_height = $response['result'][$i]['image_height'];
                            //Main Image
                            if ($file_type == 'image') {
                                //Thumb Image
                                $thumb_image_width = $this->config->item('user_post_thumb_width');
                                $thumb_image_height = $this->config->item('user_post_thumb_height');

                                if ($image_width > $image_height) {
                                    $n_h = $thumb_image_height;
                                    $image_ratio = $image_height / $n_h;
                                    $n_w = round($image_width / $image_ratio);
                                } else if ($image_width < $image_height) {
                                    $n_w = $thumb_image_width;
                                    $image_ratio = $image_width / $n_w;
                                    $n_h = round($image_height / $image_ratio);
                                } else {
                                    $n_w = $thumb_image_width;
                                    $n_h = $thumb_image_height;
                                }

                                $user_post_thumb[$i]['image_library'] = 'gd2';
                                $user_post_thumb[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_thumb[$i]['new_image'] = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_thumb[$i]['create_thumb'] = TRUE;
                                $user_post_thumb[$i]['maintain_ratio'] = FALSE;
                                $user_post_thumb[$i]['thumb_marker'] = '';
                                $user_post_thumb[$i]['width'] = $n_w;
                                $user_post_thumb[$i]['height'] = $n_h;
                                $user_post_thumb[$i]['quality'] = "100%";
                                $user_post_thumb[$i]['x_axis'] = '0';
                                $user_post_thumb[$i]['y_axis'] = '0';
                                $instanse = "image_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $user_post_thumb[$i], $instanse);
                                $dataimage = $response['result'][$i]['file_name'];
                                //Creating Thumbnail
                                $this->$instanse->resize();

                                $thumb_image = $this->config->item('user_post_thumb_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
                                }
                                //Thumb Image


                                /* Resize1 Start CROP 335 X 320 */
                                // reconfigure the image lib for cropping

                                $resized_image_width1 = $this->config->item('user_post_resize1_width');
                                $resized_image_height1 = $this->config->item('user_post_resize1_height');
                                if ($thumb_image_width < $resized_image_width1) {
                                    $resized_image_width1 = $thumb_image_width;
                                }
                                if ($thumb_image_height < $resized_image_height1) {
                                    $resized_image_height1 = $thumb_image_height;
                                }

                                $conf_new[$i] = array(
                                    'image_library' => 'gd2',
                                    'source_image' => $user_post_thumb[$i]['new_image'],
                                    'create_thumb' => FALSE,
                                    'maintain_ratio' => FALSE,
                                    'width' => $resized_image_width1,
                                    'height' => $resized_image_height1
                                );

                                $conf_new[$i]['new_image'] = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];

                                $left = ($n_w / 2) - ($resized_image_width1 / 2);
                                $top = ($n_h / 2) - ($resized_image_height1 / 2);

                                $conf_new[$i]['x_axis'] = $left;
                                $conf_new[$i]['y_axis'] = $top;

                                $instanse1 = "image1_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $conf_new[$i], $instanse1);
                                $dataimage = $response['result'][$i]['file_name'];
                                //Creating Thumbnail
                                $this->$instanse1->crop();

                                $resize_image = $this->config->item('user_post_resize1_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image, bucket, $resize_image, S3::ACL_PUBLIC_READ);
                                }
                                /*  Resize1 End CROP 335 X 320 */

                                /* Resize2 Start CROP 335 X 245 */
                                // reconfigure the image lib for cropping

                                $resized_image_width2 = $this->config->item('user_post_resize2_width');
                                $resized_image_height2 = $this->config->item('user_post_resize2_height');
                                if ($thumb_image_width < $resized_image_width2) {
                                    $resized_image_width2 = $thumb_image_width;
                                }
                                if ($thumb_image_height < $resized_image_height2) {
                                    $resized_image_height2 = $thumb_image_height;
                                }


                                $conf_new1[$i] = array(
                                    'image_library' => 'gd2',
                                    'source_image' => $user_post_thumb[$i]['new_image'],
                                    'create_thumb' => FALSE,
                                    'maintain_ratio' => FALSE,
                                    'width' => $resized_image_width2,
                                    'height' => $resized_image_height2
                                );

                                $conf_new1[$i]['new_image'] = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];

                                $left = ($n_w / 2) - ($resized_image_width2 / 2);
                                $top = ($n_h / 2) - ($resized_image_height2 / 2);

                                $conf_new1[$i]['x_axis'] = $left;
                                $conf_new1[$i]['y_axis'] = $top;

                                $instanse2 = "image2_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $conf_new1[$i], $instanse2);
                                $dataimage = $response['result'][$i]['file_name'];
                                //Creating Thumbnail
                                $this->$instanse2->crop();

                                $resize_image1 = $this->config->item('user_post_resize2_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image1, bucket, $resize_image1, S3::ACL_PUBLIC_READ);
                                }

                                /* Resize2 End CROP 335 X 245 */

                                /* Resize3 Start CROP 210 X 210 */
                                // reconfigure the image lib for cropping

                                $resized_image_width3 = $this->config->item('user_post_resize3_width');
                                $resized_image_height3 = $this->config->item('user_post_resize3_height');
                                if ($thumb_image_width < $resized_image_width3) {
                                    $resized_image_width3 = $thumb_image_width;
                                }
                                if ($thumb_image_height < $resized_image_height3) {
                                    $resized_image_height3 = $thumb_image_height;
                                }

                                $conf_new2[$i] = array(
                                    'image_library' => 'gd2',
                                    'source_image' => $user_post_thumb[$i]['new_image'],
                                    'create_thumb' => FALSE,
                                    'maintain_ratio' => FALSE,
                                    'width' => $resized_image_width3,
                                    'height' => $resized_image_height3
                                );

                                $conf_new2[$i]['new_image'] = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];

                                $left = ($n_w / 2) - ($resized_image_width3 / 2);
                                $top = ($n_h / 2) - ($resized_image_height3 / 2);

                                $conf_new2[$i]['x_axis'] = $left;
                                $conf_new2[$i]['y_axis'] = $top;

                                $instanse3 = "image3_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $conf_new2[$i], $instanse3);
                                $dataimage = $response['result'][$i]['file_name'];
                                //Creating Thumbnail
                                $this->$instanse3->crop();
                                $resize_image2 = $this->config->item('user_post_resize3_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image2, bucket, $resize_image2, S3::ACL_PUBLIC_READ);
                                }
                                /* Resize3 End CROP 210 X 210 */

                                /* RESIZE 4 Start */

                                $resize4_image_width = $this->config->item('user_post_resize4_width');
                                $resize4_image_height = $this->config->item('user_post_resize4_height');


                                if ($image_width > $image_height) {
                                    $n_h1 = $resize4_image_height;
                                    $image_ratio = $image_height / $n_h1;
                                    $n_w1 = round($image_width / $image_ratio);
                                } else if ($image_width < $image_height) {
                                    $n_w1 = $resize4_image_width;
                                    $image_ratio = $image_width / $n_w1;
                                    $n_h1 = round($image_height / $image_ratio);
                                } else {
                                    $n_w1 = $resize4_image_width;
                                    $n_h1 = $resize4_image_height;
                                }

                                $left = ($n_w1 / 2) - ($resize4_image_width / 2);
                                $top = ($n_h1 / 2) - ($resize4_image_height / 2);

                                $user_post_resize4[$i]['image_library'] = 'gd2';
                                $user_post_resize4[$i]['source_image'] = $this->config->item('user_post_main_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_resize4[$i]['new_image'] = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                                $user_post_resize4[$i]['create_thumb'] = TRUE;
                                $user_post_resize4[$i]['maintain_ratio'] = TRUE;
                                $user_post_resize4[$i]['thumb_marker'] = '';
                                $user_post_resize4[$i]['width'] = $n_w1;
                                $user_post_resize4[$i]['height'] = $n_h1;
                                $user_post_resize4[$i]['quality'] = "100%";
                                $instanse4 = "image4_$i";
                                //Loading Image Library
                                $this->load->library('image_lib', $user_post_resize4[$i], $instanse4);
                                //Creating Thumbnail
                                $this->$instanse4->resize();
                                $this->$instanse4->clear();

                                $resize_image4 = $this->config->item('user_post_resize4_upload_path') . $response['result'][$i]['file_name'];
                                if (IMAGEPATHFROM == 's3bucket') {
                                    $abc = $s3->putObjectFile($resize_image4, bucket, $resize_image4, S3::ACL_PUBLIC_READ);
                                }
                                /* RESIZE 4 End */
                            }

                            $insert_data = array();
                            $insert_data['post_id'] = $user_post_id;
                            $insert_data['file_type'] = $file_type;
                            $insert_data['filename'] = $fileName;
                            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
                            
                            $insert_post_id = $this->common->insert_data_getid($insert_data, 'user_post_file');

                            /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */

                            /*if ($_SERVER['HTTP_HOST'] != "aileensoul.localhost") {
                                if (isset($main_image)) {
                                    unlink($main_image);
                                }
                                if (isset($thumb_image)) {
                                    unlink($thumb_image);
                                }
                                if (isset($resize_image)) {
                                    unlink($resize_image);
                                }
                                if (isset($resize_image1)) {
                                    unlink($resize_image1);
                                }
                                if (isset($resize_image2)) {
                                    unlink($resize_image2);
                                }
                                if (isset($resize_image4)) {
                                    unlink($resize_image4);
                                }
                            }*/
                            /* THIS CODE UNCOMMENTED AFTER SUCCESSFULLY WORKING : REMOVE IMAGE FROM UPLOAD FOLDER */
                        } else {
                            echo $this->upload->display_errors();
                            exit;
                        }
                    } else {
                        $this->session->set_flashdata('error', '<div class="col-md-7 col-sm-7 alert alert-danger1">Something went to wrong in uploded file.</div>');
                        exit;
                    }
                $i++;
                }
            }

            //$post_data = $this->user_post_model->userPost($userid, $start = '0', $limit = '1');
            //  echo count($post_data); '<pre>'; print_r($post_data); die();
            $postDetailData = $this->user_post_model->postDetail($user_post_id, $userid);
            echo json_encode($postDetailData[0]);
            // echo json_encode($post_data);
            // echo json_encode("1");
        }
    }

    public function add_post_comment_reply() {
        // print_r($_POST);
        // exit();
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $comment_id = $_POST['comment_id'];
        $comment = $_POST['comment'];
        $mention = $_POST['mention'];
        $mention_id = $_POST['mention_id'];
        $comment_reply_id = $_POST['comment_reply_id'];
        $comment_data = $this->user_post_model->get_post_comment_reply_id($post_id, $comment_reply_id);

        $dom = new DomDocument();
        $dom->loadHTML($comment);        
        $mention_tags = array();
        foreach ($dom->getElementsByTagName('a') as $item) {            
            if($item->nodeValue != '')
            {
                // echo $item->getAttribute('mention');
                if($item->getAttribute('mention') != '')
                {
                    $mention_tags[] = base64_decode($item->getAttribute('mention'));
                }
            }
        }        
        $mention_tags = array_unique($mention_tags);

        if($comment_data)
        {
            $data = array();
            $data['user_id'] = $userid;
            $data['post_id'] = $post_id;
            $data['reply_comment_id'] = $comment_id;
            $data['comment'] = $comment;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['is_delete'] = '0';
            $postComentId = $this->common->insert_data_getid($data, 'user_post_comment');
            if($postComentId)
            {
                $return_data['message'] = '1';
                $return_data['comment_reply_data'] = $this->user_post_model->post_comment_reply_data($post_id,$comment_id,$userid);
                
                $to_id = $comment_data['user_id'];
                if($userid != $to_id)
                {
                    if($mention == 0)
                    {
                        $contition_array = array('not_from' => '7', 'not_img' => '3', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $to_id);//Comment Reply
                    }
                    elseif($mention == 1)
                    {
                        $contition_array = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $to_id);//Mention in Comment Reply   
                    }

                    $comment_notification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if ($comment_notification[0]['not_read'] == 2) {                
                    }
                    elseif($comment_notification[0]['not_read'] == 1)
                    {
                        $data_cmt_reply = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                        if($mention == 0)
                        {
                            $where = array('not_from' => '7', 'not_img' => '3', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $to_id);
                        }
                        elseif($mention == 1)
                        {
                            $where = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $to_id);
                        }
                        $this->db->where($where);
                        $updatdata = $this->db->update('notification', $data_cmt_reply);
                    }
                    else
                    {
                        if($mention == 0)
                        {
                            $data_cmt_reply = array(
                                'not_from' => '7',
                                'not_type' => '6',
                                'not_img' => '3',
                                'not_from_id' => $userid,
                                'not_product_id'=>$postComentId,
                                'not_to_id' => $to_id,
                                'not_read' => '2',                    
                                'not_created_date' => date('Y-m-d H:i:s'),
                                'not_active' => '1'
                            );
                        }
                        elseif($mention == 1)
                        {
                            $data_cmt_reply = array(
                                'not_from' => '7',
                                'not_type' => '6',
                                'not_img' => '4',
                                'not_from_id' => $userid,
                                'not_product_id'=>$postComentId,
                                'not_to_id' => $to_id,
                                'not_read' => '2',                    
                                'not_created_date' => date('Y-m-d H:i:s'),
                                'not_active' => '1'
                            );
                        }                        
                        $insert_id = $this->common->insert_data_getid($data_cmt_reply, 'notification');

                        if($_SERVER['HTTP_HOST'] != "aileensoul.localhost" && $userid != $to_id)
                        {

                            $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;

                            $login_userdata = $this->user_model->getUserData($userid);
                            $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                            // print_r($postDetailData);exit;
                            if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                            }
                            elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                            }
                            elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                            }
                            elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                            }
                            elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                            }
                            else
                            {
                                $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                            }

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
                                                <td style="padding:5px;">';
                            if($mention == 0)
                            {
                                $email_html .= '<p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> replied on your comment.</p>';
                            }
                            elseif($mention == 1)
                            {
                                $email_html .= '<p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> mentioned you in a comment.</p>';   
                            }
                            $email_html .= '<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                    </td>
                                    <td style="'.MAIL_TD_3.'">
                                        <p><a class="btn" href="'.$url.'">view</a></p>
                                    </td>
                                </tr>
                                </table>';
                            if($mention == 0)
                            {
                                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' replied on your comment in Aileensoul.';
                            }
                            elseif($mention == 1)
                            {
                                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' mentioned you in a comment in Aileensoul.';
                            }

                            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

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
                            }
                        }
                        if($comment_id != $comment_reply_id)
                        {
                            $main_comment_data = $this->user_post_model->get_post_comment_reply_id($post_id, $comment_id);
                            $main_to_id = $main_comment_data['user_id'];
                            if($userid != $main_to_id && $_SERVER['HTTP_HOST'] != "aileensoul.localhost")
                            {
                                $main_to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $main_to_id))->row()->email;

                                $login_userdata = $this->user_model->getUserData($userid);
                                $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                                // print_r($postDetailData);exit;
                                if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                                }
                                elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                                }
                                else
                                {
                                    $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                }

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
                                                    <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> replied on your comment.</p>
                                                    <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                                    </td>
                                                    <td style="'.MAIL_TD_3.'">
                                                        <p><a class="btn" href="'.$url.'">view</a></p>
                                                    </td>
                                                </tr>
                                                </table>';
                                
                                $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' replied on your comment in Aileensoul.';

                                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

                                $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                                if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
                                {
                                    $url = base_url()."user_post/send_email_in_background";
                                    $param = array(
                                        "subject"=>$subject,
                                        "email_html"=>$email_html,
                                        "to_email"=>$main_to_email_id,
                                        "unsubscribe"=>$unsubscribe,
                                    );
                                    $this->inbackground->do_in_background($url, $param);
                                }
                            }
                        }
                    }
                }

                if(isset($mention_tags) && !empty($mention_tags))
                {
                    foreach ($mention_tags as $k => $user_slug) {
                        $userdata = $this->user_model->getUserDataByslug($user_slug, "u.user_id ,u.first_name ,u.last_name ,u.user_slug ,u.user_verify ,u.user_gender ,u.encrypt_key ,u.is_subscribe ,ui.user_image ,ul.email");
                        if($userdata['user_id'] != $userid)
                        {
                            $contition_array = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $userdata['user_id']);//Mention in Comment

                            $comment_notification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                            if ($comment_notification[0]['not_read'] == 2) {                
                            }
                            elseif($comment_notification[0]['not_read'] == 1)
                            {
                                $data_cmt = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                                $where = array('not_from' => '7', 'not_img' => '4', 'not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$postComentId,'not_to_id' => $userdata['user_id']);                            
                                $this->db->where($where);
                                $updatdata = $this->db->update('notification', $data_cmt);
                            }
                            else
                            {
                                $data_cmt = array(
                                    'not_from' => '7',
                                    'not_type' => '6',
                                    'not_img' => '4',
                                    'not_from_id' => $userid,
                                    'not_product_id'=>$postComentId,
                                    'not_to_id' => $userdata['user_id'],
                                    'not_read' => '2',                    
                                    'not_created_date' => date('Y-m-d H:i:s'),
                                    'not_active' => '1'
                                );
                                $insert_id = $this->common->insert_data_getid($data_cmt, 'notification');
                                if($_SERVER['HTTP_HOST'] != "aileensoul.localhost")
                                {
                                    $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $userdata['user_id']))->row()->email;

                                    $login_userdata = $this->user_model->getUserData($userid);
                                    $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                                    if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                    }
                                    elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                                    }
                                    elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                                    }
                                    elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                                    }
                                    elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                                    }
                                    else
                                    {
                                        $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                                    }

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
                                                        <td style="padding:5px;">';
                                    if($mention == 0)
                                    {
                                        $email_html .= '<p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> replied on your comment.</p>';
                                    }
                                    elseif($mention == 1)
                                    {
                                        $email_html .= '<p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> mentioned you in a comment.</p>';   
                                    }
                                    $email_html .= '<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';

                                    $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' mentioned you in a comment in Aileensoul.';
                                    $unsubscribe = base_url()."unsubscribe/".md5($userdata['encrypt_key'])."/".md5($userdata['user_slug'])."/".md5($userdata['user_id']);

                                    if($userdata['is_subscribe'] == 1)
                                    {
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
                }
            }
        }
        else
        {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    public function edit_post_comment_reply() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $_POST['post_id'];
        $comment_id = $_POST['reply_comment_id'];
        $comment = $_POST['comment'];
        // print_r($_POST);
        $data = array();
        $data['comment'] = $comment;
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $updatedata = $this->common->update_data($data, 'user_post_comment', 'id', $comment_id);
        $return_array = array();
        if ($updatedata) {
            $return_array['message'] = 1;
        }
        echo json_encode($return_array);
    }

    public function simple_post_detail($slug = '') {
        $userid = $this->session->userdata('aileenuser');
        $this->data['simp_data'] = $simp_data = $this->user_post_model->get_simplepost_from_slug($slug);        
        if($userid == "")
        {
            $userid = $simp_data['user_id'];            
        }
        $post_id = $simp_data['post_id'];
        
        $this->data['userdata'] = $userdata = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");        
        $this->data['leftbox_data'] = $this->user_model->getLeftboxData($userid);
        $this->data['is_userBasicInfo'] = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $this->user_model->is_userStudentInfo($userid);
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['left_footer'] = $this->load->view('leftfooter', $this->data, TRUE);
        $this->data['n_leftbar'] = $this->load->view('n_leftbar', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['post_id'] = $post_id;
        $this->data['title'] = $simp_data['sim_title'].TITLEPOSTFIX;
        $this->data['metadesc'] = '';
        if($this->session->userdata('aileenuser') != "")
        {
            if(isset($simp_data) && !empty($simp_data))
            {
                $this->load->view('user_post/post_details', $this->data);
            }
            else
            {
                $this->data['title'] = "404".TITLEPOSTFIX;
                $this->data['metadesc'] = "404";
                $this->load->view('404', $this->data);
            }
        }
        else
        {
            if(isset($simp_data) && !empty($simp_data))
            {
                $this->load->view('user_post/simplepost_detail', $this->data);
            }
            else
            {
                $this->data['title'] = "404".TITLEPOSTFIX;
                $this->data['metadesc'] = "404";
                $this->load->view('404', $this->data);
            }
        }
    }

    public function save_user_post() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $this->input->post('post_id');

        $save_post_data = $this->db->select('*')->get_where('user_post_save', array('user_id' => $userid,'save_post_id'=>$post_id))->row();

        $data = array();
        if (isset($save_post_data) && !empty($save_post_data)) {
            $data['status'] = '1';
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $updatedata = $this->common->update_data($data, 'user_post_save', 'id_user_post_save', $save_post_data->id_user_post_save);
        } else {
            $data['user_id'] = $userid;
            $data['save_post_id'] = $post_id;
            $data['status'] = '1';
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $save_post_id = $this->common->insert_data_getid($data, 'user_post_save');
        }

        $return_array = array();
        $savedpost_counter = $this->common->userSavedPostCount($userid);
        $return_array['savedpost_counter'] = $this->common->change_number_long_format_to_short($savedpost_counter);
        if ($updatedata || $save_post_id) {
            $return_array['status'] = 1;
        }
        else
        {
            $return_array['status'] = 0;
        }
        echo json_encode($return_array);
    }

    public function getUserSavedPost() {
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }
        $user_slug = $_GET["user_slug"];
        $userid = $this->db->select('user_id')->get_where('user', array('user_slug' => $user_slug))->row('user_id');
        $post_data = $this->user_post_model->getUserSavedPost($userid, $page);
        echo json_encode($post_data);
    }

    public function unsave_user_post() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $this->input->post('post_id');

        $save_post_data = $this->db->select('*')->get_where('user_post_save', array('user_id' => $userid,'save_post_id'=>$post_id))->row();

        $data = array();
        if (isset($save_post_data) && !empty($save_post_data)) {
            $data['status'] = '0';
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $updatedata = $this->common->update_data($data, 'user_post_save', 'id_user_post_save', $save_post_data->id_user_post_save);
        }
        $return_array = array();
        $savedpost_counter = $this->common->userSavedPostCount($userid);
        $return_array['savedpost_counter'] = $this->common->change_number_long_format_to_short($savedpost_counter);
        if ($updatedata) {
            $return_array['status'] = 1;
        }
        else
        {
            $return_array['status'] = 0;
        }
        echo json_encode($return_array);
    }

    public function get_user_monetize()
    {
        $monetize_data = $this->common->get_monetize();
        return $this->output->set_content_type('application/json')->set_output(json_encode($monetize_data));
    }

    public function save_user_post_share()
    {
        $userid = $this->session->userdata('aileenuser');
        $main_id = $this->input->post('post_id');
        $description = $this->input->post('description');
        
        $return_array = array();

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['post_for'] = 'share';
        $insert_data['post_id'] = '';
        $insert_data['created_date'] = date('Y-m-d H:i:s', time());
        $insert_data['status'] = 'draft';
        $insert_data['is_delete'] = '0';

        $id_user_post = $this->common->insert_data_getid($insert_data, 'user_post');
        if($id_user_post > 0)
        {            
            $insert_data = array();
            $sharedpostslug = 'shared-post';
            $shared_post_slug = $this->common->set_slug($sharedpostslug, 'shared_post_slug', 'user_post_share');
            $insert_data['post_id'] = $id_user_post;        
            $insert_data['shared_post_id'] = $main_id;        
            $insert_data['description'] = $description == undefined ? "" : trim($description);
            $insert_data['shared_post_slug'] = $shared_post_slug;
            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

            $id_user_post_share = $this->common->insert_data_getid($insert_data, 'user_post_share');
            if($id_user_post_share > 0)
            {
                $data = array();                
                $data['status'] = 'publish';                
                $data['post_id'] = $id_user_post_share;                
                $this->common->update_data($data, 'user_post', 'id', $id_user_post);
                $return_array['status'] = 1;
            }
            else
            {
                $return_array['status'] = 0;
            }
        }
        else
        {
            $return_array['status'] = 0;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($return_array));
    }

    public function save_user_business_post_share()
    {
        $userid = $this->session->userdata('aileenuser');
        $main_id = $this->input->post('post_id');
        $description = $this->input->post('description');
        
        $return_array = array();

        $insert_data = array();
        $insert_data['user_id'] = $userid;
        $insert_data['post_for'] = 'share';
        $insert_data['post_id'] = '';
        $insert_data['user_type'] = '2';
        $insert_data['created_date'] = date('Y-m-d H:i:s', time());
        $insert_data['status'] = 'draft';
        $insert_data['is_delete'] = '0';

        $id_user_post = $this->common->insert_data_getid($insert_data, 'user_post');
        if($id_user_post > 0)
        {            
            $insert_data = array();
            $sharedpostslug = 'shared-post';
            $shared_post_slug = $this->common->set_slug($sharedpostslug, 'shared_post_slug', 'user_post_share');
            $insert_data['post_id'] = $id_user_post;        
            $insert_data['shared_post_id'] = $main_id;        
            $insert_data['description'] = $description == undefined ? "" : trim($description);
            $insert_data['shared_post_slug'] = $shared_post_slug;
            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());

            $id_user_post_share = $this->common->insert_data_getid($insert_data, 'user_post_share');
            if($id_user_post_share > 0)
            {
                $data = array();                
                $data['status'] = 'publish';                
                $data['post_id'] = $id_user_post_share;                
                $this->common->update_data($data, 'user_post', 'id', $id_user_post);
                $return_array['status'] = 1;
            }
            else
            {
                $return_array['status'] = 0;
            }
        }
        else
        {
            $return_array['status'] = 0;
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($return_array));
    }

    public function edit_save_user_post_share()
    {
        $userid = $this->session->userdata('aileenuser');
        $main_id = $this->input->post('post_id');
        $description = $this->input->post('description');
        $return_array = array();

        $data_share = array(
            'description' => $description == undefined ? "" : trim($description),
            'modify_date' => date('Y-m-d H:i:s', time()),
        );
        $where = array('post_id' =>$main_id);
        $this->db->where($where);
        $updatdata = $this->db->update('user_post_share', $data_share);
        
        $return_array['status'] = 1;

        $this->db->select("*")->from("user_post_share");
        $this->db->where('post_id', $main_id);                
        $query = $this->db->get();
        $share_data = $query->row_array();
        $share_data['description'] = $this->common->make_links(nl2br($share_data['description']));
        $share_data['data'] = $this->user_post_model->get_post_from_id($share_data['shared_post_id']);
        $return_array['share_data'] = $share_data;
        
        return $this->output->set_content_type('application/json')->set_output(json_encode($return_array));
    }
}
