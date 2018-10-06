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
            $data = array(
                "article_title"             => $article_title,
                "article_desc"              => $article_content,
                "article_featured_image"    =>  "",
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
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
                "article_title"             => $article_title,
                "article_desc"              => $article_content,
                "article_featured_image"    =>  "",
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
                "article_title"             => $article_title,
                "article_desc"              => $article_content,
                "article_featured_image"    =>  "",
                "modify_date"               =>  date('Y-m-d h:i:s', time()),
            );
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
                "article_featured_image"    =>  "",
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

    function findJobTitle($search_keyword = '',$flag = 0) {
        $this->db->select('jt.title_id')->from('job_title jt');
        if($flag == 1){            
            $this->db->like('LOWER(jt.name)', strtolower($search_keyword));
        }
        else
        {            
            $this->db->where('jt.name', $search_keyword);
        }
        $this->db->where('jt.status', 'publish');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function searchJobTitle($search_keyword = '') {
        $this->db->select('jt.title_id,jt.name')->from('job_title jt');
        if ($search_keyword != '') {
            $this->db->like('jt.name', $search_keyword);
        }
        $this->db->where('jt.status', 'publish');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function searchJobTitleStart($search_keyword = '') {
        $this->db->select('jt.title_id,jt.name')->from('job_title jt');
        if ($search_keyword != '') {
            $this->db->where("jt.name LIKE '".$search_keyword."%'");
        }
        $this->db->where('jt.status', 'publish');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function getSearchJobTitleStart($search_keyword = '') {
        $this->db->select('jt.title_id as id,jt.name as value')->from('job_title jt');
        if ($search_keyword != '') {
            $this->db->where("jt.name LIKE '".$search_keyword."%'");
        }
        $this->db->where('jt.status', 'publish');
        $query = $this->db->get();
        // echo $this->db->last_query();exit;
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function cityList() {
        $this->db->select('c.city_id,c.city_name')->from('cities c');
        $this->db->where('c.status', '1');
        $this->db->where('c.state_id !=', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function getCityName($id) {
        $this->db->select('c.city_name')->from('cities c');
        $this->db->where('c.status', '1');
        $this->db->where('c.city_id', $id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['city_name'];
    }

    function findCityList($search_keyword = '') {
        $this->db->select('c.city_id')->from('cities c');
        $this->db->where('c.city_name', $search_keyword);
        $this->db->where('c.status', '1');
        $this->db->where('c.state_id !=', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function searchCityList($search_keyword = '') {
        $this->db->select('c.city_id,c.city_name')->from('cities c');
        if ($search_keyword != '') {
            $this->db->like('c.city_name', $search_keyword);
        }
        $this->db->where('c.status', '1');
        $this->db->where('c.state_id !=', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function getStateIdByCityId($id = '') {
        $this->db->select('c.state_id')->from('cities c');
        $this->db->where('c.status', '1');
        $this->db->where('c.city_id', $id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['state_id'];
    }

    function getCountryByStateId($id = '') {
        $this->db->select('c.country_name')->from('countries c');
        $this->db->join('states s','s.country_id = c.country_id','left');
        $this->db->where('c.status', '1');
        $this->db->where('s.state_id', $id);
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array['country_name'];
    }

    function universityList() {
        $this->db->select('u.university_id,u.university_name')->from('university u');
        $this->db->where('u.status', '1');
        $this->db->where('u.is_delete', '0');
        $this->db->where('u.is_other', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function findUniversityList($search_keyword = '') {
        $this->db->select('u.university_id')->from('university u');
        $this->db->where('u.university_name', $search_keyword);
        $this->db->where('u.status', '1');
        $this->db->where('u.is_delete', '0');
        $this->db->where('u.is_other', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function searchUniversityList($search_keyword = '') {
        $this->db->select('u.university_id,u.university_name')->from('university u');
        if ($search_keyword != '') {
            $this->db->like('u.university_name', $search_keyword);
        }
        $this->db->where('u.status', '1');
        $this->db->where('u.is_delete', '0');
        $this->db->where('u.is_other', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function searchUniversityListNew($search_keyword = '') {
        $this->db->select('u.university_name as value')->from('university u');
        if ($search_keyword != '') {
            $this->db->like('u.university_name', $search_keyword);
        }
        $this->db->where('u.status', '1');
        $this->db->where('u.is_delete', '0');
        $this->db->where('u.is_other', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function degreeList() {
        $this->db->select('d.degree_id,d.degree_name')->from('degree d');
        $this->db->where('d.status', '1');
        $this->db->where('d.is_delete', '0');
        $this->db->where('d.is_other', '0');
        $query = $this->db->get();
        $result_array = $query->result_array();
        return $result_array;
    }

    function findDegreeList($search_keyword = '') {
        $this->db->select('d.degree_id')->from('degree d');
        $this->db->where('d.degree_name', $search_keyword);
        $this->db->where('d.status', '1');
        $this->db->where('d.is_delete', '0');
        $this->db->where('d.is_other', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

    function searchDegreeListNew($search_keyword = '') {
        $this->db->select('d.degree_name as value')->from('degree d');
        if ($search_keyword != '') {
            $this->db->like('d.degree_name', $search_keyword);
        }
        $this->db->where('d.status', '1');
        $this->db->where('d.is_delete', '0');
        $this->db->where('d.is_other', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }
    function searchDegreeList($search_keyword = '') {
        $this->db->select('d.degree_id,d.degree_name')->from('degree d');
        if ($search_keyword != '') {
            $this->db->like('d.degree_name', $search_keyword);
        }
        $this->db->where('d.status', '1');
        $this->db->where('d.is_delete', '0');
        $this->db->where('d.is_other', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function searchQueList($search_keyword = '') {
        $this->db->select('q.id,q.question')->from('user_ask_question q');
        if ($search_keyword != '') {
            $this->db->where("q.question LIKE '%$search_keyword%'");
        }
        $this->db->join('user_post up', 'up.id = q.post_id', 'left');
        $this->db->where('up.status', 'publish');
        $this->db->where('up.is_delete', '0');
        $query = $this->db->get();
        if ($search_keyword != '') {
            $result_array = $query->result_array();
        } else {
            $result_array = array();
        }
        return $result_array;
    }

    function findCategory($search_keyword = '') {
        $this->db->select('t.id')->from('tags t');
        $this->db->where('t.name', $search_keyword);
        $this->db->where('t.status', 'publish');
        $this->db->where('t.is_delete', '0');
        $query = $this->db->get();
        $result_array = $query->row_array();
        return $result_array;
    }

}
