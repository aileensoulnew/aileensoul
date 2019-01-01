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
        $this->load->library('inbackground');
        $this->load->model('common');
        $this->load->model('email_model');

       // if (!$this->session->userdata('user_id')) {
       //     redirect('login', 'refresh');
       // }

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
    public function newlaunch()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $join_str[0]['table'] = 'user';
        $join_str[0]['join_table_id'] = 'user.user_id';
        $join_str[0]['from_table_id'] = 'user_login.user_id';
        $join_str[0]['join_type'] = '';

        $contition_array = array('user_login.status' => '1','user_login.is_delete' => '0');
        $userData = $this->common->select_data_by_condition('user_login', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str, $groupby = '');

        $subject = "Introducing Aileensoul New Version 2.0";
        foreach ($userData as $key => $value) {
            $this->data['first_name'] = $value['first_name'];
            $this->data['unsubscribe_link'] = base_url()."unsubscribe/".md5($value['encrypt_key'])."/".md5($value['user_slug'])."/".md5($value['user_id']);
            $email_html = $this->load->view('email_template/new_launch',$this->data,TRUE);
            $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email = $value['email']);            
            var_dump($send_email);
            echo "<br>".$key;
        }
    }

    public function testcount()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        $to = $this->input->post('to');
        $start = $this->input->post('start');

        $myfile = fopen("test.txt", "w");
        $txt = "";
        for($i=$start;$i<=$to;$i++){
            $txt .= $i."\n";
        }        
        fwrite($myfile, $txt);
        fclose($myfile);        
    }
    public function testback()
    {
        // $this->testcount();
        // $url = base_url()."test/testcount";
        // $param = array("to"=>10,"start"=>1);
        // $this->inbackground->do_in_background($url, $param);
        // $url = base_url()."test/testcount";
        // $param = array("to"=>1000,"start"=>10);
        // $this->inbackground->do_in_background($url, $param);
        // echo "done";

        $data1 = array(
            'fname' => "test",
            'lname' => "test1",
            'email' => "test1",
            'phnno' => "test1",
            'keyskill' => "test1",
            'work_job_title' => "test1",
            'work_job_industry' => "test1",
            'work_job_city' => "test1",
            'exp_y' => "test1",
            'exp_m' => "test1",
            'experience' => "test1",
            'created_date' => "test1",
            'user_id' => "test1",
            'job_step' => '10',
            'status' => '1',
            'is_delete' => '0',
            'slug' => "test1"
        );
        echo count($data1);
        unset($data1['fname']);
        print_r($data1);
        // unset($data1[count($data1)-1]);
        // print_r($data1);
        // unset($data1[count($data1)-1]);
        // print_r($data1);

    }

  
}
