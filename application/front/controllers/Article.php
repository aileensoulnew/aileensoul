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

    public function article_preview($article_slug)
    {
        $userid = $this->session->userdata('aileenuser');
        if($userid != "")
        {
            $this->data['article_data'] = $article_data = $this->article_model->getArticleDataFromSlug($article_slug);
            // print_r($article_data);exit();
            if(empty($article_data))
            {
                redirect(base_url(),"refresh");
            }
            $this->data['article_media_data'] = $article_media_data = $this->article_model->getArticleMediaData($article_data['id_post_article']);            
            $this->data['meta_title'] = "Edit Article";
            $this->data['meta_desc'] = "Edit Article";
            $this->load->view('article/article_preview', $this->data);
        }
        else
        {
            // redirect(base_url(),"refresh");
        }
    }

    public function upload_image()
    {
        $article_upload_path = $this->config->item('article_upload_path');
        $config = array(
            'image_library' => 'gd',
            'upload_path'   => $article_upload_path,
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
                $main_image = $article_upload_path . $fileName;

                $s3 = new S3(awsAccessKey, awsSecretKey);
                $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
                if (IMAGEPATHFROM == 's3bucket') {
                    $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
                }

                $success = $this->article_model->add_article_media($user_id,$article_title,$article_content,$unique_key,$fileName);                
                echo json_encode(array("location"=>base_url().$article_upload_path.$fileName,"filename"=>$fileName,"add_new_article"=>$success['add_new_article']));
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

    public function publish_article()
    {
        // print_r($this->input->post());exit();
        $article_title = $this->input->post('article_title');
        $article_content = $this->input->post('article_content');
        $unique_key = $this->input->post('unique_key');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $article_data = $this->article_model->getArticleData($user_id,$unique_key);
            $id_post_article = $article_data['id_post_article'];            
            $article_mediaData = $this->article_model->getArticleMediaData($id_post_article);
            $user_post_article = $this->article_model->getUserPostArticle($id_post_article);
            $doc = new DOMDocument();
            $doc->loadHTML($article_content);
            $xpath = new DOMXPath($doc);
            // $src = $xpath->evaluate("string(//img/@src)");
            $images = $xpath->query('//img/@src');
            $img_arr = array();
            foreach($images as $_images)
            {
                $img_arr[] = substr($_images->value, strrpos($_images->value, '/') + 1);
            }
            foreach ($article_mediaData as $_articleMediaData) {
                # code...
                if (!in_array($_articleMediaData['image_url'], $img_arr)) 
                {
                    $article_img = $this->config->item('article_upload_path').$_articleMediaData['image_url'];
                    @unlink($article_img);
                    $this->common->delete_data('post_article_media','id',$_articleMediaData['id']);
                } 
            }
            if(isset($user_post_article) && !empty($user_post_article))
            {
                $post_id = $user_post_article['post_id'];
                $new_post = 0;
            }
            else
            {

                $data = array(
                    "user_id"                   => $user_id,
                    "post_for"                  => "article",
                    "post_id"                   => $id_post_article,
                    "created_date"              => date('Y-m-d h:i:s', time()),
                    "status"                    => "draft",
                    "is_delete"                 => '0',
                );
                $post_id = $this->common->insert_data_getid($data,'user_post');
                $new_post = 1;
            }

            if($post_id > 0)
            {
                $data_update = array(
                    "article_title" => $article_title,                    
                    "article_desc"  => $article_content,                    
                    "status"        => 'publish',                    
                    "modify_date"   => date('Y-m-d h:i:s', time()),                    
                );
                if($new_post == 1)
                {
                    $article_slug = $this->common->set_slug($article_title, 'article_slug', 'post_article');
                    $data_update["article_slug"] = $article_slug;
                }
                
                $udapte_data = $this->common->update_data($data_update,'post_article','id_post_article', $id_post_article);
                $ret_arr = array("status"=>"1","message"=>"Article published successfully.","is_publish"=>1);
            }
            else
            {
                $ret_arr = array("status"=>"0","message"=>"Try again later.","is_publish"=>0);
            }            
        }
        else
        {
            $ret_arr = array("status"=>"0","message"=>"Try again later.","is_publish"=>0);
        }
        echo json_encode($ret_arr);
    }

    public function upload_featured_img()
    {
        $unique_key = $this->input->post('unique_key');
        $article_title = $this->input->post('article_title');
        $article_content = $this->input->post('article_content');
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {        
            $article_data = $this->article_model->getArticleData($user_id,$unique_key);
            $article_featured_image = $article_data['article_featured_image'];
            $article_featured_upload_path = $this->config->item('article_featured_upload_path');
            if($article_featured_image != "")
            {
                @unlink($article_featured_image.$article_featured_upload_path);
            }
            $data = $_POST['image'];
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);
            $user_bg_path = $this->config->item('article_featured_upload_path');
            $imageName = "featured_".time() . '.png';
            $data = base64_decode($data);
            $file = $user_bg_path . $imageName;
            $success = file_put_contents($file, $data);

            //$this->thumb_img_uplode($file, $imageName, $user_bg_path, 1920, 500);

            $user_post_resize4['image_library'] = 'gd2';
            $user_post_resize4['source_image'] = $this->config->item('article_featured_upload_path') . $imageName;
            $user_post_resize4['new_image'] =  $this->config->item('article_featured_upload_path') . $imageName;
            $user_post_resize4['create_thumb'] = FALSE;
            $user_post_resize4['maintain_ratio'] = TRUE;
            $user_post_resize4['thumb_marker'] = '';
            $user_post_resize4['width'] = 1920;
            $user_post_resize4['height'] = 500;
            //$user_post_resize4['master_dim'] = width;
            $user_post_resize4['quality'] = "100%";
            $instanse4 = "image4";
            //Loading Image Library
            $this->load->library('image_lib', $user_post_resize4, $instanse4);
            //Creating Thumbnail
            $this->$instanse4->resize();
            //$this->$instanse4->clear();

            $main_image = $user_bg_path . $imageName;

            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(bucket, S3::ACL_PUBLIC_READ);
            if (IMAGEPATHFROM == 's3bucket') {
                $abc = $s3->putObjectFile($main_image, bucket, $main_image, S3::ACL_PUBLIC_READ);
            }

            $success = $this->article_model->add_article_featured($user_id,$article_title,$article_content,$unique_key,$imageName);

            echo json_encode(array("featured_img"=>base_url().$article_featured_upload_path.$imageName,"add_new_article"=>$success['add_new_article'],"success"=>$success['success']));
        }
        else
        {
            echo json_encode(array("featured_img"=>"","success"=>"-1"));
        }    
    }
}