<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_info extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->model('searchelastic_model');
        $this->load->library('S3');
        $this->load->library('inbackground');
    }
    
    public function index() {
        $userid = $this->session->userdata('aileenuser');
        $userdata = $this->data['userdata'] = $this->user_model->getUserSelectedData($userid, $select_data = "u.first_name,u.last_name,ui.user_image");
        $this->data['is_userBasicInfo'] = $is_userBasicInfo = $this->user_model->is_userBasicInfo($userid);
        $this->data['is_userStudentInfo'] = $is_userStudentInfo = $this->user_model->is_userStudentInfo($userid);
        if($is_userBasicInfo == 1 || $is_userStudentInfo == 1)
        {
            redirect(base_url());
        }        
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('footer', $this->data, TRUE);
        $this->data['title'] = "Basic Information | Aileensoul";
        $this->load->view('user_info/index', $this->data);
    }
    
    public function ng_basic_info_insert() {
        $userid = $this->session->userdata('aileenuser');
        $errors = array();
        $data = array();

        $is_userBasicInfo = $this->user_model->is_userBasicInfo($userid);
        $is_userStudentInfo = $this->user_model->is_userStudentInfo($userid);
        if($is_userBasicInfo == 1 || $is_userStudentInfo == 1)
        {
            $errors['acc_exist'] = "1";
        }


        $_POST = json_decode(file_get_contents('php://input'), true);

        if (empty($_POST['jobTitle']))
            $errors['jobTitle'] = 'Job title is required.';

        if (empty($_POST['cityList']))
            $errors['cityList'] = 'City is required.';

        if (!isset($_POST['field']))
            $errors['field'] = 'Field is required.';

        if ($_POST['field'] == '0') {
            if (empty($_POST['otherField']))
                $errors['otherField'] = 'Other field is required.';
        }
        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            $job_title = $_POST['jobTitle'];
            if (is_array($job_title)) {
                $jobTitleId = $job_title['title_id'];
            } else {
                $designation = $this->data_model->findJobTitle($job_title);
                if ($designation['title_id'] != '') {
                    $jobTitleId = $designation['title_id'];
                } else {
                    $data = array();
                    $data['name'] = substr($job_title, 0,200);
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = 'draft';
                    $data['slug'] = $this->common->clean(substr($job_title, 0,200));
                    $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                }
            }
            $city_arr = $_POST['cityList'];
            if (is_array($city_arr)) {
                $cityId = $city_arr['city_id'];
            } else {
                $city_arr = substr($city_arr, 0,200);
                $city = $this->data_model->findCityList($city_arr);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $city_slug = $this->common->set_city_slug(trim($city_arr), 'slug', 'cities');
                    $data['city_name'] = $city_arr;
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $data['city_image'] =  $city_slug.'.png';
                    $data['slug'] = $city_slug;
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
            }

            $otherField = "";
            if ($_POST['field'] == '0') {
                $otherField = substr($_POST['otherField'], 0,300);
            }

            $data = array();
            $data['user_id'] = $userid;
            $data['designation'] = $jobTitleId;
            $data['field'] = $_POST['field'];
            $data['other_field'] = $otherField;
            $data['city'] = $cityId;

            $insert_id = $this->common->insert_data_getid($data, 'user_profession');
            if ($insert_id) {

                $job_title = $this->db->select('name')->get_where('job_title', array('title_id' => $jobTitleId))->row()->name;
                $hashtag = preg_replace("/[^a-zA-Z0-9]/", "", $job_title);
                $hashtag_data = $this->data_model->get_hashtag_id($hashtag);
                if(isset($hashtag_data) && !empty($hashtag_data))
                {                    
                    $data_hashtag = array(
                        'hashtag_id' => $hashtag_data['id'],
                        'user_id' => $userid,
                        'status' => '1',
                        'created_date' => date("Y-m-d h:i:s"),
                        'modify_date' => date("Y-m-d h:i:s"),
                    );
                    $hashtag_id = $this->common->insert_data($data_hashtag, 'hashtag_follow');
                }
                else
                {
                    $data_hashtag1 = array(
                        'hashtag_id' => '3686',//jobs
                        'user_id' => $userid,
                        'status' => '1',
                        'created_date' => date("Y-m-d h:i:s"),
                        'modify_date' => date("Y-m-d h:i:s"),
                    );
                    $hashtag_id = $this->common->insert_data($data_hashtag1, 'hashtag_follow');

                    $data_hashtag2 = array(
                        'hashtag_id' => '3927',//business
                        'user_id' => $userid,
                        'status' => '1',
                        'created_date' => date("Y-m-d h:i:s"),
                        'modify_date' => date("Y-m-d h:i:s"),
                    );
                    $hashtag_id = $this->common->insert_data($data_hashtag2, 'hashtag_follow');

                    $data_hashtag3 = array(
                        'hashtag_id' => '4201',//opportunity
                        'user_id' => $userid,
                        'status' => '1',
                        'created_date' => date("Y-m-d h:i:s"),
                        'modify_date' => date("Y-m-d h:i:s"),
                    );
                    $hashtag_id = $this->common->insert_data($data_hashtag3, 'hashtag_follow');
                }


                $new_people = $this->searchelastic_model->add_edit_single_people($userid);

                $this->userdata['user_data'] = $user_data = $this->user_model->getUserData($userid);
                $fullname = ucwords($user_data['first_name']);
                $to_email_id = $user_data['email'];

                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

                $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                
                $email_html = $this->load->view('email_template/welcome_mail',$this->userdata,TRUE);                

                $subject = $fullname.", Welcome to Aileensoul Platform :)";
                // $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $to_email_id,$unsubscribe);
                $url = base_url()."user_info/send_email_in_background";
                $param = array(
                    "subject"=>$subject,
                    "email_html"=>$email_html,
                    "to_email"=>$to_email_id                    
                );
                $this->inbackground->do_in_background($url, $param);

                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }
        echo json_encode($data);
    }

    public function ng_student_info_insert() {
        $userid = $this->session->userdata('aileenuser');

        $errors = array();
        $data = array();

        $is_userBasicInfo = $this->user_model->is_userBasicInfo($userid);
        $is_userStudentInfo = $this->user_model->is_userStudentInfo($userid);
        if($is_userBasicInfo == 1 || $is_userStudentInfo == 1)
        {
            $errors['acc_exist'] = "1";
        }

        $_POST = json_decode(file_get_contents('php://input'), true);
        // print_r($_POST);exit();
        /*if (empty($_POST['jobTitle']))
            $errors['jobTitle'] = 'Interested field is required.';*/

        if (empty($_POST['currentStudy']))
            $errors['currentStudy'] = 'Current study is required.';

        if (empty($_POST['cityList']))
            $errors['cityList'] = 'City is required.';

        if (empty($_POST['universityName']))
            $errors['universityName'] = 'University name is required.';

        if (!isset($_POST['field']))
            $errors['field'] = 'Field is required.';

        if ($_POST['field'] == '0') {
            if (empty($_POST['otherField']))
                $errors['otherField'] = 'Other field is required.';
        }

        if (!empty($errors)) {
            $data['errors'] = $errors;
        } else {
            $current_study = $_POST['currentStudy'];
            if (is_array($current_study)) {
                $degreeId = $current_study['degree_id'];
            } else {
                $degree = $this->data_model->findDegreeList($current_study);
                if ($degree['degree_id'] != '') {
                    $degreeId = $degree['degree_id'];
                } else {
                    $data = array();
                    $data['degree_name'] = substr($current_study, 0,200);
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $data['user_id'] = $userid;
                    $degreeId = $this->common->insert_data_getid($data, 'degree');
                }
            }
            $city_arr = $_POST['cityList'];
            if (is_array($city_arr)) {
                $cityId = $city_arr['city_id'];
            } else {
                $city_arr = substr($city_arr, 0,300);
                $city = $this->data_model->findCityList($city_arr);
                if ($city['city_id'] != '') {
                    $cityId = $city['city_id'];
                } else {
                    $data = array();
                    $city_slug = $this->common->set_city_slug(trim($city_arr), 'slug', 'cities');
                    $data['city_name'] = $city_arr;
                    $data['state_id'] = '0';
                    $data['status'] = '2';
                    $data['group_id'] = '0';
                    $data['city_image'] =  $city_slug.'.png';
                    $data['slug'] = $city_slug;
                    $cityId = $this->common->insert_data_getid($data, 'cities');
                }
            }
            $university_list = $_POST['universityName'];
            if (is_array($university_list)) {
                $universityId = $university_list['university_id'];
            } else {
                $university_list = substr($university_list, 0,300);
                $university = $this->data_model->findUniversityList($university_list);
                if ($university['university_id'] != '') {
                    $universityId = $university['university_id'];
                } else {
                    $data = array();
                    $data['university_name'] = $university_list;
                    $data['created_date'] = date('Y-m-d H:i:s',time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $universityId = $this->common->insert_data_getid($data, 'university');
                }
            }

            $field = $_POST['field'];
            $otherField = "";
            if ($_POST['field'] == '0') {
                $otherField = substr($_POST['otherField'], 0,300);
            }
            
            $data = array();
            $data['user_id'] = $userid;
            $data['current_study'] = $degreeId;
            $data['city'] = $cityId;
            $data['university_name'] = $universityId;
            $data['interested_fields'] = $field;
            $data['other_interested_fields'] = $otherField;

            $insert_id = $this->common->insert_data_getid($data, 'user_student');
            if ($insert_id) {
                $data_hashtag = array(
                    'hashtag_id' => '3686',
                    'user_id' => $userid,
                    'status' => '1',
                    'created_date' => date("Y-m-d h:i:s"),
                    'modify_date' => date("Y-m-d h:i:s"),
                );
                $insert_id = $this->common->insert_data($data_hashtag, 'hashtag_follow');
                
                $new_people = $this->searchelastic_model->add_edit_single_people($userid);

                $this->userdata['user_data'] = $this->user_model->getUserData($userid);
                $fullname = ucwords($user_data['first_name']);
                $to_email_id = $user_data['email'];

                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

                $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                
                $email_html = $this->load->view('email_template/welcome_mail',$this->userdata,TRUE);                

                $subject = $fullname.", Welcome to Aileensoul Platform :)";

                // $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $to_email_id,$unsubscribe);
                $url = base_url()."user_info/send_email_in_background";
                $param = array(
                    "subject"=>$subject,
                    "email_html"=>$email_html,
                    "to_email"=>$to_email_id                    
                );
                $this->inbackground->do_in_background($url, $param);

                $data['is_success'] = 1;
            } else {
                $data['is_success'] = 0;
            }
        }        
        echo json_encode($data);
    }

    public function autocomplete() {

        $this->load->view('autoselecteasy', $this->data);
    }

    public function send_email_in_background()
    {
        $subject = $this->input->post('subject');
        $email_html = $this->input->post('email_html');
        $to_email = $this->input->post('to_email');
        $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email);        
    }

}
