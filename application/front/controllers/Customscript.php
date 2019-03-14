<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customscript extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('business_model');
        $this->load->model('job_model');
        $this->load->library('S3');
    }

    public function index() {
        echo "string";exit();
    }

    public function createkey( $length = 16 )
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        
        $this->load->library('encryption');

        $cipher = $this->input->get('cipher')
            ? urldecode( $this->input->get('cipher') )
            : $length . ' byte key';

        /*echo $key = bin2hex( $this->encryption->create_key( $length ) ).'<br>';
        echo $key1 = ( $this->encryption->create_key( $length ) ).'<br>';

        echo '// ' . $cipher . '<br /> 
        $config[\'encryption_key\'] = hex2bin(\'' . $key . '\');<br />';

        for ($i=0; $i < 10; $i++) { 
            $key = bin2hex( $this->encryption->create_key( $length ) );
            echo $key .'<----->'. md5($key).'<br />';
        }*/
        $userData = $this->db->get_where('user', array())->result();        
        // print_r($userData);
        foreach ($userData as $key => $value) {            
            $key = bin2hex( $this->encryption->create_key( $length ) );
            $data = array("encrypt_key"=>$key);
            $updatdata = $this->common->update_data($data, 'user', 'user_id', $value->user_id);
        }
        echo "Done";
    }

    public function createtoken( $length = 16 )
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        
        $this->load->library('encryption');

        $cipher = $this->input->get('cipher')
            ? urldecode( $this->input->get('cipher') )
            : $length . ' byte key';

        /*echo $key = bin2hex( $this->encryption->create_key( $length ) ).'<br>';
        echo $key1 = ( $this->encryption->create_key( $length ) ).'<br>';

        echo '// ' . $cipher . '<br /> 
        $config[\'encryption_key\'] = hex2bin(\'' . $key . '\');<br />';

        for ($i=0; $i < 10; $i++) { 
            $key = bin2hex( $this->encryption->create_key( $length ) );
            echo $key .'<----->'. md5($key).'<br />';
        }*/
        $userData = $this->db->query("SELECT * FROM ailee_user WHERE token IS NULL")->result();        
        foreach ($userData as $key => $value) {            
            $key = bin2hex( $this->encryption->create_key( $length ) );
            $data = array("token"=>$key);
            $updatdata = $this->common->update_data($data, 'user', 'user_id', $value->user_id);
        }
        echo "Done";
    }

    public function cityslug()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");        
      
        $cityData = $this->db->get_where('cities', array())->result();        
        echo "<pre>";
        // print_r($cityData);exit();echo "</pre>";
        foreach ($cityData as $key => $value) {
            $city_slug = $this->common->set_city_slug($value->city_name, 'slug1', 'cities');
            $data = array("slug1"=>$city_slug);
            $updatdata = $this->common->update_data($data, 'cities', 'city_id', $value->city_id);
        }
        echo "Done";
    }

    public function upload_move_to_amazon()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $main_dir = scandir('uploads');
        // print_r($main_dir);
        $s3 = new S3(awsAccessKey, awsSecretKey);
        echo "<pre>";
        foreach ($main_dir as $k=>$_main_dir) {
            /*if(is_dir($_main_dir))
            {
                echo $_main_dir."\n";   
            }*/
            // print_r($_main_dir);
            $_main_dir_arr = explode(".", $_main_dir);
            // print_r($_main_dir_arr);
            if(count($_main_dir_arr) < 2 && ($_main_dir == "artistic_profile" || $_main_dir == "artistic_bg" || $_main_dir == "artistic_post" || $_main_dir == "business_bg" || $_main_dir == "business_profile" || $_main_dir == "business_post" || $_main_dir == "job_profile" || $_main_dir == "job_bg" || $_main_dir == "recruiter_profile" || $_main_dir == "recruiter_bg" || $_main_dir == "freelancer_hire_profile" || $_main_dir == "freelancer_hire_bg" || $_main_dir == "freelancer_post_profile" || $_main_dir == "freelancer_post_bg" || $_main_dir == "user_post" || $_main_dir == "user_profile" || $_main_dir == "user_bg"))
            {
                // echo $_main_dir."-------------";
                // $inner_dir = scandir('uploads/'.$_main_dir);

                $inner_dir = array_diff(scandir('uploads/'.$_main_dir), array('..', '.'));
                foreach ($inner_dir as $_inner_dir) {
                    /*$info = $s3->getObjectInfo(bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir);
                    echo 'uploads/'.$_main_dir.'/'.$_inner_dir;
                    if($info)
                    {
                        echo "->Yes";
                    }
                    else
                    {
                        $s3->putObjectFile('uploads/'.$_main_dir.'/'.$_inner_dir, bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir, S3::ACL_PUBLIC_READ);
                        echo "->No";
                    }
                    echo "\n";*/
                    // echo 'uploads/'.$_main_dir.'/'.$_inner_dir."-------------";

                    $_inner_dir_arr = explode(".", $_inner_dir);
                    if(count($_inner_dir_arr) < 2 && $_inner_dir != "main03062018" && $_inner_dir != "blog - Copy")
                    {
                        $inner_inner_dir = array_diff(scandir('uploads/'.$_main_dir.'/'.$_inner_dir), array('..', '.'));
                        foreach ($inner_inner_dir as $_inner_inner_dir) {
                            $info = $s3->getObjectInfo(bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir);
                            echo 'uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir;
                            if($info)
                            {
                                echo "->Yes";
                                @unlink('uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir);
                            }
                            else
                            {
                                echo "->No";
                                $s3->putObjectFile('uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir, bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir, S3::ACL_PUBLIC_READ);
                            }
                            echo "\n";
                        }
                    }
                    else
                    {
                        $info = $s3->getObjectInfo(bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir);
                        echo 'uploads/'.$_main_dir.'/'.$_inner_dir;
                        if($info)
                        {
                            echo "->Yes";
                            @unlink('uploads/'.$_main_dir.'/'.$_inner_dir);
                        }
                        else
                        {
                            $s3->putObjectFile('uploads/'.$_main_dir.'/'.$_inner_dir, bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir, S3::ACL_PUBLIC_READ);
                            echo "->No";
                        }
                    }
                }
                // echo "\n";
                // print_r($inner_dir);
            }

            /*if($k == 10){
                echo "string";
                exit();
            }*/
        }
    }

    public function new_business_table()
    {
        $contition_array = array('status' => '1','is_delete' => '0');
        $businessdataposted = $this->common->select_data_by_condition('business_profile_post', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        echo "<pre>";        
        foreach ($businessdataposted as $key => $value) {

            $user_id = $value['user_id'];
            $post_for = 'simple';
            $user_type = '2';
            $created_date = $value['created_date'];
            $status = 'publish';
            $is_delete = '0';
            $data = array(
                'user_id' => $user_id,
                'post_for' => $post_for,
                'user_type' => $user_type,
                'created_date' => $created_date,
                'status' => $status,
                'is_delete' => $is_delete
            );
            
            $main_post_id = $this->common->insert_data_getid($data,'user_post');//data,table

            if($main_post_id > 0)
            {
                $simple_post = $value['product_name'].' '.$value['product_description'];
                $data1 = array(
                    'post_id' => $main_post_id,
                    'description' => $simple_post,
                    'modify_date' => $created_date                    
                );
                
                $simple_post_id = $this->common->insert_data_getid($data1,'user_simple_post');//data,table
                if($simple_post_id > 0)
                {
                    $data2 = array('post_id' => $simple_post_id);
                    $this->common->update_data($data2,'user_post','id',$main_post_id);
                    $contition_array = array('insert_profile' => '2','post_id' => $value['business_profile_post_id']);
                    $businessdatafiles = $this->common->select_data_by_condition('post_files', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
                    // $businessdataposted[$key]['image_data'] = $businessdatafiles;
                    if(isset($businessdatafiles) && !empty($businessdatafiles))
                    {
                        foreach ($businessdatafiles as $k => $v) {
                            $post_id = $main_post_id;
                            $file_name = $v['file_name'];
                            $file_type = $v['post_format'];
                            $modify_date = $created_date;

                            $data3 = array(
                                'post_id' => $post_id,
                                'file_type' => $file_type,
                                'filename' => $file_name,
                                'modify_date' => $modify_date,
                            );
                            
                            $file_insert_id = $this->common->insert_data_getid($data3,'user_post_file');//data,table
                            
                            $upload_src_main = "uploads/business_post/main/".$v['file_name'];
                            $upload_src_resize1 = "uploads/business_post/resize1/".$v['file_name'];
                            $upload_src_resize2 = "uploads/business_post/resize2/".$v['file_name'];
                            $upload_src_resize3 = "uploads/business_post/resize3/".$v['file_name'];
                            $upload_src_resize4 = "uploads/business_post/resize4/".$v['file_name'];
                            $upload_src_thumbs = "uploads/business_post/thumbs/".$v['file_name'];

                            $upload_to_main = "uploads/user_post/main/".$v['file_name'];
                            $upload_to_resize1 = "uploads/user_post/resize1/".$v['file_name'];
                            $upload_to_resize2 = "uploads/user_post/resize2/".$v['file_name'];
                            $upload_to_resize3 = "uploads/user_post/resize3/".$v['file_name'];
                            $upload_to_resize4 = "uploads/user_post/resize4/".$v['file_name'];
                            $upload_to_thumbs = "uploads/user_post/thumbs/".$v['file_name'];
                            
                            if (IMAGEPATHFROM == 's3bucket') {
                                $s3->copyObject(bucket,$upload_src_main,bucket,$upload_to_main);
                                $s3->copyObject(bucket,$upload_src_resize1,bucket,$upload_to_resize1);
                                $s3->copyObject(bucket,$upload_src_resize2,bucket,$upload_to_resize2);
                                $s3->copyObject(bucket,$upload_src_resize3,bucket,$upload_to_resize3);
                                $s3->copyObject(bucket,$upload_src_resize4,bucket,$upload_to_resize4);
                                $s3->copyObject(bucket,$upload_src_thumbs,bucket,$upload_to_thumbs);
                            }
                            else{
                                copy($upload_src_main,$upload_to_main);
                                copy($upload_src_resize1,$upload_to_resize1);
                                copy($upload_src_resize2,$upload_to_resize2);
                                copy($upload_src_resize3,$upload_to_resize3);
                                copy($upload_src_resize4,$upload_to_resize4);
                                copy($upload_src_thumbs,$upload_to_thumbs);
                            }

                        }
                    }
                }
            }           
        }
        print_r($businessdataposted);

    }

    public function check_city()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        // $sql = "SELECT * FROM ailee_user_profession WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41));";
        $sql = "SELECT * FROM ailee_user_profession WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN( SELECT `state_id` FROM `ailee_states` WHERE `country_id` IN (SELECT country_id FROM `ailee_countries` WHERE `country_name` = 'India')));";
        $city_data1 = $this->db->query($sql)->result();
        echo count($city_data1);
        echo "<br>";
        // print_r($city_data1);
        echo "<br>";

        $sql = "SELECT * FROM ailee_user_student WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN( SELECT `state_id` FROM `ailee_states` WHERE `country_id` IN (SELECT country_id FROM `ailee_countries` WHERE `country_name` = 'India')));";
        $city_data2 = $this->db->query($sql)->result();
        echo count($city_data2);
        echo "<br>";
        print_r($city_data2);
    }

    //add old user to new user from job,rec,freelance hire and freelance apply(Freelance Post) table
    public function old_user_to_new_user()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");
        // $sql = "SELECT * FROM ailee_user_profession WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41));";
        /*$sql = "SELECT * FROM ailee_user_profession WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN( SELECT `state_id` FROM `ailee_states` WHERE `country_id` IN (SELECT country_id FROM `ailee_countries` WHERE `country_name` = 'India')));";
        $city_data1 = $this->db->query($sql)->result();
        echo count($city_data1);
        echo "<br>";
        // print_r($city_data1);
        echo "<br>";

        $sql = "SELECT * FROM ailee_user_student WHERE city IN (SELECT `city_id` FROM ailee_cities WHERE `state_id` IN( SELECT `state_id` FROM `ailee_states` WHERE `country_id` IN (SELECT country_id FROM `ailee_countries` WHERE `country_name` = 'India')));";
        $city_data2 = $this->db->query($sql)->result();
        echo count($city_data2);
        echo "<br>";*/
        // print_r($city_data2);

        echo "<pre>";
        $sql = "SELECT user_id FROM ailee_user WHERE user_id NOT IN (SELECT `user_id` FROM ailee_user_profession);";
        $user_data = $this->db->query($sql)->result();
        $i = 0;
        $k = 0;
        $count = 0; 
        echo count($user_data)."<br>";
        // print_r($user_data);exit();
        foreach ($user_data as $_user_data) {
            $city = "";
            $job_title = "";
            $field = "";

            $sql_1 = "SELECT * FROM ailee_user_student WHERE user_id = $_user_data->user_id";
            $stud_data = $this->db->query($sql_1)->row();
            if(empty($stud_data))
            {
                $count++;
                $sql1 = "SELECT * FROM ailee_job_reg WHERE user_id = $_user_data->user_id AND is_delete = '0' AND status = '1'";
                $job_data = $this->db->query($sql1)->row();
                if(isset($job_data))
                {
                    if($job_data->city_id > 0)
                    {
                        $city = $job_data->city_id;
                    }
                    if($job_data->designation != "")
                    {
                        $job_title = $job_data->designation;
                    }
                    if(!$job_title && $job_data->work_job_title != "")
                    {
                        $job_title = $job_data->work_job_title;
                    }
                    if($job_data->work_job_industry != "")
                    {
                        $field = $job_data->work_job_industry;
                    }
                }            

                $sql2 = "SELECT * FROM ailee_recruiter WHERE user_id = $_user_data->user_id AND is_delete = '0' AND re_status = '1'";
                $rec_data = $this->db->query($sql2)->row();
                // $_user_data->rec =  ($rec_data);
                if(isset($rec_data))
                {
                    if(!$city && $rec_data->re_comp_city > 0)
                    {
                        $city = $rec_data->re_comp_city;
                    }
                    if(!$job_title && $rec_data->designation != "")
                    {
                        $job_title = $rec_data->designation;
                    }
                }

                $sql3 = "SELECT * FROM ailee_freelancer_hire_reg WHERE user_id = $_user_data->user_id AND is_delete = '0' AND status = '1'";
                $fh_data = $this->db->query($sql3)->row();
                // $_user_data->fh =  ($fh_data);
                if(isset($fh_data))
                {
                    if(!$city && $fh_data->city > 0)
                    {
                        $city = $fh_data->city;
                    }
                    if(!$job_title && $fh_data->designation != "")
                    {
                        $job_title = $fh_data->designation;
                    }
                }

                $sql4 = "SELECT * FROM ailee_freelancer_post_reg WHERE user_id = $_user_data->user_id AND is_delete = '0' AND status = '1'";
                $fa_data = $this->db->query($sql4)->row();
                // $_user_data->fa = ($fa_data);
                if(isset($fa_data))
                {
                    if(!$city && $fa_data->freelancer_post_city > 0)
                    {
                        $city = $fa_data->freelancer_post_city;
                    }
                    if(!$job_title && $fa_data->designation != "")
                    {
                        $job_title = $fa_data->designation;
                    }
                    if($fa_data->freelancer_post_field > 0)
                    {
                        $_user_data->fa_field = $fa_field = $fa_data->freelancer_post_field;
                    }                
                }
                if($city != "" && $job_title != "" && ($field != "" || $fa_field != ""))
                {
                    // echo $city."  --  ".$job_title." -- ".$field."   field    ".$fa_field;
                    $k++;
                    $_user_data->city = $city;                    
                    $_user_data->job_title = $job_title;
                    if($fa_field == 1 || $fa_field == 0)
                    {
                        $_user_data->field = 198;
                    }
                    elseif($fa_field == 3)
                    {
                        $_user_data->field = 149;
                    }
                    elseif($fa_field == 4)
                    {
                        $_user_data->field = 43;
                    }
                    elseif($fa_field == 5)
                    {
                        $_user_data->field = 124;
                    }
                    elseif($fa_field == 6)
                    {
                        $_user_data->field = 141;
                    }
                    elseif($fa_field == 7)
                    {
                        $_user_data->field = 80;
                    }
                    elseif($fa_field == 8)
                    {
                        $_user_data->field = 215;
                    }
                    elseif($fa_field == 9)
                    {
                        $_user_data->field = 115;
                    }
                    elseif($fa_field == 10)
                    {
                        $_user_data->field = 148;
                    }
                    elseif($fa_field == 11)
                    {
                        $_user_data->field = 244;
                    }
                    elseif($fa_field == 12)
                    {
                        $_user_data->field = 114;
                    }
                    else
                    {
                        if($field != "")
                        {
                            // $_user_data->field = $field;   
                            $sql_ji = "SELECT * FROM ailee_job_industry WHERE industry_id = $field";                        
                            $job_indu_arr = $this->db->query($sql_ji)->row();
                            $_user_data->field = 0;   
                            $_user_data->other_field = $job_indu_arr->industry_name;
                            
                        }
                        else
                        {
                            $_user_data->field = 0;   
                            $_user_data->other_field = ucwords(strtolower($_user_data->job_title));
                        }
                    }

                    
                    if(isset($_user_data->job_title) && !empty($_user_data->job_title))
                    {
                        if(is_numeric($_user_data->job_title))
                        {
                            $s = "title_id = $_user_data->job_title";
                        }
                        else
                        {
                            $s = "LOWER(name) = '".strtolower(trim($_user_data->job_title))."'";
                        }
                        $sql_jt = "SELECT * FROM ailee_job_title WHERE ".addcslashes($s);
                        // echo $sql_jt."<br>";
                        $job_title_arr = $this->db->query($sql_jt)->row();
                        if($job_title_arr)
                        {
                            // print_r($job_title_arr);
                            $_user_data->title_id = $job_title_arr->title_id;
                            // exit();
                        }
                        else
                        {
                            $data = array();
                            $job_slug = $this->common->clean($_user_data->job_title);
                            $data['name'] = $_user_data->job_title;
                            $data['created_date'] = date('Y-m-d H:i:s', time());
                            $data['modify_date'] = date('Y-m-d H:i:s', time());
                            $data['status'] = 'draft';
                            $data['job_title_img'] = $job_slug.".png";
                            $data['slug'] = $job_slug;
                            $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                            $_user_data->title_id = $jobTitleId;
                        }

                        $data1 = array(
                            "user_id" => $_user_data->user_id,
                            "designation" => $_user_data->title_id,
                            "field" => $_user_data->field,
                            "other_field" => ($_user_data->other_field != '' ? $_user_data->other_field : ''),
                            "city" => $_user_data->city
                        );
                        // print_r($data1);
                        $user_prof_data = $this->common->insert_data_getid($data1, 'user_profession');
                    }                    
                }
                
            }

            /*if($_user_data->user_id == 67)
            {
                exit();
            }*/


            /*if($i == 100)
            {
                exit;
            }*/

            $i++;
        }
        echo "<br>".$k;
        echo "<br>count".$count;
    }

    public function old_user_to_new_user_2()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");        

        echo "<pre>";
        $sql = "SELECT user_id,work_job_title,work_job_industry,work_job_other_industry,work_job_city FROM ailee_job_reg WHERE user_id IN (SELECT user_id FROM ailee_user WHERE user_id NOT IN (SELECT `user_id` FROM ailee_user_profession)) AND is_delete = '0' AND status = '1' AND work_job_title != '' AND (work_job_industry != '' OR work_job_other_industry != '') AND work_job_city != '';";
        $job_data = $this->db->query($sql)->result_array();
        // print_r($job_data);

        $sql1 = "SELECT user_id,freelancer_post_city,freelancer_post_field,freelancer_post_area FROM ailee_freelancer_post_reg WHERE user_id IN (SELECT user_id FROM ailee_user WHERE user_id NOT IN (SELECT `user_id` FROM ailee_user_profession)) AND is_delete = '0' AND status = '1' AND freelancer_post_city != '' AND freelancer_post_field > 0 AND freelancer_post_area != '';";
        $fa_data = $this->db->query($sql1)->result_array();
        // print_r($fa_data);exit();
        echo count($fa_data);
        foreach ($fa_data as $_fa_data) {
            $sql_1 = "SELECT * FROM ailee_user_student WHERE user_id = ".$_fa_data['user_id'];
            $stud_data = $this->db->query($sql_1)->row();
            if(empty($stud_data))
            {
                $field = "";
                $other_field = "";                        
                $index = array_search($_fa_data['user_id'], array_column($job_data, 'user_id'));
                if($index > -1)
                {
                    // echo $index."---Index<-----><br>";
                }
                else
                {
                    $fa_field = $_fa_data['freelancer_post_field'];
                    if($fa_field == 1 || $fa_field == 0 || $fa_field == 15)
                    {
                        $field = 198;
                    }
                    elseif($fa_field == 3)
                    {
                        $field = 149;
                    }
                    elseif($fa_field == 4)
                    {
                        $field = 43;
                    }
                    elseif($fa_field == 5)
                    {
                        $field = 124;
                    }
                    elseif($fa_field == 6)
                    {
                        $field = 141;
                    }
                    elseif($fa_field == 7)
                    {
                        $field = 80;
                    }
                    elseif($fa_field == 8)
                    {
                        $field = 215;
                    }
                    elseif($fa_field == 9)
                    {
                        $field = 115;
                    }
                    elseif($fa_field == 10)
                    {
                        $field = 148;
                    }
                    elseif($fa_field == 11)
                    {
                        $field = 244;
                    }
                    elseif($fa_field == 12)
                    {
                        $field = 114;
                    }
                    else
                    {
                        $sql_cat = "SELECT * FROM ailee_category WHERE category_id = $fa_field";                        
                        $cat_arr = $this->db->query($sql_cat)->row();
                        $field = 0;   
                        $other_field = $cat_arr->category_name."<br>";
                        
                    }
                    $skills =  explode(",", $_fa_data['freelancer_post_area']);                
                    $sql_1 = "SELECT skill FROM ailee_skill WHERE skill_id = $skills[0]";
                    $job_title = $this->db->query($sql_1)->row()->skill;                
                    
                    $s = "LOWER(name) = '".strtolower(trim($job_title))."'";
                    $sql_jt = "SELECT * FROM ailee_job_title WHERE ".($s);
                    // echo $sql_jt."<br>";exit();
                    $job_title_arr = $this->db->query($sql_jt)->row();
                    if($job_title_arr)
                    {
                        // print_r($job_title_arr);
                        $job_title_id = $job_title_arr->title_id;
                        // exit();
                    }
                    else
                    {
                        $data = array();
                        $job_slug = $this->common->clean($job_title);
                        $data['name'] = $job_title;
                        $data['created_date'] = date('Y-m-d H:i:s', time());
                        $data['modify_date'] = date('Y-m-d H:i:s', time());
                        $data['status'] = 'draft';
                        $data['job_title_img'] = $job_slug.".png";
                        $data['slug'] = $job_slug;
                        $jobTitleId = $this->common->insert_data_getid($data, 'job_title');
                        $job_title_id = $jobTitleId;
                    }

                    $data1 = array(
                        "user_id" => $_fa_data['user_id'],
                        "designation" => $job_title_id,
                        "field" => $field,
                        "other_field" => ($other_field != '' ? $other_field : ''),
                        "city" => $_fa_data['freelancer_post_city']
                    );
                    print_r($data1);
                    $user_prof_data = $this->common->insert_data_getid($data1, 'user_profession');
                }
            }            
        }
        echo "Done";
        exit();        
    }

    public function old_user_to_new_user_3()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");        

        echo "<pre>";
        $sql = "SELECT user_id,work_job_title,work_job_industry,work_job_other_industry,work_job_city FROM ailee_job_reg WHERE user_id IN (SELECT user_id FROM ailee_user WHERE user_id NOT IN (SELECT `user_id` FROM ailee_user_profession)) AND is_delete = '0' AND status = '1' AND work_job_title != '' AND (work_job_industry != '' OR work_job_other_industry != '') AND work_job_city != '';";
        $job_data = $this->db->query($sql)->result_array();
        // print_r($job_data);exit();

        echo count($job_data);
        foreach ($job_data as $_job_data) {
            $sql_1 = "SELECT * FROM ailee_user_student WHERE user_id = ".$_job_data['user_id'];
            $stud_data = $this->db->query($sql_1)->row();
            if(empty($stud_data))
            {
                $sql_cat = "SELECT * FROM ailee_job_industry WHERE industry_id = ".$_job_data['work_job_industry'];                        
                $cat_arr = $this->db->query($sql_cat)->row();                
                $other_field = $cat_arr->industry_name;
                $field = 0;
                $city = explode(",", $_job_data['work_job_city']);

                $data1 = array(
                    "user_id" => $_job_data['user_id'],
                    "designation" => $_job_data['work_job_title'],
                    "field" => $field,
                    "other_field" => ($other_field != '' ? $other_field : ''),
                    "city" => $city[0]
                );
                print_r($data1);
                $user_prof_data = $this->common->insert_data_getid($data1, 'user_profession');                
            }            
        }
        echo "Done";
        exit();        
    }

    public function convert_to_feed()
    {
        $job_data = $this->job_model->get_all_job_list();
        echo count($job_data);
        echo "<pre>";
        foreach ($job_data as $_job_data) {
            
            $user_id = $_job_data['user_id'];
            $post_for = 'opportunity';
            $user_type = '1';
            $created_date = $_job_data['created_date'];
            $status = 'publish';
            $is_delete = '0';
            $data = array(
                'user_id'       => $user_id,
                'post_for'      => $post_for,
                'user_type'     => $user_type,
                'created_date'  => $created_date,
                'status'        => $status,
                'is_delete'     => $is_delete
            );            
            $main_post_id = $this->common->insert_data_getid($data,'user_post');//data,table
            if($main_post_id > 0)
            {
                $opptitle = substr($_job_data['name'], 0,150);                
                $opp_for = $_job_data['post_name'];                
                $location = $_job_data['city'];                
                $opportunity = $_job_data['post_description'];

                $sql_ji = "SELECT * FROM ailee_job_industry WHERE industry_id = ".$_job_data['industry_type'];
                $job_indu_arr = $this->db->query($sql_ji)->row();
                $field = 0;
                $other_field = $job_indu_arr->industry_name;

                $opptitle_slug = $this->common->set_slug(substr($opptitle, 0,100), 'oppslug', 'user_opportunity');
                $company_name = $_job_data['comp_name'];

                $data1 = array(
                    "post_id"           => $main_post_id,
                    "opptitle"          => $opptitle,
                    "opportunity_for"   => $opp_for,
                    "location"          => $location,
                    "opportunity"       => $opportunity,
                    "field"             => $field,
                    "other_field"       => $other_field,
                    "oppslug"           => $opptitle_slug,
                    "company_name"      => $company_name,
                    "modify_date"       => $created_date,
                );
                $opp_post_id = $this->common->insert_data_getid($data1, 'user_opportunity');
                $data2 = array('post_id' => $opp_post_id);
                $this->common->update_data($data2,'user_post','id',$main_post_id);
                print_r($data1);
                echo "<br><br><br><br>";
            }
        }
    }

    public function convert_freelancer_job_to_feed()
    {
        $job_data = $this->job_model->convert_freelancer_job_to_feed();
        echo count($job_data);
        echo "<pre>";
        foreach ($job_data as $_job_data) {
            
            $user_id = $_job_data['user_id'];
            $post_for = 'opportunity';
            $user_type = '1';
            $created_date = $_job_data['created_date'];
            $status = 'publish';
            $is_delete = '0';
            $data = array(
                'user_id'       => $user_id,
                'post_for'      => $post_for,
                'user_type'     => $user_type,
                'created_date'  => $created_date,
                'status'        => $status,
                'is_delete'     => $is_delete
            );
            // print_r($data);
            // echo $_job_data['post_name'];
            echo "<br>";
            $main_post_id = $this->common->insert_data_getid($data,'user_post');//data,table
            if($main_post_id > 0)
            {
                $opptitle = substr($_job_data['post_name'], 0,150);

                $s = "LOWER(name) = '".(strtolower(trim($_job_data['post_name'])))."'";
                
                $sql_jt = "SELECT * FROM ailee_job_title WHERE ".$s;
                // echo $sql_jt."<br>";
                $job_title_arr = $this->db->query($sql_jt)->row();
                // print_r($job_title_arr);
                if($job_title_arr)
                {
                    // print_r($job_title_arr);
                    $title_id = $job_title_arr->title_id;
                    // exit();
                }
                else
                {
                    $data = array();
                    $job_slug = $this->common->clean($_job_data['post_name']);
                    $data['name'] = $_job_data['post_name'];
                    $data['created_date'] = date('Y-m-d H:i:s', time());
                    $data['modify_date'] = date('Y-m-d H:i:s', time());
                    $data['status'] = 'draft';
                    $data['job_title_img'] = $job_slug.".png";
                    $data['slug'] = $job_slug;
                    // print_r($data);
                    $title_id = $this->common->insert_data_getid($data, 'job_title');
                }


                $opp_for = $title_id;
                $location = $_job_data['location'];
                $opportunity = $_job_data['post_description'];
                $fa_field = $_job_data['post_field_req'];

                if($fa_field == 1 || $fa_field == 0 || $fa_field == 15)
                {
                    $field = 198;
                }
                elseif($fa_field == 3)
                {
                    $field = 149;
                }
                elseif($fa_field == 4)
                {
                    $field = 43;
                }
                elseif($fa_field == 5)
                {
                    $field = 124;
                }
                elseif($fa_field == 6)
                {
                    $field = 141;
                }
                elseif($fa_field == 7)
                {
                    $field = 80;
                }
                elseif($fa_field == 8)
                {
                    $field = 215;
                }
                elseif($fa_field == 9)
                {
                    $field = 115;
                }
                elseif($fa_field == 10)
                {
                    $field = 148;
                }
                elseif($fa_field == 11)
                {
                    $field = 244;
                }
                elseif($fa_field == 12)
                {
                    $field = 114;
                }

                $opptitle_slug = $this->common->set_slug(substr($opptitle, 0,100), 'oppslug', 'user_opportunity');

                $company_name = "";

                $data1 = array(
                    "post_id"           => $main_post_id,
                    "opptitle"          => $opptitle,
                    "opportunity_for"   => $opp_for,
                    "location"          => $location,
                    "opportunity"       => $opportunity,
                    "field"             => $field,
                    "other_field"       => "",
                    "oppslug"           => $opptitle_slug,
                    "company_name"      => $company_name,
                    "modify_date"       => $created_date,
                );
                $opp_post_id = $this->common->insert_data_getid($data1, 'user_opportunity');
                $data2 = array('post_id' => $opp_post_id);
                $this->common->update_data($data2,'user_post','id',$main_post_id);
                print_r($data1);
                echo "<br><br><br><br>";
            }
        }
    }

    public function convert_detail_job_to_user_hobbies()
    {
        $sql = "SELECT user_id,user_hobbies FROM ailee_job_reg WHERE user_hobbies != '' AND status = '1' AND is_delete = '0'";
        $hobbies = $this->db->query($sql)->result();
        // print_r($hobbies);
        echo "<pre>";
        foreach ($hobbies as $_hobbies) {
            // print_r($_hobbies->user_hobbies);
            $sql1 = "SELECT user_hobbies FROM ailee_user_info WHERE user_id = ".$_hobbies->user_id;
            $hobbies1 = $this->db->query($sql1)->row();
            $_hobbies->user_user_hobbies = $hobbies1->user_hobbies;
            $job_hobbie = explode(",", $_hobbies->user_hobbies);
            $user_hobbie = explode(",", $hobbies1->user_hobbies);
            $new_hobbies = "";
            if(!empty($user_hobbie))
            {                
                foreach ($job_hobbie as $key => $value) {
                    if(!in_array($value, $user_hobbie))
                    {
                        $new_hobbies .= $value.",";
                    }
                }
                $new_hobbies = $hobbies1->user_hobbies.','.$new_hobbies;
            }
            else
            {
                $new_hobbies = $_hobbies->user_hobbies;
            }
            $_hobbies->new_hobbie = trim($new_hobbies,",");
            $data = array("user_hobbies"=>$_hobbies->new_hobbie);
            $updatdata = $this->common->update_data($data, 'user_info', 'user_id', $_hobbies->user_id);
            print_r($_hobbies);
        }
        echo "Done";
    }

    public function convert_detail_job_to_user_research()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $sql = "SELECT * FROM ailee_job_user_research WHERE status = '1'";
        $job_research = $this->db->query($sql)->result_array();
        echo "<pre>";
        echo count($job_research)."<br>";
        // print_r($job_research);        
        foreach ($job_research as $_job_research) {
            // print_r($_hobbies->user_hobbies);
            $sql1 = "SELECT * FROM ailee_user_research WHERE user_id = '".$_job_research['user_id']."' AND research_title = '".$_job_research['research_title']."'";
            $usr_research = $this->db->query($sql1)->row();
            if(isset($usr_research) && !empty($usr_research))
            {
                $new = 0;
            }
            else
            {
                $new = 1;
            }
            if($new == 1)
            {
                if($_job_research['research_document'] != "")
                {
                    $fileName = $_job_research['research_document'];
                    $job_user_research_upload_path = $this->config->item('job_user_research_upload_path');
                    $user_research_upload_path = $this->config->item('user_research_upload_path');
                    $file = $job_user_research_upload_path.$_job_research['research_document'];
                    $newfile = $user_research_upload_path.$_job_research['research_document'];
                    if(@copy($file, $newfile))
                    {
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                        if (IMAGEPATHFROM == 's3bucket') {
                            $abc = $s3->putObjectFile($newfile, bucket, $newfile, S3::ACL_PUBLIC_READ);
                        }
                    }
                }
                else
                {
                    $fileName = "";
                }
                $user_id = $_job_research['user_id'];
                $research_title = $_job_research['research_title'];
                $research_desc = $_job_research['research_desc'];
                $research_field = $_job_research['research_field'];
                $research_other_field = $_job_research['research_other_field'];
                $research_url = $_job_research['research_url'];
                $research_publish_date = $_job_research['research_publish_date'];
                $status = $_job_research['status'];
                $created_date = $_job_research['created_date'];
                $modify_date = $_job_research['modify_date'];

                $data = array(
                    'user_id'                   => $user_id,
                    'research_title'            => $research_title,
                    'research_desc'             => $research_desc,
                    'research_field'            => $research_field,
                    'research_other_field'      => $research_other_field,
                    'research_url'              => $research_url,
                    'research_publish_date'     => $research_publish_date,
                    'research_document'         => $fileName,
                    'status'                    => $status,
                    'created_date'              => $created_date,
                    'modify_date'               => $modify_date,
                );
                
                $id_user_research = $this->common->insert_data_getid($data,'user_research');
                print_r($_job_research);
            }
        }
        echo "Done";
    }

    public function convert_detail_job_to_user_award()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $sql = "SELECT * FROM ailee_job_user_award WHERE status = '1'";
        $job_award = $this->db->query($sql)->result_array();
        echo "<pre>";
        echo count($job_award)."<br>";
        foreach ($job_award as $_job_award) {
            $sql1 = "SELECT * FROM ailee_user_award WHERE user_id = '".$_job_award['user_id']."' AND award_title = '".$_job_award['award_title']."'";
            $usr_award = $this->db->query($sql1)->row();
            if(isset($usr_award) && !empty($usr_award))
            {
                $new = 0;
            }
            else
            {
                $new = 1;
            }
            if($new == 1)
            {
                if($_job_award['award_file'] != "")
                {
                    $fileName = $_job_award['award_file'];
                    $job_user_award_upload_path = $this->config->item('job_user_award_upload_path');
                    $user_award_upload_path = $this->config->item('user_award_upload_path');
                    $file = $job_user_award_upload_path.$_job_award['award_file'];
                    $newfile = $user_award_upload_path.$_job_award['award_file'];
                    if(@copy($file, $newfile))
                    {
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                        if (IMAGEPATHFROM == 's3bucket') {
                            $abc = $s3->putObjectFile($newfile, bucket, $newfile, S3::ACL_PUBLIC_READ);
                        }
                    }
                }
                else
                {
                    $fileName = "";
                }

                $user_id = $_job_award['user_id'];
                $award_title = $_job_award['award_title'];
                $award_org = $_job_award['award_org'];
                $award_date = $_job_award['award_date'];
                $award_desc = $_job_award['award_desc'];
                $status = $_job_award['status'];
                $created_date = $_job_award['created_date'];
                $modify_date = $_job_award['modify_date'];

                $data = array(
                    'user_id'                   => $user_id,
                    'award_title'               => $award_title,
                    'award_org'                 => $award_org,
                    'award_date'                => $award_date,
                    'award_desc'                => $award_desc,
                    'award_file'                => $fileName,
                    'status'                    => $status,
                    'created_date'              => $created_date,
                    'modify_date'               => $modify_date,
                );
                
                // $id_user_award = $this->common->insert_data_getid($data,'user_award');
                print_r($_job_award);
            }
        }
        echo "Done";
    }

    public function convert_detail_job_to_user_patent()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $sql = "SELECT * FROM ailee_job_user_patent WHERE status = '1'";
        $job_patent = $this->db->query($sql)->result_array();
        echo "<pre>";
        echo count($job_patent)."<br>";
        foreach ($job_patent as $_job_patent) {
            $sql1 = "SELECT * FROM ailee_user_patent WHERE user_id = '".$_job_patent['user_id']."' AND patent_title = '".$_job_patent['patent_title']."'";
            $usr_patent = $this->db->query($sql1)->row();
            if(isset($usr_patent) && !empty($usr_patent))
            {
                $new = 0;
            }
            else
            {
                $new = 1;
            }
            if($new == 1)
            {
                if($_job_patent['patent_file'] != "")
                {
                    $fileName = $_job_patent['patent_file'];
                    $job_user_patent_upload_path = $this->config->item('job_user_patent_upload_path');
                    $user_patent_upload_path = $this->config->item('user_patent_upload_path');
                    $file = $job_user_patent_upload_path.$_job_patent['patent_file'];
                    $newfile = $user_patent_upload_path.$_job_patent['patent_file'];
                    if(@copy($file, $newfile))
                    {
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                        if (IMAGEPATHFROM == 's3bucket') {
                            $abc = $s3->putObjectFile($newfile, bucket, $newfile, S3::ACL_PUBLIC_READ);
                        }
                    }
                }
                else
                {
                    $fileName = "";
                }

                $user_id = $_job_patent['user_id'];
                $patent_title = $_job_patent['patent_title'];
                $patent_creator = $_job_patent['patent_creator'];
                $patent_number = $_job_patent['patent_number'];
                $patent_date = $_job_patent['patent_date'];
                $patent_office = $_job_patent['patent_office'];
                $patent_url = $_job_patent['patent_url'];
                $patent_desc = $_job_patent['patent_desc'];
                $status = $_job_patent['status'];
                $created_date = $_job_patent['created_date'];
                $modify_date = $_job_patent['modify_date'];

                $data = array(
                    'user_id'                   => $user_id,
                    'patent_title'              => $patent_title,
                    'patent_creator'            => $patent_creator,
                    'patent_number'             => $patent_number,
                    'patent_date'               => $patent_date,
                    'patent_office'             => $patent_office,
                    'patent_url'                => $patent_url,
                    'patent_desc'               => $patent_desc,
                    'patent_file'               => $fileName,
                    'status'                    => $status,
                    'created_date'              => $created_date,
                    'modify_date'               => $modify_date,
                );
                
                // $id_user_patent = $this->common->insert_data_getid($data,'user_patent');
                print_r($_job_patent);
            }
        }
        echo "Done";
    }

    public function convert_detail_job_to_user_activity()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $sql = "SELECT * FROM ailee_job_user_extra_activity WHERE status = '1'";
        $job_activity = $this->db->query($sql)->result_array();
        echo "<pre>";
        echo count($job_activity)."<br>";
        foreach ($job_activity as $_job_activity) {
            $sql1 = "SELECT * FROM ailee_user_extra_activity WHERE user_id = '".$_job_activity['user_id']."' AND activity_participate = '".$_job_activity['activity_participate']."' AND activity_org = '".$_job_activity['activity_org']."'";
            $usr_activity = $this->db->query($sql1)->row();
            if(isset($usr_activity) && !empty($usr_activity))
            {
                $new = 0;
            }
            else
            {
                $new = 1;
            }
            if($new == 1)
            {
                if($_job_activity['activity_file'] != "")
                {
                    $fileName = $_job_activity['activity_file'];
                    $user_activity_upload_path = $this->config->item('user_activity_upload_path');
                    $job_user_activity_upload_path = $this->config->item('job_user_activity_upload_path');
                    $file = $job_user_activity_upload_path.$_job_activity['activity_file'];
                    $newfile = $user_activity_upload_path.$_job_activity['activity_file'];
                    if(@copy($file, $newfile))
                    {
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                        if (IMAGEPATHFROM == 's3bucket') {
                            $abc = $s3->putObjectFile($newfile, bucket, $newfile, S3::ACL_PUBLIC_READ);
                        }
                    }
                }
                else
                {
                    $fileName = "";
                }

                $user_id = $_job_activity['user_id'];
                $activity_participate = $_job_activity['activity_participate'];
                $activity_org = $_job_activity['activity_org'];
                $activity_start_date = $_job_activity['activity_start_date'];
                $activity_end_date = $_job_activity['activity_end_date'];
                $activity_desc = $_job_activity['activity_desc'];                
                $status = $_job_activity['status'];
                $created_date = $_job_activity['created_date'];
                $modify_date = $_job_activity['modify_date'];

                $data = array(
                    'user_id'                   => $user_id,
                    'activity_participate'      => $activity_participate,
                    'activity_org'              => $activity_org,
                    'activity_start_date'       => $activity_start_date,
                    'activity_end_date'         => $activity_end_date,
                    'activity_desc'             => $activity_desc,                    
                    'activity_file'             => $fileName,
                    'status'                    => $status,
                    'created_date'              => $created_date,
                    'modify_date'               => $modify_date,
                );
                
                // $id_user_patent = $this->common->insert_data_getid($data,'user_extra_activity');
                print_r($_job_activity);
            }
        }
        echo "Done";
    }
}
