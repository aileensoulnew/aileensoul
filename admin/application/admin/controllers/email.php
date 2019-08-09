<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Email extends MY_Controller
{

    public $data;

    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }
        $this->load->model('email_model');
        // Get Site Information
        $this->data['title']         = 'Mail | Aileensoul';
        $this->data['module_name']   = 'Mailbox';
        $this->data['section_title'] = 'Mail';
        //Loadin Pagination Custome Config File
        $this->config->load('paging', true);
        $this->paging = $this->config->item('paging');

        include 'include.php';
        $adminid = $this->session->userdata('aileen_admin');

        // echo $this->profile->thumb();
    }

    public function compose($slug = "")
    {
        // echo $slug;die();
        //FOR GETTING ALL DATA STARt
        if ($slug == 'job') {
            $condition_array = array('emailid' => '1', 'email_status' => '1');
        }
        if ($slug == 'recruiter') {
            $condition_array = array('emailid' => '2', 'email_status' => '1');
        }
        if ($slug == 'freelancer') {
            $condition_array = array('emailid' => '3', 'email_status' => '1');
        }
        if ($slug == 'business') {
            $condition_array = array('emailid' => '4', 'email_status' => '1');
        }
        if ($slug == 'artistic') {
            $condition_array = array('emailid' => '5', 'email_status' => '1');
        }
        $this->data['email'] = $this->common->select_data_by_condition('emails_seo', $condition_array, $data = '*', $short_by = '', $order_by = '', $limit, $offset, $join_str = array());

        $this->data['subject'] = $this->common->select_data_by_condition('emails_seo', $condition_array = array(), $data = '*', $short_by = '', $order_by = '', $limit, $offset, $join_str = array());

        $this->data['slug'] = $slug;
        //FOR GETTING ALL DATA END
        $this->load->view('mail/compose', $this->data);
    }

    //LIST OF BLOG ADD BY ADMIN START
    public function compose_insert($slug = "")
    {
        $to_email = $_POST['toemail'];
        $subject  = $_POST['subjectmail'];
        $msg      = $_POST['compose'];

        $data = array(
            'varsubject'    => $subject,
            'varmailformat' => $msg,
            'timestamp'     => date('Y-m-d H:i:s'),
            'email_status'  => '1',
        );

        if ($slug == 'job') {
            $update = $this->common->update_data($data, 'emails_seo', 'emailid', 1);
        }

        if ($slug == 'recruiter') {
            $update = $this->common->update_data($data, 'emails_seo', 'emailid', 2);
        }

        if ($slug == 'freelancer') {
            $update = $this->common->update_data($data, 'emails_seo', 'emailid', 3);
        }

        if ($slug == 'business') {
            $update = $this->common->update_data($data, 'emails_seo', 'emailid', 4);
        }

        if ($slug == 'artistic') {
            $update = $this->common->update_data($data, 'emails_seo', 'emailid', 5);
        }

        $to_mail = explode(',', $to_email);

        foreach ($to_mail as $mail) {
            $mail = $this->email_model->sendEmail($app_name = '', $app_email = '', $mail, $subject, $msg);

        }
        redirect('email/compose/' . $slug, refresh);
    }
    //LIST OF BLOG ADD BY ADMIN END

    public function setting(){
        $this->data['section_title'] = 'Email Setting';        
        $sql = "SELECT * FROM ailee_email_settings ORDER BY modify_date DESC";
        $this->data['setting_data'] = $this->db->query($sql)->result_array();
        $this->load->view('mail/list_mailsetting', $this->data); 
    }
    public function add_setting(){
        $this->data['section_title'] = 'Email Setting';
        $this->data['id_email_settings'] = '';
        $this->load->view('mail/addedit_mailsetting', $this->data);
    }

    public function edit_setting($id_email_settings)
    {
        $this->data['section_title'] = 'Email Setting';
        $this->data['id_email_settings'] = $id_email_settings;
        $sql = "SELECT * FROM ailee_email_settings WHERE id_email_settings = '".$id_email_settings."'";
        $this->data['setting_data'] = $this->db->query($sql)->row_array();
        $this->load->view('mail/addedit_mailsetting', $this->data);
    }

    public function save_setting()
    {
        $id_email_settings = ($this->input->post('id_email_settings') ? $this->input->post('id_email_settings') : 0);
        $host_name = $this->input->post('host_name');
        $outgoing_port = $this->input->post('outgoing_port');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $from_email = $this->input->post('from_email');
        $from_name = $this->input->post('from_name');
        $replyto_email = $this->input->post('replyto_email');
        $replyto_name = $this->input->post('replyto_name');
        $smtp_secure = $this->input->post('smtp_secure');

        if($id_email_settings == 0)
        {
            $data = array(
                'host_name' => $host_name,
                'out_going_port' => $outgoing_port,
                'user_name' => $username,
                'password' => $password,
                'from_email' => $from_email,
                'from_name' => $from_name,
                'replyto_email' => $replyto_email,
                'replyto_name' => $replyto_name,
                'smtp_secure' => $smtp_secure,
                'status' => '0',
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time())
            );
            $insert_id = $this->common->insert_data_getid($data, 'email_settings');
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Email Setting Added successfully');
                redirect('email/setting');
            } else {
                $this->session->set_flashdata('error', 'Sorry!! Your data not inserted');
                redirect('email/add_setting');
            }
        }
        else
        {
            $data = array(
                'host_name' => $host_name,
                'out_going_port' => $outgoing_port,
                'user_name' => $username,
                'password' => $password,
                'from_email' => $from_email,
                'from_name' => $from_name,
                'replyto_email' => $replyto_email,
                'replyto_name' => $replyto_name,
                'smtp_secure' => $smtp_secure,                
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time())
            );            
            $updatdata = $this->common->update_data($data, 'email_settings', 'id_email_settings', $id_email_settings);

            if ($updatdata) {
                $this->session->set_flashdata('success', 'Email Setting updated successfully');
                redirect('email/setting');
            } else {
                $this->session->set_flashdata('error', 'Sorry!! Your data not updated');
                redirect('email/edit_setting/'.$id_email_settings);
            }
        }
    }

    public function setting_active()
    {
        $id = $this->input->post('id');
        
        $data = array("status" => "0");
        $this->db->update("email_settings", $data);

        $new_data = array("status" => "1",'modify_date' => date('Y-m-d H:i:s', time()));
        $this->db->where('id_email_settings',$id);        
        if ($this->db->update("email_settings", $new_data)) {
            $this->session->set_flashdata('success', 'Email Setting activate successfully');
            echo "1";
        } else {
            $this->session->set_flashdata('error', 'Sorry!! Try again later');
            echo "0";
        }
    }
}
