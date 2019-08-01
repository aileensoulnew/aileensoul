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
        // $this->load->view('test/amazon_add', $this->data);
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
        $to = $this->input->post('to') ? $this->input->post('to') : 10000000;
        $start = $this->input->post('start') ? $this->input->post('start') : 1;

        $myfile = fopen("test".$start.".txt", "w");
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
        $url = base_url()."test/testcount";
        $param = array("to"=>10,"start"=>1);
        $this->inbackground->do_in_background($url, $param);
        $url = base_url()."test/testcount";
        $param = array("to"=>10000000,"start"=>1);
        $this->inbackground->do_in_background($url, $param);
        $url = base_url()."test/testcount";
        $param = array("to"=>10000000,"start"=>2);
        $this->inbackground->do_in_background($url, $param);
        $url = base_url()."test/testcount";
        $param = array("to"=>10000000,"start"=>3);
        $this->inbackground->do_in_background($url, $param);
        echo "done";
        redirect(base_url());

        /*$data1 = array(
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
        print_r($data1);*/
        // unset($data1[count($data1)-1]);
        // print_r($data1);
        // unset($data1[count($data1)-1]);
        // print_r($data1);

    }

    public function testmailhp()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        
        $to_email_id = "harshad.aileensoul@gmail.com";
        /*$login_user_img = "https://aileensoulimagev2.s3.amazonaws.com/uploads/user_profile/thumbs/1546847465.png";
        $email_html = '';
        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="'.MAIL_TD_1.'">
                                <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="Harshad Patel">
                            </td>
                            <td style="padding:5px;">
                                <p><b>'.ucwords("Dhaval Shah").'</b> accepted your contact request.</p>
                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                            </td>
                            <td style="'.MAIL_TD_3.'">
                                <p><a class="btn" href="https://www.aileensoul.com/harshad-patel-2">view</a></p>
                            </td>
                        </tr>
                        </table>';
        $subject = 'Dhaval Shah accepted your contact request in Aileensoul.';
        $unsubscribe = "https://www.aileensoul.com/harshad-patel-2";
        $send_email = $this->email_model->send_email_hp($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);*/

        $unsubscribe = "https://www.aileensoul.com/harshad-patel-2";
        $subject = 'Aileensoul Mail.';
        $email_html = $this->load->view('email_template/test_mail',$this->userdata,TRUE);
        $send_email = $this->email_model->send_email_template($subject, $email_html, $to_email_id,$unsubscribe);
        var_dump($send_email);
        echo "Done";
        
    }

    public function mobile_convert()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $dir = 'uploads/user_post/main/';
        $file_display = array('jpg');//, 'jpeg', 'png', 'gif');//array('gif');
        if ( file_exists( $dir ) == false ) {
            echo 'Directory \'', $dir, '\' not found!';
        } else {
            $dir_contents = scandir( $dir );
            // print_r($dir_contents);exit();
            $cnt = 0;
            foreach ( $dir_contents as $file ) {
                if($file !== '.' && $file !== '..')
                {
                    $ext = explode('.',$file);
                    $file_type = strtolower(  $ext[count($ext) - 1] );
                    if (in_array( $file_type, $file_display)) {
                        $filename = $ext[0];
                        $upload_path = 'uploads/user_post/resize90/';
                        $upload_url = 'uploads/user_post/main/';
                        if (!file_exists($upload_path.$file)) {
                            echo $file."====";
                            // $this->common->resizeImage($upload_url,$upload_path,$filename.".jpg",60,'','',0);
                            $this->common->createThumbnailHeight($upload_url,$file,$upload_path,92);
                            echo $cnt."<br>";
                        }
                        if($cnt == 1)
                        {
                            // break;
                        }
                        $cnt++;
                    }
                }
            }
            // echo $cnt;
        }
    }

    public function mobile_dp()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $dir = 'uploads/user_profile/main/';
        $file_display = array('jpg', 'jpeg', 'png', 'gif');//array('gif');
        if ( file_exists( $dir ) == false ) {
            echo 'Directory \'', $dir, '\' not found!';
        } else {
            $dir_contents = scandir( $dir );
            // print_r($dir_contents);exit();
            $cnt = 0;
            foreach ( $dir_contents as $file ) {
                if($file !== '.' && $file !== '..')
                {
                    $ext = explode('.',$file);
                    $file_type = strtolower(  $ext[count($ext) - 1] );
                    if (in_array( $file_type, $file_display)) {
                        $filename = $ext[0];
                        $upload_path_mobile = 'uploads/user_profile/mobile/';
                        $upload_url = 'uploads/user_profile/main/'.$file;
                        if (!file_exists($upload_path_mobile.$filename.".jpg"))
                        {
                            echo $file."====";
                            $this->common->resizeImage($upload_url,$upload_path_mobile,$filename.".jpg",60,'','',0);
                            echo $cnt."====>";
                        }

                        $upload_path_80 = 'uploads/user_profile/resize8/';
                        $upload_url = 'uploads/user_profile/main/'.$file;
                        if (!file_exists($upload_path_80.$filename.".jpg"))
                        {
                            echo $file."====";
                            $this->common->resizeImage($upload_url,$upload_path_80,$filename.".jpg",95,'','',0,80,80);
                            echo $cnt."====>";
                        }
                        $upload_path_50 = 'uploads/user_profile/resize5/';
                        $upload_url = 'uploads/user_profile/main/'.$file;
                        if (!file_exists($upload_path_50.$filename.".jpg"))
                        {
                            echo $file."====";
                            $this->common->resizeImage($upload_url,$upload_path_50,$filename.".jpg",95,'','',0,50,50);
                            echo $cnt."====>";
                        }
                        $upload_path_30 = 'uploads/user_profile/resize3/';
                        if (!file_exists($upload_path_30.$filename.".jpg"))
                        {
                            echo $file."====";
                            $this->common->resizeImage($upload_url,$upload_path_30,$filename.".jpg",95,'','',0,30,30);
                            echo $cnt;
                        }
                        echo "<br>";
                        if($cnt == 0)
                        {
                            // break;
                        }
                        $cnt++;
                    }
                }
            }
            // echo $cnt;
        }
    }

  
}
