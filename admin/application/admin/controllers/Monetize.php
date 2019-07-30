<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monetize extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('email_model');        

        // Get Site Information
        $this->data['title'] = 'Monetization | Aileensoul';
        $this->data['module_name'] = 'Monetization';
        $this->data['section_title'] = 'Monetization';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
        $adminid = $this->session->userdata('aileen_admin');

        // echo $this->profile->thumb();
    }

    public function postlist() {

        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;
            $sortby = $this->uri->segment(3);
            $orderby = $this->uri->segment(4);
        } else {
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $sortby = 'id';
            $orderby = 'desc';
        }
  
        $this->data['offset'] = $offset;
        $this->paging['base_url'] = site_url("monetize/postlist");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }        

        $join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.id";
        $join_str[0]['from_table_id'] = "user_point_mapper.post_id";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "user_point_mapper.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.status' => 'publish','user_post.is_delete' => '0');

        $select_data = "user_point_mapper.id_user_point_mapper, user_point_mapper.points, user_point_mapper.user_id, user_point_mapper.created_date, user_point_mapper.status as point_status, user_point_mapper.points_for, user_point_mapper.description, user_post.post_for, user_post.id, user_post.post_id ,user_post.status as user_post_status ,user_post.is_delete as user_post_isdeleted , user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $points_list = $this->common->select_data_by_condition('user_point_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_point_mapper', $order_by = 'desc', $limit, $offset, $join_str);
        

        foreach ($points_list as $key => $value) {
            if($value['post_for'] == 'simple')
            {
                $simple_post_data = $this->db->select('*')->get_where('user_simple_post', array('post_id' => $value['id']))->row();
                $points_list[$key]['title'] = $simple_post_data->sim_title;
                $points_list[$key]['slug'] = 'p/'.$simple_post_data->simslug;
            }
            else if($value['post_for'] == 'opportunity')
            {
                $opportunity_post_data = $this->db->select('*')->get_where('user_opportunity', array('post_id' => $value['id']))->row();
                $points_list[$key]['title'] = $opportunity_post_data->opptitle;
                $points_list[$key]['slug'] = 'o/'.$opportunity_post_data->oppslug;
            }
            else if($value['post_for'] == 'article')
            {
                $article_post_data = $this->db->select('*')->get_where('post_article', array('id_post_article' => $value['post_id']))->row();
                $points_list[$key]['title'] = $article_post_data->article_title;
                $points_list[$key]['slug'] = 'article/'.$article_post_data->article_slug;
            }
            else if($value['post_for'] == 'question')
            {
                $question_post_data = $this->db->select('*')->get_where('user_ask_question', array('post_id' => $value['id']))->row();
                $points_list[$key]['title'] = $question_post_data->question;
                $points_list[$key]['slug'] = 'questions/'.$question_post_data->id.'/'.$this->common->create_slug($question_post_data->question);
            }
        }
        $this->data['points_list'] = $points_list;
        // print_r($points_list);exit();

        $total_rows = $this->common->select_data_by_condition('user_point_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_point_mapper', $order_by = 'desc', $limit = "", $offset = "", $join_str);
        $this->paging['total_rows'] = count($total_rows);
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        // print_r($this->data['article_list']);exit();        
        $this->load->view('monetize/monetizelist', $this->data);
    }

    public function approve_point() {
        $id_user_point_mapper = $_POST['id'];

        $point_data = $this->db->select('*')->get_where('user_point_mapper', array('id_user_point_mapper' => $id_user_point_mapper))->row();
        // print_r($point_data);
        
        $payment_data = $this->db->select('*')->get_where('user_payment_mapper', array('user_id' => $point_data->user_id,'earn_amount <' => '10'))->row();
        
        if(isset($payment_data) && !empty($payment_data))
        {
            $modify_date =  date('Y-m-d H:i:s', time());
            $earn_amount = $point_data->points / 100;
            $update_sql = "UPDATE ailee_user_payment_mapper SET earn_points = earn_points + '".$point_data->points."', earn_amount = earn_amount + '".$earn_amount."', modify_date = '".$modify_date."' WHERE id_user_payment_mapper =  '".$payment_data->id_user_payment_mapper."'";            
            // echo $update_sql;exit();
            $update = $this->db->query($update_sql);
        }
        else
        {
            $data = array(
                'user_id' => $point_data->user_id,
                'earn_points' => $point_data->points,
                'earn_amount' => $point_data->points/100,
                'created_date' => date('Y-m-d H:i:s', time()),
                'modify_date' => date('Y-m-d H:i:s', time()),
                'status' => 'unpaid',
            );
            $this->common->insert_data_getid($data, 'user_payment_mapper');            
        }
        // print_r($payment_data);exit();
        $data = array(
            'status' => '1'
        );
        $update = $this->common->update_data($data, 'user_point_mapper', 'id_user_point_mapper', $id_user_point_mapper);
        
        echo 'Approved';
        exit();
    }

    public function reject_point() {
        $id_user_point_mapper = $_POST['id'];
        $data = array(
            'status' => '2'
        );
        $update = $this->common->update_data($data, 'user_point_mapper', 'id_user_point_mapper', $id_user_point_mapper);
        
        echo 'Rejected';
        exit();
    }

    public function paymentprocess(){

        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;
            $sortby = $this->uri->segment(3);
            $orderby = $this->uri->segment(4);
        } else {
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $sortby = 'id';
            $orderby = 'desc';
        }
  
        $this->data['offset'] = $offset;
        $this->paging['base_url'] = site_url("monetize/paymentprocess");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "user_payment_mapper.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user_payment_mapper.user_id";

        $condition_array = array('user_payment_mapper.earn_points >=' => '1000','user_payment_mapper.earn_amount >=' => '10');

        $select_data = "user_payment_mapper.id_user_payment_mapper, user_payment_mapper.earn_points, user_payment_mapper.user_id, user_payment_mapper.earn_amount, user_payment_mapper.created_date, user_payment_mapper.modify_date, user_payment_mapper.status, user_payment_mapper.payment_date, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $payment_list = $this->common->select_data_by_condition('user_payment_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_payment_mapper', $order_by = 'desc', $limit, $offset, $join_str);
       
        $this->data['payment_list'] = $payment_list;
        // print_r($payment_list);exit();

        $total_rows = $this->common->select_data_by_condition('user_payment_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_payment_mapper', $order_by = 'desc', $limit = "", $offset = "", $join_str);
        $this->paging['total_rows'] = count($total_rows);
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        
        $this->load->view('monetize/paymentlist', $this->data);
    }

    public function monetizedetail($id){        
        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "user_payment_mapper.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user_payment_mapper.user_id";

        $condition_array = array('user_payment_mapper.id_user_payment_mapper' => $id);

        $select_data = "user_payment_mapper.id_user_payment_mapper, user_payment_mapper.earn_points, user_payment_mapper.user_id, user_payment_mapper.earn_amount, user_payment_mapper.created_date, user_payment_mapper.modify_date, user_payment_mapper.status, user_payment_mapper.payment_date, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $payment_list = $this->common->select_data_by_condition('user_payment_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_payment_mapper', $order_by = 'desc', $limit, $offset, $join_str)[0];
       
        $this->data['payment_detail'] = $payment_list;

        $condition_array1 = array('user_id' => $payment_list['user_id']);
        $bank_detail = $this->common->select_data_by_condition('user_bank_detail', $condition_array1, "*", $short_by, $order_by = '', $limit, $offset, $join_str='')[0];
       
        $this->data['bank_detail'] = $bank_detail;
        // print_r($bank_detail);
        // print_r($payment_list);exit();

        $this->load->view('monetize/paymentdetail', $this->data);
    }

    public function payamount() {

        $id = $_POST['id'];

        $cond1 = array('id_user_payment_mapper' => $id);
        $payment_data = $this->common->select_data_by_condition('user_payment_mapper', $cond1, $data = '*', $short_by = '', $order_by = 'desc', $limit, $offset, $join_str)[0];
        if($payment_data)
        {            
            $data = array();
            $data['status'] = 'paid';
            $data['payment_date'] = date('Y-m-d H:i:s');
            $this->db->where('id_user_payment_mapper', $id);            
            $update = $this->db->update('user_payment_mapper', $data);

            echo 'Payment Complete';
        }
        
        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "user_payment_mapper.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user_payment_mapper.user_id";

        $condition_array = array('user_payment_mapper.id_user_payment_mapper >=' => $id);

        $select_data = "user_payment_mapper.id_user_payment_mapper, user_payment_mapper.earn_points, user_payment_mapper.user_id, user_payment_mapper.earn_amount, user_payment_mapper.created_date, user_payment_mapper.modify_date, user_payment_mapper.status, user_payment_mapper.payment_date, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $payment_data = $this->common->select_data_by_condition('user_payment_mapper', $condition_array, $data = $select_data, $short_by = 'id_user_payment_mapper', $order_by = 'desc', $limit, $offset, $join_str)[0];

        $fullname = ucwords($payment_data['first_name']." ".$payment_data['last_name']);
        $touser = $payment_data['email'];
        $user_slug = $payment_data['user_slug'];


        $email_user = '';
        $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
        <tr><td style="padding-left:20px;">Hi '.$fullname.'!<br><br><p style="padding-left:0px; padding-bottom: 20px;">Your payment has released from Aileensoul.</p><br></td></tr>';
        $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
        $email_user .= '<a href="'.SITEURL.$user_slug.'/monetization-analytics">Click here to view payment.</a>';
        $email_user .= '<br></td></tr>';        
        $email_user .= '</table>';
        $subject = "Payment Released";
        if ($_SERVER['HTTP_HOST'] != "aileensoul.localhost") {
            $send_user = $this->email_model->send_email_new($subject = $subject, $templ = $email_user, $to_email = $touser);
        }
        die();
    }

    public function rejectamount() {

        $id = $_POST['id'];

        $cond1 = array('id_user_payment_mapper' => $id);
        $payment_data = $this->common->select_data_by_condition('user_payment_mapper', $cond1, $data = '*', $short_by = '', $order_by = 'desc', $limit, $offset, $join_str)[0];
        if($payment_data)
        {            
            $data = array();
            $data['status'] = 'reject';
            $data['payment_date'] = date('Y-m-d H:i:s');
            $this->db->where('id_user_payment_mapper', $id);            
            $update = $this->db->update('user_payment_mapper', $data);

            echo 'Payment Complete';
        }
        die();
    }    

    public function userlist()
    {
        // This is userd for pagination offset and limoi start
        $limit = $this->paging['per_page'];
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {

            $offset = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 0;

            $sortby = $this->uri->segment(3);

            $orderby = $this->uri->segment(4);

        } else {

            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $sortby = 'user_id';

            $orderby = 'desc';

        }

        $this->data['offset'] = $offset;        

        $tot_sql = $sql = "SELECT SUM(upm.points) as total_point,u.user_id,u.first_name,u.last_name,ul.email FROM ailee_user_point_mapper upm LEFT JOIN ailee_user u ON u.user_id = upm.user_id LEFT JOIN ailee_user_login ul ON ul.user_id = upm.user_id WHERE upm.status = '1' AND ul.status = '1' AND ul.is_delete = '0' GROUP BY upm.user_id ORDER BY total_point DESC";
        if($limit != '') {
            $sql .= " LIMIT $offset,$limit";
        }

        $this->data['users'] = $this->db->query($sql)->result_array();

        $total_rows = $this->db->query($tot_sql)->result_array();
        
        $this->paging['base_url'] = site_url("monetize/userlist/");
        $this->paging['uri_segment'] = 3;
        
        $this->paging['total_rows'] = count($total_rows);

        $this->data['total_rows'] = $this->paging['total_rows'];

        $this->data['limit'] = $limit;

        $this->pagination->initialize($this->paging);

        $this->data['search_keyword'] = '';
        // print_r($this->data);exit();
        $this->load->view('monetize/userlist', $this->data);
    }

    public function search()
    {

        if ($this->input->post('search_keyword')) {
            //echo "222"; die();

            $this->data['search_keyword'] = $search_keyword = trim($this->input->post('search_keyword'));

            $this->session->set_userdata('monetize_search_keyword', $search_keyword);

            $this->data['monetize_search_keyword'] = $this->session->userdata('monetize_search_keyword');

            // This is userd for pagination offset and limoi start
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;

            $this->data['offset'] = $offset;

            $sql = "SELECT SUM(upm.points) as total_point,u.user_id,u.first_name,u.last_name,ul.email FROM ailee_user_point_mapper upm LEFT JOIN ailee_user u ON u.user_id = upm.user_id LEFT JOIN ailee_user_login ul ON ul.user_id = upm.user_id WHERE upm.status = '1' AND ul.status = '1' AND ul.is_delete = '0' ";
            if($search_keyword != '')
            {
                $sql .= "AND ((CONCAT(u.first_name,' ',u.last_name) LIKE '%$search_keyword%' OR CONCAT(u.last_name,' ',u.first_name) LIKE '%$search_keyword%') OR ul.email LIKE '%$search_keyword%')";                
            }
            $sql .= " GROUP BY upm.user_id ORDER BY total_point DESC";
            $tot_sql = $sql;

            if($limit != '') {
                $sql .= " LIMIT $offset,$limit";
            }

            $this->data['users'] = $this->db->query($sql)->result_array();

            $total_rows = $this->db->query($tot_sql)->result_array();            

            //This if and else use for asc and desc while click on any field start
            $this->paging['base_url'] = site_url("monetize/search/");
            $this->paging['uri_segment'] = 3;

            $this->paging['total_rows'] = count($total_rows);

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);

        } else if ($this->session->userdata('monetize_search_keyword')) {
            $this->data['search_keyword'] = $search_keyword = trim($this->session->userdata('monetize_search_keyword'));
            // This is userd for pagination offset and limoi start
            $limit = $this->paging['per_page'];
            $offset = ($this->uri->segment(3) != '') ? $this->uri->segment(3) : 0;
            $this->data['offset'] = $offset;

            $sql = "SELECT SUM(upm.points) as total_point,u.user_id,u.first_name,u.last_name,ul.email FROM ailee_user_point_mapper upm LEFT JOIN ailee_user u ON u.user_id = upm.user_id LEFT JOIN ailee_user_login ul ON ul.user_id = upm.user_id WHERE upm.status = '1' AND ul.status = '1' AND ul.is_delete = '0' ";
            if($search_keyword != '')
            {
                $sql .= "AND ((CONCAT(u.first_name,' ',u.last_name) LIKE '%$search_keyword%' OR CONCAT(u.last_name,' ',u.first_name) LIKE '%$search_keyword%') OR ul.email LIKE '%$search_keyword%')";                
            }
            $sql .= " GROUP BY upm.user_id ORDER BY total_point DESC";
            $tot_sql = $sql;

            if($limit != '') {
                $sql .= " LIMIT $offset,$limit";
            }

            $this->data['users'] = $this->db->query($sql)->result_array();

            $total_rows = $this->db->query($tot_sql)->result_array();

            //This if and else use for asc and desc while click on any field start
            
            $this->paging['base_url'] = site_url("monetize/search/");
            $this->paging['uri_segment'] = 3;

            $this->paging['total_rows'] = count($total_rows);

            //for record display

            $this->data['total_rows'] = $this->paging['total_rows'];

            $this->data['limit'] = $limit;

            $this->pagination->initialize($this->paging);
        }

        $this->load->view('monetize/userlist', $this->data);

    }

    //clear search is used for unset session start
    public function clear_search()
    {
        if ($this->session->userdata('monetize_search_keyword')) {

            $this->session->unset_userdata('monetize_search_keyword');

            redirect('monetize/userlist', 'refresh');
        }
    }
}
?>