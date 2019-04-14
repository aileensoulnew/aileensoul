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

        $select_data = "user_point_mapper.id_user_point_mapper, user_point_mapper.points, user_point_mapper.user_id, ,user_point_mapper.created_date, user_point_mapper.status as point_status, user_post.post_for, user_post.id, user_post.post_id ,user_post.status as user_post_status ,user_post.is_delete as user_post_isdeleted , user.first_name, user.last_name, user.user_dob, user.user_gender, user.user_agree, user.user_slug, user.is_student, user.is_subscribe,user_login.email";

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
}
?>