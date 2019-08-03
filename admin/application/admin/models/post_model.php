<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Post_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function get_all_post($offset = '',$limit = '')
    {
        $sql = "SELECT * FROM ailee_user_post WHERE post_for != 'profile_update' AND post_for != 'cover_update' ORDER BY created_date DESC LIMIT $offset,$limit";
        $result_array =  $this->db->query($sql)->result_array();
        foreach ($result_array as $key => $value) {            
            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,ul.email")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');                
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email as email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;

            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.opptitle,uo.oppslug,")->from("user_opportunity uo");
                $this->db->where('uo.id', $value['post_id']);                
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.sim_title, usp.simslug")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.id,uaq.question")->from("user_ask_question uaq");
                $this->db->where('uaq.id', $value['post_id']);
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.article_title,pa.article_slug")->from('post_article pa');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("shared_post_slug")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $result_array[$key]['share_data'] = $share_data;
            }
        }
        return $result_array;
    }

    public function get_all_post_total()
    {
        $sql = "SELECT COUNT(*) as total_row FROM ailee_user_post WHERE post_for != 'profile_update' AND post_for != 'cover_update'";
        $total_row =  $this->db->query($sql)->row_array();
        return $total_row['total_row'];
    }

    public function get_all_post_search($offset = '',$limit = '',$search_keyword = '')
    {
        $sql_ser_people = "(LOWER(u.first_name) Like '%".strtolower($search_keyword)."%' OR LOWER(u.last_name) Like '%".strtolower($search_keyword)."%' OR LOWER(CONCAT(u.first_name,' ',u.last_name)) LIKE '%".strtolower($search_keyword)."%' OR LOWER(CONCAT(u.last_name,' ',u.first_name)) LIKE '%".strtolower($search_keyword)."%')";

        $sql_ser_bus = "(LOWER(bp.company_name) Like '%".strtolower($search_keyword)."%')";

        $sql = "SELECT up.* FROM ailee_user_post up LEFT JOIN ailee_user u ON u.user_id = up.user_id LEFT JOIN ailee_business_profile bp ON bp.user_id = up.user_id WHERE IF(up.user_type = '1',".$sql_ser_people.",".$sql_ser_bus.") AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC LIMIT $offset,$limit";

        $result_array =  $this->db->query($sql)->result_array();
        foreach ($result_array as $key => $value) {            
            if($value['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,ui.user_image,ui.profile_background,ul.email")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');                
                $this->db->where('u.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email as email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $value['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $result_array[$key]['user_data'] = $user_data;

            }

            if ($value['post_for'] == 'opportunity') {
                $this->db->select("uo.opptitle,uo.oppslug,")->from("user_opportunity uo");
                $this->db->where('uo.id', $value['post_id']);                
                $query = $this->db->get();
                $opportunity_data = $query->row_array();
                $result_array[$key]['opportunity_data'] = $opportunity_data;
            } elseif ($value['post_for'] == 'simple') {
                $this->db->select("usp.sim_title, usp.simslug")->from("user_simple_post usp");
                $this->db->where('usp.id', $value['post_id']);
                $query = $this->db->get();
                $simple_data = $query->row_array();
                $result_array[$key]['simple_data'] = $simple_data;
            } elseif ($value['post_for'] == 'question') {
                $this->db->select("uaq.id,uaq.question")->from("user_ask_question uaq");
                $this->db->where('uaq.id', $value['post_id']);
                $query = $this->db->get();                
                $question_data = $query->row_array();
                $result_array[$key]['question_data'] = $question_data;
            } elseif ($value['post_for'] == 'article') {
                $this->db->select("pa.article_title,pa.article_slug")->from('post_article pa');
                $this->db->where('pa.id_post_article', $value['post_id']);
                $query = $this->db->get();                
                $article_data = $query->row_array();                
                $result_array[$key]['article_data'] = $article_data;
            } elseif($value['post_for'] == 'share'){
                $this->db->select("shared_post_slug")->from("user_post_share");
                $this->db->where('id_user_post_share', $value['post_id']);                
                $query = $this->db->get();
                $share_data = $query->row_array();
                $result_array[$key]['share_data'] = $share_data;
            }
        }
        return $result_array;
    }

    public function get_all_post_search_total($search_keyword = '')
    {
        $sql_ser_people = "LOWER(u.first_name) Like '%".strtolower($search_keyword)."%' OR LOWER(u.last_name) Like '%".strtolower($search_keyword)."%' OR LOWER(CONCAT(u.first_name,' ',u.last_name)) LIKE '%".strtolower($search_keyword)."%' OR LOWER(CONCAT(u.last_name,' ',u.first_name)) LIKE '%".strtolower($search_keyword)."%'";

        $sql_ser_bus = "LOWER(bp.company_name) Like '%".strtolower($search_keyword)."%'";

        $sql = "SELECT COUNT(*) as total_row FROM ailee_user_post up LEFT JOIN ailee_user u ON u.user_id = up.user_id LEFT JOIN ailee_business_profile bp ON bp.user_id = up.user_id WHERE IF(up.user_type = '1',".$sql_ser_people.",".$sql_ser_bus.") AND up.post_for != 'profile_update' AND up.post_for != 'cover_update' ORDER BY up.created_date DESC";
        $result_array =  $this->db->query($sql)->row_array();        
        return $result_array['total_row'];
    }
}
