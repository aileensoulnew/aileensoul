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
        $this->load->model('monetize_model');

        // Get Site Information
        $this->data['title'] = 'Monetize | Aileensoul';
        $this->data['module_name'] = 'Monetize';
        $this->data['section_title'] = 'Monetize';

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
        $this->paging['base_url'] = site_url("article/articlelist");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }        

        /*$join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.post_id";
        $join_str[0]['from_table_id'] = "post_article.id_post_article";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "post_article.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.post_for' => 'article');

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $this->data['article_list'] = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str);*/
        $this->data['article_list'] = $this->monetize_model->all_post('',10,$offset);
        print($this->data['article_list']);exit();

        // $total_rows = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit = "", $offset = "", $join_str);
        $this->paging['total_rows'] = count($total_rows);
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        // print_r($this->data['article_list']);exit();        
        $this->load->view('article/articlelist', $this->data);
    }
}
?>