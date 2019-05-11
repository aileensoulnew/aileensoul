<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'es/vendor/autoload.php';

class Searchelastic extends MY_Controller {
    private $elasticclient = null;
    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->model('user_post_model');
        $this->load->model('common');
        $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
    }

    public function index() {
        $this->insert_people_data();
        $this->insert_business_data();
    }

    public function mapping_people()
    {
        $params = [
            'index' => 'aileensoul_search_people',
            'body' => [
                'mappings' => [
                    'aileensoul_search_people' => [
                        'properties' => [
                            'id' => [
                                'type' => 'integer'                                     
                            ],
                            'first_name' => [
                                'type' => 'string'
                            ],
                            'last_name' => [
                                'type' => 'string'
                            ],
                            'user_gender' => [
                                'type' => 'string'
                            ],
                            'fullname' => [
                                'type' => 'string'
                            ],
                            'user_slug' => [
                                'type' => 'string'
                            ],
                            'user_image' => [
                                'type' => 'string'
                            ],
                            'title_name' => [
                                'type' => 'string'
                            ],
                            'degree_name' => [
                                'type' => 'string'
                            ],
                            'profession_field' => [
                                'type' => 'string'
                            ],
                            'student_field' => [
                                'type' => 'string'
                            ],
                            'profession_city' => [
                                'type' => 'string'
                            ],
                            'student_city' => [
                                'type' => 'string'
                            ],
                            'university_name' => [
                                'type' => 'string'
                            ],
                        ]
                    ]
                ]
            ]
        ];
        $this->elasticclient->indices()->create($params);       
    }

    public function add_people_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_people',
            'type'  => 'aileensoul_search_people',
            'id'=> 1,
            'body'  => ['first_name' => 'Pratik', 'last_name' => 'Suthar','user_gender' => 'M', 'fullname' => 'Pratik Suthar', 'user_slug' => 'pratik-suthar', 'user_image' => 'pratik-suthar', 'title_name' => 'pratik-suthar', 'degree_name' => 'pratik-suthar', 'profession_field' => 'pratik-suthar', 'student_field' => 'pratik-suthar', 'profession_city' => 'pratik-suthar', 'student_city' => 'pratik-suthar', 'university_name' => 'pratik-suthar',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_people_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) AS fullname,u.user_slug,ui.user_image,jt.name AS title_name,d.degree_name,IF(up.field = 0,up.other_field,it1.industry_name) as profession_field,IF(us.interested_fields = 0,us.other_interested_fields,it2.industry_name) as student_field,up.city AS profession_city,us.city AS student_city,un.university_name FROM ailee_user u
            LEFT JOIN ailee_user_info ui ON ui.user_id = u.user_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id
            LEFT JOIN ailee_user_profession up ON up.user_id = u.user_id
            LEFT JOIN ailee_job_title jt ON jt.title_id = up.designation
            LEFT JOIN ailee_industry_type it1 ON it1.industry_id = up.field
            LEFT JOIN ailee_user_student us ON us.user_id = u.user_id
            LEFT JOIN ailee_degree d ON d.degree_id = us.current_study
            LEFT JOIN ailee_industry_type it2 ON it2.industry_id = us.interested_fields
            LEFT JOIN ailee_university un ON un.university_name = us.university_name
            WHERE  ul.status = '1' AND ul.is_delete = '0'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_people',
                    '_type' => 'aileensoul_search_people',
                    '_id' => $row['user_id'],
                ),
            );
            $params['body'][] = ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'], 'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'], ];            
            // print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_people_data($user_id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) AS fullname,u.user_slug,ui.user_image,jt.name AS title_name,d.degree_name,IF(up.field = 0,up.other_field,it1.industry_name) as profession_field,IF(us.interested_fields = 0,us.other_interested_fields,it2.industry_name) as student_field,up.city AS profession_city,us.city AS student_city,un.university_name FROM ailee_user u
            LEFT JOIN ailee_user_info ui ON ui.user_id = u.user_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id
            LEFT JOIN ailee_user_profession up ON up.user_id = u.user_id
            LEFT JOIN ailee_job_title jt ON jt.title_id = up.designation
            LEFT JOIN ailee_industry_type it1 ON it1.industry_id = up.field
            LEFT JOIN ailee_user_student us ON us.user_id = u.user_id
            LEFT JOIN ailee_degree d ON d.degree_id = us.current_study
            LEFT JOIN ailee_industry_type it2 ON it2.industry_id = us.interested_fields
            LEFT JOIN ailee_university un ON un.university_name = us.university_name
                WHERE ul.status = '1' AND ul.is_delete = '0' AND u.user_id= $user_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function update_people_data($user_id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) AS fullname,u.user_slug,ui.user_image,jt.name AS title_name,d.degree_name,IF(up.field = 0,up.other_field,it1.industry_name) as profession_field,IF(us.interested_fields = 0,us.other_interested_fields,it2.industry_name) as student_field,up.city AS profession_city,us.city AS student_city,un.university_name FROM ailee_user u
            LEFT JOIN ailee_user_info ui ON ui.user_id = u.user_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = u.user_id
            LEFT JOIN ailee_user_profession up ON up.user_id = u.user_id
            LEFT JOIN ailee_job_title jt ON jt.title_id = up.designation
            LEFT JOIN ailee_industry_type it1 ON it1.industry_id = up.field
            LEFT JOIN ailee_user_student us ON us.user_id = u.user_id
            LEFT JOIN ailee_degree d ON d.degree_id = us.current_study
            LEFT JOIN ailee_industry_type it2 ON it2.industry_id = us.interested_fields
            LEFT JOIN ailee_university un ON un.university_name = us.university_name
                WHERE ul.status = '1' AND ul.is_delete = '0' AND u.user_id= $user_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'],]];
        }

        $responses = $client->update($params);
        return true;
    }

    public function delete_people_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function add_business_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_business',
            'type'  => 'aileensoul_search_business',
            'id'=> 1,
            'body'  => [
                    'company_name' => 'Pratik', 
                    'country' => '101',
                    'state' => '12', 
                    'city' => '783',
                    'pincode' => '380015', 
                    'address' => 'ttest test estste', 
                    'contact_person' => 'pratik suthar', 
                    'contact_mobile' => '9876543210', 
                    'contact_email' => 'pratik.aileensoul@gmail.com', 
                    'contact_website' => 'http://www.pratik-suthar.com', 
                    'business_type' => '7', 
                    'industriyal' => '82', 
                    'details' => 'Test set test est est',
                    'addmore' => 'pratik-suthar',
                    'user_id' => '16024',
                    'status' => '1',
                    'is_deleted' => '0',
                    'created_date' => '2017-03-14 00:00:00',
                    'modified_date' => '2019-04-26 02:26:12',
                    'business_step' => '4',
                    'business_user_image' => '',
                    'profile_background' => '',
                    'profile_background_main' => '',
                    'other_business_type' => '',
                    'other_industrial' => '',
                    'city_name' => 'Ahmedabad',
                    'state_name' => 'Gujarat',
                    'country_name' => 'India',
                    'other_city' => '',
                    'business_slug' => 'pratik-suthar',
                    'industry_name' => 'IT sector',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_business_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name, bp.other_city, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) AS business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) AS industry_name FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON bp.city = ct.city_id
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0'";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_business',
                    '_type' => 'aileensoul_search_business',
                    '_id' => $row['business_profile_id'],
                ),
            );
            $params['body'][] = ['company_name' => $row['company_name'],'country' => $row['country'],'state' => $row['state'], 'city' => $row['city'],'pincode' => $row['pincode'],'address' => $row['address'],'contact_person' => $row['contact_person'], 'contact_mobile' => $row['contact_mobile'], 'contact_email' => $row['contact_email'],'contact_website' => $row['contact_website'],'business_type' => $row['business_type'],'industriyal' => $row['industriyal'],'details' => $row['details'],'addmore' => $row['addmore'],'user_id' => $row['user_id'],'status' => $row['status'],'is_deleted' => $row['is_deleted'],'created_date' => $row['created_date'],'modified_date' => $row['modified_date'],'business_step' => $row['business_step'],'business_user_image' => $row['business_user_image'],'profile_background' => $row['profile_background'],'profile_background_main' => $row['profile_background_main'],'other_business_type' => $row['other_business_type'],'other_industrial' => $row['other_industrial'],'city_name' => $row['city_name'],'state_name' => $row['state_name'],'country_name' => $row['country_name'],'other_city' => $row['other_city'],'business_slug' => $row['business_slug'],'industry_name' => $row['industry_name'], ];
            // print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_business_data($business_id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name, bp.other_city, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) AS business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) AS industry_name FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON bp.city = ct.city_id
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_profile_id = $business_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $row['business_profile_id'], 'body' => ['company_name' => $row['company_name'],'country' => $row['country'],'state' => $row['state'], 'city' => $row['city'],'pincode' => $row['pincode'],'address' => $row['address'],'contact_person' => $row['contact_person'], 'contact_mobile' => $row['contact_mobile'], 'contact_email' => $row['contact_email'],'contact_website' => $row['contact_website'],'business_type' => $row['business_type'],'industriyal' => $row['industriyal'],'details' => $row['details'],'addmore' => $row['addmore'],'user_id' => $row['user_id'],'status' => $row['status'],'is_deleted' => $row['is_deleted'],'created_date' => $row['created_date'],'modified_date' => $row['modified_date'],'business_step' => $row['business_step'],'business_user_image' => $row['business_user_image'],'profile_background' => $row['profile_background'],'profile_background_main' => $row['profile_background_main'],'other_business_type' => $row['other_business_type'],'other_industrial' => $row['other_industrial'],'city_name' => $row['city_name'],'state_name' => $row['state_name'],'country_name' => $row['country_name'],'other_city' => $row['other_city'],'business_slug' => $row['business_slug'],'industry_name' => $row['industry_name'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function update_business_data($business_id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name, bp.other_city, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) AS business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) AS industry_name FROM ailee_business_profile bp
            LEFT JOIN ailee_industry_type it ON it.industry_id = bp.industriyal
            LEFT JOIN ailee_cities ct ON bp.city = ct.city_id
            LEFT JOIN ailee_states st ON bp.state = st.state_id
            LEFT JOIN ailee_countries cr ON cr.country_id = bp.country 
            WHERE bp.status = '1' AND bp.is_deleted = '0' AND bp.business_profile_id = $business_id";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
           $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $row['business_profile_id'], 'body' => ['company_name' => $row['company_name'],'country' => $row['country'],'state' => $row['state'], 'city' => $row['city'],'pincode' => $row['pincode'],'address' => $row['address'],'contact_person' => $row['contact_person'], 'contact_mobile' => $row['contact_mobile'], 'contact_email' => $row['contact_email'],'contact_website' => $row['contact_website'],'business_type' => $row['business_type'],'industriyal' => $row['industriyal'],'details' => $row['details'],'addmore' => $row['addmore'],'user_id' => $row['user_id'],'status' => $row['status'],'is_deleted' => $row['is_deleted'],'created_date' => $row['created_date'],'modified_date' => $row['modified_date'],'business_step' => $row['business_step'],'business_user_image' => $row['business_user_image'],'profile_background' => $row['profile_background'],'profile_background_main' => $row['profile_background_main'],'other_business_type' => $row['other_business_type'],'other_industrial' => $row['other_industrial'],'city_name' => $row['city_name'],'state_name' => $row['state_name'],'country_name' => $row['country_name'],'other_city' => $row['other_city'],'business_slug' => $row['business_slug'],'industry_name' => $row['industry_name'],]];
        }

        $responses = $client->update($params);
        return true;
    }

    public function delete_business_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function add_opportunity_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_opportunity',
            'type'  => 'aileensoul_search_opportunity',
            'id'=> 1,
            'body'  => [
                    'user_id' => '100', 
                    'post_for' => 'opportunity',
                    'created_date' => '2017-03-14 00:00:00',
                    'post_id' => '1', 
                    'user_type' => '1', 
                    'opportunity_for' => 'IT sector',
                    'opportunity_for_id' => '82', 
                    'location' => 'Ahmedabad', 
                    'location_id' => '783', 
                    'opportunity' => 'Test Test', 
                    'field' => 'IT Software - Web Designing/ Web Developing', 
                    'other_field' => '', 
                    'opptitle' => 'Sr php Developer', 
                    'oppslug' => 'sr-php-developer', 
                    'company_name' => '',
                    'hashtag' => '',
                    'hashtag_id' => '',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_opportunity_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,GROUP_CONCAT(DISTINCT(jt.name)) AS opportunity_for,opportunity_for AS opportunity_for_id,GROUP_CONCAT(DISTINCT(c.city_name)) AS location,location AS location_id,uo.opportunity,it.industry_name AS field, uo.other_field, uo.opptitle ,uo.oppslug, uo.company_name,IF(uo.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag,uo.hashtag AS hashtag_id
            FROM ailee_user_opportunity uo
            LEFT JOIN ailee_user_post up ON up.id = uo.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = uo.field
            LEFT OUTER JOIN ailee_job_title jt ON FIND_IN_SET(jt.title_id, uo.opportunity_for) > 0
            LEFT OUTER JOIN ailee_cities c ON FIND_IN_SET(c.city_id, uo.location) > 0
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, uo.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' 
            GROUP BY up.id,uo.opportunity_for, uo.location,uo.hashtag ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_opportunity',
                    '_type' => 'aileensoul_search_opportunity',
                    '_id' => $row['id'],
                ),
            );

            $params['body'][] = ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'opportunity_for' => $row['opportunity_for'], 'opportunity_for_id' => $row['opportunity_for_id'], 'location' => $row['location'], 'location_id' => $row['location_id'], 'opportunity' => $row['opportunity'], 'field' => $row['field'], 'other_field' => $row['other_field'], 'opptitle' => $row['opptitle'], 'oppslug' => $row['oppslug'], 'company_name' => $row['company_name'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'],];// print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_opportunity_data($id_post)
    {
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

    public function update_opportunity_data($id_post)
    {
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

        $responses = $client->update($params);
        return true;
    }

    public function delete_opportunity_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function add_post_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_post',
            'type'  => 'aileensoul_search_post',
            'id'=> 1,
            'body'  => [
                    'user_id' => '100',
                    'post_for' => 'simple',
                    'created_date' => '2017-03-14 00:00:00',
                    'post_id' => '1',
                    'user_type' => '1',
                    'description' => 'IT sector',
                    'hashtag' => '82',
                    'hashtag_id' => '',
                    'sim_title' => 'Sr php Developer',
                    'simslug' => 'sr-php-developer',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_post_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag, usp.hashtag AS hashtag_id,usp.sim_title, usp.simslug
            FROM ailee_user_simple_post usp
            LEFT JOIN ailee_user_post up ON up.id = usp.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, usp.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' 
            GROUP BY up.id,usp.hashtag ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_post',
                    '_type' => 'aileensoul_search_post',
                    '_id' => $row['id'],
                ),
            );

            $params['body'][] = ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'description' => $row['description'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'], 'sim_title' => $row['sim_title'], 'simslug' => $row['simslug'],];// print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_post_data($id_post)
    {
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

    public function update_post_data($id_post)
    {
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

        $responses = $client->update($params);
        return true;
    }

    public function delete_post_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function search()
    {
        $search_people = $this->search_people();
        $search_business = $this->search_business();
        $search_opp = $this->search_opportunity();

        // print_r($search_business);exit();
        echo json_encode(array_merge($search_people,$search_business,$search_opp));
    }

    public function search_people()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_people', 
            'type'  => 'aileensoul_search_people',
            'from'  => 0,
            'size'  => 10,
            'body'  => ['query' => ['query_string' => 
                                        [
                                            'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                            'query' => '*'.$searchKeyword.'*',
                                            'analyzer' => 'standard'
                                        ],
                                    ]
                            /*[
                            'bool' => [
                                'should' => [
                                    'multi_match' => [
                                        'query' => $searchKeyword,
                                        'type' => 'cross_fields',
                                        'fields' => ['first_name', 'last_name', 'title_name', 'degree_name'],
                                    ],
                                ]
                            ]
                        ]*/
                    ],
        ];

        /*[
            ['wildcard' => 
                ['first_name' => "*".$searchKeyword."*"],
            ],
            ['wildcard' => 
                ['last_name' => "*".$searchKeyword."*"],
            ],
        ]*/

        $query = $client->search($params);        
        // print_r($query);exit();
        /*print_r($query['hits']['hits']);exit();
        $hits = sizeof($query['hits']['hits']);
        $hit = $query['hits']['hits'];
        $result['searchfound'] = $hits;
        while ($i < $hits) {
            $result['result'][$i] = $query['hits']['hits'][$i]['_source'];
            $i++;
        }*/
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['people_count'] = $search_data['total']['value'];
        $searchProfileData = $search_data['hits'];
        $searchProfileDataMain = array();

        foreach ($searchProfileData as $key => $value) {
            // print_r($value);exit();
            if($userid != $value['_id'])
            {                
                $searchProfileDataMain[$key] = $value['_source'];
                $searchProfileDataMain[$key]['user_id'] = $value['_id'];                
            }
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['_id']);
            if ($is_userBasicInfo) {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['_source']['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['profession_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileData[$key]['city'] = $this->data_model->getCityName($value['_source']['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['student_city']);
                $searchProfileData[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileData[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileData[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileData[$key]['contact_not_read'] = $contact_detail['not_read'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_from =' . $value['_id'] . ' AND follow_to =' . $userid . ') OR (follow_to =' . $value['_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileData[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileData[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileData[$key]['follow_status'] = $follow_detail['status'];
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['profile'] = $searchProfileDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_business()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_business', 
            'type'  => 'aileensoul_search_business',
            'from'  => 0,
            'size'  => 1,
            'body'  => ['query' => ['query_string' => 
                                ['default_field'=>'company_name','query' => '*'.$searchKeyword.'*','analyzer' => 'standard'],
                            ]
                    ],
        ];

        /*[
            ['wildcard' => 
                ['first_name' => "*".$searchKeyword."*"],
            ],
            ['wildcard' => 
                ['last_name' => "*".$searchKeyword."*"],
            ],
        ]*/

        $query = $client->search($params);        
        // print_r($query);exit();
        /*print_r($query['hits']['hits']);exit();
        $hits = sizeof($query['hits']['hits']);
        $hit = $query['hits']['hits'];
        $result['searchfound'] = $hits;
        while ($i < $hits) {
            $result['result'][$i] = $query['hits']['hits'][$i]['_source'];
            $i++;
        }*/
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['business_count'] = $search_data['total']['value'];
        $searchBusinessData = $search_data['hits'];
        $searchBusinessDataMain = array();

        foreach ($searchBusinessData as $key => $value) {
            // print_r($value);exit();
            if($userid != $value['_id'])
            {                
                $searchBusinessDataMain[$key] = $value['_source'];
                $searchBusinessDataMain[$key]['user_id'] = $value['_id'];                
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['business_data'] = $searchBusinessDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_opportunity()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'from'  => 0,
            'size'  => 1,
            'body'  => ['query' => ['query_string' => 
                                        [
                                            'fields'=>['opptitle','opportunity_for','location'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],
                                ]
                        ],
        ];

        /*[
            ['wildcard' => 
                ['first_name' => "*".$searchKeyword."*"],
            ],
            ['wildcard' => 
                ['last_name' => "*".$searchKeyword."*"],
            ],
        ]*/

        $query = $client->search($params);        
        // print_r($query);exit();
        /*print_r($query['hits']['hits']);exit();
        $hits = sizeof($query['hits']['hits']);
        $hit = $query['hits']['hits'];
        $result['searchfound'] = $hits;
        while ($i < $hits) {
            $result['result'][$i] = $query['hits']['hits'][$i]['_source'];
            $i++;
        }*/
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['opp_count'] = $search_data['total']['value'];
        $searchOpportunityData = $search_data['hits'];
        $searchOpportunityDataMain = array();        

        foreach ($searchOpportunityData as $key => $value) {
            $searchOpportunityDataMain[$key] = $value['_source'];
            $searchOpportunityDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchOpportunityDataMain[$key]['created_date']);
            $searchOpportunityDataMain[$key]['post_data'] = $searchOpportunityDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchOpportunityDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchOpportunityDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchOpportunityDataMain[$key]['opportunity_data']['company_name'] = $searchOpportunityDataMain[$key]['company_name'];
            $searchOpportunityDataMain[$key]['opportunity_data']['field'] = $searchOpportunityDataMain[$key]['field'];
            $searchOpportunityDataMain[$key]['opportunity_data']['hashtag'] = $searchOpportunityDataMain[$key]['hashtag'];
            $searchOpportunityDataMain[$key]['opportunity_data']['location'] = $searchOpportunityDataMain[$key]['location'];
            $searchOpportunityDataMain[$key]['opportunity_data']['opportunity'] = $searchOpportunityDataMain[$key]['opportunity'];
            $searchOpportunityDataMain[$key]['opportunity_data']['opportunity_for'] = $searchOpportunityDataMain[$key]['opportunity_for'];
            $searchOpportunityDataMain[$key]['opportunity_data']['oppslug'] = $searchOpportunityDataMain[$key]['oppslug'];
            $searchOpportunityDataMain[$key]['opportunity_data']['opptitle'] = $searchOpportunityDataMain[$key]['opptitle'];
            $searchOpportunityDataMain[$key]['opportunity_data']['other_field'] = $searchOpportunityDataMain[$key]['other_field'];
            $searchOpportunityDataMain[$key]['opportunity_data']['post_id'] = $searchOpportunityDataMain[$key]['post_id'];

            if($searchOpportunityDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchOpportunityDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchOpportunityDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchOpportunityDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchOpportunityDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchOpportunityDataMain[$key]['post_file_data'] = $post_file_data;

            $searchOpportunityDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchOpportunityDataMain[$key]['post_like_count'] = $post_like_count;
            $searchOpportunityDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchOpportunityDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchOpportunityDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchOpportunityDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchOpportunityDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchOpportunityDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchOpportunityDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchOpportunityDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchOpportunityDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['post'] = $searchOpportunityDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }    
}