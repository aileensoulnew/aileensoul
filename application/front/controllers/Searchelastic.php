<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require 'es/vendor/autoload.php';

class Searchelastic extends MY_Controller {
    private $elasticclient = null;
    public function __construct() {
        parent::__construct();
        $this->load->model('searchelastic_model');
        $this->load->model('user_model');
        $this->load->model('data_model');
        $this->load->model('user_post_model');
        $this->load->model('userprofile_model');
        $this->load->model('common');
        if ($_SERVER['HTTP_HOST'] == "aileensoul.localhost") {
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
        }
        else
        {
            /*$hosts = [
                '10.139.36.226:9200',//'139.59.36.139:9200',// IP + Port
                '10.139.36.226'//'139.59.36.139',// Just IP          
            ];*/
            $hosts = [
                'https://monitor.aileensoul.com:443'
            ];
            $this->elasticclient = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        }
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
                            'city_name' => [
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
            'body'  => ['first_name' => 'Pratik', 'last_name' => 'Suthar','user_gender' => 'M', 'fullname' => 'Pratik Suthar', 'user_slug' => 'pratik-suthar', 'user_image' => 'pratik-suthar', 'title_name' => 'pratik-suthar', 'degree_name' => 'pratik-suthar', 'profession_field' => 'pratik-suthar', 'student_field' => 'pratik-suthar', 'profession_city' => 'pratik-suthar', 'student_city' => 'pratik-suthar', 'university_name' => 'pratik-suthar', 'city_name' => 'pratik-suthar',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_people_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT u.user_id,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) AS fullname,u.user_slug,ui.user_image,jt.name AS title_name,d.degree_name,IF(up.field = 0,up.other_field,it1.industry_name) as profession_field,IF(us.interested_fields = 0,us.other_interested_fields,it2.industry_name) as student_field,up.city AS profession_city,us.city AS student_city,un.university_name,IF(up.city,ct1.city_name,ct2.city_name) AS city_name FROM ailee_user u
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
            $params['body'][] = ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'], 'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'], 'city_name' => $row['city_name'],];            
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
        /*$client = $this->elasticclient;
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
        // print_r($responses);exit();
        return $responses;*/

        $user_id = $this->input->post('user_id');
        $new_people = $this->searchelastic_model->add_edit_single_people($user_id);
        json_encode($new_people);
    }

    public function update_people_data($user_id)
    {
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

        $responses = $client->update($params);
        return true;
    }

    public function delete_people_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $id];
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
        /*$client = $this->elasticclient;
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
        $responses = $client->index($params);*/

        $business_id = $this->input->post('business_id');
        $new_business = $this->searchelastic_model->add_edit_single_business($business_id);
        json_encode($new_business);

        // print_r($responses);exit();
        // return $responses;
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

    public function insert_one_opportunity_data()
    {
        /*$client = $this->elasticclient;
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
        return $responses;*/

        $id_post = $this->input->post('id_post');
        $new_opportunity = $this->searchelastic_model->add_edit_single_opportunity($id_post);
        json_encode($new_opportunity);
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

    public function insert_one_post_data()
    {
        /*$client = $this->elasticclient;
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
        return $responses;*/

        $id_post = $this->input->post('id_post');
        $new_post = $this->searchelastic_model->add_edit_single_post($id_post);
        json_encode($new_post);
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

    public function add_question_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_question',
            'type'  => 'aileensoul_search_question',
            'id'=> 1,
            'body'  => [
                    'user_id' => '100', 
                    'post_for' => 'question',
                    'created_date' => '2019-04-13 17:44:26',
                    'post_id' => '1', 
                    'user_type' => '1', 
                    'category' => '',
                    'description' => 'Test ', 
                    'field' => 'IT sector',
                    'hashtag' => '',
                    'is_anonymously' => '0', 
                    'link' => '', 
                    'modify_date' => '',                     
                    'others_field' => '', 
                    'question' => 'Sr php Developer',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_question_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category, uaq.description, it.industry_name AS field, uaq.others_field, uaq.is_anonymously ,uaq.link, uaq.modify_date, uaq.question,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag,uaq.hashtag AS hashtag_id
            FROM ailee_user_ask_question uaq
            LEFT JOIN ailee_user_post up ON up.id = uaq.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = uaq.field
            LEFT OUTER JOIN ailee_tags t ON FIND_IN_SET(t.id, uaq.category) > 0            
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, uaq.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' 
            GROUP BY up.id,uaq.category,uaq.hashtag ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_question',
                    '_type' => 'aileensoul_search_question',
                    '_id' => $row['id'],
                ),
            );

            $params['body'][] = ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'category' => $row['category'],'description' => $row['description'],'field' => $row['field'],'hashtag' => $row['hashtag'],'is_anonymously' => $row['is_anonymously'],'link' => $row['link'],'modify_date' => $row['modify_date'],'others_field' => $row['others_field'],'question' => $row['question'],];
                // print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_question_data($id_post)
    {
        /*$client = $this->elasticclient;
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
        return $responses;*/

        $id_post = $this->input->post('id_post');
        $new_question = $this->searchelastic_model->add_edit_single_question($id_post);
        json_encode($new_question);
    }

    public function update_question_data($id_post)
    {
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

        $responses = $client->update($params);
        return true;
    }

    public function delete_question_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function add_article_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul_search_article',
            'type'  => 'aileensoul_search_article',
            'id'=> 1,
            'body'  => [
                    'user_id' => '', 
                    'post_for' => '',
                    'created_date' => '',
                    'post_id' => '', 
                    'user_type' => '', 
                    'article_desc' => '',
                    'article_main_category' => '', 
                    'article_other_category' => '', 
                    'article_featured_image' => '', 
                    'article_meta_description' => '',
                    'article_meta_title' => '',
                    'article_slug' => '', 
                    'article_sub_category' => '', 
                    'article_title' => '',
                    'hashtag' => '', 
                    'id_post_article' => '', 
                    'field' => '',],
        ];
        $response = $client->index($params);
        print_r($response);
    }

    public function insert_article_data()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $sql = "SELECT up.id, up.user_id, up.post_for, up.created_date, up.post_id, up.user_type, pa.article_desc, pa.article_main_category, pa.article_other_category, pa.article_featured_image, pa.article_meta_description, pa.article_meta_title, pa.article_slug, pa.article_sub_category, pa.article_title, pa.hashtag as hashtag_id , pa.id_post_article, IF(pa.hashtag != '',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #')),'') AS hashtag,it.industry_name AS field
            FROM ailee_post_article pa
            LEFT JOIN ailee_user_post up ON up.post_id = pa.id_post_article
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = pa.article_main_category
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, pa.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.post_for = 'article' AND up.status = 'publish' AND up.is_delete = '0' 
            GROUP BY up.id,pa.hashtag ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_article',
                    '_type' => 'aileensoul_search_article',
                    '_id' => $row['id'],
                ),
            );

            $params['body'][] = ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'article_desc' => $row['article_desc'],'article_main_category' => $row['article_main_category'],'article_other_category' => $row['article_other_category'],'article_featured_image' => $row['article_featured_image'],'article_meta_description' => $row['article_meta_description'],'article_meta_title' => $row['article_meta_title'],'article_slug' => $row['article_slug'],'article_sub_category' => $row['article_sub_category'],'article_title' => $row['article_title'],'hashtag_id' => $row['hashtag_id'],'id_post_article' => $row['id_post_article'],'hashtag' => $row['hashtag'],'field' => $row['field'],];
            // print_r($params);exit();
        }
        echo "<pre>";
        print_r($params);
        $responses = $client->bulk($params);
        print_r($responses);exit();
        return true;
    }

    public function insert_one_article_data()
    {
        /*$client = $this->elasticclient;
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
        return $responses;*/

        $id_post = $this->input->post('id_post');
        $new_article = $this->searchelastic_model->add_edit_single_article($id_post);
        json_encode($new_article);
    }

    public function update_article_data($id_post)
    {
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

        $responses = $client->update($params);
        return true;
    }

    public function delete_article_data($id = 0)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul_search_article', 'type' => 'aileensoul_search_article', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function search()
    {
        $search_people = $this->search_people();
        $search_business = $this->search_business();
        $search_opp = $this->search_opportunity();
        $search_post = $this->search_post();
        $search_question = $this->search_question();
        $search_article = $this->search_article();

        // print_r($search_opp);
        // print_r($search_post);exit();
        echo json_encode(array_merge($search_people,$search_business,$search_opp,$search_post,$search_question,$search_article));
    }

    public function search_people()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        $search_city = $this->input->post('search_city');
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        if($search_city != undefined && $search_city != '')
        {
            $search_city = json_decode($search_city);
        }

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_people', 
            'type'  => 'aileensoul_search_people',
            'from'  => 0,
            'size'  => 5,
            'body'  => [
                            'query' =>
                            [    
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'id' => $userid
                                            ]
                                        ]
                                    ],//must not end
                                    /*'filter' =>
                                    [
                                        'term' =>
                                        [
                                            'profession_city' => '783',
                                            // ['profession_city' => '3683'],
                                        ],
                                    ]//Filter end*/
                                    /*"should" => [
                                        [
                                            "match_phrase"=>
                                            [
                                                "profession_city"=> "3683"
                                            ]
                                        ],
                                        [
                                            "match_phrase"=>
                                            [
                                                "profession_city" => "783"
                                            ]
                                        ],                                         
                                    ],*/
                                ]//bool end                                
                            ]//query end                            
                        ],//body end
        ];
        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['city_name'] = $value->city_name;
            }
        }
        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                'fields'=>array('profession_field.keyword','student_field.keyword'),
                'query' => $search_field,
            );            
        }
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {
                $params['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                    'fields'=>array('degree_name','title_name'),
                    'query' => $value->name,
                );
            }
        }
        // print_r($params['body']['query']['bool']);exit();
        

        $query = $client->search($params);        
        // print_r($query);exit();
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['people_count'] = $search_data['total'];
        $searchProfileData = $search_data['hits'];
        if($search_data['total'] < 1)
        {        
            $params = array();
            $params = [
                'index' => 'aileensoul_search_people', 
                'type'  => 'aileensoul_search_people',
                'from'  => 0,
                'size'  => 5,
                'body'  => [
                            'query' =>
                            [    
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'id' => $userid
                                            ]
                                        ]
                                    ],//must not end                                    
                                ]//bool end                                
                            ]//query end                            
                        ],//body end
            ];
            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['city_name'] = $value->city_name;
                }
            }
            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                    'fields'=>array('profession_field.keyword','student_field.keyword'),
                    'query' => $search_field,
                );            
            }
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {
                    $params['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                        'fields'=>array('degree_name','title_name'),
                        'query' => "*".$value->name."*",
                    );
                }
            }
            // print_r($params);exit();
            $query = $client->search($params);

            $search_data = $query['hits'];
            $searchData['people_count'] = $search_data['total'];
            $searchProfileData = $search_data['hits'];
        }
        $searchProfileDataMain = array();

        foreach ($searchProfileData as $key => $value) {
            $searchProfileDataMain[$key] = $value['_source'];
            $searchProfileDataMain[$key]['user_id'] = $value['_id'];                
        
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['_id']);
            if ($is_userBasicInfo) {
                $searchProfileDataMain[$key]['city'] = $this->data_model->getCityName($value['_source']['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['profession_city']);
                $searchProfileDataMain[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileDataMain[$key]['city'] = $this->data_model->getCityName($value['_source']['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['student_city']);
                $searchProfileDataMain[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('id,from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileDataMain[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileDataMain[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileDataMain[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileDataMain[$key]['contact_not_read'] = $contact_detail['not_read'];
            $searchProfileDataMain[$key]['contact_id'] = $contact_detail['id'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_from =' . $value['_id'] . ' AND follow_to =' . $userid . ') OR (follow_to =' . $value['_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileDataMain[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileDataMain[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileDataMain[$key]['follow_status'] = $follow_detail['status'];
            
        }
        
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
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['company_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        $query = $client->search($params);        
        // print_r($query);exit();
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['business_count'] = $search_data['total'];
        $searchBusinessData = $search_data['hits'];
        $searchBusinessDataMain = array();

        foreach ($searchBusinessData as $key => $value) {            
            $searchBusinessDataMain[$key] = $value['_source'];
            $searchBusinessDataMain[$key]['user_id'] = $value['_id'];
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
        $user_id = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        $search_city = $this->input->post('search_city');
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        if($search_city != undefined && $search_city != '')
        {
            $search_city = json_decode($search_city);
        }

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['opptitle','opportunity_for','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $user_id
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['location'] = $value->city_name;
            }
        }
        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
        }
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['opportunity_for'] = $value->name;
            }   
        }

        $query = $client->search($params);                

        $searchData = array();
        $search_data = $query['hits'];
        $searchData['opp_count'] = $search_data['total'];
        $searchOpportunityData = $search_data['hits'];

        if($search_data['total'] < 1)
        {        
            $params = array();
            $params = [
                'index' => 'aileensoul_search_opportunity', 
                'type'  => 'aileensoul_search_opportunity',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['opptitle','opportunity_for','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $user_id
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['location'] = $value->city_name;
                }
            }
            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
            }
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['opportunity_for'] = $value->name;
                }   
            }
            
            // print_r($params);exit();
            $query = $client->search($params);

            $search_data = $query['hits'];
            $searchData['opp_count'] = $search_data['total'];
            $searchOpportunityData = $search_data['hits'];
        }
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
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,ui.profile_background ,jt.name as title_name,d.degree_name")->from("user u");
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
                $follower_count = $this->common->getFollowerCount($searchOpportunityDataMain[$key]['user_id'])[0];
                $searchOpportunityDataMain[$key]['user_data']['follower_count'] = $this->common->change_number_long_format_to_short((int)$follower_count['total']);

                $contact_count = $this->common->getContactCount($searchOpportunityDataMain[$key]['user_id'])[0];
                $searchOpportunityDataMain[$key]['user_data']['contact_count'] = $this->common->change_number_long_format_to_short((int)$contact_count['total']);

                $post_count = $this->common->get_post_count($searchOpportunityDataMain[$key]['user_id']);
                $searchOpportunityDataMain[$key]['user_data']['post_count'] = $this->common->change_number_long_format_to_short((int)$post_count);

                if($user_id != '')
                {                    
                    $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_to =' . $searchOpportunityDataMain[$key]['user_id'] . ' AND follow_from =' . $user_id . ') AND follow_type = "2"')->get()->row_array();
                    $searchOpportunityDataMain[$key]['user_data']['follow_status'] = $follow_detail['status'];

                    $is_userContactInfo= $this->userprofile_model->userContactStatus($user_id, $searchOpportunityDataMain[$key]['user_id']);
                    if(isset($is_userContactInfo) && !empty($is_userContactInfo))
                    {
                        $searchOpportunityDataMain[$key]['user_data']['contact_status'] = 1;
                        $searchOpportunityDataMain[$key]['user_data']['contact_value'] = $is_userContactInfo['status'];
                        $searchOpportunityDataMain[$key]['user_data']['contact_id'] = $is_userContactInfo['id'];
                    }
                    else
                    {
                        $searchOpportunityDataMain[$key]['user_data']['contact_status'] = 0;
                        $searchOpportunityDataMain[$key]['user_data']['contact_value'] = 'new';
                        $searchOpportunityDataMain[$key]['user_data']['contact_id'] = $is_userContactInfo['id'];   
                    }
                }
                else
                {
                    $result_array[$key]['user_data']['follow_status'] = '';
                    $result_array[$key]['user_data']['contact_status'] = '';
                    $result_array[$key]['user_data']['contact_value'] = '';
                    $result_array[$key]['user_data']['contact_id'] = '';
                }
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, cr.country_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchOpportunityDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchOpportunityDataMain[$key]['user_data'] = $user_data;
                $searchOpportunityDataMain[$key]['user_data']['follower_count'] = '';
                $searchOpportunityDataMain[$key]['user_data']['contact_count'] = '';
                $searchOpportunityDataMain[$key]['user_data']['post_count'] = '';
                if($user_id != '')
                {
                    $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_to =' . $searchOpportunityDataMain[$key]['user_id'] . ' AND follow_from =' . $user_id . ') AND follow_type = "2" ')->get()->row_array();
                    $searchOpportunityDataMain[$key]['user_data']['follow_status'] = $follow_detail['status'];
                }
                else
                {
                    $searchOpportunityDataMain[$key]['user_data']['follow_status'] = '';
                }
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
            $searchOpportunityDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($user_id, $value['_id']);
            $searchOpportunityDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($user_id, $value['_id']);

            $searchOpportunityDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchOpportunityDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchOpportunityDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchOpportunityDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchOpportunityDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$user_id);

            if($user_id != $value['user_id'])
            {
                $searchOpportunityDataMain[$key]['mutual_friend'] = $this->common->mutual_friend($user_id,$value['user_id']);
            }
            else
            {
                $searchOpportunityDataMain[$key]['mutual_friend'] = array();
            }

            /*foreach ($postCommentData as $key1 => $value1) {
                $searchOpportunityDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($user_id, $value1['comment_id']);
                $searchOpportunityDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }*/
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['opp_post'] = $searchOpportunityDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_post()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');        
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_post', 
            'type'  => 'aileensoul_search_post',
            'from'  => 0,
            'size'  => 10,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['sim_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        /*if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['sim_title'] = $value->name;
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }*/

        $query = $client->search($params);        
        // print_r($query);exit();
       
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['simple_count'] = $search_data['total'];
        $searchSimpleData = $search_data['hits'];

        if($search_data['total'] < 1)
        {        
            $params = array();
            $params = [
                'index' => 'aileensoul_search_post', 
                'type'  => 'aileensoul_search_post',
                'from'  => 0,
                'size'  => 10,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['sim_title','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            /*if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['sim_title'] = $value->name;
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->name;
                }   
            }*/
            
            // print_r($params);exit();
            $query = $client->search($params);

            $search_data = $query['hits'];
            $searchData['simple_count'] = $search_data['total'];
            $searchSimpleData = $search_data['hits'];            
        }
        $searchSimpleDataMain = array();        

        foreach ($searchSimpleData as $key => $value) {
            $searchSimpleDataMain[$key] = $value['_source'];
            $searchSimpleDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchSimpleDataMain[$key]['created_date']);
            $searchSimpleDataMain[$key]['post_data'] = $searchSimpleDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchSimpleDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchSimpleDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchSimpleDataMain[$key]['simple_data']['description'] = $searchSimpleDataMain[$key]['description'];
            $searchSimpleDataMain[$key]['simple_data']['hashtag'] = $searchSimpleDataMain[$key]['hashtag'];
            $searchSimpleDataMain[$key]['simple_data']['sim_title'] = $searchSimpleDataMain[$key]['sim_title'];
            $searchSimpleDataMain[$key]['simple_data']['simslug'] = $searchSimpleDataMain[$key]['simslug'];

            if($searchSimpleDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchSimpleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchSimpleDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchSimpleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchSimpleDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchSimpleDataMain[$key]['post_file_data'] = $post_file_data;

            $searchSimpleDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchSimpleDataMain[$key]['post_like_count'] = $post_like_count;
            $searchSimpleDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchSimpleDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchSimpleDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchSimpleDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchSimpleDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchSimpleDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchSimpleDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchSimpleDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchSimpleDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['sim_post'] = $searchSimpleDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_question()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');

        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        
        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_question', 
            'type'  => 'aileensoul_search_question',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['question','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
        }

        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['question'] = $value->name;
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }

        $query = $client->search($params);        
        // print_r($query);exit();
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['question_count'] = $search_data['total'];
        $searchQuestionData = $search_data['hits'];

        if($search_data['total'] < 1)
        {        
            $params = array();            
            $params = [
                'index' => 'aileensoul_search_question', 
                'type'  => 'aileensoul_search_question',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['question','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
            }

            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['question'] = $value->name;
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->name;
                }   
            }
            // print_r($params);exit();
            $query = $client->search($params);

            $search_data = $query['hits'];
            $searchData['question_count'] = $search_data['total'];
            $searchQuestionData = $search_data['hits'];
        }

        $searchQuestionDataMain = array();        

        foreach ($searchQuestionData as $key => $value) {
            $searchQuestionDataMain[$key] = $value['_source'];
            $searchQuestionDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchQuestionDataMain[$key]['created_date']);
            $searchQuestionDataMain[$key]['post_data'] = $searchQuestionDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchQuestionDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchQuestionDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchQuestionDataMain[$key]['question_data']['category'] = $searchQuestionDataMain[$key]['category'];
            $searchQuestionDataMain[$key]['question_data']['description'] = $searchQuestionDataMain[$key]['description'];
            $searchQuestionDataMain[$key]['question_data']['field'] = $searchQuestionDataMain[$key]['field'];
            $searchQuestionDataMain[$key]['question_data']['hashtag'] = $searchQuestionDataMain[$key]['hashtag'];
            $searchQuestionDataMain[$key]['question_data']['is_anonymously'] = $searchQuestionDataMain[$key]['is_anonymously'];
            $searchQuestionDataMain[$key]['question_data']['link'] = $searchQuestionDataMain[$key]['link'];
            $searchQuestionDataMain[$key]['question_data']['modify_date'] = $searchQuestionDataMain[$key]['modify_date'];
            $searchQuestionDataMain[$key]['question_data']['others_field'] = $searchQuestionDataMain[$key]['others_field'];
            $searchQuestionDataMain[$key]['question_data']['question'] = $searchQuestionDataMain[$key]['question'];

            if($searchQuestionDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchQuestionDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchQuestionDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchQuestionDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchQuestionDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchQuestionDataMain[$key]['post_file_data'] = $post_file_data;

            $searchQuestionDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchQuestionDataMain[$key]['post_like_count'] = $post_like_count;
            $searchQuestionDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchQuestionDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchQuestionDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchQuestionDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchQuestionDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchQuestionDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchQuestionDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchQuestionDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchQuestionDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['question_post'] = $searchQuestionDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_article()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_article', 
            'type'  => 'aileensoul_search_article',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [                                            
                                        'query_string' =>
                                        [
                                            'fields'=>['article_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];


        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
        }
        /*if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['article_title'] = $value->name;
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }*/

        $query = $client->search($params);        
        // print_r($query);exit();
       
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['article_count'] = $search_data['total'];
        $searchArticleData = $search_data['hits'];

        if($search_data['total'] < 1)
        {        
            $params = array();            
            $params = [
                'index' => 'aileensoul_search_article', 
                'type'  => 'aileensoul_search_article',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['article_title','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field'] = $search_field;
            }

            /*if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['question'] = $value->name;
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->name;
                }   
            }*/
            // print_r($params);exit();
            $query = $client->search($params);

            $search_data = $query['hits'];
            $searchData['article_count'] = $search_data['total'];
            $searchArticleData = $search_data['hits'];
        }
        $searchArticleDataMain = array();        

        foreach ($searchArticleData as $key => $value) {
            $searchArticleDataMain[$key] = $value['_source'];
            $searchArticleDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchArticleDataMain[$key]['created_date']);
            $searchArticleDataMain[$key]['post_data'] = $searchArticleDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchArticleDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchArticleDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchArticleDataMain[$key]['article_data']['article_desc'] = $searchArticleDataMain[$key]['article_desc'];
            $searchArticleDataMain[$key]['article_data']['article_main_category'] = $searchArticleDataMain[$key]['article_main_category'];
            $searchArticleDataMain[$key]['article_data']['article_other_category'] = $searchArticleDataMain[$key]['article_other_category'];
            $searchArticleDataMain[$key]['article_data']['article_featured_image'] = $searchArticleDataMain[$key]['article_featured_image'];
            $searchArticleDataMain[$key]['article_data']['article_meta_description'] = $searchArticleDataMain[$key]['article_meta_description'];
            $searchArticleDataMain[$key]['article_data']['article_meta_title'] = $searchArticleDataMain[$key]['article_meta_title'];
            $searchArticleDataMain[$key]['article_data']['article_slug'] = $searchArticleDataMain[$key]['article_slug'];
            $searchArticleDataMain[$key]['article_data']['article_sub_category'] = $searchArticleDataMain[$key]['article_sub_category'];
            $searchArticleDataMain[$key]['article_data']['article_title'] = $searchArticleDataMain[$key]['article_title'];
            $searchArticleDataMain[$key]['article_data']['hashtag_id'] = $searchArticleDataMain[$key]['hashtag_id'];
            $searchArticleDataMain[$key]['article_data']['id_post_article'] = $searchArticleDataMain[$key]['id_post_article'];
            $searchArticleDataMain[$key]['article_data']['hashtag'] = $searchArticleDataMain[$key]['hashtag'];
            $searchArticleDataMain[$key]['article_data']['field'] = $searchArticleDataMain[$key]['field'];

            if($searchArticleDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchArticleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchArticleDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchArticleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchArticleDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchArticleDataMain[$key]['post_file_data'] = $post_file_data;

            $searchArticleDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchArticleDataMain[$key]['post_like_count'] = $post_like_count;
            $searchArticleDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchArticleDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchArticleDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchArticleDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchArticleDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchArticleDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchArticleDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchArticleDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchArticleDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['article_post'] = $searchArticleDataMain;
        // echo json_encode($searchData);
        return $searchData;
    }

    public function search_total_count()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        $search_city = $this->input->post('search_city');
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        if($search_city != undefined && $search_city != '')
        {
            $search_city = json_decode($search_city);
        }

        $client = $this->elasticclient;
        $return_arr = array();
        
        //People Start
        $params_people = [
            'index' => 'aileensoul_search_people', 
            'type'  => 'aileensoul_search_people',
            'from'  => 0,
            'size'  => 10,
            'body'  => [
                            'query' =>
                            [    
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end                                
                            ]//query end                            
                        ],//body end
        ];

        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params_people['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['city_name'] = $value->city_name;
            }
        }
        if($search_field != undefined && $search_field != '')
        {            
            $params_people['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                'fields'=>array('profession_field.keyword','student_field.keyword'),
                'query' => $search_field,
            );
        }
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {
                $params_people['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                    'fields'=>array('degree_name','title_name'),
                    'query' => $value->name,
                );
            }   
        }

        $query_people = $client->search($params_people);
        // print_r($params_people['body']['query']['bool']);exit();
        $search_data_people = $query_people['hits'];
        $return_arr['people_count'] = $search_data_people['total'];
        if($search_data_people['total'] < 1)
        {
            $params_people = [
                'index' => 'aileensoul_search_people', 
                'type'  => 'aileensoul_search_people',
                'from'  => 0,
                'size'  => 10,
                'body'  => [
                                'query' =>
                                [    
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end                                
                                ]//query end                            
                            ],//body end
            ];

            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params_people['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['city_name'] = $value->city_name;
                }
            }
            if($search_field != undefined && $search_field != '')
            {            
                $params_people['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                    'fields'=>array('profession_field.keyword','student_field.keyword'),
                    'query' => $search_field,
                );
            }
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {
                    $params_people['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                        'fields'=>array('degree_name','title_name'),
                        'query' => $value->name,
                    );
                }   
            }

            $query_people = $client->search($params_people);
            // print_r($params_people['body']['query']['bool']);exit();
            $search_data_people = $query_people['hits'];
            $return_arr['people_count'] = $search_data_people['total'];
        }

        $params_buss = [
            'index' => 'aileensoul_search_business', 
            'type'  => 'aileensoul_search_business',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['company_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ]//query end
                        ],//body end
        ];
        $query_buss = $client->search($params_buss);
        $search_data_buss = $query_buss['hits'];
        $return_arr['business_count'] = $search_data_buss['total'];
        //People End

        //Opportunity Start
        $params_opp = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['opptitle','opportunity_for','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ]//query end                            
                        ],//body end
        ];
        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params_opp['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['location'] = $value->city_name;
            }
        }
        if($search_field != undefined && $search_field != '')
        {
            $params_opp['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
        }
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params_opp['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['opportunity_for'] = $value->name;
            }   
        }
        $query_opp = $client->search($params_opp); 
        $search_data_opp = $query_opp['hits'];
        $return_arr['opp_count'] = $search_data_opp['total'];
        if($search_data_opp['total'] < 1)
        {
            $params_opp = array();
            $params_opp = [
                'index' => 'aileensoul_search_opportunity', 
                'type'  => 'aileensoul_search_opportunity',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['opptitle','opportunity_for','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ]//query end                            
                            ],//body end
            ];
            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params_opp['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['location'] = $value->city_name;
                }
            }
            if($search_field != undefined && $search_field != '')
            {
                $params_opp['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
            }
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params_opp['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['opportunity_for'] = $value->name;
                }   
            }
            $query_opp = $client->search($params_opp); 
            $search_data_opp = $query_opp['hits'];
            $return_arr['opp_count'] = $search_data_opp['total'];
        }
        //Opportunity End

        //Post Start
        $params_post = [
            'index' => 'aileensoul_search_post', 
            'type'  => 'aileensoul_search_post',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['sim_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ]//query end                        
                        ],//body end
        ];
        /*if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params_post['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['sim_title'] = $value->name;
                $params_post['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }*/
        $query_post = $client->search($params_post);
        $search_data_post = $query_post['hits'];
        $return_arr['simple_count'] = $search_data_post['total'];
        //Post End

        //Question Start
        $params_que = [
            'index' => 'aileensoul_search_question', 
            'type'  => 'aileensoul_search_question',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['question','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ]//query end
                        ],//body end
        ];
        if($search_field != undefined && $search_field != '')
        {
            $params_que['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
        }
        /*if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params_que['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['question'] = $value->name;
                $params_que['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }*/
        $query_que = $client->search($params_que);
        $search_data_que = $query_que['hits'];
        $return_arr['question_count'] = $search_data_que['total'];
        if($search_data_que['total'] < 1)
        {
            $params_que = [
                'index' => 'aileensoul_search_question', 
                'type'  => 'aileensoul_search_question',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['question','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ]//query end
                            ],//body end
            ];
            if($search_field != undefined && $search_field != '')
            {
                $params_que['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
            }
            $query_que = $client->search($params_que);
            $search_data_que = $query_que['hits'];
            $return_arr['question_count'] = $search_data_que['total'];   
        }
        //Question End

        //Article Start
        $params_article = [
            'index' => 'aileensoul_search_article', 
            'type'  => 'aileensoul_search_article',
            'from'  => 0,
            'size'  => 1,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [                                            
                                        'query_string' =>
                                        [
                                            'fields'=>['article_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ]//query end
                        ],//body end
        ];
        if($search_field != undefined && $search_field != '')
        {
            $params_article['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('profession_field'=>$search_field));
        }
        /*if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params_article['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['article_title'] = $value->name;
                $params_article['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->name;
            }   
        }*/
        $query_article = $client->search($params_article);
        $search_data_article = $query_article['hits'];
        $return_arr['article_count'] = $search_data_article['total'];
        if($search_data_article['total'] < 1)
        {
            $params_article = [
                'index' => 'aileensoul_search_article', 
                'type'  => 'aileensoul_search_article',
                'from'  => 0,
                'size'  => 1,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [                                            
                                            'query_string' =>
                                            [
                                                'fields'=>['article_title','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ]//query end
                            ],//body end
            ];
            if($search_field != undefined && $search_field != '')
            {
                $params_article['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = $search_field;
            } 
        }
        //Article End

        $return_arr['total_count'] = $search_data_people['total']+$search_data_buss['total']+$search_data_opp['total']+$search_data_post['total']+$search_data_que['total']+$search_data_article['total'];

        echo json_encode($return_arr);        
    }

    public function search_opportunity_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');        
        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        $search_city = $this->input->post('search_city');
        $search_hashtag = $this->input->post('search_hashtag');
        $search_company = $this->input->post('search_company');
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        if($search_city != undefined && $search_city != '')
        {
            $search_city = json_decode($search_city);
        }

        if($search_hashtag != undefined && $search_hashtag != '')
        {
            $search_hashtag = json_decode($search_hashtag);
        }
        if($search_company != undefined && $search_company != '')
        {
            $search_company = json_decode($search_company);
        }


        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['opptitle','opportunity_for','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['location'] = $value->city_name;
            }
        }
        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
        }
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['opportunity_for'] = $value->name;
            }   
        }
        if(!empty($search_hashtag))
        {
            foreach ($search_hashtag as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->hashtag;
            }   
        }
        if(!empty($search_company))
        {
            foreach ($search_company as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['company_name'] = $value->company_name;
            }   
        }
        

        $query = $client->search($params);        
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['opp_count'] = $search_data['total'];
        $searchOpportunityData = $search_data['hits'];
        if($search_data['total'] < 1)
        {
            $params = [
                'index' => 'aileensoul_search_opportunity', 
                'type'  => 'aileensoul_search_opportunity',
                'from'  => $start,
                'size'  => $limit,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['opptitle','opportunity_for','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['location'] = $value->city_name;
                }
            }
            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = $search_field;//array('match_phrase'=>array('field'=>$search_field));
            }
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['opportunity_for'] = $value->name;
                }   
            }
            if(!empty($search_hashtag))
            {
                foreach ($search_hashtag as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->hashtag;
                }   
            }
            if(!empty($search_company))
            {
                foreach ($search_company as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['company_name'] = $value->company_name;
                }   
            }            

            $query = $client->search($params);
            $search_data = $query['hits'];
            $searchData['opp_count'] = $search_data['total'];
            $searchOpportunityData = $search_data['hits'];
        }
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

        $searchData['opp_post'] = $searchOpportunityDataMain;
        $searchData['page'] = $page;
        echo json_encode($searchData);        
    }

    public function search_people_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];
        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $search_job_title = $this->input->post('search_job_title');
        $search_field = $this->input->post('search_field');
        $search_city = $this->input->post('search_city');
        $search_gender = $this->input->post('search_gender');
        if($search_job_title != undefined && $search_job_title != '')
        {
            $search_job_title = json_decode($search_job_title);
        }
        if($search_city != undefined && $search_city != '')
        {
            $search_city = json_decode($search_city);
        }
        
        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_people', 
            'type'  => 'aileensoul_search_people',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end                                
                            ],//query end
                            /*'sort' =>
                            [
                                'id' =>
                                [
                                    "order" => "desc"
                                ],
                            ],*/

                        ],//body end
        ];
        
        if(!empty($search_job_title))
        {
            foreach ($search_job_title as $key => $value) {                
                $params['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                'fields'=>array('degree_name','title_name'),
                'query' => $value->name,
            );
            }   
        }
        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['multi_match'] = array(
                'fields'=>array('profession_field.keyword','student_field.keyword'),
                'query' => $search_field,
            );
        }
        if(!empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['city_name'] = $value->city_name;
            }
        }
        if($search_gender != undefined && $search_gender != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['user_gender'] = $search_gender;
        }
        // print_r($params['body']['query']['bool']);exit();
        $query = $client->search($params);        
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['people_count'] = $search_data['total'];
        $searchProfileData = $search_data['hits'];
        if($search_data['total'] < 1)
        {
            $params = [
                'index' => 'aileensoul_search_people', 
                'type'  => 'aileensoul_search_people',
                'from'  => $start,
                'size'  => $limit,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['first_name', 'last_name', 'title_name', 'degree_name'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                            ],//body end
            ];
            
            if(!empty($search_job_title))
            {
                foreach ($search_job_title as $key => $value) {                
                    $params['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                    'fields'=>array('degree_name','title_name'),
                    'query' => $value->name,
                );
                }   
            }
            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['multi_match'] = array(
                    'fields'=>array('profession_field.keyword','student_field.keyword'),
                    'query' => $search_field,
                );
            }
            if(!empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['city_name'] = $value->city_name;
                }
            }
            if($search_gender != undefined && $search_gender != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['user_gender'] = $search_gender;
            }
            // print_r($params['body']['query']['bool']);exit();
            $query = $client->search($params);
            $search_data = $query['hits'];
            $searchData['people_count'] = $search_data['total'];
            $searchProfileData = $search_data['hits'];
        }
        $searchProfileDataMain = array();

        foreach ($searchProfileData as $key => $value) {
           $searchProfileDataMain[$key] = $value['_source'];
            $searchProfileDataMain[$key]['user_id'] = $value['_id'];                
        
            $is_userBasicInfo = $this->user_model->is_userBasicInfo($value['_id']);
            if ($is_userBasicInfo) {
                $searchProfileDataMain[$key]['city'] = $this->data_model->getCityName($value['_source']['profession_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['profession_city']);
                $searchProfileDataMain[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            } else {
                $searchProfileDataMain[$key]['city'] = $this->data_model->getCityName($value['_source']['student_city']);
                $state_id = $this->data_model->getStateIdByCityId($value['_source']['student_city']);
                $searchProfileDataMain[$key]['country'] = $this->data_model->getCountryByStateId($state_id);
            }
            $contact_detail = $this->db->select('from_id,to_id,status,not_read')->from('user_contact')->where('(from_id =' . $value['_id'] . ' AND to_id =' . $userid . ') OR (to_id =' . $value['_id'] . ' AND from_id =' . $userid . ')')->get()->row_array();
            $searchProfileDataMain[$key]['contact_from_id'] = $contact_detail['from_id'];
            $searchProfileDataMain[$key]['contact_to_id'] = $contact_detail['to_id'];
            $searchProfileDataMain[$key]['contact_status'] = $contact_detail['status'];
            $searchProfileDataMain[$key]['contact_not_read'] = $contact_detail['not_read'];

            $follow_detail = $this->db->select('follow_from,follow_to,status')->from('user_follow')->where('(follow_to =' . $value['_id'] . ' AND follow_from =' . $userid . ')')->get()->row_array();
            $searchProfileDataMain[$key]['follow_from'] = $follow_detail['follow_from'];
            $searchProfileDataMain[$key]['follow_to'] = $follow_detail['follow_to'];
            $searchProfileDataMain[$key]['follow_status'] = $follow_detail['status'];
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['profile'] = $searchProfileDataMain;
        $searchData['page'] = $page;
        echo json_encode($searchData);        
    }

    public function search_post_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $search_hashtag = $this->input->post('search_hashtag');

        if($search_hashtag != undefined && $search_hashtag != '')
        {
            $search_hashtag = json_decode($search_hashtag);
        }

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_post', 
            'type'  => 'aileensoul_search_post',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['sim_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],

                        ],//body end
        ];
        if(!empty($search_hashtag))
        {
            foreach ($search_hashtag as $key => $value) {
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->hashtag;
            }   
        }        

        $query = $client->search($params);        
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['simple_count'] = $search_data['total'];
        $searchSimpleData = $search_data['hits'];
        $searchSimpleDataMain = array();        

        foreach ($searchSimpleData as $key => $value) {
            $searchSimpleDataMain[$key] = $value['_source'];
            $searchSimpleDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchSimpleDataMain[$key]['created_date']);
            $searchSimpleDataMain[$key]['post_data'] = $searchSimpleDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchSimpleDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchSimpleDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchSimpleDataMain[$key]['simple_data']['description'] = $searchSimpleDataMain[$key]['description'];
            $searchSimpleDataMain[$key]['simple_data']['hashtag'] = $searchSimpleDataMain[$key]['hashtag'];
            $searchSimpleDataMain[$key]['simple_data']['sim_title'] = $searchSimpleDataMain[$key]['sim_title'];
            $searchSimpleDataMain[$key]['simple_data']['simslug'] = $searchSimpleDataMain[$key]['simslug'];

            if($searchSimpleDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchSimpleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchSimpleDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchSimpleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchSimpleDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchSimpleDataMain[$key]['post_file_data'] = $post_file_data;

            $searchSimpleDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchSimpleDataMain[$key]['post_like_count'] = $post_like_count;
            $searchSimpleDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchSimpleDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchSimpleDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchSimpleDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchSimpleDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchSimpleDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchSimpleDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchSimpleDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchSimpleDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['sim_post'] = $searchSimpleDataMain;
        $searchData['page'] = $page;
        echo json_encode($searchData);        
    }

    public function search_business_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $this->input->post('searchKeyword');
        $search_field = $this->input->post('industry_name');
        $search_city = $this->input->post('city_name');
        
        // print_r($_POST);exit();

        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_business', 
            'type'  => 'aileensoul_search_business',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['company_name'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if(isset($search_city) && !empty($search_city))
        {            
            foreach ($search_city as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['city_name'] = $value;
            }
        }
        if(isset($search_field) && !empty($search_field))
        {
            foreach ($search_field as $key => $value) {
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['industry_name'] = $value;//array('match_phrase'=>array('field'=>$search_field));
            }
        }

        $query = $client->search($params);        
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['business_count'] = $search_data['total'];
        $searchBusinessData = $search_data['hits'];
        if($search_data['total'] < 1)
        {
            $params = [
                'index' => 'aileensoul_search_business', 
                'type'  => 'aileensoul_search_business',
                'from'  => $start,
                'size'  => $limit,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['company_name'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if(isset($search_city) && !empty($search_city))
            {            
                foreach ($search_city as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['city_name'] = $value;
                }
            }
            if(isset($search_field) && !empty($search_field))
            {
                foreach ($search_field as $key => $value) {
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['industry_name'] = $value;//array('match_phrase'=>array('field'=>$search_field));
                }
            }

            $search_data = $query['hits'];
            $searchData['business_count'] = $search_data['total'];
            $searchBusinessData = $search_data['hits'];
        }
        $searchBusinessDataMain = array();

        foreach ($searchBusinessData as $key => $value) {            
            $searchBusinessDataMain[$key] = $value['_source'];
            $searchBusinessDataMain[$key]['user_id'] = $value['_id'];
        }

        $searchData['page'] = $page;
        $searchData['business_data'] = $searchBusinessDataMain;
        echo json_encode($searchData);        
    }

    public function search_article_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $search_field = $this->input->post('search_field');

        $search_hashtag = $this->input->post('search_hashtag');
        if($search_hashtag != undefined && $search_hashtag != '')
        {
            $search_hashtag = json_decode($search_hashtag);
        }

        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_article', 
            'type'  => 'aileensoul_search_article',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [                                            
                                        'query_string' =>
                                        [
                                            'fields'=>['article_title','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = base64_decode($search_field);//array('match_phrase'=>array('field'=>$search_field));
        }
        
        if(!empty($search_hashtag))
        {
            foreach ($search_hashtag as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->hashtag;
            }   
        }

        $query = $client->search($params);        
       
        $searchData = array();
        $search_data = $query['hits'];        
        $searchData['article_count'] = $search_data['total'];
        $searchArticleData = $search_data['hits'];
        if($search_data['total'] < 1)
        {
            $params = [
                'index' => 'aileensoul_search_article', 
                'type'  => 'aileensoul_search_article',
                'from'  => $start,
                'size'  => $limit,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [                                            
                                            'query_string' =>
                                            [
                                                'fields'=>['article_title','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = base64_decode($search_field);//array('match_phrase'=>array('field'=>$search_field));
            }
            
            if(!empty($search_hashtag))
            {
                foreach ($search_hashtag as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->hashtag;
                }   
            }

            $query = $client->search($params);

            $search_data = $query['hits'];        
            $searchData['article_count'] = $search_data['total'];
            $searchArticleData = $search_data['hits'];
        }
        $searchArticleDataMain = array();        

        foreach ($searchArticleData as $key => $value) {
            $searchArticleDataMain[$key] = $value['_source'];
            $searchArticleDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchArticleDataMain[$key]['created_date']);
            $searchArticleDataMain[$key]['post_data'] = $searchArticleDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchArticleDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchArticleDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchArticleDataMain[$key]['article_data']['article_desc'] = $searchArticleDataMain[$key]['article_desc'];
            $searchArticleDataMain[$key]['article_data']['article_main_category'] = $searchArticleDataMain[$key]['article_main_category'];
            $searchArticleDataMain[$key]['article_data']['article_other_category'] = $searchArticleDataMain[$key]['article_other_category'];
            $searchArticleDataMain[$key]['article_data']['article_featured_image'] = $searchArticleDataMain[$key]['article_featured_image'];
            $searchArticleDataMain[$key]['article_data']['article_meta_description'] = $searchArticleDataMain[$key]['article_meta_description'];
            $searchArticleDataMain[$key]['article_data']['article_meta_title'] = $searchArticleDataMain[$key]['article_meta_title'];
            $searchArticleDataMain[$key]['article_data']['article_slug'] = $searchArticleDataMain[$key]['article_slug'];
            $searchArticleDataMain[$key]['article_data']['article_sub_category'] = $searchArticleDataMain[$key]['article_sub_category'];
            $searchArticleDataMain[$key]['article_data']['article_title'] = $searchArticleDataMain[$key]['article_title'];
            $searchArticleDataMain[$key]['article_data']['hashtag_id'] = $searchArticleDataMain[$key]['hashtag_id'];
            $searchArticleDataMain[$key]['article_data']['id_post_article'] = $searchArticleDataMain[$key]['id_post_article'];
            $searchArticleDataMain[$key]['article_data']['hashtag'] = $searchArticleDataMain[$key]['hashtag'];
            $searchArticleDataMain[$key]['article_data']['field'] = $searchArticleDataMain[$key]['field'];

            if($searchArticleDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchArticleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchArticleDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchArticleDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchArticleDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchArticleDataMain[$key]['post_file_data'] = $post_file_data;

            $searchArticleDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchArticleDataMain[$key]['post_like_count'] = $post_like_count;
            $searchArticleDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchArticleDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchArticleDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchArticleDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchArticleDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchArticleDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchArticleDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchArticleDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchArticleDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['article_post'] = $searchArticleDataMain;
        $searchData['page'] = $page;
        echo json_encode($searchData);        
    }

    public function search_question_data()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $search_field = $this->input->post('search_field');
        
        $search_hashtag = $this->input->post('search_hashtag');
        if($search_hashtag != undefined && $search_hashtag != '')
        {
            $search_hashtag = json_decode($search_hashtag);
        }

        $page = 1;
        if (!empty($this->input->post('page')) && $this->input->post('page') != 'undefined') {
            $page = $this->input->post('page');
        }

        $limit = '10';
        $start = ($page - 1) * $limit;
        if ($start < 0)
            $start = 0;

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul_search_question', 
            'type'  => 'aileensoul_search_question',
            'from'  => $start,
            'size'  => $limit,
            'body'  => [
                            'query' =>
                            [
                                'bool' =>
                                [
                                    'must' =>
                                    [
                                        'query_string' =>
                                        [
                                            'fields'=>['question','hashtag'],
                                            'query'=>'*'.$searchKeyword.'*',
                                            'analyzer'=>'standard'
                                        ],                                            
                                    ],//must end
                                    'must_not' =>
                                    [
                                        [
                                            'match' =>
                                            [
                                                'user_id' => $userid
                                            ]
                                        ]
                                    ]//must not end
                                ]//bool end
                            ],//query end
                            'sort' =>
                            [
                                'created_date.keyword' =>
                                [
                                    "order" => "desc"
                                ],
                            ],
                        ],//body end
        ];

        if($search_field != undefined && $search_field != '')
        {
            $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['field.keyword'] = base64_decode($search_field);//array('match_phrase'=>array('field'=>$search_field));
        }
        
        if(!empty($search_hashtag))
        {
            foreach ($search_hashtag as $key => $value) {            
                $params['body']['query']['bool']['filter']['bool']['must'][]['match_phrase']['hashtag'] = $value->hashtag;
            }   
        }

        $query = $client->search($params);        
        
        $searchData = array();
        $search_data = $query['hits'];
        $searchData['question_count'] = $search_data['total'];
        $searchQuestionData = $search_data['hits'];
        if($search_data['total'] < 1)
        {
            $params = array();
            $params = [
                'index' => 'aileensoul_search_question', 
                'type'  => 'aileensoul_search_question',
                'from'  => $start,
                'size'  => $limit,
                'body'  => [
                                'query' =>
                                [
                                    'bool' =>
                                    [
                                        'must' =>
                                        [
                                            'query_string' =>
                                            [
                                                'fields'=>['question','hashtag'],
                                                'query'=>'*'.$searchKeyword.'*',
                                                'analyzer'=>'standard'
                                            ],                                            
                                        ],//must end
                                        'must_not' =>
                                        [
                                            [
                                                'match' =>
                                                [
                                                    'user_id' => $userid
                                                ]
                                            ]
                                        ]//must not end
                                    ]//bool end
                                ],//query end
                                'sort' =>
                                [
                                    'created_date.keyword' =>
                                    [
                                        "order" => "desc"
                                    ],
                                ],
                            ],//body end
            ];

            if($search_field != undefined && $search_field != '')
            {
                $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['field.keyword'] = base64_decode($search_field);//array('match_phrase'=>array('field'=>$search_field));
            }
            
            if(!empty($search_hashtag))
            {
                foreach ($search_hashtag as $key => $value) {            
                    $params['body']['query']['bool']['filter']['bool']['should'][]['match_phrase']['hashtag'] = $value->hashtag;
                }   
            }

            $query = $client->search($params);        
            
            $search_data = $query['hits'];
            $searchData['question_count'] = $search_data['total'];
            $searchQuestionData = $search_data['hits'];
        }
        $searchQuestionDataMain = array();        

        foreach ($searchQuestionData as $key => $value) {
            $searchQuestionDataMain[$key] = $value['_source'];
            $searchQuestionDataMain[$key]['time_string'] = $this->common->time_elapsed_string($searchQuestionDataMain[$key]['created_date']);
            $searchQuestionDataMain[$key]['post_data'] = $searchQuestionDataMain[$key];

            $this->db->select("count(*) as file_count")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $total_post_files = $query->row_array('file_count');
            $searchQuestionDataMain[$key]['post_data']['total_post_files'] = $total_post_files['file_count'];
            $searchQuestionDataMain[$key]['post_data']['id'] = $value['_id'];

            $searchQuestionDataMain[$key]['question_data']['category'] = $searchQuestionDataMain[$key]['category'];
            $searchQuestionDataMain[$key]['question_data']['description'] = $searchQuestionDataMain[$key]['description'];
            $searchQuestionDataMain[$key]['question_data']['field'] = $searchQuestionDataMain[$key]['field'];
            $searchQuestionDataMain[$key]['question_data']['hashtag'] = $searchQuestionDataMain[$key]['hashtag'];
            $searchQuestionDataMain[$key]['question_data']['is_anonymously'] = $searchQuestionDataMain[$key]['is_anonymously'];
            $searchQuestionDataMain[$key]['question_data']['link'] = $searchQuestionDataMain[$key]['link'];
            $searchQuestionDataMain[$key]['question_data']['modify_date'] = $searchQuestionDataMain[$key]['modify_date'];
            $searchQuestionDataMain[$key]['question_data']['others_field'] = $searchQuestionDataMain[$key]['others_field'];
            $searchQuestionDataMain[$key]['question_data']['question'] = $searchQuestionDataMain[$key]['question'];

            if($searchQuestionDataMain[$key]['user_type'] == '1')
            {                
                $this->db->select("u.user_id,u.user_slug,u.first_name,u.last_name,u.user_gender,CONCAT(u.first_name,' ',u.last_name) as fullname,ui.user_image,jt.name as title_name,d.degree_name")->from("user u");
                $this->db->join('user_info ui', 'ui.user_id = u.user_id', 'left');
                $this->db->join('user_login ul', 'ul.user_id = u.user_id', 'left');
                $this->db->join('user_profession up', 'up.user_id = u.user_id', 'left');
                $this->db->join('job_title jt', 'jt.title_id = up.designation', 'left');
                $this->db->join('user_student us', 'us.user_id = u.user_id', 'left');
                $this->db->join('degree d', 'd.degree_id = us.current_study', 'left');
                $this->db->where('u.user_id', $searchQuestionDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchQuestionDataMain[$key]['user_data'] = $user_data;
            }
            else
            {
                $this->db->select("bp.business_profile_id, bp.company_name, bp.country, bp.state, bp.city, bp.pincode, bp.address, bp.contact_person, bp.contact_mobile, bp.contact_email, bp.contact_website, bp.business_type, bp.industriyal, bp.details, bp.addmore, bp.user_id, bp.status, bp.is_deleted, bp.created_date, bp.modified_date, bp.business_step, bp.business_user_image, bp.profile_background, bp.profile_background_main, bp.business_slug, bp.other_business_type, bp.other_industrial, ct.city_name, st.state_name, IF (bp.city != '',CONCAT(bp.business_slug, '-', ct.city_name),IF(st.state_name != '',CONCAT(bp.business_slug, '-', st.state_name),CONCAT(bp.business_slug, '-', cr.country_name))) as business_slug,IF(bp.industriyal = 0,bp.other_industrial,it.industry_name) as industry_name")->from("business_profile bp");
                $this->db->join('user_login ul', 'ul.user_id = bp.user_id', 'left');
                $this->db->join('industry_type it', 'it.industry_id = bp.industriyal', 'left');            
                $this->db->join('cities ct', 'ct.city_id = bp.city', 'left');
                $this->db->join('states st', 'st.state_id = bp.state', 'left');
                $this->db->join('countries cr', 'cr.country_id = bp.country', 'left');
                $this->db->where('bp.user_id', $searchQuestionDataMain[$key]['user_id']);
                $query = $this->db->get();
                $user_data = $query->row_array();
                $searchQuestionDataMain[$key]['user_data'] = $user_data;
            }

            $this->db->select("upf.file_type,upf.filename")->from("user_post_file upf");
            $this->db->where('upf.post_id', $value['_id']);
            $query = $this->db->get();
            $post_file_data = $query->result_array();
            $searchQuestionDataMain[$key]['post_file_data'] = $post_file_data;

            $searchQuestionDataMain[$key]['user_like_list'] = $this->user_post_model->get_user_like_list($value['_id']);
            $post_like_data = $this->user_post_model->postLikeData($value['_id']);
            $post_like_count = $this->user_post_model->likepost_count($value['_id']);
            $searchQuestionDataMain[$key]['post_like_count'] = $post_like_count;
            $searchQuestionDataMain[$key]['is_userlikePost'] = $this->user_post_model->is_userlikePost($userid, $value['_id']);
            $searchQuestionDataMain[$key]['is_user_saved_post'] = $this->user_post_model->is_user_saved_post($userid, $value['_id']);

            $searchQuestionDataMain[$key]['post_share_count'] = $this->user_post_model->postShareCount($value['_id']);

            if ($post_like_count > 1) {
                $searchQuestionDataMain[$key]['post_like_data'] = $post_like_data['username'] . ' and ' . ($post_like_count - 1) . ' other';
            } elseif ($post_like_count == 1) {
                $searchQuestionDataMain[$key]['post_like_data'] = $post_like_data['username'];
            }
            $searchQuestionDataMain[$key]['post_comment_count'] = $this->user_post_model->postCommentCount($value['_id']);
            $searchQuestionDataMain[$key]['post_comment_data'] = $postCommentData = $this->user_post_model->postCommentData($value['_id'],$userid);

            foreach ($postCommentData as $key1 => $value1) {
                $searchQuestionDataMain[$key]['post_comment_data'][$key1]['is_userlikePostComment'] = $this->user_post_model->is_userlikePostComment($userid, $value1['comment_id']);
                $searchQuestionDataMain[$key]['post_comment_data'][$key1]['postCommentLikeCount'] = $this->user_post_model->postCommentLikeCount($value1['comment_id']) == '0' ? '' : $this->user_post_model->postCommentLikeCount($value1['comment_id']);
            }            
        }
        // echo "<pre>";
        /*print_r($result);exit();
        return $result;*/
        $searchData['question_post'] = $searchQuestionDataMain;
        $searchData['page'] = $page;
        echo json_encode($searchData);        
    }

    public function insert_people_data_from_json()
    {
        set_time_limit(0);
        ini_set("memory_limit","512M");

        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/ailee_user.json');
        // echo $str;exit();
        $result = json_decode($str, true); 
        echo "<pre>";
        // print_r($result);exit();

        $params = null;
        foreach($result as $k=>$row)
        {
            // print_r($row);exit;
            /*$params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_people',
                    '_type' => 'aileensoul_search_people',
                    '_id' => $row['user_id'],
                ),
            );
            $params['body'][] = ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'], 'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'], 'city_name' => $row['city_name'],];*/            
            // print_r($params);exit();
            $params = ['index' => 'aileensoul_search_people', 'type' => 'aileensoul_search_people', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'], 'city_name' => $row['city_name'],]];
            $responses = $client->index($params);
            // print_r($responses);
            print_r($params);
        }
        // echo "<pre>";
        // print_r($params);
        // $responses = $client->bulk($params);
        exit();
        return true;
    }

    public function insert_business_data_from_json()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/ailee_business_profile.json');        
        // echo $str;exit();
        $result = json_decode(($str), true); 
        echo "<pre>";
        // print_r($result);exit();

        $params = null;
        foreach($result as $k=>$row)
        {
            $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $row['business_profile_id'], 'body' => ['company_name' => $row['company_name'],'country' => $row['country'],'state' => $row['state'], 'city' => $row['city'],'pincode' => $row['pincode'],'address' => $row['address'],'contact_person' => $row['contact_person'], 'contact_mobile' => $row['contact_mobile'], 'contact_email' => $row['contact_email'],'contact_website' => $row['contact_website'],'business_type' => $row['business_type'],'industriyal' => $row['industriyal'],'details' => $row['details'],'addmore' => $row['addmore'],'user_id' => $row['user_id'],'status' => $row['status'],'is_deleted' => $row['is_deleted'],'created_date' => $row['created_date'],'modified_date' => $row['modified_date'],'business_step' => $row['business_step'],'business_user_image' => $row['business_user_image'],'profile_background' => $row['profile_background'],'profile_background_main' => $row['profile_background_main'],'other_business_type' => $row['other_business_type'],'other_industrial' => $row['other_industrial'],'city_name' => $row['city_name'],'state_name' => $row['state_name'],'country_name' => $row['country_name'],'other_city' => $row['other_city'],'business_slug' => $row['business_slug'],'industry_name' => $row['industry_name'],]];
            $responses = $client->index($params);
            print_r($params);
        }
        // echo "<pre>";
        // $responses = $client->bulk($params);
        // print_r($responses);
        exit();
        return true;
    }

    public function insert_opportunity_data_from_json()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/opp_post.json');
        $result = json_decode($str, true); 
        echo "<pre>";
        print_r($result);

        $params = null;
        foreach($result as $k=>$row)
        {
            $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'opportunity_for' => $row['opportunity_for'], 'opportunity_for_id' => $row['opportunity_for_id'], 'location' => $row['location'], 'location_id' => $row['location_id'], 'opportunity' => $row['opportunity'], 'field' => $row['field'], 'other_field' => $row['other_field'], 'opptitle' => $row['opptitle'], 'oppslug' => $row['oppslug'], 'company_name' => $row['company_name'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'],]];
            $responses = $client->index($params);
            print_r($params);
        }
        // echo "<pre>";
        // $responses = $client->bulk($params);
        // print_r($responses);
        exit();
        return true;
    }

    public function insert_post_data_from_json()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/sim_post.json');
        $result = json_decode($str, true); 
        echo "<pre>";
        // print_r($result);exit();

        $params = null;
        foreach($result as $k=>$row)
        {
            $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'description' => $row['description'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'], 'sim_title' => $row['sim_title'], 'simslug' => $row['simslug'],]];
            $responses = $client->index($params);
            print_r($params);
        }
        // echo "<pre>";
        // $responses = $client->bulk($params);
        // print_r($responses);
        exit();
        return true;
    }

    public function insert_question_data_from_json()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/ailee_question.json');
        $result = json_decode($str, true); 
        echo "<pre>";
        // print_r($result);exit();

        $params = null;
        foreach($result as $k=>$row)
        {
            $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'category' => $row['category'],'description' => $row['description'],'field' => $row['field'],'hashtag' => $row['hashtag'],'is_anonymously' => $row['is_anonymously'],'link' => $row['link'],'modify_date' => $row['modify_date'],'others_field' => $row['others_field'],'question' => $row['question'],]];// print_r($params);exit();
            $responses = $client->index($params);
            print_r($params);
        }
        // echo "<pre>";
        // $responses = $client->bulk($params);
        // print_r($responses);
        exit();
        return true;
    }

    public function insert_article_data_from_json()
    {
        $client = $this->elasticclient;

        // $this->Mapping();exit();

        $str = file_get_contents('assets/ailee_post_article.json');
        $result = json_decode($str, true); 
        echo "<pre>";
        // print_r($result);exit();

        $params = null;
        foreach($result as $k=>$row)
        {
            /*$params['body'][] = array(
                'index' => array(
                    '_index' => 'aileensoul_search_article',
                    '_type' => 'aileensoul_search_article',
                    '_id' => $row['id'],
                ),
            );

            $params['body'][] = ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'article_desc' => $row['article_desc'],'article_main_category' => $row['article_main_category'],'article_other_category' => $row['article_other_category'],'article_featured_image' => $row['article_featured_image'],'article_meta_description' => $row['article_meta_description'],'article_meta_title' => $row['article_meta_title'],'article_slug' => $row['article_slug'],'article_sub_category' => $row['article_sub_category'],'article_title' => $row['article_title'],'hashtag_id' => $row['hashtag_id'],'id_post_article' => $row['id_post_article'],'hashtag' => $row['hashtag'],'field' => $row['field'],];
            $responses = $client->index($params);*/
            $params = ['index' => 'aileensoul_search_article', 'type' => 'aileensoul_search_article', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'article_desc' => $row['article_desc'],'article_main_category' => $row['article_main_category'],'article_other_category' => $row['article_other_category'],'article_featured_image' => $row['article_featured_image'],'article_meta_description' => $row['article_meta_description'],'article_meta_title' => $row['article_meta_title'],'article_slug' => $row['article_slug'],'article_sub_category' => $row['article_sub_category'],'article_title' => $row['article_title'],'hashtag_id' => $row['hashtag_id'],'id_post_article' => $row['id_post_article'],'hashtag' => $row['hashtag'],'field' => $row['field'],]];
            $responses = $client->index($params);
            print_r($params);
        }
        echo "<pre>";
        // print_r($params);
        // $responses = $client->bulk($params);
        // print_r($responses);exit();
        return true;
    }
}