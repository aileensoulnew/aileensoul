<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Article_model extends CI_Model {

    function add_article($user_id,$article_title = "",$article_content = "",$unique_key = "")
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
                // "article_featured_image"    =>  "",
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
            );
            if($artist_data['status'] == 'status')
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
                // "article_featured_image"    =>  "",
                "unique_key"                =>  $unique_key,
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

    function add_article_media($user_id,$article_title = "",$article_content = "",$unique_key = "",$fileName)
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
                "article_featured_image"    =>  "",
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
            );
            if($artist_data['status'] == 'status')
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
                // "article_featured_image"    =>  "",
                "unique_key"                =>  $unique_key,
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
        $this->db->where('status', 'publish');
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
        $this->db->select('*')->from('user_post');
        $this->db->where('post_for', 'article');
        $this->db->where('post_id', $post_id);
        $query = $this->db->get();
        $result_array = $query->row_array();
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
                "article_title"             => $article_title,
                "article_desc"              => $article_content,
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
}
