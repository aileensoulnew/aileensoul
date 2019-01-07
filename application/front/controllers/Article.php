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
        $this->load->model('user_post_model');
        $this->load->model('userprofile_model');
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
            $this->data['user_data'] = $this->user_model->getLeftboxData($userid);
            $this->data['unique_key'] = $this->common->generate_article_unique_key(16);
            $this->data['meta_title'] = "Add Article";
            $this->data['meta_desc'] = "Add Article";
            $this->data['articleData'] = array();
            $this->data['new_article'] = "1";
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
            $this->data['articleData'] = $article_data = $this->article_model->getArticleData($userid,$unique_key);
            if(empty($article_data))
            {
                redirect(base_url(),"refresh");
            }
            $id_post_article = $article_data['id_post_article'];
            $this->data['user_post_article'] = $user_post_article = $this->article_model->getUserPostArticle($id_post_article);
            // print_r($article_data);
            // print_r($user_post_article);exit();
            $edit_art_published = 0;
            if(isset($user_post_article) && !empty($user_post_article))
            {
                if($user_post_article['status'] == 'publish' && $article_data['status'] == 'publish')
                {
                    $edit_art_published = 1;
                }
                elseif($user_post_article['status'] == 'draft' && $article_data['status'] == 'publish')
                {
                    redirect(base_url(),"refresh");
                }
            }
            $this->data['user_data'] = $this->user_model->getLeftboxData($userid);
            $this->data['edit_art_published'] = $edit_art_published;
            $this->data['unique_key'] = $unique_key;
            $this->data['meta_title'] = "Edit Article";
            $this->data['meta_desc'] = "Edit Article";
            $this->data['new_article'] = "0";
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
            if(empty($article_data) || $article_data['user_id'] != $userid)
            {
                redirect(base_url(),"refresh");
            }
            $this->data['user_data'] = $this->user_model->getLeftboxData($article_data['user_id']);
            $id_post_article = $article_data['id_post_article'];
            $this->data['article_media_data'] = $article_media_data = $this->article_model->getArticleMediaData($id_post_article);            
            $this->data['user_post_article'] = $user_post_article = $this->article_model->getUserPostArticle($id_post_article);
            if($user_post_article['status'] == 'publish')
            {
                redirect(base_url(),"refresh");   
            }
            /*print_r($this->data['article_data']);
            print_r($this->data['user_post_article']);
            print_r($this->data['user_data']);exit();*/
            if($user_post_article['is_delete'] == '1')
            {
                $this->load->view('404', $this->data);
            }
            else
            {
                $this->load->view('article/article_preview', $this->data);
            }
        }
        else
        {
            redirect(base_url(),"refresh");
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
        $article_meta_title = $this->input->post('article_meta_title');
        $article_meta_description = $this->input->post('article_meta_description');
        $article_main_category = $this->input->post('article_main_category');
        $edit_art_published = $this->input->post('edit_art_published');
        if($article_main_category == 0)
        {                
            $article_other_category = $this->input->post('article_other_category');
        }
        else
        {
            $article_other_category = "";
        }
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
                if($edit_art_published == 0)
                {                    
                    $success = $this->article_model->add_article_media($user_id,$article_title,$article_content,$unique_key,$fileName,$article_meta_title,$article_meta_description,$article_main_category,$article_other_category);                
                    echo json_encode(array("location"=>base_url().$article_upload_path.$fileName,"filename"=>$fileName,"add_new_article"=>$success['add_new_article']));
                }
                else
                {
                    echo json_encode(array("location"=>base_url().$article_upload_path.$fileName,"filename"=>$fileName,"add_new_article"=>0));
                }
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
            $article_meta_title = $this->input->post('article_meta_title');
            $article_meta_description = $this->input->post('article_meta_description');
            $article_main_category = $this->input->post('article_main_category');
            if($article_main_category == 0)
            {                
                $article_other_category = $this->input->post('article_other_category');
            }
            else
            {
                $article_other_category = "";
            }
            $success = $this->article_model->add_article($user_id,$article_title,$article_content,$unique_key,$article_meta_title,$article_meta_description,$article_main_category,$article_other_category);
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

        $article_meta_title = $this->input->post('article_meta_title');
        $article_meta_description = $this->input->post('article_meta_description');
        $article_main_category = $this->input->post('article_main_category');
        $edit_art_published = $this->input->post('edit_art_published');
        if($article_main_category == 0)
        {                
            $article_other_category = $this->input->post('article_other_category');
        }
        else
        {
            $article_other_category = "";
        }
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $article_data = $this->article_model->getArticleData($user_id,$unique_key);
            $id_post_article = $article_data['id_post_article'];            
            $article_slug = $article_data['article_slug'];            
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
                if($edit_art_published == 1)
                {
                    $data = array(
                        "status" => "draft",                        
                    );
                    $udapte_data = $this->common->update_data($data,'user_post','post_id', $post_id);

                    $toemail = "dshah1341@gmail.com";
                    $user_data = $this->user_model->getUserData($user_id);
                    $fullname = ucwords($user_data['first_name']." ".$user_data['last_name']);
                    $article_email = $user_data['email'];
                    $subject = "Edit Article";
                    $email_html = '';
                    $email_html .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                        <tr><td style="padding-left:20px;">Hi admin!<br><br>
                        <p style="padding-left:70px;">You have received an edited article..</p><br></td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= 'The user feedback detail follows:';
                    $email_html .= '</td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= '<b>Name</b> :'.$fullname;
                    $email_html .= '<br></td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= '<b>Email-Address</b> : '.$article_email;
                    $email_html .= '</td></tr>';
                    $email_html .= '</tr></table>';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $toemail);
                }
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
                    "article_title"             => $article_title,                    
                    "article_desc"              => $article_content,
                    "article_meta_title"        => $article_meta_title,
                    "article_meta_description"  => $article_meta_description,
                    "article_main_category"     => $article_main_category,
                    "article_other_category"    => $article_other_category,
                    "status"                    => 'publish',                    
                    "modify_date"               => date('Y-m-d h:i:s', time()),                    
                );
                if($new_post == 1)
                {
                    $article_slug = $this->common->set_slug($article_title, 'article_slug', 'post_article');
                    $data_update["article_slug"] = $article_slug;
                }
                
                $udapte_data = $this->common->update_data($data_update,'post_article','id_post_article', $id_post_article);
                $ret_arr = array("status"=>"1","message"=>"Article published successfully.","is_publish"=>1,"article_slug"=>$article_slug);

                if($new_post == 1)
                {
                    $toemail = "dshah1341@gmail.com";
                    $user_data = $this->user_model->getUserData($user_id);
                    $fullname = ucwords($user_data['first_name']." ".$user_data['last_name']);
                    $article_email = $user_data['email'];
                    $subject = "New Article";
                    $email_html = '';
                    $email_html .= '<table  width="100%" cellpadding="0" cellspacing="0" style="font-family:arial;font-size:13px;">
                        <tr><td style="padding-left:20px;">Hi admin!<br><br>
                        <p style="padding-left:70px;"> You have received a new article from a user while you were away..</p><br></td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= 'The user feedback detail follows:';
                    $email_html .= '</td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= '<b>Name</b> :'.$fullname;
                    $email_html .= '<br></td></tr>';
                    $email_html .= '<tr><td style="padding-bottom: 3px;padding-left:20px;">';
                    $email_html .= '<b>Email-Address</b> : '.$article_email;
                    $email_html .= '</td></tr>';
                    $email_html .= '</tr></table>';

                    $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $toemail);
                }
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

    public function remove_featured_img()
    {
        $unique_key = $this->input->post('unique_key');
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
            $success = $this->article_model->add_article_featured($user_id,$article_title = "",$article_content = "",$unique_key,$imageName = "");

            echo json_encode(array("add_new_article"=>$success['add_new_article'],"success"=>$success['success']));
        }
        else
        {
            echo json_encode(array("featured_img"=>"","success"=>"-1"));
        }
    }

    public function article_published($article_slug)
    {
        $userid = $this->session->userdata('aileenuser');
        // if($userid != "")
        // {
            $this->data['article_data'] = $article_data = $this->article_model->getArticleDataFromSlug($article_slug);
            // print_r($article_data);exit();
            if(empty($article_data))
            {
                redirect(base_url(),"refresh");
            }
            $this->data['user_data'] = $this->user_model->getLeftboxData($article_data['user_id']);
            $id_post_article = $article_data['id_post_article'];
            $this->data['article_media_data'] = $article_media_data = $this->article_model->getArticleMediaData($id_post_article);            
            $this->data['user_post_article'] = $user_post_article = $this->article_model->getUserPostArticle($id_post_article);
            if($user_post_article['status'] == 'draft')
            {
                redirect(base_url(),"refresh");   
            }
            $this->data['related_article_data'] = $this->article_model->get_related_article($userid,$id_post_article);

            $is_userContactInfo = $this->userprofile_model->userContactStatus($userid, $article_data['user_id']);
            $is_userFollowInfo = $this->userprofile_model->userFollowStatus($userid, $article_data['user_id']);
            $this->data['to_id'] = $article_data['user_id'];
            if (count($is_userContactInfo) != 0) {
                $this->data['contact_status'] = 1;
                $this->data['contact_value'] = $is_userContactInfo['status'];
                $this->data['contact_id'] = $is_userContactInfo['id'];
                $this->data['from_id'] = $is_userContactInfo['from_id'];
            } else {
                $this->data['contact_value'] = 'new';
                $this->data['contact_status'] = 0;
                $this->data['contact_id'] = ($is_userContactInfo['id'] != "" ? $is_userContactInfo['id'] : "''");
                $this->data['from_id'] = $is_userContactInfo['from_id'];
            }

            if (count($is_userFollowInfo) != 0) {
                $this->data['follow_status'] = 1;
                $this->data['follow_id'] = $is_userFollowInfo['id'];
                $this->data['follow_value'] = $is_userFollowInfo['status'];
            } else {
                $this->data['follow_value'] = 'new';
                $this->data['follow_id'] = ($is_userFollowInfo['id'] != "" ? $is_userFollowInfo['id'] : "''");
                $this->data['follow_status'] = 0;
            }
            /*print_r($this->data['article_data']);
            print_r($this->data['user_post_article']);
            print_r($this->data['user_data']);exit();*/
            $this->data['meta_title'] = "Article Title";
            $this->data['meta_desc'] = "Article Description";
            if($user_post_article['is_delete'] == '1')
            {
                $this->load->view('404', $this->data);
            }
            else
            {
                $this->load->view('article/article_preview', $this->data);
            }
        // }
        // else
        // {
        //     redirect(base_url(),"refresh");
        // }
    }

    public function likePost() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $this->input->post('post_id');

        $is_likepost = $this->user_post_model->is_likepost($userid, $post_id);

        if ($is_likepost['id'] != '') {
            if ($is_likepost['is_like'] == '1') {
                $data = array();
                $data['is_like'] = '0';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '0';
                    $return_array['is_oldLike'] = '1';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $return_array['post_like_data'] = $this->article_model->postLikeData($post_id);
                    /*if($userid == $postLikeData['user_id'])
                    {
                        $postLikeUsername = "You";
                    }
                    else
                    {
                        $postLikeUsername = $postLikeData['username'];
                    }
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeUsername;
                    }*/
                }
            } else {
                $data = array();
                $data['is_like'] = '1';
                $data['modify_date'] = date('Y-m-d H:i:s', time());
                $updatedata = $this->common->update_data($data, 'user_post_like', 'id', $is_likepost['id']);
                if ($updatedata) {
                    $return_array['message'] = '1';
                    $return_array['is_newLike'] = '1';
                    $return_array['is_oldLike'] = '0';
                    $return_array['likePost_count'] = $this->likePost_count($post_id);
                    $return_array['post_like_data'] = $this->article_model->postLikeData($post_id);
                    /*if($userid == $postLikeData['user_id'])
                    {
                        $postLikeUsername = "You";
                    }
                    else
                    {
                        $postLikeUsername = $postLikeData['username'];
                    }
                    if ($return_array['likePost_count'] > 1) {
                        $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                    } elseif ($return_array['likePost_count'] == 1) {
                        $return_array['post_like_data'] = $postLikeUsername;
                    }*/
                }
            }
        } else {
            $insert_data = array();
            $insert_data['user_id'] = $userid;
            $insert_data['post_id'] = $post_id;
            $insert_data['created_date'] = date('Y-m-d H:i:s', time());
            $insert_data['modify_date'] = date('Y-m-d H:i:s', time());
            $insert_data['is_like'] = '1';
            $user_post_like_id = $this->common->insert_data_getid($insert_data, 'user_post_like');
            $return_array = array();
            if ($user_post_like_id != '') {
                $return_array['message'] = '1';
                $return_array['is_newLike'] = '1';
                $return_array['is_oldLike'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $return_array['post_like_data'] = $this->article_model->postLikeData($post_id);
                /*if($userid == $postLikeData['user_id'])
                {
                    $postLikeUsername = "You";
                }
                else
                {
                    $postLikeUsername = $postLikeData['username'];
                }
                if ($return_array['likePost_count'] > 1) {
                    $return_array['post_like_data'] = $postLikeUsername . ' and ' . ($return_array['likePost_count'] - 1) . ' other';
                } elseif ($return_array['likePost_count'] == 1) {
                    $return_array['post_like_data'] = $postLikeUsername;
                }*/
            } else {
                $return_array['message'] = '0';
                $return_array['likePost_count'] = $this->likePost_count($post_id);
                $return_array['post_like_data'] = '';
            }
        }

        if($return_array['is_newLike'] == 1)
        {
            $to_id = $this->user_post_model->getPostUserId($post_id);
            if($userid != $to_id)
            {
                $contition_array = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                $likenotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($likenotification[0]['not_read'] == 2) {                
                }
                elseif($likenotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '5', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '5',
                        'not_from_id' => $userid,
                        'not_product_id'=>$post_id,
                        'not_to_id' => $to_id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '2',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;
                        $login_userdata = $this->user_model->getUserData($userid);
                        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                        if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                        }
                        else
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }

                        $email_html = '';
                        
                        if($login_userdata['user_image'] != "")
                        {
                            $login_user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
                        }
                        else
                        {
                            if($login_userdata['user_gender']  == 'M')
                            {
                                $login_user_img = base_url('assets/img/man-user.jpg');
                            }

                            if($login_userdata['user_gender']  == 'F')
                            {
                                $login_user_img = base_url('assets/img/female-user.jpg');
                            }
                        }
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="'.MAIL_TD_1.'">
                                                <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                            </td>
                                            <td style="padding:5px;">
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> liked your aticle.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' liked your post in Aileensoul.';

                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

                        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                        if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
                        {
                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
                        }
                    }
                }
            }
        }
        echo json_encode($return_array);
    }

    public function likePost_count($post_id = '') {
        $userid = $this->session->userdata('aileenuser');

        $likepost_count = $this->user_post_model->likepost_count($post_id);
        return $likepost_count;
    }

    public function load_more_comment()
    {
        $post_id = $this->input->post('post_id');
        $offset = $this->input->post('offset');
        $limit = 5;
        $userid_login = $this->session->userdata('aileenuser');
        $_post_comment_data = $this->article_model->viewAllComment($post_id,$userid_login,$limit,$offset);

        $content = "";
        if(isset($_post_comment_data) && !empty($_post_comment_data))
        {
            foreach ($_post_comment_data as $post_comment_data)
            {
                if($post_comment_data['user_image'] != "")
                {
                    $pro_img_url = USER_THUMB_UPLOAD_URL.$post_comment_data['user_image'];
                }
                else
                {
                    if($post_comment_data['user_gender'] == "M")
                    {
                        $pro_img_url = base_url('assets/img/man-user.jpg');
                    }
                    elseif($post_comment_data['user_gender'] == "F")
                    {
                        $pro_img_url = base_url('assets/img/man-user.jpg');
                    }
                    else
                    {
                        $pro_img_url = base_url('assets/img/man-user.jpg');
                    }
                }
                $content .= '<div id="comment-'.$post_comment_data['comment_id'].'" class="post-comment">
                    <div class="post-img"><a href="'.base_url($post_comment_data['user_slug']).'">';
                        $content .= '<img src="'.$pro_img_url.'"></a>
                    </div>';
                    $content .= '<div class="comment-dis">';
                        $content .= '<div class="comment-name">
                            <a href="'.base_url($post_comment_data['user_slug']).'">'.ucwords($post_comment_data['username']).'</a>
                        </div>';
                        $content .= '<div id="comment-dis-inner-'.$post_comment_data['comment_id'].'" class="comment-dis-inner">'.$post_comment_data['comment'].'
                        </div>';
                        // Edit Comment Start
                        $content .= '<div class="edit-comment" id="edit-comment-'.$post_comment_data['comment_id'].'" style="display:none;">';
                            $content .= '<div class="comment-input">
                                <div contenteditable="true" data-directive ng-model="editComment" class="editable_text" placeholder="Add a Comment ..." id="editCommentTaxBox-'.$post_comment_data['comment_id'].'" focus="setFocus" focus-me="setFocus" role="textbox" spellcheck="true">'.$post_comment_data['comment'].'</div>
                            </div>';
                            $content .= '<div class="mob-comment">
                                <button onclick="sendEditComment('.$post_comment_data['comment_id'].', '.$post_id.')"><img src="'.base_url('assets/n-images/send.png').'"></button>
                            </div>';
                            
                            $content .= '<div class="comment-submit hidden-mob">
                                <button class="btn2" onclick="sendEditComment('.$post_comment_data['comment_id'].', '.$post_id.')">Save</button>
                            </div>
                        </div>';
                        // Edit Comment End
                        $content .= '<ul class="comment-action">';
                        if($userid_login != ""){
                            $content .= '<li>';                                
                                $cmt_like_cls = "";
                                if($post_comment_data['is_userlikePostComment'] == 1)
                                {
                                    $cmt_like_cls = "like";
                                }
                                $content .= '<a href="javascript:void(0);" class="'.$cmt_like_cls.'" onclick="likePostComment('.$post_comment_data['comment_id'].', '.$post_id.')">';
                                    $content .= '<i class="fa fa-thumbs-up"></i>';
                                    $content .= '<span id="post-comment-like-'.$post_comment_data['comment_id'].'">';
                                    $content .= ($post_comment_data['postCommentLikeCount'] > 0 ? $post_comment_data['postCommentLikeCount'] : "");
                                    $content .= '</span>
                                </a>
                                </li>';
                            
                                if($post_comment_data['commented_user_id'] == $userid_login){
                                $content .= '<li id="edit-comment-li-'.$post_comment_data['comment_id'].'">
                                    <a href="javascript:void(0);" onclick="editPostComment('.$post_comment_data['comment_id'].','.$post_id.'">Edit</a>
                                </li>';
                                $content .= '<li id="cancel-comment-li-'.$post_comment_data['comment_id'].'" style="display: none;"><a href="javascript:void(0);" onclick="cancelPostComment('.$post_comment_data['comment_id'].','.$post_id.')">Cancel</a></li>';
                                }
                                if($user_post_article['user_id'] == $userid_login || $post_comment_data['commented_user_id'] == $userid_login){
                                $content .= '<li><a href="javascript:void(0);" onclick="deletePostComment('.$post_comment_data['comment_id'].','.$post_id.')">Delete</a></li>';
                                }
                            }
                            $content .= '<li><a href="javascript:void(0);">'.$post_comment_data['comment_time_string'].'</a></li>';
                        $content .= '</ul>';
                    $content .= '</div>';
                $content .= '</div>';
            }
        }        
        echo $content;
    }

    public function postCommentInsert() {
        $userid = $this->session->userdata('aileenuser');
        $post_id = $this->input->post('post_id');
        $comment = $this->input->post('comment');

        $data = array();
        $data['user_id'] = $userid;
        $data['post_id'] = $post_id;
        $data['comment'] = $comment;
        $data['created_date'] = date('Y-m-d H:i:s', time());
        $data['modify_date'] = date('Y-m-d H:i:s', time());
        $data['is_delete'] = '0';
        $postComentId = $this->common->insert_data_getid($data, 'user_post_comment');
        $return_data = array();
        if ($postComentId) {
            $return_data['message'] = '1';
            $return_data['comment_data'] = $this->user_post_model->postCommentData($post_id,$userid);
            $return_data['comment_data'][0]['is_userlikePostComment'] = '0';
            $return_data['comment_data'][0]['postCommentLikeCount'] = '';
            $return_data['comment_count'] = $this->user_post_model->postCommentCount($post_id);

            $to_id = $this->user_post_model->getPostUserId($post_id);
            if($userid != $to_id)
            {
                $contition_array = array('not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                $likenotification = $this->common->select_data_by_condition('notification', $contition_array, $data = '*', $sortby = '', $orderby = '', $limit = '', $offset = '', $join_str = array(), $groupby = '');

                if ($likenotification[0]['not_read'] == 2) {                
                }
                elseif($likenotification[0]['not_read'] == 1)
                {
                    $dataFollow = array('not_read' => '2','not_created_date' => date('Y-m-d H:i:s'));
                    $where = array('not_type' => '6', 'not_from_id' => $userid,'not_product_id'=>$post_id,'not_to_id' => $to_id, 'not_from' => '7', 'not_img' => '2');
                    $this->db->where($where);
                    $updatdata = $this->db->update('notification', $dataFollow);
                }
                else
                {
                    $dataFollow = array(
                        'not_type' => '6',
                        'not_from_id' => $userid,
                        'not_product_id'=>$post_id,
                        'not_to_id' => $to_id,
                        'not_read' => '2',                    
                        'not_from' => '7',
                        'not_img' => '2',
                        'not_created_date' => date('Y-m-d H:i:s'),
                        'not_active' => '1'
                    );
                    $insert_id = $this->common->insert_data_getid($dataFollow, 'notification');

                    if ($insert_id) {
                        $to_email_id = $this->db->select('email')->get_where('user_login', array('user_id' => $to_id))->row()->email;
                        $login_userdata = $this->user_model->getUserData($userid);
                        $postDetailData = $this->user_post_model->postDetail($post_id, $userid);
                        // print_r($postDetailData);exit;
                        if(isset($postDetailData[0]['post_file_data']) && empty($postDetailData[0]['post_file_data']))
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "image")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/photos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "video")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/videos/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "audio")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/audios/".$postDetailData[0]['post_data']['id'];
                        }
                        elseif(isset($postDetailData[0]['post_file_data']) && $postDetailData[0]['post_file_data'][0]['file_type'] == "pdf")
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/pdf/".$postDetailData[0]['post_data']['id'];
                        }
                        else
                        {
                            $url = base_url().$postDetailData[0]['user_data']['user_slug']."/post/".$postDetailData[0]['post_data']['id'];
                        }

                        if($login_userdata['user_image'] != "")
                        {
                            $login_user_img = USER_THUMB_UPLOAD_URL . $login_userdata['user_image'];
                        }
                        else
                        {
                            if($login_userdata['user_gender']  == 'M')
                            {
                                $login_user_img = base_url('assets/img/man-user.jpg');
                            }

                            if($login_userdata['user_gender']  == 'F')
                            {
                                $login_user_img = base_url('assets/img/female-user.jpg');
                            }
                        }

                        $email_html = '';
                        $email_html .= '<table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="'.MAIL_TD_1.'">
                                                <img src="' . $login_user_img . '?ver=' . time() . '" width="50" height="50" alt="' . $login_userdata['user_image'] . '">
                                            </td>
                                            <td style="padding:5px;">
                                                <p><b>'.ucwords($login_userdata['first_name']." ".$login_userdata['last_name']) . '</b> commented on your article.</p>
                                                <span style="display:block; font-size:13px; padding-top: 1px; color: #646464;">'.date('j F').' at '.date('H:i').'</span>
                                            </td>
                                            <td style="'.MAIL_TD_3.'">
                                                <p><a class="btn" href="'.$url.'">view</a></p>
                                            </td>
                                        </tr>
                                        </table>';
                        $subject = ucwords($login_userdata['first_name']." ".$login_userdata['last_name']).' commented on your post in Aileensoul.';
                        $unsubscribeData = $this->db->select('encrypt_key,user_slug,user_id,is_subscribe,user_verify')->get_where('user', array('user_id' => $to_id))->row();

                        $unsubscribe = base_url()."unsubscribe/".md5($unsubscribeData->encrypt_key)."/".md5($unsubscribeData->user_slug)."/".md5($unsubscribeData->user_id);
                        if($unsubscribeData->is_subscribe == 1)// && $unsubscribeData->user_verify == 1)
                        {
                            $send_email = $this->email_model->send_email($subject = $subject, $templ = $email_html, $to_email = $to_email_id,$unsubscribe);
                        }
                    }
                }
            }
        } else {
            $return_data['message'] = '0';
        }
        echo json_encode($return_data);
    }

    function change_category()
    {
        $user_id = $this->session->userdata('aileenuser');
        if($user_id != "")
        {
            $unique_key = $this->input->post('unique_key');
            $article_meta_description = $this->input->post('article_meta_description');
            $article_main_category = $this->input->post('article_main_category');
            if($article_main_category == 0)
            {                
                $article_other_category = $this->input->post('article_other_category');
            }
            else
            {
                $article_other_category = "";
            }
            $success = $this->article_model->change_category($user_id,$unique_key,$article_main_category,$article_other_category);
            echo json_encode($success);
        }
        else
        {
            echo json_encode(array("success"=>"-1"));
        }
    }
}