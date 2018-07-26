<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');

        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        //AWS access info start
        $this->load->library('S3');
        //AWS access info end
        include ('include.php');
        include ('main_profile_link.php');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
        $this->data['userdata'] = $this->user_model->getUserData($userid);        
//      $this->data['userdata'] =  $this->common->select_data_by_id('user', 'user_id', $userid, $data = '*', $join_str = array());
        $this->data['professionData'] = $this->user_model->getUserProfessionData($userid,"*");        
        $this->data['studentData'] = $this->user_model->getUserStudentData($userid,"*");
        $this->data['title'] = 'Setting | Edit Profile - Aileensoul';
        $this->data['usry'] = date('Y', strtotime($this->data['userdata']['user_dob']));
        $this->data['usrm'] = date('m', strtotime($this->data['userdata']['user_dob']));
        $this->data['usrd'] = date('d', strtotime($this->data['userdata']['user_dob']));

        $this->load->view('profile/profile', $this->data);
    }

    public function edit_profile() {

        $id = $this->session->userdata('aileenuser');


        $contition_array = array('user_id' => $id);
        $this->data['userdata'] = $this->common->select_data_by_condition('recruiter', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');



        $this->form_validation->set_rules('first_name', 'first Name', 'required');
        $this->form_validation->set_rules('last_name', 'last Name', 'required');
        $this->form_validation->set_rules('email_profile', ' EmailId', 'required|valid_email');

        $this->form_validation->set_rules('gender', ' gender', 'required');


        $post_data = $this->input->post();
        $date = $this->input->post('selday');
        $month = $this->input->post('selmonth');
        $year = $this->input->post('selyear');

        $dob = $year . '-' . $month . '-' . $date;

        $data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'user_dob' => date('Y-m-d', strtotime($dob)),
            'user_gender' => $this->input->post('gender')
        );
        $updatdata = $this->common->update_data($data, 'user', 'user_id', $id);

        $data_login = array(

                'email' => $this->input->post('email_profile')
        );

        $updatdata1 = $this->common->update_data($data_login, 'user_login', 'user_id', $id);

        if ($updatdata) {
            $this->session->set_flashdata('success', 'Profile information updated successfully');
            // redirect(base_url(), 'refresh');// . $this->session->userdata('aileenuser_slug'), 'refresh');
        } else {
            $this->session->flashdata('error', 'Sorry!! Your data not updated');
            // redirect('profile', 'refresh');
        }
        redirect(base_url());
    }

//User email already exist checking controller start

    public function check_email() {
        $email = $this->input->post('email');
        $userid = $this->session->userdata('aileenuser');
//        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
//        $userdata = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $userdata = $this->user_model->getUserData($userid);
        $email1 = $userdata['email'];
        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1');
            $check_result = $this->common->check_unique_avalibility('user_login', 'email', $email, '', '', $condition_array);
        } else {
            $condition_array = array('is_delete' => '0', 'status' => '1');
            $check_result = $this->common->check_unique_avalibility('user_login', 'email', $email, '', '', $condition_array);
        }
        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

//User email already exist checking controller End


    public function forgot_password() {
        $forgot_email = $this->input->post('forgot_email');


        if ($forgot_email != '') {

            $forgot_email_check = $this->user_model->getUserDataByEmail($forgot_email);
            if (count($forgot_email_check) > 0) {

                $rand_password = $this->random_string(6);


                $email = $forgot_email_check[0]['user_email'];
                $username = $forgot_email_check[0]['user_name'];
                $firstname = $forgot_email_check[0]['first_name'];
                $lastname = $forgot_email_check[0]['last_name'];

                $toemail = $forgot_email;


                $msg .= '<tr>
              <td style="text-align:center; padding:10px 0 30px; font-size:15px;">';
                $msg .= '<p style="margin:0; font-family:arial;">Hi,' . ucwords($firstname) . ' ' . ucwords($lastname) . '</p>
                <p style="padding:25px 0 ; font-family:arial; margin:0;">This is your code: ' . $rand_password . '</p>
                <p><a style="background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
        background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
        font-size:16px;
           color:#fff;
      padding: 7px 12px;
    text-decoration: none;
    font-family: arial;
    letter-spacing: 1px;" class="btn" href="' . base_url() . 'profile/changepassword/' . $forgot_email_check[0]['user_id'] . '">Reset password</a></p>
              </td>
            </tr>';

                $subject = "Forgot password";
                $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $toemail, $subject, $msg);

                $data = array(
                    'password_code' => $rand_password
                );


                $updatdata = $this->common->update_data($data, 'user_login', 'user_id', $forgot_email_check[0]['user_id']);


                $this->session->set_flashdata('success', '<div class="alert alert-success">We have successfully sent a code in provided email address.</div>');
                redirect('login', 'refresh');
            } else {
                $this->session->set_flashdata('error', '<div class="alert alert-danger">Code for new password successfully not send in your email id.</div>');
                redirect('login', 'refresh');
            }
        } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger">Please enter email id.</div>');
            redirect('login', 'refresh');
        }
    }

    public function changepassword($abc) {

        $this->data['user_changeid'] = $abc;
        $this->data['emailid'] = $this->common->select_data_by_id('user', 'user_id', $abc, '*', '');

        $this->data['forgetpassword_header'] = $this->load->view('forgetpassword_header', $this->data, TRUE);


        $this->load->view('profile/change_password', $this->data);
    }

    public function code_check($abc) {
        $code = $this->input->post('code');
        $this->data['userid'] = $userid = $this->input->post('userid');


        $this->data['forgetpassword_header'] = $this->load->view('forgetpassword_header', $this->data, TRUE);

        $checkdata = $this->common->select_data_by_id('user_login', 'user_id', $abc, '*', '');


        if ($checkdata[0]['password_code'] == $code) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

    public function newpassword($abc) {

        $this->data['userid'] = $abc;

        $this->load->view('profile/change_password_view', $this->data);
    }

    public function new_forgetpassword($abc) {
        $new_password = $this->input->post('new_password');

        $data = array(
            'password' => md5($new_password),
            'password_code' => ''
        );


        $updatdata = $this->common->update_data($data, 'user_login', 'user_id', $abc);
        $this->session->set_userdata('aileenuser', $abc);
        // redirect('profiles/' . $this->session->userdata('aileenuser_slug'), refresh);
        redirect(base_url(), refresh);
    }

    public function sendEmail($app_name = '', $app_email = '', $to_email = '', $subject = '', $mail_body = '') {
        //Loading E-mail Class
        $this->load->library('email');

        $emailsetting = $this->common->select_data_by_condition('email_settings', array(), '*');

        $mail_html = '<table width="100%" cellspacing="10" cellpadding="10" style="background:#f1f1f1;" style="border:2px solid #ccc;" >
    <tr>
     <td valign="center"><img src="' . base_url('assets/img/logo.png') . '" alt="' . $this->data['main_site_name'] . '" style="margin:0px auto;display:block;width:150px;"/></td> 
  </tr> 
<tr>
  <td>
     
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <p>
                            "' . $mail_body . '"
                        </p>
    </table>
  </td>
</tr>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
     
      <tr>
      <td style="font-family:Ubuntu, sans-serif;font-size:11px; padding-bottom:15px; padding-top:15px; border-top:1px solid #ccc;text-align:center;background:#eee;"> &copy; ' . date("Y") . ' <a href="' . $this->data['main_site_url'] . '" style="color:#268bb9;text-decoration:none;"> ' . $this->data['main_site_name'] . '</a></td>
      </tr>
</table> 
</table>';

        //Loading E-mail Class
        $config['protocol'] = "smtp";
        $config['smtp_host'] = $emailsetting[0]['host_name'];
        $config['smtp_port'] = $emailsetting[0]['out_going_port'];
        $config['smtp_user'] = $emailsetting[0]['user_name'];
        $config['smtp_pass'] = $emailsetting[0]['password'];
        $config['smtp_rec_email'] = $emailsetting[0]['receiver_email'];
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $this->email->initialize($config);
        $this->email->from($config['smtp_user'], $app_name);
        $this->email->to($to_email);
        $this->email->subject($subject);
        $this->email->message(html_entity_decode($mail_body));

        if ($this->email->send()) {
            return true;
        } else {
            return FALSE;
        }
    }

    public function login() {


        $this->load->view('profile/rec_forgott_password', $this->data);
    }

    public function random_string($length = 5, $allowed_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890') {
        $allowed_chars_len = strlen($allowed_chars);

        if ($allowed_chars_len == 1) {
            return str_pad('', $length, $allowed_chars);
        } else {
            $result = '';

            while (strlen($result) < $length) {
                $result .= substr($allowed_chars, rand(0, $allowed_chars_len), 1);
            } // while

            return $result;
        }
    }

    public function check_emailforget() {

        $email_reg = $this->input->post('email_reg');
        // $contition_array = array('is_delete' => '0', 'status' => '1');
        // $userdata = $this->common->select_data_by_condition('user', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $condition_array = array('is_delete' => '0', 'status' => '1');

        $check_result = $this->common->check_unique_avalibility('user_login', 'email', $email_reg, '', '', $condition_array);

        if ($check_result) {
            echo 'false';
            die();
        } else {
            echo 'true';
            die();
        }
    }

    public function forgot_live() {
        $forgot_email = $this->input->post('forgot_email');


        if ($forgot_email != '') {

            $forgot_email_check = $this->user_model->getUserDataByEmail($forgot_email);


            if (count($forgot_email_check) > 0) {

                $rand_password = $this->random_string(6);


                $email = $forgot_email_check[0]['email'];
                $username = $forgot_email_check[0]['user_name'];
                $firstname = $forgot_email_check[0]['first_name'];
                $lastname = $forgot_email_check[0]['last_name'];

                $toemail = $forgot_email;

                $msg .= '<tr>
              <td style="text-align:center; padding:10px 0 30px; font-size:15px;">';
                $msg .= '<p style="margin:0; font-family:arial;">Hi,' . ucwords($firstname) . ' ' . ucwords($lastname) . '</p>
                <p style="padding:25px 0 ; font-family:arial; margin:0;">This is your code: ' . $rand_password . '</p>
                <p><a style="background: -moz-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #3bb0ac), color-stop(56%, #1b8ab9), color-stop(100%, #1b8ab9));
        background: -webkit-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -o-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: -ms-linear-gradient(96deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        background: linear-gradient(354deg, #1b8ab9 0%, #1b8ab9 44%, #3bb0ac 100%); 
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#3bb0ac", endColorstr="#1b8ab9",GradientType=0 );
        font-size:16px;
           color:#fff;
      padding: 7px 12px;
    text-decoration: none;
    font-family: arial;
    letter-spacing: 1px;" class="btn" href="' . base_url() . 'profile/changepassword/' . $forgot_email_check[0]['user_id'] . '">Reset password</a></p>
              </td>
            </tr>';

                $subject = "Forgot password";

                $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $toemail, $subject, $msg);
                $data = array(
                    'password_code' => $rand_password
                );


                $updatdata = $this->common->update_data($data, 'user_login', 'user_id', $forgot_email_check[0]['user_id']);


                echo json_encode(
                        array(
                            "data" => 'success',
                            "message" => '<div class="alert alert-success">We have successfully sent a code on  provided email address.</div>',
                ));
            } else {

                echo json_encode(
                        array(
                            "data" => 'error',
                            "message" => '<div class="alert alert-danger">we have not sent a code on provided email address
.</div>',
                ));
            }
        } else {

            echo json_encode(
                    array(
                        "data" => 'error',
                        "message" => '<div class="alert alert-danger">Please enter email id.</div>',
            ));
        }
    }

    public function edit_basic_info() {

        $userid = $this->session->userdata('aileenuser');

        $this->form_validation->set_rules('job_title', 'Job title', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('field', 'Field', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $userid = $this->session->userdata('aileenuser');
            $this->data['userdata'] = $this->user_model->getUserData($userid);
            $this->data['professionData'] = $this->user_model->getUserProfessionData($userid,"*");        
            $this->data['studentData'] = $this->user_model->getUserStudentData($userid,"*");
            
            $this->data['title'] = 'Setting | Edit Profile - Aileensoul';
            $this->data['usry'] = date('Y', strtotime($this->data['userdata']['user_dob']));
            $this->data['usrm'] = date('m', strtotime($this->data['userdata']['user_dob']));
            $this->data['usrd'] = date('d', strtotime($this->data['userdata']['user_dob']));

            $this->load->view('profile/profile', $this->data);
            //$this->load->view('profile/profile', $this->data);
        }
        else
        {
            $userid = $this->session->userdata('aileenuser');            
            $professionData = $this->user_model->getUserProfessionData($userid,"*");            
            $job_title = $this->input->post('job_title');
            $city = $this->input->post('city');
            $field = $this->input->post('field');
            if($field == 0)
            {
                $other_field = $this->input->post('other_field');
            }
            else
            {
                $other_field = "";
            }
            // job title start   
            if ($job_title != " ") {
                $contition_array = array('name' => $job_title);
                $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($jobdata) {
                    $jobTitleId = $jobdata[0]['title_id'];
                } else {
                    $forslug = $this->input->post('job_title');
                    $data = array(
                        'name' => ucfirst($this->input->post('job_title')),
                        'slug' => $this->common->clean($forslug),
                        'status' => 'draft',
                    );
                    if ($userid) {
                        $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                    }
                }
            }
            $cityId = "";

            if ($city != "")
            {
                $contition_array = array('LOWER(city_name)' => strtolower(trim($city)));
                $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($citydata) {
                    $cityId .= $citydata[0]['city_id'];
                } else {
                    $data = array(
                        'city_name' => trim($city),
                        'status' => '1',
                    );
                    if ($userid) {
                        $cityId .= $this->common->insert_data_getid($data, 'cities');
                    }
                }
            }
            

            $studentData = $this->user_model->getUserStudentData($userid,"*");
            if(isset($studentData) && !empty($studentData))
            {
                $this->common->delete_data('user_student', 'id', $studentData['id']);
            }

            $data_user = array(
                'is_student' => '0',
            );
            $updatdata_user = $this->common->update_data($data_user, 'user', 'user_id', $userid);

            $data_up = array(
                'designation' => $jobTitleId,
                'field' => $field,
                'other_field' => $other_field,
                'city' => $cityId,
            );
            if(isset($professionData) && !empty($professionData))
            {                
                $id = $professionData['id'];
                $updatdata_up = $this->common->update_data($data_up, 'user_profession', 'id', $id);
            }
            else
            {
                $data_up['user_id'] = $userid;
                $updatdata_up = $this->common->insert_data_getid($data_up, 'user_profession');
            }
            redirect(base_url()."edit-profile");
        }
        //print_r($this->input->post());exit;
    }

    public function edit_stud_info() {
        $userid = $this->session->userdata('aileenuser');
        $this->form_validation->set_rules('currentStudy', 'Current Study', 'required');
        $this->form_validation->set_rules('studcity', 'City', 'required');
        $this->form_validation->set_rules('university', 'University', 'required');
        $this->form_validation->set_rules('studjob_title', 'Field', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $userid = $this->session->userdata('aileenuser');
            $this->data['userdata'] = $this->user_model->getUserData($userid);
            $this->data['professionData'] = $this->user_model->getUserProfessionData($userid,"*");        
            $this->data['studentData'] = $this->user_model->getUserStudentData($userid,"*");
            
            $this->data['title'] = 'Setting | Edit Profile - Aileensoul';
            $this->data['usry'] = date('Y', strtotime($this->data['userdata']['user_dob']));
            $this->data['usrm'] = date('m', strtotime($this->data['userdata']['user_dob']));
            $this->data['usrd'] = date('d', strtotime($this->data['userdata']['user_dob']));

            $this->load->view('profile/profile', $this->data);
            //$this->load->view('profile/profile', $this->data);
        }
        else
        {
            $userid = $this->session->userdata('aileenuser');            
            $studentData = $this->user_model->getUserStudentData($userid,"*");
            //$professionData = $this->user_model->getUserProfessionData($userid,"*");            
            $currentStudy = $this->input->post('currentStudy');
            $studcity = $this->input->post('studcity');
            $university = $this->input->post('university');
            $field = $this->input->post('studjob_title');

            if ($currentStudy != "")
            {
                $contition_array = array('LOWER(degree_name)' => strtolower(trim($currentStudy)));
                $currentStudydata = $this->common->select_data_by_condition('degree', $contition_array, $data = 'degree_id,degree_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                
                if ($currentStudydata) {
                    $currentStudyId = $currentStudydata[0]['degree_id'];
                } else {
                    $data = array();
                    $data['degree_name'] = $currentStudy;
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $data['user_id'] = $userid;
                    $currentStudyId = $this->common->insert_data_getid($data, 'degree');
                }
            }

            if ($studcity != "")
            {
                $contition_array = array('LOWER(city_name)' => strtolower(trim($studcity)));
                $citydata = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($citydata) {
                    $cityId = $citydata[0]['city_id'];
                } else {
                    $data = array(
                        'city_name' => trim($studcity),
                        'status' => '1',
                    );
                    if ($userid) {
                        $cityId = $this->common->insert_data_getid($data, 'cities');
                    }
                }
            }
            if ($university != "")
            {

                $universityData = $this->data_model->findUniversityList($university);
                if ($universityData['university_id'] != '') {
                    $universityId = $universityData['university_id'];
                } else {
                    $data = array();
                    $data['university_name'] = $university;
                    $data['created_date'] = date('Y-m-d H:i:s',time());
                    $data['status'] = '2';
                    $data['is_delete'] = '0';
                    $data['is_other'] = '1';
                    $universityId = $this->common->insert_data_getid($data, 'university');
                }
            }

            // job title start   
            if ($field != " ") {
                $contition_array = array('name' => $field);
                $jobdata = $this->common->select_data_by_condition('job_title', $contition_array, $data = 'title_id,name', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                if ($jobdata) {
                    $jobTitleId = $jobdata[0]['title_id'];
                } else {
                    $forslug = $this->input->post('studjob_title');
                    $data = array(
                        'name' => ucfirst($this->input->post('studjob_title')),
                        'slug' => $this->common->clean($forslug),
                        'status' => 'draft',
                    );
                    if ($userid) {
                        $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                    }
                }
            }

            

            $professionData = $this->user_model->getUserProfessionData($userid,"*");            
            if(isset($professionData) && !empty($professionData))
            {
                $this->common->delete_data('user_profession', 'id', $professionData['id']);
            }

            $data_user = array(
                'is_student' => '1',
            );
            $updatdata_user = $this->common->update_data($data_user, 'user', 'user_id', $userid);

            $data_up = array(
                'current_study' => $currentStudyId,
                'city' => $cityId,
                'university_name' => $universityId,
                'interested_fields' => $jobTitleId,
            );
            if(isset($studentData) && !empty($studentData))
            {                
                $id = $studentData['id'];
                $updatdata_up = $this->common->update_data($data_up, 'user_student', 'id', $id);
            }
            else
            {
                $data_up['user_id'] = $userid;
                $updatdata_up = $this->common->insert_data_getid($data_up, 'user_student');
            }
            redirect(base_url());
        }
        // print_r($this->input->post());exit;
    }

}
