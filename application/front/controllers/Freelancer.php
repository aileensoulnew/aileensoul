<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Freelancer extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->model('freelancer_apply_model');
        $this->load->model('freelancer_hire_model');
        $this->lang->load('message', 'english');
        $this->load->library('upload');
        $this->load->library('S3');
        include ('main_profile_link.php');
        include ('freelancer_include.php');
        include "openfireapi/vendor/autoload.php";
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
       
        $this->data['title'] = "Hire Freelancers and Find Online Freelance Jobs| Aileensoul";
        $this->data['metadesc'] = "Choose if you want to hire freelancer or become a freelancer. And register yourself. Join now! It's Free.";
        $this->data['freelance_hire_link'] = $this->freelance_hire_profile_link ;
        $this->data['freelance_apply_profile_link'] = $this->freelance_hire_profile_link ;
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        $this->data['login_footer'] = $this->load->view('login_footer', $this->data, TRUE);
        $this->load->view('freelancer_live/freelancer_main', $this->data);
    }

    public function freelancer_post() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'status' => '0');
        $freelancerpostdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($freelancerpostdata) {
            $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
            $this->load->view('freelancer_live/freelancer_post/reactivate', $this->data);
        } else {

            $userid = $this->session->userdata('aileenuser');

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            if ($jobdata[0]['free_post_step'] == 1) {
                redirect('freelancer/address-information', refresh);
            } else if ($jobdata[0]['free_post_step'] == 2) {
                redirect('freelancer/professional-information', refresh);
            } else if ($jobdata[0]['free_post_step'] == 3) {
                redirect('freelancer/rate', refresh);
            } else if ($jobdata[0]['free_post_step'] == 4) {
                redirect('freelancer/availability', refresh);
            } else if ($jobdata[0]['free_post_step'] == 5) {
                redirect('freelancer/education', refresh);
            } else if ($jobdata[0]['free_post_step'] == 6) {
                redirect('freelancer/portfolio', refresh);
            } else if ($jobdata[0]['free_post_step'] == 7) {
                redirect('freelance-work/home', refresh);
            } else {
                redirect('freelancer/signup', refresh);
            }
        }
    }

    //freelancer workexp first  info page controller start

    public function freelancer_post_basic_information($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_email,freelancer_post_skypeid,freelancer_post_phoneno,free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];

            if ($step == 1 || $step > 1) {

                $this->data['firstname1'] = $userdata[0]['freelancer_post_fullname'];
                $this->data['lastname1'] = $userdata[0]['freelancer_post_username'];
                $this->data['email1'] = $userdata[0]['freelancer_post_email'];
                $this->data['skypeid1'] = $userdata[0]['freelancer_post_skypeid'];
                $this->data['phoneno1'] = $userdata[0]['freelancer_post_phoneno'];
            }
        }

        $this->data['title'] = "Basic Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_basic_information', $this->data);
    }


    //FREELANCER_APPLY POST_BASIC_INFORMATION PAGE DATA INSERT START
    public function freelancer_post_basic_information_insert() {


        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');


        $this->form_validation->set_rules('firstname', 'Full Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'EmailId', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('freelancer/freelancer_post/freelancer_post_basic_information');
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'free_post_step,freelancer_post_fullname,freelancer_post_username,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $first_lastname = trim($this->input->post('firstname')) . " " . trim($this->input->post('lastname'));

            if ($userdata) {
                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 1) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '1'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                }

                $data = array(
                    'freelancer_post_fullname' => trim($this->input->post('firstname')),
                    'freelancer_post_username' => trim($this->input->post('lastname')),
                    'freelancer_post_skypeid' => trim($this->input->post('skypeid')),
                    'freelancer_post_email' => trim($this->input->post('email')),
                    'freelancer_post_phoneno' => trim($this->input->post('phoneno')),
                    // 'freelancer_apply_slug' => $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg'),
                    'user_id' => $userid,
                    'modify_date' => date('Y-m-d', time())
                );

                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                if ($updatedata) {
                    if ($postid) {
                        redirect('freelancer/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/address-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelancer/basic-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/basic-information', refresh);
                    }
                }
            } else {

                $data = array(
                    'freelancer_post_fullname' => trim($this->input->post('firstname')),
                    'freelancer_post_username' => trim($this->input->post('lastname')),
                    'freelancer_post_skypeid' => trim($this->input->post('skypeid')),
                    'freelancer_post_email' => trim($this->input->post('email')),
                    'freelancer_post_phoneno' => trim($this->input->post('phoneno')),
                    'freelancer_apply_slug' => $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg'),
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'free_post_step' => '1'
                );

                $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');
                $insert_id1 = $this->common->insert_data_getid($data, 'freelancer_post_reg_search_tmp');
                if ($insert_id) {
                    if ($postid) {
                        redirect('freelancer/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/address-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelancer/basic-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/basic-information', refresh);
                    }
                }
            }
        }
    }

    //FREELANCER_APPLY POST_BASIC_INFORMATION PAGE DATA INSERT END
    // FREELANCER_HIRE SLUG START
    public function setcategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $slugname = $oldslugname = $this->create_slug($slugname);
        $i = 1;
        while ($this->comparecategory_slug($slugname, $filedname, $tablename, $notin_id) > 0) {
            $slugname = $oldslugname . '-' . $i;
            $i++;
        }return $slugname;
    }

    public function comparecategory_slug($slugname, $filedname, $tablename, $notin_id = array()) {
        $this->db->where($filedname, $slugname);
        if (isset($notin_id) && $notin_id != "" && count($notin_id) > 0 && !empty($notin_id)) {
            $this->db->where($notin_id);
        }
        $num_rows = $this->db->count_all_results($tablename);
        return $num_rows;
    }

    public function create_slug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(stripslashes($string)));
        $slug = preg_replace('/[-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    // FREELANCER HIRE SLUG END

    function slug_script() {

        $this->db->select('freelancer_post_reg_id,freelancer_post_fullname,freelancer_post_username');
        $res = $this->db->get('freelancer_post_reg')->result();
        foreach ($res as $k => $v) {
            $data = array('freelancer_apply_slug' => $this->setcategory_slug($v->freelancer_post_fullname . " " . $v->freelancer_post_username, 'freelancer_apply_slug', 'freelancer_post_reg'));
            $this->db->where('freelancer_post_reg_id', $v->freelancer_post_reg_id);
            $this->db->update('freelancer_post_reg', $data);
        }
        echo "yes";
    }

    //CHECK EMAIL AVAIBILITY OF FREELANCER_APPLY START 
    public function check_email() {

        $email = trim($this->input->post('email'));
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $email1 = $userdata[0]['freelancer_post_email'];
        if ($email1) {
            $condition_array = array('is_delete' => '0', 'user_id !=' => $userid, 'status' => '1');
            $check_result = $this->common->check_unique_avalibility('freelancer_post_reg', 'freelancer_post_email', $email, '', '', $condition_array);
        } else {
            $condition_array = array('is_delete' => '0');
            $check_result = $this->common->check_unique_avalibility('freelancer_post_reg', 'freelancer_post_email', $email, '', '', $condition_array);
        }

        if ($check_result) {
            echo 'true';
            die();
        } else {
            echo 'false';
            die();
        }
    }

    //CHECK EMAIL AVAIBILITY OF FREELANCER_APPLY END
    //FREELANCER_APPLY USER DEACTIAVTE CHECK START
    public function freelancer_apply_deactivate_check() {
        $userid = $this->session->userdata('aileenuser');
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO freelancer/freelancer_post/freelancer_post_basic_information START
        $contition_array = array('user_id' => $userid, 'status' => '0', 'is_delete' => '0');
        $freelancerpost_deactive = $this->data['freelancerpost_deactive'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if ($freelancerpost_deactive) {
            redirect('freelance-jobs');
        }
        //IF USER DEACTIVATE PROFILE THEN REDIRECT TO freelancer/freelancer_post/freelancer_post_basic_information END  
    }
    //FREELANCER_APPLY USER DEACTIAVTE CHECK START
    //FREELANCER_APPLY ADDRESS PAGE START
    public function freelancer_post_address_information($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //USER DATA FETCH
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_country,freelancer_post_state,freelancer_post_city,freelancer_post_pincode,free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //FOR GETTING STATE DATA
        $contition_array = array('status' => '1', 'country_id' => $userdata[0]['freelancer_post_country']);
        $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = 'state_id,state_name', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //FOR GETTING CITY DATA 
        $contition_array = array('status' => '1', 'state_id' => $userdata[0]['freelancer_post_state']);
        $this->data['cities'] = $this->common->select_data_by_condition('cities', $contition_array, $data = 'city_id,city_name', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 2 || $step > 2 || ($step >= 1 && $step <= 2)) {
                $this->data['country1'] = $userdata[0]['freelancer_post_country'];
                $this->data['state1'] = $userdata[0]['freelancer_post_state'];
                $this->data['city1'] = $userdata[0]['freelancer_post_city'];
                $this->data['pincode1'] = $userdata[0]['freelancer_post_pincode'];
            }
        }
        $this->data['title'] = "Address Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_address_information', $this->data);
    }

    //FREELANCER_APPLY ADDRESS PAGE END
    //FUNCTION FOR GET DATA OF STATE AND CITY START
    public function ajax_data() {
        // ajax for degree start
        if (isset($_POST["degree_id"]) && !empty($_POST["degree_id"])) {
            //Get all state data
            $contition_array = array('degree_id' => $_POST["degree_id"], 'status' => '1');
            $stream = $this->data['stream'] = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            //Count total number of rows
            //Display states list
            if (count($stream) > 0) {
                echo '<option value="">Select stream</option>';
                foreach ($stream as $st) {
                    echo '<option value="' . $st['stream_id'] . '">' . $st['stream_name'] . '</option>';
                }
            } else {
                echo '<option value="">Stream not available</option>';
            }
        }

        // ajax for degree end
        // ajax for country start
        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
            //Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
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
        // ajax for country end
        // ajax for state start
        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
            //Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => 1);
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
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
        // ajax for state end
    }

    //FUNCTION FOR GET DATA OF STATE AND CITY END
    //FREELANCER_APPLY ADDRESS INFORMATION INSERT CODE START
    public function freelancer_post_address_information_insert() {
        $userid = $this->session->userdata('aileenuser');

        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

       // if ($this->input->post('next')) {
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('freelancer/freelancer_post/freelancer_post_address_information');
            } else {
                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 2) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '2'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                }
                $data = array(
                    'freelancer_post_country' => trim($this->input->post('country')),
                    'freelancer_post_state' => trim($this->input->post('state')),
                    'freelancer_post_city' => trim($this->input->post('city')),
                    'freelancer_post_pincode' => trim($this->input->post('pincode')),
                    'modify_date' => date('Y-m-d', time())
                );
                $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                if ($updatdata) {
                    if(trim($data['freelancer_post_country']) != "")
                    {
                        $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                        $data['country_name'] = trim($country_name);
                    }

                    if(trim($data['freelancer_post_state']) != "")
                    {
                        $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                        $data['state_name'] = trim($state_name);
                    }

                    if(trim($data['freelancer_post_city']) != "")
                    {
                        $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                        $data['city_name'] = trim($city_name);
                    } 
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                    if ($postid) {
                        redirect('freelancer/professional-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/professional-information', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelancer/address-information/' . $postid, refresh);
                    } else {
                        redirect('freelancer/address-information', refresh);
                    }
                }
            }
       // }
    }

    //FREELANCER_APPLY ADDRESS INFORMATION INSERT CODE END
    //FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION PAGE START
    //freelancer professional page controller Start
    public function freelancer_post_professional_information($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_field,freelancer_post_area,freelancer_post_otherskill,freelancer_post_skill_description,freelancer_post_exp_year,freelancer_post_exp_month,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //Retrieve skill data Start
        $skill_know = explode(',', $userdata[0]['freelancer_post_area']);
        foreach ($skill_know as $sk) {
            $contition_array = array('skill_id' => $sk, 'status' => '1');
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            $detailes[] = $skilldata[0]['skill'];
        }
        $this->data['skill_2'] = implode(',', $detailes);
        //Retrieve skill data End

        $contition_array = array('status' => '1', 'is_other' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting univesity data End
        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 3 || ($step >= 1 && $step <= 3) || $step > 3) {
                $this->data['fields_req1'] = $userdata[0]['freelancer_post_field'];
                $this->data['area1'] = $userdata[0]['freelancer_post_area'];
                $this->data['otherskill1'] = $userdata[0]['freelancer_post_otherskill'];
                $this->data['skill_description1'] = $userdata[0]['freelancer_post_skill_description'];
                $this->data['experience_year1'] = $userdata[0]['freelancer_post_exp_year'];
                $this->data['experience_month1'] = $userdata[0]['freelancer_post_exp_month'];
            }
        }
        $this->data['title'] = "Professional Information | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_professional_information', $this->data);
    }

    //FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION PAGE START
    //FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION INSERT DATA START
    public function freelancer_post_professional_information_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');
        $skill1 = $this->input->post('skills');
        $skills = explode(',', $skill1);

        //if ($this->input->post('next')) {
            $this->form_validation->set_rules('field', 'Field', 'required');
            $this->form_validation->set_rules('skill_description', 'Skill Description', 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('freelancer/freelancer_post/freelancer_post_professional_information');
            } else {

                $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
                $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($userdata[0]['free_post_step'] == 7) {
                    $data = array(
                        'free_post_step' => '7'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else if ($userdata[0]['free_post_step'] > 3) {
                    $data = array(
                        'free_post_step' => $userdata[0]['free_post_step']
                    );

                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                } else {
                    $data = array(
                        'free_post_step' => '3'
                    );
                    $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                }
                if (count($skills) > 0) {
                    foreach ($skills as $ski) {
                        if (trim($ski) != "") {
                            $contition_array = array('skill' => trim($ski), 'type' => '1');
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            if (count($skilldata) < 0) {
                                $contition_array = array('skill' => trim($ski), 'type' => '5');
                                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            }
                            if ($skilldata) {
                                $skill[] = $skilldata[0]['skill_id'];
                            } else {
                                $data = array(
                                    'skill' => trim($ski),
                                    'status' => '1',
                                    'type' => '5',
                                    'user_id' => $userid,
                                );
                                $skill[] = $this->common->insert_data_getid($data, 'skill');
                            }
                        }
                    }
                    $skill = array_unique($skill, SORT_REGULAR);
                    $skills = implode(',', $skill);
                }
                $data = array(
                    'freelancer_post_field' => trim($this->input->post('field')),
                    'freelancer_post_area' => $skills,
                    'freelancer_post_otherskill' => trim($this->input->post('otherskill')),
                    'freelancer_post_skill_description' => trim($this->input->post('skill_description')),
                    'freelancer_post_exp_month' => trim($this->input->post('experience_month')),
                    'freelancer_post_exp_year' => trim($this->input->post('experience_year')),
                    'modify_date' => date('Y-m-d', time())
                );
                $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                if ($updatdata) {

                    if(trim($data['freelancer_post_field']) != "")
                    {
                        $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                        $data['freelancer_post_field_txt'] = trim($field_name);
                    }            

                    if($data['freelancer_post_area'] != "")
                    {
                        $skill_name = "";
                        foreach (explode(',',$data['freelancer_post_area']) as $skk => $skv) {
                            if($skv != "" && $skv != "26")
                            {
                                $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                                if(trim($s_name) != "")
                                {
                                    $skill_name .= $s_name.",";
                                }
                            }
                        }
                        $data['freelancer_post_area_txt'] = trim($skill_name,",");
                    }
                    $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
                    if ($postid) {
                        redirect('freelancer/rate/' . $postid, refresh);
                    } else {
                        redirect('freelancer/rate', refresh);
                    }
                } else {
                    if ($postid) {
                        redirect('freelancer/rate/' . $postid, refresh);
                    } else {
                        redirect('freelancer/rate', refresh);
                    }
                }
            }
        //}
    }

    //FREELANCER_APPLY POST_PROFESSIONAL_INFORMATION INSERT DATA END
    //FREELANCER_APPLY RATE PAGE START
    //freelancer rate page controller Start 
    public function freelancer_post_rate($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('status' => '1', 'is_delete' => '0');
        $this->data['currency'] = $this->common->select_data_by_condition('currency', $contition_array, $data = '*', $sortby = 'currency_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_hourly,freelancer_post_ratestate,freelancer_post_fixed_rate,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 4 || ($step >= 1 && $step <= 4) || $step > 4) {
                $this->data['hourly1'] = $userdata[0]['freelancer_post_hourly'];
                $this->data['currency1'] = $userdata[0]['freelancer_post_ratestate'];
                $this->data['fixed_rate1'] = $userdata[0]['freelancer_post_fixed_rate'];
            }
        }
        $this->data['title'] = "Rate | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_rate', $this->data);
    }

    //FREELANCER_APPLY RATE PAGE END
    //FREELANCER_APPLY RATE PAGE DATA INSERT START
    public function freelancer_post_rate_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }
        $userid = $this->session->userdata('aileenuser');

       // if ($this->input->post('next')) {
            if ($this->input->post('fixed_rate') == 1) {
                $data = array(
                    'freelancer_post_fixed_rate' => trim($this->input->post('fixed_rate')),
                );
            } else {
                $data = array(
                    'freelancer_post_fixed_rate' => '0',
                );
            }
            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata[0]['free_post_step'] == 7) {
                $data = array(
                    'free_post_step' => '7'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            } else if ($userdata[0]['free_post_step'] > 4) {
                $data = array(
                    'free_post_step' => $userdata[0]['free_post_step']
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            } else {
                $data = array(
                    'free_post_step' => '4'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            }
            $data = array(
                'freelancer_post_hourly' => trim($this->input->post('hourly')),
                'freelancer_post_ratestate' => trim($this->input->post('state')),
                'modify_date' => date('Y-m-d', time())
            );
            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            if ($updatdata) {
                // $this->session->set_flashdata('success', 'Rate information updated successfully');
                if ($postid) {
                    redirect('freelancer/availability/' . $postid, refresh);
                } else {
                    redirect('freelancer/availability', refresh);
                }
            } else {
                //  $this->session->flashdata('error', 'Your data not inserted');
                if ($postid) {
                    redirect('freelancer/rate/' . $postid, refresh);
                } else {
                    redirect('freelancer/rate', refresh);
                }
            }
       // }
    }

    //FREELANCER_APPLY RATE PAGE DATA INSERT END
    //FREELANCER_APPLY AVABILITY PAGE START
    //freelancer avability page controller Start
    public function freelancer_post_avability($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_job_type,freelancer_post_work_hour,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];

            if ($step == 5 || ($step >= 1 && $step <= 5) || $step > 5) {

                $this->data['job_type1'] = $userdata[0]['freelancer_post_job_type'];
                $this->data['work_hour1'] = $userdata[0]['freelancer_post_work_hour'];
            }
        }
        $this->data['title'] = "Avability | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_avability', $this->data);
    }

    //FREELANCER_APPLY AVABILITY PAGE END
    //FREELANCER_APPLY AVABILITY PAGE DATA INSERT START
    public function freelancer_post_avability_insert() {
        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }
        $userid = $this->session->userdata('aileenuser');
        if ($this->input->post('previous')) {
            redirect('freelancer/freelancer_post_rate', refresh);
        }

        //if ($this->input->post('next')) {
            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata[0]['free_post_step'] == 7) {
                $data = array(
                    'free_post_step' => '7'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            } else if ($userdata[0]['free_post_step'] > 5) {
                $data = array(
                    'free_post_step' => $userdata[0]['free_post_step']
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            } else {
                $data = array(
                    'free_post_step' => '5'
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
                $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            }
            $data = array(
                'freelancer_post_job_type' => trim($this->input->post('job_type')),
                'freelancer_post_work_hour' => trim($this->input->post('work_hour')),
                'modify_date' => date('Y-m-d', time())
            );

            $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            if ($updatdata) {
                if ($postid) {
                    redirect('freelancer/education/' . $postid, refresh);
                } else {
                    redirect('freelancer/education', refresh);
                }
            } else {
                if ($postid) {
                    redirect('freelancer/availability/' . $postid, refresh);
                } else {
                    redirect('freelancer/availability', refresh);
                }
            }
      //  }
    }

    //FREELANCER_APPLY AVABILITY PAGE DATA INSERT END
    //FREELANCER_APPLY EDUCATION PAGE START
    public function freelancer_post_education($postid = '') {

        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        //for getting degree data Strat
        $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other", 'degree_name !=' => "", 'status' => "1");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $degree_data = $this->data['degree_data'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_delete' => '0', 'degree_name' => "Other");
        $this->data['degree_otherdata'] = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting degree data End
        //For getting all Stream Strat
        $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1')) AND stream_name != 'Others'";
        $stream_alldata = $this->data['stream_alldata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');


        $contition_array = array('status' => '1', 'is_delete' => '0', 'stream_name' => "Other");
        $stream_otherdata = $this->data['stream_otherdata'] = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = 'stream_name');
        //For getting all Stream End
        //for getting univesity data Start
        $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $university_data = $this->data['university_data'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'university_name' => "Other");
        $this->data['university_otherdata'] = $this->common->select_data_by_condition('university', $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        //for getting univesity data End
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_degree,freelancer_post_stream,freelancer_post_univercity,freelancer_post_collage,freelancer_post_percentage,freelancer_post_passingyear,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 6 || ($step >= 1 && $step <= 6) || $step > 6) {
                $this->data['degree1'] = $userdata[0]['freelancer_post_degree'];
                $this->data['stream1'] = $userdata[0]['freelancer_post_stream'];
                $this->data['university1'] = $userdata[0]['freelancer_post_univercity'];
                $this->data['college1'] = $userdata[0]['freelancer_post_collage'];
                $this->data['percentage1'] = $userdata[0]['freelancer_post_percentage'];
                $this->data['pass_year1'] = $userdata[0]['freelancer_post_passingyear'];
            }
        }
        $this->data['title'] = "Eduction | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_education', $this->data);
    }

    //FREELANCER_APPLY EDUCATION PAGE END
    //ADD OTHER UNIVERSITY INTO DATABASE START
    public function freelancer_other_university() {
        $other_university = $_POST['other_university'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'university_name' => $other_university);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_university != NULL) {
            if ($count == 0) {
                $data = array(
                    'university_name' => $other_university,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'university');
                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'university_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $university = $this->data['university'] = $this->common->select_data_by_search('university', $search_condition, $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    if (count($university) > 0) {
                        $select = '<option value="" selected option disabled>Select your University</option>';
                        foreach ($university as $st) {
                            $select .= '<option value="' . $st['university_id'] . '"';
                            if ($st['university_name'] == $other_university) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['university_name'] . '</option>';
                        }
                    }
            //For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'university_name' => "Other");
                    $university_otherdata = $this->common->select_data_by_condition('university', $contition_array, $data = '*', $sortby = 'university_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $select .= '<option value="' . $university_otherdata[0]['university_id'] . '">' . $university_otherdata[0]['university_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }
        echo json_encode(array(
            "select" => $select,
        ));
    }

    //ADD OTHER UNIVERSITY INTO DATABASE END
    //FREELANCER_APPLY EDUCATION PAGE DATA INSERT START
    public function freelancer_post_education_insert() {

        if ($this->input->post('livepostid')) {
            $postid = trim($this->input->post('livepostid'));
        }

        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if ($userdata[0]['free_post_step'] == 7) {
            $data = array(
                'free_post_step' => '7'
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
        } else if ($userdata[0]['free_post_step'] > 6) {
            $data = array(
                'free_post_step' => $userdata[0]['free_post_step']
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
        } else {
            $data = array(
                'free_post_step' => '6'
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
        }
        $data = array(
            'freelancer_post_degree' => trim($this->input->post('degree')),
            'freelancer_post_stream' => trim($this->input->post('stream')),
            'freelancer_post_univercity' => trim($this->input->post('university')),
            'freelancer_post_collage' => trim($this->input->post('college')),
            'freelancer_post_percentage' => trim($this->input->post('percentage')),
            'freelancer_post_passingyear' => trim($this->input->post('passingyear')),
            'modify_date' => date('Y-m-d', time())
        );
        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
        if ($updatdata) {
            // $this->session->set_flashdata('success', 'Education information updated successfully');
            if ($postid) {
                redirect('freelancer/portfolio/' . $postid, refresh);
            } else {
                redirect('freelancer/portfolio', refresh);
            }
        } else {
            // $this->session->flashdata('error', 'Your data not inserted');
            if ($postid) {
                redirect('freelancer/education/' . $postid, refresh);
            } else {
                redirect('freelancer/education', refresh);
            }
        }
    }

    //FREELANCER_APPLY EDUCATION PAGE DATA INSERT END
    //FREELANCER_APPLY PORTFOLIO PAGE START
    public function freelancer_post_portfolio($postid = '') {
        if ($postid != '') {
            $this->data['livepostid'] = $postid;
        }

        $userid = $this->session->userdata('aileenuser');
            //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $userdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_portfolio,freelancer_post_portfolio_attachment,free_post_step,user_id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['free_post_step'] = $userdata[0]['free_post_step'];
        if ($userdata) {
            $step = $userdata[0]['free_post_step'];
            if ($step == 7 || ($step >= 1 && $step <= 7) || $step > 7) {
                $this->data['portfolio1'] = $userdata[0]['freelancer_post_portfolio'];
                $this->data['portfolio_attachment1'] = $userdata[0]['freelancer_post_portfolio_attachment'];
            }
        }
        $this->data['title'] = "Portfolio | Edit Profile - Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_post_portfolio', $this->data);
    }

    //FREELANCER_APPLY PORTFOLIO PAGE END
    //FREELANCER_APPLY PORTFOLIO PAGE DATA INSERT START
    public function freelancer_post_portfolio_insert($postliveid = '') {

        $portfolio = $_POST['portfolio'];
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');

        $userdatacon = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $portfolio = trim($_POST['portfolio']);
        $image_hidden_portfolio = $_POST['image_hidden_portfolio'];
        $config = array(
            'upload_path' => $this->config->item('free_portfolio_main_upload_path'),
            'max_size' => 2500000000000,
            'allowed_types' => $this->config->item('free_portfolio_main_allowed_types'),
            'file_name' => $_FILES['freelancer_post_portfolio_attachment']['name']
        );
        //Load upload library and initialize configuration
        $images = array();
        $files = $_FILES;

        $this->load->library('upload');

        $fileName = $_FILES['image']['name'];
        $images[] = $fileName;
        $config['file_name'] = $fileName;

        $this->upload->initialize($config);
        $this->upload->do_upload();
        if ($this->upload->do_upload('image')) {

            $response['result'] = $this->upload->data();
            $art_post_thumb['image_library'] = 'gd2';
            $art_post_thumb['source_image'] = $this->config->item('free_portfolio_main_upload_path') . $response['result']['file_name'];
            $art_post_thumb['new_image'] = $this->config->item('free_portfolio_thumb_upload_path') . $response['result']['file_name'];
            $art_post_thumb['create_thumb'] = TRUE;
            $art_post_thumb['maintain_ratio'] = TRUE;
            $art_post_thumb['thumb_marker'] = '';
            $art_post_thumb['width'] = $this->config->item('art_portfolio_thumb_width');
            $art_post_thumb['height'] = 2;
            $art_post_thumb['master_dim'] = 'width';
            $art_post_thumb['quality'] = "100%";
            $art_post_thumb['x_axis'] = '0';
            $art_post_thumb['y_axis'] = '0';
            $instanse = "image_$i";
            //Loading Image Library
            $this->load->library('image_lib', $art_post_thumb, $instanse);
            $dataimage = $response['result']['file_name'];

            //Creating Thumbnail
            $this->$instanse->resize();
            $response['error'][] = $thumberror = $this->$instanse->display_errors();
            $return['data'][] = $this->upload->data();
            $return['status'] = "success";
            $return['msg'] = sprintf($this->lang->line('success_item_added'), "Image", "uploaded");
        } else {
            $dataimage = $image_hidden_portfolio;
        }
        $data = array(
            'freelancer_post_portfolio_attachment' => $dataimage,
            'freelancer_post_portfolio' => $portfolio,
            'modify_date' => date('Y-m-d', time()),
            'free_post_step' => '7'
        );
        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
    }

    //FREELANCER_APPLY PORTFOLIO PAGE DATA INSERT END
    public function text2link($text) {
        $text = preg_replace('/(((f|ht){1}t(p|ps){1}:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" target="_blank" rel="nofollow">\\1</a>', $text);
        $text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="http://\\2" target="_blank" rel="nofollow">\\2</a>', $text);
        $text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow" target="_blank">\\1</a>', $text);
        return $text;
    }

    public function aasort(&$array, $key) {
        $sorter = array();
        $ret = array();
        reset($array);

        foreach ($array as $ii => $va) {
            $sorter[$ii] = $va[$key];
        }

        arsort($sorter);

        foreach ($sorter as $ii => $va) {

            $ret[$ii] = $array[$ii];
        }

        return $array = $ret;
    }

    public function ajax_dataforcity() {

        if (isset($_POST["country_id"]) && !empty($_POST["country_id"])) {
            //Get all state data
            $contition_array = array('country_id' => $_POST["country_id"], 'status' => '1');
            $state = $this->data['states'] = $this->common->select_data_by_condition('states', $contition_array, $data = '*', $sortby = 'state_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Count total number of rows
            //Display states list
            if (count($state) > 0) {
                echo '<option value = "">Select state</option>';
                foreach ($state as $st) {
                    echo '<option value = "' . $st['state_id'] . '">' . $st['state_name'] . '</option>';
                }
            } else {
                echo '<option value = "">State not available</option>';
            }
        }

        if (isset($_POST["state_id"]) && !empty($_POST["state_id"])) {
            //Get all city data
            $contition_array = array('state_id' => $_POST["state_id"], 'status' => '1');
            $city = $this->data['city'] = $this->common->select_data_by_condition('cities', $contition_array, $data = '*', $sortby = 'city_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            //Display cities list
            if (count($city) > 0) {
                echo '<option value = "">Select city</option>';
                foreach ($city as $cit) {
                    echo '<option value = "' . $cit['city_id'] . '">' . $cit['city_name'] . '</option>';
                }
            } else {
                echo '<option value = "">City not available</option>';
            }
        }
    }
    
    //FREELANCER_APPLY HOME PAGE START
    public function freelancer_apply_post($id = "") {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        $this->progressbar();
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $freelancerdata = $this->data['freelancerdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['title'] = 'Get Freelance Work Suggestion | Aileensoul';
        $this->data['metadesc'] = 'Aileensoul provides you the freelance job recommendation based on your skills and interest. Apply and Get the work. ';
        $this->load->view('freelancer_live/freelancer_post/post_apply', $this->data);
    }

    //FREELANCER_APPLY HOME PAGE END
    //AJAX FREELANCER_APPLY HOME PAGE START
    public function ajax_freelancer_apply_post() {
        $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $limit = 3;
        $category_id = (isset($_POST['category_id']) && !empty($_POST['category_id']) ? $_POST['category_id'] : "");//Field
        
        $skill_id = (isset($_POST['skill_id']) && !empty($_POST['skill_id']) ? $_POST['skill_id'] : "");
        $worktype = (isset($_POST['worktype']) && !empty($_POST['worktype']) ? $_POST['worktype'] : "");
        $period_filter = (isset($_POST['period_filter']) && !empty($_POST['period_filter']) ? $_POST['period_filter'] : "");
        $exp_fil = (isset($_POST['exp_fil']) && !empty($_POST['exp_fil']) ? $_POST['exp_fil'] : "");

        $postdetail = $this->freelancer_apply_model->recommended_freelance_work($userid,$category_id,$skill_id,$worktype,$period_filter,$exp_fil,$page,$limit);
        echo json_encode($postdetail);
        exit;
    }

    //AJAX FREELANCER_APPLY HOME PAGE END
    //FREELANCER_APPLY CHECK USER IS REGISTERD START
    public function freelancer_apply_check() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');

        $apply_step = $this->data['apply_step'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'free_post_step', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);
        if (count($apply_step) > 0) {
            if ($apply_step[0]['free_post_step'] == 1) {
                if ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_address_information');
                }
            } elseif ($apply_step[0]['free_post_step'] == 2) {
                // echo "222";die();
                if ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_professional_information');
                }
            } elseif ($apply_step[0]['free_post_step'] == 3) {
                if ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_rate');
                }
            } elseif ($apply_step[0]['free_post_step'] == 4) {
                if ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_avability');
                }
            } elseif ($apply_step[0]['free_post_step'] == 5) {
                if ($this->uri->segment(2) == 'education') {
                    
                } elseif ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_education');
                }
            } elseif ($apply_step[0]['free_post_step'] == 6) {
                if ($this->uri->segment(2) == 'portfolio') {
                    
                } elseif ($this->uri->segment(2) == 'education') {
                    
                } elseif ($this->uri->segment(2) == 'avability') {
                    
                } elseif ($this->uri->segment(2) == 'rate') {
                    
                } elseif ($this->uri->segment(2) == 'professional-information') {
                    
                } elseif ($this->uri->segment(2) == 'address-information') {
                    
                } else {
                    redirect('freelancer/freelancer_post/freelancer_post_portfolio');
                }
            } else {
                
            }
        } else {
            redirect('freelance-jobs');
        }
    }

    //FREELANCER_APPLY CHECK USER IS REGISTERD END
        

    //Freelancer Job All Post controller end
    //FREELANCER_APPLY APPLY TO PROJECT START
    public function apply_insert() {
        $id = $_POST['post_id'];
        $para = $_POST['allpost'];
        $notid = $_POST['userid'];

        $userid = $this->session->userdata('aileenuser');
        $this->data['jobdata'] = $postdtaa = $this->common->select_data_by_id('freelancer_post', 'post_id', $id, $data = 'user_id', $join_str = array());
        if ($postdtaa[0]['user_id'] == $userid) {

            $this->session->set_flashdata('error', 'You can not apply on your own post');
        } else {
            $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
            $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('user_id' => $userid);
            $hiredata = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'email', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $app_id = $userdata[0]['app_id'];

            if ($userdata) {

                $contition_array = array('job_delete' => '1');
                $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'app_id', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                $data = array(
                    'job_delete' => '0',
                    'job_save' => '3',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );

                $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '4',
                    'not_product_id' => $app_id,
                    "not_active" => '1',
                    'not_created_date' => date('Y-m-d H:i:s')
                );
                $updatedata = $this->common->insert_data_getid($data, 'notification');
                // end notoification
                if ($updatedata) {
                    if ($para == 'all') {
                        // apply mail start
                        $this->apply_email($notid,$id);

                        $applypost = 'Applied';
                    }
                }
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($notid);

                echo json_encode(
                        array(
                            "status" => 'Applied',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
                ));
            } else {

                $data = array(
                    'post_id' => $id,
                    'user_id' => $userid,
                    'status' => '1',
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'modify_date' => date('Y-m-d h:i:s', time()),
                    'is_delete' => '0',
                    'job_delete' => '0',
                    'job_save' => '3'
                );
                $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
                // insert notification
                $data = array(
                    'not_type' => '3',
                    'not_from_id' => $userid,
                    'not_to_id' => $notid,
                    'not_read' => '2',
                    'not_from' => '4',
                    'not_product_id' => $insert_id,
                    "not_active" => '1',
                    'not_created_date' => date('Y-m-d H:i:s')
                );

                $insert_id = $this->common->insert_data_getid($data, 'notification');
                // end notoification
                if ($insert_id) {
                    $this->apply_email($notid,$id);
                    $applypost = 'Applied';
                }
                // GET NOTIFICATION COUNT
                $not_count = $this->freelancer_notification_count($notid);

                echo json_encode(
                        array(
                            "status" => 'Applied',
                            "notification" => array('notification_count' => $not_count, 'to_id' => $notid),
                ));
            }
            $this->session->set_flashdata('success', 'Applied Sucessfully ......');
        }
    }

    //FREELANCER_APPLY APPLY TO PROJECT START
    //FREELANCER_APPLY APPLIED ON POST(PROJECTS) START
    public function freelancer_applied_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        // $this->progressbar();
        // job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'freelancer_apply';
        $join_str[0]['join_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('freelancer_apply.job_delete' => '0', 'freelancer_apply.user_id' => $userid);
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
        $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if($apply_data[0]['is_indivdual_company'] == '1')
        {
            $fullname = ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']);
        }
        else
        {
            $fullname = ucfirst($apply_data[0]['comp_name']);   
        }

        $this->data['title'] = ucfirst($fullname). " | Applied Projects | Freelancer Profile" . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_applied_post', $this->data);
    }

    //FREELANCER_APPLY APPLIED ON POST(PROJECTS) START
    // AJAX FREELANCER_APPLY APLLIED ON POST(PROJECT) START
    public function ajax_freelancer_applied_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;


        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $join_str[0]['table'] = 'freelancer_apply';
        $join_str[0]['join_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['join_type'] = '';
        $limit = $perpage;
        $offset = $start;
        $contition_array = array('freelancer_apply.job_delete' => '0', 'freelancer_apply.user_id' => $userid);
        $postdata = $this->data['postdata'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
        $postdata1 = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'freelancer_post.*, freelancer_apply.app_id, freelancer_apply.user_id as userid, freelancer_apply.modify_date, freelancer_apply.created_date ', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');

        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdata1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';
        if (count($postdata1) > 0) {
            foreach ($postdata as $post) {

                $return_html .= '<div class="all-job-box" id="removeapply' . $post['app_id'] . '">
                                    <div class="all-job-top">';
                $cache_time1 = $post['post_name'];

                if ($cache_time1 != '') {
                    $text = strtolower($this->common->clean($cache_time1));
                } else {
                    $text = '';
                }
                $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name;
                $f_url = base_url()."freelance-jobs/".$category_name."/".substr($text, 0, 200)."-".$post['user_id']."-".$post['post_id'];
                $city = $this->db->select('city')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;

                if ($cityname != '') {
                    $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                } else {
                    $cityname1 = '';
                }

                $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                $lastname = $this->db->select('username')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                $hireslug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;


                $return_html .= '<div class="job-top-detail">';
                $return_html .= '<h5><a title = "' . $post['post_name'] . '" href="' . $f_url . ' ">';
                $return_html .= $post['post_name'];
                $return_html .= '</a></h5>';
                $return_html .= '<p><a title = "' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-employer/' . $hireslug) . '">';
                $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                $return_html .= '<span><img alt= "location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
                $country = $this->db->select('country')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country;
                $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $country))->row()->country_name;
                if ($cityname || $countryname) {
                    if ($cityname) {
                        $return_html .= $cityname . ",";
                    }
                    $return_html .= $countryname;
                }
                $return_html .= '      </span>
                    </span>';
                $return_html .= '<span class="exp">
                        <span><img alt="skill" class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                $comma = ", ";
                $k = 0;
                $aud = $post['post_skill'];
                $aud_res = explode(',', $aud);
                if (!$post['post_skill']) {

                    $return_html .= $post['post_other_skill'];
                } else if (!$post['post_other_skill']) {

                    foreach ($aud_res as $skill) {
                        if ($k != 0) {
                            $return_html .= $comma;
                        }
                        $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                        $return_html .= $cache_time;
                        if ($k == 5) {
                            $etc = ",etc...";
                            $return_html .= $etc;
                            break;
                        }
                        $k++;
                    }
                } else if ($post['post_skill'] && $post['post_other_skill']) {
                    foreach ($aud_res as $skill) {
                        if ($k != 0) {
                            $return_html .= $comma;
                        }
                        $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                        $return_html .= $cache_time;
                        if ($k == 5) {
                            $etc = ",etc...";
                            $return_html .= $etc;
                            break;
                        }
                        $k++;
                    }
                    if ($k < 5) {
                        $return_html .= "," . $post['post_other_skill'];
                    }
                }


                $return_html .= '</span>
                    </span>
                </p>
                <p>';

                $rest = substr($post['post_description'], 0, 150);
                $return_html .= $rest;

                if (strlen($post['post_description']) > 150) {
                    $return_html .= '.....<a href="' . $f_url . ' " title = "Read more">Read more</a>';
                }
                $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                $return_html .= '</span>
                <p class="pull-right">';

                $return_html .= '<a title = "Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['app_id'] . ')">Remove</a>';

                $return_html .= ' </p>

            </div>
            </div>';
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt= "No applied Projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_applied_projects");
            $return_html .= '</div>
                                            </div>';
        }
        echo $return_html;
    }

    // AJAX FREELANCER_APPLY APLLIED ON POST(PROJECT) END
    //FREELANCER_APPLY REMOVE FROM APPLIED AND SAVE LIST START
    public function freelancer_delete_apply() {
        $id = $_POST['app_id'];
        $para = $_POST['para'];

        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'job_delete' => '1',
            'job_save' => '3',
            'modify_date' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $id);
    }

    //FREELANCER_APPLY REMOVE FROM APPLIED AND SAVE LIST END
    public function save_insert() {
        $id = $_POST['post_id'];
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];
        if ($userdata) {
            $contition_array = array('job_delete' => '1');
            $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array = array(), $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $data = array(
                'job_delete' => '0',
                'job_save' => '1'
            );

            $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
            if ($updatedata) {
                $savepost = 'Applied post';
                echo $savepost;
            }
        } else {
            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '0',
                'job_save' => '1'
            );

            $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
            if ($insert_id) {
                $savepost = 'Applied Post';
                echo $savepost;
            }
        }
    }

    public function save_user() {
        $id = $_POST['post_id'];
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $app_id = $userdata[0]['app_id'];
        if ($userdata) {
            $contition_array = array('job_delete' => '0');
            $jobdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array = array(), $data = '*', $sortby = 'post_id', $orderby = 'asc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $data = array(
                'job_delete' => '1',
                'job_save' => '2',
                'modify_date' => date('Y-m-d h:i:s', time())
            );

            $updatedata = $this->common->update_data($data, 'freelancer_apply', 'app_id', $app_id);
            if ($updatedata) {

                $savepost = 'Saved';
            }
            echo $savepost;
        } else {

            $data = array(
                'post_id' => $id,
                'user_id' => $userid,
                'status' => '1',
                'created_date' => date('Y-m-d h:i:s', time()),
                'modify_date' => date('Y-m-d h:i:s', time()),
                'is_delete' => '0',
                'job_delete' => '1',
                'job_save' => '2'
            );

            $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
            if ($insert_id) {

                $savepost = 'Saved';
            } echo $savepost;
        }
    }

    //FREELANCER_APPLY SAVE POST(PROJECT) START
    public function freelancer_save_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        // code for display page start
        $this->freelancer_apply_check();
        // code for display page end
        // $this->progressbar();
        // job seeker detail
        $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
        $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1', 'free_post_step' => '7');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username,is_indivdual_company,comp_name', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        if($jobdata[0]['is_indivdual_company'] == '1')
        {
            $fullname = ucfirst($jobdata[0]['freelancer_post_fullname']) . " " . ucfirst($jobdata[0]['freelancer_post_username']);
        }
        else
        {
            $fullname = ucfirst($jobdata[0]['comp_name']);   
        }
        $this->data['title'] =  $fullname. " | Saved Projects | Freelancer Profile " . TITLEPOSTFIX;
        $this->load->view('freelancer_live/freelancer_post/freelancer_save_post', $this->data);
    }

    //FREELANCER_APPLY SAVE POST(PROJECT) END
    //Freelancer Save Post Controller End
    //AJAX_FREELANCER_APPLY SAVE POST(PROJECT) START
    public function ajax_freelancer_save_post() {
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $perpage = 5;
        $page = 1;
        if (!empty($_GET["page"]) && $_GET["page"] != 'undefined') {
            $page = $_GET["page"];
        }

        $start = ($page - 1) * $perpage;
        if ($start < 0)
            $start = 0;

        // job seeker detail
        $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
        $jobdata = $this->data['jobdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // post detail
        $join_str[0]['table'] = 'freelancer_post';
        $join_str[0]['join_table_id'] = 'freelancer_post.post_id';
        $join_str[0]['from_table_id'] = 'freelancer_apply.post_id';
        $join_str[0]['join_type'] = '';

        $limit = $perpage;
        $offset = $start;

        $contition_array = array('freelancer_apply.job_delete' => '1', 'freelancer_apply.user_id' => $userid, 'freelancer_apply.job_save' => '2');
        $postdetail = $this->data['postdetail'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'freelancer_apply.app_id, freelancer_post.post_id, freelancer_post.user_id, freelancer_post.created_date, freelancer_post.post_name, freelancer_post.post_field_req, freelancer_post.post_est_time, freelancer_post.post_skill, freelancer_post.post_exp_month, freelancer_post.post_exp_year, freelancer_post.post_other_skill, freelancer_post.post_description, freelancer_post.post_rate, freelancer_post.post_last_date, freelancer_post.post_currency, freelancer_post.post_rating_type, freelancer_post.country, freelancer_post.city', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit, $offset, $join_str, $groupby = '');
        $postdetail1 = $this->data['postdetail'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = 'freelancer_apply.app_id, freelancer_post.post_id, freelancer_post.user_id, freelancer_post.created_date, freelancer_post.post_name, freelancer_post.post_field_req, freelancer_post.post_est_time, freelancer_post.post_skill, freelancer_post.post_exp_month, freelancer_post.post_exp_year, freelancer_post.post_other_skill, freelancer_post.post_description, freelancer_post.post_rate, freelancer_post.post_last_date, freelancer_post.post_currency, freelancer_post.post_rating_type, freelancer_post.country, freelancer_post.city', $sortby = 'freelancer_apply.modify_date', $orderby = 'desc', $limit = '', $offset = '', $join_str, $groupby = '');
        if (empty($_GET["total_record"])) {
            $_GET["total_record"] = count($postdetail1);
        }
        $return_html = '';
        $return_html .= '<input type="hidden" class="page_number" value="' . $page . '" />';
        $return_html .= '<input type="hidden" class="total_record" value="' . $_GET["total_record"] . '" />';
        $return_html .= '<input type = "hidden" class = "perpage_record" value = "' . $perpage . '" />';

        if (count($postdetail1) > 0) {
            foreach ($postdetail as $post) {
                $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                if ($freelancerapply1) {
                    
                } else {

                    $return_html .= '<div class="all-job-box" id="postdata' . $post['app_id'] . '">
                                    <div class="all-job-top">';
                    $cache_time1 = $post['post_name'];

                    if ($cache_time1 != '') {
                        $text = strtolower($this->common->clean($cache_time1));
                    } else {
                        $text = '';
                    }
                    $category_name = $this->db->select('category_name')->get_where('category', array('category_id' => $post['post_field_req']))->row()->category_name;
                    $f_url = base_url()."freelance-jobs/".$category_name."/".substr($text, 0,200)."-".$post['user_id']."-".$post['post_id'];
                    
                    $city = $this->db->select('city')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->city;
                    $cityname = $this->db->select('city_name')->get_where('cities', array('city_id' => $city))->row()->city_name;

                    if ($cityname != '') {
                        $cityname1 = '-vacancy-in-' . strtolower($this->common->clean($cityname));
                    } else {
                        $cityname1 = '';
                    }

                    $firstname = $this->db->select('fullname')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->fullname;
                    $lastname = $this->db->select('username')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->username;
                    $hireslug = $this->db->select('freelancer_hire_slug')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->freelancer_hire_slug;


                    $return_html .= '<div class="job-top-detail">';
                    $return_html .= '<h5><a title = "' . $post['post_name'] . '" href="' . $f_url. ' ">';
                    $return_html .= $post['post_name'];
                    $return_html .= '</a></h5>';
                    $return_html .= '<p><a title = "' . ucwords($firstname) . " " . ucwords($lastname) . '" href="' . base_url('freelance-employer/' . $hireslug) . '">';
                    $return_html .= ucwords($firstname) . " " . ucwords($lastname);
                    $return_html .= '</a></p>
            </div>
            </div>
            <div class="all-job-middle">
                <p class="pb5">
                    <span class="location">';
                    $return_html .= '<span><img alt= "location" class="pr5" src="' . base_url('assets/images/location.png') . '">';
                    $country = $this->db->select('country')->get_where('freelancer_hire_reg', array('user_id' => $post['user_id']))->row()->country;
                    $countryname = $this->db->select('country_name')->get_where('countries', array('country_id' => $country))->row()->country_name;
                    if ($cityname || $countryname) {
                        if ($cityname) {
                            $return_html .= $cityname . ",";
                        }
                        $return_html .= $countryname;
                    }
                    $return_html .= '      </span>
                    </span>';
                    $return_html .= '<span class="exp">
                        <span><img alt= "skill" class="pr5" src="' . base_url('assets/images/exp.png') . '">';

                    $comma = ", ";
                    $k = 0;
                    $aud = $post['post_skill'];
                    $aud_res = explode(',', $aud);
                    if (!$post['post_skill']) {

                        $return_html .= $post['post_other_skill'];
                    } else if (!$post['post_other_skill']) {

                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            if ($k == 5) {
                                $etc = ",etc...";
                                $return_html .= $etc;
                                break;
                            }
                            $k++;
                        }
                    } else if ($post['post_skill'] && $post['post_other_skill']) {
                        foreach ($aud_res as $skill) {
                            if ($k != 0) {
                                $return_html .= $comma;
                            }
                            $cache_time = $this->db->select('skill')->get_where('skill', array('skill_id' => $skill))->row()->skill;
                            $return_html .= $cache_time;
                            if ($k == 5) {
                                $etc = ",etc...";
                                $return_html .= $etc;
                                break;
                            }
                            $k++;
                        }
                        if ($k < 5) {
                            $return_html .= "," . $post['post_other_skill'];
                        }
                    }


                    $return_html .= '</span>
                    </span>
                </p>
                <p>';

                    $rest = substr($post['post_description'], 0, 150);
                    $return_html .= $rest;

                    if (strlen($post['post_description']) > 150) {
                        $return_html .= '.....<a href="' . $f_url . ' " title="Read more">Read more</a>';
                    }
                    $return_html .= '</p>

            </div>
            <div class="all-job-bottom">
                <span class="job-post-date"><b>Posted on: </b>';
                    $return_html .= trim(date('d-M-Y', strtotime($post['created_date'])));
                    $return_html .= '</span>
                <p class="pull-right">';

                    $return_html .= '<a title = "Remove" href="javascript:void(0);" class="btn4" onclick="removepopup(' . $post['app_id'] . ')">Remove</a>';
                    $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
                    $contition_array = array('post_id' => $post['post_id'], 'job_delete' => '0', 'user_id' => $userid);
                    $freelancerapply1 = $this->data['freelancerapply'] = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if ($freelancerapply1) {
                        
                    } else {
                        $return_html .= '<a title="Apply" href="javascript:void(0);"  class= "btn4" onclick="applypopup(' . $post['post_id'] . ',' . $post['app_id'] . ')">Apply</a>';
                    }

                    $return_html .= ' </p>

            </div>
            </div>';
                }
            }
        } else {
            $return_html .= '<div class="art-img-nn">
                                                <div class="art_no_post_img">

                                                    <img alt= "No Saved Projects" src="../assets/img/free-no1.png">

                                                </div>
                                                <div class="art_no_post_text">';
            $return_html .= $this->lang->line("no_saved_project");
            $return_html .= '</div>
                                            </div>';
        }
        echo $return_html;
    }

    //AJAX_FREELANCER_APPLY SAVE POST(PROJECT) END

    //FREELANCER_APPLY PROFILE PIC INSERT START
    public function user_image_add1() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['freelancer_post_user_image'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_post_profile_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_post_profile_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }


        /*$data = $_POST['image'];
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $user_bg_path = $this->config->item('free_post_profile_main_upload_path');
        $data = base64_decode($data);
        $imageName = time() . '.png';
        $file = $user_bg_path . $imageName;
        file_put_contents($user_bg_path . $imageName, $data);
        $success = file_put_contents($file, $data);
        $main_image = $user_bg_path . $imageName;
        $main_image_size = filesize($main_image);*/

        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('free_post_profile_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $main_image = $user_bg_path . $imageName;
        $success = file_put_contents($main_image, $data);
        $main_image_size = filesize($main_image);

        if (IMAGEPATHFROM == 's3bucket') {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
            $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
        }

        $user_thumb_path = $this->config->item('free_post_profile_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_post_profile_thumb_width');
        $user_thumb_height = $this->config->item('free_post_profile_thumb_height');

        $thumb_image = $user_thumb_path . $imageName;
        copy($main_image, $thumb_image);
        if (IMAGEPATHFROM == 's3bucket') {
            $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);
        }

        $data = array(
            'freelancer_post_user_image' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            if (isset($main_image)) {
                unlink($main_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
        }
        if ($update) {

            $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
            $freelancerpostdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_user_image', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby);
            $userimage .= '<img src="' . FREE_POST_PROFILE_MAIN_UPLOAD_URL . $freelancerpostdata[0]['freelancer_post_user_image'] . '" alt="User Image" >';
            $userimage .= '<a title = "update profile pic" href="javascript:void(0);" onclick="updateprofilepopup();" class="cusome_upload"><img alt="Upload profile pic" src="' . base_url('assets/img/cam.png') . '">';
            $userimage .= $this->lang->line("update_profile_picture");
            $userimage .= '</a>';

            echo $userimage;
        } else {

            $this->session->flashdata('error', 'Your data not inserted');
            redirect('freelance-work/home', refresh);
        }
    }

    //FREELANCER_APPLY PROFILE PIC INSERT END

    //FREELANCER_APPLY PORTFOLIO UPLOAD PDF START
    public function pdf($id) {
        $this->data['title'] =   "PDF | Freelancer Profile" . TITLEPOSTFIX;
        $contition_array = array('user_id' => $id, 'status' => '1');
        $this->data['freelancerdata'] = $freelancerdata = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->load->view('freelancer/freelancer_post/freelancer_pdf', $this->data);
    }

    //FREELANCER_APPLY PORTFOLIO UPLOAD PDF END

    //FREELANCER_APPLY PROFILE PAGE START
    public function freelancer_post_profile($id = "") {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $id, 'status' => 1))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');
        if($userid == "")
        {
            redirect(base_url());
        }

        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        if ($id == $userid || $id == '') {
            // code for display page start
            $this->freelancer_apply_check();
            // code for display page end

            // $this->progressbar();

            $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'free_post_step' => '7', 'status' => '1');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $contition_array = array('status' => '1', 'is_delete' => '0','category_id'=>$apply_data[0]['freelancer_post_field']);
        $field = $this->common->select_data_by_search('category', $search_condition = array(), $contition_array, $data = 'category_name', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '')[0]['category_name'];

        $contition_array = array('user_id' => $userid, 'status' => '1', 'free_hire_step' => '3');
        $this->data['fa_data'] = $this->common->select_data_by_condition('freelancer_hire_reg', $contition_array, $data = 'username, fullname, email, skyupid, phone, country, state, city, pincode, professional_info, freelancer_hire_user_image,freelancer_hire_slug, profile_background, user_id,designation, is_indivdual_company,comp_name,company_field,company_other_field', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '')[0];

        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "( status = '1')";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        // print_r($apply_data);exit;
        $skills = $this->freelancer_apply_model->getSkillsNames($apply_data[0]['freelancer_post_area']);
        $this->data['title'] = "Freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) . " Profile";
        $this->data['metadesc'] = "Connect with freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) ." on Aileensoul. Field: ".$field.". Skills: ".$skills.". Experience: ".($apply_data[0]['freelancer_post_exp_year']) . " " . ($apply_data[0]['freelancer_post_exp_month']).".";

        $this->load->view('freelancer_live/freelancer_post/freelancer_post_profile_new', $this->data);
    }

    public function freelancer_post_profile_new($id = "") {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $id, 'status' => 1))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');
        if($userid == "")
        {
            redirect(base_url());
        }

        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        if ($id == $userid || $id == '') {
            // code for display page start
            $this->freelancer_apply_check();
            // code for display page end

            $this->progressbar();

            $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city,freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'free_post_step' => '7', 'status' => '1');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city, freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image,  designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $contition_array = array('status' => '1', 'is_delete' => '0','category_id'=>$apply_data[0]['freelancer_post_field']);
        $field = $this->common->select_data_by_search('category', $search_condition = array(), $contition_array, $data = 'category_name', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '')[0]['category_name'];
        


        // print_r($apply_data);exit;
        $skills = $this->freelancer_apply_model->getSkillsNames($apply_data[0]['freelancer_post_area']);
        $this->data['title'] = "Freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) . " Profile";
        $this->data['metadesc'] = "Connect with freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) ." on Aileensoul. Field: ".$field.". Skills: ".$skills.". Experience: ".($apply_data[0]['freelancer_post_exp_year']) . " " . ($apply_data[0]['freelancer_post_exp_month']).".";

        $this->load->view('freelancer_live/freelancer_post/freelancer_post_profile_new', $this->data);
    }

    public function freelancer_post_profile_new_individual($id = "") {
        if (is_numeric($id)) {
            
        } else {
            $id = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $id, 'status' => 1))->row()->user_id;
        }
        $userid = $this->session->userdata('aileenuser');
        if($userid == "")
        {
            redirect(base_url());
        }

        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end
        if ($id == $userid || $id == '') {
            // code for display page start
            $this->freelancer_apply_check();
            // code for display page end

            $this->progressbar();

            $contition_array = array('user_id' => $userid, 'status' => '1', 'free_post_step' => '7');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city,freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image, designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        } else {
            $contition_array = array('user_id' => $id, 'free_post_step' => '7', 'status' => '1');
            $apply_data = $this->data['freelancerpostdata'] = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname, freelancer_post_username, freelancer_post_skypeid, freelancer_post_email, freelancer_post_phoneno, freelancer_post_country, freelancer_post_state, freelancer_post_city, freelancer_post_pincode, freelancer_post_field, freelancer_post_area, freelancer_post_skill_description, freelancer_post_hourly, freelancer_post_ratestate, freelancer_post_fixed_rate, freelancer_post_job_type, freelancer_post_work_hour, freelancer_post_degree, freelancer_post_stream, freelancer_post_univercity, freelancer_post_collage, freelancer_post_percentage, freelancer_post_passingyear, freelancer_post_portfolio_attachment, freelancer_post_portfolio, user_id, freelancer_post_user_image,  designation, freelancer_post_otherskill, freelancer_post_exp_month, freelancer_post_exp_year,freelancer_apply_slug', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        }

        $contition_array = array('status' => '1', 'is_delete' => '0','category_id'=>$apply_data[0]['freelancer_post_field']);
        $field = $this->common->select_data_by_search('category', $search_condition = array(), $contition_array, $data = 'category_name', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = '')[0]['category_name'];
        


        // print_r($apply_data);exit;
        $skills = $this->freelancer_apply_model->getSkillsNames($apply_data[0]['freelancer_post_area']);
        $this->data['title'] = "Freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) . " Profile";
        $this->data['metadesc'] = "Connect with freelancer ".ucfirst($apply_data[0]['freelancer_post_fullname']) . " " . ucfirst($apply_data[0]['freelancer_post_username']) ." on Aileensoul. Field: ".$field.". Skills: ".$skills.". Experience: ".($apply_data[0]['freelancer_post_exp_year']) . " " . ($apply_data[0]['freelancer_post_exp_month']).".";

        $this->load->view('freelancer_live/freelancer_post/freelancer_post_profile_new_individual', $this->data);
    }

    //FREELANCER_APPLY PROFILE PAGE END

    //FREELANCER_APPLY DEACTIVATE START
    public function deactivate() {

        $id = $_POST['id'];
        $data = array(
            'status' => '0'
        );
        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $id);
    }

    //FREELANCER_APPLY DEACTIVATE END


    //FREELANCER_APPLY COVER PIC START
    public function ajaxpro_work() {
        $userid = $this->session->userdata('aileenuser');

        $contition_array = array('user_id' => $userid);
        $user_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'profile_background_main', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $user_reg_prev_image = $user_reg_data[0]['profile_background'];
        $user_reg_prev_main_image = $user_reg_data[0]['profile_background_main'];

        if ($user_reg_prev_image != '') {
            $user_image_main_path = $this->config->item('free_post_bg_main_upload_path');
            $user_bg_full_image = $user_image_main_path . $user_reg_prev_image;
            if (isset($user_bg_full_image)) {
                unlink($user_bg_full_image);
            }

            $user_image_thumb_path = $this->config->item('free_post_bg_thumb_upload_path');
            $user_bg_thumb_image = $user_image_thumb_path . $user_reg_prev_image;
            if (isset($user_bg_thumb_image)) {
                unlink($user_bg_thumb_image);
            }
        }
        if ($user_reg_prev_main_image != '') {
            $user_image_original_path = $this->config->item('free_post_bg_original_upload_path');
            $user_bg_origin_image = $user_image_original_path . $user_reg_prev_main_image;
            if (isset($user_bg_origin_image)) {
                unlink($user_bg_origin_image);
            }
        }


        $data = $_POST['image'];
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $user_bg_path = $this->config->item('free_post_bg_main_upload_path');
        $imageName = time() . '.png';
        $data = base64_decode($data);
        $file = $user_bg_path . $imageName;
        $success = file_put_contents($file, $data);

        $main_image = $user_bg_path . $imageName;

        $main_image_size = filesize($main_image);

        $s3 = new S3(awsAccessKey, awsSecretKey);
        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
        $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);

        $user_thumb_path = $this->config->item('free_post_bg_thumb_upload_path');
        $user_thumb_width = $this->config->item('free_post_bg_thumb_width');
        $user_thumb_height = $this->config->item('free_post_bg_thumb_height');

        $upload_image = $user_bg_path . $imageName;

        $thumb_image_uplode = $this->thumb_img_uplode($upload_image, $imageName, $user_thumb_path, $user_thumb_width, $user_thumb_height);

        $thumb_image = $user_thumb_path . $imageName;
        $abc = $s3->putObjectFile($thumb_image, bucket, $thumb_image, S3::ACL_PUBLIC_READ);

        $data = array(
            'profile_background' => $imageName
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            if (isset($main_image)) {
                unlink($main_image);
            }
            if (isset($thumb_image)) {
                unlink($thumb_image);
            }
            if (isset($upload_image)) {
                unlink($upload_image);
            }
        }


        $this->data['jobdata'] = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'profile_background', $join_str = array());
        $coverpic = '<img alt="User Image" src="' . FREE_POST_BG_MAIN_UPLOAD_URL . $this->data['jobdata'][0]['profile_background'] . '" name="image_src" id="image_src" />';
        echo $coverpic;
    }

    public function image_work() {
        $userid = $this->session->userdata('aileenuser');

        $config['upload_path'] = $this->config->item('free_post_bg_original_upload_path');
        $config['allowed_types'] = $this->config->item('free_post_bg_main_allowed_types');

        $config['file_name'] = $_FILES['image']['name'];

        //Load upload library and initialize configuration
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {

            $uploadData = $this->upload->data();

            $image = $uploadData['file_name'];
        } else {

            $image = '';
        }

        $data = array(
            'profile_background_main' => $image,
            'modify_date ' => date('Y-m-d h:i:s', time())
        );

        $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

        if ($updatedata) {
            echo $userid;
        } else {
            echo "welcome";
        }
    }

    //FREELANCER_APPLY COVER PIC START
    //FREELANCER_APPLY DESIGNATION START
    public function designation() {
        $userid = $this->session->userdata('aileenuser');

        $data = array(
            'designation' => trim($this->input->post('designation')),
            'modify_date' => date('Y-m-d', time())
        );

        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

        if ($updatdata) {

            if ($this->input->post('hitext') == 1) {
                redirect('freelancer/freelancer_post_profile', refresh);
            } elseif ($this->input->post('hitext') == 2) {
                redirect('freelancer/freelancer_save_post', refresh);
            } elseif ($this->input->post('hitext') == 3) {
                redirect('freelancer/freelancer_applied_post', refresh);
            }
        } else {
            $this->session->flashdata('error', 'Your data not inserted');
            redirect('freelancer/post_apply', refresh);
        }
    }

    //FREELANCER_APPLY DESIGNATION END
    //FREELANCER_APPLY REACTIVATE PROFILE STRAT
    public function reactivate() {

        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'status' => 1,
            'modify_date' => date('y-m-d h:i:s')
        );

        $updatdata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if ($updatdata) {

            redirect('freelance-work/home', refresh);
        } else {

            redirect('freelancer/reactivate', refresh);
        }
    }

    //FREELANCER_APPLY REACTIVATE PROFILE END
    //FREELANCER_HIRE INVITE FREELANCER OF APLLIED START
    public function free_invite_user() {
        $postid = $_POST['post_id'];
        $invite_user = $_POST['invited_user'];
        //echo $invite_user;die();
        $userid = $this->session->userdata('aileenuser');
        $data = array(
            'user_id' => $userid,
            'post_id' => $postid,
            'invite_user_id' => $invite_user,
            'profile' => "freelancer"
        );
        $insert_id = $this->common->insert_data_getid($data, 'user_invite');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $invite_user, $data = 'freelancer_post_email');
        $projectdata = $this->common->select_data_by_id('freelancer_post', 'post_id', $postid, $data = 'post_name');

        if ($insert_id) {
            $data = array(
                'not_type' => '4',
                'not_from_id' => $userid,
                'not_to_id' => $invite_user,
                'not_read' => '2',
                'not_status' => '0',
                'not_product_id' => $insert_id,
                'not_from' => '5',
                "not_active" => '1',
                'not_created_date' => date('Y-m-d H:i:s')
            );
            $insert_id = $this->common->insert_data_getid($data, 'notification');
            // GET NOTIFICATION COUNT
            $not_count = $this->freelancer_notification_count($invite_user);

            echo json_encode(
                    array(
                        "status" => 'Selected',
                        "notification" => array('notification_count' => $not_count, 'to_id' => $invite_user),
            ));

            if ($insert_id) {
                $word = 'Selected';
                $this->selectemail_user($invite_user, $postid, $word);
            }
        } else {
            echo 'error';
        }
    }

    //FREELANCER_HIRE INVITE FREELANCER OF APLLIED END
    //FREELANCER_APPLY DELETE PDF OF PORTFOLIO START
    public function deletepdf() {
        $userid = $this->session->userdata('aileenuser');
        //code for check user deactivate start
        $this->freelancer_apply_deactivate_check();
        //code for check user deactivate end

        $contition_array = array('user_id' => $userid);
        $free_reg_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $freeportfolio = $free_reg_data[0]['freelancer_post_portfolio_attachment'];

        if ($freeportfolio != '') {
            $free_pdf_path = 'uploads/freelancer_post_portfolio/main';
            $free_pdf = $free_pdf_path . $freeportfolio;
            if (isset($free_pdf)) {
                unlink($free_pdf);
            }
        }

        $data = array(
            'freelancer_post_portfolio_attachment' => ''
        );

        $update = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        echo 'ok';
    }

    //FREELANCER_APPLY DELETE PDF OF PORTFOLIO END

    //FREELANCER_HIRE SEARCH CITY FOR AUTO COMPLETE START
    public function freelancer_search_city($id = "") {
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'state_id !=' => '0');
            $search_condition = "(city_name LIKE '" . trim($searchTerm) . "%')";
            $location_list = $this->common->select_data_by_search('cities', $search_condition, $contition_array, $data = 'city_name', $sortby = 'city_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'city_name');
            foreach ($location_list as $key1 => $value) {
                foreach ($value as $ke1 => $val1) {
                    $location[] = $val1;
                }
            }
            foreach ($location as $key => $value) {
                $city_data[$key]['value'] = $value;
            }
            echo json_encode($city_data);
        }
    }

    //FREELANCER_HIRE SEARCH CITY FOR AUTO COMPLETE END
    //FREELANCER_APPLY SEARCH KEYWORD FOR AUTO COMPLETE START
    public function freelancer_apply_search_keyword($id = "") {
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'is_delete' => '0', 'free_post_step' => '7');
            $search_condition = "(designation LIKE '" . trim($searchTerm) . "%')";
            $freelancer_postdata = $this->common->select_data_by_search('freelancer_post_reg', $search_condition, $contition_array, $data = 'designation', $sortby = 'designation', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'designation');

            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $skill = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');

            $contition_array = array('status' => '1');
            $search_condition = "(post_name LIKE '" . trim($searchTerm) . "%')";
            $results_post = $this->common->select_data_by_search('freelancer_post', $search_condition, $contition_array, $data = 'post_name', $sortby = 'post_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'post_name');
            //$this->data['results'] = $this->common->select_data_by_condition('freelancer_post', $contition_array, $data = 'post_name', $sortby = '', $orderby = '', $limit = '', $offset = '', $$join_str = array(), $groupby);

            $contition_array = array('status' => '1', 'is_delete' => '0');
            $search_condition = "(category_name LIKE '" . trim($searchTerm) . "%')";
            $field = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = 'category_name', $sortby = 'category_name', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'category_name');
        }
        $uni = array_merge((array) $skill, (array) $freelancer_postdata, (array) $field, (array) $results_post);
        foreach ($uni as $key => $value) {
            foreach ($value as $ke => $val) {
                if ($val != "") {
                    $result[] = $val;
                }
            }
        }
        foreach ($result as $key => $value) {
            $result1[$key]['value'] = $value;
        }
        $result1 = array_values($result);
        echo json_encode($result1);
    }

    //FREELANCER_APPLY SEARCH KEYWORD FOR AUTO COMPLETE END
    public function get_skill($id = "") {

        //get search term
        $searchTerm = $_GET['term'];
        if (!empty($searchTerm)) {
            $contition_array = array('status' => '1', 'type' => '1');
            $search_condition = "(skill LIKE '" . trim($searchTerm) . "%')";
            $citylist = $this->common->select_data_by_search('skill', $search_condition, $contition_array, $data = 'skill as text', $sortby = 'skill', $orderby = 'desc', $limit = '', $offset = '', $join_str5 = '', $groupby = 'skill');
        }
        foreach ($citylist as $key => $value) {
            $citydata[$key]['value'] = $value['text'];
        }

        $cdata = array_values($citydata);
        echo json_encode($cdata);
    }

    //FREELANCER_APPLY OTHER DEGREE ADD START
    public function freelancer_other_degree() {
        $other_degree = $_POST['other_degree'];
        $other_stream = $_POST['other_stream'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('is_delete' => '0', 'degree_name' => $other_degree);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_degree != NULL) {
            if ($count == 0) {
                $data = array(
                    'degree_name' => $other_degree,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'degree');
                $degree_id = $insert_id;

                $contition_array = array('is_delete' => '0', 'status' => '2', 'stream_name' => $other_stream, 'user_id' => $userid);
                $stream_data = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                $count1 = count($stream_data);

                if ($count1 == 0) {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $insert_id = $this->common->insert_data_getid($data, 'stream');
                } else {
                    $data = array(
                        'stream_name' => $other_stream,
                        'degree_id' => $degree_id,
                        'created_date' => date('Y-m-d h:i:s', time()),
                        'status' => '2',
                        'is_delete' => '0',
                        'is_other' => '1',
                        'user_id' => $userid
                    );
                    $updatedata = $this->common->update_data($data, 'stream', 'stream_id', $stream_data[0]['stream_id']);
                }
                if ($insert_id || $updatedata) {

                    $contition_array = array('is_delete' => '0', 'degree_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $degree = $this->data['degree'] = $this->common->select_data_by_search('degree', $search_condition, $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($degree) > 0) {

                        $select = '<option value="" Selected option disabled="">Select your Degree</option>';

                        foreach ($degree as $st) {

                            $select .= '<option value="' . $st['degree_id'] . '"';
                            if ($st['degree_name'] == $other_degree) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['degree_name'] . '</option>';
                        }
                    }
        //For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'degree_name' => "Other");
                    $degree_otherdata = $this->common->select_data_by_condition('degree', $contition_array, $data = '*', $sortby = 'degree_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $degree_otherdata[0]['degree_id'] . '">' . $degree_otherdata[0]['degree_name'] . '</option>';

                    //for getting selected stream data start
                    $contition_array = array('is_delete' => '0', 'degree_id' => $degree_id);
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select2 = '<option value="" Selected option disabled="">Select your Stream</option>';
                    $select2 .= '<option value="' . $stream[0]['stream_id'] . '"';
                    if ($stream[0]['stream_name'] == $other_stream) {
                        $select2 .= 'selected';
                    }
                    $select2 .= '>' . $stream[0]['stream_name'] . '</option>';
                    //for getting selected stream data End         
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo json_encode(array(
            "select" => $select,
            "select2" => $select2,
        ));
    }

    //FREELANCER_APPLY OTHER DEGREE ADD START
    //FREELANCER_APPLY OTHER STREAM START
    public function freelancer_other_stream() {
        $other_stream = $_POST['other_stream'];
        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');

        $contition_array = array('is_delete' => '0', 'stream_name' => $other_stream);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_stream != NULL) {
            if ($count == 0) {
                $data = array(
                    'stream_name' => $other_stream,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid
                );
                $insert_id = $this->common->insert_data_getid($data, 'stream');


                if ($insert_id) {

                    $contition_array = array('is_delete' => '0', 'stream_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $stream = $this->data['stream'] = $this->common->select_data_by_search('stream', $search_condition, $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($stream) > 0) {
                        $select = '<option value="" selected option disabled="">Select your Stream</option>';

                        foreach ($stream as $st) {

                            $select .= '<option value="' . $st['stream_id'] . '"';
                            if ($st['stream_name'] == $other_stream) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['stream_name'] . '</option>';
                        }
                    }
            //For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'stream_name' => "Other");
                    $stream_otherdata = $this->common->select_data_by_condition('stream', $contition_array, $data = '*', $sortby = 'stream_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    $select .= '<option value="' . $stream_otherdata[0]['stream_id'] . '">' . $stream_otherdata[0]['stream_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }

        echo $select;
    }

    //FREELANCER_APPLY OTHER STREAM END
    //FREELANCER_APPLY  OTHER FIELD START
    public function freelancer_other_field() {

        $other_field = $_POST['other_field'];

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $contition_array = array('is_delete' => '0', 'category_name' => $other_field);
        $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
        $userdata = $this->data['userdata'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $count = count($userdata);

        if ($other_field != NULL) {
            if ($count == 0) {
                $data = array(
                    'category_name' => $other_field,
                    'created_date' => date('Y-m-d h:i:s', time()),
                    'status' => '2',
                    'is_delete' => '0',
                    'is_other' => '1',
                    'user_id' => $userid,
                    'category_slug' => $this->common->clean($other_field)
                );
                $insert_id = $this->common->insert_data_getid($data, 'category');
                if ($insert_id) {
                    $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
                    $search_condition = "((status = '2' AND user_id = $userid) OR (status = '1'))";
                    $category = $this->data['category'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                    if (count($category) > 0) {
                        $select = '<option value="" selected option disabled>Select your field</option>';
                        foreach ($category as $st) {
                            $select .= '<option value="' . $st['category_id'] . '"';
                            if ($st['category_name'] == $other_field) {
                                $select .= 'selected';
                            }
                            $select .= '>' . $st['category_name'] . '</option>';
                        }
                    }
        //For Getting Other at end
                    $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
                    $category_otherdata = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    $select .= '<option value="' . $category_otherdata[0]['category_id'] . '">' . $category_otherdata[0]['category_name'] . '</option>';
                }
            } else {
                $select .= 0;
            }
        } else {
            $select .= 1;
        }


        echo json_encode(array(
            "select" => $select,
        ));
    }

    //FREELANCER_APPLY BOTH OTHER FIELD END

    //FREELANCER APPLY AS APPLIED ON POST SEND MAIL START
    public function apply_email($notid,$post_id) {

        $userid = $this->session->userdata('aileenuser');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_user_image,freelancer_apply_slug', $join_str = array());
        $hiremail = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $notid, $data = 'email', $join_str = array());
        
        $fa_data = $this->freelancer_apply_model->getFreelancerApplyPostDetail($post_id);
        $url = 'freelance-jobs/' .$fa_data->category_name."/".strtolower($fa_data->post_slug)."-".$fa_data->user_id."-".$fa_data->post_id;

        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="'.MAIL_TD_1.'">';
        if ($applydata[0]['freelancer_post_user_image'] == '') {
            $fname = $applydata[0]['freelancer_post_fullname'];
            $lname = $applydata[0]['freelancer_post_username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div></td>';
        } else {
            $email_html .= '<img alt="User Image" src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $applydata[0]['freelancer_post_user_image'] . '" width="60" height="60"></td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Freelancer <b>' . $applydata[0]['freelancer_post_fullname'] . " " . $applydata[0]['freelancer_post_username'] . '</b> Applied on your Project.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a title = "View Detail" class="btn" href="' . base_url($url) . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $applydata[0]['freelancer_post_fullname'] . " " . $applydata[0]['freelancer_post_username'] . ' Applied on your Project.';

        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $notid))->row();

        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
        if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
        {
            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $hiremail[0]['email'],$unsubscribe);
        }
        // mail end  
    }

    //FREELANCER APPLY AS APPLIED ON POST SEND MAIL END
    public function selectemail_user($select_user = '', $post_id = '', $word = '') {
        $invite_user = $select_user;
        $postid = $post_id;
        $writting_word = $word;
        $userid = $this->session->userdata('aileenuser');
        $applydata = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $invite_user, $data = 'freelancer_post_email');
        $projectdata = $this->common->select_data_by_id('freelancer_post', 'post_id', $postid, $data = 'post_name');

        $fa_data = $this->freelancer_apply_model->getFreelancerApplyPostDetail($post_id);
        $url = 'freelance-jobs/' .$fa_data->category_name."/".strtolower($fa_data->post_slug)."-".$fa_data->user_id."-".$fa_data->post_id;

        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr><td style="'.MAIL_TD_1.'">';
        if ($this->data['freehiredata'][0]['freelancer_hire_user_image']) {
            $email_html .= '<img alt="User Image" src="' . FREE_HIRE_PROFILE_THUMB_UPLOAD_URL . $this->data['freehiredata'][0]['freelancer_hire_user_image'] . '" width="60" height="60"></td>';
        } else {
            $fname = $this->data['freehiredata'][0]['fullname'];
            $lname = $this->data['freehiredata'][0]['username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">
                          ' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div> </td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Employer <b>' . $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . '</b> you for ' . $projectdata[0]["post_name"] . ' project in freelancer profile.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a title= "View Detail" class="btn" href="' . base_url($url) . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';
        $subject = $this->data['freehiredata'][0]['fullname'] . " " . $this->data['freehiredata'][0]['username'] . " " . $writting_word . ' you for ' . $projectdata[0]["post_name"] . ' project in Aileensoul.';

        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $invite_user))->row();

        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
        if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
        {
            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $applydata[0]['freelancer_post_email'],$unsubscribe);
        }
    }

    //FREELANCER APPLY NEW REGISTATION PROFILE START
    public function registation($postid = '') {

        $contition_array = array('status' => '1');
        $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('status' => '1', 'is_other' => '0');
        $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
        $search_condition = "( status = '1')";
        $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
        $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


        $contition_array = array('status' => '1', 'type' => '1');
        $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $this->data['title'] = "Registration | Freelancer Profile" . TITLEPOSTFIX;
        $this->data['header_profile'] = $this->load->view('header_profile', $this->data, TRUE);
        if ($this->session->userdata('aileenuser')) {
            $userid = $this->session->userdata('aileenuser');
            $hireuser = $this->db->select('user_id')->get_where('freelancer_post_reg', array('user_id' => $userid))->row()->user_id;
        }
        if ($hireuser) {
            redirect('recommended-freelance-work', refresh);
        } else {
            if($userid != "")
            {                
                $this->data['user_data'] = $this->user_model->getLeftboxData($userid);
                $this->load->view('freelancer_live/freelancer_post/registation', $this->data);
            }
            else
            {
                redirect(base_url('freelancer/create-account'));
            }
        }
    }

    //FREELANCER APPLY NEW REGISTATION PROFILE END
    //FREELANCER APPLY NEW REGISTATION INSERT START
    public function registation_insert($postliveid = '') {
        //echo $postliveid;die();
        $userid = $this->session->userdata('aileenuser');
        $skill1 = $this->input->post('skills');
        $skills = explode(',', $skill1);
        $this->form_validation->set_rules('firstname', 'Full Name', 'required');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'EmailId', 'required|valid_email');
        $this->form_validation->set_rules('country', 'country', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('field', 'Field', 'required');
        $this->form_validation->set_rules('skills', 'skill', 'required');
        if (empty($this->input->post('experience_month')) && empty($this->input->post('experience_year'))) {
            $this->form_validation->set_rules('experiance', 'Experiance', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $contition_array = array('status' => '1');
            $this->data['countries'] = $this->common->select_data_by_condition('countries', $contition_array, $data = 'country_id,country_name', $sortby = 'country_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('status' => '1', 'is_other' => '0');
            $this->data['category'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'category_name !=' => "Other");
            $search_condition = "( status = '1')";
            $this->data['category_data'] = $this->common->select_data_by_search('category', $search_condition, $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');

            $contition_array = array('is_delete' => '0', 'status' => '1', 'category_name' => "Other");
            $this->data['category_otherdata'] = $this->common->select_data_by_condition('category', $contition_array, $data = '*', $sortby = 'category_name', $orderby = 'ASC', $limit = '', $offset = '', $join_str = array(), $groupby = '');


            $contition_array = array('status' => '1', 'type' => '1');
            $this->data['skill1'] = $this->common->select_data_by_condition('skill', $contition_array, $data = '*', $sortby = 'skill', $orderby = 'DESC', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            $this->data['title'] = "Registration | Freelancer Profile" . TITLEPOSTFIX;
            $this->load->view('freelancer/freelancer_post/registation', $this->data);
        } else {

            $contition_array = array('user_id' => $userid, 'is_delete' => '0', 'status' => '1');
            $userdata1 = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');
            if ($userdata1) {
                redirect('recommended-freelance-work', refresh);
            } else {
                if (count($skills) > 0) {
                    foreach ($skills as $ski) {
                        if ($ski != " ") {
                            $contition_array = array('skill' => trim($ski), 'type' => '1');
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            if (count($skilldata) < 0) {
                                $contition_array = array('skill' => trim($ski), 'type' => '5');
                                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                            }
                            if ($skilldata) {
                                $skill[] = $skilldata[0]['skill_id'];
                            } else {
                                $data = array(
                                    'skill' => trim($ski),
                                    'status' => '1',
                                    'type' => '5',
                                    'user_id' => $userid,
                                );
                                $skill[] = $this->common->insert_data_getid($data, 'skill');
                            }
                        }
                    }
                    $skill = array_unique($skill, SORT_REGULAR);
                    $skills = implode(',', $skill);
                }

                $first_name = trim($this->input->post('firstname'));
                $last_name = trim($this->input->post('lastname'));
                $email_reg = trim($this->input->post('email'));
                $first_lastname = $first_name." ".$last_name;
                $user_slug = $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg');

                $data = array(
                    'freelancer_post_fullname' => $first_name,
                    'freelancer_post_username' => $last_name,
                    'freelancer_post_email' => $email_reg,
                    'freelancer_post_country' => trim($this->input->post('country')),
                    'freelancer_post_state' => trim($this->input->post('state')),
                    'freelancer_post_city' => trim($this->input->post('city')),
                    'freelancer_post_field' => trim($this->input->post('field')),
                    'freelancer_post_area' => $skills,
                    'freelancer_post_exp_month' => trim($this->input->post('experience_month')),
                    'freelancer_post_exp_year' => trim($this->input->post('experience_year')),
                    'freelancer_apply_slug' => $user_slug,
                    'user_id' => $userid,
                    'created_date' => date('Y-m-d', time()),
                    'status' => '1',
                    'is_delete' => '0',
                    'free_post_step' => '7'
                );
                $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');                
                if ($insert_id) {
                    if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
                        //Openfire Username Generate Start
                        $authenticationToken = new \Gnello\OpenFireRestAPI\AuthenticationToken(OP_ADMIN_UN, OP_ADMIN_PW);
                        $api = new \Gnello\OpenFireRestAPI\API(OPENFIRESERVER, 9090, $authenticationToken);
                        $op_un_ps = "fa_".str_replace("-", "_", $user_slug);
                        $properties = array();
                        $username = $op_un_ps;
                        $password = $op_un_ps;
                        $name = ucwords($first_name." ".$last_name);
                        $email = $email_reg;
                        $result = $api->Users()->createUser($username, $password, $name, $email, $properties);
                        //Openfire Username Generate End
                    }

                    //Send Promotional Mail Start
                    $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

                    $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                    $this->userdata['firstname'] = $first_name;
                    
                    $email_html = $this->load->view('email_template/freelancer',$this->userdata,TRUE);

                    $subject = $first_name.", Here’s How to Not Miss Great Opportunities.";

                    $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $email,$unsubscribe);
                    //Send Promotional Mail End
                    if(trim($data['freelancer_post_field']) != "")
                    {
                        $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                        $data['freelancer_post_field_txt'] = trim($field_name);
                    }            

                    if($data['freelancer_post_area'] != "")
                    {
                        $skill_name = "";
                        foreach (explode(',',$data['freelancer_post_area']) as $skk => $skv) {
                            if($skv != "" && $skv != "26")
                            {
                                $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                                if(trim($s_name) != "")
                                {
                                    $skill_name .= $s_name.",";
                                }
                            }
                        }
                        $data['freelancer_post_area_txt'] = trim($skill_name,",");
                    }
                    if(trim($data['freelancer_post_country']) != "")
                    {
                        $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                        $data['country_name'] = trim($country_name);
                    }

                    if(trim($data['freelancer_post_state']) != "")
                    {
                        $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                        $data['state_name'] = trim($state_name);
                    }

                    if(trim($data['freelancer_post_city']) != "")
                    {
                        $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                        $data['city_name'] = trim($city_name);
                    }
                    $insert_id1 = $this->common->insert_data_getid($data, 'freelancer_post_reg_search_tmp');

                    if ($postliveid) {
                        $id = trim($postliveid);

                        $userid = $this->session->userdata('aileenuser');
                        $notid = $this->db->select('user_id')->get_where('freelancer_post', array('post_id' => $id))->row()->user_id;

                        $contition_array = array('post_id' => $id, 'user_id' => $userid, 'is_delete' => '0');
                        $userdata = $this->common->select_data_by_condition('freelancer_apply', $contition_array, $data = '*', $sortby = '', $orderby = 'desc', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                        if ($userid == $notid) {

                            $this->session->flashdata('error', 'you can not apply on your own post');
                        } else {
                            if ($userdata) {
                                
                            } else {
                                $data = array(
                                    'post_id' => $id,
                                    'user_id' => $userid,
                                    'status' => '1',
                                    'created_date' => date('Y-m-d h:i:s', time()),
                                    'modify_date' => date('Y-m-d h:i:s', time()),
                                    'is_delete' => '0',
                                    'job_delete' => '0',
                                    'job_save' => '3'
                                );
                                $insert_id = $this->common->insert_data_getid($data, 'freelancer_apply');
                                // insert notification
                                $data = array(
                                    'not_type' => '3',
                                    'not_from_id' => $userid,
                                    'not_to_id' => $notid,
                                    'not_read' => '2',
                                    'not_from' => '4',
                                    'not_product_id' => $insert_id,
                                    "not_active" => '1',
                                    'not_created_date' => date('Y-m-d H:i:s')
                                );

                                $insert_id = $this->common->insert_data_getid($data, 'notification');
                                // end notoification
                                if ($insert_id) {
                                    $this->apply_email($notid,$id);
                                    $applypost = 'Applied';
                                }
                                // echo $applypost;
                            }
                        }
                    }

                    if ($postliveid) {
                        $this->session->set_flashdata('success', 'Applied Sucessfully ......');
                        redirect('freelance-work/home/live-post/', refresh);
                        
                    } else {
                        redirect('recommended-freelance-work', refresh);
                    }
                } else {

                    //   $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                    if ($postliveid) {
                        $this->session->flashdata('error', 'Sorry!! Your data not inserted');
                        redirect('freelance-work/registation' . $postliveid, refresh);
                    } else {
                        redirect('freelance-work/registation', refresh);
                    }
                }
            }
        }
    }

    //FREELANCER APPLY NEW REGISTATION INSERT END
    //CHECK FOR MAIL DESIGNING START
    public function email_view() {
        $userid = 140;
        $notid = 103;
        $postuser = $this->common->select_data_by_id('freelancer_post_reg', 'user_id', $userid, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_user_image,freelancer_apply_slug', $join_str = array());

        $hireuser = $this->common->select_data_by_id('freelancer_hire_reg', 'user_id', $notid, $data = 'email', $join_str = array());

        // apply mail start
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
                                            <td style="padding:5px;">';
        if ($postuser[0]['freelancer_post_user_image'] == '') {
            $fname = $postuser[0]['freelancer_post_fullname'];
            $lname = $postuser[0]['freelancer_post_username'];
            $sub_fname = substr($fname, 0, 1);
            $sub_lname = substr($lname, 0, 1);
            $email_html .= '<div class="post-img-div">' . ucfirst(strtolower($sub_fname)) . ucfirst(strtolower($sub_lname)) . '</div></td>';
        } else {
            $email_html .= '<img alt="User Image" src="' . FREE_POST_PROFILE_THUMB_UPLOAD_URL . $postuser[0]['freelancer_post_user_image'] . '" width="60" height="60"></td>';
        }
        $email_html .= '<td style="padding:5px;">
						<p>Freelancer <b>' . $postuser[0]['freelancer_post_fullname'] . " " . $postuser[0]['freelancer_post_username'] . '</b> Applied on your Project.</p>
						<span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">' . date('j F') . ' at ' . date('H:i') . '</span>
                                            </td>
                                            <td style="padding:5px;">
                                                <p><a title="View Detail" class="btn" href="' . BASEURL . 'freelancer/' . $postuser[0]['freelancer_apply_slug'] . '">view</a></p>
                                            </td>
					</tr>
                                    </table>';

        $this->data['templ'] = $email_html;
        $this->load->view('email_view', $this->data);
    }

    //CHECK FOR MAIL DESIGNING END
    public function session() {
        if ($this->session->userdata('searchkeyword')) {
            $this->session->unset_userdata('searchkeyword');
        }
        if ($this->session->userdata('searchplace')) {
            $this->session->unset_userdata('searchplace');
        }
        $keyword = $_POST['keyword'];
        $keyword1 = $_POST['keyword1'];
        $this->session->set_userdata('searchkeyword', $keyword);
        $this->session->set_userdata('searchplace', $keyword1);
        // $data='yes';
        echo "yes";
    }

    //FOR FREELANCER APPLY PROGRESSBAR START
    public function progressbar() {
        $userid = $this->session->userdata('aileenuser');
        $contition_array = array('user_id' => $userid, 'status' => '1', 'is_delete' => '0');
        $this->data['apply_reg'] = $apply_reg = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = 'freelancer_post_fullname,freelancer_post_username,freelancer_post_skypeid,freelancer_post_email,freelancer_post_phoneno,freelancer_post_country,freelancer_post_state,freelancer_post_city,freelancer_post_pincode,freelancer_post_field,freelancer_post_area,freelancer_post_skill_description,freelancer_post_hourly,freelancer_post_ratestate,freelancer_post_fixed_rate,freelancer_post_job_type,freelancer_post_work_hour,freelancer_post_degree,freelancer_post_stream,freelancer_post_univercity,freelancer_post_collage,freelancer_post_percentage,freelancer_post_passingyear,freelancer_post_portfolio_attachment,freelancer_post_portfolio,freelancer_post_exp_month,freelancer_post_exp_year,progressbar', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array());

        if ($apply_reg > 0) {
            $notEmpty = 0;
            $totalField = 26;

            foreach ($apply_reg as $row) {
                $notEmpty += ($row['freelancer_post_fullname'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_username'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_skypeid'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_email'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_phoneno'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_country'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_state'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_city'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_pincode'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_field'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_area'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_skill_description'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_hourly'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_ratestate'] != '') ? 1 : 0;
                // $notEmpty += ($row['freelancer_post_fixed_rate'] != 0) ? 1 : 0;
                $notEmpty += ($row['freelancer_post_job_type'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_work_hour'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_degree'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_stream'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_univercity'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_collage'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_percentage'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_passingyear'] != '') ? 1 : 0;
                //  $notEmpty += ($row['freelancer_post_eduaddress'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_portfolio_attachment'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_portfolio'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_exp_month'] != '') ? 1 : 0;
                $notEmpty += ($row['freelancer_post_exp_year'] != '') ? 1 : 0;
                //do with all field
            }

            $percentage = $notEmpty / $totalField * 100;
        }

        $this->data['count_profile'] = $percentage;
        $this->data['count_profile_value'] = ($percentage / 100);


        if ($this->data['count_profile'] == 100) {
            if ($apply_reg[0]['progressbar'] != 1) {
                $data = array(
                    'progressbar' => '0',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
            }
        } else {
            $data = array(
                'progressbar' => '0',
                'modify_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        }
    }

    //FOR FREELANCER APPLY PROGRESSBAR END
    public function post_slug() {
        $this->db->select('post_id,post_name');
        $res = $this->db->get('freelancer_post')->result();
        foreach ($res as $k => $v) {
            $data = array('post_slug' => $this->common->clean($v->post_name));
            $this->db->where('post_id', $v->post_id);
            $this->db->update('freelancer_post', $data);
        }
        echo "yes";
    }

    public function category_slug() {
        $this->db->select('category_id,category_name');
        $res = $this->db->get('category')->result();
        foreach ($res as $k => $v) {
            $data = array('category_slug' => $this->common->clean($v->category_name));
            $this->db->where('category_id', $v->category_id);
            $this->db->update('category', $data);
        }
        echo "yes";
    }

    public function skill_slug() {
        $this->db->select('skill_id,skill');
        $res = $this->db->get('skill')->result();
        foreach ($res as $k => $v) {
            $data = array('skill_slug' => $this->common->clean($v->skill));
            $this->db->where('skill_id', $v->skill_id);
            $this->db->update('skill', $data);
        }
        echo "yes";
    }

    public function freelancer_notification_count($to_id = '') {
        $contition_array = array('not_read' => '2', 'not_to_id' => $to_id, 'not_type !=' => '1', 'not_type !=' => '2');
        $result = $this->common->select_data_by_condition('notification', $contition_array, $data = 'count(*) as total', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

        $count = $result[0]['total'];
        return $count;
    }
    //function user when live link and login start

    public function registation_insert_new($postliveid = '') {
        //echo $postliveid;die();
        $userid = $this->session->userdata('aileenuser');

        $this->data['userid'] = $userid = $this->session->userdata('aileenuser');
        $errors = array();
        $data = array();

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if (empty($_POST['first_name']))
            $errors['errorFname'] = 'Firstname is required.';

        if (empty($_POST['last_name']))
            $errors['errorLname'] = 'Lastname is required.';

        if (empty($_POST['email']))
            $errors['errorEmail'] = 'Email is required.';

        if (!empty($errors)) {
            $data['errors'] = $errors;
        }
        else
        {
            $firstname = trim($_POST['first_name']);
            $lastname = trim($_POST['last_name']);
            $email = trim($_POST['email']);
            $country = trim($_POST['country']);
            $state = trim($_POST['state']);
            $city = trim($_POST['city']);
            $field = trim($_POST['field']);
            $experience_year = trim($_POST['experience_year']);
            $experience_month = trim($_POST['experience_month']);
            $phoneno = trim($_POST['phoneno']);
            $skill1 = trim($_POST['skills']);
            $skills = explode(',', $skill1);
            if (count($skills) > 0) {
                foreach ($skills as $skk=>$ski) {
                    if (trim($ski) != "") {
                        $contition_array = array('skill' => trim($ski), 'type' => '1');
                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        if (count($skilldata) < 0) {
                            $contition_array = array('skill' => trim($ski), 'type' => '5');
                            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                        }
                        if ($skilldata) {
                            $skill[] = $skilldata[0]['skill_id'];
                        } else {
                            $data = array(
                                'skill' => trim($ski),
                                'status' => '1',
                                'type' => '5',
                                'user_id' => $userid,
                            );
                            $skill[] = $this->common->insert_data_getid($data, 'skill');
                        }
                    }
                }
                $skill = array_unique($skill, SORT_REGULAR);
                $skills = implode(',', $skill);
            }

            $first_lastname = $firstname . " " . $lastname;
            $user_slug = $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg');
            $data = array(
                'freelancer_post_fullname' => $firstname,
                'freelancer_post_username' => $lastname,
                'freelancer_post_email' => $email,
                'freelancer_post_country' => $country,
                'freelancer_post_state' => $state,
                'freelancer_post_city' => $city,
                'freelancer_post_field' => $field,
                'freelancer_post_area' => $skills,
                'freelancer_post_exp_month' => $experience_month,
                'freelancer_post_exp_year' => $experience_year,
                'freelancer_apply_slug' => $user_slug,
                'user_id' => $userid,
                'created_date' => date('Y-m-d', time()),
                'status' => '1',
                'is_delete' => '0',
                'free_post_step' => '7'
            );
            $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');            
            if ($insert_id) {
                if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
                    //Openfire Username Generate Start
                    $authenticationToken = new \Gnello\OpenFireRestAPI\AuthenticationToken(OP_ADMIN_UN, OP_ADMIN_PW);
                    $api = new \Gnello\OpenFireRestAPI\API(OPENFIRESERVER, 9090, $authenticationToken);
                    $op_un_ps = "fa_".str_replace("-", "_", $user_slug);
                    $properties = array();
                    $username = $op_un_ps;
                    $password = $op_un_ps;
                    $name = ucwords($firstname." ".$lastname);
                    $email = $email;
                    $result = $api->Users()->createUser($username, $password, $name, $email, $properties);
                    //Openfire Username Generate End
                }

                //Send Promotional Mail Start
                $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

                $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                $this->userdata['firstname'] = $firstname;
                
                $email_html = $this->load->view('email_template/freelancer',$this->userdata,TRUE);                

                $subject = $firstname.", Here’s How to Not Miss Great Opportunities.";

                $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $email,$unsubscribe);
                //Send Promotional Mail End

                if(trim($data['freelancer_post_field']) != "")
                {
                    $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                    $data['freelancer_post_field_txt'] = trim($field_name);
                }            

                if($data['freelancer_post_area'] != "")
                {
                    $skill_name = "";
                    foreach (explode(',',$data['freelancer_post_area']) as $skk => $skv) {
                        if($skv != "")
                        {
                            $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                            if(trim($s_name) != "")
                            {
                                $skill_name .= $s_name.",";
                            }
                        }
                    }
                    $data['freelancer_post_area_txt'] = trim($skill_name,",");
                }
                if(trim($data['freelancer_post_country']) != "")
                {
                    $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                    $data['country_name'] = trim($country_name);
                }

                if(trim($data['freelancer_post_state']) != "")
                {
                    $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                    $data['state_name'] = trim($state_name);
                }

                if(trim($data['freelancer_post_city']) != "")
                {
                    $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                    $data['city_name'] = trim($city_name);
                }                
                $insert_id1 = $this->common->insert_data_getid($data, 'freelancer_post_reg_search_tmp');
                $data = array("is_success" => 1);
            }
            else
            {
                $data['errors'] = $errors['not_sucess'] = "Please Try again";
            }
        }
        echo json_encode($data);
    }

    // GET ALL FILTER DATA FOR FREELANCER HIRE
    function get_filter_data(){
        $limitstart = ($_POST['limitstart']) ? $_POST['limitstart'] : 0;
        $limit = ($_POST['limit']) ? $_POST['limit'] : 5;
        $result['freelancer_category'] = $this->freelancer_apply_model->get_filter_category($limitstart,10);
        $result['freelancer_cities'] = $this->freelancer_apply_model->get_filter_cities($limitstart,30);
        $result['freelancer_skills'] = $this->freelancer_apply_model->get_filter_skills($limitstart,30);
        $result['freelancer_experience'] = $this->freelancer_apply_model->get_filter_experience($limitstart,$limit);
        echo json_encode($result);
    }

    public function save_company()
    {
        $userid = $this->session->userdata('aileenuser');        

        $comp_name = trim($this->input->post('comp_name'));        
        $first_lastname = strtolower($comp_name);
        $comp_number = trim($this->input->post('comp_number'));
        $email = trim($this->input->post('email'));
        $comp_website = trim($this->input->post('comp_website'));
        $country = trim($this->input->post('country'));
        $state = trim($this->input->post('state'));
        $city = trim($this->input->post('city'));
        $field = trim($this->input->post('field'));
        $comp_overview = trim($this->input->post('comp_overview'));
        
        $experience_year = trim($this->input->post('experience_year'));
        $experience_month = trim($this->input->post('experience_month'));

        $skill1 = trim($this->input->post('skills'));

        $skills = explode(',', $skill1);
        if (count($skills) > 0) {
            foreach ($skills as $skk=>$ski) {
                if (trim($ski) != "") {
                    $contition_array = array('skill' => trim($ski), 'type' => '1');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    if (count($skilldata) < 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '5');
                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($skilldata) {
                        $skill[] = $skilldata[0]['skill_id'];
                    } else {
                        $skill_slug = $this->common->clean($ski);
                        $data = array(
                            'skill' => trim($ski),
                            'status' => '1',
                            'type' => '5',
                            'user_id' => $userid,
                            'skill_image' => $skill_slug.".png",
                            'skill_slug' => $skill_slug
                        );
                        $skill[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
            $skill = array_unique($skill, SORT_REGULAR);
            $skills = implode(',', $skill);
        }
        
        $user_slug = $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg');
        $data = array(
            'comp_name' => $comp_name,
            'comp_number' => $comp_number,
            'comp_email' => $email,
            'comp_website' => $comp_website,
            'comp_exp_month' => $experience_month,
            'comp_exp_year' => $experience_year,
            'comp_overview' => $comp_overview,
            'freelancer_post_country' => $country,
            'freelancer_post_state' => $state,
            'freelancer_post_city' => $city,
            'freelancer_post_field' => $field,
            'freelancer_post_area' => $skills,
            'freelancer_apply_slug' => $user_slug,
            'is_indivdual_company' => '2',
            'user_id' => $userid,
            'created_date' => date('Y-m-d', time()),
            'status' => '1',
            'is_delete' => '0',
            'free_post_step' => '7'
        );
        $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');            
        if ($insert_id) {
            if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
                //Openfire Username Generate Start
                $authenticationToken = new \Gnello\OpenFireRestAPI\AuthenticationToken(OP_ADMIN_UN, OP_ADMIN_PW);
                $api = new \Gnello\OpenFireRestAPI\API(OPENFIRESERVER, 9090, $authenticationToken);
                $op_un_ps = "fa_".str_replace("-", "_", $user_slug);
                $properties = array();
                $username = $op_un_ps;
                $password = $op_un_ps;
                $name = ucwords($first_name." ".$last_name);
                $email = $email;
                $result = $api->Users()->createUser($username, $password, $name, $email, $properties);
                //Openfire Username Generate End
            }

            //Send Promotional Mail Start
            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

            $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            $this->userdata['firstname'] = $first_name;
            
            $email_html = $this->load->view('email_template/freelancer',$this->userdata,TRUE);                

            $subject = $first_name.", Here’s How to Not Miss Great Opportunities.";

            $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $email,$unsubscribe);
            //Send Promotional Mail End

            if(trim($data['freelancer_post_field']) != "")
            {
                $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                $data['freelancer_post_field_txt'] = trim($field_name);
            }            

            if($data['freelancer_post_area'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$data['freelancer_post_area']) as $skk => $skv) {
                    if($skv != "")
                    {
                        $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }
                }
                $data['freelancer_post_area_txt'] = trim($skill_name,",");
            }
            if(trim($data['freelancer_post_country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                $data['country_name'] = trim($country_name);
            }

            if(trim($data['freelancer_post_state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                $data['state_name'] = trim($state_name);
            }

            if(trim($data['freelancer_post_city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                $data['city_name'] = trim($city_name);
            }

            $insert_id1 = $this->common->insert_data_getid($data, 'freelancer_post_reg_search_tmp');

            $ret_arr = array("success"=>1);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }

        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_individual()
    {
        // print_r($this->input->post());exit();
        $userid = $this->session->userdata('aileenuser');        

        $first_name = trim($this->input->post('first_name'));
        $last_name = trim($this->input->post('last_name'));
        $first_lastname = strtolower($first_name . $last_name);
        $email = trim($this->input->post('email'));
        $current_position = trim($this->input->post('current_position'));
        $country = trim($this->input->post('country'));
        $state = trim($this->input->post('state'));
        $city = trim($this->input->post('city'));
        $field = trim($this->input->post('field'));
        $phoneno = trim($this->input->post('phoneno'));
        $experience_year = trim($this->input->post('experience_year'));
        $experience_month = trim($this->input->post('experience_month'));
        $skill1 = trim($this->input->post('skills'));
        

        $job_title = $this->data_model->findJobTitle($current_position);
        if ($job_title['title_id'] != '') {
            $jobTitleId = $job_title['title_id'];
        } else {
            $data = array();
            $data['name'] = $current_position;
            $data['created_date'] = date('Y-m-d H:i:s', time());
            $data['modify_date'] = date('Y-m-d H:i:s', time());
            $data['status'] = 'draft';
            $data['slug'] = $this->common->clean($current_position);
            $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
        }

        $skills = explode(',', $skill1);
        if (count($skills) > 0) {
            foreach ($skills as $skk=>$ski) {
                if (trim($ski) != "") {
                    $contition_array = array('skill' => trim($ski), 'type' => '1');
                    $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    if (count($skilldata) < 0) {
                        $contition_array = array('skill' => trim($ski), 'type' => '5');
                        $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
                    }
                    if ($skilldata) {
                        $skill[] = $skilldata[0]['skill_id'];
                    } else {
                        $skill_slug = $this->common->clean($ski);
                        $data = array(
                            'skill' => trim($ski),
                            'status' => '1',
                            'type' => '5',
                            'user_id' => $userid,
                            'skill_image' => $skill_slug.".png",
                            'skill_slug' => $skill_slug
                        );
                        $skill[] = $this->common->insert_data_getid($data, 'skill');
                    }
                }
            }
            $skill = array_unique($skill, SORT_REGULAR);
            $skills = implode(',', $skill);
        }
        
        $user_slug = $this->setcategory_slug($first_lastname, 'freelancer_apply_slug', 'freelancer_post_reg');
        $data = array(
            'freelancer_post_fullname' => $first_name,
            'freelancer_post_username' => $last_name,
            'freelancer_post_email' => $email,
            'freelancer_post_country' => $country,
            'freelancer_post_state' => $state,
            'freelancer_post_city' => $city,
            'freelancer_post_field' => $field,
            'freelancer_post_area' => $skills,
            'freelancer_post_exp_month' => $experience_month,
            'freelancer_post_exp_year' => $experience_year,
            'freelancer_apply_slug' => $user_slug,
            'current_position' => $jobTitleId,
            'is_indivdual_company' => '1',
            'user_id' => $userid,
            'created_date' => date('Y-m-d', time()),
            'status' => '1',
            'is_delete' => '0',
            'free_post_step' => '7'
        );
        $insert_id = $this->common->insert_data_getid($data, 'freelancer_post_reg');            
        if ($insert_id) {
            if ($_SERVER['HTTP_HOST'] == "www.aileensoul.com") {
                //Openfire Username Generate Start
                $authenticationToken = new \Gnello\OpenFireRestAPI\AuthenticationToken(OP_ADMIN_UN, OP_ADMIN_PW);
                $api = new \Gnello\OpenFireRestAPI\API(OPENFIRESERVER, 9090, $authenticationToken);
                $op_un_ps = "fa_".str_replace("-", "_", $user_slug);
                $properties = array();
                $username = $op_un_ps;
                $password = $op_un_ps;
                $name = ucwords($first_name." ".$last_name);
                $email = $email;
                $result = $api->Users()->createUser($username, $password, $name, $email, $properties);
                //Openfire Username Generate End
            }

            //Send Promotional Mail Start
            $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe')->get_where('user', array('user_id' => $userid))->row();

            $this->userdata['unsubscribe_link'] = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
            $this->userdata['firstname'] = $first_name;
            
            $email_html = $this->load->view('email_template/freelancer',$this->userdata,TRUE);                

            $subject = $first_name.", Here’s How to Not Miss Great Opportunities.";

            $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $email,$unsubscribe);
            //Send Promotional Mail End

            if(trim($data['freelancer_post_field']) != "")
            {
                $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                $data['freelancer_post_field_txt'] = trim($field_name);
            }            

            if($data['freelancer_post_area'] != "")
            {
                $skill_name = "";
                foreach (explode(',',$data['freelancer_post_area']) as $skk => $skv) {
                    if($skv != "")
                    {
                        $s_name = $this->db->get_where('skill', array('skill_id' => $skv))->row()->skill;
                        if(trim($s_name) != "")
                        {
                            $skill_name .= $s_name.",";
                        }
                    }
                }
                $data['freelancer_post_area_txt'] = trim($skill_name,",");
            }
            if(trim($data['freelancer_post_country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                $data['country_name'] = trim($country_name);
            }

            if(trim($data['freelancer_post_state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                $data['state_name'] = trim($state_name);
            }

            if(trim($data['freelancer_post_city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                $data['city_name'] = trim($city_name);
            }

            $data['current_position_txt'] = trim($current_position);

            $insert_id1 = $this->common->insert_data_getid($data, 'freelancer_post_reg_search_tmp');

            $ret_arr = array("success"=>1);
        }
        else
        {
            $ret_arr = array("success"=>0);
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
            $free_apply_education_upload_path = $this->config->item('free_apply_education_upload_path');
            $user_edu_file_old = $free_apply_education_upload_path . $edu_file_old;
            if (isset($user_edu_file_old)) {
                unlink($user_edu_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_education_upload_path,
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
                $main_image = $free_apply_education_upload_path . $fileName;
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
            $user_project_insert = $this->freelancer_apply_model->set_user_education($user_id,$edu_school_college,$edu_university,$edu_other_university,$edu_degree,$edu_stream,$edu_other_degree,$edu_other_stream,$edu_start_date,$edu_end_date,$edu_nograduate,$fileName,$edit_edu);
            $user_education = $this->freelancer_apply_model->get_user_education($user_id);            
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
            $user_exp_insert = $this->freelancer_apply_model->delete_user_education($user_id,$edu_id);
            $user_education = $this->freelancer_apply_model->get_user_education($user_id);
            // $profile_progress = $this->progressbar_new($user_id);              
            $ret_arr = array("success"=>1,"user_education"=>$user_education,"profile_progress"=>$profile_progress);
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
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_education = $this->freelancer_apply_model->get_user_education($userid);        
        $ret_arr = array("success"=>1,"user_education"=>$user_education);        
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
            $free_apply_experience_upload_path = $this->config->item('free_apply_experience_upload_path');
            $user_exp_file_old = $free_apply_experience_upload_path . $exp_file_old;
            if (isset($user_exp_file_old)) {
                unlink($user_exp_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_experience_upload_path,
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
                $main_image = $free_apply_experience_upload_path . $fileName;
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
            $user_exp_insert = $this->freelancer_apply_model->set_user_experience($user_id,$exp_company_name,$exp_designation_id,$exp_company_website,$exp_field,$exp_other_field,$exp_country,$exp_state,$exp_city,$exp_start_date,$exp_end_date,$exp_isworking,$exp_desc,$fileName,$edit_exp);
            $user_experience = $this->freelancer_apply_model->get_user_experience($user_id);
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
            $user_exp_insert = $this->freelancer_apply_model->delete_user_experience($user_id,$exp_id);
            $user_experience = $this->freelancer_apply_model->get_user_experience($user_id);
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
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_experience = $this->freelancer_apply_model->get_user_experience($userid);
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
            $free_apply_addicourse_upload_path = $this->config->item('free_apply_addicourse_upload_path');
            $user_addicourse_file_old = $free_apply_addicourse_upload_path . $addicourse_file_old;
            if (isset($user_addicourse_file_old)) {
                unlink($user_addicourse_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_addicourse_upload_path,
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
                $main_image = $free_apply_addicourse_upload_path . $fileName;
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
            $user_activity_insert = $this->freelancer_apply_model->set_user_addicourse($user_id,$addicourse_name,$addicourse_org,$addicourse_start_date,$addicourse_end_date,$addicourse_url,$fileName,$edit_addicourse);
            $user_addicourse = $this->freelancer_apply_model->get_user_addicourse($user_id);
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
            $user_addicourse_insert = $this->freelancer_apply_model->delete_user_addicourse($user_id,$addicourse_id);
            $user_addicourse = $this->freelancer_apply_model->get_user_addicourse($user_id);
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
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_addicourse = $this->freelancer_apply_model->get_user_addicourse($userid);        
        $ret_arr = array("success"=>1,"user_addicourse"=>$user_addicourse);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_publication()
    {
        $edit_publication = $this->input->post('edit_publication');        
        $pub_file_old = ($this->input->post('pub_file_old') != "" && $this->input->post('pub_file_old') != "undefined" ? $this->input->post('pub_file_old') : '');
        $pub_title = $this->input->post('pub_title');
        $pub_author = $this->input->post('pub_author');
        $pub_url = $this->input->post('pub_url');
        $pub_publisher = $this->input->post('pub_publisher');
        $pub_desc = $this->input->post('pub_desc');
        $publication_date = $this->input->post('pub_year_txt').'-'.$this->input->post('pub_month_txt').'-'.$this->input->post('pub_day_txt');
        $fileName = $pub_file_old;
        if(isset($_FILES['pub_file']['name']) && $_FILES['pub_file']['name'] != "")
        {
            $free_apply_publication_upload_path = $this->config->item('free_apply_publication_upload_path');
            $user_publication_file_old = $free_apply_publication_upload_path . $pub_file_old;
            if (isset($user_publication_file_old)) {
                unlink($user_publication_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_publication_upload_path,
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
                $main_image = $free_apply_publication_upload_path . $fileName;
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
            $user_publication = $this->freelancer_apply_model->set_user_publication($user_id,$pub_title,$pub_author,$pub_url,$pub_publisher,$pub_desc,$publication_date,$fileName,$edit_publication);
            $user_publication = $this->freelancer_apply_model->get_user_publication($user_id);
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
            $user_publication_insert = $this->freelancer_apply_model->delete_user_publication($user_id,$publication_id);
            $user_publication = $this->freelancer_apply_model->get_user_publication($user_id);
            $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_publication()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_publication = $this->freelancer_apply_model->get_user_publication($userid);
        $ret_arr = array("success"=>1,"user_publication"=>$user_publication);
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
            $this->db->delete('freelancer_user_languages');

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
                        $insert_id = $this->common->insert_data($data, 'freelancer_user_languages');
                    }
                }
            }            
        }

        $user_languages = $this->freelancer_apply_model->get_user_languages($userid);
        $ret_arr = array("success"=>1,"user_languages"=>$user_languages);
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_languages()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_languages = $this->freelancer_apply_model->get_user_languages($userid);
        $ret_arr = array("success"=>1,"user_languages"=>$user_languages);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    function save_user_links()
    {
        $userid = $this->session->userdata('aileenuser');
        $link_type = $this->input->post('link_type');
        $link_url = $this->input->post('link_url');
        $personal_link_url = $this->input->post('personal_link_url');

        $this->db->where('user_id', $userid);
        $this->db->delete('freelancer_user_links');

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
                    $insert_id = $this->common->insert_data($data, 'freelancer_user_links');
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
                    $insert_id = $this->common->insert_data($data, 'freelancer_user_links');
                }
            }
        }

        $user_social_links_data = $this->freelancer_apply_model->get_user_social_links($userid);        
        $user_personal_links_data = $this->freelancer_apply_model->get_user_personal_links($userid);        
        $ret_arr = array("success"=>1,"user_social_links_data"=>$user_social_links_data,"user_personal_links_data"=>$user_personal_links_data);
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_links()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        $user_social_links_data = $this->freelancer_apply_model->get_user_social_links($userid);        
        $user_personal_links_data = $this->freelancer_apply_model->get_user_personal_links($userid);        
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

    public function save_user_skills()
    {
        $userid = $this->session->userdata('aileenuser');
        $skills = $this->input->post('user_skills');
        $skill_ids = "";
        $skill_names = "";
        foreach ($skills as $title) {
            $ski = $title['name'];
            $contition_array = array('skill' => trim($ski), 'type' => '1');
            $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');

            if (!$skilldata) {
                $contition_array = array('skill' => trim($ski), 'type' => '5');
                $skilldata = $this->common->select_data_by_condition('skill', $contition_array, $data = 'skill_id,skill', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str5 = '', $groupby = '');
            }
            if ($skilldata) {

                $skill_id = $skilldata[0]['skill_id'];
            } else {
                $skill_slug = $this->common->clean($ski);
                $data = array(
                    'skill' => trim($ski),
                    'status' => '1',
                    'type' => '5',
                    'user_id' => $userid,
                    'skill_image' => $skill_slug.".png",
                    'skill_slug' => $skill_slug
                );
                $skill_id = $this->common->insert_data_getid($data, 'skill');
            }
            $skill_names .= $ski. ',';
            $skill_ids .= $skill_id . ',';
        }
        $skill_ids = trim($skill_ids, ',');
        $skill_names = trim($skill_names, ',');
        $data = array('freelancer_post_area' => $skill_ids);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('freelancer_post_area' => $skill_ids,'freelancer_post_area_txt' => $skill_names);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

            $skills_data = $this->freelancer_apply_model->get_user_skills($userid);
            $skills_data_edit = $skills_data;
            $ret_arr = array("success"=>1,"skills_data"=>$skills_data,"skills_data_edit"=>$skills_data_edit);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_skills()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        $skills_data = $this->freelancer_apply_model->get_user_skills($userid);
        $skills_data_edit = $skills_data;
        $ret_arr = array("success"=>1,"skills_data"=>$skills_data,"skills_data_edit"=>$skills_data_edit);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_freelancer_skills() {
        $skills = $this->freelancer_apply_model->get_skills();
        echo json_encode($skills);
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

                $skill_slug = $this->common->clean($ski);
                $data = array(
                    'skill' => trim($ski),
                    'status' => '1',
                    'type' => '5',
                    'user_id' => $userid,
                    'skill_image' => $skill_slug.".png",
                    'skill_slug' => $skill_slug
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
            $free_apply_project_upload_path = $this->config->item('free_apply_project_upload_path');
            $user_proj_file_old = $free_apply_project_upload_path . $project_file_old;
            if (isset($user_proj_file_old)) {
                unlink($user_proj_file_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_project_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['project_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('project_file')){
                $main_image = $free_apply_project_upload_path . $fileName;
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
            $user_project_insert = $this->freelancer_apply_model->set_user_project($user_id,$project_title,$project_team,$project_role,$project_skill_ids,$project_field,$project_other_field,$project_url,$project_partner_name,$project_start_date,$project_end_date,$project_desc,$fileName,$edit_project);
            $user_projects = $this->freelancer_apply_model->get_user_project($user_id);            
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
            $user_exp_insert = $this->freelancer_apply_model->delete_user_project($user_id,$project_id);
            $user_projects = $this->freelancer_apply_model->get_user_project($user_id);
            $ret_arr = array("success"=>1,"user_projects"=>$user_projects);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_user_project()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');

        $user_projects = $this->freelancer_apply_model->get_user_project($userid);        
        $ret_arr = array("success"=>1,"user_projects"=>$user_projects);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_prof_summary()
    {
        $prof_summary = $this->input->post('prof_summary');
        $userid = $this->session->userdata('aileenuser');
        $data = array('freelancer_post_skill_description' => $prof_summary);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('freelancer_post_skill_description' => $prof_summary);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            $ret_arr = array("success"=>1,"user_prof_summary"=>$prof_summary);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_prof_summary()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');

        $user_prof_summary = $this->freelancer_apply_model->get_user_prof_summary($userid);
        $ret_arr = array("success"=>1,"user_prof_summary"=>$user_prof_summary);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_company_overview()
    {
        $company_overview = $this->input->post('company_overview');
        $userid = $this->session->userdata('aileenuser');
        $data = array('comp_overview' => $company_overview);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('comp_overview' => $company_overview);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            $ret_arr = array("success"=>1,"user_company_overview"=>$company_overview);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        // $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_company_overview()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_company_overview = $this->freelancer_apply_model->get_user_company_overview($userid);
        $ret_arr = array("success"=>1,"user_company_overview"=>$user_company_overview);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_tagline()
    {
        $user_tagline = $this->input->post('user_tagline');
        $userid = $this->session->userdata('aileenuser');
        $data = array('tagline' => $user_tagline);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('tagline' => $user_tagline);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            $ret_arr = array("success"=>1,"user_tagline"=>$user_tagline);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        // $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_tagline()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_tagline = $this->freelancer_apply_model->get_user_tagline($userid);
        $ret_arr = array("success"=>1,"user_tagline"=>$user_tagline);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_availability()
    {
        $freelancer_avail_week = $this->input->post('freelancer_avail_week');
        $freelancer_avail_status = $this->input->post('freelancer_avail_status');

        $userid = $this->session->userdata('aileenuser');
        $data = array('freelancer_avail_week' => $freelancer_avail_week,'freelancer_avail_status' => $freelancer_avail_status);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('freelancer_avail_week' => $freelancer_avail_week,'freelancer_avail_status' => $freelancer_avail_status);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            $user_availability = $this->freelancer_apply_model->get_user_availability($userid);
            $ret_arr = array("success"=>1,"user_availability"=>$user_availability);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_availability()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_availability = $this->freelancer_apply_model->get_user_availability($userid);
        $ret_arr = array("success"=>1,"user_availability"=>$user_availability);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_rate()
    {
        $rate_currency = $this->input->post('rate_currency');
        $rate_amt = $this->input->post('rate_amt');
        $rate_type = $this->input->post('rate_type');

        $userid = $this->session->userdata('aileenuser');
        $data = array('rate_currency' => $rate_currency,'rate_amt' => $rate_amt,'rate_type' => $rate_type);
        $udpate_data = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
        if($udpate_data)
        {
            $data1 = array('rate_currency' => $rate_currency,'rate_amt' => $rate_amt,'rate_type' => $rate_type);
            $udpate_data1 = $this->common->update_data($data1, 'freelancer_post_reg_search_tmp', 'user_id', $userid);
            $user_rate = $this->freelancer_apply_model->get_user_rate($userid);
            $ret_arr = array("success"=>1,"user_rate"=>$user_rate);
        }
        else
        {
            $ret_arr = array("success"=>0);   
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));        
    }

    public function get_user_rate()
    {
        $user_slug = $this->input->post('user_slug');
        $userid = $this->db->select('user_id')->get_where('freelancer_post_reg', array('freelancer_apply_slug' => $user_slug,'status' => '1'))->row('user_id');
        
        $user_rate = $this->freelancer_apply_model->get_user_rate($userid);
        $ret_arr = array("success"=>1,"user_rate"=>$user_rate);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_review()
    {
        $from_user_id = $this->input->post('from_user_id');
        $to_user_id = $this->input->post('to_user_id');
        $review_star = $this->input->post('review_star');
        $review_desc = $this->input->post('review_desc');

        $fileName = "";
        if(isset($_FILES['review_file']['name']) && $_FILES['review_file']['name'] != "")
        {
            $review_upload_path = $this->config->item('review_upload_path');
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $review_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['review_file']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('review_file')){
                $main_image = $review_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }

        if($from_user_id != '' && $to_user_id != '')
        {
            $user_project_insert = $this->freelancer_apply_model->set_save_review($from_user_id,$to_user_id,$review_star,$review_desc,$fileName);
            $review_data = $this->freelancer_apply_model->get_save_review($to_user_id);
            
            $review_count = $this->freelancer_apply_model->get_review_count($to_user_id);
            $review_avarage = $this->freelancer_apply_model->get_review_avarage($to_user_id);
            
            $sum_star = 0;
            $sum_count = 0;
            foreach ($review_avarage as $key => $value) {
                $sum_star = $sum_star + ($value['rating_count'] * $value['review_star']);
                $sum_count = $sum_count + $value['rating_count'];
            }                       
            $avarage_review = round($sum_star / $sum_count,1);
            
            $ret_arr = array("success"=>1,"review_data"=>$review_data,"review_count"=>$review_count['total_review'],"avarage_review"=>$avarage_review);

        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_review()
    {
        $to_user_id = $this->input->post('to_user_id');
        if($to_user_id != '')
        {            
            $review_data = $this->freelancer_apply_model->get_save_review($to_user_id);
            if(!empty($review_data))
            {               
                $review_count = $this->freelancer_apply_model->get_review_count($to_user_id);
                $review_avarage = $this->freelancer_apply_model->get_review_avarage($to_user_id);
                
                $sum_star = 0;
                $sum_count = 0;
                foreach ($review_avarage as $key => $value) {
                    $sum_star = $sum_star + ($value['rating_count'] * $value['review_star']);
                    $sum_count = $sum_count + $value['rating_count'];
                }                       
                $avarage_review = round($sum_star / $sum_count,1);
                
                $ret_arr = array("success"=>1,"review_data"=>$review_data,"review_count"=>$review_count['total_review'],"avarage_review"=>$avarage_review);
            }
            else
            {
                $ret_arr = array("success"=>1,"review_data"=>$review_data);
            }
        }
        else
        {
            $ret_arr = array("success"=>0,"review_data"=>array());
        }
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_company_info()
    {
        $to_user_id = $this->input->post('to_user_id');
        if($to_user_id != '')
        {            
            $company_info = $this->freelancer_apply_model->get_company_info($to_user_id);
            $ret_arr = array("success"=>1,"company_info"=>$company_info);
        }
        else
        {
            $ret_arr = array("success"=>0,"company_info"=>array());
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($to_user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_company_info()
    {
        /*print_r($_POST);
        print_r($_FILES);
        exit();*/
        $userid = $this->session->userdata('aileenuser');
        $comp_logo_old = $this->input->post('comp_logo_old');
        $comp_name = $this->input->post('comp_name');
        $comp_field = $this->input->post('comp_field');
        $comp_email = $this->input->post('comp_email');
        $comp_skype = $this->input->post('comp_skype');
        $comp_number = $this->input->post('comp_number');        
        $comp_teamsize = $this->input->post('comp_teamsize');
        $comp_website = $this->input->post('comp_website');
        $comp_founded_year = $this->input->post('comp_founded_year');
        $comp_founded_month = $this->input->post('comp_founded_month');        
        $comp_service_offer = $this->input->post('comp_service_offer');
        $comp_exp_year = $this->input->post('comp_exp_year');
        $comp_exp_month = $this->input->post('comp_exp_month');
        $company_country = $this->input->post('company_country');
        $company_state = $this->input->post('company_state');
        $company_city = $this->input->post('company_city');

        $fileName = $comp_logo_old;
        if(isset($_FILES['comp_logo']['name']) && $_FILES['comp_logo']['name'] != "")
        {
            $free_apply_comp_logo_upload_path = $this->config->item('free_apply_comp_logo_upload_path');

            if ($comp_logo_old != '') {
                $comp_logo_old = $free_apply_comp_logo_upload_path . $comp_logo_old;
                @unlink($comp_logo_old);
            }
            $config = array(
                'image_library' => 'gd',
                'upload_path'   => $free_apply_comp_logo_upload_path,
                'allowed_types' => $this->config->item('user_post_main_allowed_types'),
                'overwrite'     => true,
                'remove_spaces' => true
            );
            $store = $_FILES['comp_logo']['name'];
            $store_ext = explode('.', $store);        
            $store_ext = $store_ext[count($store_ext)-1];
            $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
            $config['file_name'] = $fileName;
            $this->upload->initialize($config);
            $imgdata = $this->upload->data();
            if($this->upload->do_upload('comp_logo')){
                $main_image = $free_apply_comp_logo_upload_path . $fileName;
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }
            }
        }

        if($userid != '')
        {
            $company_info_insert = $this->freelancer_apply_model->set_save_company_info($userid,$comp_name,$comp_field,$comp_email,$comp_skype,$comp_number,$comp_teamsize,$comp_website,$comp_founded_year,$comp_founded_month,$comp_service_offer,$comp_exp_year,$comp_exp_month,$company_country,$company_state,$company_city,$fileName);

            $company_info = $this->freelancer_apply_model->get_company_info($userid);
            $ret_arr = array("success"=>1,"company_info"=>$company_info);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function get_basic_info()
    {
        $to_user_id = $this->input->post('to_user_id');
        if($to_user_id != '')
        {            
            $basic_info = $this->freelancer_apply_model->get_basic_info($to_user_id);
            $ret_arr = array("success"=>1,"basic_info"=>$basic_info);
        }
        else
        {
            $ret_arr = array("success"=>0,"basic_info"=>array());
        }
        $ret_arr['profile_progress'] = $this->progressbar_new($to_user_id);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function save_user_basic()
    {
        $userid = $this->session->userdata('aileenuser');        
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $current_position = $this->input->post('current_position');
        $basic_field = $this->input->post('basic_field');
        $basic_email = $this->input->post('basic_email');        
        $basic_skype = $this->input->post('basic_skype');
        $basic_phoneno = $this->input->post('basic_phoneno');
        $basic_country = $this->input->post('basic_country');
        $basic_state = $this->input->post('basic_state');        
        $basic_city = $this->input->post('basic_city');

        if($userid != '')
        {
            $job_title = $this->data_model->findJobTitle($current_position);
            if ($job_title['title_id'] != '') {
                $jobTitleId = $job_title['title_id'];
            } else {
                $data = array();
                $data['name'] = $current_position;
                $data['created_date'] = date('Y-m-d H:i:s', time());
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $data['status'] = 'draft';
                $data['slug'] = $this->common->clean($current_position);
                $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
            }

            $data = array(
                'freelancer_post_fullname' => $first_name,
                'freelancer_post_username' => $last_name,
                'freelancer_post_email' => $basic_email,
                'freelancer_post_country' => $basic_country,
                'freelancer_post_state' => $basic_state,
                'freelancer_post_city' => $basic_city,
                'freelancer_post_field' => $basic_field,
                'current_position' => $jobTitleId,
                'freelancer_post_phoneno' => $basic_phoneno,
                'freelancer_post_skypeid' => $basic_skype,
                'modify_date' => date('Y-m-d', time()),
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $userid);
           

            if(trim($data['freelancer_post_field']) != "")
            {
                $field_name = $this->db->get_where('category', array('category_id' => $data['freelancer_post_field']))->row()->category_name;
                $data['freelancer_post_field_txt'] = trim($field_name);
            } 

            if(trim($data['freelancer_post_country']) != "")
            {
                $country_name = $this->db->get_where('countries', array('country_id' => $data['freelancer_post_country'], 'status' => '1'))->row()->country_name;

                $data['country_name'] = trim($country_name);
            }

            if(trim($data['freelancer_post_state']) != "")
            {
                $state_name = $this->db->get_where('states', array('state_id' => $data['freelancer_post_state'], 'status' => '1'))->row()->state_name;

                $data['state_name'] = trim($state_name);
            }

            if(trim($data['freelancer_post_city']) != "")
            {
                $city_name = $this->db->get_where('cities', array('city_id' => $data['freelancer_post_city'], 'status' => '1'))->row()->city_name;

                $data['city_name'] = trim($city_name);
            }

            $data['current_position_txt'] = trim($current_position);

            $updatedata = $this->common->update_data($data, 'freelancer_post_reg_search_tmp', 'user_id', $userid);

            $basic_info = $this->freelancer_apply_model->get_basic_info($userid);
            $ret_arr = array("success"=>1,"basic_info"=>$basic_info);
        }
        else
        {
            $ret_arr = array("success"=>0);
        }
        // $ret_arr['profile_progress'] = $this->progressbar_new($userid);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }

    public function progressbar_new($user_id)
    {
        $contition_array = array('user_id' => $user_id, 'status' => '1', 'is_delete' => '0');
        $fa_data = $this->common->select_data_by_condition('freelancer_post_reg', $contition_array, $data = '
            *', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = array())[0];

        $count = 0;
        $progress_status = array();

        $user_image = 0;        
        if($fa_data['freelancer_post_user_image'] != '')
        {
            $user_image = 1;
            $count = $count + 3;
        }
        $progress_status['user_image_status'] = $user_image;

        $user_bg = 0;        
        if($fa_data['profile_background'] != '')
        {
            $user_bg = 1;
            $count = $count + 3;
        }
        $progress_status['profile_background_status'] = $user_bg;

        $user_availability = 0;
        if($fa_data['freelancer_avail_week'] > 0 && $fa_data['freelancer_avail_status'] > 0)
        {
            $user_availability = 1;
            $count = $count + 1;
        }
        $progress_status['user_availability_status'] = $user_availability;

        $user_rate = 0;
        if($fa_data['rate_currency'] > 0 && $fa_data['rate_amt'] > 0 && $fa_data['rate_type'] > 0)
        {
            $user_rate = 1;
            $count = $count + 1;
        }
        $progress_status['user_rate_status'] = $user_rate;

        $languages_data = $this->freelancer_apply_model->get_user_languages($user_id);
        $user_languages = 0;
        if(isset($languages_data) && !empty($languages_data))
        {
            $user_languages = 1;
            $count = $count + 1;
        }
        $progress_status['user_languages_status'] = $user_languages;

        $user_links = $this->freelancer_apply_model->get_user_links($user_id);
        $user_links_status = 0;
        if(isset($user_links) && !empty($user_links))
        {
            $user_links_status = 1;
            $count = $count + 1;
        }
        $progress_status['user_links_status'] = $user_links_status;

        $user_skills = 0;
        if($fa_data['freelancer_post_area'] != '')
        {
            $user_skills = 1;
            $count = $count + 1;
        }
        
        $progress_status['user_skills_status'] = $user_skills;

        if($fa_data['is_indivdual_company'] == '1')
        {
            $user_fname = 0;
            if($fa_data['freelancer_post_fullname'] != '')
            {
                $user_fname = 1;
                $count = $count + 1;
            }
            $progress_status['user_fname_status'] = $user_fname;

            $user_lname = 0;
            if($fa_data['freelancer_post_username'] != '')
            {
                $user_lname = 1;
                $count = $count + 1;
            }
            $progress_status['user_lname_status'] = $user_lname;

            $user_current_position = 0;
            if($fa_data['current_position'] != '')
            {
                $user_current_position = 1;
                $count = $count + 1;
            }
            $progress_status['user_current_position_status'] = $user_current_position;

            $user_individual_industry = 0;
            if($fa_data['freelancer_post_field'] != 0)
            {
                $user_individual_industry = 1;
                $count = $count + 1;
            }
            $progress_status['user_individual_field_status'] = $user_individual_industry;

            $user_email = 0;
            if($fa_data['freelancer_post_email'] != '')
            {
                $user_email = 1;
                $count = $count + 1;
            }
            $progress_status['user_email_status'] = $user_email;

            $user_skyupid = 0;
            if($fa_data['freelancer_post_skypeid'] != '')
            {
                $user_skyupid = 1;
                $count = $count + 1;
            }
            $progress_status['user_skyupid_status'] = $user_skyupid;

            $user_phone = 0;
            if($fa_data['freelancer_post_phoneno'] != '')
            {
                $user_phone = 1;
                $count = $count + 1;
            }
            $progress_status['user_phone_status'] = $user_phone;

            $user_country = 0;
            if($fa_data['freelancer_post_country'] != '')
            {
                $user_country = 1;
                $count = $count + 1;
            }
            $progress_status['user_country_status'] = $user_country;

            $user_state = 0;
            if($fa_data['freelancer_post_state'] != '')
            {
                $user_state = 1;
                $count = $count + 1;
            }
            $progress_status['user_state_status'] = $user_state;

            $user_city = 0;
            if($fa_data['freelancer_post_city'] != '')
            {
                $user_city = 1;
                $count = $count + 1;
            }
            $progress_status['user_city_status'] = $user_city;

            $education_data = $this->freelancer_apply_model->get_user_education($user_id);
            $user_education = 0;
            if(isset($education_data) && !empty($education_data))
            {
                $user_education = 1;
                $count = $count + 1;
            }
            $progress_status['user_education_status'] = $user_education;

            $user_prof_summary = 0;
            if($fa_data['freelancer_post_skill_description'] != '')
            {
                $user_prof_summary = 1;
                $count = $count + 1;
            }
            $progress_status['user_prof_summary_status'] = $user_prof_summary;

            $experience_data = $this->freelancer_apply_model->get_user_experience($user_id);
            $user_experience = 0;
            if(isset($experience_data) && !empty($experience_data))
            {
                $user_experience = 1;
                $count = $count + 1;
            }
            $progress_status['user_experience_status'] = $user_experience;
            
            $user_process = ($count * 100) / 24;
        }
        if($fa_data['is_indivdual_company'] == '2')
        {
            $user_comp_overview = 0;
            if($fa_data['comp_overview'] != '')
            {
                $user_comp_overview = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_overview_status'] = $user_comp_overview;

            $user_comp_name = 0;
            if($fa_data['comp_name'] != '')
            {
                $user_comp_name = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_name_status'] = $user_comp_name;

            $user_company_field = 0;
            if($fa_data['freelancer_post_field'] != 0)
            {
                $user_company_field = 1;
                $count = $count + 1;
            }
            $progress_status['user_company_field_status'] = $user_company_field;

            $user_comp_email = 0;
            if($fa_data['comp_email'] != '')
            {
                $user_comp_email = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_email_status'] = $user_comp_email;

            $user_comp_skypeid = 0;
            if($fa_data['comp_skypeid'] != '')
            {
                $user_comp_skypeid = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_skypeid_status'] = $user_comp_skypeid;

            $user_comp_number = 0;
            if($fa_data['comp_number'] != '')
            {
                $user_comp_number = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_number_status'] = $user_comp_number;

            $user_comp_team = 0;
            if($fa_data['comp_teamsize'] != '')
            {
                $user_comp_team = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_team_status'] = $user_comp_team;

            $user_comp_website = 0;
            if($fa_data['comp_website'] != '')
            {
                $user_comp_website = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_website_status'] = $user_comp_website;

            $user_comp_founded_year = 0;
            if($fa_data['comp_founded_year'] != '')
            {
                $user_comp_founded_year = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_founded_year_status'] = $user_comp_founded_year;

            $user_comp_founded_month = 0;
            if($fa_data['comp_founded_month'] != '')
            {
                $user_comp_founded_month = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_founded_month_status'] = $user_comp_founded_month;

            $user_comp_service_offer = 0;
            if($fa_data['comp_service_offer'] != '')
            {
                $user_comp_service_offer = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_service_offer_status'] = $user_comp_service_offer;

            $user_comp_exp_year = 0;
            if($fa_data['comp_exp_year'] != '')
            {
                $user_comp_exp_year = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_exp_year_status'] = $user_comp_exp_year;

            $user_comp_exp_month = 0;
            if($fa_data['comp_exp_month'] != '')
            {
                $user_comp_exp_month = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_exp_month_status'] = $user_comp_exp_month;

            $user_company_country = 0;
            if($fa_data['freelancer_post_country'] != '')
            {
                $user_company_country = 1;
                $count = $count + 1;
            }
            $progress_status['user_company_country_status'] = $user_company_country;

            $user_company_state = 0;
            if($fa_data['freelancer_post_state'] != '')
            {
                $user_company_state = 1;
                $count = $count + 1;
            }
            $progress_status['user_company_state_status'] = $user_company_state;

            $user_company_city = 0;
            if($fa_data['freelancer_post_city'] != '')
            {
                $user_company_city = 1;
                $count = $count + 1;
            }
            $progress_status['user_company_city_status'] = $user_company_city;

            $user_comp_logo = 0;
            if($fa_data['comp_logo'] != '')
            {
                $user_comp_logo = 1;
                $count = $count + 1;
            }
            $progress_status['user_comp_logo_status'] = $user_comp_logo;

            $user_process = ($count * 100) / 24;
        }

        $user_process_value = ($user_process / 100);

        if ($user_process == 100) {
            //if ($job_data['progress_new'] != 1) {
                $data = array(
                    'progressbar' => '1',
                    'modify_date' => date('Y-m-d h:i:s', time())
                );
                $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $user_id);
            //}
        } else {
            $data = array(
                'progressbar' => '0',
                'modify_date' => date('Y-m-d h:i:s', time())
            );
            $updatedata = $this->common->update_data($data, 'freelancer_post_reg', 'user_id', $user_id);
        }
        return array("user_process"=>$user_process,"user_process_value"=>$user_process_value,"progress_status"=>$progress_status);
    }

    public function get_freelancer_apply_progress()
    {
        $userid = $this->session->userdata('aileenuser');
        $profile_progress = $this->progressbar_new($userid);
        $ret_arr = array("success"=>1,"profile_progress"=>$profile_progress);
        return $this->output->set_content_type('application/json')->set_output(json_encode($ret_arr));
    }
}