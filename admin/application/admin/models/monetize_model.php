<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monetize_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function all_post($user_id = '', $limit = '', $start = '') {

        $this->db->select("up.id,upm.user_id,up.post_for,up.created_date,up.post_id,upm.status")->from("user_post up");
        $this->db->join('user_point_mapper upm', 'upm.post_id = up.id', 'left');        
        $this->db->where('up.status', 'publish');        
        $this->db->where('up.is_delete', '0');        
        $this->db->order_by('upm.created_date', 'desc');
        if ($limit != '') {
            $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $user_post = $query->result_array();

        $result_array = array();

        foreach ($user_post as $key => $value) {
            print_r($value);
            $user_post[$key]['time_string'] = $this->common->time_elapsed_string(date('Y-m-d H:i:s', strtotime($user_post[$key]['created_date'])));
            $result_array[$key]['post_data'] = $user_post[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $result_array[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];

            $this->db->select("u.user_id, u.user_slug, u.user_gender, u.first_name, u.last_name, ui.user_image, jt.name as title_name, d.degree_name")->from("user u");
            $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
            $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
            $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
            $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
            $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
            $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
            $this->db->where('u.user_id ='.$value['user_id']);
            $query = $this->db->get();            
            $user_data = $query->row_array();
            $result_array[$key]['user_data'] = $user_data;

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.post_id,GROUP_CONCAT(DISTINCT(jt.name)) as opportunity_for,GROUP_CONCAT(DISTINCT(c.city_name)) as location,uo.opportunity,it.industry_name as field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_opportunity uo, ailee_job_title jt, ailee_cities c, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uo.field', 'left');
                $this->db->where('uo.id', $value['post_id']);
                $this->db->where('FIND_IN_SET(jt.title_id, uo.`opportunity_for`) !=', 0);
                $this->db->where('FIND_IN_SET(c.city_id, uo.`location`) !=', 0);
                $sql = "IF(uo.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uo.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uo.opportunity_for', 'uo.location','uo.hashtag');
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $opportunity_data['opportunity'] = nl2br($this->common->make_links($opportunity_data['opportunity']));
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag, usp.sim_title, usp.simslug")->from("user_simple_post usp, ailee_hashtag ht");
                $this->db->where('usp.id', $value['post_id']);
                $sql = "IF(usp.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, usp.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('usp.hashtag');
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $simple_data['description'] = $this->common->make_links(nl2br($simple_data['description']));//nl2br($this->common->make_links($simple_data['description']));
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.*,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category,it.industry_name as field,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) as hashtag")->from("user_ask_question uaq, ailee_tags t, ailee_hashtag ht");
                $this->db->join('industry_type it', 'it.industry_id = uaq.field', 'left');
                $this->db->where('uaq.id', $value['post_id']);
                //$this->db->where('FIND_IN_SET(t.id, uaq.`category`) !=', 0);
                $this->db->where("IF(uaq.category != '', FIND_IN_SET(t.id, uaq.category) != 0 , '1')");
                $sql = "IF(uaq.hashtag IS NULL,1=1,FIND_IN_SET(ht.id, uaq.hashtag) != 0)";
                $this->db->where($sql);
                $this->db->group_by('uaq.category','uaq.hashtag');
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $question_data['description'] = nl2br($this->common->make_links($question_data['description']));
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'profile_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $profile_update = $query->row_array();
                $result_array[$key]['profile_update'] = $profile_update;
            } elseif ($value['post_for'] == 'cover_update') {
                $this->db->select("upu.*")->from("user_profile_update upu");
                $this->db->where('upu.id', $value['post_id']);
                $query = $this->db->get();
                $cover_update = $query->row_array();
                $result_array[$key]['cover_update'] = $cover_update;
            }
            elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.*,IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') as hashtag")->from('post_article pa, ailee_hashtag ht');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $this->db->where('pa.status', 'publish');                
                $sql = "IF(pa.hashtag != '', FIND_IN_SET(ht.id, pa.hashtag) != '0' , 1=1)";
                $this->db->where($sql);
                $this->db->group_by('pa.hashtag');
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;

            }
            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $result_array[$key]['post_file_data'] = $post_file_data;
        }
        return $result_array;
    }
    
}