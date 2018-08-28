<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_auth{

    private $CI;

    function User_auth()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('user_model');
    }
    
    public function index() {
        // print_r($this->CI->session->userdata('aileenuser'));exit;
        if($this->CI->session->userdata('aileenuser'))
        {
            $userid = $this->CI->session->userdata('aileenuser');
            $ProfessionData = $this->CI->user_model->getUserProfessionData($userid,"*");
            $StudentData = $this->CI->user_model->getUserStudentData($userid,"*");
            $no_page = array("basic-information","user_info_page","logout","job_basic_info","job_live","general_data","user_info","recruiter","artist_live","artist-profile","business-profile","business_profile_live","freelance-employer","freelancer_hire_live","freelancer","freelancer_apply_live","job-profile");
            if(empty($ProfessionData) && empty($StudentData) && !in_array($this->CI->uri->segment(1), $no_page))
            {
                // print_r($this->CI->uri->segment(1));exit;
                redirect(base_url().'basic-information', 'refresh');
            }
        }
        /*if ($this->CI->session->userdata('aileenuser') == '' )  // If no session found redirect to login page.
        {
            redirect(site_url('login'));
        }*/
    }
}
