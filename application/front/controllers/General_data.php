<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_data extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->library('S3');
    }

    public function index() {
        
    }

    public function getFieldList() {
        $userid = $this->session->userdata('aileenuser');
        $getFieldList = $this->data_model->getFieldList();
        echo json_encode($getFieldList);
    }

    public function getjobTitle() {
        $getJobTitle = $this->data_model->getJobTitle();
        echo json_encode($getJobTitle);
    }
    
    public function searchJobTitle() {
        $titleSearch = $_POST['q'];
        $getJobTitle = $this->data_model->searchJobTitle($titleSearch);
        echo json_encode($getJobTitle);
    }

    public function searchJobTitleStart() {
        $titleSearch = $_POST['q'];
        $getJobTitle = $this->data_model->searchJobTitleStart($titleSearch);
        echo json_encode($getJobTitle);
    }

    public function getSearchJobTitleStart() {
        $titleSearch = $_GET['q'];
        $getJobTitle = $this->data_model->getSearchJobTitleStart($titleSearch);
        echo json_encode($getJobTitle);
    }
    
    public function cityList() {
        $getCityList = $this->data_model->cityList();
        echo json_encode($getCityList);
    }
    
    public function getCityName() {
        $getCityList = $this->data_model->getCityName();
        echo json_encode($getCityList);
    }
    
    public function searchCityList() {
        $citySearch = $_POST['q'];
        $getCityList = $this->data_model->searchCityList($citySearch);
        echo json_encode($getCityList);
    }
    
    public function universityList() {
        $getUniversityList = $this->data_model->universityList();
        echo json_encode($getUniversityList);
    }
    
    public function searchUniversityList() {
        $universitySearch = $_POST['q'];
        $getUniversityList = $this->data_model->searchUniversityList($universitySearch);
        echo json_encode($getUniversityList);
    }
    
    public function degreeList() {
        $getDegreeList = $this->data_model->degreeList();
        echo json_encode($getDegreeList);
    }
    
    public function searchDegreeList() {
        $degreeSearch = $_POST['q'];
        $getDegreeList = $this->data_model->searchDegreeList($degreeSearch);
        echo json_encode($getDegreeList);
    }
    
    public function searchQuestionList(){
        $queSearch = $_POST['q'];
        
        $getQueList = $this->data_model->searchQueList($queSearch);
        echo json_encode($getQueList);
    }

    public function searchDegreeListNew() {
        $degreeSearch = $_GET['q'];
        $getDegreeList = $this->data_model->searchDegreeListNew($degreeSearch);
        echo json_encode($getDegreeList);
    }

    public function searchUniversityListNew() {
        $universitySearch = $_GET['q'];
        $getUniversityList = $this->data_model->searchUniversityListNew($universitySearch);
        echo json_encode($getUniversityList);
    }

    public function get_languages(){        
        $lang_search = $this->input->post('q');
        $language_list = $this->data_model->get_languages($lang_search);
        echo json_encode($language_list);
    }

}
