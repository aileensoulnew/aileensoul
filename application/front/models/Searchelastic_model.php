<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'es/vendor/autoload.php';

class Searchelastic_model extends CI_Model {

    private $elasticclient = null;
    
    public function __construct() {
        $this->db->reconnect();
    }
    
    public function add_edit_single_people($user_id)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        
        $client = $this->elasticclient;
        $stmt = "SELECT u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) AS fullname,u.user_slug,ui.user_image,jt.name AS title_name,d.degree_name,IF(up.field = 0,up.other_field,it1.industry_name) as profession_field,IF(us.interested_fields = 0,us.other_interested_fields,it2.industry_name) as student_field,up.city AS profession_city,us.city AS student_city,un.university_name,IF(up.city,ct1.city_name,ct2.city_name) AS city_name FROM ailee_user u
            LEFT JOIN ailee_user_info ui ON ui.user_id = u.user_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id
            LEFT JOIN ailee_user_profession up ON up.user_id = u.user_id
            LEFT JOIN ailee_job_title jt ON jt.title_id = up.designation
            LEFT JOIN ailee_industry_type it1 ON it1.industry_id = up.field
            LEFT JOIN ailee_user_student us ON us.user_id = u.user_id
            LEFT JOIN ailee_degree d ON d.degree_id = us.current_study
            LEFT JOIN ailee_industry_type it2 ON it2.industry_id = us.interested_fields
            LEFT JOIN ailee_university un ON un.university_name = us.university_name
            LEFT JOIN ailee_cities ct1 ON ct1.city_id = up.city
            LEFT JOIN ailee_cities ct2 ON ct2.city_id = us.city
            WHERE ul.status = '1' AND ul.is_delete = '0' AND u.user_id= $user_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'], 'city_name' => $row['city_name'],]];
        }
        $responses = $client->index($params);
        return $responses;
    }

    public function add_edit_single_business($user_id)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        $client = $this->elasticclient;
        $stmt = "SELECT bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name, bp.other_city, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) AS business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) AS industry_name FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON bp.city = ct.city_id
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.user_id = $user_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $row['business_profile_id'], 'body' => ['company_name' => $row['company_name'],'country' => $row['country'],'state' => $row['state'], 'city' => $row['city'],'pincode' => $row['pincode'],'address' => $row['address'],'contact_person' => $row['contact_person'], 'contact_mobile' => $row['contact_mobile'], 'contact_email' => $row['contact_email'],'contact_website' => $row['contact_website'],'business_type' => $row['business_type'],'industriyal' => $row['industriyal'],'details' => $row['details'],'addmore' => $row['addmore'],'user_id' => $row['user_id'],'status' => $row['status'],'is_deleted' => $row['is_deleted'],'created_date' => $row['created_date'],'modified_date' => $row['modified_date'],'business_step' => $row['business_step'],'business_user_image' => $row['business_user_image'],'profile_background' => $row['profile_background'],'profile_background_main' => $row['profile_background_main'],'other_business_type' => $row['other_business_type'],'other_industrial' => $row['other_industrial'],'city_name' => $row['city_name'],'state_name' => $row['state_name'],'country_name' => $row['country_name'],'other_city' => $row['other_city'],'business_slug' => $row['business_slug'],'industry_name' => $row['industry_name'],]];
        }
        $responses = $client->index($params);
        return $responses;
    }

    public function add_edit_single_opportunity($id_post)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        $client = $this->elasticclient;
        $stmt = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,GROUP_CONCAT(DISTINCT(jt.name)) AS opportunity_for,opportunity_for AS opportunity_for_id,GROUP_CONCAT(DISTINCT(c.city_name)) AS location,location AS location_id,uo.opportunity,it.industry_name AS field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag,uo.hashtag AS hashtag_id
            FROM ailee_user_opportunity uo
            LEFT JOIN ailee_user_post up ON up.id = uo.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = uo.field
            LEFT OUTER JOIN ailee_job_title jt ON FIND_IN_SET(jt.title_id, uo.opportunity_for) > 0
            LEFT OUTER JOIN ailee_cities c ON FIND_IN_SET(c.city_id, uo.location) > 0
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, uo.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id = $id_post GROUP BY up.id,uo.opportunity_for, uo.location,uo.hashtag ORDER BY id DESC";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'opportunity_for' => $row['opportunity_for'], 'opportunity_for_id' => $row['opportunity_for_id'], 'location' => $row['location'], 'location_id' => $row['location_id'], 'opportunity' => $row['opportunity'], 'field' => $row['field'], 'other_field' => $row['other_field'], 'opptitle' => $row['opptitle'], 'oppslug' => $row['oppslug'], 'company_name' => $row['company_name'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function add_edit_single_post($id_post)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        $client = $this->elasticclient;
        $stmt = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag, usp.hashtag AS hashtag_id,usp.sim_title, usp.simslug
            FROM ailee_user_simple_post usp
            LEFT JOIN ailee_user_post up ON up.id = usp.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, usp.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id = $id_post GROUP BY up.id,usp.hashtag ORDER BY id DESC";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'description' => $row['description'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'], 'sim_title' => $row['sim_title'], 'simslug' => $row['simslug'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function add_edit_single_question($id_post)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        $client = $this->elasticclient;
        $stmt = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category, uaq.description, it.industry_name AS field, uaq.others_field, uaq.is_anonymously ,uaq.link, uaq.modify_date, uaq.question,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag,uaq.hashtag AS hashtag_id
            FROM ailee_user_ask_question uaq
            LEFT JOIN ailee_user_post up ON up.id = uaq.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = uaq.field
            LEFT OUTER JOIN ailee_tags t ON FIND_IN_SET(t.id, uaq.category) > 0            
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, uaq.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id = $id_post
            GROUP BY up.id,uaq.category,uaq.hashtag ORDER BY id DESC";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'category' => $row['category'],'description' => $row['description'],'field' => $row['field'],'hashtag' => $row['hashtag'],'is_anonymously' => $row['is_anonymously'],'link' => $row['link'],'modify_date' => $row['modify_date'],'others_field' => $row['others_field'],'question' => $row['question'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function add_edit_single_article($id_post)
    {
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            $hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
        $client = $this->elasticclient;
        $stmt = "SELECT up.id, up.user_id, up.post_for, up.created_date, up.post_id, up.user_type, pa.article_desc, pa.article_main_category, pa.article_other_category, pa.article_featured_image, pa.article_meta_description, pa.article_meta_title, pa.article_slug, pa.article_sub_category, pa.article_title, pa.hashtag as hashtag_id , pa.id_post_article, IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') AS hashtag,it.industry_name AS field
            FROM ailee_post_article pa
            LEFT JOIN ailee_user_post up ON up.post_id = pa.id_post_article
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = pa.article_main_category
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, pa.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.post_for = 'article' AND up.status = 'publish' AND up.is_delete = '0' AND up.id = $id_post
            GROUP BY up.id,pa.hashtag ORDER BY id DESC
            ";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_article', 'type' => 'aileensoul_search_article', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'article_desc' => $row['article_desc'],'article_main_category' => $row['article_main_category'],'article_other_category' => $row['article_other_category'],'article_featured_image' => $row['article_featured_image'],'article_meta_description' => $row['article_meta_description'],'article_meta_title' => $row['article_meta_title'],'article_slug' => $row['article_slug'],'article_sub_category' => $row['article_sub_category'],'article_title' => $row['article_title'],'hashtag_id' => $row['hashtag_id'],'id_post_article' => $row['id_post_article'],'hashtag' => $row['hashtag'],'field' => $row['field'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }
}