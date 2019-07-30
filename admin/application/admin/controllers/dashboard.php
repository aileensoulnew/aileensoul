<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends MY_Controller {
  
    public $data;

    public function __construct() {
 
      parent::__construct();

        if (!$this->session->userdata('aileen_admin')) 
        {
            redirect('login', 'refresh');
        }
        
        // Get Site Information
        $this->data['title'] = 'Dashboard | Aileensoul';
        $this->data['section_title'] = 'Dashboard';

        include('include.php');


    }

    public function index()
    {
        $adminid =  $this->session->userdata('aileen_admin');

        $user_sql = "SELECT COUNT(*) as total_user FROM ailee_user u LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id WHERE ul.status = '1' AND ul.is_delete = '0'";
        $this->data['user_count'] = $this->db->query($user_sql)->row()->total_user;

        $business_sql = "SELECT COUNT(*) as total_business FROM ailee_business_profile bp LEFT JOIN ailee_user_login ul ON ul.user_id = bp.user_id WHERE ul.status = '1' AND ul.is_delete = '0' AND bp.status = '1' AND bp.is_deleted = '0' AND bp.business_step ='4'";
        $this->data['business_count'] = $this->db->query($business_sql)->row()->total_business;

        $date = date('Y-m-d');
        $visit_sql = "SELECT COUNT(*) as total_visit FROM ailee_user_visit WHERE insert_date >= '".$date."'";
        $this->data['user_visit'] = $this->db->query($visit_sql)->row()->total_visit;

        $contition_array = array('insert_date >= ' => $date);
        $user_visit = $this->common->select_data_by_condition('user_visit', $contition_array, $data = 'id', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');
        $this->data['count_visit'] = count($user_visit);
        
        
        $this->load->view('dashboard/index',$this->data);


        // print_r($this->data['art_list']);die();
    }

    //logout user
    public function logout() {

        
        // $this->session->set_userdata('aileen_admin', $admin_check[0]['admin_id']);

        if ($this->session->userdata('aileen_admin')) {
            

            $this->session->unset_userdata('aileen_admin');

            redirect('login', 'refresh');
        }
    }

    
    

    public function change_password() {

 
        if($this->input->post('old_pass')){
            
            $user_id = ($this->session->userdata('dollarbid_admin'));
            $old_password=$this->input->post('old_pass');
            $new_password=  $this->input->post('new_pass');
          
            $admin_old_password = $this->common->select_data_by_id('admin','admin_id',1,'admin_password');
            $admin_password = $admin_old_password[0]['admin_password'];

            if($admin_password == md5($old_password)){
                $update_array=array('admin_password'=> md5($new_password));
                $update_result=  $this->common->update_data($update_array,'admin','admin_id',1);
                if($update_result){
                    $this->session->set_flashdata('success','Your password is successfully changed.');
                    redirect('dashboard/change_password','refresh');
                }
                else{
                    $this->session->set_flashdata('error','Error Occurred. Try Again!');
                    redirect('dashboard/change_password','refresh');
                }
            }
            else{
                $this->session->set_flashdata('error','Old password does not match');
                redirect('dashboard/change_password','refresh');
            }
        }
        
        $this->data['module_name'] = 'Dashboard';
        $this->data['section_title'] = 'Change Password';
        $this->load->view('dashboard/change_password', $this->data);
    }

    
    //check old password
    public function check_old_pass() {
        if ($this->input->is_ajax_request() && $this->input->post('old_pass')) {
            $user_id = ($this->session->userdata('dollarbid_admin'));

            $old_pass = $this->input->post('old_pass');
            $check_result = $this->common->select_data_by_id('user','user_id',$user_id,'password');
            if ($check_result[0]['password'] === md5($old_pass)) {
                echo 'true';
                die();
            } else {
                echo 'false';
                die();
            }
        }
    }
    
}

?>