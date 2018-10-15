<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article_model extends CI_Model {

    function add_article($user_id,$article_title = "",$article_content = "",$unique_key = "",$article_meta_title = "",$article_meta_description = "",$article_main_category = "",$article_other_category = "")
    {
        $add_new_article = 0;
        $this->db->select('*')->from('post_article');
        $this->db->where('user_id', $user_id);   
        $this->db->where('unique_key', $unique_key);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $artist_data = $query->row_array();
            $data = array(
                "article_desc"              => $article_content,
                "article_meta_title"        => $article_meta_title,
                "article_meta_description"  => $article_meta_description,
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );
            if($artist_data['status'] == 'draft')
            {
                $data['article_title'] = $article_title;
            }
            $this->db->where('user_id', $user_id);   
            $this->db->where('unique_key', $unique_key);
            $udapte_data = $this->db->update('post_article',$data);
            if($udapte_data)
            {
                $ret_arr = array("success"=>1,"add_new_article"=>$add_new_article);                
            }
            else
            {
                $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);
            }
        }
        else
        {
            $data = array(
                "user_id"                   => $user_id,
                "article_title"             => $article_title,
                "article_desc"              => $article_content,
                "article_meta_title"        => $article_meta_title,
                "article_meta_description"  => $article_meta_description,
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "unique_key"                => $unique_key,
                "status"                    => "draft",
                "created_date"              => date('Y-m-d h:i:s', time()),
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );
            $article_id = $this->common->insert_data_getid($data,'post_article');
            if($article_id > 0)
            {
                $add_new_article = 1;                
                $ret_arr = array("success"=>$article_id,"add_new_article"=>$add_new_article);
            }
            else
            {
                $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);                
            }
        }
        return $ret_arr;
    }

    function add_article_media($user_id,$article_title = "",$article_content = "",$unique_key = "",$fileName,$article_meta_title = "",$article_meta_description = "",$article_main_category = "",$article_other_category = "")
    {
        $this->db->select('*')->from('post_article');
        $this->db->where('user_id', $user_id);   
        $this->db->where('unique_key', $unique_key);
        $query = $this->db->get();
        $add_new_article = 0;
        if($query->num_rows() > 0)
        {
            $artist_data = $query->row_array();
            $data = array(            
                "article_desc"              => $article_content,
                "article_meta_title"        => $article_meta_title,
                "article_meta_description"  => $article_meta_description,
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
            );
            if($artist_data['status'] == 'draft')
            {
                $data['article_title'] = $article_title;
            }
            $this->db->where('user_id', $user_id);   
            $this->db->where('unique_key', $unique_key);
            $udapte_data = $this->db->update('post_article',$data);
            $article_id = $artist_data['id_post_article'];
        }
        else
        {
            $data = array(
                "user_id"                   => $user_id,
                "article_title"             => $article_title,
                "article_desc"              => $article_content,                
                "unique_key"                => $unique_key,
                "article_meta_title"        => $article_meta_title,
                "article_meta_description"  => $article_meta_description,
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "status"                    => "draft",
                "created_date"              => date('Y-m-d h:i:s', time()),
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );
            $article_id = $this->common->insert_data_getid($data,'post_article');
            $add_new_article = 1;
        }

        $data = array(
            "post_article_id"           => $article_id,
            "image_url"                 => $fileName,
            "created_date"              => date('Y-m-d h:i:s', time()),
        );
        $article_media_id = $this->common->insert_data_getid($data,'post_article_media');
        if($article_media_id > 0)
        {
            $ret_arr = array("success"=>$article_media_id,"add_new_article"=>$add_new_article);            
        }
        else
        {
            $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);            
        }
        return $ret_arr;
    }

    function getArticleData($user_id,$unique_key) {
        $this->db->select('*')->from('post_article');
        $this->db->where('user_id', $user_id);   
        $this->db->where('unique_key', $unique_key);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getArticleDataFromSlug($article_slug = "") {
        $this->db->select('*')->from('post_article');        
        $this->db->where('article_slug', $article_slug);
        // $this->db->where('status', 'publish');
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        $result_array = $query->row_array();
        return $result_array;
    }

    function getArticleMediaData($post_article_id = '') {
        $this->db->select('*')->from('post_article_media');
        $this->db->where('post_article_id', $post_article_id);
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getUserPostArticle($post_id) {
        $user_id = $this->session->userdata('aileenuser');
        $this->db->select('*')->from('user_post');
        $this->db->where('post_for', 'article');
        // $this->db->where('is_delete', '0');
        $this->db->where('post_id', $post_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        if(empty($result_array))
        {
            return $result_array;
        }

        $result_array['post_like_data'] = $this->postLikeData($result_array['id']);
        $post_like_count = $this->user_post_model->likepost_count($result_array['id']);
        $result_array['post_like_count'] = $post_like_count;
        $result_array['is_userlikePost'] = $this->user_post_model->is_userlikePost($user_id, $result_array['id']);
        /*if($user_id == $post_like_data['user_id'])
        {
            $postLikeUsername = "You";
        }
        else
        {
            $postLikeUsername = $post_like_data['username'];
        }
        if ($post_like_count > 1) {
            $result_array['post_like_data'] = $postLikeUsername . ' and ' . ($post_like_count - 1) . ' other';
        } elseif ($post_like_count == 1) {
            $result_array['post_like_data'] = $postLikeUsername;
        }*/
        $result_array['post_comment_count'] = $this->user_post_model->postCommentCount($result_array['id']);
        $result_array['post_comment_data'] = $postCommentData = $this->viewAllComment($result_array['id'],$user_id,5);        

        foreach ($postCommentData as $key1 => $value1) {
            $result_array['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($user_id, $value1['comment_id']);
            $result_array['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
        }
        // print_r($result_array);exit();
        return $result_array;
    }

    function add_article_featured($user_id,$article_title = "",$article_content = "",$unique_key = "",$fileName)
    {
        $this->db->select('*')->from('post_article');
        $this->db->where('user_id', $user_id);   
        $this->db->where('unique_key', $unique_key);
        $query = $this->db->get();
        $add_new_article = 0;
        if($query->num_rows() > 0)
        {
            $artist_data = $query->row_array();
            $data = array(
                // "article_title"             => $article_title,
                // "article_desc"              => $article_content,
                "article_featured_image"    =>  $fileName,
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
            );
            $this->db->where('user_id', $user_id);   
            $this->db->where('unique_key', $unique_key);
            $udapte_data = $this->db->update('post_article',$data);
            if($udapte_data)
                $article_id = $artist_data['id_post_article'];
            else
                $article_id = 0;
            $article_id = $artist_data['id_post_article'];
        }
        else
        {
            $data = array(
                "user_id"                   => $user_id,
                // "article_title"             => $article_title,
                // "article_desc"              => $article_content,
                "article_featured_image"    => $fileName,
                "unique_key"                => $unique_key,
                "status"                    => "draft",
                "created_date"              => date('Y-m-d h:i:s', time()),
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );
            $article_id = $this->common->insert_data_getid($data,'post_article');
            $add_new_article = 1;
        }

        if($article_id > 0)
        {
            $ret_arr = array("success"=>$article_id,"add_new_article"=>$add_new_article);            
        }
        else
        {
            $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);            
        }
        return $ret_arr;
    }

    public function postLikeData($post_id = '') {
        $this->db->select("CONCAT(u.first_name,' ',u.last_name) as fullname,u.user_id,u.user_slug,u.user_gender,ui.user_image")->from("user_post_like upl");
        $this->db->join('user u', 'u.user_id = upl.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upl.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upl.user_id', 'left');
        $this->db->where('upl.post_id', $post_id);
        $this->db->where('upl.is_like', '1');
        $this->db->where('ul.status', '1');
        $this->db->order_by('upl.id', 'desc');        
        $query = $this->db->get();
        return $post_like_data = $query->result_array();
    }

    public function viewAllComment($post_id = '', $user_id = '', $limit = '', $page = '') {
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;
        $this->db->select("u.user_slug,u.user_gender,upc.user_id as commented_user_id,CONCAT(u.first_name,' ',u.last_name) as username, ui.user_image,upc.id as comment_id,upc.comment,upc.created_date")->from("user_post_comment upc");//UNIX_TIMESTAMP(STR_TO_DATE(upc.created_date, '%Y-%m-%d %H:%i:%s')) as created_date
        $this->db->join('user u', 'u.user_id = upc.user_id', 'left');
        $this->db->join('user_login ul', 'ul.user_id = upc.user_id', 'left');
        $this->db->join('user_info ui', 'ui.user_id = upc.user_id', 'left');
        $this->db->where('upc.post_id', $post_id);
        $this->db->where('ul.status', '1');
        $this->db->where('upc.is_delete', '0');
        $this->db->order_by('upc.id', 'desc');
        if ($limit != '') {
            $this->db->limit($limit,$start);
        }
        $query = $this->db->get();
        $post_comment_data = $query->result_array();
        foreach ($post_comment_data as $key => $value) {
            $post_comment_data[$key]['comment_time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($post_comment_data[$key]['created_date'])));
            $post_comment_data[$key]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($user_id, $value['comment_id']);
            $post_comment_data[$key]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value['comment_id']);
        }
        return $post_comment_data;
    }

    public function get_related_article($user_id,$post_id)
    {
        $this->db->select("a.id_post_article,a.article_title,a.article_featured_image,a.article_slug")->from("post_article a");
        $this->db->join('user_post up', 'up.post_id = a.id_post_article', 'left');
        $this->db->where('up.user_id', $user_id);
        $this->db->where('up.post_id !=', $post_id);
        $this->db->where('up.status', 'publish');
        $this->db->where('up.post_for', 'article');
        $this->db->where('up.is_delete', '0');
        $this->db->order_by('a.id_post_article', 'desc');
        $this->db->limit(3);
        $query = $this->db->get();
        // echo $this->db->last_query();exit();
        $related_article_data = $query->result_array();
        return $related_article_data;
    }

    public function change_category($user_id,$unique_key,$article_main_category = "",$article_other_category = "")
    {
        $add_new_article = 0;
        $this->db->select('*')->from('post_article');
        $this->db->where('user_id', $user_id);   
        $this->db->where('unique_key', $unique_key);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $artist_data = $query->row_array();
            $data = array(
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );            
            $this->db->where('user_id', $user_id);   
            $this->db->where('unique_key', $unique_key);
            $udapte_data = $this->db->update('post_article',$data);
            if($udapte_data)
            {
                $ret_arr = array("success"=>1,"add_new_article"=>$add_new_article);                
            }
            else
            {
                $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);
            }
        }
        else
        {
            $data = array(
                "user_id"                   => $user_id,
                "article_main_category"     => $article_main_category,
                "article_other_category"    => $article_other_category,
                "unique_key"                => $unique_key,
                "status"                    => "draft",
                "created_date"              => date('Y-m-d h:i:s', time()),
                "modify_date"               => date('Y-m-d h:i:s', time()),
            );
            $article_id = $this->common->insert_data_getid($data,'post_article');
            if($article_id > 0)
            {
                $add_new_article = 1;                
                $ret_arr = array("success"=>$article_id,"add_new_article"=>$add_new_article);
            }
            else
            {
                $ret_arr = array("success"=>0,"add_new_article"=>$add_new_article);                
            }
        }
        return $ret_arr;
    }
}