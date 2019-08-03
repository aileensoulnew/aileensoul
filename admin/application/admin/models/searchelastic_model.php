<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require '../es/vendor/autoload.php';

class Searchelastic_model extends CI_Model {
    private $elasticclient = null;
    function __construct()
    {
        parent::__construct();
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

    public function add_edit_single_article($id_post)
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
        $responses = $client->index($params);
        // print_r($responses);exit();
        return $responses;
    }

    public function delete_people_data($id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_people', 
            'type'  => 'aileensoul_search_people',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "_id" => $id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];        
        $people_count = $search_data['total'];
        if($people_count > 0)
        {
            $params = [
                        'index' => 'aileensoul_search_people', 
                        'type' => 'aileensoul_search_people', 
                        'id' => $id
                    ];
            $responses = $client->delete($params);        
        }

        return true;
    }

    public function delete_business_data($user_id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_business', 
            'type'  => 'aileensoul_search_business',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "user_id" => $user_id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $bus_count = $search_data['total'];
        if($bus_count > 0)
        {
            $bus_data = $search_data['hits'];            
            foreach ($bus_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_business', 'type' => 'aileensoul_search_business', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }

        }
        return true;
    }

    public function delete_post_data($user_id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_post', 
            'type'  => 'aileensoul_search_post',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "user_id" => $user_id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);        
        $search_data = $query['hits'];
        $post_count = $search_data['total'];
        if($post_count > 0){
            $post_data = $search_data['hits'];            
            foreach ($post_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }
        return true;
    }

    public function delete_opportunity_data($user_id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "user_id" => $user_id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $opp_count = $search_data['total'];
        if($opp_count > 0)
        {
            $opp_data = $search_data['hits'];            
            foreach ($opp_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }

        return true;
    }    

    public function delete_question_data($user_id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_question', 
            'type'  => 'aileensoul_search_question',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "user_id" => $user_id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $que_count = $search_data['total'];
        if($que_count > 0)
        {
            $opp_data = $search_data['hits'];            
            foreach ($opp_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }
        return true;
    }

    public function delete_article_data($user_id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_article', 
            'type'  => 'aileensoul_search_article',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "user_id" => $user_id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $art_count = $search_data['total'];
        if($art_count > 0)
        {
            $opp_data = $search_data['hits'];            
            foreach ($opp_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_article', 'type' => 'aileensoul_search_article', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }

        return true;
    }

    public function delete_article_id_data($id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_article', 
            'type'  => 'aileensoul_search_article',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "_id" => $id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];        
        $people_count = $search_data['total'];
        if($people_count > 0)
        {
            $params = [
                        'index' => 'aileensoul_search_article', 
                        'type' => 'aileensoul_search_article', 
                        'id' => $id
                    ];
            $responses = $client->delete($params);        
        }

        return true;
    }

    public function delete_post_from_id_data($id = 0)
    {
        
        $client = $this->elasticclient;
        $params_search = [
            'index' => 'aileensoul_search_post', 
            'type'  => 'aileensoul_search_post',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "_id" => $id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);        
        $search_data = $query['hits'];
        $post_count = $search_data['total'];
        if($post_count > 0){
            $post_data = $search_data['hits'];            
            foreach ($post_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }
        return true;
    }

    public function delete_opportunity_from_id_data($id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_opportunity', 
            'type'  => 'aileensoul_search_opportunity',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "_id" => $id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $opp_count = $search_data['total'];
        if($opp_count > 0)
        {
            $opp_data = $search_data['hits'];            
            foreach ($opp_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }

        return true;
    }    

    public function delete_question_from_id_data($id = 0)
    {
        
        $client = $this->elasticclient;

        $params_search = [
            'index' => 'aileensoul_search_question', 
            'type'  => 'aileensoul_search_question',
            'body'  => [
                            "query" =>
                            [
                                "match_phrase" => [
                                    "_id" => $id
                                ]
                            ]//query end
                        ],//body end
        ];
        $query = $client->search($params_search);
        $searchData = array();
        $search_data = $query['hits'];
        $que_count = $search_data['total'];
        if($que_count > 0)
        {
            $opp_data = $search_data['hits'];            
            foreach ($opp_data as $key => $value) {                
                $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $value['_id'], ];
                $responses = $client->delete($params);
            }
        }
        return true;
    }

    public function add_edit_single_opportunity_data($id)
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
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id='".$id."'
            GROUP BY up.id,uo.opportunity_for, uo.location,uo.hashtag ORDER BY id DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row)
        {
            $params = ['index' => 'aileensoul_search_opportunity', 'type' => 'aileensoul_search_opportunity', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'opportunity_for' => $row['opportunity_for'], 'opportunity_for_id' => $row['opportunity_for_id'], 'location' => $row['location'], 'location_id' => $row['location_id'], 'opportunity' => $row['opportunity'], 'field' => $row['field'], 'other_field' => $row['other_field'], 'opptitle' => $row['opptitle'], 'oppslug' => $row['oppslug'], 'company_name' => $row['company_name'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'],]];
            $responses = $client->index($params);
        }
        return true;
    }

    public function add_edit_single_post_data($id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,usp.description,IF(usp.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag, usp.hashtag AS hashtag_id,usp.sim_title, usp.simslug
            FROM ailee_user_simple_post usp
            LEFT JOIN ailee_user_post up ON up.id = usp.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, usp.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id='".$id."' GROUP BY up.id,usp.hashtag ORDER BY id DESC";
        $query = $this->db->query($stmt);
        $result = $query->result_array();
        $params = null;
        foreach($result as $k=>$row) {
            print_r($row);
            $params = ['index' => 'aileensoul_search_post', 'type' => 'aileensoul_search_post', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'], 'user_type' => $row['user_type'], 'description' => $row['description'], 'hashtag' => $row['hashtag'],'hashtag_id' => $row['hashtag_id'], 'sim_title' => $row['sim_title'], 'simslug' => $row['simslug'],]];
            $responses = $client->index($params);
        }
        return true;
    }

    public function add_edit_single_question_data($id)
    {
        $client = $this->elasticclient;
        $stmt = "SELECT up.id,up.user_id,up.post_for,up.created_date,up.post_id,up.user_type,IF(uaq.category != '', GROUP_CONCAT(DISTINCT(t.name)) , '') as category, uaq.description, it.industry_name AS field, uaq.others_field, uaq.is_anonymously ,uaq.link, uaq.modify_date, uaq.question,IF(uaq.hashtag IS NULL,'',CONCAT('#',GROUP_CONCAT(DISTINCT(ht.hashtag) SEPARATOR ' #'))) AS hashtag,uaq.hashtag AS hashtag_id
            FROM ailee_user_ask_question uaq
            LEFT JOIN ailee_user_post up ON up.id = uaq.post_id
            LEFT JOIN ailee_user_login ul ON ul.user_id = up.user_id
            LEFT JOIN ailee_industry_type it ON it.industry_id = uaq.field
            LEFT OUTER JOIN ailee_tags t ON FIND_IN_SET(t.id, uaq.category) > 0            
            LEFT OUTER JOIN ailee_hashtag ht ON FIND_IN_SET(ht.id, uaq.hashtag) > 0
            WHERE ul.status = '1' AND ul.is_delete = '0' AND up.status = 'publish' AND up.is_delete = '0' AND up.id='".$id."'
            GROUP BY up.id,uaq.category,uaq.hashtag ORDER BY id DESC";
        $query = $this->db->query($stmt);
        $result = $query->result_array();        
        $params = null;
        foreach($result as $k=>$row) {
            $params = ['index' => 'aileensoul_search_question', 'type' => 'aileensoul_search_question', 'id' => $row['id'], 'body' => ['user_id' => $row['user_id'],'post_for' => $row['post_for'],'created_date' => $row['created_date'],'post_id' => $row['post_id'],'user_type' => $row['user_type'],'category' => $row['category'],'description' => $row['description'],'field' => $row['field'],'hashtag' => $row['hashtag'],'is_anonymously' => $row['is_anonymously'],'link' => $row['link'],'modify_date' => $row['modify_date'],'others_field' => $row['others_field'],'question' => $row['question'],]];
            $responses = $client->index($params);
        }
        return true;
    }
}