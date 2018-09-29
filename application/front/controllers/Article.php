<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->library('S3');
        $this->load->library('upload');
        $this->load->library("pagination");
        
        include ('main_profile_link.php');
        include ('include.php');
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
    }

    public function new_article()
    {
        $userid = $this->session->userdata('aileenuser');
        if($userid)
        {
            $this->data['userData'] = $this->user_model->getUserData($userid);
            $this->data['meta_title'] = "Article";
            $this->data['meta_desc'] = "Article";
            $this->load->view('article/new_article', $this->data);
        }
        else
        {
            redirect(base_url(),"refresh");
        }
    }
}