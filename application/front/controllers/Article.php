<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article extends MY_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('common');
        $this->load->model('email_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->model('article_model');
        $this->load->library('S3');
        $this->load->library('upload');
        $this->load->library("pagination");
        $this->load->library('encryption');
        
        include ('main_profile_link.php');
        include ('include.php');
        $this->data['aileenuser_id'] = $this->session->userdata('aileenuser');
    }

    public function index() {
        $userid = $this->session->userdata('aileenuser');
    }

    public function new_article()
    {
        $userid = $this->session->userdata('aileenuser');
        if($userid)
        {
            $this->data['userData'] = $this->user_model->getUserData($userid);
            $this->data['unique_key'] = $this->common->generate_article_unique_key(16);
            $this->data['meta_title'] = "Add Article";
            $this->data['meta_desc'] = "Add Article";
            $this->load->view('article/new_article', $this->data);
        }
        else
        {
            redirect(base_url(),"refresh");
        }
    }

    public function edit_article($unique_key)
    {
        $userid = $this->session->userdata('aileenuser');
        if($userid != "" && $unique_key != "")
        {
            $this->data['articleData'] = $this->article_model->getArticleData($userid,$unique_key);
            if(empty($this->data['articleData']))
            {
                redirect(base_url(),"refresh");
            }
            $this->data['unique_key'] = $unique_key;
            $this->data['meta_title'] = "Edit Article";
            $this->data['meta_desc'] = "Edit Article";
            $this->load->view('article/new_article', $this->data);
        }
        else
        {
            redirect(base_url(),"refresh");
        }
    }

    public function upload_image()
    {
        $config = array(
            'image_library' => 'gd',
            'upload_path'   => $this->config->item('article_upload_path'),
            'allowed_types' => $this->config->item('user_post_main_allowed_types'),
            'overwrite'     => true,
            'remove_spaces' => true
        );
        $store = $_FILES['file']['name'];
        $store_ext = explode('.', $store);        
        $store_ext = $store_ext[count($store_ext)-1];
        $fileName = 'file_' . random_string('numeric', 4) . '.' . $store_ext;        
        $config['file_name'] = $fileName;
        $this->upload->initialize($config);
        $imgdata = $this->upload->data();
        $unique_key = $this->input->post('unique_key');
        $article_title = $this->input->post('article_title');
        $article_content = $this->input->post('article_content');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            if($this->upload->do_upload('file'))
            {
                $success = $this->article_model->add_article_media($user_id,$article_title,$article_content,$unique_key,$fileName);                
                echo json_encode(array("location"=>base_url().'uploads/article/'.$fileName,"filename"=>$fileName,"add_new_article"=>$success['add_new_article']));
            }
            else
            {
                echo json_encode(array("location"=>'',"success"=>"0"));
            }
        }
        else
        {
            echo json_encode(array("location"=>"","success"=>"-1"));
        }
    }

    public function add_article()
    {
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $article_title = $this->input->post('article_title');
            $article_content = $this->input->post('article_content');
            $unique_key = $this->input->post('unique_key');
            $success = $this->article_model->add_article($user_id,$article_title,$article_content,$unique_key);
            echo json_encode($success);
        }
        else
        {
            echo json_encode(array("success"=>"-1"));
        }

    }
}