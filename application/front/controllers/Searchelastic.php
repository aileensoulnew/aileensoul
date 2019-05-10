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
        $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
    }

    public function index() {
        $this->insert_people_data();
    }

    public function mapping_people(){
                $params = [
                    'index' => 'aileensoul',
                    'body' => [
                        'mappings' => [
                            'aileensoulpeoplesearch' => [
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
                    '_index' => 'aileensoul',
                    '_type' => 'aileensoulpeoplesearch',
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
           $params = ['index' => 'aileensoul', 'type' => 'aileensoulpeoplesearch', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'],]];
        }
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function update_people_data($articleid)
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
           $params = ['index' => 'aileensoul', 'type' => 'aileensoulpeoplesearch', 'id' => $row['user_id'], 'body' => ['first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'user_gender' => $row['user_gender'], 'fullname' => $row['fullname'],'user_slug' => $row['user_slug'], 'user_image' => $row['user_image'], 'title_name' => $row['title_name'], 'degree_name' => $row['degree_name'], 'profession_field' => $row['profession_field'], 'student_field' => $row['student_field'], 'profession_city' => $row['profession_city'], 'student_city' => $row['student_city'], 'university_name' => $row['university_name'],]];
        }

        $responses = $client->update($params);
        return true;
    }

    public function delete_people_data($id = 1)
    {
        $client = $this->elasticclient;
        $params = ['index' => 'aileensoul', 'type' => 'aileensoulpeoplesearch', 'id' => $id, ];
        $responses = $client->delete($params);
        return true;
    }

    public function search()
    {
        $userid = $this->session->userdata('aileenuser');
        $searchKeyword = $_POST['searchKeyword'];

        $client = $this->elasticclient;
        $result = array();
        $i = 0;
        $params = [
            'index' => 'aileensoul', 
            'type'  => 'aileensoulpeoplesearch',
            'from'  => 0,
            'size'  => 10,
            'body'  => ['query' => [
                            'bool' => [
                                'should' => [
                                    'multi_match' => [
                                        'query' => $searchKeyword,
                                        'type' => 'cross_fields',
                                        'fields' => ['first_name', 'last_name', 'title_name', 'degree_name'],
                                    ],
                                ]
                            ]
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
        echo json_encode($searchData);
    }

    public function add_people_index()
    {
        $client = Elasticsearch\ClientBuilder::create()->build();
        $params = [
            'index' => 'aileensoul',
            'type'  => 'aileensoulpeoplesearch',
            'id'=> 1,
            'body'  => ['first_name' => 'Pratik', 'last_name' => 'Suthar','user_gender' => 'M', 'fullname' => 'Pratik Suthar', 'user_slug' => 'pratik-suthar', 'user_image' => 'pratik-suthar', 'title_name' => 'pratik-suthar', 'degree_name' => 'pratik-suthar', 'profession_field' => 'pratik-suthar', 'student_field' => 'pratik-suthar', 'profession_city' => 'pratik-suthar', 'student_city' => 'pratik-suthar', 'university_name' => 'pratik-suthar',],
        ];
        $response = $client->index($params);
        print_r($response);
    }
}