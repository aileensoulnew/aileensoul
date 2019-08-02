<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Posts extends CI_Controller
{

    public $data;
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('aileen_admin')) {
            redirect('login', 'refresh');
        }

        $this->load->model('email_model');
        $this->load->model('post_model');
        $this->load->model('searchelastic_model');

        // Get Site Information
        $this->data['title']         = 'Posts | Aileensoul';
        $this->data['module_name']   = 'Posts';
        $this->data['section_title'] = 'Posts';

        //Loadin Pagination Custome Config File
        $this->config->load('paging', true);
        $this->paging = $this->config->item('paging');

        include 'include.php';
        $adminid = $this->session->userdata('aileen_admin');

        // echo $this->profile->thumb();
    }

    public function list()
    {
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
        $this->paging['base_url'] = site_url("posts/list");
        if ($this->uri->segment(3) != '' && $this->uri->segment(4) != '') {
            $this->paging['uri_segment'] = 5;
        } else {
            $this->paging['uri_segment'] = 3;
        }
        $this->data['post_list'] =  $this->post_model->get_all_post($offset,$limit);
        $total_rows =  $this->post_model->get_all_post_total();

        $this->paging['total_rows'] = $total_rows;
        $this->data['total_rows'] = $this->paging['total_rows'];
        $this->data['limit'] = $limit;
        $this->pagination->initialize($this->paging);
        $this->data['search_keyword'] = '';
        // print_r($this->data['article_list']);exit();        
        $this->load->view('posts/list', $this->data);
    }
}
