<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends MY_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('email_model');

        // Get Site Information
        $this->data['title'] = 'Article | Aileensoul';
        $this->data['module_name'] = 'Article';
        $this->data['section_title'] = 'Article';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', TRUE);
        $this->paging = $this->config->item('paging');

        include('include.php');
        $adminid = $this->session->userdata('aileen_admin');

        // echo $this->profile->thumb();
    }

    public function list() {

        $join_str[0]['table'] = "user_post";
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

        $this->data['article_list'] = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str);
        // print_r($this->data['article_list']);exit();        
        $this->load->view('article/list', $this->data);
    }

    
    public function publish() {
        $id = $_POST['id'];
        $data = array(
            'status' => 'publish'
        );

        $update = $this->common->update_data($data, 'user_post', 'post_id', $id);
        echo 'Accepted';

        $join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.post_id";
        $join_str[0]['from_table_id'] = "post_article.id_post_article";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "post_article.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.post_for' => 'article','post_article.id_post_article'=>$id);

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $article_data = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str)[0];
        $fullname = ucwords($article_data['first_name']." ".$article_data['last_name']);
        $touser = $article_data['email'];
        $user_id = $article_data['user_id'];
        $article_slug = $article_data['article_slug'];
        
        $dataFollow = array(
            'not_type' => '10',//Article Accepted
            'not_from_id' => 1,
            'not_product_id'=>$id,
            'not_to_id' => $user_id,
            'not_read' => '2',                    
            'not_from' => '8',//Article
            'not_img' => '4',
            'not_created_date' => date('Y-m-d H:i:s'),
            'not_active' => '1'
        );
        echo $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');


        $email_user = '';
        $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
        <tr><td style="padding-left:20px;">Hi '.$fullname.'!<br><br><p style="padding-left:0px; padding-bottom: 20px;"> Your Article has been approved by the admin.</p><br></td></tr>';
        $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
        $email_user .= '<a href="'.SITEURL.'article/'.$article_slug.'">Click here to view article.</a>';
        $email_user .= '<br></td></tr>';        
        $email_user .= '</table>';

        $send_user = $this->email_model->send_email_new($subject = $subject, $templ = $email_user, $to_email = $touser);
        die();
    }

    public function reject() {
        $id = $_POST['id'];
        $data = array(
            'is_delete' => '1'
        );
        $update = $this->common->update_data($data, 'user_post', 'post_id', $id);
        echo 'Rejected';

        $join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.post_id";
        $join_str[0]['from_table_id'] = "post_article.id_post_article";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "post_article.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.post_for' => 'article','post_article.id_post_article'=>$id);

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $article_data = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str)[0];
        $fullname = ucwords($article_data['first_name']." ".$article_data['last_name']);
        $touser = $article_data['email'];
        $user_id = $article_data['user_id'];
        $article_slug = $article_data['article_slug'];        
        
        $dataFollow = array(
            'not_type' => '11',//Article Rejected
            'not_from_id' => 1,
            'not_product_id'=>$id,
            'not_to_id' => $user_id,
            'not_read' => '2',                    
            'not_from' => '8',//Article
            'not_img' => '4',
            'not_created_date' => date('Y-m-d H:i:s'),
            'not_active' => '1'
        );
        $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

        $email_user = '';
        $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
        <tr><td style="padding-left:20px;">Hi '.$fullname.'!<br><br><p style="padding-left:0px; padding-bottom: 20px;"> Your Article has been rejected by the admin.</p><br></td></tr>';        
        $email_user .= '</table>';

        $send_user = $this->email_model->send_email_new($subject = $subject, $templ = $email_user, $to_email = $touser);


        die();
    }

    public function articledetail($id) {
        
        $join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.post_id";
        $join_str[0]['from_table_id'] = "post_article.id_post_article";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "post_article.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.post_for' => 'article','post_article.id_post_article'=>$id);

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $this->data['article_detail'] = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str)[0];
        // print_r($this->data['article_detail']);exit();        
        $this->load->view('article/articledetail', $this->data);
    }
}
?>