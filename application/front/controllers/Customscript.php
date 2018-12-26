<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customscript extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('common');
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
}
