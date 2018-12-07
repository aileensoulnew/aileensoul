<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->lang->load('message', 'english');
        $this->load->library('S3');
        $this->load->model('common');
        $this->load->model('email_model');

//        if (!$this->session->userdata('user_id')) {
//            redirect('login', 'refresh');
//        }

        include ('include.php');
        include ('business_include.php');
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $this->load->view('test/amazon_add', $this->data);
    }

    public function testmail()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        
        $to_email_id = array("mansiparmar911@gmail.com","mansiparmar911@yahoo.com","poorti.aileensoul@gmail.com","yatin.aileensoul@gmail.com","harshad.aileensoul@gmail.com","dhaval.aileensoul@gmail.com","pratik.aileensoul@gmail.com","adititrivedi231@gmail.com","bhattbhakti15@gmail.com","dshah1341@gmail.com","mansiparmar911@gmail.com","mansiparmar911@yahoo.com","poorti.aileensoul@gmail.com","yatin.aileensoul@gmail.com","harshad.aileensoul@gmail.com","dhaval.aileensoul@gmail.com","pratik.aileensoul@gmail.com","adititrivedi231@gmail.com","bhattbhakti15@gmail.com","dshah1341@gmail.com","dhavalshah@aileensoul.com");// $user_data['email'];
        // echo $to_email_id = "mansiparmar911@gmail.com";

        $email_html = $this->load->view('email_template/freelancer_test',$this->userdata,TRUE);

        $subject = "Find Freelancing Work Opportunities on Aileensoul";
        foreach ($to_email_id as $key => $value) {            
            $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $value,$unsubscribe);
            var_dump($send_email);
            echo "<br>".$value;
        }
        
    }

  
}
