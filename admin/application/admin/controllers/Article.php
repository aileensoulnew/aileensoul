<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends CI_Controller {

    public $data;

    public function __construct() {

        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('email_model');
        $this->load->model('searchelastic_model');

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

    public function articlelist() {

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

        $total_rows = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit = "", $offset = "", $join_str);
        $this->paging['total_rows'] = count($total_rows);
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        // print_r($this->data['article_list']);exit();        
        $this->load->view('article/articlelist', $this->data);
    }

    
    public function publish() {

        $id = $_POST['id'];

        $cond1 = array('post_id' => $id,'post_for' => 'article');
        $post_data = $this->common->select_data_by_condition('user_post', $cond1, $data = '*', $short_by = '', $order_by = 'desc', $limit, $offset, $join_str)[0];

        $cond2 = array('user_id' => $post_data['user_id'],'status' => '1');
        $monetine_data = $this->common->select_data_by_condition('user_monetize', $cond2, $data = '*', $short_by = '', $order_by = 'desc', $limit, $offset, $join_str)[0];
        $data = array();
        
        $data['status'] = 'publish';
        $this->db->where('post_id', $id);
        $this->db->where('post_for', 'article');
        $update = $this->db->update('user_post', $data);
        if(isset($monetine_data) && !empty($monetine_data))
        {
            $inser_point = array(
                "user_id"       =>  $post_data['user_id'],
                "post_id"       =>  $post_data['id'],
                "points"        =>  30,
                "points_for"    =>  3,
                "description"   =>  '',
                "status"        =>  '0',
                "created_date"  =>  date('Y-m-d H:i:s', time()),
                "modify_date"   =>  date('Y-m-d H:i:s', time()),
            );
            $this->common->insert_data_getid($inser_point, 'user_point_mapper');
        }
        // $update = $this->common->update_data($data, 'user_post', 'post_id', $id);
        
        $this->searchelastic_model->add_edit_single_article($post_data['id']);
        
        $sql = "UPDATE ailee_post_article SET article_desc_old = article_desc WHERE id_post_article = '".$id."'";
        $query = $this->db->query($sql); 
        
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
        $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

        $img_url = base_url('assets/img/user.jpg');
        $data = array(
            'not_id'            => $insert_id,
            'not_title_name'    => 'Admin',
            'not_desc'          => 'has beed approved your article :<br><b>'.$article_data['article_title'].'</b>.',
            'not_image'         => $img_url,
            'not_url'           => SITEURL.'article/'.$article_slug,
            'user_id'           => '0',
            'user_type'         => '0',
            'status'            => '1',
            'created_date'      => date('Y-m-d H:i:s')
        );
        $this->common->insert_data_getid($data, 'notification_detail');

        $email_user = '';
        $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
        <tr><td style="padding-left:20px;">Hi '.$fullname.'!<br><br><p style="padding-left:0px; padding-bottom: 20px;">Your Article has approved by the Aileensoul.</p><br></td></tr>';
        $email_user .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
        $email_user .= '<a href="'.SITEURL.'article/'.$article_slug.'">Click here to view article.</a>';
        $email_user .= '<br></td></tr>';        
        $email_user .= '</table>';
        $subject = "Approve Article";
        if ($_SERVER['HTTP_HOST'] != "aileensoul.localhost") {
            $send_user = $this->email_model->send_email_new($subject = $subject, $templ = $email_user, $to_email = $touser);
        }
        die();
    }

    public function reject() {
        // $id = $_POST['id'];
        $id = $this->input->post('id');
        $data = array(
            'status' => 'reject'
        );
        $update = $this->common->update_data($data, 'user_post', 'post_id', $id);

        $data = array(
            'status' => 'reject'
        );
        $update1 = $this->common->update_data($data, 'post_article', 'id_post_article', $id);

        

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

        $article_data = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit = '', $offset = '', $join_str)[0];
        
        $fullname = ucwords($article_data['first_name']." ".$article_data['last_name']);
        $touser = $article_data['email'];
        $user_id = $article_data['user_id'];
        $article_slug = $article_data['article_slug'];        
        
        $dataFollow = array(
            'not_type' => '11',//Article Rejected
            'not_from_id' => '1',
            'not_product_id'=>$id,
            'not_to_id' => $user_id,
            'not_read' => '2',                    
            'not_from' => '8',//Article
            'not_img' => '4',
            'not_created_date' => date('Y-m-d H:i:s'),
            'not_active' => '1'
        );
        $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

        $img_url = base_url('assets/img/user.jpg');
        $data = array(
            'not_id'            => $insert_id,
            'not_title_name'    => 'Admin',
            'not_desc'          => 'has rejected your article:<br><b>'.$article_data['article_title'].'</b>.',
            'not_image'         => $img_url,
            'not_url'           => 'javascript:void(0);',
            'user_id'           => '0',
            'user_type'         => '0',
            'status'            => '1',
            'created_date'      => date('Y-m-d H:i:s'),
        );
        $this->common->insert_data_getid($data, 'notification_detail');
        
        echo 'Rejected';

        $email_user = '';
        $email_user .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
        <tr><td style="padding-left:20px;">Hi '.$fullname.'!<br><br><p style="padding-left:0px; padding-bottom: 20px;"> Your Article has been rejected by the Aileensoul.</p><br></td></tr>';
        $email_user .= '</table>';
        $subject = "Reject Article";
        $send_user = $this->email_model->send_email_new($subject = $subject, $templ = $email_user, $to_email = $touser);        

        exit();
    }

    public function delete() {
        $id = $_POST['id'];
        $data = array(
            'is_delete' => '1'
        );
        $update = $this->common->update_data($data, 'user_post', 'post_id', $id);

        $data = array(
            'status' => 'delete'
        );
        $update1 = $this->common->update_data($data, 'post_article', 'id_post_article', $id);

        echo 'Deleted';

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

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_desc_old, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $this->data['article_detail'] = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str)[0];
        // print_r($this->data['article_detail']);exit();        
        $this->load->view('article/articledetail', $this->data);
    }

    public function clear_search()
    {
        if ($this->session->userdata('user_search_keyword'))
        {
            $this->session->unset_userdata('user_search_keyword');
            redirect('article/articlelist','refresh');
        }
    }

    public function search() {
        if($this->input->post('search_keyword'))
        {
            $search_keyword = $this->input->post('search_keyword');
        }
        elseif($this->session->userdata('user_search_keyword'))
        {
            $search_keyword = $this->session->userdata('user_search_keyword');   
        }
        else
        {
            redirect('article/articlelist','refresh');
        }
        $this->data['search_keyword'] = trim($search_keyword);
        $this->session->set_userdata('user_search_keyword', $search_keyword);
        $this->data['user_search_keyword'] = $this->session->userdata('user_search_keyword');

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
        $this->paging['base_url'] = site_url("article/search");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }

        $join_str[0]['table'] = "user_post";
        $join_str[0]['join_table_id'] = "user_post.post_id";
        $join_str[0]['from_table_id'] = "post_article.id_post_article";

        $join_str[1]['table'] = "user";
        $join_str[1]['join_table_id'] = "user.user_id";
        $join_str[1]['from_table_id'] = "post_article.user_id";

        $join_str[2]['table'] = "user_login";
        $join_str[2]['join_table_id'] = "user_login.user_id";
        $join_str[2]['from_table_id'] = "user.user_id";

        $condition_array = array('user_post.post_for' => 'article',"post_article.article_desc LIKE '%".$search_keyword."%'"=>'');

        $select_data = "post_article.id_post_article, post_article.user_id, post_article.article_title, post_article.article_desc, post_article.article_featured_image, post_article.unique_key, post_article.status as article_status, post_article.created_date, post_article.article_slug, user_post.post_for, user_post.post_id, user_post.status as user_post_status,user_post.is_delete as user_post_isdeleted, user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

        $this->data['article_list'] = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit, $offset, $join_str);

        $total_rows = $this->common->select_data_by_condition('post_article', $condition_array, $data = $select_data, $short_by = 'id_post_article', $order_by = 'desc', $limit = "", $offset = "", $join_str);
        $this->paging['total_rows'] = count($total_rows);
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);        
        // print_r($this->data['article_list']);exit();        
        $this->load->view('article/articlelist', $this->data);
    }
}
?>