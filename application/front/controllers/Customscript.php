<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customscript extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
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
            echo $_main_dir."\n";
            // print_r($_main_dir_arr);
            if(count($_main_dir_arr) < 2 && ($_main_dir == "artistic_profile" || $_main_dir == "artistic_bg" || $_main_dir == "artistic_post" || $_main_dir == "business_bg" || $_main_dir == "business_profile" || $_main_dir == "business_post" || $_main_dir == "job_profile" || $_main_dir == "job_bg" || $_main_dir == "recruiter_profile" || $_main_dir == "recruiter_bg" || $_main_dir == "freelancer_hire_profile" || $_main_dir == "freelancer_hire_bg" || $_main_dir == "freelancer_post_profile" || $_main_dir == "freelancer_post_bg" || $_main_dir == "user_post" || $_main_dir == "user_profile" || $_main_dir == "user_bg"))
            {
                // echo $_main_dir."-------------";
                // $inner_dir = scandir('uploads/'.$_main_dir);

                $inner_dir = array_diff(scandir('uploads/'.$_main_dir), array('..', '.'));
                print_r($inner_dir);
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
                                echo "->YES";
                            }
                            else
                            {
                                echo "->NO";
                                // $s3->putObjectFile('uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir, bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir.'/'.$_inner_inner_dir, S3::ACL_PUBLIC_READ);
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
                            echo "->YES";
                        }
                        else
                        {
                            // $s3->putObjectFile('uploads/'.$_main_dir.'/'.$_inner_dir, bucket, 'uploads/'.$_main_dir.'/'.$_inner_dir, S3::ACL_PUBLIC_READ);
                            echo "->NO";
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
}
